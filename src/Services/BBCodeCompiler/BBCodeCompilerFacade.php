<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 10:02 PM
 */

namespace Sel2b\Core\Services\BBCodeCompiler;


use Sel2b\Core\Services\BBCodeCompiler\Src\BBCodeCompilerService;
use Illuminate\Support\Facades\Facade;

/**
 * Class BBCodeCompilerFacade
 *
 * @method static string compile(string $content)
 *
 * @package Sel2b\Core\Services\BBCodeCompiler
 */
class BBCodeCompilerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BBCodeCompilerService::class;
    }
}