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

class XSSProtection
{
	/**
	 * The following method loops through all request input and strips out all tags from
	 * the request. This to ensure that users are unable to set ANY HTML within the form
	 * submissions, but also cleans up input.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (request()->segment(1) == admin_uri()) {
			try {
				if (!Schema::hasTable('permissions')) {
					return $next($request);
				}
			} catch (\Exception $e) {
				return $next($request);
			}
			
			if (auth()->check() && auth()->user()->can(Permission::getStaffPermissions())) {
				return $next($request);
			}
		}
		
		// Get all fields values
		$input = $request->all();
		
		// Remove all HTML tags in the fields values
		// Except fields: description
		array_walk_recursive($input, function (&$input, $key) use ($request) {
			if (!in_array($key, ['description'])) {
				if (!empty($input)) {
					$input = strip_tags($input);
				}
			}
		});
		
		// Replace the fields values
		$request->merge($input);
		
		return $next($request);
	}
}
