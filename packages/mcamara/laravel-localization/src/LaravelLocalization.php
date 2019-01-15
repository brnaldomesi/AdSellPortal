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

namespace Larapen\LaravelLocalization;

use App\Models\Language;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request as RequestFacade;

class LaravelLocalization
{
	use LocalizationTrait;
	
	/**
	 * Config repository.
	 *
	 * @var \Illuminate\Config\Repository
	 */
	protected $configRepository;
	
	/**
	 * Illuminate view Factory.
	 *
	 * @var \Illuminate\View\Factory
	 */
	protected $view;
	
	/**
	 * Illuminate translator class.
	 *
	 * @var \Illuminate\Translation\Translator
	 */
	protected $translator;
	
	/**
	 * Illuminate router class.
	 *
	 * @var \Illuminate\Routing\Router
	 */
	protected $router;
	
	/**
	 * Illuminate request class.
	 *
	 * @var \Illuminate\Routing\Request
	 */
	protected $request;
	
	/**
	 * Illuminate request class.
	 *
	 * @var \Illuminate\Foundation\Application
	 */
	protected $app;
	
	/**
	 * Illuminate request class.
	 *
	 * @var string
	 */
	protected $baseUrl;
	
	/**
	 * Default locale
	 *
	 * @var string
	 */
	protected $defaultLocale;
	
	/**
	 * Supported Locales
	 *
	 * @var array
	 */
	protected $supportedLocales;
	
	/**
	 * Current locale
	 *
	 * @var string
	 */
	protected $currentLocale = false;
	
	/**
	 * An array that contains all routes that should be translated
	 *
	 * @var array
	 */
	protected $translatedRoutes = [];
	
	/**
	 * Name of the translation key of the current route, it is used for url translations
	 *
	 * @var string
	 */
	protected $routeName;
	
	public static $cacheExpiration = 60; // In minutes (e.g. 60 for 1h)
	
	/**
	 * LaravelLocalization constructor.
	 */
	public function __construct()
	{
		$this->app = app();
		
		$this->configRepository = $this->app['config'];
		$this->view = $this->app['view'];
		$this->translator = $this->app['translator'];
		$this->router = $this->app['router'];
		$this->request = $this->app['request'];
		
		// Cache Expiration Time
		self::$cacheExpiration = (int)config('settings.other.cache_expiration', 60);
		
		// set default locale
		// $this->defaultLocale = $this->configRepository->get('app.locale');
		
		// Default language (from config)
		$this->defaultLocale = config('appLang.abbr', config('app.locale'));
		
		$supportedLocales = $this->getSupportedLocales();
		
		if (
			!isset($supportedLocales[$this->defaultLocale])
			|| empty($supportedLocales[$this->defaultLocale])
		) {
			dd("The default locale is not supported.");
		}
	}
	
	/**
	 * Set and return current locale
	 *
	 * @param null $locale
	 * @return null
	 */
	public function setLocale($locale = null)
	{
		if (empty($locale) || !\is_string($locale)) {
			// If the locale has not been passed through the function
			// it tries to get it from the first segment of the url
			$locale = $this->request->segment(1);
		}
		
		if (!empty($this->supportedLocales[$locale])) {
			$this->currentLocale = $locale;
		} else {
			// if the first segment/locale passed is not valid
			// the system would ask which locale have to take
			// it could be taken by the browser
			// depending on your configuration
			
			$locale = null;
			
			// if we reached this point and hideDefaultLocaleInURL is true
			// we have to assume we are routing to a defaultLocale route.
			if ($this->hideDefaultLocaleInURL()) {
				$this->currentLocale = $this->defaultLocale;
			}
			// but if hideDefaultLocaleInURL is false, we have
			// to retrieve it from the browser...
			else {
				$this->currentLocale = $this->getCurrentLocale();
			}
		}
		
		$this->app->setLocale($this->currentLocale);
		
		// Regional locale such as de_DE, so formatLocalized works in Carbon
		$regional = $this->getCurrentLocaleRegional();
		if ($regional) {
			setlocale(LC_TIME, $regional.'.UTF-8');
			setlocale(LC_MONETARY, $regional.'.UTF-8');
		}
		
		return $locale;
	}
	
