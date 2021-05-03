<?php

    require_once('../assets/php/config.php');
	include_once('./includes/formHall.php');	
	require_once('../assets/php/common/hall.php');

	$form = new FormHall();
	
	
	if(isset($_POST['new'])) {
		$_SESSION["option"] = "new";
		echo "<h1> Crear una Sala </h1>";
		$form->gestiona();
	}

?>