<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 3/18/2018
 * Time: 6:15 PM
 */

namespace PhucTran\Core\Services\Validator;


use PhucTran\Core\Services\Validator\Src\ValidationRuleInterface;
use PhucTran\Core\Services\Validator\Src\ValidationService;
use Illuminate\Support\Facades\Facade;

/**
 * Class ResponseFacade
 *
 * @method static mixed validate(array|object $data, ValidationRuleInterface|string $rule)
 *
 * @package App\Services\Validator
 */
class ValidationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ValidationService::class;
    }
}