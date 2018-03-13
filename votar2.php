<?PHP
session_start();
if (!(isset($_SESSION['id']) && $_SESSION['id'] != '')) {
    header ("Location:index2.php");
}
$IdUsuario = $_SESSION['id'];
$IdPregunta = $_SESSION['idPregunta'];
if(isset($_GET['id'])){
	$idRespuesta = $_GET['id'];
}
	require 'config/configure.php';

	$database = "Foro";
	
	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );
	
	if ($db_found) {
		$SQL = $db_found->prepare("UPDATE Respuesta SET Votos = Votos+1 WHERE IdRespuesta=?");
		$SQL->bind_param('i', $idRespuesta);
		$SQL->execute();
		header ("Location: VerPregunta2.php?id=".$IdPregunta);
	}
	else {
		header ("Location: Foro2.php?msg=Voto realizado");
		$errorMessage = "Error de conexion";
	}
?>