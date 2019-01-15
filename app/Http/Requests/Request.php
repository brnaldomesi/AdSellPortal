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

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

abstract class Request extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}
	
	/**
	 * Handle a failed validation attempt.
	 *
	 * @param Validator $validator
	 * @throws ValidationException
	 */
	protected function failedValidation(Validator $validator)
	{
		if ($this->ajax() || $this->wantsJson() || $this->segment(1) == 'api') {
			// Get Errors
			$errors = (new ValidationException($validator))->errors();
			
			// Get Json
			$json = [
				'success' => false,
				'message' => t('An error occurred while validating the data.'),
				'data'    => $errors,
			];
			
			// Add a specific json attributes for 'bootstrap-fileinput' plugin
			if (str_contains(get_called_class(), 'PhotoRequest')) {
				// Get errors in text
				$errorsTxt = t('Error found');
				if (is_array($errors) && count($errors) > 0) {
					foreach ($errors as $value) {
						if (is_array($value)) {
							foreach ($value as $v) {
								$errorsTxt .= '<br>- ' . $v;
							}
						} else {
							$errorsTxt .= '<br>- ' . $value;
						}
					}
				}
				
				// NOTE: 'bootstrap-fileinput' need 'errorkeys' (array) element & 'error' (text) element
				$json['error'] = $errorsTxt;
				$json['errorkeys'] = $errors;
			}
			
			throw new HttpResponseException(response()->json($json, JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
		}
		
		parent::failedValidation($validator);
	}
}
