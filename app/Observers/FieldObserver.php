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

namespace App\Observer;

use App\Models\CategoryField;
use App\Models\Field;
use App\Models\FieldOption;
use App\Models\PostValue;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class FieldObserver extends TranslatedModelObserver
{
    /**
     * Listen to the Entry updating event.
     *
     * @param  Field $field
     * @return void
     */
    public function updating(Field $field)
    {
        // Get fields types having options
        $fieldTypesHavingOptions = ['checkbox_multiple', 'radio', 'select'];
    
        if (Input::filled('type')) {
            // Check if field has options
            if (in_array($field->type, $fieldTypesHavingOptions) && !in_array(Input::get('type'), $fieldTypesHavingOptions)) {
                // Delete all the Custom Field's options
                $options = FieldOption::where('field_id', $field->id)->get();
                if ($options->count() > 0) {
                    foreach ($options as $option) {
                        $option->delete();
                    }
                }
            
                // Delete all Posts Custom Field's Values
                $postValues = PostValue::where('field_id', $field->id)->get();
                if ($postValues->count() > 0) {
                    foreach ($postValues as $postValue) {
                        $postValue->delete();
                    }
                }
            }
        
            // Check if field has options
            if (!in_array($field->type, $fieldTypesHavingOptions) && in_array(Input::get('type'), $fieldTypesHavingOptions)) {
                // Delete all Posts Custom Field's Values
                $postValues = PostValue::where('field_id', $field->id)->get();
                if ($postValues->count() > 0) {
                    foreach ($postValues as $postValue) {
                        // If field is of type 'file', remove files (if exists)
                        if ($field->type == 'file') {
                            if (!empty($postValue->value)) {
                                Storage::delete($postValue->value);
                            }
                        }
                        // Delete the Post's value for this field
                        $postValue->delete();
                    }
                }
            }
        }
    }
    
    /**
     * Listen to the Entry deleting event.
     *
     * @param  Field $field
     * @return void
     */
    public function deleting($field)
    {
		parent::deleting($field);
		
        // Delete all Categories Custom Fields
        $catFields = CategoryField::where('field_id', $field->id)->get();
        if ($catFields->count() > 0) {
            foreach ($catFields as $catField) {
                $catField->delete();
            }
        }
    
        // Delete all the Custom Field's options
        $fieldOptions = FieldOption::where('field_id', $field->id)->get();
        if ($fieldOptions->count() > 0) {
            foreach ($fieldOptions as $fieldOption) {
                $fieldOption->delete();
            }
        }
    
        // Delete all Posts Custom Field's Values
        $postValues = PostValue::where('field_id', $field->id)->get();
        if ($postValues->count() > 0) {
            foreach ($postValues as $postValue) {
                $postValue->delete();
            }
        }
    }
}
