<?php    
    include('../../../assets/php/config.php');
    include('../includes/promotion_dao.php');

    $bd = new Promotion_DAO('complucine');
    if($bd){
        $promo = $bd->GetPromotionObj($_GET["code"]);
        if ($promo && $promo->getActive()) {
            echo "avaliable";
        }
        else{
            echo "!avaliable";
        }
    }
?>