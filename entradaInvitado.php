<?php

	session_start();
		
    $acompanantes = $_SESSION["arrInvitado"]["acompanantes"];
    $numSocio = $_SESSION["numSocio"];
    $nombre = $_SESSION["arrInvitado"]["nombre"];
    $estado = $_SESSION["arrInvitado"]["estado"];
    $habitacion = $_SESSION["arrInvitado"]["habitacion"];

	require("fpdf.php");
	$newAcompanantes = explode(",", $acompanantes);
	$size = sizeof($newAcompanantes);
	$string1 = "Invitado del Socio ".$numSocio;
    $string2 = $nombre;
    $string5 = $estado;
    $string6 = "Invitado";
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

?>
