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

namespace App\Http\Controllers;

/*
 * Increase PHP page execution time for this controller.
 * NOTE: This function has no effect when PHP is running in safe mode (http://php.net/manual/en/ini.sect.safe-mode.php#ini.safe-mode).
 * There is no workaround other than turning off safe mode or changing the time limit (max_execution_time) in the php.ini.
 */
set_time_limit(0);

use App\Helpers\ArrayHelper;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Models\Category;
use App\Models\Page;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\City;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Watson\Sitemap\Facades\Sitemap;

class SitemapsController extends FrontController
{
	protected $defaultDate = '2015-10-30T20:10:00+02:00';
	
	/**
	 * SitemapsController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Get Countries
		$this->countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
		
		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->commonQueries();
			return $next($request);
		});
	}
	
	/**
	 * Common Queries
	 */
	public function commonQueries()
	{
		// Set the Country's Locale & Default Date
		$this->applyCountrySettings();
	}
	
	/**
	 * Index Sitemap
	 *
	 * @return mixed
	 */
	public function index()
	{
		foreach ($this->countries as $item) {
			// Get Country Settings
			$country = $this->getCountrySettings($item->get('code'), false);
			if (empty($country)) {
				continue;
			}
			
			Sitemap::addSitemap(localUrl($country, $country->icode . '/sitemaps.xml'));
		}
		
		return Sitemap::index();
	}
	
	/**
	 * Index Single Country Sitemap
	 *
	 * @param null $countryCode
	 * @return bool|\Illuminate\Http\Response
	 */
	public function site($countryCode = null)
	{
		if (empty($countryCode)) {
			$countryCode = config('country.code');
		}
		
		// Get Country Settings
		$country = $this->getCountrySettings($countryCode);
		if (empty($country)) {
			return false;
		}
		
		Sitemap::addSitemap(localUrl(collect($country), $country->icode . '/sitemaps/pages.xml'));
		Sitemap::addSitemap(localUrl(collect($country), $country->icode . '/sitemaps/categories.xml'));
		Sitemap::addSitemap(localUrl(collect($country), $country->icode . '/sitemaps/cities.xml'));
		
		$countPosts = Post::verified()->countryOf($country->code)->count();
		if ($countPosts > 0) {
			Sitemap::addSitemap(localUrl(collect($country), $country->icode . '/sitemaps/posts.xml'));
		}
		
		return Sitemap::index();
	}
	
	/**
	 * @param null $countryCode
	 * @return bool|\Illuminate\Http\Response
	 */
	public function pages($countryCode = null)
	{
		if (empty($countryCode)) {
			$countryCode = config('country.code');
		}
		
		// Get Country Settings
		$country = $this->getCountrySettings($countryCode);
		if (empty($country)) {
			return false;
		}
		
		$queryString = '?d=' . $country->code;
		
		$url = lurl('/') . $queryString;
		Sitemap::addTag($url, $this->defaultDate, 'daily', '1.0');
		
		$attr = ['countryCode' => $country->icode];
		$url = lurl(trans('routes.v-sitemap', $attr, $country->locale), $attr, $country->locale) . $queryString;
		Sitemap::addTag($url, $this->defaultDate, 'daily', '0.5');
		
		$attr = ['countryCode' => $country->icode];
		$url = lurl(trans('routes.v-search', $attr, $country->locale), $attr, $country->locale) . $queryString;
		Sitemap::addTag($url, $this->defaultDate, 'daily', '0.6');
		
		$pages = Cache::remember('pages.' . $country->locale, $this->cacheExpiration, function () use ($country) {
			$pages = Page::transIn($country->locale)->orderBy('lft', 'ASC')->get();
			
			return $pages;
		});
		
		if ($pages->count() > 0) {
			foreach ($pages as $page) {
				$attr = ['slug' => $page->slug];
				$url = lurl(trans('routes.v-page', $attr, $country->locale), $attr, $country->locale);
				Sitemap::addTag($url, $this->defaultDate, 'daily', '0.7');
			}
		}
		
		$url = lurl(trans('routes.contact', [], $country->locale) . $queryString, [], $country->locale);
		Sitemap::addTag($url, $this->defaultDate, 'daily', '0.7');
		
		return Sitemap::render();
	}
	
