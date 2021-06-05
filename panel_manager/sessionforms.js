$(document).ready(function () {
	
	//New form session
	$('#sumbit_new').click( function(e) {
		$(".form_group").removeClass("has_error");
		$(".help_block").remove();
		
		var formData = {
		  price: $("#price").val(),
		  format: $("#format").val(),
		  hall: $("#hall").val(),
		  startDate: $("#startDate").val(),
		  endDate: $("#endDate").val(),
		  startHour: $("#startHour").val(),
		  idFilm: $("#film_id").val(),
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
		  checkErrors(data,"session_form");
		})
		.fail(function (jqXHR, textStatus) {
			$("form#session_form").html(
			  '<div class="alert alert-danger">Could not reach server, please try again later. '+textStatus+'</div>'
			);
     });
	     e.preventDefault();
  });
	//Edit session
	$('#sumbit_edit').click( function(e) {
		$(".form_group").removeClass("has_error");
		$(".help_block").remove();
		
		
		var formData = {
		  price: $("#price").val(),
		  format: $("#format").val(),
		  hall: $("#hall").val(),
		  startDate: $("#startDate").val(),
		  endDate: $("#endDate").val(),
		  startHour: $("#startHour").val(),
		  idFilm: $("#film_id").val(),
		  og_hall: $("#original_hall").val(),
		  og_date: $("#original_date").val(),
		  og_start: $("#original_start_time").val(),
		};
		console.log(formData);
		
		$.ajax({
		  type: "PUT",
		  url:"eventos.php",
		  contentType: 'application/json; charset=utf-8',
		  dataType: "json",
		  data:JSON.stringify(formData),
		  encode: true,
		}).done(function (data) {
		  console.log(data);
		  checkErrors(data,"session_form");
		})
		.fail(function (jqXHR, textStatus) {
			$("form#session_form").html(
			  '<div class="alert alert-danger">Could not reach server, please try again later. '+textStatus+'</div>'
			);
     });
	     e.preventDefault();
  });
	/*
  	$('#sumbit_del').click( function(e) {
		$(".form_group").removeClass("has_error");
		$(".help_block").remove();
		
		var formData = {
		  og_hall: $("#original_hall").val(),
		  og_date: $("#original_date").val(),
		  og_start: $("#original_start_time").val(),
		};
				
		$.ajax({
		  type: "DELETE",
		  url:"eventos.php",
		  contentType: 'application/json; charset=utf-8',
		  dataType: "json",
		  data:JSON.stringify(formData),
		  encode: true,
		}).done(function (data) {
		  console.log(data);
		  checkErrors(data,"session_form");
		})
		.fail(function (jqXHR, textStatus) {
			$("form#session_form").html(
			  '<div class="alert alert-danger">Could not reach server, please try again later. '+textStatus+'</div>'
			);
     });
	     e.preventDefault();
  });*/
  
	function checkErrors(data,formname) {
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
			if (data.errors.idfilm) {
			  $("#film_msg_group").addClass("has_error");
			  $("#film_msg_group").append(
				'<div class="help_block">' + data.errors.idfilm + "</div>"
			  );
			}
			if (data.errors.global) {
			  $("#global_group").addClass("has_error");
			  $("#global_group").append(
				'<div class="help_block">' + data.errors.global + "</div>"
			  );
			}
      } else {
		$("#operation_msg").addClass("has_no_error");
		$("#operation_msg").append(
			'<div class="alert alert-success" id="success">' + data.message + "</div>"
		 );
		 document.getElementById("session_form").style.display = "none";

		}
			
	}

		
	$('.film_button').bind('click', function(e) {
            var id = $(this).attr('id'); 
			
			var x = document.getElementById("film_group");
			x.style.display = "block";
			
			var tittle = document.getElementById("title"+id);
			document.getElementById("film_title").innerHTML = tittle.innerHTML;
			
			var lan = document.getElementById("lan"+id);
			document.getElementById("film_lan").innerHTML = lan.value;
			
			var dur = document.getElementById("dur"+id);
			document.getElementById("film_dur").innerHTML = dur.innerHTML;

			var img = document.getElementById("img"+id);
			document.getElementById("film_img").src = "../img/films/"+img.value;
			
			var desc = document.getElementById("desc"+id);
			document.getElementById("film_desc").innerHTML = desc.value;
			
			var idf = document.getElementById("id"+id);
			document.getElementById("film_id").value = idf.value;

			x = document.getElementById("film_list")
			x.style.display = "none";
			  

     });
		
	 $('#return').click( function() {
		 	var x = document.getElementById("film_group");
			x.style.display = "none";
			
			x = document.getElementById("film_list");
			x.style.display = "block";
		});
  
});