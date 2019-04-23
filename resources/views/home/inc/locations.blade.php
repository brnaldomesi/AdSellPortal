<?php
// Default Map's values
$loc = [
	'show'       		=> false,
	'itemsCols'  		=> 3,
	'showButton' 		=> false,
	'countCitiesPosts' 	=> false,
];
$map = ['show' => false];

// Get Admin Map's values
if (isset($citiesOptions)) {
	if (isset($citiesOptions['show_cities']) and $citiesOptions['show_cities'] == '1') {
		$loc['show'] = true;
	}
	if (isset($citiesOptions['items_cols']) and !empty($citiesOptions['items_cols'])) {
		$loc['itemsCols'] = (int)$citiesOptions['items_cols'];
	}
	if (isset($citiesOptions['show_post_btn']) and $citiesOptions['show_post_btn'] == '1') {
		$loc['showButton'] = true;
	}
	
	if (file_exists(config('larapen.core.maps.path') . config('country.icode') . '.svg')) {
		if (isset($citiesOptions['show_map']) and $citiesOptions['show_map'] == '1') {
			$map['show'] = true;
		}
	}
	
	if (isset($citiesOptions['count_cities_posts']) and $citiesOptions['count_cities_posts'] == '1') {
		$loc['countCitiesPosts'] = true;
	}
}
?>
@if ($loc['show'] || $map['show'])
@include('home.inc.spacer')
<div class="container">
	<div class="col-xl-12 page-content p-0">
		<div class="inner-box">
			
			<div class="row">
				@if (!$map['show'])
					<div class="row">
						<div class="col-xl-12 col-sm-12">
							<h2 class="title-3 p-0">
								<i class="icon-location-2"></i>&nbsp;{{ t('Choose a city') }}
							</h2>
						</div>
					</div>
				@endif
				<?php
				$leftClassCol = '';
				$rightClassCol = '';
				$ulCol = 'col-md-3 col-sm-12'; // Cities Columns
				
				if ($loc['show'] && $map['show']) {
					// Display the Cities & the Map
					$leftClassCol = 'col-lg-8 col-md-12';
					$rightClassCol = 'col-lg-3 col-md-12';
					$ulCol = 'col-md-4 col-sm-6 col-xs-12';
					
					if ($loc['itemsCols'] == 2) {
						$leftClassCol = 'col-md-6 col-sm-12';
						$rightClassCol = 'col-md-5 col-sm-12';
						$ulCol = 'col-md-6 col-sm-12';
					}
					if ($loc['itemsCols'] == 1) {
						$leftClassCol = 'col-md-3 col-sm-12';
						$rightClassCol = 'col-md-8 col-sm-12';
						$ulCol = 'col-xl-12';
					}
				} else {
					if ($loc['show'] && !$map['show']) {
						// Display the Cities & Hide the Map
						$leftClassCol = 'col-xl-12';
					}
					if (!$loc['show'] && $map['show']) {
						// Display the Map & Hide the Cities
						$rightClassCol = 'col-xl-12';
					}
				}
				?>
				@if ($loc['show'])
				<div class="{{ $leftClassCol }} page-content m-0 p-0">
					@if (isset($cities))
						<div class="relative location-content">
							
							@if ($loc['show'] && $map['show'])
								<h2 class="title-3 p-3" style="white-space: nowrap;">
									<i class="icon-location-2"></i>&nbsp;{{ t('Choose a city or region') }}
								</h2>
							@endif
							<div class="col-xl-12 tab-inner">
								<div class="row">
									@foreach ($cities as $key => $items)
										<ul class="cat-list {{ $ulCol }} {{ (count($cities) == $key+1) ? 'cat-list-border' : '' }}">
											@foreach ($items as $k => $city)
												<li>
													@if ($city->id == 999999999)
														<a href="#browseAdminCities" id="dropdownMenu1" data-toggle="modal">{!! $city->name !!}</a>
													@else
														<?php $attr = ['countryCode' => config('country.icode'), 'city' => slugify($city->name), 'id' => $city->id]; ?>
														<a href="{{ lurl(trans('routes.v-search-city', $attr), $attr) }}">
															{{ $city->name }}
														</a>
														@if ($loc['countCitiesPosts'])
															&nbsp;({{ $city->posts->count() }})
														@endif
													@endif
												</li>
											@endforeach
										</ul>
									@endforeach
								</div>
							</div>
							
							@if ($loc['showButton'])
								@if (!auth()->check() and config('settings.single.guests_can_post_ads') != '1')
									<a class="btn btn-lg btn-add-listing" href="#quickLogin" data-toggle="modal">
										<i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
									</a>
								@else
									<a class="btn btn-lg btn-add-listing pl-4 pr-4" href="{{ addPostURL() }}" style="text-transform: none;">
										<i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
									</a>
								@endif
							@endif
	
						</div>
					@endif
				</div>
				@endif
				
				@include('layouts.inc.tools.svgmap')
			</div>
			
		</div>
	</div>
</div>
@endif

@section('modal_location')
	@parent
	@if ($loc['show'] || $map['show'])
		@include('layouts.inc.modal.location')
	@endif
@endsection