	/**
	 * Set and return supported locales
	 *
	 * @param $locales
	 */
	public function setSupportedLocales($locales)
	{
		$this->supportedLocales = $locales;
	}
	
	/**
	 * Returns an URL adapted to $locale or current locale
	 *
	 * @param null $url
	 * @param null $locale
	 * @return bool|\Illuminate\Contracts\Routing\UrlGenerator|mixed|null|string
	 */
	public function localizeURL($url = null, $locale = null)
	{
		return $this->getLocalizedURL($locale, $url);
	}
	
	/**
	 * Returns an URL adapted to $locale
	 *
	 * @param null $locale
	 * @param null $url
	 * @param array $attributes
	 * @param bool $forceDefaultLocation
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|null|string
	 */
	public function getLocalizedURL($locale = null, $url = null, $attributes = [], $forceDefaultLocation = false)
	{
		if ($locale === null) {
			$locale = $this->getCurrentLocale();
		}
		
		// Skip some Paths
		if ($this->exceptRedirectionPath()) {
			return false;
		}
		
		// Check if Locale is supported
		if (!$this->checkLocaleInSupportedLocales($locale)) {
			return false;
		}
		
		// If no attributes has been set, Extract them from RAW URL.
		if (empty($attributes)) {
			$attributes = $this->extractAttributes($url, $locale);
		}
		
		if (empty($url)) {
			if (!empty($this->routeName)) {
				return $this->getURLFromRouteNameTranslated($locale, $this->routeName, $attributes, $forceDefaultLocation);
			}
			
			// Get URL through the current Controller
			$url = $this->getUrlThroughCurrentController($locale, $attributes);
			if (!empty($url)) {
				return $url;
			} else {
				$url = url($this->request->getRequestUri());
			}
		} else {
			// Get URL through entered Route (Or through entered URL)
			$url = $this->getUrlThroughEnteredRoute($locale, $url, $attributes);
			if (!empty($url)) {
				if (!str_contains($url, '###') && !str_contains($url, '{')) {
					return $url;
				}
				$url = str_replace('###', '', $url);
			}
		}
		
		if ($locale && $translatedRoute = $this->findTranslatedRouteByUrl($url, $attributes, $this->currentLocale)) {
			return $this->getURLFromRouteNameTranslated($locale, $translatedRoute, $attributes, $forceDefaultLocation);
		}
		
		$base_path = $this->request->getBaseUrl();
		$parsed_url = mb_parse_url($url); //=> UTF-8
		$url_locale = $this->getDefaultLocale();
		
		if (!$parsed_url || empty($parsed_url['path'])) {
			$path = $parsed_url['path'] = "";
		} else {
			$parsed_url['path'] = str_replace($base_path, '', '/' . ltrim($parsed_url['path'], '/'));
			$path = $parsed_url['path'];
			foreach ($this->getSupportedLocales() as $localeCode => $lang) {
				if (!config('settings.seo.multi_countries_urls')) {
					$parsed_url['path'] = preg_replace('%^/?' . $localeCode . '/%', '$1', $parsed_url['path']);
					if ($parsed_url['path'] !== $path) {
						$url_locale = $localeCode;
						break;
					}
				}
				
				$parsed_url['path'] = preg_replace('%^/?' . $localeCode . '$%', '$1', $parsed_url['path']);
				if ($parsed_url['path'] !== $path) {
					$url_locale = $localeCode;
					break;
				}
			}
		}
		
		$parsed_url['path'] = ltrim($parsed_url['path'], '/');
		
		if ($translatedRoute = $this->findTranslatedRouteByPath($parsed_url['path'], $url_locale)) {
			return $this->getURLFromRouteNameTranslated($locale, $translatedRoute, $attributes, $forceDefaultLocation);
		}
		
		if (!empty($locale)) {
			if ($forceDefaultLocation || $locale != $this->getDefaultLocale() || !$this->hideDefaultLocaleInURL()) {
				$parsed_url['path'] = $locale . '/' . ltrim($parsed_url['path'], '/');
			}
		}
		$parsed_url['path'] = ltrim(ltrim($base_path, '/') . '/' . $parsed_url['path'], '/');
		
		// Make sure that the pass path is returned with a leading slash only if it come in with one.
		if (starts_with($path, '/') === true) {
			$parsed_url['path'] = '/' . $parsed_url['path'];
		}
		$parsed_url['path'] = rtrim($parsed_url['path'], '/');
		
		$url = $this->unparseUrl($parsed_url);
		
		if ($this->checkUrl($url)) {
			return $url;
		}
		
		return $this->createUrlFromUri($url);
	}
	
