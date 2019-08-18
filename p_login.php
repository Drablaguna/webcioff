<?php
	// se crea la sesión
	session_start();

	if (!empty($_SESSION)) {
        if ($_SESSION['sesion']) {
            header("Location:miCuenta.php");
        }        
    }

	$numSocio = $_POST["numSocio"];
	$password = $_POST["password"];
	
	include("Connection.php");
	$conexion = Connect();
	
	// primero verificamos si el usuario existe
	$SQL = "SELECT * FROM usuario WHERE numSocio = '$numSocio';";
	$consulta = RunQuery($conexion, $SQL);
	// $n tiene la cantidad de elementos obtenidos en $consulta 0 - no existe 1 - si existe
	$n = mysqli_num_rows($consulta);
	
	if($n == 0){
		// no hay ningun usuario registrado con el nombre consultado
		Disconnect($conexion);
        echo'<script type="text/javascript">
                    alert("Número de socio o contraseña incorrectos.");
                    window.location.href="index.php";
                    </script>';
	}else{
		$fila = mysqli_fetch_assoc($consulta);

		// validacion de campos
		if( password_verify($password, $fila["contrasena"]) ) {
			if($fila["numSocio"] == $numSocio) {
				// inicio de sesion satisfactorio
				
                /* ======================================================
                           V A R I A B L E S  D E  S E S I O N
                   ====================================================== */

				$_SESSION["numSocio"]  = $numSocio;
                $_SESSION["idUsuario"] = $fila["idUsuario"];
				$_SESSION["sesion"]    = true;

				// obtencion de la fecha y hora actual para almacenarla en la BD
				$now = date("Y-m-d H:i:s");

				// asignacion de lastDateConnection
				$SQL = "UPDATE usuario SET ultcon = '$now' WHERE numSocio = '$numSocio';";
				$consulta = RunQuery($conexion, $SQL);

				// obtencion y asignacion de ip de cliente
				$ip = obtener_ip();
				$SQL = "UPDATE usuario SET ip = '$ip' WHERE numSocio = '$numSocio';";
				$consulta = RunQuery($conexion, $SQL);

				Disconnect($conexion);

				echo'<script type="text/javascript">
				    alert("Inicio de sesión correcto.");
				    window.location.href="miCuenta.php";
				    </script>';
			} else {
				// campos incorrectos
				Disconnect($conexion);
                echo'<script type="text/javascript">
                    alert("Número de socio o contraseña incorrectos.");
                    window.location.href="index.php";
                    </script>';
			}
		} else {
			// campos incorrectos
			Disconnect($conexion);
            echo'<script type="text/javascript">
                alert("Número de socio o contraseña incorrectos.");
                window.location.href="index.php";
                </script>';
		}
	}
?>