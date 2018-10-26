<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 3/18/2018
 * Time: 6:09 PM
 */

namespace Sel2b\Core\Services\Validator\Src;


use Illuminate\Validation\ValidationException;

class ValidationService
{
    private $validator;
    public function __construct()
    {
        // TODO: may want to explore instantiation of validation factory or extension of validator here instead
        $this->validator = app('validator');
    }
    /**
     * Validate an object or array against a ValidationRuleInterface class
     *
     * NOTE:
     * This will not work recursively as, ultimately, the Illuminate Validator does not work recursively either.
     *
     * @param $input
     * @param $rules
     * @param array $messages
     * @param array $customAttributes
     * @throws ValidationException
     * @internal param $model
     * @internal param $validationClass
     */
    public function validate($input, $rules, array $messages = [], array $customAttributes = [])
    {
        // See if we should be validating against a ValidationRuleInterface
        if (is_subclass_of($rules, ValidationRuleInterface::class)) {
            // Create ArrayObject from $input & get data as array
            if(is_object($input)) {
                $data = json_decode(json_encode($input), true);
            }
            else{
                $data = $input;
            }
            // See if descriptor is provided
            if (is_string($rules::descriptor())) {
                // Get default validation messages & apply overrides from $rules::class
                $messages = array_replace_recursive(
                    app('translator')->trans('validation'),
                    $rules::messages()
                );
                // Replace message text with descriptor
                array_walk_recursive($messages, function (&$message) use ($rules) {
                    $message = $rules::descriptor() . ' / ' . $message;
                });
            } else {
                // Simply grab message overrides form $rules::class
                // TODO: there's probably a simpler/better way to do this
                $messages = $rules::messages();
            }
            // Validate object data
            $validator = $this->make($data, $rules::rules(), $messages, $customAttributes);
        } else {
            // Validate array data (this is the "default" functionality)
            $validator = $this->make($input, $rules, $messages, $customAttributes);
        }
        // Check for validation failure
        if ($validator->fails()) {
            // Throw validation exception
            throw new ValidationException($validator, $validator->errors());
        }
    }
    private function make($input, $rules, array $messages = [], array $customAttributes = []) {
        return $this->validator->make($input, $rules, $messages, $customAttributes);
    }
}