<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 7:24 PM
 */

namespace PhucTran\Core\Services\BladeCompiler;


use PhucTran\Core\Services\BladeCompiler\Src\BladeCompilerService;
use Illuminate\Support\Facades\Facade;

/**
 * Class BladeCompilerFacade
 *
 * @method static void compileString(string $templateContent, string|object|array $params = null)
 * @method static void compileFile(string $templateFile, string|object|array $params = null)
 *
 * @package App\Services\BladeCompiler
 */
class BladeCompilerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BladeCompilerService::class;
    }
}