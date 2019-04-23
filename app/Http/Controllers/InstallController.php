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

use App\Helpers\Curl;
use App\Helpers\DBTool;
use App\Helpers\Ip;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Date\Date;
use PulkitJalan\GeoIP\Facades\GeoIP;

class InstallController extends Controller
{
	public static $cookieExpiration = 3600;
	public $baseUrl;
	public $installUrl;
	private $phpVersion = '7.1.3';
	
	/**
	 * InstallController constructor.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->commonQueries($request);
			
			return $next($request);
		});
		
		// Create SQL destination path if not exists
		if (!File::exists(storage_path('app/database/geonames/countries'))) {
			File::makeDirectory(storage_path('app/database/geonames/countries'), 0755, true);
		}
		
		// Base URL
		$this->baseUrl = getRawBaseUrl();
		view()->share('baseUrl', $this->baseUrl);
		config(['app.url' => $this->baseUrl]);
		
		// Installation URL
		$this->installUrl = $this->baseUrl . '/install';
		view()->share('installUrl', $this->installUrl);
	}
	
	/**
	 * Common Queries
	 *
	 * @param Request $request
	 */
	public function commonQueries(Request $request)
	{
		// Delete all front&back office sessions
		$request->session()->forget('country_code');
		$request->session()->forget('time_zone');
		$request->session()->forget('language_code');
		
		// Get country code by the user IP address
		$ipCountryCode = $this->getCountryCodeFromIPAddr();
	}
	
	/**
	 * Check for current step
	 *
	 * @param $request
	 * @param null $liveData
	 * @return int
	 */
	public function step($request, $liveData = null)
	{
		$step = 0;
		
		$data = $request->session()->get('compatibilities');
		if (isset($data)) {
			$step = 1;
		} else {
			return $step;
		}
		
		$data = $request->session()->get('site_info');
		if (isset($data)) {
			$step = 3;
		} else {
			return $step;
		}
		
		$data = $request->session()->get('database');
		if (isset($data)) {
			$step = 4;
		} else {
			return $step;
		}
		
		$data = $request->session()->get('database_imported');
		if (isset($data)) {
			$step = 5;
		} else {
			return $step;
		}
		
		$data = $request->session()->get('cron_jobs');
		if (isset($data)) {
			$step = 6;
		} else {
			return $step;
		}
		
		return $step;
	}
	
