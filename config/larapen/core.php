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

return [

    /*
     |-----------------------------------------------------------------------------------------------
     | The item's ID on CodeCanyon
     |-----------------------------------------------------------------------------------------------
     |
     */

    'itemId' => '16458425',

    /*
     |-----------------------------------------------------------------------------------------------
     | Purchase code checker URL
     |-----------------------------------------------------------------------------------------------
     |
     */

    'purchaseCodeCheckerUrl' => 'http://api.bedigit.com/envato.php?purchase_code=',
	
	/*
     |-----------------------------------------------------------------------------------------------
     | Purchase Code
     |-----------------------------------------------------------------------------------------------
     |
     */

	'purchaseCode' => env('PURCHASE_CODE', ''),

    /*
     |-----------------------------------------------------------------------------------------------
     | Demo Website Info
     |-----------------------------------------------------------------------------------------------
     |
     */

    'demo' => [
    	'domain' => 'bedigit.com',
		'hosts'   => [
			'demo.bedigit.com',
			'laraclassified.bedigit.com',
		],
	],

    /*
     |-----------------------------------------------------------------------------------------------
     | Default Logo
     |-----------------------------------------------------------------------------------------------
     |
     */

    'logo' => 'app/default/logo.png',

    /*
     |-----------------------------------------------------------------------------------------------
     | Default Favicon
     |-----------------------------------------------------------------------------------------------
     |
     */

    'favicon' => 'app/default/ico/favicon.png',

    /*
     |-----------------------------------------------------------------------------------------------
     | Default ads picture & Default ads pictures sizes
     |-----------------------------------------------------------------------------------------------
     |
     */

    'picture' => [
        'default' => 'app/default/picture.jpg',
        'size' => [
            'width'  => 1000,
            'height' => 1000,
        ],
        'quality' => env('PICTURE_QUALITY', 100),
        'resize' => [
            'logo'   => '500x100',
            'square' => '400x400', // ex: Categories
            'small'  => '120x90',
            'medium' => '320x240',
            'big'    => '816x460',
            'large'  => '1000x1000'
        ],
        'versioned' => env('PICTURE_VERSIONED', false),
        'version'   => env('PICTURE_VERSION', 1),
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Default user profile picture (Unused for now)
     |-----------------------------------------------------------------------------------------------
     |
     */

    'photo' => '',

	/*
     |-----------------------------------------------------------------------------------------------
     | TextToImage settings (Used to convert phone numbers to image)
     |-----------------------------------------------------------------------------------------------
     |
	 | format         : IMAGETYPE_JPEG, IMAGETYPE_PNG or IMAGETYPE_GIF
	 | color          : RGB (Example RGB: #FFFFFF = White)
	 | backgroundColor: RGBA or RGB (Examples RGBA: rgba(0,0,0,0.0) = Transparent)
	 | fontFamily     : Fonts Path: /packages/larapen/texttoimage/src/Libraries/font/
	 |
	 | NOTE: Transparent value is only available for PNG format.
	 |
     */

	'textToImage' => [
		'format'          => IMAGETYPE_PNG,
		'color'           => '#FFFFFF',
		'backgroundColor' => 'rgba(0,0,0,0.0)',
		'fontFamily'      => 'FiraSans-Regular.ttf',
		'fontSize'        => 12,
		'padding'         => 0,
		'quality'         => 100,
	],
    
    /*
     |-----------------------------------------------------------------------------------------------
     | Countries SVG maps folder & URL base
     |-----------------------------------------------------------------------------------------------
     |
     */

    'maps' => [
        'path'    => public_path('images/maps') . '/',
        'urlBase' => 'images/maps/',
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Optimize your URLs for SEO (for International website)
     |-----------------------------------------------------------------------------------------------
     |
     | You have to set the variables below in the /.env file:
     |
     | MULTI_COUNTRIES_URLS=true (to enable the multi-countries URLs optimization)
     | HIDE_DEFAULT_LOCALE_IN_URL=false (to show the default language code in the URLs)
     |
     */

    'multiCountriesUrls' => env('MULTI_COUNTRIES_URLS', false),

    /*
     |-----------------------------------------------------------------------------------------------
     | Force links to use the HTTPS protocol
     |-----------------------------------------------------------------------------------------------
     |
     */

    'forceHttps' => env('FORCE_HTTPS', false),

    /*
     |-----------------------------------------------------------------------------------------------
     | Plugins Path & Namespace
     |-----------------------------------------------------------------------------------------------
     |
     */

    'plugin' => [
        'path'      => app_path('Plugins') . '/',
        'namespace' => '\\App\Plugins\\',
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Managing User's Fields (Phone, Email & Username)
     |-----------------------------------------------------------------------------------------------
     |
     | When 'disable.phone' and 'disable.email' are TRUE,
     | the script use the email field by default.
     |
     */

    'disable' => [
        'phone'    => env('DISABLE_PHONE', true),
        'email'    => env('DISABLE_EMAIL', false),
        'username' => env('DISABLE_USERNAME', true),
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Disallowing usernames that match reserved names
     |-----------------------------------------------------------------------------------------------
     |
     */

    'reservedUsernames' => [
        'admin',
        'api',
        'profile',
        //...
    ],
    
    /*
     |-----------------------------------------------------------------------------------------------
     | Custom Prefix for the new locations (Administratives Divisions) Codes
     |-----------------------------------------------------------------------------------------------
     |
     */
    
    'locationCodePrefix' => 'Z',
    
    /*
     |-----------------------------------------------------------------------------------------------
     | Mile use countries (By default, the script use Kilometer)
     |-----------------------------------------------------------------------------------------------
     |
     */
    
    'mileUseCountries' => ['US','UK'],

	/*
     |-----------------------------------------------------------------------------------------------
     | MySQL Distance Calculation function (orthodromy or haversine formula)
     |-----------------------------------------------------------------------------------------------
     |
	 | e.g. orthodromy
     */

	'distanceCalculationFormula' => 'orthodromy',
	
	/*
     |-----------------------------------------------------------------------------------------------
     | Date & Datetime Format Syntax: http://php.net/strftime
	 | The implementation makes a call to strftime using the current instance timestamp.
     |-----------------------------------------------------------------------------------------------
     |
     */
	'defaultDateFormat'     => '%d %B %Y',
	'defaultDatetimeFormat' => '%d %B %Y %H:%M',
	'defaultTimezone'       => 'America/New_York',
	
	/*
     |-----------------------------------------------------------------------------------------------
     | Permalink Collection (Posts)
     |-----------------------------------------------------------------------------------------------
     |
     */
	
	'permalink' => [
		'posts' => [
			'{slug}-{id}' => ':slug-:id',
			'{slug}/{id}' => ':slug/:id',
			'{slug}_{id}' => ':slug_:id',
			'{id}-{slug}' => ':id-:slug',
			'{id}/{slug}' => ':id/:slug',
			'{id}_{slug}' => ':id_:slug',
			'{id}'        => ':id',
		],
	],
	
	/*
     |-----------------------------------------------------------------------------------------------
     | Maintenance Mode IP Whitelist
     |-----------------------------------------------------------------------------------------------
	 |
	 | e.g. ['127.0.0.1', '::1', '175.12.103.14', ...]
     |
     */
	
	'exceptOwnIp' => [
		//...
	],

];
