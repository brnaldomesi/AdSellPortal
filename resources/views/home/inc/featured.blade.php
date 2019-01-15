<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.other.cache_expiration');
}
?>
@if (isset($featured) and !empty($featured) and !empty($featured->posts))
	@include('home.inc.spacer')
	<div class="container">
		<div class="col-xl-12 content-box layout-section">
			<div class="row row-featured row-featured-category">
				<div class="col-xl-12 box-title">
					<div class="inner">
						<h2>
							<span class="title-3">{!! $featured->title !!}</span>
							<a href="{{ $featured->link }}" class="sell-your-item">
								{{ t('View more') }} <i class="icon-th-list"></i>
							</a>
						</h2>
					</div>
				</div>
		
				<div style="clear: both"></div>
		
				<div class="relative content featured-list-row clearfix">
					
					<div class="large-12 columns">
						<div class="no-margin featured-list-slider owl-carousel owl-theme">
							<?php
							foreach($featured->posts as $key => $post):
								if (empty($countries) or !$countries->has($post->country_code)) continue;
			
								// Picture setting
								$pictures = \App\Models\Picture::where('post_id', $post->id)->orderBy('position')->orderBy('id');
								if ($pictures->count() > 0) {
									$postImg = resize($pictures->first()->filename, 'medium');
								} else {
									$postImg = resize(config('larapen.core.picture.default'));
								}
			
								// Category
								$cacheId = 'category.' . $post->category_id . '.' . config('app.locale');
								$liveCat = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
									$liveCat = \App\Models\Category::find($post->category_id);
									return $liveCat;
								});
			
								// Check parent
								if (empty($liveCat->parent_id)) {
									$liveCatType = $liveCat->type;
								} else {
									$cacheId = 'category.' . $liveCat->parent_id . '.' . config('app.locale');
									$liveParentCat = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($liveCat) {
										$liveParentCat = \App\Models\Category::find($liveCat->parent_id);
										return $liveParentCat;
									});
									$liveCatType = (!empty($liveParentCat)) ? $liveParentCat->type : 'classified';
								}
								?>
								<div class="item">
									<?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
									<a href="{{ lurl($post->uri, $attr) }}">
										<span class="item-carousel-thumb">
											<img class="img-fluid" src="{{ $postImg }}" alt="{{ $post->title }}" style="border: 1px solid #e7e7e7; margin-top: 2px;">
										</span>
										<span class="item-name">{{ str_limit($post->title, 70) }}</span>
										
										@if (config('plugins.reviews.installed'))
											@if (view()->exists('reviews::ratings-list'))
												@include('reviews::ratings-list')
											@endif
										@endif
										
										<span class="price">
											@if (isset($liveCatType) and !in_array($liveCatType, ['not-salable']))
												@if ($post->price > 0)
													{!! \App\Helpers\Number::money($post->price) !!}
												@else
													{!! \App\Helpers\Number::money('--') !!}
												@endif
											@else
												{{ '--' }}
											@endif
										</span>
									</a>
								</div>
							<?php endforeach; ?>
			
						</div>
					</div>
		
				</div>
			</div>
		</div>
	</div>
@endif

@section('after_style')
	@parent
@endsection

@section('before_scripts')
	@parent
	<script>
		/* Carousel Parameters */
		var carouselItems = {{ (isset($featured) and isset($featured->posts)) ? collect($featured->posts)->count() : 0 }};
		var carouselAutoplay = {{ (isset($featuredOptions) && isset($featuredOptions['autoplay'])) ? $featuredOptions['autoplay'] : 'false' }};
		var carouselAutoplayTimeout = {{ (isset($featuredOptions) && isset($featuredOptions['autoplay_timeout'])) ? $featuredOptions['autoplay_timeout'] : 1500 }};
		var carouselLang = {
			'navText': {
				'prev': "{{ t('prev') }}",
				'next': "{{ t('next') }}"
			}
		};
	</script>
@endsection