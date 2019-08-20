<?php
	session_start();

	if ($_SESSION['sesion']) {
		if (!empty($_POST)) {
			$idUsuario = $_SESSION["idUsuario"];
			$numSocio  = $_SESSION["numSocio"];

			$correo 		 = $_POST["correo"];
			$fechaNacimiento = $_POST["fechaNac"];
			$telefonoCelular = $_POST["telefono"];
			$telefonoFijo 	 = $_POST["telefonoFijo"];
			$habitacion 	 = $_POST["habitacion"];
			$acompanantes    = $_POST["acompanantes"];
			
			$newLlegada = $_POST["llegadaF"]." ".$_POST["llegadaH"];
			$newSalida = $_POST["salidaF"]." ".$_POST["salidaH"];

			$fechaHoraLlegada = $newLlegada;
			$fechaHoraSalida  = $newSalida;
			include("Connection.php");
		    $con       = Connect();
		    $SQL       = "UPDATE registrocongreso SET correo = '$correo', fechaNacimiento = '$fechaNacimiento', 
		    	telefonoCelular = '$telefonoCelular', telefonoFijo = '$telefonoFijo', habitacion = '$habitacion',
		    	acompanantes = '$acompanantes', fechaHoraLlegada = '$fechaHoraLlegada', fechaHoraSalida = '$fechaHoraSalida' 
		    	WHERE numSocio = $numSocio;";
		    $query     = RunQuery($con, $SQL);

		    $sql_up_fase  = "UPDATE usuario SET faseRegistro = 1 WHERE idUsuario = $idUsuario;";
			$queryFase    = RunQuery($con, $sql_up_fase);
		    Disconnect($con);

		    if ($query && $queryFase) {
		    	echo'<script type="text/javascript">
					    alert("Actualización de registro satisfactoria.");
					    window.location.href="registro.php";
					    </script>';
		    } else {
		    	header("Location:error.php");
		    }
		} else {
			header("Location:miCuenta.php");	
		}
	}else{
	    header("Location:index.php");
	}
?>