/**
 * Práctica - Sistemas Web | Grupo D
 * CompluCine - FDI-cines
 */

// Método 1: recargar la página y enviar un GET.
window.onload = function(){
    if(!select_cinema()) select_film();
}

function select_cinema(){
    var select = document.getElementById("select_cinema");
    console.log(select);
    if(select != undefined){
        select.onchange = function(){
            location.href += "&cinema=" + $('select[id=cinemas]').val();
        }
        return true;
    } else {
        return false;
    }
}

function select_film(){
    var select_ = document.getElementById("select_film");
    select_.onchange = function(){
        location.href += "&film=" + $('select[id=films]').val();
    }
}


// Método 2: enviar una petición AJAX con POST. ==> (NO FUNCIONA, PERO LA IDEA ERA HACERLO ASÍ PARA EVITAR REFRESCAR LA PÁGINA Y LLENAR LA URL)
/*
$(document).ready(function(){
	$("#select_cinema").change(function(){
        var cinema =  $('select[id=cinemas]').val();
        //console.log($('select[id=cinemas]').val());

        $.ajax({
            url         : "index.php",
            type        : "post",
            dataType    : "html",
            data        : "",
            success: function(response){
                $("#cinemas > option[value="+ cinema +"]").attr("selected", true);
                console.log(cinema);
            },
            error: function(response){
                console.log(response + ' ==> Error al seleccionar el cine')
            }
        });
	});
});
*/