<?php 

	// se crea la sesión
	session_start();

	if ($_SESSION['sesion'] && !empty($_POST)) {
		
		$idUsuario    = $_SESSION["idUsuario"];
		$numSocio     = $_SESSION["numSocio"];

		$correo 	  = $_POST["correo"];
		$fechaNac 	  = $_POST["fechaNac"];
		$telefono 	  = $_POST["telefono"];
		$telefonoFijo = $_POST["telefonoFijo"];
		if ($telefonoFijo == "") { $telefonoFijo = "-"; }

		$habitacion   = $_POST["habitacion"];
		$monto = 0;
		
		switch ($habitacion) {
			case "Individual":
				$monto = 1000;
				break;

			case "Doble":
				$monto = 2000;
				break;

			case "Triple":
				$monto = 3000;
				break;

			case "Cuadruple":
				$monto = 4000;
				break;
			
			default:
				// error
				$monto = 1;
				break;
		}

		$acompanantes = $_POST["acompanantes"];

		$llegadaF 	  = $_POST["llegadaF"];
		$llegadaH 	  = $_POST["llegadaH"];
		$salidaF 	  = $_POST["salidaF"];
		$salidaH 	  = $_POST["salidaH"];

		$now = date("Y-m-d H:i:s");

		include("Connection.php");
		$conexion = Connect();

		mysqli_query($conexion, "SET NAMES 'utf8'");

		$SQLFase   = "SELECT faseRegistro, registrado FROM usuario WHERE idUsuario = $idUsuario;";
		$queryFase = RunQuery($conexion, $SQLFase);
		$faseArr   = mysqli_fetch_assoc($queryFase);

		$faseRegistro = $faseArr["faseRegistro"];
		$registrado   = $faseArr["registrado"];

		$SQLGpo = "SELECT nombreDir, estado, ciudad, nombreGpo, cargoGpo FROM grupo WHERE idUsuario = $idUsuario;";
		$queryG = RunQuery($conexion, $SQLGpo);
		$gpoArr = mysqli_fetch_assoc($queryG);

		$nombreDir = $gpoArr["nombreDir"];
		$estado    = $gpoArr["estado"];
		$ciudad    = $gpoArr["ciudad"];
		$nombreGpo = $gpoArr["nombreGpo"];
		$cargoGpo  = $gpoArr["cargoGpo"];

		// concateno fechas con horas para almacenar el datetime completo
		$newLlegada = $llegadaF." ".$llegadaH;
		$newLlegada .= ":00";
		$newSalida  = $salidaF." ".$salidaH;
		$newSalida  .= ":00";

		$SQL = "INSERT INTO registrocongreso(numSocio, marcaTemporal, correo, nombre, fechaNacimiento, estado,
		 ciudad, telefonoCelular, telefonoFijo, grupo, puestoEnGrupo, habitacion, acompanantes,
		  fechaHoraLlegada, fechaHoraSalida, monto) VALUES ('$numSocio', '$now', '$correo', '$nombreDir',
		   '$fechaNac', '$estado', '$ciudad', '$telefono', '$telefonoFijo', '$nombreGpo', '$cargoGpo',
		    '$habitacion', '$acompanantes', '$newLlegada', '$newSalida', '$monto');";
		$query = RunQuery($conexion, $SQL);
		
		$sql_up_fase  = "UPDATE usuario SET faseRegistro = 1 WHERE idUsuario = $idUsuario;";
		$qFase = RunQuery($conexion, $sql_up_fase);

		if ($query && $qFase) {
			Disconnect($conexion);
			echo'<script type="text/javascript">
				    alert("Registro al congreso satisfactorio.");
				    window.location.href="registro.php";
				    </script>';
		} else {
			Disconnect($conexion);
	    	header("Location:error.php");
	    }
    } else {
    	header("Location:index.php");
    }

?>