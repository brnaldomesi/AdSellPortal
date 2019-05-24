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
use App\Models\Appointment;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Controllers\Post\Traits\CustomFieldTrait;
use App\Http\Controllers\Post\Traits\EditTrait;
use Illuminate\Http\Request;

class CalendarController extends FrontController
{
    use EditTrait, VerificationTrait, CustomFieldTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $req, $postId)
    {
        
        return (view('post/createOrEdit/multiSteps/calendar',['post_id' => $postId]));
    }

    public function inline(Request $req, $postId)
    {
        return (view('post/createOrEdit/multiSteps/calendar-inline',['post_id' => $postId]));
    }

    public function allbypost(Request $req, $postId, $page_type)
    {
        $calendars = Calendar::where('post_id', $postId)->get();
        $result = $this->makeCalendarData($calendars);
        if($page_type == "1"){
            $appointments = Appointment::where('post_id', $postId)->get();
            $appointments = $this->makeAppointmentData($appointments);
            $result = $result->concat($appointments);
        }   
        return json_encode($result);
    }

    public function remove(Request $req, $postId)
    {
        $deletedRows = Calendar::find($req->input('id'))->delete();
        return;
    }

    public function changeEvent(Request $req, $postId){
        $update_data = $req->input('update_data');
        $calendar = Calendar::find($update_data['id']);

        if($update_data['status']=="resize"){
            $calendar->to = $update_data['to'];
        }elseif($update_data['status']=="move"){
            $calendar->start_date = $update_data['start_date'] ;
            $calendar->end_date = $update_data['end_date'] ;
            $calendar->from = $update_data['from'] ;
            $calendar->to = $update_data['to'] ;
        }else{
            $calendar->note = $update_data['note'] ;
            $calendar->from = $update_data['from'] ;
            $calendar->to = $update_data['to'] ;
            $calendar->save();
            $calendar = $this->makeCalendarData(collect([$calendar]));
            return json_encode($calendar);
        }
        
        $calendar->save();

        return;
    }

    public function store(Request $req, $postId)
    {
        $note = $req->input('note');
        $start_date = $req->input('start_date');
        $end_date = $req->input('end_date');
        $from = $req->input('from');
        $to = $req->input('to');
        $days = $req->input('days');
        $start_date_time = strtotime($start_date);
        $end_date_time = strtotime(Date("Y-m-d", strtotime($start_date."1 Month")));
        
        $calendars = [];
        if($req->has('days') && count($days) !=0){
            for ($i=$start_date_time; $i<=$end_date_time; $i+=86400) {  
                 if(in_array(date('w', $i), $days)){
                     $calendar = Calendar::create([
                                                    'post_id' => $postId, 
                                                    'note'=> $note, 
                                                    'start_date' => date('Y-m-d', $i), 
                                                    'end_date' => date('Y-m-d', $i), 
                                                    'from' => $from, 
                                                    'to' => $to
                                                ]);
                    $calendars[] = $calendar;
                 }
            } 
            
        }else{
            $calendar = Calendar::create([
                'post_id' => $postId,
                'note' => $note, 
                'start_date' => $start_date, 
                'end_date' => $end_date, 
                'from' => $from, 
                'to' => $to
            ]);
            $calendars[] = $calendar;
        }
        
        $result = $this->makeCalendarData(collect($calendars));
        return json_encode($result);
    }

    public function makeCalendarData($calendars){
        $calendars = $calendars->map(function ($item){
                return [   
                    'id' => $item['id'],
                    'title' => $item['note'] == null ? "" : $item['note'],
                    'start' => date(DATE_W3C, strtotime($item['start_date'] .' ' . $item['from'] )),
                    'end' => date(DATE_W3C, strtotime($item['end_date'] .' ' . $item['to'] )),
                    'color' => 'green'
                ];
        });
        return $calendars;
    }

    public function makeAppointmentData($appointments){
        $appointments = $appointments->map(function ($item){
                return [   
                    'title' => $item['note'] == null ? "" : $item['note'],
                    'start' => date(DATE_W3C, strtotime($item['date'] .' ' . $item['from'] )),
                    'end' => date(DATE_W3C, strtotime($item['date'] .' ' . $item['to'] )),
                    'color' => 'blue',
                    'groupId' => $item['id'],
                    'editable' => false,
                    'overlap' => false
                    
                ];
        });
        return $appointments;
    }
}