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

use App\Models\Category;
use App\Models\CategoryField;
use Illuminate\Support\Facades\Input;

class CategoryFieldValidator
{
    public function __construct()
    {
    	//...
    }

    /**
     * Prevent duplicate content (Category & Custom Field) in 'category_field' table
	 * Example: 'field_id' => 'unique_ccf:category_id,{varCatId}|...'
     *
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @param $validator
	 * @return bool
	 */
    public function isUnique($attribute, $value, $parameters, $validator)
    {
        $countCategories = CategoryField::where($parameters[0], $parameters[1])->where($attribute, $value)->count();
        if ($countCategories > 0) {
        	return false;
		}

        return true;
    }
	
	/**
	 * Example: 'field_id' => 'unique_ccf_parent:category_id,{varCatId}|...'
	 *
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @param $validator
	 * @return bool
	 */
	public function isUniqueWithParent($attribute, $value, $parameters, $validator)
    {
		$categoryId = ($attribute == 'category_id') ? $value : $parameters[1];
		
		// Check parent records
		$cat = Category::findTrans($categoryId);
		if (!empty($cat)) {
			if ($cat->parent_id != 0) {
				if ($attribute == 'category_id') {
					$parentCatField = CategoryField::where($parameters[0], $parameters[1])->where($attribute, $cat->parent_id)->first();
				} else {
					$parentCatField = CategoryField::where($parameters[0], $cat->parent_id)->where($attribute, $value)->first();
				}
				
				if (!empty($parentCatField) && $parentCatField->disabled_in_subcategories != 1) {
					return false;
				}
			}
		}

        return true;
    }
	
	/**
	 * Example: 'field_id' => 'unique_ccf_children:category_id,{varCatId}|...'
	 *
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @param $validator
	 * @return bool
	 */
	public function isUniqueWithChildren($attribute, $value, $parameters, $validator)
	{
		$categoryId = ($attribute == 'category_id') ? $value : $parameters[1];
		
		// Check child records
		$subCats = Category::trans()->where('parent_id', $categoryId)->get(['id', 'parent_id']);
		if ($subCats->count() > 0) {
			$fieldAlreadyExistsInAChild = false;
			foreach ($subCats as $subCat) {
				if ($attribute == 'category_id') {
					$subCatField = CategoryField::where($parameters[0], $parameters[1])->where($attribute, $subCat->id)->first();
				} else {
					$subCatField = CategoryField::where($parameters[0], $subCat->id)->where($attribute, $value)->first();
				}
				
				if (!empty($subCatField)) {
					$fieldAlreadyExistsInAChild = true;
					break;
				}
			}
			
			if ($fieldAlreadyExistsInAChild && Input::get('disabled_in_subcategories') != 1) {
				return false;
			}
		}
		
		return true;
	}
}
