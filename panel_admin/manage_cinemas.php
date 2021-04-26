<?php 

$cinema = array(   
    "idCine" => "1234",
    "name"   => "cineJuan",
    "address"=> "calle..",
    "phone_number"=>"660099000",
);

$delete_cinemas='<!-- delete_cinemas -->
    <div class="column left">
        <h2>Lista de cines</h2>
        <br></br>
            <div class="row">
            <table>   
                <tr> 
                <th>idCine</th>
                <th>nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                </tr>
                <tr>
                <td> '. $cinema['idCine'] .' </td>
                <td> '. $cinema['name'] .' </td>
                <td> '. $cinema['address'] .' </td>
                <td> '. $cinema['phone_number'] .' </td>
                </tr>
                <tr>
                
                </tr>  
                <tr>

                </tr>  
                <tr>

                </tr>           
            </table>
            </div>
    </div>'."\n";
$add_cinemas='<!-- Add_cinemas -->   
     <div class="column side">
        <h2>Añadir o modificar cine</h2>
        <form method="post" action="add_cinema.php">
            <div class="row">
                <fieldset id="datos_cine">
                    <legend>Datos del cine</legend>
                    <div class="_idCine">
                        <input type="text" name="idCine" id="idCine" value="" placeholder="IdCine" />
                    </div>
                    <div class="_name">
                        <input type="text" name="name" id="name" value="" placeholder="Nombre" />
                    </div>
                    <div class="_address">
                        <input type="text" name="address" id="address" value="" placeholder="Direccion" />
                    </div>
                    <div class="_phone_number">
                        <input type="number" name="phone_number" id="phone_number" value="" placeholder="Teléfono" />
                    </div>
                </fieldset>
                <div class="actions"> 
                    <input type="submit" id="submit" value="Añadir cine" class="primary" />
                    <input type="reset" id="reset" value="Borrar" />       
                </div>
            </div>
        </form>
    </div>'."\n";
?>
