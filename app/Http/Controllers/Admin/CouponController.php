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
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends FrontController
{
    use EditTrait, VerificationTrait, CustomFieldTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $req)
    {
        $code = $req->input('code');
        $coupon = Coupon::where('code', $code)->first();
        return json_encode($coupon);
    }
}
