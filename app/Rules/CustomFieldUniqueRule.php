<?php
/**
 * LaraClassified - Classified Ads Web Application
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

namespace App\Rules;

use App\Models\CategoryField;
use Illuminate\Contracts\Validation\Rule;

class CustomFieldUniqueRule implements Rule
{
	public $parameters = [];
	public $attribute;
	
	public function __construct($parameters)
	{
		$this->parameters = $parameters;
	}
	
	/**
	 * Determine if the validation rule passes.
	 * Prevent duplicate content (Category & Custom Field) in 'category_field' table
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		if (!isset($this->parameters[0]) || !isset($this->parameters[1])) {
			return false;
		}
		
		$this->attribute = $attribute;
		
		$countCategories = CategoryField::where($this->parameters[0], $this->parameters[1])->where($attribute, $value)->count();
		if ($countCategories > 0) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		if ($this->attribute == 'category_id') {
			$message = trans('validation.custom_field_unique_rule', [
				'field_1' => trans('admin::messages.category'),
				'field_2' => trans('admin::messages.custom field'),
			]);
		} else {
			$message = trans('validation.custom_field_unique_rule_field', [
				'field_1' => trans('admin::messages.custom field'),
				'field_2' => trans('admin::messages.category'),
			]);
		}
		
		return $message;
	}
}
