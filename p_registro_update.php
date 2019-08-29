<?php
	session_start();

	if ($_SESSION['sesion']) {
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

			$nombreDir = $gpoArr["nombreDir"];
			$estado    = $gpoArr["estado"];
			$ciudad    = $gpoArr["ciudad"];
			$nombreGpo = $gpoArr["nombreGpo"];
			$cargoGpo  = $gpoArr["cargoGpo"];

			$correo 		 = $_POST["correo"];
			$fechaNacimiento = $_POST["fechaNac"];
			$telefonoCelular = $_POST["telefono"];
			$telefonoFijo 	 = $_POST["telefonoFijo"];
			$habitacion 	 = $_POST["habitacion"];
			$acompanantes    = $_POST["acompanantes"];

			$habitacion = $_POST["habitacion"];
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
			
			$newLlegada = $_POST["llegadaF"]." ".$_POST["llegadaH"];
			$newSalida = $_POST["salidaF"]." ".$_POST["salidaH"];

			$fechaHoraLlegada = $newLlegada;
			$fechaHoraSalida  = $newSalida;
			
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