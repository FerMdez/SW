<?php    
    include('../../../assets/php/config.php');
    include('../includes/user_dao.php');

    $bd = new UserDAO('complucine');
    if($bd){
        $user = $bd->selectUserName(strtolower($_GET["user"]));
        if ($user->data_seek(0)) {
            echo "!avaliable";
        }
        else{
            echo "avaliable";
        }
    }
?>