	/**
	 * Returns an URL adapted to the route name and the locale given
	 *
	 * @param $locale
	 * @param $transKeyName
	 * @param array $attributes
	 * @param bool $forceDefaultLocation
	 * @return bool|string
	 */
	public function getURLFromRouteNameTranslated($locale, $transKeyName, $attributes = [], $forceDefaultLocation = false)
	{
		if (!$this->checkLocaleInSupportedLocales($locale)) {
			dd('Locale \'' . $locale . '\' is not in the list of supported locales.');
		}
		
		if (!\is_string($locale)) {
			$locale = $this->getDefaultLocale();
		}
		
		$route = "";
		
		if ($forceDefaultLocation || !($locale === $this->defaultLocale && $this->hideDefaultLocaleInURL())) {
			$route = '/' . $locale;
		}
		if (\is_string($locale) && $this->translator->has($transKeyName, $locale)) {
			$translation = $this->translator->trans($transKeyName, [], $locale);
			$route .= "/" . $translation;
			
			$route = $this->substituteAttributesInRoute($attributes, $route);
		}
		
		if (empty($route)) {
			// This locale does not have any key for this route name
			return false;
		}
		
		return rtrim($this->createUrlFromUri($route));
	}
	
	/**
	 * It returns an URL without locale (if it has it)
	 * Convenience function wrapping getLocalizedURL(false)
	 *
	 * @param null $url
	 * @return false|\Illuminate\Contracts\Routing\UrlGenerator|null|string
	 */
	public function getNonLocalizedURL($url = null)
	{
		return $this->getLocalizedURL(false, $url);
	}
	
	/**
	 * Returns default locale
	 *
	 * @return string
	 */
	public function getDefaultLocale()
	{
		return $this->defaultLocale;
	}
	
	/**
	 * Return an array of all supported Locales
	 *
	 * @return array|mixed
	 */
	public function getSupportedLocales()
	{
		if (!empty($this->supportedLocales)) {
			return $this->supportedLocales;
		}
		
		// Get supported languages from database
		try {
			// Get all DB Languages
			$activeLanguages = Cache::remember('languages.active.array', self::$cacheExpiration, function () {
				try {
					$activeLanguages = Language::where('active', 1)->orderBy('lft', 'ASC')->get()->toArray();
				} catch (\Exception $e) {
					$activeLanguages = Language::where('active', 1)->get()->toArray();
				}
				return $activeLanguages;
			});
			
			$localizableLanguagesArray = [];
			
			if (count($activeLanguages)) {
				foreach ($activeLanguages as $key => $lang) {
					$lang['regional'] = $lang['locale'];
					$localizableLanguagesArray[$lang['abbr']] = $lang;
				}
				
				$this->supportedLocales = $localizableLanguagesArray;
				
				return $localizableLanguagesArray;
			}
		} catch (\Exception $e) {
			/*
			 * Database or tables don't exists.
			 * The script will display an error or will start the installation.
			 * Please don't change anything here.
			 */
		}
		
		// Get supported languages from config
		$localizableLanguagesArray = $this->configRepository->get('laravellocalization.supportedLocales');
		
		if (empty($localizableLanguagesArray) || !\is_array($localizableLanguagesArray)) {
			dd("Supported locales must be defined.");
		}
		
		$this->supportedLocales = $localizableLanguagesArray;
		
		return $localizableLanguagesArray;
	}
	
	/**
	 * Return an array of all supported Locales but in the order the user
	 * has specified in the config file. Useful for the language selector.
	 *
	 * @return array|mixed
	 */
	public function getLocalesOrder()
	{
		$locales = $this->getSupportedLocales();
		
		$order = $this->configRepository->get('laravellocalization.localesOrder');
		
		uksort($locales, function ($a, $b) use ($order) {
			$pos_a = array_search($a, $order);
			$pos_b = array_search($b, $order);
			return $pos_a - $pos_b;
		});
		
		return $locales;
	}
	