	/**
	 * STEP 0 - Starting installation
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function starting(Request $request)
	{
		$exitCode = Artisan::call('cache:clear');
		$exitCode = artisanConfigCache();
		$exitCode = Artisan::call('config:clear');
		
		return redirect($this->installUrl . '/system_compatibility');
	}
	
	/**
	 * STEP 1 - Check System Compatibility
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function systemCompatibility(Request $request)
	{
		// Begin check
		$request->session()->forget('compatibilities');
		
		// Get the system compatibilities data
		$compatibilities = $this->getSystemCompatibilitiesData();
		
		// Auto-Checking: Skip this step If the system is Ok.
		if ($this->checkSystemCompatibility($request, $compatibilities)) {
			$request->session()->put('compatibilities', $compatibilities);
			
			return redirect($this->installUrl . '/site_info');
		}
		
		// Check the compatibilities manually
		$result = true;
		foreach ($compatibilities as $compatibility) {
			if (!$compatibility['check']) {
				$result = false;
			}
		}
		
		// Retry if something not work yet
		try {
			if ($result) {
				$request->session()->put('compatibilities', $compatibilities);
			}
			
			return view('install.compatibilities', [
				'compatibilities' => $compatibilities,
				'result'          => $result,
				'step'            => $this->step($request),
				'current'         => 1,
			]);
		} catch (\Exception $e) {
			$exitCode = Artisan::call('cache:clear');
			$exitCode = artisanConfigCache();
			$exitCode = Artisan::call('config:clear');
			
			return redirect($this->installUrl . '/system_compatibility');
		}
	}
	
	/**
	 * STEP 2 - Set Site Info
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function siteInfo(Request $request)
	{
		if ($this->step($request) < 1) {
			return redirect($this->installUrl . '/system_compatibility');
		}
		
		// Make sure session is working
		$rules = [
			'site_name'       => 'required',
			'site_slogan'     => 'required',
			'name'            => 'required',
			'purchase_code'   => 'required',
			'email'           => 'required|email',
			'password'        => 'required',
			'default_country' => 'required',
		];
		$smtp_rules = [
			'smtp_hostname'   => 'required',
			'smtp_port'       => 'required',
			'smtp_username'   => 'required',
			'smtp_password'   => 'required',
			'smtp_encryption' => 'required',
		];
		$mailgun_rules = [
			'mailgun_domain' => 'required',
			'mailgun_secret' => 'required',
		];
		$mandrill_rules = [
			'mandrill_secret' => 'required',
		];
		$ses_rules = [
			'ses_key'    => 'required',
			'ses_secret' => 'required',
			'ses_region' => 'required',
		];
		$sparkpost_rules = [
			'sparkpost_secret' => 'required',
		];
		
		// Validate and save posted data
		if ($request->isMethod('post')) {
			$request->session()->forget('site_info');
			
			// Check purchase code
			$messages = [];
			$purchase_code_data = $this->purchaseCodeChecker($request);
			if ($purchase_code_data->valid == false) {
				$rules['purchase_code_valid'] = 'required';
				if ($purchase_code_data->message != '') {
					$messages = ['purchase_code_valid.required' => 'The :attribute field is required. ERROR: <strong>' . $purchase_code_data->message . '</strong>'];
				}
			}
			
			if ($request->mail_driver == 'smtp') {
				$rules = array_merge($rules, $smtp_rules);
			}
			if ($request->mail_driver == 'mailgun') {
				$rules = array_merge($rules, $mailgun_rules);
			}
			if ($request->mail_driver == 'mandrill') {
				$rules = array_merge($rules, $mandrill_rules);
			}
			if ($request->mail_driver == 'ses') {
				$rules = array_merge($rules, $ses_rules);
			}
			if ($request->mail_driver == 'sparkpost') {
				$rules = array_merge($rules, $sparkpost_rules);
			}
			
			if (!empty($messages)) {
				$this->validate($request, $rules, $messages);
			} else {
				$this->validate($request, $rules);
			}
			
			// Check SMTP connection
			if ($request->mail_driver == 'smtp') {
				$rules = [];
				$messages = [];
				try {
					$transport = new \Swift_SmtpTransport($request->smtp_hostname, $request->smtp_port, $request->smtp_encryption);
					$transport->setUsername($request->smtp_username);
					$transport->setPassword($request->smtp_password);
					$mailer = new \Swift_Mailer($transport);
					$mailer->getTransport()->start();
				} catch (\Swift_TransportException $e) {
					$rules['smtp_valid'] = 'required';
					if ($e->getMessage() != '') {
						$messages = ['smtp_valid.required' => 'Can\'t connect to SMTP server. ERROR: <strong>' . $e->getMessage() . '</strong>'];
					}
				} catch (\Exception $e) {
					$rules['smtp_valid'] = 'required';
					if ($e->getMessage() != '') {
						$messages = ['smtp_valid.required' => 'Can\'t connect to SMTP server. ERROR: <strong>' . $e->getMessage() . '</strong>'];
					}
				}
				if (!empty($messages)) {
					$this->validate($request, $rules, $messages);
				} else {
					$this->validate($request, $rules);
				}
			}
			
			// Save data in session
			$siteInfo = $request->all();
			$request->session()->put('site_info', $siteInfo);
			
			return redirect($this->installUrl . '/database');
		}
		
		$siteInfo = $request->session()->get('site_info');
		if (!empty($request->old())) {
			$siteInfo = $request->old();
		}
		
		return view('install.site_info', [
			'site_info'       => $siteInfo,
			'rules'           => $rules,
			'smtp_rules'      => $smtp_rules,
			'mailgun_rules'   => $mailgun_rules,
			'mandrill_rules'  => $mandrill_rules,
			'ses_rules'       => $ses_rules,
			'sparkpost_rules' => $sparkpost_rules,
			'step'            => $this->step($request),
			'current'         => 2,
		]);
	}
	
	/**
	 * STEP 3 - Database configuration
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function database(Request $request)
	{
		if ($this->step($request) < 2) {
			return redirect($this->installUrl . '/site_info');
		}
		
		// Check required fields
		$rules = [
			'host'       => 'required',
			'port'       => 'required',
			'username'   => 'required',
			//'password' => 'required', // Comment this line for local server
			'database'   => 'required',
		];
		
		// Validate and save posted data
		if ($request->isMethod('post')) {
			$request->session()->forget('database');
			
			$this->validate($request, $rules);
			
			// Check the Database Connection
			$messages = [];
			try {
				// Database Parameters
				$driver = config('database.connections.' . config('database.default') . '.driver', 'mysql');
				$port = (int)$request->port;
				$options = [
					\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
					\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
					\PDO::ATTR_EMULATE_PREPARES   => true,
					\PDO::ATTR_CURSOR             => \PDO::CURSOR_FWDONLY,
				];
				
				// Get the Connexion's DSN
				if (empty($request->socket)) {
					$dsn = $driver . ':host=' . $request->host . ';port=' . $port . ';dbname=' . $request->database . ';charset=utf8';
				} else {
					$dsn = $driver . ':unix_socket=' . $request->socket . ';dbname=' . $request->database . ';charset=utf8';
				}
				
				// Connect to the Database Server
				$pdo = new \PDO($dsn, $request->username, $request->password, $options);
				
			} catch (\PDOException $e) {
				$rules['database_connection'] = 'required';
				$messages = ['database_connection.required' => 'Can\'t connect to the database server. ERROR: <strong>' . $e->getMessage() . '</strong>'];
			} catch (\Exception $e) {
				$rules['database_connection'] = 'required';
				$messages = ['database_connection.required' => 'The database connection failed. ERROR: <strong>' . $e->getMessage() . '</strong>'];
			}
			
			if (!empty($messages)) {
				$this->validate($request, $rules, $messages);
			} else {
				$this->validate($request, $rules);
			}
			
			// Get database info and Save it in session
			$database = $request->all();
			$request->session()->put('database', $database);
			
			// Write config file
			$this->writeEnv($request);
			
			// Return to Import Database page
			return redirect($this->installUrl . '/database_import');
		}
		
		$database = $request->session()->get('database');
		if (!empty($request->old())) {
			$database = $request->old();
		}
		
		return view('install.database', [
			'database' => $database,
			'rules'    => $rules,
			'step'     => $this->step($request),
			'current'  => 3,
		]);
	}
	
	/**
	 * STEP 4 - Import Database
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function databaseImport(Request $request)
	{
		if ($this->step($request) < 3) {
			return redirect($this->installUrl . '/database');
		}
		
		// Get database connexion info & site info
		$database = $request->session()->get('database');
		$siteInfo = $request->session()->get('site_info');
		
		if ($request->action == 'import') {
			$request->session()->forget('database_imported');
			
			// Get PDO connexion
			$pdo = DBTool::getPDOConnexion($database);
			
			// Check if database is not empty
			$rules = [];
			$tableNames = $this->getDatabaseTables($pdo, $database);
			if (count($tableNames) > 0) {
				// 1. Drop all old tables
				$this->dropExistingTables($pdo, $tableNames);
				
				// 2. Check if all table are dropped (Check if database's tables still exist)
				$tablesExist = false;
				$tableNames = $this->getDatabaseTables($pdo, $database);
				if (count($tableNames) > 0) {
					$tablesExist = true;
				}
				
				if ($tablesExist) {
					$rules['database_not_empty'] = 'required';
					$rules['can_not_empty_database'] = 'required';
				}
				
				// 3. Validation
				$this->validate($request, $rules);
			}
			
			// Import database with prefix
			$this->importDatabase($pdo, $database['prefix'], $siteInfo);
			
			// Close PDO connexion
			DBTool::closePDOConnexion($pdo);
			
			// The database is now imported !
			$request->session()->put('database_imported', true);
			
			$request->session()->flash('alert-success', trans('messages.install.database_import.success'));
			
			return redirect($this->installUrl . '/cron_jobs');
		}
		
		return view('install.database_import', [
			'database' => $database,
			'step'     => $this->step($request),
			'current'  => 3,
		]);
	}
	
	/**
	 * STEP 5 - Set Cron Jobs
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function cronJobs(Request $request)
	{
		if ($this->step($request) < 5) {
			return redirect($this->installUrl . '/database');
		}
		
		$request->session()->put('cron_jobs', true);
		
		return view('install.cron_jobs', [
			'step'    => $this->step($request),
			'current' => 5,
		]);
	}
	
	/**
	 * STEP 6 - Finish
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function finish(Request $request)
	{
		if ($this->step($request) < 6) {
			return redirect($this->installUrl . '/database');
		}
		
		$request->session()->put('install_finish', true);
		
		// Delete all front&back office cookies
		if (isset($_COOKIE['ip_country_code'])) {
			unset($_COOKIE['ip_country_code']);
		}
		
		// Clear all Cache
		$exitCode = Artisan::call('cache:clear');
		sleep(2);
		$exitCode = Artisan::call('view:clear');
		sleep(1);
		File::delete(File::glob(storage_path('logs') . '/laravel*.log'));
		
		// Rendering final Info
		return view('install.finish', [
			'step'    => $this->step($request),
			'current' => 6,
		]);
	}
	
	
	
	// PRIVATE METHODS
	
	
	
	/**
	 * Get the system compatibilities data
	 *
	 * @return array
	 */
	private function getSystemCompatibilitiesData()
	{
		return [
			[
				'type'  => 'requirement',
				'name'  => 'PHP version',
				'check' => version_compare(PHP_VERSION, $this->phpVersion, '>='),
				'note'  => 'PHP ' . $this->phpVersion . ' or higher is required.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'OpenSSL Extension',
				'check' => extension_loaded('openssl'),
				'note'  => 'OpenSSL PHP Extension is required.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'Mbstring PHP Extension',
				'check' => extension_loaded('mbstring'),
				'note'  => 'Mbstring PHP Extension is required.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'PDO PHP Extension',
				'check' => extension_loaded('pdo'),
				'note'  => 'PDO PHP Extension is required.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'Tokenizer PHP Extension',
				'check' => extension_loaded('tokenizer'),
				'note'  => 'Tokenizer PHP Extension is required.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'XML PHP Extension',
				'check' => extension_loaded('xml'),
				'note'  => 'XML PHP Extension is required.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'PHP Fileinfo Extension',
				'check' => extension_loaded('fileinfo'),
				'note'  => 'PHP Fileinfo Extension is required.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'PHP GD Library',
				'check' => (extension_loaded('gd') && function_exists('gd_info')),
				'note'  => 'PHP GD Library is required.',
			],
			[
				'type' => 'requirement',
				'name' => 'escapeshellarg()',
				'check' => func_enabled('escapeshellarg'),
				'note' => 'escapeshellarg() must be enabled.',
			],
			[
				'type'  => 'permission',
				'name'  => 'bootstrap/cache/',
				'check' => file_exists(base_path('bootstrap/cache')) &&
					is_dir(base_path('bootstrap/cache')) &&
					(is_writable(base_path('bootstrap/cache'))) &&
					getPerms(base_path('bootstrap/cache')) >= 755,
				'note'  => 'The directory must be writable by the web server (0755).',
			],
			[
				'type'  => 'permission',
				'name'  => 'storage/',
				'check' => (file_exists(storage_path('/')) &&
					is_dir(storage_path('/')) &&
					(is_writable(storage_path('/'))) &&
					getPerms(storage_path('/')) >= 755),
				'note'  => 'The directory must be writable (recursively) by the web server (0755).',
			],
		];
	}
	
