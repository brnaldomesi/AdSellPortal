$(document).ready(function () {
    var token = $('meta[name="csrf-token"]').attr("content");
    if (token) {
        $.ajaxSetup({
            headers: { "X-CSRF-TOKEN": token }
        });
    }
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
        eventLimit: true, // allow "more" link when too many events
        events: "/admin/posts/" + $("#post_id").val() + "/admincalendar/allbypost",
        dateClick: function (info) { },
        eventClick: function (info) {
            if (info.event.backgroundColor == "blue") {
                $.ajax({
                    type: "GET",
                    url: "/admin/posts/" + $("#post_id").val() + "/appointment-info",
                    dataType: "json",
                    data: {
                        id: info.event.id
                    }
                }).done(function (data) {
                    $("#full_name").val(data.full_name);
                    $("#mobile_number").val(data.mobile_number);
                    $("#email").val(data.email);
                    $("#budget").val(data.budget);
                    $("select[name=payment_method]").val(data.payment_method);
                    $("select[name=type]").val(data.type);
                    $('.selectpicker').selectpicker('refresh')
                    $("#note").val(data.note);
                    $("#date").val(data.date);
                    $("#from").val(data.from);
                    $("#to").val(data.to);
                    $("#eventSaveBtn").attr("data-status", "1");
                    $("#event_id").val(info.event.id);
                    $("#addAppointmentModal").modal("show");
                });

            }

        },
        select: function (info) {

            var update_data = {};
            update_data.start_date = info.start.getFullYear() + "-" + (info.start.getMonth() + 1) + "-" + info.start.getDate();
            update_data.end_date = info.end.getFullYear() + "-" + (info.end.getMonth() + 1) + "-" + info.end.getDate();
            update_data.from = info.start.getUTCHours() + ":" + info.start.getUTCMinutes();
            update_data.to = info.end.getUTCHours() + ":" + info.end.getUTCMinutes();
            $.ajax({
                type: 'GET',
                url: '/admin/posts/' + $("#post_id").val() + "/admincalendar/checkAvailable",
                dataType: 'json',
                data: {
                    update_data: update_data
                }
            }).done(function (data) {
                if (data == "1") {
                    $("#event_id").val(info.id);
                    $("#date").val(update_data.start_date);
                    $("#from").val(update_data.from);
                    $("#to").val(update_data.to);
                    $("#eventSaveBtn").attr("data-status", "0");
                    $("#addAppointmentModal").modal("show");
                } else {
                    alert("Please mark in availabe times");
                }
            })
        },
        eventDrop: function (info) {
            if (info.event.backgroundColor == "blue") {
                var update_data = {};
                update_data.start_date = info.event.start.getFullYear() + "-" + (info.event.start.getMonth() + 1) + "-" + info.event.start.getDate();
                update_data.end_date = info.event.end.getFullYear() + "-" + (info.event.end.getMonth() + 1) + "-" + info.event.end.getDate();
                update_data.from = info.event.start.getUTCHours() + ":" + info.event.start.getUTCMinutes();
                update_data.to = info.event.end.getUTCHours() + ":" + info.event.end.getUTCMinutes();
                update_data.status = "move";
                update_data.id = info.event.id;
                $("#event_id").val(info.event.id);
                $.ajax({
                    type: 'GET',
                    url: '/admin/posts/' + $("#post_id").val() + "/admincalendar/checkAvailable",
                    dataType: 'json',
                    data: {
                        update_data: update_data
                    }
                }).done(function (data) {
                    if (data == "1") {
                        changeEvent(update_data);
                    } else {
                        info.revert();
                        alert("Please mark in availabe times");
                    }
                })
            }
        },
        eventResize: function (info) {

            var update_data = {};
            update_data.start_date = info.event.start.getFullYear() + "-" + (info.event.start.getMonth() + 1) + "-" + info.event.start.getDate();
            update_data.end_date = info.event.end.getFullYear() + "-" + (info.event.end.getMonth() + 1) + "-" + info.event.end.getDate();
            update_data.date = info.event.start.getFullYear() + "-" + (info.event.start.getMonth() + 1) + "-" + info.event.start.getDate();
            update_data.from = info.event.start.getUTCHours() + ":" + info.event.start.getUTCMinutes();
            update_data.to = info.event.end.getUTCHours() + ":" + info.event.end.getUTCMinutes();
            update_data.status = "resize";
            update_data.id = info.event.id;
            $("#event_id").val(info.event.id);
            $.ajax({
                type: 'GET',
                url: '/admin/posts/' + $("#post_id").val() + "/admincalendar/checkAvailable",
                dataType: 'json',
                data: {
                    update_data: update_data
                }
            }).done(function (data) {
                if (data == "1") {
                    changeEvent(update_data);
                } else {
                    info.revert();
                    alert("Please mark in availabe times");

                }
            })

        }
    });

    calendar.render();
    $(".selectpicker").selectpicker();
    $(".filter-option-inner-inner:eq(0)").html("Choose payment method");
    $(".filter-option-inner-inner:eq(1)").html("Choose type");
    $("#date").datepicker({
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
        //calendar.getEventById($("#event_id").val()).remove();
        $.ajax({
            type: "POST",
            url: "/admin/posts/" + $("#post_id").val() + "/admincalendar/remove",
            dataType: "json",
            data: {
                id: $("#event_id").val()
            }
        }).done(function (data) {
            location.reload();
        });
    });

    $("#eventSaveBtn").on("click", function () {
        var update_data = {};
        update_data.full_name = $("#full_name").val();
        update_data.mobile_number = $("#mobile_number").val();
        update_data.email = $("#email").val();
        update_data.budget = $("#budget").val();
        update_data.payment_method = $("#payment_method").val();
        update_data.type = $("#type").val();
        update_data.note = $("#note").val();
        update_data.start_date = $("#date").val();
        update_data.end_date = $("#date").val();
        update_data.date = $("#date").val();
        update_data.from = $("#from").val();
        update_data.to = $("#to").val();
        update_data.id = $("#event_id").val();

        if ($("#eventSaveBtn").attr("data-status") == "1") {
            // Edit Event
            update_data.status = "edit";
            $.ajax({
                type: 'GET',
                url: '/admin/posts/' + $("#post_id").val() + "/admincalendar/checkAvailable",
                dataType: 'json',
                data: {
                    update_data: update_data
                }
            }).done(function (data) {
                if (data == "1") {
                    changeEvent(update_data);
                    calendar.getEventById($("#event_id").val()).remove();
                    $("#addEventModal").modal("hide");
                } else {
                    alert("Please mark in availabe times");
                }
            })

        } else {
            // Add New Event

            $.ajax({
                type: 'GET',
                url: '/admin/posts/' + $("#post_id").val() + "/admincalendar/checkAvailable",
                dataType: 'json',
                data: {
                    update_data: update_data
                }
            }).done(function (data) {
                if (data == "1") {
                    $.ajax({
                        type: "POST",
                        url: "/admin/posts/" + $("#post_id").val() + "/admincalendar/add",
                        dataType: "json",
                        data: {
                            update_data: update_data
                        }
                    }).done(function (data) {
                        location.reload();
                        // data.forEach(event => {
                        //     calendar.addEvent(event);
                        // });
                        // $("#addAppointmentModal").modal("hide");
                    });
                } else {
                    alert("Please mark in availabe times");
                }
            })
        }
    });

    $("#addEventBtn").on("click", function () {
        $("#eventSaveBtn").attr("data-status", "0");
        $("#addAppointmentModal").modal("show");
    });

    function changeEvent(update_data) {
        $.ajax({
            type: "PUT",
            url: "/admin/posts/" + $("#post_id").val() + "/admincalendar/changeEvent",
            dataType: "json",
            data: {
                update_data: update_data
            }
        }).done(function (data) {
            location.reload();
            // if ($("#eventSaveBtn").attr("data-status") == "1") {
            //     data.forEach(event => {
            //         calendar.addEvent(event);
            //     });
            // }
        });
    }
});
