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

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [
		\App\Http\Middleware\CheckForMaintenanceMode::class,
		\Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
		\App\Http\Middleware\TrimStrings::class,
		\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
		\App\Http\Middleware\TrustProxies::class,
	];
	
	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		'web' => [
			\App\Http\Middleware\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\Session\Middleware\StartSession::class,
			// \Illuminate\Session\Middleware\AuthenticateSession::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			// \App\Http\Middleware\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
			
			\App\Http\Middleware\CheckBrowserLanguage::class,
			\App\Http\Middleware\CheckCountryLanguage::class,
			\App\Http\Middleware\XSSProtection::class,
			\App\Http\Middleware\BannedUser::class,
			\App\Http\Middleware\HttpsProtocol::class,
			\App\Http\Middleware\LazyLoading::class,
			\App\Http\Middleware\HtmlMinify::class,
		],
		
		'admin' => [
			\App\Http\Middleware\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\Session\Middleware\StartSession::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\App\Http\Middleware\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
			
			\App\Http\Middleware\Admin::class,
			\App\Http\Middleware\XSSProtection::class,
			\App\Http\Middleware\BannedUser::class,
			\App\Http\Middleware\HttpsProtocol::class,
		],
		
		'api' => [
			'throttle:60,1',
			'bindings',
		],
		
		'locale' => ['localize', 'localizationRedirect', 'localeSessionRedirect', 'localeViewPath'],
	];
	
	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth'          => \App\Http\Middleware\Authenticate::class,
		'auth.basic'    => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'bindings'      => \Illuminate\Routing\Middleware\SubstituteBindings::class,
		'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
		'can'           => \Illuminate\Auth\Middleware\Authorize::class,
		'guest'         => \App\Http\Middleware\RedirectIfAuthenticated::class,
		'signed'        => \Illuminate\Routing\Middleware\ValidateSignature::class,
		'throttle'      => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		
		'client' => \Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
		
		'banned.user' => \App\Http\Middleware\BannedUser::class,
		
		'localize'              => \Larapen\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
		'localizationRedirect'  => \Larapen\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
		'localeSessionRedirect' => \Larapen\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
		'localeViewPath'        => \Larapen\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
		
		'install.checker'      => \App\Http\Middleware\InstallationChecker::class,
		'prevent.back.history' => \App\Http\Middleware\PreventBackHistory::class,
		'only.ajax'            => \App\Http\Middleware\OnlyAjax::class,
		'demo.restriction'     => \App\Http\Middleware\DemoRestriction::class,
	];
	
	/**
	 * The priority-sorted list of middleware.
	 *
	 * This forces non-global middleware to always be in the given order.
	 *
	 * @var array
	 */
	protected $middlewarePriority = [
		\Illuminate\Session\Middleware\StartSession::class,
		\Illuminate\View\Middleware\ShareErrorsFromSession::class,
		\App\Http\Middleware\Authenticate::class,
		\Illuminate\Session\Middleware\AuthenticateSession::class,
		\Illuminate\Routing\Middleware\SubstituteBindings::class,
		\Illuminate\Auth\Middleware\Authorize::class,
		\App\Http\Middleware\CheckBrowserLanguage::class,
		\App\Http\Middleware\CheckCountryLanguage::class,
		\App\Http\Middleware\LazyLoading::class,
		\App\Http\Middleware\HtmlMinify::class,
	];
}
