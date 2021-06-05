<?php

require_once('../assets/php/config.php');
require_once('./Evento.php');
include_once($prefix.'assets/php/includes/session.php');

// Procesamos la cabecera Content-Type
$contentType= $_SERVER['CONTENT_TYPE'] ?? 'application/json';
$contentType = strtolower(str_replace(' ', '', $contentType));

// Verificamos corresponde con uno de los tipos soportados
$acceptedContentTypes = array('application/json;charset=utf-8', 'application/json');
$found = false;
foreach ($acceptedContentTypes as $acceptedContentType) {
    if (substr($contentType, 0, strlen($acceptedContentType)) === $acceptedContentType) {
        $found=true;
        break;
    }
}

if (!$found) {
    // throw new ContentTypeNoSoportadoException('Este servicio REST sólo soporta el content-type application/json');
}

$result = null;

/**
 * Las API REST usan la semántica de los métoods HTTP para gestionar las diferentes peticiones: 
 * https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol#Request_methods
 */
switch($_SERVER['REQUEST_METHOD']) {
    // Consulta de datos
    case 'GET':
		$hall =  $_GET["hall"];
		$cinema =  $_SESSION["cinema"];
        // Comprobamos si es una consulta de un evento concreto -> eventos.php?idEvento=XXXXX
        $idEvento = filter_input(INPUT_GET, 'idEvento', FILTER_VALIDATE_INT);
        if ($idEvento) {
			
            $result = [];
            $result[] = Evento::buscaPorId((int)$idEvento,$hall,$cinema);
        } else {
            // Comprobamos si es una lista de eventos entre dos fechas -> eventos.php?start=XXXXX&end=YYYYY
            $start = filter_input(INPUT_GET, 'start', FILTER_VALIDATE_REGEXP,  array("options" => array("regexp"=>"/\d{4}-((0[1-9])|(1[0-2]))-((0[1-9])|([1-2][0-9])|(3[0-1]))/")));
            $end = filter_input(INPUT_GET, 'end', FILTER_VALIDATE_REGEXP, array("options" => array("default" => null, "regexp"=>"/\d{4}-((0[1-9])|(1[0-2]))-((0[1-9])|([1-2][0-9])|(3[0-1]))/")));
            if ($start) {     
					
                $startDateTime = $start . ' 00:00:00';
                $endDateTime = $end;
                if ($end) {
                    $endDateTime = $end. ' 00:00:00';
                }
                $result = Evento::buscaEntreFechas(1, $startDateTime, $endDateTime, $hall,$cinema);
            } else {
				
                // Comprobamos si es una lista de eventos completa
                $result = Evento::buscaTodosEventos(1, $hall,$cinema); // HACK: normalmente debería de ser App::getSingleton()->idUsuario();
            }
        }
        // Generamos un array de eventos en formato JSON
        $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        http_response_code(200); // 200 OK
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Length: ' . mb_strlen($json));;
		
        echo $json;    
    break;
    // Añadir un nuevo evento    
    case 'POST':
		$errors = [];
		$data = [];

		$correct_response = 'Operación completada';
		
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
    case 'PUT':
		/*
        // 1. Comprobamos si es una consulta de un evento concreto -> eventos.php?idEvento=XXXXX
        $idEvento = filter_input(INPUT_GET, 'idEvento', FILTER_VALIDATE_INT);
        // 2. Leemos el contenido que nos envían
        $entityBody = file_get_contents('php://input');
        // 3. Verificamos que nos envían un objeto
        $dictionary = json_decode($entityBody);
        if (!is_object($dictionary)) {
            //throw new ParametroNoValidoException('El cuerpo de la petición no es valido');
        }    
		
		
        // 4. Reprocesamos el cuerpo de la petición como un array PHP
        $dictionary = json_decode($entityBody, true);
        $e = Evento::buscaPorId($idEvento);
        $e->actualizaDesdeDiccionario($dictionary, ['id', 'userId']);
        $result = Evento::guardaOActualiza($e);
        
        // 5. Generamos un objecto como salida.
        $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        
        http_response_code(200); // 200 OK
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Length: ' . mb_strlen($json));

        echo $json;   
		*/
		//If the user want to move a session
		if(isset($_GET["resize"]) && $_GET["resize"]){
			
			
		}else{	
			
			$errors = [];
			$data = [];

			$correct_response = 'Se ha editado la session con exito';
			
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
			
			$or_hall = $dictionary->{"og_hall"} ?? "";		
			$or_date = $dictionary->{"og_date"} ?? "";		
			$or_start = $dictionary->{"og_start"} ?? "";	
			
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
    case 'DELETE':
	
        // 1. Comprobamos si es una consulta de un evento concreto -> eventos.php?idEvento=XXXXX
        $idEvento = filter_input(INPUT_GET, 'idEvento', FILTER_VALIDATE_INT);
        // 2. Borramos el evento
        Evento::borraPorId($idEvento);

        http_response_code(204); // 204 No content (como resultado)
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Length: 0');
        break;
    default:
        //throw new MetodoNoSoportadoException($_SERVER['REQUEST_METHOD']. ' no está soportado');
    break;
}