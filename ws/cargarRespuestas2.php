<?PHP
require '../config/configure.php';

	$database = "Foro";
	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );

	if ($db_found) {

		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$query = 'SELECT * FROM Respuesta where IdPregunta=?';
			$SQL = $db_found->prepare($query);
			$SQL->bind_param('s', $id);
			if ($SQL) {
				$SQL->execute();
	
				$result = $SQL->get_result();
	
				if ($result->num_rows > 0) {
					$db_table = $result->fetch_all(MYSQLI_ASSOC);
				    header('Content-Type: application/json');
	                echo json_encode($db_table);
				}
				else {
					print "Consulta vacia";
				}
	    	}
	    	else {
	    	print "Sin preguntas";
	    	}
		}
		}
    else {
    print "error en base de datos";
    }
?>