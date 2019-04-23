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

use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use League\Flysystem\Adapter\Local;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
	public $data = [];
	
	/**
	 * BackupController constructor.
	 */
	public function __construct()
	{
		$this->middleware('demo.restriction')->except(['index']);
	}
	
	public function index()
	{
		if (!count(config('backup.backup.destination.disks'))) {
			dd(trans('admin::messages.no_disks_configured'));
		}
		
		$this->data['backups'] = [];
		
		foreach (config('backup.backup.destination.disks') as $disk_name) {
			$disk = Storage::disk($disk_name);
			$adapter = $disk->getDriver()->getAdapter();
			$files = $disk->allFiles();
			
			// make an array of backup files, with their filesize and creation date
			foreach ($files as $k => $f) {
				// only take the zip files into account
				if (substr($f, -4) == '.zip' && $disk->exists($f)) {
					$this->data['backups'][] = [
						'file_path'     => $f,
						'file_name'     => str_replace('backups/', '', $f),
						'file_size'     => $disk->size($f),
						'last_modified' => $disk->lastModified($f),
						'disk'          => $disk_name,
						'download'      => ($adapter instanceof Local) ? true : false,
					];
				}
			}
		}
		
		// reverse the backups, so the newest one would be on top
		$this->data['backups'] = array_reverse($this->data['backups']);
		$this->data['title'] = 'Backups';
		
		return view('admin::backup', $this->data);
	}
	
	public function create()
	{
		try {
			ini_set('max_execution_time', 300);
			
			// Get the current version value
			$version = preg_replace('/[^0-9\+]/', '', config('app.version'));
			
			// All backup filename prefix
			Config::set('backup.backup.destination.filename_prefix', 'all-site-v' . $version . '-');
			
			if (request()->filled('type')) {
				// Database backup
				if (request()->get('type') == 'database') {
					Config::set('backup.backup.admin_flags', [
						'--disable-notifications' => true,
						'--only-db'               => true,
					]);
					Config::set('backup.backup.destination.filename_prefix', 'database-v' . $version . '-');
				}
				
				// Languages files backup
				if (request()->get('type') == 'languages') {
					$include = [
						resource_path('lang'),
					];
					$pluginsDirs = glob(config('larapen.core.plugin.path') . '*', GLOB_ONLYDIR);
					if (!empty($pluginsDirs)) {
						foreach ($pluginsDirs as $pluginDir) {
							$pluginLangFolder = $pluginDir . '/resources/lang';
							if (file_exists($pluginLangFolder)) {
								$include[] = $pluginLangFolder;
							}
						}
					}
					
					Config::set('backup.backup.admin_flags', [
						'--disable-notifications' => true,
						'--only-files'            => true,
					]);
					Config::set('backup.backup.source.files.include', $include);
					Config::set('backup.backup.source.files.exclude', [
						//...
					]);
					Config::set('backup.backup.destination.filename_prefix', 'languages-');
				}
				
				// Generated files backup
				if (request()->get('type') == 'files') {
					Config::set('backup.backup.admin_flags', [
						'--disable-notifications' => true,
						'--only-files'            => true,
					]);
					Config::set('backup.backup.source.files.include', [
						base_path('.env'),
						storage_path('app/public'),
						storage_path('installed'),
					]);
					Config::set('backup.backup.source.files.exclude', [
						//...
					]);
					Config::set('backup.backup.destination.filename_prefix', 'files-');
				}
				
				// App files backup
				if (request()->get('type') == 'app') {
					Config::set('backup.backup.admin_flags', [
						'--disable-notifications' => true,
						'--only-files'            => true,
					]);
					Config::set('backup.backup.source.files.include', [
						base_path(),
						base_path('.gitattributes'),
						base_path('.gitignore'),
					]);
					Config::set('backup.backup.source.files.exclude', [
						base_path('node_modules'),
						base_path('.git'),
						base_path('.idea'),
						base_path('.env'),
						base_path('bootstrap/cache') . '/*',
						public_path('robots.txt'),
						storage_path('app/backup-temp'),
						storage_path('app/database'),
						storage_path('app/public/app/categories/custom') . '/*',
						storage_path('app/public/app/ico') . '/*',
						storage_path('app/public/app/logo') . '/*',
						storage_path('app/public/app/page') . '/*',
						storage_path('app/public/files') . '/*',
						storage_path('app/purifier') . '/*',
						storage_path('database/demo'),
						storage_path('backups'),
						storage_path('dotenv-editor') . '/*',
						storage_path('framework/cache') . '/*',
						storage_path('framework/sessions') . '/*',
						storage_path('framework/testing') . '/*',
						storage_path('framework/views') . '/*',
						storage_path('installed'),
						storage_path('laravel-backups'),
						storage_path('logs') . '/*',
					]);
					Config::set('backup.backup.destination.filename_prefix', 'app-v' . $version . '-');
				}
			}
			
			// start the backup process
			$flags = config('backup.backup.admin_flags', false);
			
			try {
				if ($flags) {
					Artisan::call('backup:run', $flags);
				} else {
					Artisan::call('backup:run');
				}
			} catch (\Exception $e) {
				dd($e->getMessage());
			}
			
			$output = Artisan::output();
			
			// log the results
			Log::info("Backup -- new backup started from admin interface \r\n" . $output);
			
			// return the results as a response to the ajax call
			echo $output;
		} catch (Exception $e) {
			Response::make($e->getMessage(), 500);
		}
		
		return 'success';
	}
	
	/**
	 * Downloads a backup zip file.
	 */
	public function download()
	{
		$disk = Storage::disk(Request::input('disk'));
		$file_name = Request::input('file_name');
		$adapter = $disk->getDriver()->getAdapter();
		
		if ($adapter instanceof Local) {
			$storage_path = $disk->getDriver()->getAdapter()->getPathPrefix();
			
			if ($disk->exists($file_name)) {
				return response()->download($storage_path . $file_name);
			} else {
				abort(404, trans('admin::messages.backup_doesnt_exist'));
			}
		} else {
			abort(404, trans('admin::messages.only_local_downloads_supported'));
		}
	}
	
	/**
	 * Deletes a backup file.
	 */
	public function delete($file_name)
	{
		$disk = Storage::disk(Request::input('disk'));
		
		if ($disk->exists($file_name)) {
			$disk->delete($file_name);
			
			return 'success';
		} else {
			abort(404, trans('admin::messages.backup_doesnt_exist'));
		}
	}
}
