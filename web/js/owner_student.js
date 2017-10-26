$(".updatePaidFor").on("click", function() {
    var element = this;
    var paidStatus = "false";

    if ($(this).val() === "Paid") {
      paidStatus = "true";
    } else {
      paidStatus = "false";
    }
    $.ajax({
      url : "/owner_sessions_update_paid_for",
      type : "POST",
      data : {
        service_id : serviceId,
        paid_status : paidStatus
      },
      success: function(result) {
        if (result === "true") {
          $(element).removeClass("btn-warning");
          $(element).addClass("btn-success");
          $(element).val("Paid");
        } else {
          $(element).removeClass("btn-success");
          $(element).addClass("btn-warning");
          $(element).val("Not Paid");
        }
      },
      error: function() {
        console.log("error");
      }
    });
});
