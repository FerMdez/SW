<?php
    //General Config File:
    require_once('../assets/php/config.php');

    //Purchase form:
    require_once('includes/formPurchase.php');
    $form = new FormPurchase();
    $formHTML = $form->gestiona();

    //Page-specific content:
    $section = '<div class="code">
                    <h2>Completar la Compra</h2><hr />
                    <!-- Purchase Form -->
                    '.$formHTML.'
                </div>';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>