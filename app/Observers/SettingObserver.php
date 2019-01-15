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

use App\Helpers\Lang\LangManager;
use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Prologue\Alerts\Facades\Alert;

class SettingObserver
{
	/**
	 * Listen to the Entry updating event.
	 *
	 * @param  Setting $setting
	 * @return void
	 */
    public function updating(Setting $setting)
	{
		// Get the original object values
		$original = $setting->getOriginal();
		
		if (isset($original['value']) && !empty($original['value'])) {
			$original['value'] = jsonToArray($original['value']);
			
			// Remove old logo from disk (Don't remove the default logo)
			if (isset($setting->value['logo']) && isset($original['value']['logo'])) {
				if ($setting->value['logo'] != $original['value']['logo']) {
					if (!str_contains($original['value']['logo'], config('larapen.core.logo'))) {
						Storage::delete($original['value']['logo']);
					}
				}
			}
			
			// Remove old favicon from disk (Don't remove the default favicon)
			if (isset($setting->value['favicon']) && isset($original['value']['favicon'])) {
				if ($setting->value['favicon'] != $original['value']['favicon']) {
					if (!str_contains($original['value']['favicon'], config('larapen.core.favicon'))) {
						Storage::delete($original['value']['favicon']);
					}
				}
			}
			
			// Remove old body_background_image from disk
			if (isset($setting->value['body_background_image']) && isset($original['value']['body_background_image'])) {
				if ($setting->value['body_background_image'] != $original['value']['body_background_image']) {
					Storage::delete($original['value']['body_background_image']);
				}
			}
			
			// Enable Posts Approbation by User Admin (Post Review)
			if (isset($setting->value['posts_review_activation'])) {
				// If Post Approbation is enabled, then update all the existing Posts
				if ((int)$setting->value['posts_review_activation'] == 1) {
					Post::where('reviewed', '!=', 1)->update(['reviewed' => 1]);
				}
			}
			
			// Regenerate the "resources/lang/[langCode]/routes.php" file
			if (
				(isset($setting->value['posts_permalink']) && isset($original['value']['posts_permalink'])) ||
				(isset($setting->value['posts_permalink_ext']) && isset($original['value']['posts_permalink_ext'])) ||
				(isset($setting->value['multi_countries_urls']) && isset($original['value']['multi_countries_urls']))
			) {
				if (
					($setting->value['posts_permalink'] != $original['value']['posts_permalink']) ||
					($setting->value['posts_permalink_ext'] != $original['value']['posts_permalink_ext']) ||
					($setting->value['multi_countries_urls'] != $original['value']['multi_countries_urls'])
				) {
					$this->regenerateLangRoutes($setting);
				}
			}
			
			// Check if the session sharing field has changed & Update the /.env file
			if ((isset($setting->value['share_session']) && isset($original['value']['share_session']))) {
				if (($setting->value['share_session'] != $original['value']['share_session'])) {
					$this->updateEnvFileForSessionSharing($setting);
				}
			}
		}
	}
    
