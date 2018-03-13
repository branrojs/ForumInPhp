<?PHP
session_start();
if (!(isset($_SESSION['id']) && $_SESSION['id'] != '')) {
	header ("Location: index2.php");
}
$IdUsuario = $_SESSION['id'];
require 'config/configure.php';

	$database = "Foro";
	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );

	if ($db_found) {
		$SQL = $db_found->prepare("SELECT * FROM Usuario WHERE IdUsuario = ?");
		$SQL->bind_param('i', $IdUsuario);
		$SQL->execute();
		$result = $SQL->get_result();
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			session_start();
			$Nombre=$row['Nombre'];
		}
	}
	else {
		$errorMessage = "Error de conexion";
	}
?>
<html>
<head>
	<title>Bienvenido</title>
</head>
<body>
    <h1>Bienvenido <span id="Nombre"><?php echo $Nombre;?></span></h1>
	<h1 class="animated swing">Preguntas</h1>
	<input type="hidden" id="id" value="<?php echo $_SESSION['id'];?>" />
		<h2>Preguntas</h2>
		<div class="preguntas">
			<h1>Titulo</h1>
			<div class="preguntas">
			<h3>Nombre de usuario</h3>
			<h3 class="nombre"></h3>
			<p>Cuerpo</p>
			<p class="cuerpo"></p>
			<p>RESUELTO</p>
			<p class="resuelto"></p>
			</div>
		</div>
		<div>
			<h2>Usuarios</h2>
			<div class="usuarios">
			</div>
			<ul class="usuario">
				<!--  -->
			</ul>
		</div>
		<div>
			<a href="CrearPregunta2.php">Crear pregunta</a>
			<a class="salir" href="Salir2.php" role="button">Salir</a>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript">
		$.ajax({
			url: 'ws/cargarPreguntas2.php',
			success: function(data) {
				$('.preguntas').empty();
		        $(data).each(function(index, element) {
					$('.preguntas').append('<h3>'+element.Titulo+'</h3><a href="VerPregunta2.php?id='+element.IdPregunta+'">ir a pregunta</a>');
		        });
			}
        });
		$.ajax({
			url: 'ws/cargarUsuarios2.php',
			success: function(data) {
				$('.usuarios').empty();
		        $(data).each(function(index, element) {
					$('.usuarios').append('<h3>'+element.Nombre+'</h3>');
		        });
			}
        });
		</script>
	</div>
</body>
</html>