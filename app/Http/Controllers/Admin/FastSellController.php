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

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\FrontController;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Controllers\Post\Traits\CustomFieldTrait;
use App\Http\Controllers\Post\Traits\EditTrait;
use App\Models\FastSell;
use App\Models\Post;
use App\Models\AdminService;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ServiceAdded;
use Illuminate\Http\Request;

class FastSellController extends FrontController
{
    use EditTrait, VerificationTrait, CustomFieldTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function store(Request $req)
    {
        $postId = $req->input('postId');

        /* EMAIL */
        
        // $post = Post::find($postId);
        // $location = $post->city->name;
        
        
        // $admins = AdminService::whereHas('user', function ($query) use ($location) {
        //     return $query->where('district', $location);
        // })->get()->load('user')->map(function ($admin) { 
        //     return $admin->user; 
        // });
        
        // if(count($admins) == 0) {
        //     $admins = AdminService::whereHas('user', function ($query) use ($location) {
        //         return $query->where('city', $location);
        //     })->get()->load('user')->map(function ($admin) { 
        //         return $admin->user; 
        //     });
        // }
        
        
        // if(count($admins) > 0) {
        //     Notification::send($admins, new ServiceAdded());
        // }
                        
        $fast_sell = FastSell::create(['post_id' => $postId]);
        $result['code'] = 200;
        return json_encode($result);
    }
}
