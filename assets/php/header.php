<?php
    $page = $_SERVER['PHP_SELF'];
    $prefix = '../';

    switch(true){
        case strpos($page, 'detalles'): $page = 'Detalles'; break;
        case strpos($page, 'bocetos'): $page = 'Detalles'; break;
        case strpos($page, 'miembros'): $page = 'Detalles'; break;
        case strpos($page, 'planificacion'): $page = 'Detalles'; break;
        case strpos($page, 'contacto'): $page = 'Detalles'; break;
        default: $page = 'FDI-Cines'; $prefix = './'; break;
    }
    
    echo"<div class='header'>
            <a href='{$prefix}'><img src='{$prefix}img/favicon2.png' /> CompluCine</a> | {$page}
            <div class='menu'>
                <a href='{$prefix}'>Inicio |</a>
                <a href='{$prefix}detalles/'>Detalles |</a>
                <a href='{$prefix}bocetos/'>Bocetos |</a>
                <a href='{$prefix}miembros/'>Miembros |</a>
                <a href='{$prefix}planificacion/'>Planificación |</a>
                <a href='{$prefix}contacto/'>Contacto</a>
            </div>
        </div>\n";
?>