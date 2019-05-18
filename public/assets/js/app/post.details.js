$(document).ready(function() {
  var token = $('meta[name="csrf-token"]').attr("content");
  if (token) {
    $.ajaxSetup({
      headers: { "X-CSRF-TOKEN": token }
    });
  }

  $("#fastSellBtn").click(function() {
    $("#fastSellModal").modal("show");
  });

  $("#fastSellSave").click(function() {
    if (!$("#fastSellCheck").prop("checked")) {
      alert("Please check to sell fast.");
      return;
    }

    $.ajax({
      type: "POST",
      url: siteUrl + "/fastsell",
      dataType: "json",
      data: {
        postId: $("#post_id").val(),
        _token: $("input[name=_token]").val()
      }
    }).done(function(data) {
      if (data.code == 200) alert("Success!");
      $("#fastSellModal").modal("hide");
    });
  });

  $("#renewBtn").click(function() {
    $.ajax({
      type: "POST",
      url: siteUrl + "/renew",
      dataType: "json",
      data: {
        postId: $("#post_id").val(),
        _token: $("input[name=_token]").val()
      }
    }).done(function(data) {
      if (data.code == 200) {
        window.location.href = siteUrl + "/posts/" + data.postId + "/payment";
      }
    });
  });

  // Open Services modal
  // $("#addonServices").click(function() {
  //   showServices(this);
  // });

  // //Check/uncheck all services

  // $("#check_all").change(function() {
  //   $("#service_list")
  //     .find(".service_check")
  //     .prop("checked", $(this).prop("checked"));
  // });

  //Save addon_services into LocalStorage
  // $("#service_save").click(function() {
  //   var service_list = [];
  //   $("#service_list")
  //     .find(".service_check:checked")
  //     .each(function() {
  //       let service_item = {
  //         id: $(this).val(),
  //         title: $(this).attr("data-title"),
  //         price: $(this).attr("data-price")
  //       };
  //       service_list.push(service_item);
  //     });

  //   localStorage.setItem("addon_services", JSON.stringify(service_list));
  //   $("#ServicePage").modal("hide");
  //   //JSON.parse(localStorage.getItem("addon_services")));
  // });
});

// function showServices(elmt) {
//   var postId = $(elmt).attr("post-id");

//   $.ajax({
//     type: "GET",
//     url: siteUrl + "/posts/" + postId + "/invoice_data/",
//     dataType: "json",
//     data: {
//       _token: $("input[name=_token]").val()
//     }
//   }).done(function(data) {
//     var service_html = "";

//     $.each(data.service_list, function(i, item) {
//       var checked = "";
//       var disabled = "";
//       var ordered = "";
//       for (i = 0, len = data.addon_services.length; i < len; i++) {
//         if (item.id == data.addon_services[i].id) {
//           checked = "checked";
//           disabled = "disabled";
//           ordered = "_ordered";
//           break;
//         }
//       }
//       var check_box_id = "check_box_" + item.id;
//       service_html +=
//         '<span class="input-group-text1">' +
//         '<input class="service_check' +
//         ordered +
//         '" data-price="' +
//         item.price +
//         '" data-title="' +
//         item.name +
//         '" type="checkbox" value="' +
//         item.id +
//         '" id="' +
//         check_box_id +
//         '" ' +
//         checked +
//         " " +
//         disabled +
//         " >" +
//         "&nbsp;&nbsp;" +
//         '<label class="check_label" for="' +
//         check_box_id +
//         '"><small>' +
//         item.name +
//         "</small>" +
//         "</span></label>";
//     });

//     $("#service_list").html(service_html);
//     $("#ServicePage").modal("show");
//   });

//   return false;
// }
