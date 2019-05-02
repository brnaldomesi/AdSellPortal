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

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		\App\Console\Commands\Inspire::class,
		\App\Console\Commands\AdsClear::class,
	];
	
	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		// Clear Ads
		$schedule->command('ads:clear')->hourly();
		
		// Clear Cache & Views
		if (!env('DISABLE_CACHE_AUTO_CLEAR') || (int)env('DISABLE_CACHE_AUTO_CLEAR', 0) != 1) {
			$schedule->command('cache:clear')->weeklyOn(7, '6:00');
			$schedule->command('cache:clear')->weeklyOn(7, '6:05'); // To prevent file lock issues (Optional)
			$schedule->command('view:clear')->weeklyOn(7, '6:00');
		}
	}
	
	/**
	 * Register the Closure based commands for the application.
	 *
	 * @return void
	 */
	protected function commands()
	{
		require base_path('routes/console.php');
	}
}
