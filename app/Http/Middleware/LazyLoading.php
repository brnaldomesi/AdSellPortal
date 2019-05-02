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

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class LazyLoading
{
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$response = $next($request);
		
		// Bots and Other Exceptions
		$crawler = new CrawlerDetect();
		if (
			$crawler->isCrawler()
			|| isFromAdminPanel()
			|| Str::contains(Route::currentRouteAction(), 'InstallController')
			|| Str::contains(Route::currentRouteAction(), 'UpgradeController')
		) {
			return $response;
		}
		
		// Don't minify the HTML if the option is not activated
		if (config('settings.optimization.lazy_loading_activation') == 0) {
			return $response;
		}
		
		// Get HTML
		$buffer = $response->getContent();
		
		// Apply Lazy Loading HTML transformation
		$buffer = $this->applyLazyLoading($buffer);
		
		// Output the minified HTML
		return $response->setContent($buffer);
	}
	
	/**
	 * Apply the Lazy Loading HTML transformation
	 *
	 * @param $buffer
	 * @return mixed|string
	 */
	private function applyLazyLoading($buffer)
	{
		$lazyCssClassName = 'lazyload';
		$lazyDataSrcTagName = 'data-src';
		
		// HTML elements patterns
		$tags = [
			'img'    => [
				'all'      => '/(<img[^>]*>)/ui',
				'filtered' => '/(<img.*?class=".*?' . $lazyCssClassName . '[^"]*"[^>]*>)/ui',
			],
			'iframe' => [
				'all'      => '/(<iframe[^>]*>[^<]*<\/iframe>)/ui',
				'filtered' => '/(<iframe.*class=".*' . $lazyCssClassName . '[^"]*"[^>]*>[^<]*<\/iframe>)/ui',
			],
		];
		
		$lazyBuffer = '';
		$i = 0;
		foreach ($tags as $tag => $pattern) {
			if ($i > 0) {
				$buffer = $lazyBuffer;
			}
			// Get all tag element with the CSS class "lazyload"
			preg_match_all($pattern['all'], $buffer, $matches);
			
			$elements = [];
			if (isset($matches[1]) && !empty($matches[1])) {
				foreach ($matches[1] as $key => $value) {
					if (!preg_match($pattern['filtered'], $value)) {
						continue;
					}
					$elements[] = $value;
				}
				unset($matches);
			}
			// dd($elements); // debug!
			
			if (!empty($elements)) {
				$replace = [];
				$blankSrc = ($tag == 'img') ? url('images/blank.gif') : '';
				
				foreach ($elements as $key => $element) {
					$image = preg_replace('/src="([^"]*)"/ui', $lazyDataSrcTagName . '="\1" src="' . $blankSrc . '"', $element);
					$replace[$key] = $image;
				}
				
				$lazyBuffer = str_replace($elements, $replace, $buffer);
			}
			
			if (empty($lazyBuffer)) {
				$lazyBuffer = $buffer;
			}
			
			$i++;
		}
		
		return $lazyBuffer;
	}
}
