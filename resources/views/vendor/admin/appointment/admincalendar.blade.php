<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <script src="{{ url('/assets/js/app/admincalendar.js') }}"></script>
  </head>
  <body style="background: transparent;">
    <div class="row" >
      <div class="col">
        <button type="button" class="btn btn-default waves-effect waves-light" id="addEventBtn">Add Event</button>
      </div>
    </div>
    <div id='calendar'></div>
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="col-sm-12">

                        <table class="table table-hover">
                            <thead class="blue white-text">
                                <tr>
                                    <th> No </th>
                                    <th> Date </th>
                                    <th> From </th>
                                    <th> to </th>
                                    <th> Note </th>
                                    <th> Name </th>
                                    <th> Phone </th>
                                    <th> Email </th>
                                    <th> Budget </th>
                                    <th> Payment </th>
                                    <th> Type </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($appointments))
                                    @for ($i = 0; $i < count($appointments); $i++)
                                        <tr data-id="{{ $appointments[$i]->id }}">
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $appointments[$i]->date }}</td>
                                            <td>{{ $appointments[$i]->from }}</td>
                                            <td>{{ $appointments[$i]->to }}</td>
                                            <td>{{ $appointments[$i]->note }}</td>
                                            <td>{{ $appointments[$i]->full_name }}</td>
                                            <td>{{ $appointments[$i]->mobile_number }}</td>
                                            <td>{{ $appointments[$i]->email }}</td>
                                            <td>{{ $appointments[$i]->budget }}</td>
                                            <td>{{ $appointments[$i]->payment_method }}</td>
                                            <td>{{ $appointments[$i]->type }}</td>
                                        </tr>
                                    @endfor
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="post_id" value="{{ $post_id }}">
    <input type="hidden" id="event_id">
    <div id="addAppointmentModal" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New Appointment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="md-form input-group mt-0 mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text md-addon" ><i class="fas fa-book prefix"></i></span>
                </div>
                <input type="text" class="form-control" id="full_name" placeholder="Full Name" aria-describedby="Full Name">
            </div>
            <div class="md-form input-group mt-0 mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text md-addon" ><i class="fas fa-phone prefix"></i></span>
                </div>
                <input type="number" class="form-control" id="mobile_number" placeholder="Enter mobile number" aria-describedby="">
            </div>
            <div class="md-form input-group mt-0 mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text md-addon" ><i class="fas fa-envelope-open-text prefix"></i></span>
                </div>
                <input type="text" class="form-control" id="email" placeholder="Email" aria-describedby="Email">
            </div>
            <div class="md-form input-group mt-0 mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text md-addon" ><i class="fas fa-money-check-alt prefix"></i></span>
                </div>
                <input type="number" class="form-control" id="budget" placeholder="Budget" aria-describedby="Budget">
            </div>
            <div class="md-form input-group mt-0 mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text md-addon" ><i class="fas fa-cog prefix"></i></span>
                </div>
              <select id="payment_method" class="selectpicker" data-live-search="true" name="payment_method">
                <option value=""></option>
                <option value="PayPal">PayPal</option>
              </select>
            </div>
            <div class="md-form input-group mt-0 mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text md-addon"><i class="fas fa-cog prefix"></i></span>
              </div>
              <select id="type" class="selectpicker" data-live-search="true" name="type">
                <option value=""></option>
                <option value="Personal">Personal</option>
                <option value="Investor">Investor</option>
                <option value="Company">Company</option>
              </select>
            </div>  
            <div class="md-form input-group mt-0 mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text md-addon" ><i class="fas fa-book-open prefix"></i></span>
                </div>
                <input type="text" class="form-control" id="note" placeholder="Note" aria-describedby="Note">
            </div>
            <div class="md-form input-group mt-0 mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text md-addon"><i class="fas fa-calendar-alt prefix"></i></span>
              </div>
                <input type="text" class="form-control" id="date" placeholder="Choose date" aria-describedby="Choose date">
            </div>  
            <div class="md-form input-group mt-0 mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text md-addon"><i class="fas fa-clock prefix"></i></span>
              </div>
                <input type="text" class="form-control" id="from" placeholder="" aria-describedby="">
            </div>  
            <div class="md-form input-group mt-0 mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text md-addon"><i class="fas fa-clock prefix"></i></span>
              </div>
                <input type="text" class="form-control" id="to" placeholder="" aria-describedby="">
            </div>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary waves-effect waves-light" id="eventSaveBtn" data-status="0">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="removeBtn">Remove</button>
          </div>
        </div>
      </div>
    </div> 
  </body>
</html>