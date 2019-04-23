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

use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Language as LanguageLocalization;
use Illuminate\Support\Facades\Config;

trait LocalizationTrait
{
	/**
	 * Get Localization
	 * Get Locale from Browser or from Country spoken Language
	 * and get Country by User IP
	 */
	private function loadLocalizationData()
	{
		// Language
		$langObj = new LanguageLocalization();
		$lang = $langObj->find();
		
		// Country
		$countryObj = new CountryLocalization();
		$countryObj->find();
		$countryObj->setCountryParameters();
		
		// Fix for the vars
		$lang = (!empty($lang)) ? $lang : collect([]);
		$country = (!empty($countryObj->country)) ? $countryObj->country : collect([]);
		$ipCountry = (!empty($countryObj->ipCountry)) ? $countryObj->ipCountry : collect([]);
		
		// Translate the Country name (If translation exists)
		if (!$country->isEmpty() && !$lang->isEmpty()) {
			$country = CountryLocalizationHelper::trans($country, $lang->get('abbr'));
		}
		
		// Session: Set Country Code
		// Config: Country
		if (!$country->isEmpty() && $country->has('code')) {
			session(['country_code' => $country->get('code')]);
			$countryLangExists = $country->has('lang') && $country->get('lang')->has('abbr');
			Config::set('country.locale', ($countryLangExists) ? $country->get('lang')->get('abbr') : config('app.locale'));
			Config::set('country.lang', ($country->has('lang')) ? $country->get('lang')->toArray() : []);
			Config::set('country.code', $country->get('code'));
			Config::set('country.icode', $country->get('icode'));
			Config::set('country.name', $country->get('name'));
			Config::set('country.currency', $country->get('currency_code'));
			Config::set('country.admin_type', $country->get('admin_type'));
			Config::set('country.admin_field_active', $country->get('admin_field_active'));
			Config::set('country.background_image', $country->get('background_image'));
		}
		// Config: IP Country
		if (!$ipCountry->isEmpty() && $ipCountry->has('code')) {
			Config::set('ipCountry.code', $ipCountry->get('code'));
		}
		// Config: Currency
		if (!$country->isEmpty() && $country->has('currency') && !empty($country->get('currency'))) {
			Config::set('currency', $country->get('currency')->toArray());
		}
		// Config: Set TimeZome
		if (!$country->isEmpty() && $country->has('timezone') && !empty($country->get('timezone'))) {
			Config::set('timezone.id', $country->get('timezone')->time_zone_id);
		}
		// Config: Language
		if (!$lang->isEmpty()) {
			session(['language_code' => $lang->get('abbr')]);
			Config::set('lang.abbr', $lang->get('abbr'));
			Config::set('lang.locale', $lang->get('locale'));
			Config::set('lang.direction', $lang->get('direction'));
			Config::set('lang.russian_pluralization', $lang->get('russian_pluralization'));
		}
		// Config: Currency Exchange Plugin
		if (config('plugins.currencyexchange.installed')) {
			Config::set('country.currencies', ($country->has('currencies')) ? $country->get('currencies') : '');
		} else {
			Config::set('selectedCurrency', config('currency'));
		}
		// Config: Domain Mapping Plugin
		if (config('plugins.domainmapping.installed')) {
			applyDomainMappingConfig(config('country.code'));
		}
	}
}
