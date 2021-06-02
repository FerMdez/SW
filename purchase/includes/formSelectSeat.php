<?php
include_once($prefix.'assets/php/form.php');
include_once($prefix.'assets/php/includes/film_dao.php');
include_once($prefix.'assets/php/includes/film.php');
include_once($prefix.'assets/php/includes/cinema_dao.php');
include_once($prefix.'assets/php/includes/cinema.php');
include_once($prefix.'assets/php/includes/session_dao.php');
include_once($prefix.'assets/php/includes/session.php');
include_once($prefix.'assets/php/includes/hall_dao.php');
include_once($prefix.'assets/php/includes/hall.php');
include_once($prefix.'assets/php/includes/seat_dao.php');
include_once($prefix.'assets/php/includes/seat.php');

class FormSelectSeat extends Form {

    //Atributes:

    public function __construct() {
        $options = array("action" => "confirm.php");
        parent::__construct('formSelectSeat', $options);
        
    }

    protected function generaCamposFormulario($datos, $errores = array()){

        // Se generan los mensajes de error, si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorSeat = self::createMensajeError($errores, 'seats', 'span', array('class' => 'error'));

        $sessionDAO = new SessionDAO("complucine");
        $session = $sessionDAO->sessionData($_POST["sessions"]);

        $hallDAO = new HallDAO("complucine");
        $hall = $hallDAO->HallData($session->getIdhall());

        $seatDAO = new SeatDAO("complucine");
        $seats = $seatDAO->getAllSeats($session->getIdhall(), $session->getIdcinema());

        $rows = $hall->getNumRows(); 
        $cols = $hall->getNumCol();

        //$seats = $hall->getTotalSeats();
		$seats_map = array();

        for($i = 1; $i <= $rows; $i++){
            for($j = 1; $j <= $cols; $j++){ 
                $seats_map[$i][$j] = $seats[$i]->getState();
            }
        }
        $html ='<h2>Seleccionar un Asiento</h2><hr />
            <h3 class="table_title">Pantalla</h3>
            <table class="seat">
                <thead>
                    <tr>
                        <th> </th>
                        ';
        for($j = 1; $j <= $cols; $j++){
            $html .= '<th>'.$j.'</th>
                            ';	
        }
        $html .= '</tr>
                    </thead>
                    <tbody>';
            for($i = 1; $i <= $rows; $i++){
                    $html .= '
                        <tr>
                            <td>'.$i.'</td>
                            ';
                for($j = 1; $j <= $cols; $j++){
                    if($seats_map[$i][$j] >= 0){
                        $html .= '<td> <input type="checkbox" class="check_box" name="checkbox'.$i.$j.'" value="'.$seats_map[$i][$j].'" id="checkbox'.$i.$j.'" /> <label for="checkbox'.$i.$j.'"> </td> <!-- checked -->
                            ';}
                    else {
                        $html .= '<td> <input type="checkbox" class="check_box" name="checkbox'.$i.$j.'" value="'.$seats_map[$i][$j].'" id="checkbox'.$i.$j.'" disabled /> <label for="checkbox'.$i.$j.'"> </td>
                            ';}
                }
                    $html .='</tr>';
            }
            
        $html .= '
                </tbody>
            </table>';

        //Pay button:
        $pay = '<input type="hidden" name="sessions" id="sessions" value="'.$_POST["sessions"].'" />
                <input type="submit" id="submit" value="Pagar" />';

        return '
                <section class="code purchase">
                    '.$html.'
                </section>
                <section class="code purchase">
                    '.$pay.'
                </section>';
    }

    protected function procesaFormulario($datos){
        $result = array();

        if (count($result) === 0) {
            $result = "confirm.php";
        }

        return $result;
    }
}
?>