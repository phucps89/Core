<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 7:24 PM
 */

namespace Sel2b\Core\Services\BladeCompiler;


use Sel2b\Core\Services\BladeCompiler\Src\BladeCompilerService;
use Illuminate\Support\Facades\Facade;

/**
 * Class BladeCompilerFacade
 *
 * @method static void compileString(string $templateContent, string|object|array $params = null)
 * @method static void compileFile(string $templateFile, string|object|array $params = null)
 *
 * @package Sel2b\Core\Services\BladeCompiler
 */
class BladeCompilerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BladeCompilerService::class;
    }
}