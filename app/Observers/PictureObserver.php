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

namespace App\Observer;

use App\Models\Picture;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PictureObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  Picture $picture
     * @return void
     */
    public function deleting(Picture $picture)
    {
        // Delete all pictures files
        if (!empty($picture->filename)) {
            $filePath = str_replace('uploads/', '', $picture->filename);
        
            // Delete the picture with its thumbs
            $filename = last(explode('/', $filePath));
            $files = Storage::files(dirname($filePath));
            if (!empty($files)) {
                foreach($files as $file) {
                    // Don't delete the default picture
                    if (Str::contains($file, config('larapen.core.picture.default'))) {
                        continue;
                    }
                    if (Str::contains($file, $filename)) {
                        Storage::delete($file);
                    }
                }
            }
        }
    }
	
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param  Picture $picture
	 * @return void
	 */
	public function saved(Picture $picture)
	{
		// Removing Entries from the Cache
		$this->clearCache($picture);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param  Picture $picture
	 * @return void
	 */
	public function deleted(Picture $picture)
	{
		// Removing Entries from the Cache
		$this->clearCache($picture);
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $picture
	 */
	private function clearCache($picture)
	{
		Cache::forget('post.withoutGlobalScopes.with.city.pictures.' . $picture->post_id);
		Cache::forget('post.with.city.pictures.' . $picture->post_id);
		Cache::forget('post.withoutGlobalScopes.with.city.pictures.' . $picture->post_id . '.' . config('app.locale'));
		Cache::forget('post.with.city.pictures.' . $picture->post_id . '.' . config('app.locale'));
	}
}
