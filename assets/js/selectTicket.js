// Método 1: recargar la página y enviar un GET.
window.onload = function(){
    var select = document.getElementById("select_cinema");
    select.onchange = function(){
        location.href += "&cinema=" + $('select[id=cinemas]').val();
    }
}

// Método 2: enviar una petición AJAX con POST. (NO FUNCIONA)
/*
$(document).ready(function(){
	$("#select_cinema_session").change(function(){
        var cinema =  $('select[id=cinemas]').val();
        //console.log($('select[id=cinemas]').val());
        $.ajax({
            url         : 'index.php',
            type        : 'POST',
            dataType    : 'text',
            data        : 'cinema='+cinema,
            cache       : false,
            async       : false,
            success: function(data){
                $("cinemas option").remove();
                $("cinemas").append(data);
                console.log(cinema);
            },
            error: function(response)
            {
                console.log(response + ' ==> Error al seleccionar el cine')
            }
        });
	});
});
*/

//Método 3: enviar una petición AJAX con GET. (NO FUNCIONA)
/*
$(document).ready(function(){
	$("#select_cinema_session").change(function(){
        var cinema =  $('select[id=cinemas]').val();
        //console.log($('select[id=cinemas]').val());
        $.get(window.location + "?cinema=" + cinema, function(data,status){
            console.log(cinema);
        });
	});
});
*/