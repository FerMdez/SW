/**
 * Práctica - Sistemas Web | Grupo D
 * CompluCine - FDI-cines
 */

function cambiarCSS(nuevo){
    if(nuevo.includes("main.css")){
        var css = "main.css";
    } else {
        var css = "highContrast.css";
    }

    var url = "../assets/php/common/changeCSS.php?css=" + css;
	$.get(url);
    
    /* La idea era que cambiase todo dinámicamente sin refrescar la página */
    document.getElementById('estilo').setAttribute('href', nuevo);
    //document.getElementById('cssChange').innerHTML = oldName;
    //document.getElementById('cssChange').setAttribute('onClick', 'cambiarCSS('+viejo+')');

    location.reload();
}