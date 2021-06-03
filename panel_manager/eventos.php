<?php

require_once('../assets/php/config.php');
require_once('./Evento.php');

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
        // Comprobamos si es una consulta de un evento concreto -> eventos.php?idEvento=XXXXX
        $idEvento = filter_input(INPUT_GET, 'idEvento', FILTER_VALIDATE_INT);
        if ($idEvento) {
            $result = [];
            $result[] = Evento::buscaPorId((int)$idEvento);
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
                $result = Evento::buscaEntreFechas(1, $startDateTime, $endDateTime);
            } else {
				
                // Comprobamos si es una lista de eventos completa
                $result = Evento::buscaTodosEventos(1); // HACK: normalmente debería de ser App::getSingleton()->idUsuario();
            }
        }
        // Generamos un array de eventos en formato JSON
        $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
		
        http_response_code(200); // 200 OK
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Length: ' . mb_strlen($json));

        echo $json;    
    break;
    // Añadir un nuevo evento    
    case 'POST':
        // 1. Leemos el contenido que nos envían
        $entityBody = file_get_contents('php://input');
        // 2. Verificamos que nos envían un objeto
        $dictionary = json_decode($entityBody);
        if (!is_object($dictionary)) {
            //throw new ParametroNoValidoException('El cuerpo de la petición no es valido');
        }
        
        // 3. Reprocesamos el cuerpo de la petición como un array PHP
        $dictionary = json_decode($entityBody, true);
        $dictionary['userId'] = 1;// HACK: normalmente debería de ser App::getSingleton()->idUsuario();
        $e = Evento::creaDesdeDicionario($dictionary);
        
        // 4. Guardamos el evento en BD
        $result = Evento::guardaOActualiza($e);
        
        // 5. Generamos un objecto como salida.
        $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

        http_response_code(201); // 201 Created
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Length: ' . mb_strlen($json));

        echo $json;   

    break;
    case 'PUT':
		error_log("PUT");
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