/**
 * Práctica - Sistemas Web | Grupo D
 * CompluCine - FDI-cines
 */

/* TO-DO: NO FUNCIONA LA PETICIÓN AJAX */

$(document).ready(function() {
	document.getElementById("submit").onclick=function(){
		let _delete = confirm("¿Está seguro de que desea eliminar su cuenta de usuario?\nEsta acción no se puede deshacer.");

		if(_delete == true){
			//console.log(location.href += "&reply=" + _delete);
			//location.href += "&reply=" + _delete;
			$.ajax({
				url:"./?option=delete_user",
				type: "POST",
				data: {reply: "true"},
				success:function(data){
					console.log(data.reply);
				},
				error:function(data){
					console.log(data.reply);
				}
			 });
		}
	}
});