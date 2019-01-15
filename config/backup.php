<?php

return [
	
	'backup' => [
		
		/* --------------------------------------
		 * Backup Command Flags
		 * --------------------------------------
		 * These flags will be attached every time a backup is triggered
		 * By default only notifications are disabled.
		 *
		 * https://docs.spatie.be/laravel-backup/v4/taking-backups/overview
		 * --only-to-disk=name-of-your-disk
		 * --only-db
		 * --only-files
		 * --disable-notifications
		 */
		'admin_flags' => [
			'--disable-notifications' => true,
		],
		
		/*
		 * The name of this application. You can use this name to monitor
		 * the backups.
		 */
		'name' => preg_replace('#http[^:]*://#ui', '', env('APP_URL')),
		
		'source' => [
			
			'files' => [
				
				/*
				 * The list of directories that should be part of the backup. You can
				 * specify individual files as well.
				 */
				'include' => [
					base_path(),
					base_path('.gitattributes'),
					base_path('.gitignore'),
				],
				
				/*
				 * These directories will be excluded from the backup.
				 * You can specify individual files as well.
				 */
				'exclude' => [
					base_path('node_modules'),
					base_path('.git'),
					base_path('.idea'),
					base_path('bootstrap/cache') . '/*',
					storage_path('app/backup-temp'),
					storage_path('backups'),
					storage_path('framework/cache') . '/*',
					storage_path('framework/sessions') . '/*',
					storage_path('framework/testing') . '/*',
					storage_path('framework/views') . '/*',
				],
				
				/*
				 * Determines if symlinks should be followed.
				 */
				'followLinks' => false,
			],
			
			/*
			 * The names of the connections to the databases that should be part of the backup.
			 * Currently only MySQL- and PostgreSQL-databases are supported.
			 */
			'databases' => [
				'mysql',
			],
		],
		
		/*
		 * The database dump can be gzipped to decrease diskspace usage.
		 */
		'gzip_database_dump' => false,
		
		'destination' => [
			
			/*
			 * The filename prefix used for the backup zip file.
			 */
			'filename_prefix' => '',
			
			/*
			 * The disk names on which the backups will be stored.
			 */
			'disks' => [
				'backups',
			],
		],
	],
	
	/*
	 * You can get notified when specific events occur. Out of the box you can use 'mail' and 'slack'.
	 * For Slack you need to install guzzlehttp/guzzle.
	 *
	 * You can also use your own notification classes, just make sure the class is named after one of
	 * the `Spatie\Backup\Events` classes.
	 */
	'notifications' => [
		
		'notifications' => [
			\Spatie\Backup\Notifications\Notifications\BackupHasFailed::class         => ['mail'],
			\Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFound::class => ['mail'],
			\Spatie\Backup\Notifications\Notifications\CleanupHasFailed::class        => ['mail'],
			\Spatie\Backup\Notifications\Notifications\BackupWasSuccessful::class     => ['mail'],
			\Spatie\Backup\Notifications\Notifications\HealthyBackupWasFound::class   => ['mail'],
			\Spatie\Backup\Notifications\Notifications\CleanupWasSuccessful::class    => ['mail'],
		],
		
		/*
		 * Here you can specify the notifiable to which the notifications should be sent. The default
		 * notifiable will use the variables specified in this config file.
		 */
		'notifiable' => \Spatie\Backup\Notifications\Notifiable::class,
		
		/*
		 * Here you can specify how emails should be sent.
		 */
		'mail' => [
			'to'   => 'your@email.com',
		],
		
		/*
		 * Here you can specify how messages should be sent to Slack.
		 */
		'slack' => [
			'webhook_url' => '',
			
			/*
			 * If this is set to null the default channel of the webhook will be used.
			 */
			'channel' => null,
		],
	],
	
	/*
	 * Here you can specify which backups should be monitored.
	 * If a backup does not meet the specified requirements the
	 * UnHealthyBackupWasFound event will be fired.
	 */
	'monitorBackups' => [
		[
			'name'                                   => preg_replace('#http[^:]*://#ui', '', env('APP_NAME')),
			'disks'                                  => ['backup'],
			'newestBackupsShouldNotBeOlderThanDays'  => 1,
			'storageUsedMayNotBeHigherThanMegabytes' => 5000,
		],
		
		/*
		[
			'name' => 'name of the second app',
			'disks' => ['local', 's3'],
			'newestBackupsShouldNotBeOlderThanDays' => 1,
			'storageUsedMayNotBeHigherThanMegabytes' => 5000,
		],
		*/
	],
	
	'cleanup' => [
		/*
		 * The strategy that will be used to cleanup old backups. The default strategy
		 * will keep all backups for a certain amount of days. After that period only
		 * a daily backup will be kept. After that period only weekly backups will
		 * be kept and so on.
		 *
		 * No matter how you configure it the default strategy will never
		 * delete the newest backup.
		 */
		'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,
		
		'defaultStrategy' => [
			
			/*
			 * The number of days for which backups must be kept.
			 */
			'keepAllBackupsForDays' => 7,
			
			/*
			 * The number of days for which daily backups must be kept.
			 */
			'keepDailyBackupsForDays' => 16,
			
			/*
			 * The number of weeks for which one weekly backup must be kept.
			 */
			'keepWeeklyBackupsForWeeks' => 8,
			
			/*
			 * The number of months for which one monthly backup must be kept.
			 */
			'keepMonthlyBackupsForMonths' => 4,
			
			/*
			 * The number of years for which one yearly backup must be kept.
			 */
			'keepYearlyBackupsForYears' => 2,
			
			/*
			 * After cleaning up the backups remove the oldest backup until
			 * this amount of megabytes has been reached.
			 */
			'deleteOldestBackupsWhenUsingMoreMegabytesThan' => 5000,
		],
	],

];