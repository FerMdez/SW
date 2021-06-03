<?php 
	//General Config File:
    require_once('../../assets/php/config.php');
	
	$prefix ="../../";
	include_once('formHall.php');	
	include_once('formSession.php');
	
	if(isset($_POST['new_hall'])){
		$data = array("option" => "new_hall","number" => $_POST["number"],"cols" => $_POST["cols"],"rows" => $_POST["rows"], "cinema" => $_SESSION["cinema"], "seats" => 0);
		//Check what checkboxs are seats or not
		for($i = 1;$i<=$data["rows"];$i++){
			for($j=1; $j<=$data["cols"]; $j++){
				if(!empty($_POST['checkbox'.$i.$j.''])){
					$data[$i][$j] = $_POST['checkbox'.$i.$j.''];
					$data["seats"]++;
				} else $data[$i][$j] = "-1";
			}
		}
		FormHall::processesForm($data);
	}

	if(isset($_POST['edit_hall'])){
		$data = array("option" => "edit_hall","number" => $_POST["number"],"cols" => $_POST["cols"],"rows" => $_POST["rows"], "cinema" => $_SESSION["cinema"],"seats" => 0);
		//Check what checkboxs are seats or not
		for($i = 1;$i<=$data["rows"];$i++){
			for($j=1; $j<=$data["cols"]; $j++){
				if(!empty($_POST['checkbox'.$i.$j.''])){
					$data[$i][$j] = $_POST['checkbox'.$i.$j.''];
					$data["seats"]++;
				} else $data[$i][$j] = "-1";
			}
		}
		FormHall::processesForm($data);
	}

	if(isset($_POST['delete_hall'])){
		$data = array("option" => "delete_hall","number" => $_POST["number"], "cinema" => $_SESSION["cinema"]);
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
			, "origin_hall"=>$_SESSION["or_hall"],"origin_date"=> $_SESSION["or_date"],"origin_start"=> $_SESSION["or_start"]);
		
		$_SESSION["or_hall"] = "";
		$_SESSION["or_date"] = "";
		$_SESSION["or_start"] = "";
		FormSession::processesForm($data);
	}

	if(isset($_POST['delete_session'])){
		$data = array("option" => "delete_session","cinema" => $_SESSION["cinema"], "hall"=> $_POST["origin_hall"]
					 ,"date"=> $_POST["origin_date"],"start"=> $_POST["origin_start"]);
		FormSession::processesForm($data);
	}
	
?>