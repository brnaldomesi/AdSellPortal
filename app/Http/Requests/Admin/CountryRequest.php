<?php
/**
 * LaraClassified - Geo Classified Ads CMS
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

namespace App\Http\Requests\Admin;

class CountryRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'code'           => 'required|min:2|max:2',
			'name'           => 'required|min:2|max:255',
			'asciiname'      => 'required',
			'continent_code' => 'required',
			'currency_code'  => 'required',
			'phone'          => 'required',
			'languages'      => 'required',
		];
		
		if ($this->filled('currencies')) {
			$rules['currencies'] = 'check_currencies';
		}
		
		return $rules;
	}
	
	/**
	 * Extend the default getValidatorInstance method
	 * so fields can be modified or added before validation
	 *
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function getValidatorInstance()
	{
		if (isset($this->currencies)) {
			// Add new data field before it gets sent to the validator
			$currenciesCodes = collect(explode(',', $this->currencies))->map(function ($value, $key) {
				return trim($value);
			})->filter(function ($value, $key) {
				return !empty($value);
			})->toArray();
			
			$input = [];
			$input['currencies'] = @implode(',', $currenciesCodes);
			
			request()->merge($input); // Required!
			$this->merge($input);
		}
		
		// Fire the parent getValidatorInstance method
		return parent::getValidatorInstance();
	}
}
