<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 3/18/2018
 * Time: 6:11 PM
 */

namespace PhucTran\Core\Services\Validator\Src;


interface ValidationRuleInterface
{
    /**
     * Object descriptor to be used in validation exception messages, or empty array
     *
     * @return array|string
     */
    public static function descriptor();
    /**
     * Array of Validation rules, or empty array
     *
     * @return array
     */
    public static function rules();
    /**
     * Array of Validation message overrides, or empty array
     *
     * @return array
     */
    public static function messages();
}