	/**
	 * Check for requirement when install app (Automatic)
	 *
	 * @param $request
	 * @param $compatibilities
	 * @return bool
	 */
	private function checkSystemCompatibility($request, $compatibilities)
	{
		if ($request->has('mode') && $request->input('mode') == 'manual') {
			return false;
		}
		
		// Check Default Compatibilities
		$defaultCompatibilityTest = true;
		foreach ($compatibilities as $compatibility) {
			if (!$compatibility['check']) {
				$defaultCompatibilityTest = false;
			}
		}
		
		// Check Additional Directories Permissions
		$additionalPermissionsAreOk = false;
		if (
			(file_exists(storage_path('app/public/app')) &&
				is_dir(storage_path('app/public/app')) &&
				(is_writable(storage_path('app/public/app'))) &&
				getPerms(storage_path('app/public/app')) >= 755)
			&&
			(file_exists(storage_path('app/public/app/categories/custom')) &&
				is_dir(storage_path('app/public/app/categories/custom')) &&
				(is_writable(storage_path('app/public/app/categories/custom'))) &&
				getPerms(storage_path('app/public/app/categories/custom')) >= 755)
			&&
			(file_exists(storage_path('app/public/app/logo')) &&
				is_dir(storage_path('app/public/app/logo')) &&
				(is_writable(storage_path('app/public/app/logo'))) &&
				getPerms(storage_path('app/public/app/logo')) >= 755)
			&&
			(file_exists(storage_path('app/public/app/page')) &&
				is_dir(storage_path('app/public/app/page')) &&
				(is_writable(storage_path('app/public/app/page'))) &&
				getPerms(storage_path('app/public/app/page')) >= 755)
			&&
			(file_exists(storage_path('app/public/files')) &&
				is_dir(storage_path('app/public/files')) &&
				(is_writable(storage_path('app/public/files'))) &&
				getPerms(storage_path('app/public/files')) >= 755)
		)
		{
			$additionalPermissionsAreOk = true;
		}
		
		$allIsReady = $defaultCompatibilityTest && $additionalPermissionsAreOk;
		
		return $allIsReady;
	}
	
