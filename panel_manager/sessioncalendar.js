
$(document).ready(function(){
	
		var selectedFeed = $('#hall_selector').find(':selected').data('feed');
		var modal = document.getElementById("myModal");

		// Get the button that opens the modal
		var btn = document.getElementById("myBtn");

		// Get the <span> element that closes the modal
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
		eventDrop:function(event)
		{
		 var e = {
		   "id"    : event.id,
		   "userId": event.userId,
		   "start" : $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss"),
		   "end"   : $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss"),
		   "title" : event.title
		 };
		 $.ajax({
		  url:"eventos.php?idEvento="+event.id+"resize=true",
		  contentType: 'application/json; charset=utf-8',
		  dataType: "json",
		  type:"PUT",
		  data:JSON.stringify(e),
		  success:function()
		  {
		   calendar.fullCalendar('refetchEvents');
		   alert("Event Updated");
		  }
		 });
		},
		
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
	   
	   $('#hall_selector').change(onSelectChangeFeed);

		function onSelectChangeFeed() { 
			var feed = $(this).find(':selected').data('feed');
			$('#calendar').fullCalendar('removeEventSource', selectedFeed);
			$('#calendar').fullCalendar('addEventSource', feed);  
			selectedFeed = feed;
		};
		
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		   formout();
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		  if (event.target == modal) {
			 formout();
		  }
		}
		
		function formout(){
			$(modal).fadeOut(100,function(){
			var success = document.getElementById("success");
			if(success){
				calendar.fullCalendar('refetchEvents');
				calendar.fullCalendar('reren');
				success.style.display = "none";

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
	
