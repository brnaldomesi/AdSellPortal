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

namespace App\Http\Middleware;

use App\Helpers\Curl;
use App\Models\TimeZone;
use Closure;
use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class InstallationChecker
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($request->segment(1) == 'install') {
			// Check if installation is processing
			$InstallInProgress = false;
			if (
				!empty($request->session()->get('database_imported')) ||
				!empty($request->session()->get('cron_jobs')) ||
				!empty($request->session()->get('install_finish'))
			) {
				$InstallInProgress = true;
			}
			if ($this->alreadyInstalled($request) && $this->properlyInstalled() && !$InstallInProgress) {
				return redirect('/');
			}
		} else {
			// Check if an update is available
			if ($this->envFileExists() && $this->updateIsAvailable()) {
				return headerLocation(getRawBaseUrl() . '/upgrade');
			}
			
			// Check if the website is installed
			if (!$this->alreadyInstalled($request) || !$this->properlyInstalled()) {
				return redirect(getRawBaseUrl() . '/install');
			}
			
			$this->checkPurchaseCode($request);
		}
		
		return $next($request);
	}
	
	/**
	 * If application is already installed.
	 *
	 * @param $request
	 * @return bool|\Illuminate\Http\RedirectResponse
	 */
	public function alreadyInstalled($request)
	{
		// Check if installation has just finished
		if (!empty($request->session()->get('install_finish'))) {
			// Write file
			File::put(storage_path('installed'), '');
			
			$request->session()->forget('install_finish');
			$request->session()->flush();
			
			// Redirect to the homepage after installation
			return redirect('/');
		}
		
		// Check if the /storage/installed file exists
		return File::exists(storage_path('installed'));
	}
	
	/**
	 * @return bool
	 */
	public function properlyInstalled()
	{
		// Check if .env file exists
		if (!$this->envFileExists()) {
			return false;
		}
		
		// Check Installation Setup
		$properly = true;
		try {
			// Check if all database tables exists
			$namespace = 'App\\Models\\';
			$modelsPath = app_path('Models');
			$modelFiles = array_filter(File::glob($modelsPath . '/' . '*.php'), 'is_file');
			
			if (count($modelFiles) > 0) {
				foreach ($modelFiles as $filePath) {
					$filename = last(explode('/', $filePath));
					$modelname = head(explode('.', $filename));
					
					if (!str_contains(strtolower($filename), '.php') or str_contains(strtolower($modelname), 'base')) {
						continue;
					}
					
					eval('$model = new ' . $namespace . $modelname . '();');
					if (!Schema::hasTable($model->getTable())) {
						$properly = false;
					}
				}
			}
			
			// Check Settings table
			if (Setting::count() <= 0) {
				$properly = false;
			}
			// Check TimeZone table
			if (TimeZone::count() <= 0) {
				$properly = false;
			}
		} catch (\PDOException $e) {
			$properly = false;
		} catch (\Exception $e) {
			$properly = false;
		}
		
		return $properly;
	}
	
	/**
	 * Check if /.env file exists
	 *
	 * @return bool
	 */
	public function envFileExists()
	{
		return File::exists(base_path('.env'));
	}
	
	/**
	 * Check Purchase Code
	 * ===================
	 * Checking your purchase code. If you do not have one, please follow this link:
	 * https://codecanyon.net/item/laraclassified-geo-classified-ads-cms/16458425
	 * to acquire a valid code.
	 *
	 * IMPORTANT: Do not change this part of the code to prevent any data losing issue.
	 *
	 * @param $request
	 */
	private function checkPurchaseCode($request)
	{
		$tab = [
			'install',
			admin_uri(),
		];
		
		// Don't check the purchase code for these areas (install, admin, etc. )
		if (!in_array($request->segment(1), $tab)) {
			// Make the purchase code verification only if 'installed' file exists
			if (file_exists(storage_path('installed')) && !config('settings.error')) {
				// Get purchase code from 'installed' file
				$purchaseCode = file_get_contents(storage_path('installed'));
				
				// Send the purchase code checking
				if (
					$purchaseCode == '' ||
					config('settings.app.purchase_code') == '' ||
					$purchaseCode != config('settings.app.purchase_code')
				) {
					$apiUrl = config('larapen.core.purchaseCodeCheckerUrl') . config('settings.app.purchase_code') . '&item_id=' . config('larapen.core.itemId');
					$data = Curl::fetch($apiUrl);
					
					// Check & Get cURL error by checking if 'data' is a valid json
					if (!isValidJson($data)) {
						$data = json_encode(['valid' => false, 'message' => 'Invalid purchase code. ' . strip_tags($data)]);
					}
					
					// Format object data
					$data = json_decode($data);
					
					// Check if 'data' has the valid json attributes
					if (!isset($data->valid) || !isset($data->message)) {
						$data = json_encode(['valid' => false, 'message' => 'Invalid purchase code. Incorrect data format.']);
						$data = json_decode($data);
					}
					
					// Checking
					if ($data->valid == true) {
						file_put_contents(storage_path('installed'), $data->license_code);
					} else {
						// Invalid purchase code
						dd($data->message);
					}
				}
			}
		}
	}
	
	/**
	 * Check if an update is available
	 *
	 * @return bool
	 */
	private function updateIsAvailable()
	{
		$updateIsAvailable = false;
		
		// Get eventual new version value & the current (installed) version value
		$lastVersionInt = strToInt(config('app.version'));
		$currentVersionInt = strToInt(getCurrentVersion());
		
		// Check the update
		if ($lastVersionInt > $currentVersionInt) {
			$updateIsAvailable = true;
		}
		
		return $updateIsAvailable;
	}
}
