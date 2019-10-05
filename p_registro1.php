<?php 

	// se crea la sesión
	session_start();

	if ($_SESSION['sesion'] && !empty($_POST)) {
		$_SESSION["tiempoIn"] = time();
	    if ($_SESSION["tiempoIn"] >= $_SESSION["tiempoLim"]) {
	        echo'<script type="text/javascript">
	            alert("Tiempo de sesión expirado, vuelve a iniciar sesión.");
	            window.location.href="p_logout.php";
	            </script>';
	    }
	    include("Connection.php");
		$idUsuario    = $_SESSION["idUsuario"];
		$numSocio     = $_SESSION["numSocio"];

		$correo 	  = $_POST["correo"];
		$diaFec 	  = $_POST["diaFec"];
		$mesFec 	  = $_POST["mesFec"];
		$anioFec 	  = $_POST["anioFec"];
		$telefono 	  = $_POST["telefono"];
		$telefonoFijo = $_POST["telefonoFijo"];
		$mesPago      = $_POST["mesPago"];
		if ($telefonoFijo == "") { $telefonoFijo = "-"; }

		$habitacion   = $_POST["habitacion"];
		$monto = 0.00;
		$now = date("Y-m-d H:i:s");
		$thisMonth = date("m");

		if ($mesPago == 0) {
			$monto = calcularMonto($thisMonth, $habitacion);
		}

		$acompanantes = $_POST["acompanantes"];

		$diaFecLleg = $_POST["diaFecLleg"];
		$mesFecLleg = $_POST["mesFecLleg"];
		$llegadaH = $_POST["llegadaH"];
		$llegadaM = $_POST["llegadaM"];
		$diaFecSal = $_POST["diaFecSal"];
		$mesFecSal = $_POST["mesFecSal"];
		$salidaH = $_POST["salidaH"];
		$salidaM = $_POST["salidaM"];

		$conexion = Connect();

		mysqli_query($conexion, "SET NAMES 'utf8'");

		$SQLFase   = "SELECT faseRegistro FROM usuario WHERE idUsuario = $idUsuario;";
		$queryFase = RunQuery($conexion, $SQLFase);
		$faseArr   = mysqli_fetch_assoc($queryFase);

		$faseRegistro = $faseArr["faseRegistro"];

		$SQLGpo = "SELECT nombreDir, estado, ciudad, nombreGpo, cargoGpo FROM grupo WHERE idUsuario = $idUsuario;";
		$queryG = RunQuery($conexion, $SQLGpo);
		$gpoArr = mysqli_fetch_assoc($queryG);

		$nombreDir = $gpoArr["nombreDir"];
		$estado    = $gpoArr["estado"];
		$ciudad    = $gpoArr["ciudad"];
		$nombreGpo = $gpoArr["nombreGpo"];
		$cargoGpo  = $gpoArr["cargoGpo"];

		// concateno fechas con horas para almacenar el datetime completo - 2019-11-15 22:30:00
		$fechaNac = $anioFec."-".$mesFec."-".$diaFec;
		$newLlegada = "2019-".$mesFecLleg."-".$diaFecLleg." ".$llegadaH.":".$llegadaM.":00";
		$newSalida = "2019-".$mesFecSal."-".$diaFecSal." ".$salidaH.":".$salidaM.":00";
		
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