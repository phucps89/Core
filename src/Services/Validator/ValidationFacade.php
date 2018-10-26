<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 3/18/2018
 * Time: 6:15 PM
 */

namespace Sel2b\Core\Services\Validator;


use Sel2b\Core\Services\Validator\Src\ValidationRuleInterface;
use Sel2b\Core\Services\Validator\Src\ValidationService;
use Illuminate\Support\Facades\Facade;

/**
 * Class ResponseFacade
 *
 * @method static void validate(array|object $data, ValidationRuleInterface|string $rule)
 *
 * @package Sel2b\Core\Services\Validator
 */
class ValidationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ValidationService::class;
    }
}