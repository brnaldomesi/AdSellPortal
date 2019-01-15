<?php
/**
 * LaraClassified - Geo Classified Ads CMS
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

namespace App\Http\Controllers\Ajax;

use App\Models\Picture;
use App\Models\Post;
use App\Http\Controllers\FrontController;
use App\Models\SavedPost;
use App\Models\SavedSearch;
use App\Models\Scopes\VerifiedScope;
use App\Models\Scopes\ReviewedScope;
use Illuminate\Http\Request;
use Larapen\TextToImage\Facades\TextToImage;

class PostController extends FrontController
{
    /**
     * PostController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePost(Request $request)
    {
        $postId = $request->input('postId');
        
        $status = 0;
        if (auth()->check()) {
            $savedPost = SavedPost::where('user_id', auth()->user()->id)->where('post_id', $postId);
            if ($savedPost->count() > 0) {
                // Delete SavedPost
                $savedPost->delete();
            } else {
                // Store SavedPost
                $savedPostInfo = [
                    'user_id' => auth()->user()->id,
                    'post_id' => $postId,
                ];
                $savedPost = new SavedPost($savedPostInfo);
                $savedPost->save();
                $status = 1;
            }
        }
        
        $result = [
            'logged'   => (auth()->check()) ? auth()->user()->id : 0,
            'postId'   => $postId,
            'status'   => $status,
            'loginUrl' => url(config('lang.abbr') . '/' . trans('routes.login')),
        ];
        
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveSearch(Request $request)
    {
        $queryUrl = $request->input('url');
        $tmp = parse_url($queryUrl);
        $query = $tmp['query'];
        parse_str($query, $tab);
        $keyword = $tab['q'];
        $countPosts = $request->input('countPosts');
        if ($keyword == '') {
            return response()->json([], 200, [], JSON_UNESCAPED_UNICODE);
        }
        
        $status = 0;
        if (auth()->check()) {
            $savedSearch = SavedSearch::where('user_id', auth()->user()->id)->where('keyword', $keyword)->where('query', $query);
            if ($savedSearch->count() > 0) {
                // Delete SavedSearch
                $savedSearch->delete();
            } else {
                // Store SavedSearch
                $savedSearchInfo = [
                    'country_code' => config('country.code'),
                    'user_id'      => auth()->user()->id,
                    'keyword'      => $keyword,
                    'query'        => $query,
                    'count'        => $countPosts,
                ];
                $savedSearch = new SavedSearch($savedSearchInfo);
                $savedSearch->save();
                $status = 1;
            }
        }
        
        $result = [
            'logged'   => (auth()->check()) ? auth()->user()->id : 0,
            'query'    => $query,
            'status'   => $status,
            'loginUrl' => url(config('lang.abbr') . '/' . trans('routes.login')),
        ];
        
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPhone(Request $request)
    {
        $postId = $request->input('postId', 0);
        
        $post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', $postId)->first();
        
        if (empty($post)) {
            return response()->json(['error' => ['message' => t("Error. Post doesn't exist."),], 404]);
        }
        
        $post->phone = TextToImage::make($post->phone, IMAGETYPE_PNG, ['color' => '#FFFFFF']);
        
        return response()->json(['phone' => $post->phone], 200, [], JSON_UNESCAPED_UNICODE);
    }
	
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function picturesReorder(Request $request)
	{
		$params = $request->input('params');
		
		$result = ['status' => 0];
		
		if (auth()->check()) {
			if (isset($params['stack']) && count($params['stack']) > 0) {
				$statusOk = false;
				foreach ($params['stack'] as $position => $item) {
					if (isset($item['key']) && !empty($item['key'])) {
						$picture = Picture::find($item['key']);
						if (!empty($picture)) {
							$picture->position = $position;
							$picture->save();
							
							$statusOk = true;
						}
					}
				}
				if ($statusOk) {
					$result = ['status' => 1];
				}
			}
		}
		
		return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
	}
}
