$(document).ready(function () {
	
	$("form#new_session_form").on('submit', function(e){
		
	$(".form_group").removeClass("has_error");
    $(".help_block").remove();
	
    var formData = {
      price: $("#price").val(),
	  format: $("#format").val(),
	  hall: $("#hall").val(),
	  startDate: $("#startDate").val(),
	  endDate: $("#endDate").val(),
	  startHour: $("#startHour").val(),
    };
			  
    $.ajax({
      type: "POST",
      url:"eventos.php",
	  contentType: 'application/json; charset=utf-8',
      dataType: "json",
	  data:JSON.stringify(formData),
      encode: true,
    }).done(function (data) {
      console.log(data);
	  
	  if (!data.success) {
        if (data.errors.price) {
          $("#price_group").addClass("has_error");
          $("#price_group").append(
            '<div class="help_block">' + data.errors.price + "</div>"
          );
        }
		if (data.errors.format) {
          $("#format_group").addClass("has_error");
          $("#format_group").append(
            '<div class="help_block">' + data.errors.format + "</div>"
          );
        }
		if (data.errors.hall) {
          $("#hall_group").addClass("has_error");
          $("#hall_group").append(
            '<div class="help_block">' + data.errors.hall + "</div>"
          );
        }
		if (data.errors.startDate) {
          $("#date_group").addClass("has_error");
          $("#date_group").append(
            '<div class="help_block">' + data.errors.startDate + "</div>"
          );
        }
		if (data.errors.startDate) {
          $("#date_group").addClass("has_error");
          $("#date_group").append(
            '<div class="help_block">' + data.errors.endDate + "</div>"
          );
        }
		if (data.errors.date) {
          $("#date_group").addClass("has_error");
          $("#date_group").append(
            '<div class="help_block">' + data.errors.date + "</div>"
          );
        }
		if (data.errors.startHour) {
          $("#hour_group").addClass("has_error");
          $("#hour_group").append(
            '<div class="help_block">' + data.errors.startHour + "</div>"
          );
        }
		if (data.errors.global) {
          $("#global_group").addClass("has_error");
          $("#global_group").append(
            '<div class="help_block">' + data.errors.global + "</div>"
          );
        }
		
		
      } else {
        $("form#new_session_form").html(
          '<div class="alert alert-success">' + data.message + "</div>"
        );
      }
	  
    })
	.fail(function (jqXHR, textStatus) {
        $("form#new_session_form").html(
          '<div class="alert alert-danger">Could not reach server, please try again later. '+textStatus+'</div>'
        );
     });
	
    e.preventDefault();
  });
});