{{-- localized datetime using jenssegers/date --}}
<td data-order="{{ $entry->{$column['name']} }}">
	<?php
	try {
		$dateColumnValue = \Date::parse($entry->{$column['name']})->timezone(config('app.timezone'));
	} catch (\Exception $e) {
		$dateColumnValue = \Date::parse($entry->{$column['name']});
	}
	
	if (str_contains(config('larapen.admin.default_datetime_format'), '%')) {
		$dateColumnValue = $dateColumnValue->formatLocalized(config('larapen.admin.default_datetime_format'));
	} else {
		$dateColumnValue = $dateColumnValue->format(config('larapen.admin.default_datetime_format'));
	}
	?>
	{{ $dateColumnValue }}
</td>