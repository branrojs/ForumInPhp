<?PHP
session_start();
if (!(isset($_SESSION['id']) && $_SESSION['id'] != '')) {
    header ("Location:index2.php");
}
if(isset($_GET['id'])){
	$idPregunta = $_GET['id'];
	$_SESSION['idPregunta'] = $_GET['id'];
}
$IdUsuario = $_SESSION['id'];
$IdPregunta = $_SESSION['idPregunta'];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	require 'config/configure.php';
	$idPregunta = $_POST['IdPregunta'];
	$Cuerpo = $_POST['Cuerpo'];

	$database = "Foro";
	
	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );
	
	if ($db_found) {
		$SQL = $db_found->prepare("INSERT INTO Respuesta (IdPregunta, IdUsuario, Cuerpo) VALUES (?,?,?)");
		$SQL->bind_param('iis', $idPregunta, $IdUsuario, $Cuerpo);
		$SQL->execute();
		$SQL = $db_found->prepare("UPDATE Pregunta SET Resuelto=1 WHERE IdPregunta=?");
		$SQL->bind_param('i', $idPregunta);
		$SQL->execute();
		header ("Location: VerPregunta2.php?id=".$IdPregunta);
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
	<h1>Titulo de la pregunta</h1>
	<div class="pregunta"></div>
	<div class="respuestas"></div>
	<FORM NAME="Preguntar" METHOD ="POST" ACTION ="VerPregunta2.php">
	    <input type="text" name="IdPregunta" type="hidden" style="display: none;" value="<?php echo $idPregunta;?>"/>
	    <p>Cuerpo:</p>
	    <textarea type="text" name="Cuerpo" maxlength="300" style="overflow:auto; resize:none;"></textarea>
	    <input type="Submit" name="Submit1"  value="Responder">
	</FORM>
	<a href="Foro2.php">Regresar al foro</a>
	<p><?PHP print $errorMessage;?></p>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript">
		$.ajax({
			url: 'ws/cargarPreguntas2.php?id=<?php echo $idPregunta; ?>',
			success: function(data) {
				$('.pregunta').empty();
		        $(data).each(function(index, element) {
					$('.pregunta').append('<h1>'+element.Titulo+'</h1>');
		        });
			}
        });
		$.ajax({
			url: 'ws/cargarRespuestas2.php?id=<?php echo $idPregunta; ?>',
			success: function(data) {
				$('.respuestas').empty();
		        $(data).each(function(index, element) {
					$('.respuestas').append('<h1>'+element.Cuerpo+'</h1><a href="votar2.php?id='+element.IdRespuesta+'">Votar</a>');
		        });
			}
        });
		</script>
</body>
</html>