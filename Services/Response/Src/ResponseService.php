<?php
/**
 * Created by PhpStorm.
 * Account: phuctran
 * Date: 20/01/2017
 * Time: 13:15
 */

namespace PhucTran\Core\Services\Response\Src;


use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use PhucTran\Core\Services\S3\S3Facade;

class ResponseService
{
    protected function getClassStatusCode($code)
    {
        $classCode = (int)($code / 100);
        $classArray = [
            'informational',
            'success',
            'redirection',
            'client_error',
            'server_error'
        ];
        return $classArray[$classCode - 1];
    }

    /**
     * @param null $result
     * @param int $statusCode
     *
     * @return mixed
     */
    public function send($data, $code = Response::HTTP_OK, $message = null)
    {
        $response = [
            'status'  => false,
            'message' => null,
            'data'    => []
        ];

        if ($code == Response::HTTP_OK) {
            $response['status'] = true;
        }

        if ($code == Response::HTTP_OK) {
            if (is_string($data)) {
                $response['message'] = $data;
            }
            else {
                $response['data'] = $data;
                $response['message'] = $message;
            }
        }
        else {
            if ($data instanceof \Exception){
                $response['message'] = $data->getMessage();
            }
            else if (is_string($data)) {
                $response['message'] = $data;
            }
            else {
                $response['data'] = $data;
                $response['message'] = $message;
            }
        }
        return response()->json($response, $code);
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function download(string $path)
    {
        return response()->download(Storage::get($path))->deleteFileAfterSend(true);
    }

    /**
     * @param string $pathOnS3
     */
    public function displayFromS3(string $pathOnS3)
    {
        $url = S3Facade::getPreSignedUrl($pathOnS3);
        header('Content-type: ' . $this->mimeType($pathOnS3));
        readfile($url);
    }

    private function mimeType($path)
    {
        preg_match("|\.([a-z0-9]{2,4})$|i", $path, $fileSuffix);

        switch (strtolower($fileSuffix[1])) {
            case 'js' :
                return 'application/x-javascript';
            case 'json' :
                return 'application/json';
            case 'jpg' :
            case 'jpeg' :
            case 'jpe' :
                return 'image/jpg';
            case 'png' :
            case 'gif' :
            case 'bmp' :
            case 'tiff' :
                return 'image/' . strtolower($fileSuffix[1]);
            case 'css' :
                return 'text/css';
            case 'xml' :
                return 'application/xml';
            case 'doc' :
            case 'docx' :
                return 'application/msword';
            case 'xls' :
            case 'xlt' :
            case 'xlm' :
            case 'xld' :
            case 'xla' :
            case 'xlc' :
            case 'xlw' :
            case 'xll' :
                return 'application/vnd.ms-excel';
            case 'ppt' :
            case 'pps' :
                return 'application/vnd.ms-powerpoint';
            case 'rtf' :
                return 'application/rtf';
            case 'pdf' :
                return 'application/pdf';
            case 'html' :
            case 'htm' :
            case 'php' :
                return 'text/html';
            case 'txt' :
                return 'text/plain';
            case 'mpeg' :
            case 'mpg' :
            case 'mpe' :
                return 'video/mpeg';
            case 'mp3' :
                return 'audio/mpeg3';
            case 'wav' :
                return 'audio/wav';
            case 'aiff' :
            case 'aif' :
                return 'audio/aiff';
            case 'avi' :
                return 'video/msvideo';
            case 'wmv' :
                return 'video/x-ms-wmv';
            case 'mov' :
                return 'video/quicktime';
            case 'zip' :
                return 'application/zip';
            case 'tar' :
                return 'application/x-tar';
            case 'swf' :
                return 'application/x-shockwave-flash';
            default :
                if (function_exists('mime_content_type')) {
                    $fileSuffix = mime_content_type($path);
                }
                return 'unknown/' . trim($fileSuffix[0], '.');
        }
    }
}