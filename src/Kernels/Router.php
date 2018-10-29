<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/29/2018
 * Time: 10:12 AM
 */

namespace Sel2b\Core\Kernels;


class Router extends \Laravel\Lumen\Routing\Router
{
    public function extends($action)
    {
        $this->addRoute('EXTENDS', null, $action);

        return $this;
    }
}