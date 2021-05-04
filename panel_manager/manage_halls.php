<?php	
	require_once('../assets/php/common/hall.php');
	require_once('../assets/php/config.php');						

	$listhalls = '<form method="post" action="./?state=edit_hall">
					<table class="alt">
						<thead>
							<tr>
								<th>Numero</th>
								<th>Filas</th>
								<th>Columnas</th>
							</tr>
						</thead>
						<tbody>'; 
		
	
	foreach(Hall::getListHalls("1") as $hall){ 
		$listhalls .='
						<tr>
							<td> '. $hall->getNumber().'</td>
							<td> '. $hall->getNumRows().'</td>
							<td> '. $hall->getNumCol().'</td>
							<td> <input type="submit" name="edit" value="Editar" class="button" ></td>
						</tr>';
	}
	$listhalls.='
						</tbody>
					</table>
					<input type="submit" name="new"  value="Añadir" class="button large" >
				</form>';

	echo $listhalls;
?>


