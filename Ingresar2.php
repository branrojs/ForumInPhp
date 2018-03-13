<?PHP
$Nombre = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	require 'config/configure.php';

	$Nombre = $_POST['Nombre'];

	$database = "Foro";
	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );

	if ($db_found) {
		$SQL = $db_found->prepare("SELECT * FROM Usuario WHERE Nombre = ?");
		$SQL->bind_param('s', $Nombre);
		$SQL->execute();
		$result = $SQL->get_result();

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			session_start();
			var_dump($_SESSION);
			#header ("Location: Foro2.php");
		}
		else {
			$SQL = $db_found->prepare("INSERT INTO Usuario (Nombre) VALUES (?)");
			$SQL->bind_param('s', $Nombre);
			$SQL->execute();
			session_start();
			$_SESSION['login'] = $db_found->insert_id;
			var_dump($_SESSION);
			#header ("Location: Foro2.php");
		}
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
	<FORM NAME="Ingresar" METHOD ="POST" ACTION ="Ingresar2.php">
	<h2>Nombre de usuario:</h2>
	<INPUT TYPE='TEXT' Name='Nombre'  value="<?PHP print $Nombre;?>" maxlength="25">
	<INPUT TYPE="Submit" Name="Submit1"  VALUE="Ingresar">
	</FORM>
	<p><?PHP print $errorMessage;?></p>
</body>
</html>