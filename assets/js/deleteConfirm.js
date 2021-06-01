/**
 * Práctica - Sistemas Web | Grupo D
 * CompluCine - FDI-cines
 */

function confirmDelete(e) {
	if(confirm("¿Está seguro de que desea eliminar su cuenta de usuario?\nEsta acción no se puede deshacer.")){
		document.getElementById("formDeleteAccount1").submit();
	} else {
		//location.href = "./";
		e.preventDefault();
	}
}