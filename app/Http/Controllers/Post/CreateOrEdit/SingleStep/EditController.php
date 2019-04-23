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

namespace App\Http\Controllers\Post\CreateOrEdit\SingleStep;

use App\Helpers\Ip;
use App\Helpers\Payment as PaymentHelper;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Controllers\Post\Traits\CustomFieldTrait;
use App\Http\Controllers\Post\CreateOrEdit\Traits\PaymentTrait;
use App\Http\Requests\PostRequest;
use App\Models\City;
use App\Models\Picture;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Category;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Http\Controllers\FrontController;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\StrictActiveScope;
use App\Models\Scopes\VerifiedScope;
use Torann\LaravelMetaTags\Facades\MetaTag;

class EditController extends FrontController
{
    use VerificationTrait, CustomFieldTrait, PaymentTrait;
	
	public $request;
	public $data;
	public $msg = [];
	public $uri = [];
	public $packages;
	public $paymentMethods;

    /**
     * EditController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        // From Laravel 5.3.4 or above
        $this->middleware(function ($request, $next) {
            $this->commonQueries();

            return $next($request);
        });
    }

    /**
     * Common Queries
     */
    public function commonQueries()
    {
        // References
        $data = [];
	
		// Messages
		$this->msg['post']['success'] = t("Your ad has been updated.");
		$this->msg['checkout']['success'] = t("We have received your payment.");
		$this->msg['checkout']['cancel'] = t("We have not received your payment. Payment cancelled.");
		$this->msg['checkout']['error'] = t("We have not received your payment. An error occurred.");
	
		// Set URLs
		$this->uri['previousUrl'] = config('app.locale') . '/edit/#entryId';
		$this->uri['nextUrl'] = config('app.locale') . '/' . trans('routes.v-post', ['slug' => '#title', 'id' => '#entryId']);
		$this->uri['paymentCancelUrl'] = url(config('app.locale') . '/edit/#entryId/payment/cancel');
		$this->uri['paymentReturnUrl'] = url(config('app.locale') . '/edit/#entryId/payment/success');
	
		// Payment Helper init.
		PaymentHelper::$country = collect(config('country'));
		PaymentHelper::$lang = collect(config('lang'));
		PaymentHelper::$msg = $this->msg;
		PaymentHelper::$uri = $this->uri;
	
		// Get Packages
		$this->packages = Package::trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
		$data['countPackages'] = $this->packages->count();
		view()->share('packages', $this->packages);
		view()->share('countPackages', $this->packages->count());
	
		PostRequest::$packages = $this->packages;
		PostRequest::$paymentMethods = $this->paymentMethods;

        // Get Countries
        $data['countries'] = $this->countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
        $this->countries = $data['countries'];
        view()->share('countries', $data['countries']);

        // Get Categories
        $data['categories'] = Category::trans()->where('parent_id', 0)->with([
            'children' => function ($query) {
                $query->trans();
            },
        ])->orderBy('lft')->get();
        view()->share('categories', $data['categories']);

        // Get Post Types
        $data['postTypes'] = PostType::trans()->get();
        view()->share('postTypes', $data['postTypes']);
    
        // Save common's data
        $this->data = $data;
    }

