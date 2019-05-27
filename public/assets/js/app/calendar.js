$(document).ready(function () {
  var calendar;
  var calendarEl = document.getElementById("calendar");

  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: ["interaction", "dayGrid", "timeGrid", "bootstrap"],
    timeZone: "UTC",
    themeSystem: "bootstrap",
    selectable: true,
    editable: true,
    header: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay"
    },
    weekNumbers: true,
    defaultView: 'timeGridWeek',
    eventLimit: true, // allow "more" link when too many events
    events: "/posts/" + $("#post_id").val() + "/calendar/allbypost/" + $("#page_type").val(),
    dateClick: function (info) { },
    eventClick: function (info) {
      if (info.event.backgroundColor == "green") {
        $("#note").val(info.event.title);
        $("#start_date").val(info.event.start.getFullYear() + "-" + (info.event.start.getMonth() + 1) + "-" + info.event.start.getDate());
        $("#end_date").val(info.event.end.getFullYear() + "-" + (info.event.end.getMonth() + 1) + "-" + info.event.end.getDate());
        $("#from").val(info.event.start.getUTCHours() + ":" + info.event.start.getUTCMinutes());
        $("#to").val(info.event.end.getUTCHours() + ":" + info.event.end.getUTCMinutes());
        $("#start_date").prop("disabled", true);
        $("#end_date").prop("disabled", true);
        $("#add_status").val("0");
        $("#event_id").val(info.event.id);
        $("#addEventModal").modal("show");
      }
      if (info.event.backgroundColor == "blue") {
        $.ajax({
          type: "GET",
          url: "/posts/calendar-appointment",
          dataType: "json",
          data: {
            id: info.event.groupId
          }
        }).done(function (data) {
          $("#a_full_name").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + data.full_name);
          $("#a_mobile_number").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + data.mobile_number);
          $("#a_email").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + data.email);
          $("#a_budget").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + data.budget);
          $("#a_payment_method").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + data.payment_method);
          $("#a_date").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + data.date + ' : ' + data.from + " To " + data.to);
          $("#appointmentModal").modal("show");
        });

      }

    },
    select: function (info) {
      // var groupId = info.jsEvent.target.fcSeg.eventRange.def.groupId;
      if (info.jsEvent.target.fcSeg === undefined || (info.jsEvent.target.fcSeg != undefined && info.jsEvent.target.fcSeg.eventRange.def.groupId == "")) {
        $("#start_date").val(info.start.getFullYear() + "-" + (info.start.getMonth() + 1) + "-" + info.start.getDate());
        $("#end_date").val(info.end.getFullYear() + "-" + (info.end.getMonth() + 1) + "-" + info.end.getDate());
        $("#from").val(info.start.getUTCHours() + ":" + info.start.getUTCMinutes());
        $("#to").val(info.end.getUTCHours() + ":" + info.end.getUTCMinutes());
        $("#event_id").val(info.id);
        $("#add_status").val("1");
        $("#addEventModal").modal("show");
      }
    },
    eventDrop: function (info) {
      if (info.event.backgroundColor == "green") {
        var update_data = {};
        update_data.start_date = info.event.start.getFullYear() + "-" + (info.event.start.getMonth() + 1) + "-" + info.event.start.getDate();
        update_data.end_date = info.event.end.getFullYear() + "-" + (info.event.end.getMonth() + 1) + "-" + info.event.end.getDate();
        update_data.from = info.event.start.getUTCHours() + ":" + info.event.start.getUTCMinutes();
        update_data.to = info.event.end.getUTCHours() + ":" + info.event.end.getUTCMinutes();
        update_data.status = "move";
        update_data.id = info.event.id;
        $("#event_id").val(info.event.id);
        changeEvent(update_data);
      } else {
        info.el.draggable = false;
      }
    },
    eventResize: function (info) {

      var hours = info.event.end.getUTCHours();
      var minutes = info.event.end.getUTCMinutes();
      var update_data = {};
      update_data.to = hours + ":" + minutes;
      update_data.status = "resize";
      update_data.id = info.event.id;
      $("#event_id").val(info.event.id);
      changeEvent(update_data);

    }
  });

  calendar.render();

  $(".selectpicker").selectpicker();
  $("#start_date").datepicker({
    showOtherMonths: true,
    format: "yyyy-mm-dd"
  });

  $("#end_date").datepicker({
    showOtherMonths: true,
    format: "yyyy-mm-dd"
  });

  $("#from").timepicker({
    showOtherMonths: true
  });

  $("#to").timepicker({
    showOtherMonths: true
  });
  $("#removeBtn").on("click", function () {

    if ($("#event_id").val() == "" || $("#event_id").val() == null)
      return;
    calendar.getEventById($("#event_id").val()).remove();
    $.ajax({
      type: "POST",
      url: "/posts/" + $("#post_id").val() + "/calendar/remove",
      dataType: "json",
      data: {
        id: $("#event_id").val()
      }
    }).done(function (data) {
      calendar.getEventById($("#event_id").val()).remove();
      $("#event_id").val("");
      $("#add_status").val("1");
    });
  });
  $("#eventSaveBtn").on("click", function () {
    if ($("#add_status").val() == "0") {
      // Edit Event

      var update_data = {};
      update_data.note = $("#note").val();
      update_data.from = $("#from").val();
      update_data.to = $("#to").val();
      update_data.id = $("#event_id").val();
      update_data.status = "edit";
      if ($("#event_id").val() != "") {
        changeEvent(update_data);
        calendar.getEventById($("#event_id").val()).remove();
      }

      $("#addEventModal").modal("hide");
    } else {
      // Add New Event

      var days = [];
      $("ul li.selected").each(function () {
        days.push($("li").index($(this)));
      });

      $.ajax({
        type: "POST",
        url: "/posts/" + $("#post_id").val() + "/calendar/add",
        dataType: "json",
        data: {
          start_date: $("#start_date").val(),
          end_date: $("#end_date").val(),
          note: $("#note").val(),
          from: $("#from").val(),
          to: $("#to").val(),
          days: days
        }
      }).done(function (data) {
        data.forEach(event => {
          calendar.addEvent(event);
        });
        $("#addEventModal").modal("hide");
      });
    }
  });

  $("#addEventBtn").on("click", function () {
    $("#addEventModal").modal("show");
  });

  $("#finishBtn").on("click", function () {
    window.parent.location.href = "/posts/" + $("#post_id").val();
  });
  function changeEvent(update_data) {
    $.ajax({
      type: "PUT",
      url: "/posts/" + $("#post_id").val() + "/calendar/changeEvent",
      dataType: "json",
      data: {
        update_data: update_data
      }
    }).done(function (data) {
      if ($("#add_status").val() == "0") {
        $("#start_date").prop("disabled", false);
        $("#end_date").prop("disabled", false);
        $("#add_status").val("1")
        data.forEach(event => {
          calendar.addEvent(event);
        });
      }
    });
  }
});
