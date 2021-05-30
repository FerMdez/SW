
  $(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
     editable:true,
     header:{
      left:'prev,next today',
      center:'title',
    right:''
     },
     events: 'eventos.php',
     selectable:true,
     selectHelper:true,
     select: function(start, end, allDay)
     {
      var title = confirm("¿Estas son las fechas correctas?");
      if(title)
      {
      
       var e = {
         "start" : $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss"),
         "end"   : $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss"),
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
       })
      }
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
   });