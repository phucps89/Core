<?php

namespace PhucTran\Core\Services\S3;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Facade;
use PhucTran\Core\Services\S3\Src\S3Service;

/**
 * Created by PhpStorm.
 * Account: phuctran
 * Date: 19/01/2017
 * Time: 15:20
 */

/**
 * Class S3Facade
 *
 * @method static false|string upload(string $pathOnS3, string $pathFile, string $visibility = null)
 * @method static false|string uploadFile(string $pathOnS3, File $srcFile, string $visibility = null)
 * @method static void download(string $pathOnS3, string $pathOnLocal)
 * @method static string getContent(string $pathOnS3)
 * @method static bool exists(string $pathOnS3)
 * @method static string getUrl(string $pathOnS3)
 * @method static string getPreSignedUrl(string $pathOnS3, int $expTime = 30)
 * @method static FilesystemAdapter getStorage()
 *
 * @package App\Services\S3
 */
class S3Facade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return S3Service::class;
    }
}