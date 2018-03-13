<?PHP
session_start();
if (!(isset($_SESSION['id']) && $_SESSION['id'] != '')) {
    header ("Location:index2.php");
}
$IdUsuario = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	require 'config/configure.php';
	$Titulo = $_POST['Titulo'];
	$Cuerpo = $_POST['Cuerpo'];

	$database = "Foro";
	
	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );
	
	if ($db_found) {
		$SQL = $db_found->prepare("INSERT INTO Pregunta (IdUsuario, Titulo, Cuerpo) VALUES (?,?,?)");
		$SQL->bind_param('iss', $IdUsuario, $Titulo, $Cuerpo);
		$SQL->execute();
		header ("Location: Foro2.php?msg=Pregunta creada con exito");
	}
	else {
		$errorMessage = "Error de conexion";
	}
}
?>
<html>
<head>
<title>Bienvenido</title>
</head>
<body>
	<FORM NAME="Preguntar" METHOD ="POST" ACTION ="CrearPregunta2.php">
	    <input type="text" name="IdUsuario" type="hidden" style="display: none;" value="<?php echo $IdUsuario;?>"/>
	    <p>Titulo:</p>
	    <input type="text" name="Titulo" maxlength="40"/>
	    <p>Cuerpo:</p>
	    <textarea type="text" name="Cuerpo" maxlength="300" style="overflow:auto; resize:none;"></textarea>
	    <input type="Submit" name="Submit1"  value="CrearPregunta">
	</FORM>
	<a href="Foro2.php">Regresar al foro</a>
	<p><?PHP print $errorMessage;?></p>
</body>
</html>