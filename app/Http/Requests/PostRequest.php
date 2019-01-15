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


class PostRequest extends Request
{
	protected $cfMessages = [];
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'category_id'  => 'required|not_in:0',
			'post_type_id' => 'required|not_in:0',
			'title'        => 'required|mb_between:2,150|whitelist_word_title',
			'description'  => 'required|mb_between:5,6000|whitelist_word',
			'contact_name' => 'required|mb_between:2,200',
			'email'        => 'max:100|whitelist_email|whitelist_domain',
			'phone'        => 'max:20',
			'city_id'      => 'required|not_in:0',
		];
		
		// CREATE
		if (in_array($this->method(), ['POST', 'CREATE'])) {
			$rules['parent_id'] = 'required|not_in:0';
			
			// Recaptcha
			if (config('settings.security.recaptcha_activation')) {
				$rules['g-recaptcha-response'] = 'required';
			}
		}
		
		// UPDATE
		// if (in_array($this->method(), ['PUT', 'PATCH', 'UPDATE'])) {}
		
		// COMMON
		
		// Location
		if (in_array(config('country.admin_type'), ['1', '2']) && config('country.admin_field_active') == 1) {
			$rules['admin_code'] = 'required|not_in:0';
		}
		
		// Email
		if ($this->filled('email')) {
			$rules['email'] = 'email|' . $rules['email'];
		}
		if (isEnabledField('email')) {
			if (isEnabledField('phone') && isEnabledField('email')) {
				if (auth()->check()) {
					$rules['email'] = 'required_without:phone|' . $rules['email'];
				} else {
					// Email address is required for Guests
					$rules['email'] = 'required|' . $rules['email'];
				}
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
			if (isEnabledField('phone') && isEnabledField('email')) {
				$rules['phone'] = 'required_without:email|' . $rules['phone'];
			} else {
				$rules['phone'] = 'required|' . $rules['phone'];
			}
		}
		
		// Custom Fields
		if (!isFromApi()) {
			$cfRequest = new CustomFieldRequest();
			$rules = $rules + $cfRequest->rules();
			$this->cfMessages = $cfRequest->messages();
		}
		
		/*
		 * Tags (Only allow letters, numbers, spaces and ',;_-' symbols)
		 *
		 * Explanation:
		 * [] 	=> character class definition
		 * p{L} => matches any kind of letter character from any language
		 * p{N} => matches any kind of numeric character
		 * _- 	=> matches underscore and hyphen
		 * + 	=> Quantifier — Matches between one to unlimited times (greedy)
		 * /u 	=> Unicode modifier. Pattern strings are treated as UTF-16. Also causes escape sequences to match unicode characters
		 */
		if ($this->filled('tags')) {
			$rules['tags'] = 'regex:/^[\p{L}\p{N} ,;_-]+$/u';
		}
		
		return $rules;
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		$messages = [];
		
		// Custom Fields
		if (!isFromApi()) {
			$messages = $messages + $this->cfMessages;
		}
		
		return $messages;
	}
}
