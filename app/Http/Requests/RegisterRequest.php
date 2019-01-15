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

namespace App\Http\Requests;

class RegisterRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'name'         => 'required|mb_between:2,200',
			'country_code' => 'sometimes|required|not_in:0',
			'phone'        => 'max:20',
			'email'        => 'max:100|whitelist_email|whitelist_domain',
			'password'     => 'required|between:6,60|dumbpwd|confirmed',
			'term'         => 'accepted',
		];
		
		// Email
		if ($this->filled('email')) {
			$rules['email'] = 'email|unique:users,email|' . $rules['email'];
		}
		if (isEnabledField('email')) {
			if (isEnabledField('phone') and isEnabledField('email')) {
				$rules['email'] = 'required_without:phone|' . $rules['email'];
			} else {
				$rules['email'] = 'required|' . $rules['email'];
			}
		}
		
		// Phone
		if (config('settings.sms.phone_verification') == 1) {
			if ($this->filled('phone')) {
				$countryCode = $this->input('country_code', config('country.code'));
				if ($countryCode == 'UK') {
					$countryCode = 'GB';
				}
				$rules['phone'] = 'phone:' . $countryCode . '|' . $rules['phone'];
			}
		}
		if (isEnabledField('phone')) {
			if (isEnabledField('phone') and isEnabledField('email')) {
				$rules['phone'] = 'required_without:email|' . $rules['phone'];
			} else {
				$rules['phone'] = 'required|' . $rules['phone'];
			}
		}
		if ($this->filled('phone')) {
			$rules['phone'] = 'unique:users,phone|' . $rules['phone'];
		}
		
		// Username
		if (isEnabledField('username')) {
			$rules['username'] = ($this->filled('username')) ? 'valid_username|allowed_username|between:3,100|unique:users,username' : '';
		}
		
		// Recaptcha
		if (config('settings.security.recaptcha_activation')) {
			$rules['g-recaptcha-response'] = 'required';
		}
		
		return $rules;
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		$messages = [];
		
		return $messages;
	}
}
