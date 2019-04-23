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

namespace App\Http\Controllers\Traits;

use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use Illuminate\Support\Facades\File;

trait RobotsTxtTrait
{
	/**
	 * Check & Create the robots.txt file if it doesn't exist
	 */
	public function checkRobotsTxtFile()
	{
		// Get the robots.txt file path
		$robotsFile = public_path('robots.txt');
		
		// Generate the robots.txt (If it does not exist)
		if (!File::exists($robotsFile)) {
			$robotsTxt = '';
			
			// Default Content
			$robotsTxt .= 'User-agent: *' . "\n";
			$robotsTxt .= 'Disallow:' . "\n";
			$robotsTxt .= "\n";
			$robotsTxt .= 'Allow: /' . "\n";
			$robotsTxt .= "\n";
			$robotsTxt .= 'User-agent: *' . "\n";
			$robotsTxt .= 'Disallow: /' . admin_uri() . '/' . "\n";
			$robotsTxt .= 'Disallow: /ajax/' . "\n";
			$robotsTxt .= 'Disallow: /assets/' . "\n";
			$robotsTxt .= 'Disallow: /css/' . "\n";
			$robotsTxt .= 'Disallow: /js/' . "\n";
			$robotsTxt .= 'Disallow: /vendor/' . "\n";
			$robotsTxt .= 'Disallow: /main.php' . "\n";
			$robotsTxt .= 'Disallow: /mix-manifest.json' . "\n";
			$robotsTxt .= "\n";
			
			// Add a Sitemap Index for each Country
			$countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
			if (!$countries->isEmpty()) {
				foreach ($countries as $country) {
					$country = CountryLocalization::getCountryInfo($country->get('code'));
					
					if ($country->isEmpty()) {
						continue;
					}
					
					// Get the Country's Language Code
					$countryLanguageCode = ($country->has('lang') && $country->get('lang')->has('abbr'))
						? $country->get('lang')->get('abbr')
						: config('app.locale');
					
					// Add the Sitemap Index
					$robotsTxt .= 'Sitemap: ' . localUrl($country, $country->get('icode') . '/sitemaps.xml') . "\n";
				}
			}
			
			// Create the robots.txt file
			if (File::isWritable(dirname($robotsFile))) {
				File::put($robotsFile, $robotsTxt);
			}
		}
	}
}
