<?php

namespace App;

/**
 * Class CustomValidator
 */
class CustomValidator extends \Illuminate\Validation\Validator
{
    /**
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateHasMultiByte($attribute, $value, $parameters)
    {
        $len = mb_strlen($value, 'UTF-8');
        $wdt = mb_strwidth($value, 'UTF-8');

        if (20 < ($wdt - $len)) {
            return true;
        }

        return false;
    }
}