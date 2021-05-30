/**
 * Práctica - Sistemas Web | Grupo D
 * CompluCine - FDI-cines
 */

function confirmDelete() {
	if(confirm("¿Está seguro de que desea eliminar su cuenta de usuario?\nEsta acción no se puede deshacer.")){
		document.formDeleteAccount.submit();
	} else {
		location.href = "./";
	}
}