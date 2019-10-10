<?php 

	// se crea la sesión
	session_start();

	if ($_SESSION['sesion'] && !empty($_POST)) {
		$_SESSION["tiempoIn"] = time();
	    if ($_SESSION["tiempoIn"] >= $_SESSION["tiempoLim"]) {
	        echo'<script type="text/javascript">
	            alert("Tiempo de sesión expirado, vuelve a iniciar sesión.");
	            window.location.href="p_logout.php";
	            </script>';
	    }		
		$sw1 = true;
		$sw2 = true;
		$sw3 = true;
		$upload = true;

		$idUsuario = $_SESSION["idUsuario"];
		$numSocio  = $_SESSION["numSocio"];

		$nombreGpo = $_POST["nombreGpo"];
		$estado    = $_POST["estado"];
		$ciudad    = $_POST["ciudad"];
		$nombreDir = $_POST["nombreDir"];
		$cargoGpo  = $_POST["cargoGpo"];
		$resena    = $_POST["resena"];
		$contacto  = $_POST["contacto"];
		$estatus   = $_POST["estatus"];
		
	    $ruta_imagen = "./fotosGrupos/";
	    $accepted = array(
	        'image/jpeg',
	        'image/JPEG',
	        'image/jpg',
	        'image/JPG',
	        'image/png',
	        'image/PNG'
	    );
    	
    	$img1     = $ruta_imagen.$_FILES["img1"]["name"];
	    $ext 	  = pathinfo($img1, PATHINFO_EXTENSION);
	    $new_img1 = $ruta_imagen.$numSocio."_1.".$ext;
	    if ($ext == "") { $sw1 = false; }

	    if ($_FILES["img1"]["error"] == 0) {
	    	if (!in_array($_FILES["img1"]["type"], $accepted) || $_FILES["img1"]["size"] >= 5000000) {
		    	$upload = false;
		    	echo'<script type="text/javascript">
				    alert("La primera imagen que subiste no cumple con las condiciones requeridas.");
				    window.location.href="actualizar.php";
				    </script>';
		    }
	    }
    
    	$img2     = $ruta_imagen.$_FILES["img2"]["name"];
	    $ext 	  = pathinfo($img2, PATHINFO_EXTENSION);
	    $new_img2 = $ruta_imagen.$numSocio."_2.".$ext;
	    if ($ext == "") { $sw2 = false; }

	    if ($_FILES["img2"]["error"] == 0) {
	    	if (!in_array($_FILES["img2"]["type"], $accepted) || $_FILES["img2"]["size"] >= 5000000) {
		    	$upload = false;
		    	echo'<script type="text/javascript">
				    alert("La segunda imagen que subiste no cumple con las condiciones requeridas.");
				    window.location.href="actualizar.php";
				    </script>';
		    }	
	    }
    	
    	$img3     = $ruta_imagen.$_FILES["img3"]["name"];
	    $ext 	  = pathinfo($img3, PATHINFO_EXTENSION);
	    $new_img3 = $ruta_imagen.$numSocio."_3.".$ext;
	    if ($ext == "") { $sw3 = false; }

	    if ($_FILES["img3"]["error"] == 0) {
	    	if (!in_array($_FILES["img3"]["type"], $accepted) || $_FILES["img3"]["size"] >= 5000000) {
		    	$upload = false;
		    	echo'<script type="text/javascript">
				    alert("La tercera imagen que subiste no cumple con las condiciones requeridas.");
				    window.location.href="actualizar.php";
				    </script>';
		    }	
	    }

	    if ($upload) {
	    	include("Connection.php");
			$conexion = Connect();
			
			// con "SET NAMES 'utf8'" evito caracteres extranos en peticiones a MySQL
	    	mysqli_query($conexion, "SET NAMES 'utf8'");
	    	// mysqli_set_charset($conn, "utf8"); // si no funciona el de arriba

			$SQL = "SELECT estado FROM grupo WHERE idUsuario = '$idUsuario';";
			$consulta = RunQuery($conexion, $SQL);
			$n = mysqli_num_rows($consulta);
			
			if($n != 0) {
				// update

				$SQL = "UPDATE grupo SET nombreGpo='$nombreGpo', estado='$estado', ciudad='$ciudad',
				 nombreDir='$nombreDir', cargoGpo='$cargoGpo', resena='$resena', contacto='$contacto'";

				if ($sw1) { $SQL = $SQL.", img1='$new_img1'"; }
				if ($sw2) { $SQL = $SQL.", img2='$new_img2'"; }
				if ($sw3) { $SQL = $SQL.", img3='$new_img3'"; }

				$SQL = $SQL." WHERE idUsuario = $idUsuario; ";
				$SQL = $SQL."UPDATE usuario SET estatus='$estatus' WHERE idUsuario = $idUsuario;";
				
				$query = mysqli_multi_query($conexion, $SQL);

				if ($query) {
			        if ($sw1) { move_uploaded_file($_FILES["img1"]["tmp_name"], $new_img1); }
			        if ($sw2) { move_uploaded_file($_FILES["img2"]["tmp_name"], $new_img2); }
			        if ($sw3) { move_uploaded_file($_FILES["img3"]["tmp_name"], $new_img3); }

			        Disconnect($conexion);
				    echo'<script type="text/javascript">
						    alert("Actualización de información satisfactoria.");
						    window.location.href="miCuenta.php";
						    </script>';
			    } else {
			    	Disconnect($conexion);
			    	header("Location:error.php");
			    }

			} else {
				// insert

				$SQL = "INSERT INTO grupo (idUsuario, nombreGpo, estado, ciudad, nombreDir, cargoGpo,
				 resena, contacto, img1, img2, img3) VALUES ($idUsuario, '$nombreGpo', '$estado', '$ciudad',
				  '$nombreDir', '$cargoGpo', '$resena', '$contacto', '$new_img1', '$new_img2', '$new_img3');
				  UPDATE usuario SET actualizado = 1, estatus = '$estatus' WHERE idUsuario = $idUsuario;";
				$query = mysqli_multi_query($conexion, $SQL);
				
				if ($query) {
		            move_uploaded_file($_FILES["img1"]["tmp_name"], $new_img1);
		            move_uploaded_file($_FILES["img2"]["tmp_name"], $new_img2);
		            move_uploaded_file($_FILES["img3"]["tmp_name"], $new_img3);
			    
					Disconnect($conexion);
					echo'<script type="text/javascript">
						    alert("Actualización de información satisfactoria.");
						    window.location.href="miCuenta.php";
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