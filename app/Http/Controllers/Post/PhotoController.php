<?php
/**
 * LaraClassified - Geo Classified Ads Software
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

namespace App\Http\Controllers\Post;

use App\Http\Requests\PhotoRequest;
use App\Models\Post;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\Picture;
use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;
use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\File;
use Torann\LaravelMetaTags\Facades\MetaTag;

class PhotoController extends FrontController
{
	public $data;
	
	/**
	 * PhotoController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->commonQueries();
			
			return $next($request);
		});
		
		$this->middleware('ajax')->only('delete');
	}
	
	/**
	 * Common Queries
	 */
	public function commonQueries()
	{
		$data = [];
		
		// Count Packages
		$data['countPackages'] = Package::trans()->applyCurrency()->count();
		view()->share('countPackages', $data['countPackages']);
		
		// Count Payment Methods
		$data['countPaymentMethods'] = PaymentMethod::whereIn('name', array_keys((array)config('plugins.installed')))
			->where(function ($query) {
				$query->whereRaw('FIND_IN_SET("' . config('country.icode') . '", LOWER(countries)) > 0')
					->orWhereNull('countries');
			})->count();
		view()->share('countPaymentMethods', $data['countPaymentMethods']);
		
		// Save common's data
		$this->data = $data;
		
		// Keep the Post's creation message
		// session()->keep(['message']);
		if (getSegment(2) == 'create') {
			if (session()->has('tmpPostId')) {
				session()->flash('message', t('Your ad has been created.'));
			}
		}
	}
	
	/**
	 * Show the form the create a new ad post.
	 *
	 * @param $postIdOrToken
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getForm($postIdOrToken)
	{
		$data = [];
		
		// Get Post
		if (getSegment(2) == 'create') {
			if (!session()->has('tmpPostId')) {
				return redirect('posts/create');
			}
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('id', session('tmpPostId'))
				->where('tmp_token', $postIdOrToken)
				->with(['pictures'])
				->first();
		} else {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('user_id', auth()->user()->id)
				->where('id', $postIdOrToken)
				->with(['pictures'])
				->first();
		}
		
		if (empty($post)) {
			abort(404);
		}
		
		view()->share('post', $post);
		
		
		// Get next step URI
		$creationPath = (getSegment(2) == 'create') ? 'create/' : '';
		if (
			isset($this->data['countPackages']) &&
			isset($this->data['countPaymentMethods']) &&
			$this->data['countPackages'] > 0 &&
			$this->data['countPaymentMethods'] > 0
		) {
			$nextStepUrl = config('app.locale') . '/posts/' . $creationPath . $postIdOrToken . '/payment';
			$nextStepLabel = t('Next');
		} else {
			if (getSegment(2) == 'create') {
				$nextStepUrl = config('app.locale') . '/posts/create/' . $postIdOrToken . '/finish';
			} else {
				$nextStepUrl = config('app.locale') . '/' . $post->uri . '?preview=1';
			}
			$nextStepLabel = t('Finish');
		}
		view()->share('nextStepUrl', $nextStepUrl);
		view()->share('nextStepLabel', $nextStepLabel);
		
		
		// Meta Tags
		if (getSegment(2) == 'create') {
			MetaTag::set('title', getMetaTag('title', 'create'));
			MetaTag::set('description', strip_tags(getMetaTag('description', 'create')));
			MetaTag::set('keywords', getMetaTag('keywords', 'create'));
		} else {
			MetaTag::set('title', t('Update My Ad'));
			MetaTag::set('description', t('Update My Ad'));
		}
		
		return view('post.photos', $data);
	}
	
	/**
	 * Store a new ad post.
	 *
	 * @param $postIdOrToken
	 * @param PhotoRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postForm($postIdOrToken, PhotoRequest $request)
	{
		// Get Post
		if (getSegment(2) == 'create') {
			if (!session()->has('tmpPostId')) {
				if ($request->ajax()) {
					return response()->json(['error' => t('Post not found')]);
				}
				
				return redirect('posts/create');
			}
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('id', session('tmpPostId'))
				->where('tmp_token', $postIdOrToken)->first();
		} else {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('user_id', auth()->user()->id)
				->where('id', $postIdOrToken)
				->first();
		}
		
		if (empty($post)) {
			if ($request->ajax()) {
				return response()->json(['error' => t('Post not found')]);
			}
			abort(404);
		}
		
		// Get pictures limit
		$countExistingPictures = Picture::where('post_id', $post->id)->count();
		$picturesLimit = (int)config('settings.single.pictures_limit', 5) - $countExistingPictures;
		
		// Save all pictures
		$pictures = [];
		$files = $request->file('pictures');
		if (count($files) > 0) {
			foreach ($files as $key => $file) {
				if (empty($file)) {
					continue;
				}
				
				// Delete old file if new file has uploaded
				// Check if current Post have a pictures
				$picture = Picture::find($key);
				if (!empty($picture)) {
					// Delete old file
					$picture->delete($picture->id);
				}
				
				// Post Picture in database
				$picture = new Picture([
					'post_id'  => $post->id,
					'filename' => $file,
					'position' => (int)$key + 1,
				]);
				$picture->save();
				
				$pictures[] = $picture;
				
				// Check the pictures limit
				if ($key >= ($picturesLimit - 1)) {
					break;
				}
			}
		}
		
		// Get next step URI
		$creationPath = (getSegment(2) == 'create') ? 'create/' : '';
		if (
			isset($this->data['countPackages']) &&
			isset($this->data['countPaymentMethods']) &&
			$this->data['countPackages'] > 0 &&
			$this->data['countPaymentMethods'] > 0
		) {
			flash(t('The pictures have been updated'))->success();
			$nextStepUrl = config('app.locale') . '/posts/' . $creationPath . $postIdOrToken . '/payment';
			$nextStepLabel = t('Next');
		} else {
			if (getSegment(2) == 'create') {
				$request->session()->flash('message', t('Your ad has been created.'));
				$nextStepUrl = config('app.locale') . '/posts/create/' . $postIdOrToken . '/finish';
			} else {
				flash(t('The pictures have been updated'))->success();
				$nextStepUrl = config('app.locale') . '/' . $post->uri . '?preview=1';
			}
			$nextStepLabel = t('Done');
		}
		
		view()->share('nextStepUrl', $nextStepUrl);
		view()->share('nextStepLabel', $nextStepLabel);
		
		
		// Ajax response
		if ($request->ajax()) {
			$data = [];
			$data['initialPreview'] = [];
			$data['initialPreviewConfig'] = [];
			
			$pictures = collect($pictures);
			if ($pictures->count() > 0) {
				foreach ($pictures as $picture) {
					// Get Deletion Url
					if (getSegment(2) == 'create') {
						$initialPreviewConfigUrl = lurl('posts/create/' . $post->tmp_token . '/photos/' . $picture->id . '/delete');
					} else {
						$initialPreviewConfigUrl = lurl('posts/' . $post->id . '/photos/' . $picture->id . '/delete');
					}
					
					// Build Bootstrap-Input plugin's parameters
					$data['initialPreview'][] = resize($picture->filename);
					$data['initialPreviewConfig'][] = [
						'caption' => last(explode('/', $picture->filename)),
						'size'    => (int)File::size(filePath($picture->filename)),
						'url'     => $initialPreviewConfigUrl,
						'key'     => $picture->id,
						'extra'   => ['id' => $picture->id],
					];
				}
			}
			
			return response()->json($data);
		}
		
		// Non ajax response
		return redirect($nextStepUrl);
	}
	
	/**
	 * Delete picture
	 *
	 * @param $postIdOrToken
	 * @param $pictureId
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function delete($postIdOrToken, $pictureId, Request $request)
	{
		$inputs = $request->all();
		
		// Get Post
		if (getSegment(2) == 'create') {
			if (!session()->has('tmpPostId')) {
				if ($request->ajax()) {
					return response()->json(['error' => t('Post not found')]);
				}
				
				return redirect('posts/create');
			}
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();
		} else {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('user_id', auth()->user()->id)->where('id', $postIdOrToken)->first();
		}
		
		if (empty($post)) {
			if ($request->ajax()) {
				return response()->json(['error' => t('Post not found')]);
			}
			abort(404);
		}
		
		$picture = Picture::withoutGlobalScopes([ActiveScope::class])->find($pictureId);
		if (!empty($picture)) {
			$nb = $picture->delete();
		}
		
		if ($request->ajax()) {
			return response()->json([]);
		}
		
		flash(t("The picture has been deleted."))->success();
		
		return back();
	}
}
