<?php


$errors = [];
$data = [];

if (empty($_POST['price']) || $_POST['price'] <= 0 ) {
    $errors['price'] = 'El precio no puede ser 0.';
}

if (empty($_POST['format'])) {
    $errors['format'] = 'El formato no puede estar vacio. Ej: 3D, 2D, voz original';
}

if (empty($_POST['hall']) || $_POST['hall']<=0 ) {
    $errors['hall'] = 'La sala no puede ser 0 o menor';
}

if (empty($_POST['startDate'])) {
    $errors['startDate'] = 'Las sesiones tienen que empezar algun dia.';
}

if (empty($_POST['endDate'])) {
    $errors['endDate'] = 'Las sesiones tienen que teminar algun dia.';
}

if (!empty($_POST['startDate']) && !empty($_POST['endDate'])) {
	$start = strtotime($_POST['startDate']);
	$end = strtotime($_POST['endDate']);
	
	$start = date('Y-m-d', $start);
	$end = date('Y-m-d', $end);
	
	if($start >= $end){
		$errors['date'] = 'La fecha inicial no puede ser antes o el mismo dia que la final.';
	}
}

if (empty($_POST['startHour'])) {
    $errors['startHour'] = 'Es necesario escoger el horario de la sesion.';
}


if (!empty($errors)){
	error_log("creamos una sesion, wahoo");
	Session::create_session("1", $_POST['hall'], $_POST['startHour'], $_POST['startDate'],
	"1",$_POST['price'], $_POST['format'],"0");
		
		
	$data['success'] = false;
    $data['errors'] = $errors;
} else {
    $data['success'] = true;
    $data['message'] = 'Success!';
}

echo json_encode($data);