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

	if(isset($_POST['edit_session'])){
		$data = array("option" => "edit_session","film" => $_POST["film"],"hall" => $_POST["hall"],"date" => $_POST["date"],"start" => $_POST["start"]
			,"price" => $_POST["price"],"format" => $_POST["format"],"repeat" => $_POST["repeat"], "cinema" => $_SESSION["cinema"]
			, "origin_hall"=> $_POST["origin_hall"],"origin_date"=> $_POST["origin_date"],"origin_start"=> $_POST["origin_start"]);
		FormSession::processesForm($data);
	}

	if(isset($_POST['delete_session'])){
		$data = array("option" => "delete_session","cinema" => $_SESSION["cinema"], "hall"=> $_POST["origin_hall"]
					 ,"date"=> $_POST["origin_date"],"start"=> $_POST["origin_start"]);
		FormSession::processesForm($data);
	}
?>