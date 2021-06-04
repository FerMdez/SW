/**
 * Práctica - Sistemas Web | Grupo D
 * CompluCine - FDI-cines
 */

function cambiarCSS(nuevo){
    if(nuevo.includes("main.css")){
        var viejo = "{$prefix}assets/css/highContrast.css";
        var oldName = "Alto Contraste";
    } else {
        var viejo = "{$prefix}assets/css/main.css";
        var oldName = "Contrast Normal";
    }

    var url = "../assets/php/common/changeCSS.php?css=" + nuevo;
	$.get(url);
    
    /* La idea era que cambiase todo dinámicamente sin refrescar la página */
    //document.getElementById('estilo').setAttribute('href', nuevo);
    //document.getElementById('cssChange').innerHTML = oldName;
    //document.getElementById('cssChange').setAttribute('onClick', 'cambiarCSS('+viejo+')');

    location.reload();
}