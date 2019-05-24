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
});
