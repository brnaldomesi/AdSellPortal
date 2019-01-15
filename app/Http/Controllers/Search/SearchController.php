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
use App\Http\Controllers\Search\Traits\PreSearchTrait;
use App\Models\CategoryField;
use Torann\LaravelMetaTags\Facades\MetaTag;

class SearchController extends BaseController
{
	use PreSearchTrait;
	
	public $isIndexSearch = true;
	
	protected $cat = null;
	protected $subCat = null;
	protected $city = null;
	protected $admin = null;
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		view()->share('isIndexSearch', $this->isIndexSearch);
		
		// Pre-Search
		if (request()->filled('c')) {
			if (request()->filled('sc')) {
				$this->getCategory(request()->get('c'), request()->get('sc'));
				
				// Get Category nested IDs
				$catNestedIds = (object)[
					'parentId' => request()->get('c'),
					'id'       => request()->get('sc'),
				];
			} else {
				$this->getCategory(request()->get('c'));
				
				// Get Category nested IDs
				$catNestedIds = (object)[
					'parentId' => 0,
					'id'       => request()->get('c'),
				];
			}
			
			// Get Custom Fields
			$customFields = CategoryField::getFields($catNestedIds);
			view()->share('customFields', $customFields);
		}
		if (request()->filled('l') || request()->filled('location')) {
			$city = $this->getCity(request()->get('l'), request()->get('location'));
		}
		if (request()->filled('r') && !request()->filled('l')) {
			$admin = $this->getAdmin(request()->get('r'));
		}
		
		// Pre-Search values
		$preSearch = [
			'city'  => (isset($city) && !empty($city)) ? $city : null,
			'admin' => (isset($admin) && !empty($admin)) ? $admin : null,
		];
		
		// Search
		$search = new Search($preSearch);
		$data = $search->fechAll();
		
		// Export Search Result
		view()->share('count', $data['count']);
		view()->share('paginator', $data['paginator']);
		
		// Get Titles
		$title = $this->getTitle();
		$this->getBreadcrumb();
		$this->getHtmlTitle();
		
		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $title);
		
		return view('search.serp');
	}
}
