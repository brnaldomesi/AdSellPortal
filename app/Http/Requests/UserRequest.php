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


class UserRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return auth()->check();
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		// Check if these fields has changed
		$emailChanged = ($this->input('email') != auth()->user()->email);
		$phoneChanged = ($this->input('phone') != auth()->user()->phone);
		$usernameChanged = ($this->filled('username') && $this->input('username') != auth()->user()->username);
		
		// Validation Rules
		$rules = [
			'gender_id'    => 'required|not_in:0',
			'name'         => 'required|max:100',
			'phone'        => 'required|max:20',
			'email'        => 'required|email|whitelist_email|whitelist_domain',
			'username'     => 'valid_username|allowed_username|between:3,100',
		];
		
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
		if ($phoneChanged) {
			$rules['phone'] = 'unique:users,phone|' . $rules['phone'];
		}
		
		// Email
		if ($emailChanged) {
			$rules['email'] = 'unique:users,email|' . $rules['email'];
		}
		
		// Username
		if ($usernameChanged) {
			$rules['username'] = 'required|unique:users,username|' . $rules['username'];
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
