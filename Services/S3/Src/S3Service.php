<?php

namespace PhucTran\Core\Services\S3\Src;

use Aws\S3\S3Client;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

/**
 * Created by PhpStorm.
 * Account: phuctran
 * Date: 19/01/2017
 * Time: 15:42
 */
class S3Service
{
    protected $_env_prefix;
    protected $_disk = 's3';
    protected $_storage;
    protected $_s3Client;
    protected $_s3Bucket;

    public function __construct()
    {
        $this->_env_prefix = env('S3_PREFIX_ENV', 'develop');
        $this->_storage = $this->getStorageAdapter();

        $s3Client = new S3Client([
            'region'  => env('S3_REGION'),
            'version' => 'latest',
            'credentials' => array(
                'key' => env('S3_KEY'),
                'secret'  => env('S3_SECRET')
            )
        ]);
        $this->_s3Client = $s3Client;
        $this->_s3Bucket = env('S3_BUCKET');
    }

    protected function getStorageAdapter() : FilesystemAdapter {
        return Storage::disk($this->_disk);
    }

    protected function normalizePathS3(string $pathOnS3) : string {
        return $this->_env_prefix . '/' . $pathOnS3;
    }

    protected function cancelNormalizePathS3(string $pathOnS3Real) : string {
        $pathOnS3RealArray = explode('/', $pathOnS3Real);
        array_shift($pathOnS3RealArray);
        return implode('/', $pathOnS3RealArray);
    }

    /**
     * @param string $pathOnS3
     * @param string $pathFile
     * @param string|null $visibility
     *
     * @return false|string
     */
    public function upload(string $pathOnS3, string $pathFile, string $visibility = null) {
        return $this->uploadFile($pathOnS3, new File($pathFile), $visibility);
    }

    /**
     * @param string $pathOnS3
     * @param $srcFile
     * @param string|null $visibility
     *
     * @return false|string
     */
    public function uploadFile(string $pathOnS3, $srcFile, string $visibility = null) {
        $upPath = $this->normalizePathS3($pathOnS3);
        $path = $this->_storage->putFile($upPath, $srcFile, $visibility);
        if($path !== false)
            return $this->cancelNormalizePathS3($path);
        else return false;
    }

    public function download(string $pathOnS3, string $pathOnLocal){
        $content = $this->getContent($pathOnS3);
        Storage::put($pathOnLocal, $content);
    }

    /**
     * @param string $pathOnS3
     *
     * @return string
     */
    public function getContent(string $pathOnS3){
        $pathOnS3Real = $this->normalizePathS3($pathOnS3);
        $content = $this->_storage->get($pathOnS3Real);
        return $content;
    }

    /**
     * @param string $pathOnS3
     *
     * @return bool
     */
    public function exists(string $pathOnS3){
        $pathOnS3Real = $this->normalizePathS3($pathOnS3);
        return $this->_storage->exists($pathOnS3Real);
    }

    /**
     * @param string $pathOnS3
     *
     * @return string
     */
    public function getUrl(string $pathOnS3) : string {
        $pathOnS3Real = $this->normalizePathS3($pathOnS3);
        return $this->_storage->url($pathOnS3Real);
    }

    /**
     * @param string $pathOnS3
     * @param int    $expTime
     *
     * @return string
     */
    public function getPreSignedUrl(string $pathOnS3, int $expTime = 30) : string {
        $pathOnS3Real = $this->normalizePathS3($pathOnS3);
        $cmd = $this->_s3Client->getCommand('GetObject', [
            'Bucket' => $this->_s3Bucket,
            'Key'    => $pathOnS3Real
        ]);

        $request = $this->_s3Client->createPresignedRequest($cmd, "+{$expTime} minutes");
        return (string) $request->getUri();
    }

    /**
     * @return FilesystemAdapter
     */
    public function getStorage(){
        return $this->_storage;
    }
}