	/**
	 * Returns current locale name
	 *
	 * @return mixed
	 */
	public function getCurrentLocaleName()
	{
		return $this->supportedLocales[$this->getCurrentLocale()]['name'];
	}
	
	/**
	 * Returns current locale native name
	 *
	 * @return mixed
	 */
	public function getCurrentLocaleNative()
	{
		return $this->supportedLocales[$this->getCurrentLocale()]['native'];
	}
	
	/**
	 * Returns current locale direction
	 *
	 * @return string
	 */
	public function getCurrentLocaleDirection()
	{
		
		if (!empty($this->supportedLocales[$this->getCurrentLocale()]['dir'])) {
			return $this->supportedLocales[$this->getCurrentLocale()]['dir'];
		}
		
		switch ($this->getCurrentLocaleScript()) {
			// Other (historic) RTL scripts exist, but this list contains the only ones in current use.
			case 'Arab':
			case 'Hebr':
			case 'Mong':
			case 'Tfng':
			case 'Thaa':
				return 'rtl';
			default:
				return 'ltr';
		}
		
	}
	
	/**
	 * Returns current locale script
	 *
	 * @return mixed
	 */
	public function getCurrentLocaleScript()
	{
		return $this->supportedLocales[$this->getCurrentLocale()]['script'];
	}
	
	/**
	 * Returns current language's native reading
	 *
	 * @return mixed
	 */
	public function getCurrentLocaleNativeReading()
	{
		return $this->supportedLocales[$this->getCurrentLocale()]['native'];
	}
	
	/**
	 * Returns current language
	 *
	 * @return mixed|string
	 */
	public function getCurrentLocale()
	{
		if ($this->currentLocale) {
			return $this->currentLocale;
		}
		
		if ($this->useAcceptLanguageHeader() && !$this->app->runningInConsole()) {
			$negotiator = new LanguageNegotiator($this->defaultLocale, $this->getSupportedLocales(), $this->request);
			
			return $negotiator->negotiateLanguage();
		}
		
		// or get application default language
		return $this->configRepository->get('app.locale');
	}
	
	/**
	 * Returns current regional
	 *
	 * @return null
	 */
	public function getCurrentLocaleRegional()
	{
		// need to check if it exists, since 'regional' has been added
		// after version 1.0.11 and existing users will not have it
		if (isset($this->supportedLocales[$this->getCurrentLocale()]['regional'])) {
			return $this->supportedLocales[$this->getCurrentLocale()]['regional'];
		} else {
			return null;
		}
	}
	