    /**
     * Listen to the Entry saved event.
     *
     * @param  Setting $setting
     * @return void
     */
    public function saved(Setting $setting)
    {
    	// If the Default Country is changed, then clear the 'country_code' from the sessions
		if (isset($setting->value['default_country_code'])) {
			session()->forget('country_code');
			session(['country_code' => $setting->value['default_country_code']]);
		}
	
		// If the Default Listing Mode is changed, then clear the 'listing_display_mode' from the cookies
		// NOTE: The cookie has been set from JavaScript, so we have to provide the good path (may be the good expire time)
		if (isset($setting->value['display_mode'])) {
			$expire = 60 * 24 * 7; // 7 days
			if (isset($_COOKIE['listing_display_mode'])) {
				unset($_COOKIE['listing_display_mode']);
			}
			setcookie('listing_display_mode', $setting->value['display_mode'], $expire, '/');
		}
		
		// If the Default Front Skin is changed, then update its assets paths (like categories pictures, etc.)
		if (isset($setting->value['app_skin']) && !empty($setting->value['app_skin'])) {
			$categories = Category::where('parent_id', 0)->get();
			if ($categories->count() > 0) {
				foreach ($categories as $category) {
					$canSave = false;
					
					// If the Category contains a skinnable icon,
					// Change it by the selected skin icon.
					if (str_contains($category->picture, 'app/categories/skin-')) {
						$pattern = '/app\/categories\/skin-[^\/]+\//ui';
						$replacement = 'app/categories/' . $setting->value['app_skin'] . '/';
						$picture = preg_replace($pattern, $replacement, $category->picture);
						if (!empty($picture)) {
							$category->picture = $picture;
							$canSave = true;
						}
					}
					
					// (Optional)
					// If the Category contains a skinnable default icon,
					// Change it by the selected skin default icon.
					if (str_contains($category->picture, 'app/default/categories/fa-folder-')) {
						$pattern = '/app\/default\/categories\/fa-folder-[^\.]+\./ui';
						$replacement = 'app/default/categories/fa-folder-' . $setting->value['app_skin'] . '.';
						$picture = preg_replace($pattern, $replacement, $category->picture);
						if (!empty($picture)) {
							$category->picture = $picture;
							$canSave = true;
						}
					}
					
					if ($canSave) {
						$category->save();
					}
				}
			}
		}
		
        // Removing Entries from the Cache
        $this->clearCache($setting);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  Setting $setting
     * @return void
     */
    public function deleted(Setting $setting)
    {
        // Removing Entries from the Cache
        $this->clearCache($setting);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $setting
     */
    private function clearCache($setting)
    {
        Cache::flush();
    }
	
	/**
	 * Regenerate the "resources/lang/[langCode]/routes.php" file
	 *
	 * @param null $setting
	 * @return bool
	 */
    private function regenerateLangRoutes($setting = null)
	{
		$doneSuccessfully = true;
		
		try {
			// Update in live the config vars related the Settings below before saving them.
			if (isset($setting->value)) {
				if (isset($setting->value['posts_permalink'])) {
					Config::set('settings.seo.posts_permalink', $setting->value['posts_permalink']);
				}
				if (isset($setting->value['posts_permalink_ext'])) {
					Config::set('settings.seo.posts_permalink_ext', $setting->value['posts_permalink_ext']);
				}
				if (isset($setting->value['multi_countries_urls'])) {
					// Check the Domain Mapping plugin
					if (config('plugins.domainmapping.installed')) {
						Config::set('settings.seo.multi_countries_urls', false);
					} else {
						Config::set('settings.seo.multi_countries_urls', $setting->value['multi_countries_urls']);
					}
				}
			}
			
			// Init. the language manager
			$manager = new LangManager();
			
			// Get current values of "resources/lang/[langCode]/routes.php" (Original version)
			$routes = $manager->getFileContent(config_path('larapen/routes.php'));
			
			// Get all the others languages
			$locales = $manager->getLocales();
			if (!empty($locales)) {
				foreach ($locales as $locale) {
					$filePath = resource_path('lang/' . $locale . '/routes.php');
					$manager->writeFile($filePath, $routes);
				}
			}
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$doneSuccessfully = false;
		}
		
		return $doneSuccessfully;
	}
	
	/**
	 * Update the /.env file to apply the session sharing rules
	 * The admin user will be log out automatically.
	 *
	 * @param $setting
	 */
	private function updateEnvFileForSessionSharing($setting)
	{
		// Check the Domain Mapping plugin
		if (config('plugins.domainmapping.installed')) {
			if (isset($setting->value['share_session'])) {
				Config::set('settings.domain_mapping.share_session', $setting->value['share_session']);
				
				// Log out the admin user
				\App\Plugins\domainmapping\Domainmapping::logout();
				
				// Update the /.env file to meet the plugin installation requirements
				\App\Plugins\domainmapping\Domainmapping::updateEnvFile(true);
			}
		}
	}
}
