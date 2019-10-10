<?php 
	session_start();
	if ($_SESSION["sesion"]) {
		$numSocio  = $_SESSION["numSocio"];

		require("fpdf.php");
		include("Connection.php");
	    $con = Connect();

	    mysqli_query($con, "SET NAMES 'utf8'");
		
	    $SQL    = "SELECT estatus FROM usuario WHERE numSocio = $numSocio;";
	    $query1 = RunQuery($con, $SQL);
	    $arr_sql1 = mysqli_fetch_assoc($query1);
	    $estatus = $arr_sql1["estatus"];

	    $SQL2   = "SELECT nombre, estado, grupo, puestoEnGrupo, habitacion, acompanantes 
	    	FROM registrocongreso WHERE numSocio = $numSocio;";
	    $query2 = RunQuery($con, $SQL2);
	    $arr_sql2 = mysqli_fetch_assoc($query2);
	    $nombre = $arr_sql2["nombre"];
	    $estado = $arr_sql2["estado"];
	    $grupo = $arr_sql2["grupo"];
	    $puestoEnGrupo = $arr_sql2["puestoEnGrupo"];
	    $habitacion = $arr_sql2["habitacion"];
	    if ($habitacion == "Cuadruple") { $habitacion = "Cuádruple"; }
	    $acompanantes = $arr_sql2["acompanantes"];
		$newAcompanantes = explode(",", $acompanantes);
		$size = sizeof($newAcompanantes);
	    Disconnect($con);

	    $string1 = "Socio ".$numSocio;
	    $string2 = $nombre;
	    $string3 = $estatus;
	    $string4 = $grupo;
	    $string5 = $estado;
	    $string6 = $puestoEnGrupo;
	    $string7 = "Habitación: ".$habitacion;
	    $string8 = "Personas con las que compartirá habitación: ";

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
		$pdf->Cell(0,10,utf8_decode($string3), 0, 1, "C");
		$pdf->Cell(0,10,utf8_decode($string4), 0, 1, "C");
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
		$nombrePDF = $numSocio."_entrada.pdf";
		$pdf->Output("d",$nombrePDF);
		header("Location:registro.php");
	}else{
	    header("Location:index.php");
	}

?>