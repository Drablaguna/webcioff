<?php 
	
	if ($_SESSION['sesion']) {
		$numSocio  = $_SESSION["numSocio"];
		$idUsuario = $_SESSION["idUsuario"];

		include("Connection.php");
	    $con       = Connect();

	    mysqli_query($con, "SET NAMES 'utf8'");
		
	    $SQL    = ";";
	    $query = RunQuery($con, $SQL);
	    $SQL2   = ";";
	    $query = RunQuery($con, $SQL2);
	    $SQL3   = ";";
	    $query = RunQuery($con, $SQL3);
	    Disconnect($con);
	}else{
	    header("Location:index.php");
	}

?>