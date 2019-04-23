<?php

if (!\Schema::hasColumn('ads', 'address')) {
	\Schema::table('ads', function ($table) {
		$table->string('address', 255)->nullable()->index('address')->after('seller_phone_hidden');
	});
}