    /**
     * Show the form the create a new ad post.
     *
     * @param $postId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getForm($postId)
    {
		// Check if the form type is 'Multi Steps Form', and make redirection to it (permanently).
		if (config('settings.single.publication_form_type') == '1') {
			return redirect(lurl('posts/' . $postId . '/edit'), 301)->header('Cache-Control', 'no-store, no-cache, must-revalidate');
		}
		
		$data = [];
	
		$post = Post::with(['city', 'latestPayment' =>  function ($builder) {
						$builder->with(['package'])->withoutGlobalScope(StrictActiveScope::class);
					}])
					->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
					->where('user_id', auth()->user()->id)
					->where('id', $postId)
					->first();
	
		if (empty($post)) {
			abort(404);
		}
	
		view()->share('post', $post);
	
		// Get the Post's Administrative Division
		if (config('country.admin_field_active') == 1 && in_array(config('country.admin_type'), ['1', '2'])) {
			if (!empty($post->city)) {
				$adminType = config('country.admin_type');
				$adminModel = '\App\Models\SubAdmin' . $adminType;
			
				// Get the City's Administrative Division
				$admin = $adminModel::where('code', $post->city->{'subadmin' . $adminType . '_code'})->first();
				if (!empty($admin)) {
					view()->share('admin', $admin);
				}
			}
		}
	
		// Meta Tags
		MetaTag::set('title', t('Update My Ad'));
		MetaTag::set('description', t('Update My Ad'));
	
		return view('post.createOrEdit.singleStep.edit', $data);
    }

    /**
     * Update ad post.
     *
     * @param $postId
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postForm($postId, PostRequest $request)
    {
		$post = Post::with(['latestPayment'])
					->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
					->where('user_id', auth()->user()->id)
					->where('id', $postId)
					->first();
	
		if (empty($post)) {
			abort(404);
		}
	
		// Get the Post's City
		$city = City::find($request->input('city_id', 0));
		if (empty($city)) {
			flash(t("Posting Ads was disabled for this time. Please try later. Thank you."))->error();
		
			return back()->withInput();
		}
	
		// Conditions to Verify User's Email or Phone
		$emailVerificationRequired = config('settings.mail.email_verification') == 1 && $request->filled('email') && $request->input('email') != $post->email;
		$phoneVerificationRequired = config('settings.sms.phone_verification') == 1 && $request->filled('phone') && $request->input('phone') != $post->phone;
	
		/*
		 * Allow admin users to approve the changes,
		 * If the ads approbation option is enable,
		 * And if important data have been changed.
		 */
		if (config('settings.single.posts_review_activation')) {
			if (
				md5($post->title) != md5($request->input('title')) ||
				md5($post->description) != md5($request->input('description'))
			) {
				$post->reviewed = 0;
			}
		}
	
		// Update Post
		$input = $request->only($post->getFillable());
		foreach ($input as $key => $value) {
			$post->{$key} = $value;
		}
		$post->negotiable = $request->input('negotiable');
		$post->phone_hidden = $request->input('phone_hidden');
		$post->lat = $city->latitude;
		$post->lon = $city->longitude;
		$post->ip_addr = Ip::get();
	
		// Email verification key generation
		if ($emailVerificationRequired) {
			$post->email_token = md5(microtime() . mt_rand());
			$post->verified_email = 0;
		}
	
		// Phone verification key generation
		if ($phoneVerificationRequired) {
			$post->phone_token = mt_rand(100000, 999999);
			$post->verified_phone = 0;
		}
	
		// Save
		$post->save();
	
		// Save all pictures
		$files = $request->file('pictures');
		if (!empty($files)) {
			$i = 0;
			foreach ($files as $key => $file) {
				if (empty($file)) {
					continue;
				}
			
				// Delete old file if new file has uploaded
				// Check if current Post have a pictures
				$picture = Picture::find($key);
				if (!empty($picture)) {
					$picture->delete($picture->id);
				}
				
				// Save Post's Picture in DB
				$picture = new Picture([
					'post_id'  => $post->id,
					'filename' => $file,
					'position' => $i,
				]);
				
				$picture->save();
				$i++;
			}
		}
	
		// Custom Fields
		$this->createPostFieldsValues($post, $request);
		
	
		// MAKE A PAYMENT (IF NEEDED)
	
		// Check if the selected Package has been already paid for this Post
		$alreadyPaidPackage = false;
		if (!empty($post->latestPayment)) {
			if ($post->latestPayment->package_id == $request->input('package_id')) {
				$alreadyPaidPackage = true;
			}
		}
	
		// Check if Payment is required
		$package = Package::find($request->input('package_id'));
		if (!empty($package)) {
			if ($package->price > 0 && $request->filled('payment_method_id') && !$alreadyPaidPackage) {
				// Send the Payment
				return $this->sendPayment($request, $post);
			}
		}
	
		// IF NO PAYMENT IS MADE (CONTINUE)
		
	
		// Get Next URL
		flash(t("Your ad has been updated."))->success();
		$nextStepUrl = config('app.locale') . '/' . $post->uri . '?preview=1';
	
		// Send Email Verification message
		if ($emailVerificationRequired) {
			$this->sendVerificationEmail($post);
			$this->showReSendVerificationEmailLink($post, 'post');
		}
	
		// Send Phone Verification message
		if ($phoneVerificationRequired) {
			// Save the Next URL before verification
			session(['itemNextUrl' => $nextStepUrl]);
		
			$this->sendVerificationSms($post);
			$this->showReSendVerificationSmsLink($post, 'post');
		
			// Go to Phone Number verification
			$nextStepUrl = config('app.locale') . '/verify/post/phone/';
		}
	
		// Redirection
		return redirect($nextStepUrl);
    }
}
