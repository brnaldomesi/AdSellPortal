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

namespace App\Observer;

use App\Models\Message;
use App\Models\Post;
use App\Models\SavedPost;
use App\Models\SavedSearch;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;
use App\Models\User;
use App\Notifications\UserActivated;
use Illuminate\Support\Facades\DB;

class UserObserver
{
	/**
	 * Listen to the Entry updating event.
	 *
	 * @param  User $user
	 * @return void
	 */
	public function updating(User $user)
	{
		// Get the original object values
		$original = $user->getOriginal();
		
		// Post Email address or Phone was not verified
		if (config('settings.mail.confirmation') == 1) {
			try {
				if ($original['verified_email'] != 1 || $original['verified_phone'] != 1) {
					if ($user->verified_email == 1 && $user->verified_phone == 1) {
						$user->notify(new UserActivated($user));
					}
				}
			} catch (\Exception $e) {
				flash($e->getMessage())->error();
			}
		}
	}
	
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param  User $user
	 * @return void
	 */
	public function deleting(User $user)
	{
		// Delete all user's Posts
		$posts = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('user_id', $user->id)->get();
		if ($posts->count() > 0) {
			foreach ($posts as $post) {
				$post->delete();
			}
		}
		
		// Delete all user's Messages
		$messages = Message::where(function ($query) use ($user) {
			$query->where('to_user_id', $user->id)->orWhere('from_user_id', $user->id);
		})->get();
		if ($messages->count() > 0) {
			foreach ($messages as $message) {
				if (empty($message->deleted_by)) {
					// Delete the Entry for current user
					$message->deleted_by = $user->id;
					$message->save();
				} else {
					// If the 2nd user delete the Entry,
					// Delete the Entry (definitely)
					if ($message->deleted_by != $user->id) {
						$message->delete();
					}
				}
			}
		}
		
		// Delete all user's Saved Posts
		$savedPosts = SavedPost::where('user_id', $user->id)->get();
		if ($savedPosts->count() > 0) {
			foreach ($savedPosts as $savedPost) {
				$savedPost->delete();
			}
		}
		
		// Delete all user's Saved Searches
		$savedSearches = SavedSearch::where('user_id', $user->id)->get();
		if ($savedSearches->count() > 0) {
			foreach ($savedSearches as $savedSearch) {
				$savedSearch->delete();
			}
		}
		
		// Check the Reviews Plugin
		if (config('plugins.reviews.installed')) {
			try {
				// Delete the reviews of this User
				$reviews = \App\Plugins\reviews\app\Models\Review::where('user_id', $user->id)->get();
				if ($reviews->count() > 0) {
					foreach ($reviews as $review) {
						$review->delete();
					}
				}
			} catch (\Exception $e) {
			}
		}
		
		// Check the API Plugin
		if (config('plugins.apilc.installed')) {
			DB::table('oauth_access_tokens')->where('user_id', '=', $user->id)->delete();
			DB::table('oauth_auth_codes')->where('user_id', '=', $user->id)->delete();
			DB::table('oauth_clients')->where('user_id', '=', $user->id)->delete();
		}
	}
	
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param  User $user
	 * @return void
	 */
	public function saved(User $user)
	{
		// Create a new email token if the user's email is marked as unverified
		if ($user->verified_email != 1) {
			if (empty($user->email_token)) {
				$user->email_token = md5(microtime() . mt_rand());
				$user->save();
			}
		}
		
		// Create a new phone token if the user's phone number is marked as unverified
		if ($user->verified_phone != 1) {
			if (empty($user->phone_token)) {
				$user->phone_token = mt_rand(100000, 999999);
				$user->save();
			}
		}
	}
}
