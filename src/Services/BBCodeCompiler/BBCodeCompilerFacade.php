<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 10:02 PM
 */

namespace PhucTran\Core\Services\BBCodeCompiler;


use PhucTran\Core\Services\BBCodeCompiler\Src\BBCodeCompilerService;
use Illuminate\Support\Facades\Facade;

/**
 * Class BBCodeCompilerFacade
 *
 * @method static string compile(string $content)
 *
 * @package App\Services\BBCodeCompiler
 */
class BBCodeCompilerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BBCodeCompilerService::class;
    }
}