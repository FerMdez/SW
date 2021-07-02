
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
		eventSources: [ selectedFeed ],
		selectable:true,
		selectHelper:true,
		timeFormat: 'H:mm',
		select: function(start, end, allDay)
			{
			modal.style.display = "block";
			/*
			  var e = {
				"date"  : $.fullCalendar.formatDate(allDay,"Y-MM-DD"),
				"start" : $.fullCalendar.formatDate(start, "HH:mm"),
				"end"   : $.fullCalendar.formatDate(end, "HH:mm")
			  };
			  $.ajax({
			   url:"eventos.php",
			   type:"POST",
			   contentType: 'application/json; charset=utf-8',
			   dataType: "json",
			   data:JSON.stringify(e),
			   success:function()
			   {
				calendar.fullCalendar('refetchEvents');
				alert("Added Successfully");
			   }
			  })*/
			},
		editable:true,
		eventResize:function(event)
		{
		 var e = {
		   "id"    : event.id,
		   "userId": event.userId,
		   "start" : $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss"),
		   "end"   : $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss"),
		   "title" : event.title
		 };
		 
		 $.ajax({
		  url:"eventos.php?idEvento="+event.id,
		  type:"PUT",
		  contentType: 'application/json; charset=utf-8',
		  dataType:"json",
		  data:JSON.stringify(e),
		  success:function(){
		   calendar.fullCalendar('refetchEvents');
		   alert('Event Update');
		  }
		 })
		},

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
		  url:"eventos.php?idEvento="+event.id,
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
		 if(confirm("Are you sure you want to remove it?"))
		 {
		  var id = event.id;
		  $.ajax({
		   url:"eventos.php?idEvento="+id,
		   contentType: 'application/json; charset=utf-8',
		   dataType: "json",
		   type:"DELETE",
		   success:function()
		   {
			calendar.fullCalendar('refetchEvents');
			alert("Event Removed");
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		   }
		  })
		 }
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
		  modal.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		  if (event.target == modal) {
			modal.style.display = "none";
		  }
		}
});
	
