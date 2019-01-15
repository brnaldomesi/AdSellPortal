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

use App\Models\CategoryField;
use App\Models\PostValue;
use Illuminate\Support\Facades\Storage;

class CustomFieldRequest extends Request
{
	protected $customFields = [];
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$request = request();
		if ($this->has('parent_id') && $this->has('category_id')) {
			$request = $this;
		}
		
		$rules = [];
		
		// Get Category nested IDs
		$catNestedIds = (object)[
			'parentId' => $request->input('parent_id'),
			'id'       => $request->input('category_id'),
		];
		
		// Custom Fields
		$this->customFields = CategoryField::getFields($catNestedIds);
		if ($this->customFields->count() > 0) {
			foreach ($this->customFields as $field) {
				$cfRules = '';
				
				// Check if the field is required
				if ($field->required == 1 && $field->type != 'file') {
					$cfRules = 'required';
				}
				
				// Check if the field is an upload type
				if ($field->type == 'file') {
					$fileExists = false;
					
					if ($request->filled('post_id')) {
						$postValue = PostValue::where('post_id', $request->input('post_id'))->where('field_id', $field->tid)->first();
						if (!empty($postValue)) {
							if (trim($postValue->value) != '' && Storage::exists($postValue->value)) {
								$fileExists = true;
							}
						}
					}
					
					if ($field->required == 1) {
						if (!$fileExists) {
							$cfRules = 'required';
						}
					}
					
					$cfRules = (!empty($cfRules)) ? $cfRules . '|' : '';
					$cfRules = $cfRules . 'mimes:' . getUploadFileTypes('file') . '|max:' . (int)config('settings.upload.max_file_size', 1000);
				}
				
				$rules['cf.' . $field->tid] = $cfRules;
			}
		}
		
		return $rules;
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		$messages = [];
		
		if ($this->customFields->count() > 0) {
			foreach ($this->customFields as $field) {
				// If the field is required
				if ($field->required == 1) {
					$messages['cf.' . $field->tid . '.required'] = t('The :field is required.', ['field' => mb_strtolower($field->name)]);
				}
				
				// If the field is an upload type
				if ($field->type == 'file') {
					$messages['cf.' . $field->tid . '.mimes'] = t('The file of :field must be in the good format.', ['field' => mb_strtolower($field->name)]);
					$messages['cf.' . $field->tid . '.max'] = t('The file of :field may not be greater than :max.', [
						'field' => mb_strtolower($field->name),
						'max'   => (int)config('settings.upload.max_file_size', 1000),
					]);
				}
			}
		}
		
		return $messages;
	}
}
