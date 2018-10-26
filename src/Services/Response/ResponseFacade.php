<?php

namespace Sel2b\Core\Services\Response;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Facade;
use Sel2b\Core\Services\Response\Src\ResponseService;

/**
 * Created by PhpStorm.
 * Account: phuctran
 * Date: 20/01/2017
 * Time: 13:14
 */

/**
 * Class ResponseFacade
 *
 * @method static mixed send(string|array|object $data = null, int $statusCode = Response::HTTP_OK, string $message)
 * @method static mixed download(string $path, string $fileName = null, $headers = [])
 * @method static displayFromS3(string $pathOnS3)
 * @method static display(string $path)
 *
 * @package Sel2b\Core\Services\Response
 */
class ResponseFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ResponseService::class;
    }
}