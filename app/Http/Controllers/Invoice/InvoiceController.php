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
use App\Models\InvoiceData;
use App\Models\Invoice;
use App\Models\Post;
use App\Models\AdminService;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use App\Http\Requests\PackageRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ServiceAdded;
use Twilio\Rest\Client;

class InvoiceController extends FrontController
{
    use EditTrait, VerificationTrait, CustomFieldTrait;

    /**
     * CreateController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function store(Request $req){

        $post_id = $req->input('postId');
        $coupon_id = $req->input('coupon_id');
        $status = 'unpaid';
        $service_ids = $req->input('service_ids');
        if(count($service_ids) > 0){
            $service_ids = $service_ids[0];
            $service_ids = explode(',', $service_ids);
        } 
        if($service_ids[0]=="")
            $service_ids = [];
            
        /* Twilio SMS AND EMAIL */

        // $post = Post::find($post_id);
        // $location = $post->city->name;

        // foreach ($service_ids as $service_id) {
            
        //     $admins = AdminService::whereHas('user', function ($query) use ($location) {
        //         return $query->where('district', $location);
        //     })->where('addon_services_id', $service_id)->get()->load('user')->map(function ($admin) { 
        //         return $admin->user; 
        //     });

        //     if(count($admins) == 0) {
        //         $admins = AdminService::whereHas('user', function ($query) use ($location) {
        //             return $query->where('city', $location);
        //         })->where('addon_services_id', $service_id)->get()->load('user')->map(function ($admin) { 
        //             return $admin->user; 
        //         });
        //     }

        //     if(count($admins) > 0) {
        //         // Send sms using twilio to admins
        //         $account = env('TWILIO_ACCOUNT_SID');
        //         $token  = env('TWILIO_AUTH_TOKEN');
        //         $client = new Client($account, $token);

        //         foreach($admins as $admin) {
        //             $client->messages->create(
        //                 $admin->phone, 
        //                 [
        //                     'from' => env( 'TWILIO_FROM' ),
        //                     'body' => 'sms'
        //                 ]
        //             );
        //         }
        //         Notification::send($admins, new ServiceAdded());
        //     }
        // }

        $invoice = Invoice::create(['post_id' => $post_id, 'coupon_id' => $coupon_id, 'status' => $status]);
        
        $invoice_data_array = [];
        foreach($service_ids as $service_id){
            $invoice_data_array[] = ['service_id' => $service_id];
        }
        $invoice_data = $invoice->invoice_data()->createMany($invoice_data_array);
        flash("Your invoice has been created.")->success();
        $nextStepUrl = config('app.locale') . '/posts/' . $post_id;
        return redirect($nextStepUrl);
    }
}