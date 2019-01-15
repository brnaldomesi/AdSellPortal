@if (count(LaravelLocalization::getSupportedLocales()) > 1)
	<!-- Language selector -->
	<li class="dropdown lang-menu nav-item">
		<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-target="#langMenuDropdown">
			<span class="lang-title">{{ strtoupper(config('app.locale')) }}</span>
		</button>
		<ul id="langMenuDropdown" class="dropdown-menu dropdown-menu-right user-menu shadow-sm" role="menu">
			@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
				@if (strtolower($localeCode) != strtolower(config('app.locale')))
					<?php
					// Controller Parameters
					$attr = [];
					$attr['countryCode'] = config('country.icode');
					if (isset($uriPathCatSlug)) {
						$attr['catSlug'] = $uriPathCatSlug;
						if (isset($uriPathSubCatSlug)) {
							$attr['subCatSlug'] = $uriPathSubCatSlug;
						}
					}
					if (isset($uriPathCityName) && isset($uriPathCityId)) {
						$attr['city'] = $uriPathCityName;
						$attr['id'] = $uriPathCityId;
					}
					if (isset($uriPathUserId)) {
						$attr['id'] = $uriPathUserId;
						if (isset($uriPathUsername)) {
							$attr['username'] = $uriPathUsername;
						}
					}
					if (isset($uriPathUsername)) {
						if (isset($uriPathUserId)) {
							$attr['id'] = $uriPathUserId;
						}
						$attr['username'] = $uriPathUsername;
					}
					if (isset($uriPathTag)) {
						$attr['tag'] = $uriPathTag;
					}
					if (isset($uriPathPageSlug)) {
						$attr['slug'] = $uriPathPageSlug;
					}
					
					// Default
					// $link = LaravelLocalization::getLocalizedURL($localeCode, null, $attr);
					$link = lurl(null, $attr, $localeCode);
					$localeCode = strtolower($localeCode);
					?>
					<li class="dropdown-item">
						<a href="{{ $link }}" tabindex="-1" rel="alternate" hreflang="{{ $localeCode }}">
							<span class="lang-name">{{{ $properties['native'] }}}</span>
						</a>
					</li>
				@endif
			@endforeach
		</ul>
	</li>
@endif