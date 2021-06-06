$(document).ready(function(){
		//Get the data that is going to be used as a filter for events
		var selectedFeed = $('#hall_selector').find(':selected').data('feed');
		
		var modal = document.getElementById("myModal");
		var btn = document.getElementById("myBtn");
		var span = document.getElementsByClassName("close")[0];
	
	   var calendar = $('#calendar').fullCalendar({
		editable:true,
		header:{
		 left:'prev,next today',
		 center:'title',
		 right:'month,agendaWeek,agendaDay'
		},
		firstDay: 1,
		fixedWeekCount: false,
		eventSources: [ selectedFeed ],
		selectable:true,
		selectHelper:true,
		timeFormat: 'H:mm',
		eventOverlap: function(stillEvent, movingEvent) {
				return (stillEvent.start_time > stillEvent.end && stillEvent.end < movingEvent.start_time)
		},
		//Add event/session function when u click in any non-event date. Prepares the form to be seen as such
		select: function(start, end, allDay)
			{
				
			$(modal).fadeIn();
			
		    var x = document.getElementById("film_group");
			x.style.display = "none";
			x = document.getElementById("film_list");
			x.style.display = "block";
			
			document.getElementById("hall").value = document.getElementById("hall_selector").value;
			document.getElementById("startDate").value = $.fullCalendar.formatDate( start, "Y-MM-DD" );
			document.getElementById("endDate").value = $.fullCalendar.formatDate( end, "Y-MM-DD" );
			
			document.getElementById("sumbit_new").style.display = "block";
			document.getElementById("edit_inputs").style.display = "none";
			},
		editable:true,
		//Edit only the date/hour start of an event/session when u click,drag and drop an event.
		eventDrop:function(event)
		{
		 var e = {
		   "newDate" : $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss"),
			"idhall": document.getElementById("hall").value,
			"startHour":event.start_time,
			"startDate":event.date,
			"price": event.seat_price,
			"idfilm": event.film.idfilm,
			"format": event.format,
		 };
		 console.log(e);
		 console.log(event);
		 $.ajax({
		  url:"eventsProcess.php?drop=true",
		  contentType: 'application/json; charset=utf-8',
		  dataType: "json",
		  type:"PUT",
		  data:JSON.stringify(e),
           success: function(data) {
                alert("El evento se ha desplazado correctamente");
				calendar.fullCalendar('refetchEvents');
            },
            error: function(data) {
                alert("Ha habido un error al desplazar el evento");
            },
		 });
		},
		//Edit event/session function when u click an event. Prepares the form to be seen as such
		eventClick:function(event)
		{	
		 	$(modal).fadeIn();

		    var x = document.getElementById("film_group");
			x.style.display = "block";
			
			x = document.getElementById("film_list");
			x.style.display = "none";
			
			document.getElementById("hall").value = document.getElementById("hall_selector").value;
			document.getElementById("startDate").value = $.fullCalendar.formatDate( event.start, "Y-MM-DD" );
			document.getElementById("endDate").value = $.fullCalendar.formatDate( event.end, "Y-MM-DD" );
			document.getElementById("price").value = event.seat_price;
			document.getElementById("format").value = event.format;
			document.getElementById("startHour").value = event.start_time;
			
			document.getElementById("original_hall").value = document.getElementById("hall_selector").value;
			document.getElementById("original_start_time").value = event.start_time;
			document.getElementById("original_date").value = $.fullCalendar.formatDate( event.start, "Y-MM-DD" );
			
			document.getElementById("film_title").innerHTML = event.film.tittle;
			document.getElementById("film_lan").innerHTML = event.film.language;
			document.getElementById("film_dur").innerHTML = event.film.duration+" min";
			document.getElementById("film_img").src = "../img/films/"+event.film.img;
			document.getElementById("film_desc").innerHTML = event.film.description;
			document.getElementById("film_id").value = event.film.idfilm;
			document.getElementById("sumbit_new").style.display = "none";
			document.getElementById("edit_inputs").style.display = "grid";	
			
		},

	   });
	   //Once the filter changes, do the changes needed so full calendar research the events with the new hall
	   $('#hall_selector').change(onSelectChangeFeed);

		function onSelectChangeFeed() { 
			var feed = $(this).find(':selected').data('feed');
			$('#calendar').fullCalendar('removeEventSource', selectedFeed);
			$('#calendar').fullCalendar('addEventSource', feed);  
			selectedFeed = feed;
		};
		
		//When u click on the X the form closes. If the user close it because the operation has been complete. Restart the form correctly
		span.onclick = function() {
		   formout();
		}

		function formout(){
			$(modal).fadeOut(100,function(){
			var success = document.getElementById("success");
			if(success){
				calendar.fullCalendar('refetchEvents');
				$(".alert").remove();
				document.getElementById("session_form").style.display = "block";
				document.getElementById("price").value = "";
				document.getElementById("format").value = "";
				document.getElementById("film_id").value = "";
				document.getElementById("startHour").value ="";
			}
				$(".form_group").removeClass("has_error");
				$(".help_block").remove();
			});
		}
});
	
