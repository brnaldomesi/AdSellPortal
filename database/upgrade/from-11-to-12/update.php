<?php

if (!\Schema::hasColumn('ads', 'reviewed')) {
	\Schema::table('ads', function ($table) {
		$table->boolean('reviewed')->nullable()->default(0)->index('reviewed')->after('active');
	});
	if (\Schema::hasColumn('ads', 'reviewed')) {
		$affected = \DB::table('ads')->update(array('reviewed' => 1));
	}
}

\DB::table('settings')->where('key', '=', 'ads_review_activation')->delete();
\DB::table('settings')->where('key', '=', 'facebook_page_fans')->delete();
