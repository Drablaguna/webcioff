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
		if ($_POST["key"] == "key") {
			// solo actualizo la faseRegistro a 1
			$idUsuario = $_SESSION["idUsuario"];
			include("Connection.php");
		    $con       = Connect();
		    $SQL       = "UPDATE usuario SET faseRegistro = 1 WHERE idUsuario = $idUsuario;";
		    $query     = RunQuery($con, $SQL);
		    Disconnect($con);
		    if ($query) {
		    	header("Location:registro.php");
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