<?php 
	//General Config File:
    require_once('../../assets/php/config.php');
	
	$prefix ="../../";
	include_once('formHall.php');	
	include_once('formSession.php');
	
	if(isset($_POST['new_hall'])){
		$data = array("option" => "new_hall","number" => $_POST["number"],"cols" => $_POST["cols"],"rows" => $_POST["rows"], "cinema" => $_SESSION["cinema"]);
		FormHall::processesForm($data);
	}
	
	if(isset($_POST['new_session'])){
		$data = array("option" => "new_session","film" => $_POST["film"],"hall" => $_POST["hall"],"date" => $_POST["date"],"start" => $_POST["start"]
			,"price" => $_POST["price"],"format" => $_POST["format"],"repeat" => $_POST["repeat"], "cinema" => $_SESSION["cinema"]);
		FormSession::processesForm($data);
	}
?>