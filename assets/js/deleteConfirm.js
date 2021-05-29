/**
 * Práctica - Sistemas Web | Grupo D
 * CompluCine - FDI-cines
 */

function confirmDelete() {
	let _delete = confirm("¿Está seguro de que desea eliminar su cuenta de usuario?\nEsta acción no se puede deshacer.");

	if(_delete){
		document.formDeleteAccount.submit();
	}
}

/*
$(document).ready(function() {
	document.getElementById("submit").onclick=function(){
		let _delete = confirm("¿Está seguro de que desea eliminar su cuenta de usuario?\nEsta acción no se puede deshacer.");

		if(_delete){
			document.formDeleteAccount.submit();
		}
	}
});
*/