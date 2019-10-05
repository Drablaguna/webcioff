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
			include("Connection.php");
			$idUsuario = $_SESSION["idUsuario"];
			$numSocio  = $_SESSION["numSocio"];
			if ($_POST["key"] == "key") {
				$ruta_pdfs = "./recibos/";
				$randStr = genText();
				$pdf     = $ruta_pdfs.$_FILES["pdf"]["name"];
			    $ext 	 = pathinfo($pdf, PATHINFO_EXTENSION);
			    $new_pdf = $ruta_pdfs.$numSocio."_invitado_".$randStr."_".$_SESSION["nombreInvitado"].".".$ext;

			    $now = date("Y-m-d H:i:s");
			    $correo = $_SESSION["arrInvitado"]["correo"];
			    $nombre = $_SESSION["arrInvitado"]["nombre"];
			    $estado = $_SESSION["arrInvitado"]["estado"];
			    $ciudad = $_SESSION["arrInvitado"]["ciudad"];
			    $telefonoCelular = $_SESSION["arrInvitado"]["telefono"];
			    $telefonoFijo = $_SESSION["arrInvitado"]["telefonoFijo"];
			    $habitacion = $_SESSION["arrInvitado"]["habitacion"];
			    $acompanantes = $_SESSION["arrInvitado"]["acompanantes"];
			    $monto = $_SESSION["arrInvitado"]["monto"];
			    if ($telefonoFijo == "") { $telefonoFijo = "-"; }

			    $diaFec = $_SESSION["arrInvitado"]["diaFec"];
				$mesFec = $_SESSION["arrInvitado"]["mesFec"];
				$anioFec = $_SESSION["arrInvitado"]["anioFec"];

			    $diaFecLleg = $_SESSION["arrInvitado"]["diaFecLleg"];
				$mesFecLleg = $_SESSION["arrInvitado"]["mesFecLleg"];
				$llegadaH = $_SESSION["arrInvitado"]["llegadaH"];
				$llegadaM = $_SESSION["arrInvitado"]["llegadaM"];
				$diaFecSal = $_SESSION["arrInvitado"]["diaFecSal"];
				$mesFecSal = $_SESSION["arrInvitado"]["mesFecSal"];
				$salidaH = $_SESSION["arrInvitado"]["salidaH"];
				$salidaM = $_SESSION["arrInvitado"]["salidaM"];

			    $fechaNac = $anioFec."-".$mesFec."-".$diaFec;
				$newLlegada = "2019-".$mesFecLleg."-".$diaFecLleg." ".$llegadaH.":".$llegadaM.":00";
				$newSalida = "2019-".$mesFecSal."-".$diaFecSal." ".$salidaH.":".$salidaM.":00";

			    if (isset($_FILES["pdf"])) {
		            move_uploaded_file($_FILES["pdf"]["tmp_name"], $new_pdf);
		        }
			    $con = Connect();
			    mysqli_query($con, "SET NAMES 'utf8'");
		        $SQL = "INSERT INTO invitado(clave, idUsuario, marcaTemporal, correo, nombre, 
		          fechaNacimiento, estado, ciudad, telefonoCelular, telefonoFijo, habitacion, 
		          acompanantes, fechaHoraLlegada, fechaHoraSalida, monto, reciboInv) 
		          VALUES ('$randStr', '$idUsuario', '$now', '$correo', '$nombre', '$fechaNac',
		           '$estado', '$ciudad', '$telefonoCelular', '$telefonoFijo', '$habitacion', '$acompanantes',
		            '$newLlegada', '$newSalida', '$monto', '$new_pdf');";
				
				$query = RunQuery($con, $SQL);

				if ($query) {
					require("fpdf.php");
					$newAcompanantes = explode(",", $acompanantes);
					$size = sizeof($newAcompanantes);
					$string1 = "Invitado del Socio ".$numSocio;
				    $string2 = $nombre;
				    $string5 = $estado;
				    $string6 = "Invitado";
				    $string7 = "Habitación: ".$habitacion;
				    $string8 = "Acompañantes: ";

				    $pdf = new FPDF();
					$pdf->AddPage("P", "A4");
					$pdf->SetFont("Arial","B",16);
					$pdf->Image("./static/img/Logo_CIOFF_chico.png", 87, 12);
					$pdf->Cell(0,10,"", 0, 1, "C");
					$pdf->Cell(0,10,"", 0, 1, "C");
					$pdf->Cell(0,10,"", 0, 1, "C");
					$pdf->Cell(0,10,"", 0, 1, "C");
					$pdf->Cell(0,10,"", 0, 1, "C");
					$pdf->Cell(0,10,"7mo Congreso Nacional CIOFF", 0, 1, "C");
					$pdf->Cell(0,10,utf8_decode("Santiago de Querétaro - Querétaro"), 0, 1, "C");
					$pdf->Cell(0,10,"", 0, 1, "C");
					$pdf->Cell(0,10,utf8_decode($string1), 0, 1, "C");
					$pdf->Cell(0,10,utf8_decode($string2), 0, 1, "C");
					$pdf->Cell(0,10,utf8_decode($string5), 0, 1, "C");
					$pdf->Cell(0,10,utf8_decode($string6), 0, 1, "C");
					$pdf->Cell(0,10,utf8_decode($string7), 0, 1, "C");
					$pdf->Cell(0,10,utf8_decode($string8), 0, 1, "C");
					try {
						for ($x = 0; $x < $size; $x++) {
							$pdf->Cell(0,10,utf8_decode($newAcompanantes[$x]), 0, 1, "C");
						}
					} catch (Exception $e) {
						header("Location:error.php");	
					}
					$nombrePDF = "Invitado_".$numSocio."_entrada.pdf";
					$pdf->Output("d",$nombrePDF);

				} else {
					header("Location:error.php");
				}
			} else {
				$ruta_pdfs = "./recibos/";

			    $pdf     = $ruta_pdfs.$_FILES["pdf"]["name"];
			    $ext 	 = pathinfo($pdf, PATHINFO_EXTENSION);
			    $new_pdf = $ruta_pdfs.$numSocio."_recibo.".$ext;

			    if (isset($_FILES["pdf"])) {
		            move_uploaded_file($_FILES["pdf"]["tmp_name"], $new_pdf);
		        }
				
			    $con   = Connect();
			    $SQL   = "UPDATE registrocongreso SET recibo = '$new_pdf'
			    	WHERE numSocio = $numSocio;";
			    $query = RunQuery($con, $SQL);

			    $sql_up_fase  = "UPDATE usuario SET faseRegistro = 4 WHERE idUsuario = $idUsuario;";
				$queryFase    = RunQuery($con, $sql_up_fase);
			    Disconnect($con);

			    if ($query && $queryFase) {
			    	echo'<script type="text/javascript">
						    alert("Subida de recibo satisfactoria.");
						    window.location.href="registro.php";
						    </script>';
			    } else {
			    	header("Location:error.php");
			    }
			}
		} else {
			header("Location:miCuenta.php");	
		}
	}else{
	    header("Location:index.php");
	}
?>