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

use App\Models\Field;
use App\Models\PostValue;
use Illuminate\Support\Facades\Storage;

class PostValueObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  PostValue $postValue
     * @return void
     */
    public function deleting(PostValue $postValue)
    {
        // Remove files (if exists)
        $field = Field::findTrans($postValue->field_id);
        if (!empty($field)) {
            if ($field->type == 'file') {
                if (!empty($postValue->value)) {
                    Storage::delete($postValue->value);
                }
            }
        }
    }
}
