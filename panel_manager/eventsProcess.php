<?php
require_once('../assets/php/config.php');
include_once($prefix.'assets/php/includes/event.php');
include_once($prefix.'assets/php/includes/session.php');

$contentType= $_SERVER['CONTENT_TYPE'] ?? 'application/json';
$contentType = strtolower(str_replace(' ', '', $contentType));

// Verify the content type is supported
$acceptedContentTypes = array('application/json;charset=utf-8', 'application/json');
$found = false;
foreach ($acceptedContentTypes as $acceptedContentType) {
    if (substr($contentType, 0, strlen($acceptedContentType)) === $acceptedContentType) {
        $found=true;
        break;
    }
}

switch($_SERVER['REQUEST_METHOD']) {
    // Get Events
    case 'GET':
		error_log("GET");
		$hall =  $_GET["hall"];
		$cinema =  $_SESSION["cinema"];

		// Comprobamos si es una lista de eventos entre dos fechas -> eventos.php?start=XXXXX&end=YYYYY
		$start = filter_input(INPUT_GET, 'start', FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>"/\d{4}-((0[1-9])|(1[0-2]))-((0[1-9])|([1-2][0-9])|(3[0-1]))/")));
		$end = filter_input(INPUT_GET, 'end', FILTER_VALIDATE_REGEXP, array("options" => array("default" => null, "regexp"=>"/\d{4}-((0[1-9])|(1[0-2]))-((0[1-9])|([1-2][0-9])|(3[0-1]))/")));
		if ($start) {     
				
			$startDateTime = $start . ' 00:00:00';
			$endDateTime = $end;
			if ($end) {
				$endDateTime = $end. ' 00:00:00';
			}
			$result = Event::searchEventsBetween2dates($startDateTime, $endDateTime, $hall,$cinema);
		} else {
			// Comprobamos si es una lista de eventos completa
			$result = Event::searchAllEvents($hall,$cinema); 
		}
        
        // Generamos un array de eventos en formato JSON
        $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        http_response_code(200); // 200 OK
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Length: ' . mb_strlen($json));;

        echo $json;    
    break;
    // Add Session  
    case 'POST':
		error_log("POST");
		$errors = [];
		$data = [];
		
		//Correct reply to verify the session has been correctly added
		$correct_response = 'Operación completada';
		
		//Check if the body is ok
		$entityBody = file_get_contents('php://input');
		$dictionary = json_decode($entityBody);
		
		if (!is_object($dictionary))
            $errors['global'] = 'El cuerpo de la petición no es valido';
		
		$price = $dictionary->{"price"} ?? "";
		$format = $dictionary->{"format"} ?? "";
		$hall = $dictionary->{"hall"} ?? "";		
		$startDate = $dictionary->{"startDate"} ?? "";
		$endDate = $dictionary->{"endDate"} ?? "";		
		$startHour = $dictionary->{"startHour"} ?? "";		
		$idfilm = $dictionary->{"idFilm"} ?? "";	
		
		//Check errors in inputs
		if (empty($price) || $price <= 0 ) 
			$errors['price'] = 'El precio no puede ser 0.';
		if (empty($format)) 
			$errors['format'] = 'El formato no puede estar vacio. Ej: 3D, 2D, voz original';
		if (empty($hall) || $hall<=0 ) 
			$errors['hall'] = 'La sala no puede ser 0 o menor';
		if (empty($startDate)) 
			$errors['startDate'] = 'Las sesiones tienen que empezar algun dia.';
		else if (empty($endDate)) 
			$errors['endDate'] = 'Las sesiones tienen que teminar algun dia.';
		else {
			$start = strtotime($startDate);
			$end = strtotime($endDate);
			$start = date('Y-m-d', $start);
			$end = date('Y-m-d', $end);
			
			if($start > $end)
				$errors['date'] = 'La fecha inicial no puede ser antes o el mismo dia que la final.';
		}
		if (empty($startHour)) 
			$errors['startHour'] = 'Es necesario escoger el horario de la sesion.';
		
		if (!is_numeric($idfilm) && $idfilm <= 0 ) 
			$errors['idfilm'] = 'No se ha seleccionado una pelicula.';
		
		//Create as many sessions as the diference between start and end date tell us. 1 session per day
		while($startDate < $endDate && empty($errors)){
				$msg = Session::create_session($_SESSION["cinema"], $hall, $startHour, $startDate, $idfilm, $price, $format);
				
				if(strcmp($msg,$correct_response)!== 0)
					$errors['global'] = $msg;
				else
					$data['message'] = $msg;
				
				$startDate = date('Y-m-d H:i:s', strtotime( $startDate . ' +1 day'));
		}
		
		if (!empty($errors)) {
			$data['success'] = false;
			$data['errors'] = $errors;
		} else {
			$data['success'] = true;
		}
		
		echo json_encode($data);

    break;
	//Edit session
    case 'PUT':
		//Correct reply to verify the session has been correctly edited
		$correct_response = 'Se ha editado la session con exito';
		
		$errors = [];
		$data = [];
		
		//Check if the body is ok
		$entityBody = file_get_contents('php://input');
		$dictionary = json_decode($entityBody);
		
		if (!is_object($dictionary))
            $errors['global'] = 'El cuerpo de la petición no es valido';
		
		//Check if the user is droping an event in a new date
		if(isset($_GET["drop"]) && $_GET["drop"]){
			$or_hall = $dictionary->{"idhall"} ?? "";		
			$or_date = $dictionary->{"startDate"} ?? "";		
			$or_start = $dictionary->{"startHour"} ?? "";	
			$price = $dictionary->{"price"} ?? "";		
			$idfilm = $dictionary->{"idfilm"} ?? "";	
			$format = $dictionary->{"format"} ?? "";	
			
			$new_date = $dictionary->{"newDate"} ?? "";	
			
			$msg = Session::edit_session($_SESSION["cinema"], $or_hall, $or_date, $or_start, $or_hall, $new_date, $new_date, $idfilm, $price, $format);
			
			if(strcmp($msg,$correct_response)!== 0)
				http_response_code(400);
			 else
				http_response_code(200);
		}else{	
			//Edit session from a form
			$price = $dictionary->{"price"} ?? "";
			$format = $dictionary->{"format"} ?? "";
			$hall = $dictionary->{"hall"} ?? "";		
			$startDate = $dictionary->{"startDate"} ?? "";
			
			$endDate = $dictionary->{"endDate"} ?? "";		
			$startHour = $dictionary->{"startHour"} ?? "";		
			$idfilm = $dictionary->{"idFilm"} ?? "";	
			
			$or_hall = $dictionary->{"og_hall"} ?? "";		
			$or_date = $dictionary->{"og_date"} ?? "";		
			$or_start = $dictionary->{"og_start"} ?? "";	
			
			//Check errors in inputs
			if (empty($price) || $price <= 0 ) 
				$errors['price'] = 'El precio no puede ser 0.';
			if (empty($format)) 
				$errors['format'] = 'El formato no puede estar vacio. Ej: 3D, 2D, voz original';
			if (empty($hall) || $hall<=0 ) 
				$errors['hall'] = 'La sala no puede ser 0 o menor';
			if (empty($startDate)) 
				$errors['startDate'] = 'Las sesiones tienen que empezar algun dia.';
			else if (empty($endDate)) 
				$errors['endDate'] = 'Las sesiones tienen que teminar algun dia.';
			else {
				$start = strtotime($startDate);
				$end = strtotime($endDate);
				$start = date('Y-m-d', $start);
				$end = date('Y-m-d', $end);
				if($start > $end)
					$errors['date'] = 'La fecha inicial no puede ser antes o el mismo dia que la final.';
			}
			if (empty($startHour)) 
				$errors['startHour'] = 'Es necesario escoger el horario de la sesion.';
			
			if (!is_numeric($idfilm) && $idfilm <= 0 ) 
				$errors['idfilm'] = 'No se ha seleccionado una pelicula.';
			
			if(empty($errors)){				
					$msg = Session::edit_session($_SESSION["cinema"], $or_hall, $or_date, $or_start, $hall, $startHour, $startDate, $idfilm, $price, $format);
					
					if(strcmp($msg,$correct_response)!== 0)
						$errors['global'] = $msg;
					else
						$data['message'] = $msg;
			}
			
			if (!empty($errors)) {
				$data['success'] = false;
				$data['errors'] = $errors;
			} else {
				$data['success'] = true;
			}
		}
		
		echo json_encode($data);
        break;
	//Delete a session
    case 'DELETE':
		$errors = [];
		$data = [];
		
		//Correct reply to verify the session has been correctly edited
		$correct_response = 'Se ha eliminado la session con exito';
			
       	//Check if the body is ok
		$entityBody = file_get_contents('php://input');
		$dictionary = json_decode($entityBody);
		
		if (!is_object($dictionary))
				$errors['global'] = 'El cuerpo de la petición no es valido';
		
		$or_hall = $dictionary->{"og_hall"} ?? "";		
		$or_date = $dictionary->{"og_date"} ?? "";		
		$or_start = $dictionary->{"og_start"} ?? "";
		
		//Check errors in inputs
		if(empty($or_hall))
				$errors['global'] = 'El nº de sala a borrar no existe';
		if(empty($or_date))
				$errors['global'] = 'La fecha de donde borrar no existe';
		if(empty($or_start))
				$errors['global'] = 'La hora de donde borrar no existe';
			
		if(empty($errors)){	
			$msg = Session::delete_session($_SESSION["cinema"], $or_hall, $or_start, $or_date);

			if(strcmp($msg,$correct_response)!== 0)
				$errors['global'] = $msg;
			else
				$data['message'] = $msg;
		}
			
		if (!empty($errors)) {
			$data['success'] = false;
			$data['errors'] = $errors;
		} else {
			$data['success'] = true;
		}
		
		echo json_encode($data);
		
        break;
    default:
    break;
}