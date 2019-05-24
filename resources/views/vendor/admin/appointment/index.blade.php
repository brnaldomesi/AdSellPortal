@extends('admin::layout')
@section('after_styles')
<style>
    .calendar-frame{
        width: 100%;
        height: 1050px;
        border: 0;
    }
</style>
@endsection
@section('content')
<div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col">
                <!-- @include('post.inc.notification') -->
                    <div id="calendarContainer" style="text-align:center;">
                        <iframe class="calendar-frame" src="{{ admin_url('posts/' . $post_id . '/admin-calendar') }}"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection