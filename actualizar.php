<?php
	session_start();
    if (!$_SESSION['sesion']) { header("Location:index.php"); }
?>

<?php 

    include("Connection.php");
    $con       = Connect();
    $idUser    = $_SESSION["idUsuario"];
    mysqli_query($con, "SET NAMES 'utf8'");
    
    // checo si el usuario ya esta actualizado para poder asignar valores vacios a las variables para los
    // placeholders y no me arroje error
    $SQLactualizado = "SELECT actualizado FROM usuario WHERE idUsuario = $idUser";
    $r = RunQuery($con, $SQLactualizado);
    $arr_r = mysqli_fetch_assoc($r);
    $actualizado = $arr_r["actualizado"];

    // inicializo las variables en "" para que no haya error
    $nombreGpo = "";
    $estado    = "";
    $ciudad    = "";
    $nombreDir = "";
    $cargoGpo  = "";
    $resena    = "";
    $contacto  = "";

    if ($actualizado == 1) {
        $SQL       = "SELECT nombreGpo, estado, ciudad, nombreDir, cargoGpo, resena, contacto
         FROM grupo WHERE idUsuario = $idUser;";
        $resultado = RunQuery($con, $SQL);
        $arr_assoc = mysqli_fetch_assoc($resultado);
        
        $nombreGpo = $arr_assoc["nombreGpo"];
        $estado    = $arr_assoc["estado"];
        $ciudad    = $arr_assoc["ciudad"];
        $nombreDir = $arr_assoc["nombreDir"];
        $cargoGpo  = $arr_assoc["cargoGpo"];
        $resena    = $arr_assoc["resena"];
        $contacto  = $arr_assoc["contacto"];
    }

    Disconnect($con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="static/css/estilos.css">
    <script type="text/javascript" src="static/js/funciones.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <title>Actualizar Información</title>
</head>
<body>
    
    <div class="container">

        <div class="menu-left">
            <img class="logoCIOFF-menu" src="static/img/Logo_CIOFF.png" alt="Logo CIOFF Mexico">
            <hr>
            <div class="cont-nombre">
                <p><?php echo $nombreDir;?></p>
            </div>
            <hr>
            <div class="cont-menu">
                <ul>
                    <li class="cont-option">
                        <img src="static/img/user.png" alt="Mi Cuenta">
                        <a href="miCuenta.php">Mi Cuenta</a>
                    </li>
                    <li class="cont-option">
                        <img src="static/img/list.png" alt="Actualizar Información">
                        <a id="blue_a" href="actualizar.php">Actualizar Información</a>
                    </li>
                    <li class="cont-option">
                        <img src="static/img/clipboard.png" alt="Registro al Congreso">
                        <a href="registro.php">Registro al Congreso</a>
                    </li>
                </ul>
            </div>
            <hr>
            <ul>
                <li class="cont-option">
                    <img src="static/img/logout.png" alt="Cerrar Sesión">
                    <a onclick="modalLogout();">Cerrar Sesión</a>
                </li>
            </ul>

        </div>

        <div class="contenido">
            
            <div class="modal-container-logout">
                <div id="modal-logout" class="alerta-bckg" style="display: none;">
                    <div class="modal-alerta">
                        <img src="static/img/alert2.png" alt="Alerta">
                        <div class="cont-textBox">
                            <p>¿Seguro que deseas cerrar tu sesión?</p>
                        </div>
                        <div class="cont-alerta-btn">
                            <form>
                                <input type="button" class="btn-main" onclick="window.location.href = 'p_logout.php';" value="Aceptar">
                                <input type="button" id="btn-main-cancel" class="btn-main" onclick="modalLogout();" value="Cancelar">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-container">
                <div class="modal-datos">
                    <div class="modal-datos-top">
                        <h2>Actualizar Información</h2>
                    </div>
                    <div class="modal-mid-container">
                        <?php
                            echo '
                                <form class="modal-datos-mid" name="formActInf" method="POST" action="p_update.php" enctype="multipart/form-data">
                                    <h4>Nota: Las fotos que subas aparecerán en la pantalla de inicio de sesión para
                                    todos los demás usuarios.<br>
                                    Si estás actualizando tus datos ten en cuenta que las fotos que hayas subido
                                    en el pasado serán reemplazadas por las que mandes en este formulario.</h4>
                                    <br>
                                    <p><span>*</span>Campos requeridos</p>
                                    <p><span>*</span>Nombre de Grupo (o festival en caso de que la cuenta pertenezca a uno)</p>
                                    <input type="text" name="nombreGpo" class="input-form" minlength="10" maxlength="199" value="'.$nombreGpo.'" required>
                                    <p><span>*</span>Estado</p>
                                    <input type="text" name="estado" class="input-form" minlength="3" maxlength="29" value="'.$estado.'" required>
                                    <p><span>*</span>Ciudad</p>
                                    <input type="text" name="ciudad" class="input-form" minlength="3" maxlength="99" value="'.$ciudad.'" required>
                                    <p><span>*</span>Nombre del Asociado</p>
                                    <input type="text" name="nombreDir" class="input-form" minlength="10" maxlength="99" value="'.$nombreDir.'" required>
                                    <p><span>*</span>Cargo dentro de su Agrupación</p>
                                    <input type="text" name="cargoGpo" class="input-form" minlength="5" maxlength="99" value="'.$cargoGpo.'" required>
                                    <p>Breve Reseña del Grupo o Festival</p>
                                    <textarea  rows="4" cols="73" name="resena" class="input-area" minlength="10" maxlength="999">'.$resena.'</textarea>
                                    <p><span>*</span>Datos de Contacto y Redes Sociales (separar cada dato o enlace con un espacio)</p>
                                    <textarea  rows="4" cols="73" name="contacto" class="input-area" minlength="10" maxlength="299" required>'.$contacto.'</textarea>
                                    <p>Para mejores resultados asegúrate de subir fotos en tamaño rectangular (ancho mayor y alto menor).</p>
                                    <p><span>*</span>Foto 1</p>
                                    <input type="file" accept="image/*" name="img1" id="img1" class="input-form input-file" required>
                                    <p><span>*</span>Foto 2</p>
                                    <input type="file" accept="image/*" name="img2" id="img2" class="input-form input-file" required>
                                    <p><span>*</span>Foto 3</p>
                                    <input type="file" accept="image/*" name="img3" id="img3" class="input-form input-file" required>
                                    
                                    <div class="modal-datos-mid-bottom">
                                        <input class="btn-main" type="submit" name="submit" value="Actualizar">
                                    </div>

                                </form>
                            ';
                        ?>
                    </div>
                </div>

            </div>

            <div class="datosCIOFF">
                <p>Consejo Internacional de Organizaciones de Festivales de Folklore y de las Artes Tradicionales</p>
            </div>

        </div>

    </div>

</body>
</html>