<?php 
	   //General Config File:
    require_once('../../assets/php/config.php');
	$prefix ="../../";
	include_once('formHall.php');	
	
	if(isset($_POST['new_hall'])){
		$data = array("option" => "new","number" => $_POST["number"],"cols" => $_POST["cols"],"rows" => $_POST["rows"], "cinema" => "1");
		FormHall::processesForm($data);
	}
	
?>