	/**
	 * Returns supported languages language key
	 *
	 * @return array    keys of supported languages
	 */
	public function getSupportedLanguagesKeys()
	{
		return array_keys($this->supportedLocales);
	}
	
	
	/**
	 * Check if Locale exists on the supported locales array
	 *
	 * @param $locale
	 * @return bool
	 */
	public function checkLocaleInSupportedLocales($locale)
	{
		$locales = $this->getSupportedLocales();
		if ($locale !== false && empty($locales[$locale])) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Change route attributes for the ones in the $attributes array
	 *
	 * @param $attributes array Array of attributes
	 * @param string $route string route to substitute
	 * @return string route with attributes changed
	 */
	protected function substituteAttributesInRoute($attributes, $route)
	{
		foreach ($attributes as $key => $value) {
			if ($value instanceOf UrlRoutable) {
				$value = $value->getRouteKey();
			}
			$route = str_replace(array('{'.$key.'}', '{'.$key.'?}'), $value, $route);
		}
		
		// delete empty optional arguments that are not in the $attributes array
		$route = preg_replace('/\/{[^)]+\?}/', '', $route);
		
		return $route;
	}
	
	/**
	 * Returns translated routes
	 *
	 * @return array translated routes
	 */
	protected function getTranslatedRoutes()
	{
		return $this->translatedRoutes;
	}
	
	/**
	 * Set current route name
	 * @param string $routeName current route name
	 */
	public function setRouteName($routeName)
	{
		$this->routeName = $routeName;
	}
	
	/**
	 * Translate routes and save them to the translated routes array (used in the localize route filter)
	 *
	 * @param  string $routeName Key of the translated string
	 *
	 * @return string                Translated string
	 */
	public function transRoute($routeName)
	{
		if (!\in_array($routeName, $this->translatedRoutes)) {
			$this->translatedRoutes[] = $routeName;
		}
		
		return $this->translator->trans($routeName);
	}
	
	/**
	 * Returns the translation key for a given path
	 *
	 * @param  string $path Path to get the key translated
	 *
	 * @return string|false            Key for translation, false if not exist
	 */
	public function getRouteNameFromAPath($path)
	{
		$attributes = $this->extractAttributes($path);
		
		$path = str_replace(url('/'), "", $path);
		if ($path[0] !== '/') {
			$path = '/' . $path;
		}
		$path = str_replace('/' . $this->currentLocale . '/', '', $path);
		$path = trim($path, "/");
		
		foreach ($this->translatedRoutes as $route) {
			if ($this->substituteAttributesInRoute($attributes, $this->translator->trans($route)) === $path) {
				return $route;
			}
		}
		
		return false;
	}
	
	/**
	 * Returns the translated route for the path and the url given
	 *
	 * @param  string $path Path to check if it is a translated route
	 * @param  string $url_locale Language to check if the path exists
	 *
	 * @return string|false            Key for translation, false if not exist
	 */
	protected function findTranslatedRouteByPath($path, $url_locale)
	{
		// check if this url is a translated url
		foreach ($this->translatedRoutes as $translatedRoute) {
			if ($this->translator->trans($translatedRoute, [], $url_locale) == rawurldecode($path)) {
				return $translatedRoute;
			}
		}
		
		return false;
	}
	
	/**
	 * Returns the translated route for an url and the attributes given and a locale
	 *
	 * @param $url
	 * @param $attributes
	 * @param $locale
	 * @return bool|mixed
	 */
	protected function findTranslatedRouteByUrl($url, $attributes, $locale)
	{
		if (empty($url)) {
			return false;
		}
		
		// check if this url is a translated url
		foreach ($this->translatedRoutes as $translatedRoute) {
			$routeName = $this->getURLFromRouteNameTranslated($locale, $translatedRoute, $attributes);
			
			if ($this->getNonLocalizedURL($routeName) == $this->getNonLocalizedURL($url)) {
				return $translatedRoute;
			}
			
		}
		
		return false;
	}
	
	/**
	 * Returns true if the string given is a valid url
	 *
	 * @param  string $url String to check if it is a valid url
	 *
	 * @return boolean        Is the string given a valid url?
	 */
	protected function checkUrl($url)
	{
		return filter_var($url, FILTER_VALIDATE_URL);
	}
	
	
	/**
	 * Returns the config repository for this instance
	 *
	 * @return Repository    Configuration repository
	 *
	 */
	public function getConfigRepository()
	{
		return $this->configRepository;
	}
	
	
	/**
	 * Returns the translation key for a given path
	 *
	 * @return boolean       Returns value of useAcceptLanguageHeader in config.
	 */
	protected function useAcceptLanguageHeader()
	{
		return $this->configRepository->get('laravellocalization.useAcceptLanguageHeader');
	}
	
	/**
	 * Returns the translation key for a given path
	 *
	 * @return boolean       Returns value of hideDefaultLocaleInURL in config.
	 */
	public function hideDefaultLocaleInURL()
	{
		return $this->configRepository->get('laravellocalization.hideDefaultLocaleInURL');
	}
	
	/**
	 * Create an url from the uri
	 * @param    string $uri Uri
	 *
	 * @return  string  Url for the given uri
	 */
	public function createUrlFromUri($uri)
	{
		$uri = ltrim($uri, "/");
		$queryString = (RequestFacade::getQueryString() ? ('?' . RequestFacade::getQueryString()) : '');
		
		if (empty($this->baseUrl)) {
			return app('url')->to($uri);
		}
		
		return $this->baseUrl . $uri;
	}
	
	/**
	 * Sets the base url for the site
	 * @param string $url Base url for the site
	 *
	 */
	public function setBaseUrl($url)
	{
		if (substr($url, -1) != "/")
			$url .= "/";
		
		$this->baseUrl = $url;
	}
	
	/**
	 * Extract attributes for current url
	 *
	 * @param string|null|false $url to extract attributes, if not present, the system will look for attributes in the current call
	 * @param string                 $locale
	 *
	 * @return array    Array with attributes
	 *
	 */
	protected function extractAttributes($url = false, $locale = '')
	{
		if (!empty($url)) {
			$attributes = [];
			$parse = parse_url($url);
			if (isset($parse['path'])) {
				$parse = explode("/", $parse['path']);
			} else {
				$parse = [];
			}
			
			$url = [];
			foreach ($parse as $segment) {
				if (!empty($segment)) {
					$url[] = $segment;
				}
			}
			
			foreach ($this->router->getRoutes() as $route) {
				$path = method_exists($route, 'uri') ? $route->uri() : $route->getUri();
				
				if (!preg_match("/{[\w]+}/", $path)) {
					continue;
				}
				
				$path = explode("/", $path);
				$i = 0;
				
				$match = true;
				foreach ($path as $j => $segment) {
					if (isset($url[$i])) {
						if ($segment === $url[$i]) {
							$i++;
							continue;
						}
						if (preg_match("/{[\w]+}/", $segment)) {
							// must-have parameters
							$attribute_name = preg_replace(["/}/", "/{/", "/\?/"], "", $segment);
							$attributes[$attribute_name] = $url[$i];
							$i++;
							continue;
						}
						if (preg_match("/{[\w]+\?}/", $segment)) {
							// optional parameters
							if (!isset($path[$j + 1]) || $path[$j + 1] !== $url[$i]) {
								// optional parameter taken
								$attribute_name = preg_replace(["/}/", "/{/", "/\?/"], "", $segment);
								$attributes[$attribute_name] = $url[$i];
								$i++;
								continue;
							}
							
						}
					} else if (!preg_match("/{[\w]+\?}/", $segment)) {
						// no optional parameters but no more $url given
						// this route does not match the url
						$match = false;
						break;
					}
				}
				
				if (isset($url[$i + 1])) {
					$match = false;
				}
				
				if ($match) {
					return $attributes;
				}
			}
			
		} else {
			if (!$this->router->current()) {
				return [];
			}
			
			$attributes = $this->normalizeAttributes($this->router->current()->parameters());
			$response = event('routes.translation', [$locale, $attributes]);
			if (!empty($response)) {
				$response = array_shift($response);
			}
			if (\is_array($response)) {
				$attributes = array_merge($attributes, $response);
			}
		}
		
		return $attributes;
	}
	
	/**
	 * Build URL using array data from parse_url
	 *
	 * @param array|false $parsed_url Array of data from parse_url function
	 *
	 * @return string               Returns URL as string.
	 */
	protected function unparseUrl($parsed_url)
	{
		if (empty($parsed_url)) {
			return '';
		}
		
		$url = '';
		$url .= isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
		$url .= $parsed_url['host'] ?? '';
		$url .= isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
		$user = $parsed_url['user'] ?? '';
		$pass = isset($parsed_url['pass']) ? ':' . $parsed_url['pass'] : '';
		$url .= $user . (($user || $pass) ? "$pass@" : '');
		
		if (!empty($url)) {
			$url .= isset($parsed_url['path']) ? '/' . ltrim($parsed_url['path'], '/') : '';
		} else {
			$url .= $parsed_url['path'] ?? '';
		}
		
		$url .= isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
		$url .= isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
		
		// Sub-folder support
		$url = $this->extendedUnparseUrl($parsed_url, $url);
		
		return $url;
	}
	
	/**
	 * Normalize attributes gotten from request parameters.
	 *
	 * @param      array  $attributes  The attributes
	 * @return     array  The normalized attributes
	 */
	protected function normalizeAttributes($attributes)
	{
		if (array_key_exists('data', $attributes) && \is_array($attributes['data']) && ! \count($attributes['data'])) {
			$attributes['data'] = null;
			return $attributes;
		}
		
		return $attributes;
	}
}
