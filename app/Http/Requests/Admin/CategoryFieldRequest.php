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

namespace App\Http\Requests\Admin;

use App\Rules\CustomFieldUniqueRule;
use App\Rules\CustomFieldUniqueChildrenRule;
use App\Rules\CustomFieldUniqueParentRule;

class CategoryFieldRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
	
		if ($this->segment(2) == 'categories') {
			$rules['field_id'] = [
				'required',
				'not_in:0',
				new CustomFieldUniqueRule(['category_id', $this->category_id]),
				new CustomFieldUniqueParentRule(['category_id', $this->category_id]),
				new CustomFieldUniqueChildrenRule(['category_id', $this->category_id]),
			];
		}
	
		if ($this->segment(2) == 'custom_fields') {
			$rules['category_id'] = [
				'required',
				'not_in:0',
				new CustomFieldUniqueRule(['field_id', $this->field_id]),
				new CustomFieldUniqueParentRule(['field_id', $this->field_id]),
				new CustomFieldUniqueChildrenRule(['field_id', $this->field_id]),
			];
		}
        
        return $rules;
    }
    
    /**
     * @return array
     */
    public function messages()
    {
        $messages = [
            'category_id.required' => trans('admin::messages.The :field is required.', ['field' => trans('admin::messages.category')]),
            'category_id.not_in'   => trans('admin::messages.The :field is required. And cannot be 0.', ['field' => trans('admin::messages.category')]),
            'field_id.required'    => trans('admin::messages.The :field is required.', ['field' => trans('admin::messages.custom field')]),
            'field_id.not_in'      => trans('admin::messages.The :field is required. And cannot be 0.', ['field' => trans('admin::messages.custom field')]),
        ];
		
        /*
		$messages['category_id.unique_ccf'] = trans('validation.custom_field_unique_rule', [
			'field_1' => trans('admin::messages.category'),
			'field_2' => trans('admin::messages.custom field'),
		]);
		$messages['category_id.unique_ccf_parent'] = trans('validation.custom_field_unique_parent_rule', [
			'field_1' => trans('admin::messages.category'),
			'field_2' => trans('admin::messages.custom field'),
		]);
		$messages['category_id.unique_ccf_children'] = trans('validation.custom_field_unique_children_rule', [
			'field_1' => trans('admin::messages.category'),
			'field_2' => trans('admin::messages.custom field'),
		]);
		
		$messages['field_id.unique_ccf'] = trans('validation.custom_field_unique_rule_field', [
			'field_1' => trans('admin::messages.custom field'),
			'field_2' => trans('admin::messages.category'),
		]);
		$messages['field_id.unique_ccf_parent'] = trans('validation.custom_field_unique_parent_rule_field', [
			'field_1' => trans('admin::messages.custom field'),
			'field_2' => trans('admin::messages.category'),
		]);
		$messages['field_id.unique_ccf_children'] = trans('validation.custom_field_unique_children_rule_field', [
			'field_1' => trans('admin::messages.custom field'),
			'field_2' => trans('admin::messages.category'),
		]);
        */
        
        return $messages;
    }
}
