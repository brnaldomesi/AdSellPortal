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


namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Controllers\Post\Traits\CustomFieldTrait;
use App\Http\Controllers\Post\Traits\EditTrait;
use App\Models\AddonServices;
use App\Models\InvoiceData;
use App\Models\Invoice;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;

class InvoiceDataController extends FrontController
{
    use EditTrait, VerificationTrait, CustomFieldTrait;

    /**
     * CreateController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index($postId)
    {
        // $services = AddonServices::all();
        // $orders = InvoiceData::where('post_id', $postId)->get('service_id');
        // $coupon_list = Coupon::all();
        // $coupon_id = Post::find($postId)->coupon_id;

        // $result = array();
        // $result['services'] = $services;
        // $result['orders'] = $orders;
        // $result['coupon_id'] = $coupon_id;
        // $result['coupon_list'] = $coupon_list;
        
        $result = array();
        $result['service_list'] = AddonServices::all();
        $addon_services = collect([]);
        $invoices = Invoice::with('invoice_data.service')
                    ->where('post_id', $postId)
                    ->get()
                    ->map->invoice_data;
        foreach ($invoices as $invoice) {
            $addon_services = $addon_services->concat($invoice->map->service);
        }
        $result['addon_services'] = $addon_services;
        return json_encode($result);
    }
}