	/**
	 * @return string
	 */
	private function checkServerVar()
	{
		$vars = ['HTTP_HOST', 'SERVER_NAME', 'SERVER_PORT', 'SCRIPT_NAME', 'SCRIPT_FILENAME', 'PHP_SELF', 'HTTP_ACCEPT', 'HTTP_USER_AGENT'];
		$missing = [];
		foreach ($vars as $var) {
			if (!isset($_SERVER[$var])) {
				$missing[] = $var;
			}
		}
		
		if (!empty($missing)) {
			return '$_SERVER does not have: ' . implode(', ', $missing);
		}
		
		if (!isset($_SERVER['REQUEST_URI']) && isset($_SERVER['QUERY_STRING'])) {
			return 'Either $_SERVER["REQUEST_URI"] or $_SERVER["QUERY_STRING"] must exist.';
		}
		
		if (!isset($_SERVER['PATH_INFO']) && strpos($_SERVER['PHP_SELF'], $_SERVER['SCRIPT_NAME']) !== 0) {
			return 'Unable to determine URL path info. Please make sure $_SERVER["PATH_INFO"] (or $_SERVER["PHP_SELF"] and $_SERVER["SCRIPT_NAME"]) contains proper value.';
		}
		
		return '';
	}
	
	/**
	 * Write configuration values to file
	 *
	 * @param $request
	 */
	private function writeEnv($request)
	{
		// Get .env file path
		$filePath = base_path('.env');
		
		// Remove the old .env file (If exists)
		if (File::exists($filePath)) {
			File::delete($filePath);
		}
		
		// Set app key
		$key = 'base64:' . base64_encode($this->randomString(32));
		$key = config('app.key', $key);
		
		// Get app host
		$appHost = getHostByUrl($this->baseUrl);
		
		// Get app version
		$version = config('app.version');
		
		// Get database & site info
		$database = $request->session()->get('database');
		$siteInfo = $request->session()->get('site_info');
		
		// Generate .env file content
		$content = '';
		$content .= 'APP_ENV=production' . "\n";
		$content .= 'APP_KEY=' . $key . "\n";
		$content .= 'APP_DEBUG=false' . "\n";
		$content .= 'APP_URL=' . $this->baseUrl . "\n";
		$content .= 'APP_LOCALE=en' . "\n";
		$content .= 'APP_VERSION=' . $version . "\n";
		$content .= "\n";
		$content .= 'PURCHASE_CODE=' . (isset($siteInfo['purchase_code']) ? $siteInfo['purchase_code'] : '') . "\n";
		$content .= 'FORCE_HTTPS=false' . "\n";
		$content .= "\n";
		$content .= 'DB_HOST=' . (isset($database['host']) ? $database['host'] : '') . "\n";
		$content .= 'DB_PORT=' . (isset($database['port']) ? $database['port'] : '') . "\n";
		$content .= 'DB_DATABASE=' . (isset($database['database']) ? $database['database'] : '') . "\n";
		$content .= 'DB_USERNAME=' . (isset($database['username']) ? $database['username'] : '') . "\n";
		$content .= 'DB_PASSWORD=' . (isset($database['password']) ? $database['password'] : '') . "\n";
		$content .= 'DB_SOCKET=' . (isset($database['socket']) ? $database['socket'] : '') . "\n";
		$content .= 'DB_TABLES_PREFIX=' . (isset($database['prefix']) ? $database['prefix'] : '') . "\n";
		$content .= 'DB_CHARSET=utf8' . "\n";
		$content .= 'DB_COLLATION=utf8_unicode_ci' . "\n";
		$content .= 'DB_DUMP_BINARY_PATH=' . "\n";
		$content .= "\n";
		$content .= 'IMAGE_DRIVER=gd' . "\n";
		$content .= "\n";
		$content .= 'CACHE_DRIVER=file' . "\n";
		$content .= 'CACHE_PREFIX=lc_' . "\n";
		$content .= 'QUEUE_CONNECTION=sync' . "\n";
		$content .= 'SESSION_DRIVER=file' . "\n";
		$content .= 'SESSION_LIFETIME=10080' . "\n";
		$content .= "\n";
		$content .= 'LOG_CHANNEL=daily' . "\n";
		$content .= 'LOG_LEVEL=debug' . "\n";
		$content .= 'LOG_DAYS=2' . "\n";
		$content .= "\n";
		$content .= 'FORM_REGISTER_HIDE_PHONE=false' . "\n";
		$content .= 'FORM_REGISTER_HIDE_EMAIL=false' . "\n";
		$content .= 'FORM_REGISTER_HIDE_USERNAME=true' . "\n";
		
		// Save the new .env file
		File::put($filePath, $content);
		
		// Reload .env (related to the config values)
		$exitCode = artisanConfigCache();
		$exitCode = Artisan::call('config:clear');
	}
	
