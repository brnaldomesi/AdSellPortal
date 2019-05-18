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


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Controllers\Post\Traits\CustomFieldTrait;
use App\Http\Controllers\Post\Traits\EditTrait;
use App\Models\Post;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use App\Http\Requests\PackageRequest;


class RenewController extends FrontController
{
    use EditTrait, VerificationTrait, CustomFieldTrait;

    /**
     * CreateController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $req){
        $postId = $req->input('postId');
        $old_post = Post::find($postId);
        $new_post = $old_post->replicate();
        $new_post->save();
        $result['code'] = 200;
        $result['postId'] = $new_post->id;
        return json_encode($result);
    }
}