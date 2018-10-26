<?php

namespace Sel2b\Core\Controllers;
use Laravel\Lumen\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Sel2b\Core\Libraries\Helpers;
use Sel2b\Core\Services\Response\ResponseFacade;

abstract class Sel2bCoreController extends Controller
{
    /**
     * @param array|object|string|\Exception $data
     * @param int $code
     * @param null $message
     * @return mixed
     */
    public function response($data, $code = Response::HTTP_OK, $message = null)
    {
        return ResponseFacade::send($data, $code, $message);
    }

    /**
     * @param \Exception $exception
     * @return string
     */
    public function getExceptionMessage($exception)
    {
        return $exception->getMessage().' in '.$exception->getFile().' at '.$exception->getLine();
    }

    /**
     * @return Client
     */
    public function createRestful(){
        return Helpers::createRestFul();
    }

    /**
     * @param string $method
     * @param string $url
     * @return \GuzzleHttp\Psr7\Request
     */
    public function createRestfulRequest($method, $url){
        return Helpers::createRestfulRequest($method, $url);
    }
}