	/**
	 * Drop All Existing Tables
	 *
	 * @param $pdo
	 * @param $tableNames
	 */
	private function dropExistingTables($pdo, $tableNames)
	{
		if (is_array($tableNames) && count($tableNames) > 0) {
			// Try 4 times
			$try = 5;
			while ($try > 0) {
				// Extend query max setting
				$pdo->exec('FLUSH TABLES;');
				$pdo->exec('SET group_concat_max_len = 9999999;');
				
				// Drop all tables
				$pdo->exec("SET foreign_key_checks = 0;");
				foreach ($tableNames as $tableName) {
					if ($this->tableExists($pdo, $tableName)) {
						$pdo->exec("DROP TABLE $tableName;");
					}
				}
				$pdo->exec("SET foreign_key_checks = 1;");
				
				$pdo->exec('FLUSH TABLES;');
				
				$try--;
			}
		}
	}
	
	/**
	 * Import Database - Migration & Seed
	 *
	 * @param $pdo
	 * @param $tablesPrefix
	 * @param $siteInfo
	 * @return bool
	 */
	private function importDatabase($pdo, $tablesPrefix, $siteInfo)
	{
		// Import database schema
		$this->importSchemaSql($pdo, $tablesPrefix);
		
		// Import required data
		$this->importRequiredDataSql($pdo, $tablesPrefix);
		
		// Import Geonames Default country database
		$this->importGeonamesSql($pdo, $tablesPrefix, $siteInfo['default_country']);
		
		// Update database with customer info
		$this->updateDatabase($pdo, $tablesPrefix, $siteInfo);
		
		return true;
	}
	
