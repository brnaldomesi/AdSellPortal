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

namespace App\Http\Controllers\Search;

use App\Helpers\Search;
use App\Models\User;
use Torann\LaravelMetaTags\Facades\MetaTag;

class UserController extends BaseController
{
	public $isUserSearch = true;
	public $sUser;

    /**
     * @param $countryCode
     * @param null $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($countryCode, $userId = null)
    {
        // Check multi-countries site parameters
        if (!config('settings.seo.multi_countries_urls')) {
            $userId = $countryCode;
        }

        view()->share('isUserSearch', $this->isUserSearch);

        // Get User
        $this->sUser = User::findOrFail($userId);

        // Redirect to User's profile If username exists
        if (!empty($this->sUser->username)) {
        	$attr = ['countryCode' => $countryCode, 'username' => $this->sUser->username];
            $url = lurl(trans('routes.v-search-username', $attr), $attr);
            headerLocation($url);
        }

        return $this->searchByUserId($this->sUser->id);
    }

    /**
     * @param $countryCode
     * @param null $username
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile($countryCode, $username = null)
    {
        // Check multi-countries site parameters
        if (!config('settings.seo.multi_countries_urls')) {
            $username = $countryCode;
        }

        view()->share('isUserSearch', $this->isUserSearch);

        // Get User
        $this->sUser = User::where('username', $username)->firstOrFail();

        return $this->searchByUserId($this->sUser->id, $this->sUser->username);
    }
    
	/**
	 * @param $userId
	 * @param null $username
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    private function searchByUserId($userId, $username = null)
    {
        // Search
        $search = new Search();
        $data = $search->setUser($userId)->setRequestFilters()->fetch();

        // Get Titles
        $bcTab = $this->getBreadcrumb();
        $htmlTitle = $this->getHtmlTitle();
        view()->share('bcTab', $bcTab);
        view()->share('htmlTitle', $htmlTitle);

        // Meta Tags
        $title = $this->getTitle();
        MetaTag::set('title', $title);
        MetaTag::set('description', $title);
	
		// Translation vars
		view()->share('uriPathUserId', $userId);
		view()->share('uriPathUsername', $username);

        return view('search.serp', $data);
    }
}