	/**
	 * @param null $countryCode
	 * @return bool|\Illuminate\Http\Response
	 */
	public function categories($countryCode = null)
	{
		if (empty($countryCode)) {
			$countryCode = config('country.code');
		}
		
		// Get Country Settings
		$country = $this->getCountrySettings($countryCode);
		if (empty($country)) {
			return false;
		}
		
		// Categories
		$cacheId = 'categories.' . $country->locale . '.all';
		$cats = Cache::remember($cacheId, $this->cacheExpiration, function () use ($country) {
			$cats = Category::transIn($country->locale)->orderBy('lft')->get();
			
			return $cats;
		});
		
		if ($cats->count() > 0) {
			$cats = collect($cats)->keyBy('translation_of');
			$cats = $subCats = $cats->groupBy('parent_id');
			$cats = $cats->get(0);
			$subCats = $subCats->forget(0);
			
			foreach ($cats as $cat) {
				$attr = ['countryCode' => $country->icode, 'catSlug' => $cat->slug];
				$url = lurl(trans('routes.v-search-cat', $attr, $country->locale), $attr, $country->locale);
				Sitemap::addTag($url, $this->defaultDate, 'daily', '0.8');
				
				if ($subCats->get($cat->tid)) {
					foreach ($subCats->get($cat->tid) as $subCat) {
						$attr = [
							'countryCode' => $country->icode,
							'catSlug'     => $cat->slug,
							'subCatSlug'  => $subCat->slug,
						];
						$url = lurl(trans('routes.v-search-subCat', $attr, $country->locale), $attr, $country->locale);
						Sitemap::addTag($url, $this->defaultDate, 'weekly', '0.8');
					}
				}
			}
		}
		
		return Sitemap::render();
	}
	
	/**
	 * @param null $countryCode
	 * @return bool|\Illuminate\Http\Response
	 */
	public function cities($countryCode = null)
	{
		if (empty($countryCode)) {
			$countryCode = config('country.code');
		}
		
		// Get Country Settings
		$country = $this->getCountrySettings($countryCode);
		if (empty($country)) {
			return false;
		}
		
		$limit = 1000;
		$cacheId = $country->icode . '.cities.take.' . $limit;
		$cities = Cache::remember($cacheId, $this->cacheExpiration, function () use ($country, $limit) {
			$cities = City::countryOf($country->code)->take($limit)->orderBy('population', 'DESC')->orderBy('name')->get();
			
			return $cities;
		});
		
		if ($cities->count() > 0) {
			foreach ($cities as $city) {
				$city->name = trim(head(explode('/', $city->name)));
				$attr = [
					'countryCode' => $country->icode,
					'city'        => slugify($city->name),
					'id'          => $city->id,
				];
				$url = lurl(trans('routes.v-search-city', $attr, $country->locale), $attr, $country->locale);
				Sitemap::addTag($url, $this->defaultDate, 'weekly', '0.7');
			}
		}
		
		return Sitemap::render();
	}
	
	/**
	 * @param null $countryCode
	 * @return bool|\Illuminate\Http\Response
	 */
	public function posts($countryCode = null)
	{
		if (empty($countryCode)) {
			$countryCode = config('country.code');
		}
		
		// Get Country Settings
		$country = $this->getCountrySettings($countryCode);
		if (empty($country)) {
			return false;
		}
		
		$limit = 50000;
		$cacheId = $country->icode . '.sitemaps.posts.xml';
		$posts = Cache::remember($cacheId, $this->cacheExpiration, function () use ($country, $limit) {
			$posts = Post::verified()->countryOf($country->code)->take($limit)->orderBy('created_at', 'DESC')->get();
			
			return $posts;
		});
		
		if ($posts->count() > 0) {
			foreach ($posts as $post) {
				$attr = ['slug' => slugify($post->title), 'id' => $post->id];
				$url = lurl($post->uri, $attr, $country->locale);
				Sitemap::addTag($url, $post->created_at, 'daily', '0.6');
			}
		}
		
		return Sitemap::render();
	}
	
	/**
	 * Set the Country's Locale & Default Date
	 *
	 * @param null $locale
	 * @param null $timeZone
	 */
	public function applyCountrySettings($locale = null, $timeZone = null)
	{
		// Set the App Language
		if (!empty($locale)) {
			App::setLocale($locale);
		} else {
			App::setLocale(config('app.locale'));
		}
		
		// Date: Carbon object
		$this->defaultDate = Carbon::parse(date('Y-m-d H:i'));
		if (!empty($timeZone)) {
			$this->defaultDate->timezone($timeZone);
		} else {
			if (config('timezone.id')) {
				$this->defaultDate->timezone(config('timezone.id'));
			}
		}
	}
	
	/**
	 * Get Country Settings
	 *
	 * @param $countryCode
	 * @param bool $canApplySettings
	 * @return array|null
	 */
	public function getCountrySettings($countryCode, $canApplySettings = true)
	{
		$tab = [];
		
		// Get Country Info
		$country = CountryLocalization::getCountryInfo($countryCode);
		if ($country->isEmpty()) {
			return null;
		}
		
		$tab['code'] = $country->get('code');
		$tab['icode'] = $country->get('icode');
		
		// Language
		if (!$country->get('lang')->isEmpty() && $country->get('lang')->has('abbr')) {
			$tab['locale'] = $country->get('lang')->get('abbr');
		} else {
			$tab['locale'] = config('app.locale');
		}
		
		// TimeZone
		if (!empty($country->get('timezone')) && isset($country->get('timezone')->time_zone_id)) {
			$tab['timezone'] = $country->get('timezone')->time_zone_id;
		} else {
			$tab['timezone'] = config('timezone.id');
		}
		
		$tab = ArrayHelper::toObject($tab);
		
		// Set the Country's Locale & Default Date
		if ($canApplySettings) {
			$this->applyCountrySettings($tab->locale, $tab->timezone);
		}
		
		return $tab;
	}
}
