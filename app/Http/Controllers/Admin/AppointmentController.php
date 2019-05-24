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

use App\Models\Calendar;
use App\Models\Post;
use App\Models\Appointment;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Controllers\Post\Traits\CustomFieldTrait;
use App\Http\Controllers\Post\Traits\EditTrait;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AppointmentAdded;
use App\Models\AdminService;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
class AppointmentController extends FrontController
{
    use EditTrait, VerificationTrait, CustomFieldTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function adminindex(Request $req, $id)
    {
        
        return view('admin::appointment.index')->with('post_id', $id);
    }

    public function admincalendar(Request $req, $id)
    {
        $appointments = Post::find($id)->appointments;
        return view('vendor/admin/appointment/admincalendar', ['appointments' => $appointments, 'post_id' => $id]);
    }

    public function index(Request $req, $postId)
    {
        $appointments = Post::find($postId)->appointments;
        return (view('post/createOrEdit/multiSteps/appointment',['post_id' => $postId, 'appointments' => $appointments]));
    }

    public function allbypost(Request $req, $postId)
    {
        $calendars = Calendar::where('post_id', $postId)->get();
        $result = $this->makeCalendarData($calendars);
        $appointments = Appointment::where('post_id', $postId)->get();
        $appointments = $this->makeAppointmentData($appointments);
        $result = $result->concat($appointments);
           
        return json_encode($result);
    }

    public function checkAvailable(Request $req, $postId)
    {
        $update_data = $req->input('update_data');
        $temp_start = strtotime($update_data['from']);
        $temp_end = strtotime($update_data['to']);
        $available_times = Calendar::where('post_id', $postId)->get();
        $available = 0;
        
        foreach($available_times as $item) 
        {
            $calendar_start = strtotime($item['from']);
            $calendar_end = strtotime($item['to']);
            if(($temp_start >= $calendar_start && $temp_end <= $calendar_end) && ($temp_end >= $calendar_start && $temp_end <= $calendar_end)){
                $available = 1;
                break;
            }
        };
        return json_encode($available);
    }

    public function remove(Request $req, $postId)
    {
        $deletedRows = Appointment::find($req->input('id'))->delete();
        return json_encode("200");
    }

    public function changeEvent(Request $req, $postId){
        $update_data = $req->input('update_data');
        $appointment = Appointment::find($update_data['id']);

        if($update_data['status']=="resize"){
            $appointment->to = $update_data['to'];
        }elseif($update_data['status']=="move"){
            $appointment->date = $update_data['start_date'] ;
            $appointment->from = $update_data['from'] ;
            $appointment->to = $update_data['to'] ;
        }else{
            $appointment->full_name = $update_data['full_name'];
            $appointment->mobile_number = $update_data['mobile_number'];
            $appointment->email = $update_data['email'];
            $appointment->budget = $update_data['budget'];
            $appointment->payment_method = $update_data['payment_method'];
            $appointment->type = $update_data['type'];
            $appointment->note = $update_data['note'] ;
            $appointment->date = $update_data['date'];
            $appointment->from = $update_data['from'] ;
            $appointment->to = $update_data['to'] ;
            $appointment->save();
            $appointment = $this->makeAppointmentData(collect([$appointment]));
            return json_encode($appointment);
        }
        
        $appointment->save();

        /* Send Twillio SMS And Email */
        // $this->sendSMS($postId, $appointment->id); 

        return;
    }

    public function store(Request $req, $postId)
    {
        $update_data = $req->input('update_data');
        
        $appointment = Appointment::create([
            'post_id' => $postId,
            'full_name' => $update_data['full_name'],
            'mobile_number' => $update_data['mobile_number'],
            'email' => $update_data['email'],
            'budget' => $update_data['budget'],
            'payment_method' => $update_data['payment_method'],
            'type' => $update_data['type'],
            'note' => $update_data['note'] == null ? "" : $update_data['note'], 
            'date' => $update_data['date'], 
            'from' => $update_data['from'], 
            'to' => $update_data['to']
        ]);
        $appointment = collect([$appointment]);
        
        $result = $this->makeAppointmentData($appointment);

        /* Send Twillio SMS And Email */
        // $this->sendSMS($postId, $appointment->id); 
        
        return json_encode($result);
    }

    public function makeCalendarData($calendars){
        $calendars = $calendars->map(function ($item){
                return [   
                    'start' => date(DATE_W3C, strtotime($item['start_date'] .' ' . $item['from'] )),
                    'end' => date(DATE_W3C, strtotime($item['end_date'] .' ' . $item['to'] )),
                    'rendering' => 'background',
                    'editable' => false
                ];
        });
        return $calendars;
    }

    public function makeAppointmentData($appointments){
        $appointments = $appointments->map(function ($item){
                return [   
                    'id' => $item['id'],
                    'title' => $item['note'] == null ? "" : $item['note'],
                    'start' => date(DATE_W3C, strtotime($item['date'] .' ' . $item['from'] )),
                    'end' => date(DATE_W3C, strtotime($item['date'] .' ' . $item['to'] )),
                    'color' => 'blue'
                ];
        });
        return $appointments;
    }

    public function appointmentbyid(Request $req)
    {
        $appointment = Appointment::find($req->input('id'));
        return json_encode($appointment);
    }

    public function sendSms($postId, $appointmentId)
    {
        /* Twilio SMS AND EMAIL */
        $account = env('TWILIO_ACCOUNT_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $client = new Client($account, $token);
        $user = Post::with('user')->where('post_id', $postId)->first();
        $appointment = Appointment::find($appointmentId);
        $client->messages->create(
            $user->phone, 
            [
                'from' => env( 'TWILIO_FROM' ),
                'body' => 'sms'
            ]
        );
                
        Notification::send($user, new AppointmentAdded());
    }
    
}