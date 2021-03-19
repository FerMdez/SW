<?php
    $page = $_SERVER['PHP_SELF'];
    $prefix = '../';

    switch(true){
        case strpos($page, 'detalles'): $page = 'Detalles'; break;
        case strpos($page, 'bocetos'): $page = 'Bocetos'; break;
        case strpos($page, 'miembros'): $page = 'Miembros'; break;
        case strpos($page, 'planificacion'): $page = 'Planificación'; break;
        case strpos($page, 'contacto'): $page = 'Contacto'; break;
        default: $page = 'FDI-Cines'; $prefix = './'; break;
    }
    
    echo"<div class='header'>
            <a href='{$prefix}'><img src='{$prefix}img/favicon2.png' /> CompluCine</a> | {$page}
            <div class='menu'>
                <nav>
                    <li>Iniciar Sesión</li>
                    <li>Menú
                        <ul>
                            <li><a href='{$prefix}'>Inicio</a></li>
                            <li><a href='{$prefix}detalles/'>Detalles</a></li>
                            <li><a href='{$prefix}bocetos/'>Bocetos</a></li>
                            <li><a href='{$prefix}miembros/'>Miembros</a></li>
                            <li><a href='{$prefix}planificacion/'>Planificación</a></li>
                            <li><a href='{$prefix}contacto/'>Contacto</a></li>
                        <ul>
                    </li>
                </nav>
            </div>
        </div>\n";
?>