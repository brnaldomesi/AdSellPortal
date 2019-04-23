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

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Support\Facades\Schema;
use Prologue\Alerts\Facades\Alert;

class Clearance
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		try {
			if (!Schema::hasTable('permissions')) {
				return $next($request);
			}
		} catch (\Exception $e) {
			return $next($request);
		}
		
		// If user has this //permission
		if (userHasSuperAdminPermissions()) {
			return $next($request);
		}
		
		// Get all routes that have permissions
		$routesPermissions = Permission::getRoutesPermissions();
		if (!empty($routesPermissions)) {
			foreach ($routesPermissions as $key => $route) {
				if (!isset($route['uri']) || !isset($route['permission']) || !isset($route['methods'])) {
					continue;
				}
				
				// If the current route found, ...
				if ($request->is($route['uri']) && in_array($request->method(), $route['methods'])) {
					
					// Check if user has permission to perform this action
					if (!auth()->user()->can($route['permission'])) {
						// abort('401');
						if ($request->ajax() || $request->wantsJson()) {
							return response(trans('admin::messages.unauthorized'), 401);
						} else {
							Alert::error(trans('admin::messages.unauthorized'))->flash();
							
							return redirect()->back();
						}
					}
					
				}
			}
		}
		
		return $next($request);
	}
}
