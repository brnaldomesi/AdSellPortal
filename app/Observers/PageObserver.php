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

use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class PageObserver extends TranslatedModelObserver
{
    /**
     * Listen to the Entry saved event.
     *
     * @param  Page $page
     * @return void
     */
    public function saved(Page $page)
    {
        // Removing Entries from the Cache
        $this->clearCache($page);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  Page $page
     * @return void
     */
    public function deleted(Page $page)
    {
        // Removing Entries from the Cache
        $this->clearCache($page);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $page
     */
    private function clearCache($page)
    {
        Cache::flush();
    }
}
