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


use App\Models\Currency;

class LocaleValidator
{
	public function __construct()
	{
		//...
	}
	
	/**
	 * Check the Locale related to the Language Code
	 *
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @param $validator
	 * @return bool
	 */
	public static function languageCheckLocale($attribute, $value, $parameters, $validator)
	{
		$langCode = ($parameters[0]) ? $parameters[0] : null;
		$locales = (array)config('locales');
		
		$filtered = collect($locales)->filter(function ($item, $key) use ($langCode) {
			return starts_with($key, $langCode);
		});
		
		if ($filtered->isNotEmpty()) {
			return starts_with($value, $langCode);
		}
		
		return isset($locales[$value]);
	}
	
	/**
	 * Check the Locale related to the Country Code
	 *
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @param $validator
	 * @return bool
	 */
	public static function countryCheckLocale($attribute, $value, $parameters, $validator)
	{
		$countryCode = ($parameters[0]) ? $parameters[0] : null;
		$locales = (array)config('locales');
		
		$filtered = collect($locales)->filter(function ($item, $key) use ($countryCode) {
			return ends_with($key, '_' . $countryCode);
		});
		
		if ($filtered->isNotEmpty()) {
			return ends_with($value, '_' . $countryCode);
		}
		
		return isset($locales[$value]);
	}
	
	/**
	 * Check if each the Currency Code in the list is valid
	 *
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @param $validator
	 * @return bool
	 */
	public static function checkCurrencies($attribute, $value, $parameters, $validator)
	{
		$valid = true;
		
		$currenciesCodes = explode(',', $value);
		if (!empty($currenciesCodes)) {
			foreach($currenciesCodes as $code) {
				if (Currency::where('code', $code)->count() <= 0) {
					$valid = false;
					break;
				}
			}
		}
		
		return $valid;
	}
}