	/**
	 * Import Database's Schema
	 *
	 * @param $pdo
	 * @param $tablesPrefix
	 * @return bool
	 */
	private function importSchemaSql($pdo, $tablesPrefix)
	{
		// Default Schema SQL file
		$filename = 'database/schema.sql';
		$filePath = storage_path($filename);
		
		// Import the SQL file
		$res = DBTool::importSqlFile($pdo, $filePath, $tablesPrefix);
		if ($res === false) {
			dd('ERROR');
		}
		
		return $res;
	}
	
	/**
	 * Import Database's Required Data
	 *
	 * @param $pdo
	 * @param $tablesPrefix
	 * @return bool
	 */
	private function importRequiredDataSql($pdo, $tablesPrefix)
	{
		// Default Required Data SQL file
		$filename = 'database/data.sql';
		$filePath = storage_path($filename);
		
		// Import the SQL file
		$res = DBTool::importSqlFile($pdo, $filePath, $tablesPrefix);
		if ($res === false) {
			dd('ERROR');
		}
		
		return $res;
	}
	
	/**
	 * Import the Default Country Data from the Geonames SQL Files
	 *
	 * @param $pdo
	 * @param $tablesPrefix
	 * @param $defaultCountryCode
	 * @return bool
	 */
	private function importGeonamesSql($pdo, $tablesPrefix, $defaultCountryCode)
	{
		// Default Country SQL file
		$filename = 'database/geonames/countries/' . strtolower($defaultCountryCode) . '.sql';
		$filePath = storage_path($filename);
		
		// Import the SQL file
		$res = DBTool::importSqlFile($pdo, $filePath, $tablesPrefix);
		if ($res === false) {
			dd('ERROR');
		}
		
		return $res;
	}
	
