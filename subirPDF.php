<?php
	session_start();

	if ($_SESSION['sesion']) {
		if (!empty($_POST)) {
			$idUsuario = $_SESSION["idUsuario"];
			$numSocio  = $_SESSION["numSocio"];

			$ruta_pdfs = "./recibos/";

		    $pdf     = $ruta_pdfs.$_FILES["pdf"]["name"];
		    $ext 	 = pathinfo($pdf, PATHINFO_EXTENSION);
		    $new_pdf = $ruta_pdfs.$numSocio."_recibo.".$ext;

		    // esto solo si se ejecuto el query
		    if (isset($_FILES["pdf"])) {
	            move_uploaded_file($_FILES["pdf"]["tmp_name"], $new_pdf);
	        }
			
			include("Connection.php");
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
		} else {
			header("Location:miCuenta.php");	
		}
	}else{
	    header("Location:index.php");
	}
?>