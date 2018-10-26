<?php

namespace Sel2b\Core\Services\Currency;

use Sel2b\Core\Services\Currency\Src\CurrencyService;
use Illuminate\Support\Facades\Facade;

/**
 * Created by PhpStorm.
 * Account: Phuc
 * Date: 2/14/2017
 * Time: 11:11 AM
 */

/**
 * Class CurrencyFacade
 *
 * @method static string formatUSD(float $value)
 *
 * @package Sel2b\Core\Services\Currency
 */
class CurrencyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CurrencyService::class;
    }
}