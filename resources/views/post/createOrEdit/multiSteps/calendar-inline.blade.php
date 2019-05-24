<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" rel="stylesheet"/>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/plugins/fullcalendar/core/main.css') }}" rel='stylesheet' />
    <link href="{{ url('/assets/plugins/fullcalendar/daygrid/main.css') }}" rel='stylesheet' />
    <link href="{{ url('/assets/plugins/fullcalendar/timegrid/main.css') }}" rel='stylesheet' />
    <link href="{{ url('/assets/plugins/fullcalendar/bootstrap/main.css') }}" rel='stylesheet' />
    <link href="{{ url('/assets/material/css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/material/css/style.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/calendar-inline.css') }}" rel="stylesheet">
    

    <script src="{{ url('/assets/material/js/jquery-3.4.0.min.js') }}"></script>
    <script src="{{ url('/assets/material/js/popper.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/fullcalendar/core/main.js') }}"></script>
    <script src="{{ url('/assets/plugins/fullcalendar/daygrid/main.js') }}"></script>
    <script src="{{ url('/assets/plugins/fullcalendar/timegrid/main.js') }}"></script>
    <script src="{{ url('/assets/plugins/fullcalendar/interaction/main.js') }}"></script>
    <script src="{{ url('/assets/plugins/fullcalendar/bootstrap/main.js') }}"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="{{ url('/assets/js/app/calendar.js') }}"></script>
  </head>
  <body>
    <div class="row" >
      <div class="col">
        <button type="button" class="btn btn-default waves-effect waves-light" id="addEventBtn">Add Event</button>
      </div>
      <div class="col text-right"> 
        <button type="button" class="btn btn-secondary waves-effect waves-light" id="finishBtn"> Finish </button>
      </div>
    </div>
    <div id='calendar'></div>
    <input type="hidden" id="post_id" value="{{ $post_id }}">
    <input type="hidden" id="event_id">
    <input type="hidden" id="page_type" value="0">
    <div id="addEventModal" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New Event</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="md-form input-group mt-0 mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text md-addon" ><i class="fas fa-book prefix"></i></span>
                </div>
                <input type="text" class="form-control" id="note" placeholder="Note" aria-describedby="Note">
            </div>
            <div class="md-form input-group mt-0 mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text md-addon" ><i class="fas fa-calendar-alt prefix"></i></span>
                </div>
                <input type="text" class="form-control" id="start_date" placeholder="Start Date" aria-describedby="Start Date">
            </div>
            <div class="md-form input-group mt-0 mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text md-addon" ><i class="fas fa-calendar-alt prefix"></i></span>
                </div>
                <input type="text" class="form-control" id="end_date" placeholder="End Date" aria-describedby="End Date">
            </div>
            <div class="md-form input-group mt-0 mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text md-addon" ><i class="fas fa-clock prefix"></i></span>
                </div>
                <input type="text" class="form-control" id="from" placeholder="From" aria-describedby="From">
            </div>
            <div class="md-form input-group mt-0 mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text md-addon" ><i class="fas fa-clock prefix"></i></span>
                </div>
                <input type="text" class="form-control" id="to" placeholder="To" aria-describedby="To">
            </div>
            <div class="md-form input-group mt-0 mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text md-addon"><i class="fas fa-calendar prefix"></i></span>
              </div>
              <select id="days" class="selectpicker" multiple data-live-search="true">
                <option value="0">Sunday</option>
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Saturday</option>
              </select>
            </div>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary waves-effect waves-light" id="eventSaveBtn" data-status="0">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div> 
  </body>
</html>