function cambiarCSS(nuevo){
    let highContrast;

    if(highContrast === true){
        highContrast = false;
    } else {
        highContrast = true;
    }
    
    //window.location.href += "?highContrast=" + highContrast;
    document.getElementById('estilo').setAttribute('href', nuevo);
}