<?php
	session_start();

	if ($_SESSION['sesion']) {
		$_SESSION["tiempoIn"] = time();
	    if ($_SESSION["tiempoIn"] >= $_SESSION["tiempoLim"]) {
	        echo'<script type="text/javascript">
	            alert("Tiempo de sesión expirado, vuelve a iniciar sesión.");
	            window.location.href="p_logout.php";
	            </script>';
	    }
		if (!empty($_POST)) {
			$idUsuario = $_SESSION["idUsuario"];
			$numSocio  = $_SESSION["numSocio"];

			include("Connection.php");
		    $con   = Connect();

		    mysqli_query($con, "SET NAMES 'utf8'");

			$now = date("Y-m-d H:i:s");

			$SQLGpo = "SELECT nombreDir, estado, ciudad, nombreGpo, cargoGpo FROM grupo WHERE idUsuario = $idUsuario;";
			$queryG = RunQuery($con, $SQLGpo);
			$gpoArr = mysqli_fetch_assoc($queryG);

			$SQLest = "SELECT estatus FROM usuario WHERE idUsuario = $idUsuario;";
			$qE = RunQuery($con, $SQLest);
			$estAr = mysqli_fetch_assoc($qE);
			$estatus = $estAr["estatus"];

			$nombreDir = $gpoArr["nombreDir"];
			$estado    = $gpoArr["estado"];
			$ciudad    = $gpoArr["ciudad"];
			$nombreGpo = $gpoArr["nombreGpo"];
			$cargoGpo  = $gpoArr["cargoGpo"];

			$correo 		 = $_POST["correo"];
			$diaFec 		 = $_POST["diaFec"];
			$mesFec 		 = $_POST["mesFec"];
			$anioFec 		 = $_POST["anioFec"];
			$telefonoCelular = $_POST["telefono"];
			$telefonoFijo 	 = $_POST["telefonoFijo"];
			$habitacion 	 = $_POST["habitacion"];
			$acompanantes    = $_POST["acompanantes"];

			$mesPago = $_POST["mesPago"];
			$habitacion = $_POST["habitacion"];
			$monto = 0.00;

			switch ($mesPago) {
				case 0:
					$thisMonth = date("m");
					$monto = calcularMonto($thisMonth, $habitacion, $estatus);
					break;
				
				case 6:
					$monto = calcularMonto(6, $habitacion, $estatus);		
					break;

				case 7:
					$monto = calcularMonto(7, $habitacion, $estatus);		
					break;

				case 8:
					$monto = calcularMonto(8, $habitacion, $estatus);		
					break;

				case 9:
					$monto = calcularMonto(9, $habitacion, $estatus);		
					break;

				case 10:
					$monto = calcularMonto(10, $habitacion, $estatus);		
					break;

				case 11:
					$monto = calcularMonto(11, $habitacion, $estatus);		
					break;
				
				default:
					$monto = 1;
					break;
			}

			$diaFecLleg = $_POST["diaFecLleg"];
			$mesFecLleg = $_POST["mesFecLleg"];
			$llegadaH = $_POST["llegadaH"];
			$llegadaM = $_POST["llegadaM"];
			$diaFecSal = $_POST["diaFecSal"];
			$mesFecSal = $_POST["mesFecSal"];
			$salidaH = $_POST["salidaH"];
			$salidaM = $_POST["salidaM"];
			// 2019-11-15 22:30:00
			$fechaNacimiento = $anioFec."-".$mesFec."-".$diaFec;
			$fechaHoraLlegada = "2019-".$mesFecLleg."-".$diaFecLleg." ".$llegadaH.":".$llegadaM.":00";
			$fechaHoraSalida  = "2019-".$mesFecSal."-".$diaFecSal." ".$salidaH.":".$salidaM.":00";
			
	    	$SQL   = "UPDATE registrocongreso SET marcaTemporal='$now' ,correo='$correo' ,nombre='$nombreDir'
				 ,fechaNacimiento='$fechaNacimiento',estado='$estado' ,ciudad='$ciudad' ,
				 telefonoCelular='$telefonoCelular' ,telefonoFijo='$telefonoFijo' ,grupo='$nombreGpo'
				  ,puestoEnGrupo='$cargoGpo' ,habitacion='$habitacion' ,acompanantes='$acompanantes'
				   ,fechaHoraLlegada='$fechaHoraLlegada' ,fechaHoraSalida='$fechaHoraSalida' ,monto=$monto 
				   WHERE numSocio = $numSocio;";
			
		    $query = RunQuery($con, $SQL);
		    
		    $sql_up_fase  = "UPDATE usuario SET faseRegistro = 1 WHERE idUsuario = $idUsuario;";
			$queryFase    = RunQuery($con, $sql_up_fase);

		    if ($query && $queryFase) {
		    	Disconnect($con);
		    	echo'<script type="text/javascript">
					    alert("Actualización de registro satisfactoria.");
					    window.location.href="registro.php";
					    </script>';
		    } else {
		    	Disconnect($con);
		    	header("Location:error.php");
		    }
		} else {
			header("Location:miCuenta.php");	
		}
	}else{
	    header("Location:index.php");
	}
?>