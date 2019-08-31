<?php 

	// se crea la sesión
	session_start();

	if ($_SESSION['sesion'] && !empty($_POST)) {
		echo "+------------------------------ D E B U G ------------------------------+<br>";
		print_r($_SESSION);
		echo "<br>";
		print_r($_POST);
		echo "<br>";
		$idUsuario = $_SESSION["idUsuario"];
		$numSocio  = $_SESSION["numSocio"];

		$nombreGpo = $_POST["nombreGpo"];
		$estado    = $_POST["estado"];
		$ciudad    = $_POST["ciudad"];
		$nombreDir = $_POST["nombreDir"];
		$cargoGpo  = $_POST["cargoGpo"];
		$resena    = $_POST["resena"];
		$contacto  = $_POST["contacto"];
		
	    $ruta_imagen = "./fotosGrupos/";

	    $img1     = $ruta_imagen.$_FILES["img1"]["name"];
	    $ext 	  = pathinfo($img1, PATHINFO_EXTENSION);
	    $new_img1 = $ruta_imagen.$numSocio."_1.".$ext;

	    $img2     = $ruta_imagen.$_FILES["img2"]["name"];
	    $ext 	  = pathinfo($img2, PATHINFO_EXTENSION);
	    $new_img2 = $ruta_imagen.$numSocio."_2.".$ext;

	    $img3     = $ruta_imagen.$_FILES["img3"]["name"];
	    $ext 	  = pathinfo($img3, PATHINFO_EXTENSION);
	    $new_img3 = $ruta_imagen.$numSocio."_3.".$ext;
	    echo '<br>-> $new_img1: '.$new_img1.'<br>';
	    echo '<br>-> $new_img2: '.$new_img2.'<br>';
	    echo '<br>-> $new_img3: '.$new_img3.'<br>';
		include("Connection.php");
		$conexion = Connect();
		
		// con "SET NAMES 'utf8'" evito caracteres extranos en peticiones a MySQL
    	mysqli_query($conexion, "SET NAMES 'utf8'");
    	// mysqli_set_charset($conn, "utf8"); // si no funciona el de arriba

		$SQL = "SELECT * FROM grupo WHERE idUsuario = '$idUsuario';";
		$consulta = RunQuery($conexion, $SQL);
		$n = mysqli_num_rows($consulta);
		echo '<br>-> $n: '.$n.'<br>';
		if($n != 0) {
			// update
			echo '<br>-> Inst: update<br>';
			$SQL = "UPDATE grupo SET nombreGpo='$nombreGpo', estado='$estado', ciudad='$ciudad',
			 nombreDir='$nombreDir', cargoGpo='$cargoGpo', resena='$resena', contacto='$contacto',
			 img1='$new_img1', img2='$new_img2', img3='$new_img3' 
			 WHERE idUsuario = $idUsuario;";
			$query = RunQuery($conexion, $SQL);
			echo '<br>-> $SQL: '.$SQL.'<br>';
			echo '<br>-> $query: '.$query.'<br>';
			if ($query) {
				echo '<br>-> Inst: Query insert realizada<br>';
		        if (isset($_FILES["img1"])) {
		            move_uploaded_file($_FILES["img1"]["tmp_name"], $new_img1);
		        }
		        if (isset($_FILES["img2"])) {
		            move_uploaded_file($_FILES["img2"]["tmp_name"], $new_img2);
		        }
		        if (isset($_FILES["img3"])) {
		            move_uploaded_file($_FILES["img3"]["tmp_name"], $new_img3);
		        }

		        Disconnect($conexion);
		        echo '<br>-> Inst: alert(act satisfactoria)w.loc.href=miCuenta;<br>';
			    // echo'<script type="text/javascript">
					  //   alert("Actualización de información satisfactoria.");
					  //   window.location.href="miCuenta.php";
					  //   </script>';
		    } else {
		    	Disconnect($conexion);
		    	echo '<br>-> Inst: header("Location:errorINS.php");<br>';
		    	// header("Location:error.php");
		    }

		} else {
			// insert
			echo '<br>-> Inst: insert<br>';
			$SQL = "INSERT INTO grupo (idUsuario, nombreGpo, estado, ciudad, nombreDir, cargoGpo,
			 resena, contacto, img1, img2, img3) VALUES ($idUsuario, '$nombreGpo', '$estado', '$ciudad',
			  '$nombreDir', '$cargoGpo', '$resena', '$contacto', '$new_img1', '$new_img2', '$new_img3');
			  UPDATE usuario SET actualizado = 1 WHERE idUsuario = $idUsuario;";
			// $query = mysqli_query($conexion, $SQL);
			if (!mysqli_query($conexion, $SQL)) {
				echo "<br>-> error: ".mysqli_error($con);
			}
			echo '<br>-> $SQL: '.$SQL.'<br>';
			// echo '<br>-> $query: '.$query.'<br>';
			// if ($query) {
			if (1==2) {
				echo '<br>-> Query realizada<br>';
		        if (isset($_FILES["img1"])) {
		            move_uploaded_file($_FILES["img1"]["tmp_name"], $new_img1);
		        }
		        if (isset($_FILES["img2"])) {
		            move_uploaded_file($_FILES["img2"]["tmp_name"], $new_img2);
		        }
		        if (isset($_FILES["img3"])) {
		            move_uploaded_file($_FILES["img3"]["tmp_name"], $new_img3);
		        }
		    
				Disconnect($conexion);
				echo '<br>-> Inst: alert("Act satisfactoria") w.loc.href=miCuenta;<br>';
				// echo'<script type="text/javascript">
				// 	    alert("Actualización de información satisfactoria.");
				// 	    window.location.href="miCuenta.php";
				// 	    </script>';
			} else {
		    	Disconnect($conexion);
		    	echo '<br>-> Query fallida<br>';
		    	echo '<br>-> Inst: header("Location:error.php");<br>';
		    	// header("Location:error.php");
		    }

		}
    } else {
    	echo '<br>-> Inst: header("Location:index.php");<br>';
    	// header("Location:index.php");
    }

?>