<?php

namespace Larapen\Feed\Http;

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Spatie\Feed\Feed;

class FeedController extends FrontController
{
	public function __construct()
	{
		parent::__construct();
		
		$title = t('All ads') . ' ' . t('on') . ' ' . config('app.name');
		Config::set('feed.feeds.main.title', $title);
	}
	
	public function __invoke()
	{
		$feeds = config('feed.feeds');
		
		$name = Str::after(app('router')->currentRouteName(), 'feeds.');
		
		$feed = $feeds[$name] ?? null;
		
		abort_unless($feed, 404);
		
		return new Feed($feed['title'], request()->url(), $feed['items'], $feed['view'] ?? 'feed::feed');
	}
}