	/**
	 * Update the Database with the Site Information
	 *
	 * @param $pdo
	 * @param $tablesPrefix
	 * @param $siteInfo
	 */
	private function updateDatabase($pdo, $tablesPrefix, $siteInfo)
	{
		// Default date
		$date = Date::now();
		
		try {
			
			// USERS - Insert default superuser
			$pdo->exec('DELETE FROM `' . $tablesPrefix . 'users` WHERE 1');
			$sql = 'INSERT INTO `' . $tablesPrefix . 'users`
				(`id`, `country_code`, `user_type_id`, `gender_id`, `name`, `about`, `email`, `password`, `is_admin`, `verified_email`, `verified_phone`)
				VALUES (1, :countryCode, 1, 1, :name, "Administrator", :email, :password, 1, 1, 1);';
			$query = $pdo->prepare($sql);
			$res = $query->execute([
				':countryCode' => $siteInfo['default_country'],
				':name'        => $siteInfo['name'],
				':email'       => $siteInfo['email'],
				':password'    => Hash::make($siteInfo['password']),
			]);
			
			// Setup ACL system
			$this->setupAclSystem();
			
			// COUNTRIES - Activate default country
			$sql = 'UPDATE `' . $tablesPrefix . 'countries` SET `active`=1 WHERE `code`=:countryCode';
			$query = $pdo->prepare($sql);
			$res = $query->execute([
				':countryCode' => $siteInfo['default_country'],
			]);
			
			// SETTINGS - Update settings
			// App
			$appSettings = [
				'purchase_code' => isset($siteInfo['purchase_code']) ? $siteInfo['purchase_code'] : '',
				'name'          => isset($siteInfo['site_name']) ? $siteInfo['site_name'] : '',
				'slogan'        => isset($siteInfo['site_slogan']) ? $siteInfo['site_slogan'] : '',
				'email'         => isset($siteInfo['email']) ? $siteInfo['email'] : '',
			];
			$sql = 'UPDATE `' . $tablesPrefix . 'settings` SET `value`=:appSettings WHERE `key`="app"';
			$query = $pdo->prepare($sql);
			$res = $query->execute([
				':appSettings' => json_encode($appSettings),
			]);
			
			// Geo Location
			$geoLocationSettings = [
				'default_country_code' => isset($siteInfo['default_country']) ? $siteInfo['default_country'] : '',
			];
			$sql = 'UPDATE `' . $tablesPrefix . 'settings` SET `value`=:geoLocationSettings WHERE `key`="geo_location"';
			$query = $pdo->prepare($sql);
			$res = $query->execute([
				':geoLocationSettings' => json_encode($geoLocationSettings),
			]);
			
			// Mail
			$mailSettings = [
				'email_sender' => isset($siteInfo['email']) ? $siteInfo['email'] : '',
				'driver'       => isset($siteInfo['mail_driver']) ? $siteInfo['mail_driver'] : '',
			];
			if (isset($siteInfo['mail_driver'])) {
				if (in_array($siteInfo['mail_driver'], ['smtp', 'mailgun', 'mandrill', 'ses', 'sparkpost'])) {
					$mailSettings['host'] = isset($siteInfo['smtp_hostname']) ? $siteInfo['smtp_hostname'] : '';
					$mailSettings['port'] = isset($siteInfo['smtp_port']) ? $siteInfo['smtp_port'] : '';
					$mailSettings['encryption'] = isset($siteInfo['smtp_encryption']) ? $siteInfo['smtp_encryption'] : '';
					$mailSettings['username'] = isset($siteInfo['smtp_username']) ? $siteInfo['smtp_username'] : '';
					$mailSettings['password'] = isset($siteInfo['smtp_password']) ? $siteInfo['smtp_password'] : '';
				}
				if ($siteInfo['mail_driver'] == 'mailgun') {
					$mailSettings['mailgun_domain'] = isset($siteInfo['mailgun_domain']) ? $siteInfo['mailgun_domain'] : '';
					$mailSettings['mailgun_secret'] = isset($siteInfo['mailgun_secret']) ? $siteInfo['mailgun_secret'] : '';
				}
				if ($siteInfo['mail_driver'] == 'mandrill') {
					$mailSettings['mandrill_secret'] = isset($siteInfo['mandrill_secret']) ? $siteInfo['mandrill_secret'] : '';
				}
				if ($siteInfo['mail_driver'] == 'ses') {
					$mailSettings['ses_key'] = isset($siteInfo['ses_key']) ? $siteInfo['ses_key'] : '';
					$mailSettings['ses_secret'] = isset($siteInfo['ses_secret']) ? $siteInfo['ses_secret'] : '';
					$mailSettings['ses_region'] = isset($siteInfo['ses_region']) ? $siteInfo['ses_region'] : '';
				}
				if ($siteInfo['mail_driver'] == 'sparkpost') {
					$mailSettings['sparkpost_secret'] = isset($siteInfo['sparkpost_secret']) ? $siteInfo['sparkpost_secret'] : '';
				}
			}
			$sql = 'UPDATE `' . $tablesPrefix . 'settings` SET `value`=:mailSettings WHERE `key`="mail"';
			$query = $pdo->prepare($sql);
			$res = $query->execute([
				':mailSettings' => json_encode($mailSettings),
			]);
			
		} catch (\PDOException $e) {
			dd($e->getMessage());
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	}
	
	/**
	 * Setup ACL system
	 */
	private function setupAclSystem()
	{
		// Check & Fix the default Permissions
		if (!Permission::checkDefaultPermissions()) {
			Permission::resetDefaultPermissions();
		}
	}
	
	/**
	 * Get all the database tables
	 *
	 * @param $pdo
	 * @param $database
	 * @return array
	 */
	private function getDatabaseTables($pdo, $database)
	{
		$tables = [];
		
		$prefixChecker = !empty($database['prefix']) ? '  AND table_name LIKE "' . $database['prefix'] . '%"' : '';
		$sql = 'SELECT GROUP_CONCAT(table_name) AS table_names
				FROM information_schema.tables
                WHERE table_schema = "' . $database['database'] . '"' . $prefixChecker;
		$query = $pdo->query($sql);
		$databaseSchemaInfo = $query->fetch();
		if (isset($databaseSchemaInfo->table_names)) {
			$tables = array_merge($tables, explode(',', $databaseSchemaInfo->table_names));
		}
		
		return $tables;
	}
	
	/**
	 * Check if a table exists in the current database.
	 *
	 * @param $pdo
	 * @param $table
	 * @return bool
	 */
	private function tableExists($pdo, $table)
	{
		// Try a select statement against the table
		// Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
		try {
			$result = $pdo->query('SELECT 1 FROM ' . $table . ' LIMIT 1');
		} catch (\Exception $e) {
			// We got an exception == table not found
			return false;
		}
		
		// Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
		return $result !== false;
	}
	
	/**
	 * @return bool|string
	 */
	private static function getCountryCodeFromIPAddr()
	{
		if (isset($_COOKIE['ip_country_code'])) {
			$countryCode = $_COOKIE['ip_country_code'];
		} else {
			// Localize the user's country
			try {
				$ipAddr = Ip::get();
				
				GeoIP::setIp($ipAddr);
				$countryCode = GeoIP::getCountryCode();
				
				if (!is_string($countryCode) or strlen($countryCode) != 2) {
					return null;
				}
			} catch (\Exception $e) {
				return null;
			}
			
			// Set data in cookie
			if (isset($_COOKIE['ip_country_code'])) {
				unset($_COOKIE['ip_country_code']);
			}
			setcookie('ip_country_code', $countryCode);
		}
		
		return $countryCode;
	}
	
	/**
	 * IMPORTANT: Do not change this part of the code to prevent any data losing issue.
	 *
	 * @param Request $request
	 * @return mixed|string
	 */
	private function purchaseCodeChecker(Request $request)
	{
		$apiUrl = config('larapen.core.purchaseCodeCheckerUrl') . $request->purchase_code . '&item_id=' . config('larapen.core.itemId');
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
		
		return $data;
	}
	
	/**
	 * @param int $length
	 * @return string
	 */
	private function randomString($length = 6)
	{
		$str = "";
		$characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		
		return $str;
	}
}
