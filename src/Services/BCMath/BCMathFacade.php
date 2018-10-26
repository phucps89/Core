<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/19/2018
 * Time: 3:44 PM
 */

namespace Sel2b\Core\Services\BCMath;


use Sel2b\Core\Services\BCMath\Src\BCMathService;
use Illuminate\Support\Facades\Facade;

/**
 * Class BCMathFacade
 *
 * @method static BCMathService init()
 * @method static void setScale($scale = null)
 * @method static string round($number, $precision = 0)
 * @method static string pow($leftOperand, $rightOperand, $scale = null)
 * @method static string powFractional($leftOperand, $rightOperand, $scale = null)
 * @method static string mul($leftOperand, $rightOperand, $scale = null)
 * @method static string exp($arg)
 * @method static string add($leftOperand, $rightOperand, $scale = null)
 * @method static string div($leftOperand, $rightOperand, $scale = null)
 * @method static string log($arg)
 * @method static string comp($leftOperand, $rightOperand, $scale = null)
 * @method static string sub($leftOperand, $rightOperand, $scale = null)
 * @method static string abs($number)
 * @method static string rand($min, $max)
 * @method static string roundDown($number, $precision = 0)
 * @method static string floor($number)
 * @method static string roundUp($number, $precision = 0)
 * @method static string ceil($number)
 * @method static int getScale()
 * @method static string sqrt($operand, $scale = null)
 * @method static string mod($leftOperand, $modulus, $scale = null)
 * @method static string powMod($leftOperand, $rightOperand, $modulus, $scale = null)
 * @method static string fact($arg)
 *
 * @package Sel2b\Core\Services\BCMath
 */
class BCMathFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BCMathService::class;
    }
}