<?php
    //General Config File:
    require_once('../assets/php/config.php');
    
    //Login form validate:
    require_once('./includes/formRegister.php');
    $reply = FormRegister::getReply();

    $section =  '<!-- Reply -->
        <section class="reply">
            <div class ="row">
                <div class="column side"></div>
                <div class="column middle">
                    <div class="code info">
                        '.$reply.'
                    </div>
                </div>
                <div class="column side"></div>    
            </div>
        </section>
        ';

    require RAIZ_APP.'/HTMLtemplate.php';
?>