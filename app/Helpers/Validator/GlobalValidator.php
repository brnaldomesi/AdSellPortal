<?php
/**
 * LaraClassified - Geo Classified Ads Software
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Helpers\Validator;

class GlobalValidator
{
    /**
	 * Example: 'name' => 'mb_between:2,200|...'
	 *
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @param $validator
	 * @return bool
	 */
    public static function mbBetween($attribute, $value, $parameters, $validator)
    {
        $min = (isset($parameters[0])) ? (int)$parameters[0] : 0;
        $max = (isset($parameters[1])) ? (int)$parameters[1] : 999999;
        
        $value = strip_tags($value);
        
        if (mb_strlen($value) < $min) {
            return false;
        } else {
            if (mb_strlen($value) > $max) {
                return false;
            }
        }

        return true;
    }
}
