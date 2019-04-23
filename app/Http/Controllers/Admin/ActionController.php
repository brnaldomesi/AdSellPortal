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

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Larapen\Admin\app\Http\Controllers\Controller;
use Prologue\Alerts\Facades\Alert;

class ActionController extends Controller
{
	/**
	 * ActionController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('demo.restriction');
	}
	
	/**
	 * Clear Cache
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function clearCache()
	{
		$errorFound = false;
		
		if (session()->has('curr')) {
			session()->forget('curr');
		}
		
		// Removing all Objects Cache
		try {
			$exitCode = Artisan::call('cache:clear');
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Some time of pause
		sleep(2);
		
		// Removing all Views Cache
		try {
			$exitCode = Artisan::call('view:clear');
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Some time of pause
		sleep(1);
		
		// Removing all Logs
		try {
			File::delete(File::glob(storage_path('logs') . '/laravel*.log'));
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Removing all /.env cached files
		try {
			DotenvEditor::deleteBackups();
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Check if error occurred
		if (!$errorFound) {
			$message = trans("admin::messages.The cache was successfully dumped.");
			Alert::success($message)->flash();
		}
		
		return redirect()->back();
	}
	
	/**
	 * Test the Ads Cleaner Command
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function callAdsCleanerCommand()
	{
		$errorFound = false;
		
		// Run the Cron Job command manually
		try {
			$exitCode = Artisan::call('ads:clear');
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Check if error occurred
		if (!$errorFound) {
			$message = trans("admin::messages.The Ads Clear command was successfully run.");
			Alert::success($message)->flash();
		}
		
		return redirect()->back();
	}
	
	/**
	 * Put to maintenance Mode
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function maintenanceDown(Request $request)
	{
		// Form validation
		$rules = [
			'message' => 'max:200',
		];
		$this->validate($request, $rules);
		
		$errorFound = false;
		
		// Go to maintenance with DOWN status
		try {
			if ($request->has('message')) {
				$exitCode = Artisan::call('down', ['--message' => $request->input('message')]);
			} else {
				$exitCode = Artisan::call('down');
			}
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Check if error occurred
		if (!$errorFound) {
			$message = trans("admin::messages.The website has been putted in maintenance mode.");
			Alert::success($message)->flash();
		}
		
		return redirect()->back();
	}
	
	/**
	 * Back to Maintenance Mode
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function maintenanceUp()
	{
		$errorFound = false;
		
		// Restore system UP status
		try {
			$exitCode = Artisan::call('up');
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Check if error occurred
		if (!$errorFound) {
			$message = trans("admin::messages.The website has left the maintenance mode.");
			Alert::success($message)->flash();
		}
		
		return redirect()->back();
	}
}
