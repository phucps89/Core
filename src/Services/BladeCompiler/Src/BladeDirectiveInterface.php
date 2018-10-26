<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 7:46 PM
 */

namespace Sel2b\Core\Services\BladeCompiler\Src;


interface BladeDirectiveInterface
{
    /**
     * @param string $expression
     * @param string|object|array $params
     * @return mixed
     */
    public function transform($expression, $params);
}