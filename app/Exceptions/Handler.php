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

namespace App\Exceptions;

use App\Helpers\Arr;
use App\Helpers\DBTool;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Prologue\Alerts\Facades\Alert;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		\Illuminate\Auth\AuthenticationException::class,
		\Illuminate\Auth\Access\AuthorizationException::class,
		\Symfony\Component\HttpKernel\Exception\HttpException::class,
		\Illuminate\Database\Eloquent\ModelNotFoundException::class,
		\Illuminate\Session\TokenMismatchException::class,
		\Illuminate\Validation\ValidationException::class,
	];
	
	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];
	
	/**
	 * Illuminate request class.
	 *
	 * @var \Illuminate\Foundation\Application
	 */
	protected $app;
	
	/**
	 * Handler constructor.
	 * @param Container $container
	 */
	public function __construct(Container $container)
	{
		parent::__construct($container);
		
		$this->app = app();
		
		// Fix the 'files' & 'filesystem' binging.
		$this->app->register(\Illuminate\Filesystem\FilesystemServiceProvider::class);
		
		// Create a config var for current language
		$this->getLanguage();
	}
	
	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param Exception $e
	 * @return mixed|void
	 * @throws Exception
	 */
	public function report(Exception $e)
	{
		// Prevent error 500 from PDO Exception
		if ($this->isInstalled()) {
			if ($this->isPDOException($e)) {
				if (($res = $this->testDatabaseConnection()) !== true) {
					die($res);
				}
			}
		} else {
			// Clear PDO error log during installation
			if ($this->isPDOException($e)) {
				$this->clearLog();
			}
		}
		
		parent::report($e);
	}
	
	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param Exception $e
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
	 */
	public function render($request, Exception $e)
	{
		// Show AJAX requests exceptions (for API)
		if ($request->ajax() || $request->wantsJson() || $request->segment(1) == 'api') {
			$json = [
				'success' => false,
				'message' => $e->getMessage(),
				'code'    => $e->getCode(),
			];
			
			return response()->json($json, 400);
		}
		
		// Show HTTP exceptions
		if ($this->isHttpException($e)) {
			return $this->renderHttpException($e);
		}
		
		// Show DB exceptions
		if ($e instanceof \PDOException) {
			/*
			 * DB Connection Error:
			 * http://dev.mysql.com/doc/refman/5.7/en/error-messages-server.html
			 */
			$dbErrorCodes = ['mysql' => ['1042', '1044', '1045', '1046', '1049'], 'standardized' => ['08S01', '42000', '28000', '3D000', '42000', '42S22'],];
			$tableErrorCodes = ['mysql' => ['1051', '1109', '1146'], 'standardized' => ['42S02'],];
			
			// Database errors
			if (in_array($e->getCode(), $dbErrorCodes['mysql']) or in_array($e->getCode(), $dbErrorCodes['standardized'])) {
				$msg = '';
				$msg .= '<html><head><title>SQL Error</title></head><body>';
				$msg .= '<pre>';
				$msg .= '<h3>SQL Error</h3>';
				$msg .= '<br>Code error: ' . $e->getCode() . '.';
				$msg .= '<br><br><blockquote>' . $e->getMessage() . '</blockquote>';
				$msg .= '</pre>';
				$msg .= '</body></html>';
				echo $msg;
				exit();
			}
			
			// Tables and fields errors
			if (in_array($e->getCode(), $tableErrorCodes['mysql']) or in_array($e->getCode(), $tableErrorCodes['standardized'])) {
				$msg = '';
				$msg .= '<html><head><title>Installation - LaraClassified</title></head><body>';
				$msg .= '<pre>';
				$msg .= '<h3>There were errors during the installation process</h3>';
				$msg .= 'Some tables in the database are absent.';
				$msg .= '<br><br><blockquote>' . $e->getMessage() . '</blockquote>';
				$msg .= '<br>1/ Perform the database installation manually with the sql files:';
				$msg .= '<ul>';
				$msg .= '<li><code>/storage/database/schema.sql</code> (required)</li>';
				$msg .= '<li><code>/storage/database/data.sql</code> (required)</li>';
				$msg .= '<li><code>/storage/database/data/geonames/countries/[country_code].sql</code> (required during installation)</li>';
				$msg .= '</ul>';
				$msg .= '<br>2/ Or perform a resettlement:';
				$msg .= '<ul>';
				$msg .= '<li>Delete the installation backup file at: <code>/storage/installed</code> (required before re-installation)</li>';
				$msg .= '<li>and reload this page -or- go to install URL: <a href="' . url('install') . '">' . url('install') . '</a>.</li>';
				$msg .= '</ul>';
				$msg .= '<br>BE CAREFUL: If your site is already in production, you will lose all your data in both cases.';
				$msg .= '</body></html>';
				echo $msg;
				exit();
			}
		}
		
		// Show Token exceptions
		if ($e instanceof TokenMismatchException) {
			$message = t('Your session has expired. Please try again.');
			flash($message)->error(); // front
			Alert::error($message)->flash(); // admin
			if (!str_contains(URL::previous(), 'CsrfToken')) {
				return redirect(URL::previous() . '?error=CsrfToken')->withInput();
			} else {
				return redirect(URL::previous())->withInput();
			}
		}
		
		// Show MethodNotAllowed HTTP exceptions
		if ($e instanceof MethodNotAllowedHttpException) {
			$message = "Opps! Seems you use a bad request method. Please try again.";
			flash($message)->error();
			if (!str_contains(URL::previous(), 'MethodNotAllowed')) {
				return redirect(URL::previous() . '?error=MethodNotAllowed');
			} else {
				return redirect(URL::previous())->withInput();
			}
		}
		
		// Try to fix the cookies issue related the Laravel security release:
		// https://laravel.com/docs/5.6/upgrade#upgrade-5.6.30
		if (str_contains($e->getMessage(), 'unserialize()') && request()->get('exception') != 'unserialize') {
			// Unset cookies
			unsetCookies();
			
			// Customize and Redirect to the previous URL
			$previousUrl = URL::previous();
			$queryString = (parse_url($previousUrl, PHP_URL_QUERY)) ? '&exception=unserialize' : '?exception=unserialize';
			$previousUrl = $previousUrl . $queryString;
			
			return headerLocation($previousUrl);
		}
		
		// Customize the HTTP 500 error page
		// ...
		
		// Original Code
		return parent::render($request, $e);
	}
	
	/**
	 * Convert an authentication exception into an unauthenticated response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Illuminate\Auth\AuthenticationException $exception
	 * @return \Illuminate\Http\Response
	 */
	protected function unauthenticated($request, AuthenticationException $exception)
	{
		if ($request->expectsJson()) {
			return response()->json(['error' => 'Unauthenticated.'], 401);
		}
		
		$loginPath = config('app.locale') . '/' . trans('routes.login');
		
		return redirect()->guest($loginPath);
	}
	
	/**
	 * Convert a validation exception into a JSON response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Illuminate\Validation\ValidationException $exception
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function invalidJson($request, ValidationException $exception)
	{
		return response()->json($exception->errors(), $exception->status);
	}
	
	// PRIVATE METHODS
	
	/**
	 * Check if the app is installed
	 *
	 * @return bool
	 */
	private function isInstalled()
	{
		if (file_exists(base_path('.env')) && file_exists(storage_path('installed'))) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Is a PDO Exception
	 *
	 * @param $e
	 * @return bool
	 */
	private function isPDOException($e)
	{
		if (
			($e instanceof \PDOException) ||
			$e->getCode() == 1045 ||
			str_contains($e->getMessage(), 'SQLSTATE') ||
			str_contains($e->getFile(), 'Database/Connectors/Connector.php')
		) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Test Database Connection
	 *
	 * @return bool|string
	 */
	private function testDatabaseConnection()
	{
		$pdo = DBTool::getPDOConnexion();
		
		if ($pdo instanceof \PDO) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Create a config var for current language
	 */
	private function getLanguage()
	{
		// Get the language only the app is already installed
		// to prevent HTTP 500 error through DB connexion during the installation process.
		if ($this->isInstalled()) {
			try {
				// Get the current language details
				$sql = 'SELECT * FROM ' . DBTool::rawTable('languages') . ' WHERE abbr = "' . config('app.locale') . '" LIMIT 1';
				$query = DBTool::getPDOConnexion()->prepare($sql);
				$query->execute();
				$lang = $query->fetch();
				$lang = Arr::fromObject($lang);
				
				if (!empty($lang)) {
					$this->app['config']->set('lang', $lang);
				} else {
					$this->app['config']->set('lang.abbr', config('app.locale'));
				}
			} catch (\Exception $e) {
				$this->app['config']->set('lang.abbr', config('app.locale'));
			}
		}
	}
	
	/**
	 * Clear Laravel Log files
	 */
	private function clearLog()
	{
		$mask = storage_path('logs') . '/laravel*.log';
		$logFiles = glob($mask);
		if (is_array($logFiles) && !empty($logFiles)) {
			foreach ($logFiles as $filename) {
				@unlink($filename);
			}
		}
	}
}
