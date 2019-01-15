<?php
$advertising = \App\Models\Advertising::where('slug', 'top')->first();
?>
@if (!empty($advertising))
	@include('home.inc.spacer')
	<div class="container">
		<div class="container hidden-md hidden-sm hidden-xs ads-parent-responsive">
			<div class="text-center">
				{!! $advertising->tracking_code_large !!}
			</div>
		</div>
		<div class="container hidden-lg hidden-xs ads-parent-responsive">
			<div class="text-center">
				{!! $advertising->tracking_code_medium !!}
			</div>
		</div>
		<div class="container hidden-sm hidden-md hidden-lg ads-parent-responsive">
			<div class="text-center">
				{!! $advertising->tracking_code_small !!}
			</div>
		</div>
	</div>
@endif