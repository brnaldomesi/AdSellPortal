<!-- this (.mobile-filter-sidebar) part will be position fixed in mobile version -->
<?php
    $fullUrl = url(request()->getRequestUri());
    $tmpExplode = explode('?', $fullUrl);
    $fullUrlNoParams = current($tmpExplode);
?>
<div class="col-md-3 page-sidebar mobile-filter-sidebar pb-4">
	<aside>
		<div class="sidebar-modern-inner enable-long-words">
			
			@include('search.inc.fields')
            
            <!-- Date -->
			<div class="block-title has-arrow sidebar-header">
				<h5><strong><a href="#"> {{ t('Date Posted') }} </a></strong></h5>
			</div>
            <div class="block-content list-filter">
                <div class="filter-date filter-content">
                    <ul>
                        @if (isset($dates) and !empty($dates))
                            @foreach($dates as $key => $value)
                                <li>
                                    <input type="radio" name="postedDate" value="{{ $key }}" id="postedDate_{{ $key }}" {{ (request()->get('postedDate')==$key) ? 'checked="checked"' : '' }}>
                                    <label for="postedDate_{{ $key }}">{{ $value }}</label>
                                </li>
                            @endforeach
                        @endif
                        <input type="hidden" id="postedQueryString" value="{{ httpBuildQuery(request()->except(['page', 'postedDate'])) }}">
                    </ul>
                </div>
            </div>
            
            @if (isset($cat))
                @if (!in_array($cat->type, ['not-salable']))
					<!-- Price -->
					<div class="block-title has-arrow sidebar-header">
						<h5><strong><a href="#">{{ (!in_array($cat->type, ['job-offer', 'job-search'])) ? t('Price range') : t('Salary range') }}</a></strong></h5>
					</div>
					<div class="block-content list-filter">
						<form role="form" class="form-inline" action="{{ $fullUrlNoParams }}" method="GET">
							{!! csrf_field() !!}
							@foreach(request()->except(['page', 'minPrice', 'maxPrice', '_token']) as $key => $value)
								@if (is_array($value))
									@foreach($value as $k => $v)
										@if (is_array($v))
											@foreach($v as $ik => $iv)
												@continue(is_array($iv))
												<input type="hidden" name="{{ $key.'['.$k.']['.$ik.']' }}" value="{{ $iv }}">
											@endforeach
										@else
											<input type="hidden" name="{{ $key.'['.$k.']' }}" value="{{ $v }}">
										@endif
									@endforeach
								@else
									<input type="hidden" name="{{ $key }}" value="{{ $value }}">
								@endif
							@endforeach
							<div class="form-group col-sm-4 no-padding">
								<input type="text" placeholder="2000" id="minPrice" name="minPrice" class="form-control" value="{{ request()->get('minPrice') }}">
							</div>
							<div class="form-group col-sm-1 no-padding text-center hidden-xs"> -</div>
							<div class="form-group col-sm-4 no-padding">
								<input type="text" placeholder="3000" id="maxPrice" name="maxPrice" class="form-control" value="{{ request()->get('maxPrice') }}">
							</div>
							<div class="form-group col-sm-3 no-padding">
								<button class="btn btn-default pull-right btn-block-xs" type="submit">{{ t('GO') }}</button>
							</div>
						</form>
						<div style="clear:both"></div>
					</div>
                @endif
				
				<?php $parentId = ($cat->parent_id == 0) ? $cat->tid : $cat->parent_id; ?>
                <!-- SubCategory -->
				<div id="subCatsList">
					<div class="block-title has-arrow sidebar-header">
						<h5><strong><a href="#"><i class="fa fa-angle-left"></i> {{ t('Others Categories') }}</a></strong></h5>
					</div>
					<div class="block-content list-filter categories-list">
						<ul class="list-unstyled">
							<li>
								@if ($cats->has($parentId))
									<?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cats->get($parentId)->slug]; ?>
									<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}" title="{{ $cats->get($parentId)->name }}">
										<span class="title"><strong>{{ $cats->get($parentId)->name }}</strong>
										</span><span class="count">&nbsp;{{ $countCatPosts->get($parentId)->total ?? 0 }}</span>
									</a>
								@endif
								<ul class="list-unstyled long-list">
									@if ($cats->groupBy('parent_id')->has($parentId))
									@foreach ($cats->groupBy('parent_id')->get($parentId) as $iSubCat)
										@continue(!$cats->has($iSubCat->parent_id))
										<li>
											<?php $attr = [
												'countryCode' => config('country.icode'),
												'catSlug'     => $cats->get($iSubCat->parent_id)->slug,
												'subCatSlug'  => $iSubCat->slug
											]; ?>
											@if ((isset($uriPathSubCatSlug) and $uriPathSubCatSlug == $iSubCat->slug) or (request()->input('sc') == $iSubCat->tid))
												<strong>
													<a href="{{ lurl(trans('routes.v-search-subCat', $attr), $attr) }}" title="{{ $iSubCat->name }}">
														{{ str_limit($iSubCat->name, 100) }}
														<span class="count">({{ $countSubCatPosts->get($iSubCat->tid)->total ?? 0 }})</span>
													</a>
												</strong>
											@else
												<a href="{{ lurl(trans('routes.v-search-subCat', $attr), $attr) }}" title="{{ $iSubCat->name }}">
													{{ str_limit($iSubCat->name, 100) }}
													<span class="count">({{ $countSubCatPosts->get($iSubCat->tid)->total ?? 0 }})</span>
												</a>
											@endif
										</li>
									@endforeach
									@endif
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<?php $style = 'style="display: none;"'; ?>
			@endif
        
            <!-- Category -->
			<div id="catsList" {!! (isset($style)) ? $style : '' !!}>
				<div class="block-title has-arrow sidebar-header">
					<h5><strong><a href="#">{{ t('All Categories') }}</a></strong></h5>
				</div>
				<div class="block-content list-filter categories-list">
					<ul class="list-unstyled">
						@if ($cats->groupBy('parent_id')->has(0))
						@foreach ($cats->groupBy('parent_id')->get(0) as $iCat)
							<li>
								<?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $iCat->slug]; ?>
								@if ((isset($uriPathCatSlug) and $uriPathCatSlug == $iCat->slug) or (request()->input('c') == $iCat->tid))
									<strong>
										<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}" title="{{ $iCat->name }}">
											<span class="title">{{ $iCat->name }}</span>
											<span class="count">&nbsp;{{ $countCatPosts->get($iCat->tid)->total ?? 0 }}</span>
										</a>
									</strong>
								@else
									<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}" title="{{ $iCat->name }}">
										<span class="title">{{ $iCat->name }}</span>
										<span class="count">&nbsp;{{ $countCatPosts->get($iCat->tid)->total ?? 0 }}</span>
									</a>
								@endif
							</li>
						@endforeach
						@endif
					</ul>
				</div>
			</div>
            
            <!-- City -->
			<div class="block-title has-arrow sidebar-header">
				<h5><strong><a href="#">{{ t('Locations') }}</a></strong></h5>
			</div>
			<div class="block-content list-filter locations-list">
				<ul class="browse-list list-unstyled long-list">
                    @if (isset($cities) and $cities->count() > 0)
						@foreach ($cities as $city)
							<?php
								$attr = ['countryCode' => config('country.icode')];
								$fullUrlLocation = lurl(trans('routes.v-search', $attr), $attr);
								$locationParams = [
									'l'  => $city->id,
									'r'  => '',
									'c'  => (isset($cat)) ? $cat->tid : '',
									'sc' => (isset($subCat)) ? $subCat->tid : '',
								];
							?>
							<li>
								@if ((isset($uriPathCityId) and $uriPathCityId == $city->id) or (request()->input('l')==$city->id))
									<strong>
										<a href="{!! qsurl($fullUrlLocation, array_merge(request()->except(['page'] + array_keys($locationParams)), $locationParams)) !!}" title="{{ $city->name }}">
											{{ $city->name }}
										</a>
									</strong>
								@else
									<a href="{!! qsurl($fullUrlLocation, array_merge(request()->except(['page'] + array_keys($locationParams)), $locationParams)) !!}" title="{{ $city->name }}">
										{{ $city->name }}
									</a>
								@endif
							</li>
						@endforeach
                    @endif
				</ul>
			</div>

			<div style="clear:both"></div>
		</div>
	</aside>

</div>

@section('after_scripts')
    @parent
    <script>
        var baseUrl = '{{ $fullUrlNoParams }}';
        
        $(document).ready(function ()
        {
            $('input[type=radio][name=postedDate]').click(function() {
                var postedQueryString = $('#postedQueryString').val();
				
                if (postedQueryString != '') {
                    postedQueryString = postedQueryString + '&';
                }
                postedQueryString = postedQueryString + 'postedDate=' + $(this).val();
                
                var searchUrl = baseUrl + '?' + postedQueryString;
				redirect(searchUrl);
            });
        });
    </script>
@endsection