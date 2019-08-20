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
				echo "habitacion: ".$habitacion."<br>";
				echo "monto: ".$monto."<br>";
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

		// concateno fechas con horas para almacenar el datetime completo, si son vacias igualarlas a nada
		if ($llegadaF != "" && $llegadaH != "" && $salidaF != "" && $salidaH != "") {
			$newLlegada = $llegadaF." ".$llegadaH;
			$newLlegada .= ":00";
			$newSalida  = $salidaF." ".$salidaH;
			$newSalida  .= ":00";
		} else {
			$newLlegada = "";
			$newSalida  = "";
		}

		// si la fase del registro es 0 o inicial, si el usuario quiere actualizar su informacion, en otra 
		// ventana se resetea faseRegistro a 0, pero registrado ya estara en 1 y se ejecutara el update 
		if ($faseRegistro == 0) {
			if ($registrado == 1) {
				// update
				$SQL = "UPDATE registrocongreso SET marcaTemporal='$now' ,correo='$correo' ,nombre='$nombreDir'
				 ,fechaNacimiento='$fechaNac',estado='$estado' ,ciudad='$ciudad' ,
				 telefonoCelular='$telefono' ,telefonoFijo='$telefonoFijo' ,grupo='$nombreGpo'
				  ,puestoEnGrupo='$cargoGpo' ,habitacion='$habitacion' ,acompanantes='$acompanantes'
				   ,fechaHoraLlegada='$newLlegada' ,fechaHoraSalida='$newSalida' ,monto=$monto 
				   WHERE numSocio = $numSocio;";
				$query = RunQuery($conexion, $SQL);

				if ($query) {
					$sql_up_fase  = "UPDATE usuario SET faseRegistro = 1 WHERE idUsuario = $idUsuario;";
					RunQuery($conexion, $sql_up_fase);
					Disconnect($conexion);
					echo'<script type="text/javascript">
						    alert("Actualización de datos de registro al congreso satisfactoria.");
						    window.location.href="registro.php";
						    </script>';
				} else {
					Disconnect($conexion);
			    	header("Location:error.php");
			    }
			} else {
				// insert
				$SQL = "INSERT INTO registrocongreso(numSocio, marcaTemporal, correo, nombre, fechaNacimiento, estado,
				 ciudad, telefonoCelular, telefonoFijo, grupo, puestoEnGrupo, habitacion, acompanantes,
				  fechaHoraLlegada, fechaHoraSalida, monto) VALUES ('$numSocio', '$now', '$correo', '$nombreDir',
				   '$fechaNac', '$estado', '$ciudad', '$telefono', '$telefonoFijo', '$nombreGpo', '$cargoGpo',
				    '$habitacion', '$acompanantes', '$newLlegada', '$newSalida', '$monto');";
				$query = RunQuery($conexion, $SQL);
				
				if ($query) {
					$sql_up_fase  = "UPDATE usuario SET faseRegistro = 1 WHERE idUsuario = $idUsuario;";
					RunQuery($conexion, $sql_up_fase);
					Disconnect($conexion);
					echo'<script type="text/javascript">
						    alert("Registro al congreso satisfactorio.");
						    window.location.href="registro.php";
						    </script>';
				} else {
					Disconnect($conexion);
			    	header("Location:error.php");
			    }
			}
		}

    } else {
    	header("Location:index.php");
    }

?>