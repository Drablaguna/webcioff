<?php
	session_start();
	if (!$_SESSION['sesion']) { header("Location:index.php"); }
    $_SESSION["tiempoIn"] = time();
    if ($_SESSION["tiempoIn"] >= $_SESSION["tiempoLim"]) {
        echo'<script type="text/javascript">
            alert("Tiempo de sesión expirado, vuelve a iniciar sesión.");
            window.location.href="p_logout.php";
            </script>';
    }

?>

<?php

	include("Connection.php");
    $con       = Connect();
    $idUser    = $_SESSION["idUsuario"];
    $numSocio  = $_SESSION["numSocio"];
    mysqli_query($con, "SET NAMES 'utf8'");
    $SQL       = "SELECT nombreDir FROM grupo WHERE idUsuario = $idUser;";
    $resultado = RunQuery($con, $SQL);
    $arr_assoc = mysqli_fetch_assoc($resultado);
    $nombreDir = $arr_assoc["nombreDir"];
    Disconnect($con);

    if (empty($_POST)) {
        header("Location:registroInvitado.php");
    } else {
        $_SESSION["arrInvitado"] = $_POST;
    }

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
    <link rel="icon" type="image/ico" href="static/img/Logo_CIOFF_pequeno.png"/>
    <title>Registro al Congreso</title>
</head>
<body>
    
    <div class="container">

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
                        <a href="actualizar.php">Actualizar Información</a>
                    </li>
                    <li class="cont-option">
                        <img src="static/img/clipboard.png" alt="Registro al Congreso">
                        <a id="blue_a" href="registro.php">Registro al Congreso</a>
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

        	<?php
                
                $correo           = $_POST["correo"];
                $nombre           = $_POST["nombre"];
                $nombreArr = explode(" ", $nombre);
                $_SESSION["nombreInvitado"] = $nombreArr[0];
                $diaFec           = $_POST["diaFec"];
                $mesFec           = $_POST["mesFec"];
                $anioFec          = $_POST["anioFec"];
                $estado           = $_POST["estado"];
                $ciudad           = $_POST["ciudad"];
                $telefonoCelular  = $_POST["telefono"];
                $telefonoFijo     = $_POST["telefonoFijo"];
                if ($telefonoFijo == "") { $telefonoFijo = "-"; }
                $habitacion       = $_POST["habitacion"];
                $acompanantes     = $_POST["acompanantes"];
                
                $diaFecLleg = $_POST["diaFecLleg"];
                $mesFecLleg = $_POST["mesFecLleg"];
                $llegadaH = $_POST["llegadaH"];
                $llegadaM = $_POST["llegadaM"];
                $diaFecSal = $_POST["diaFecSal"];
                $mesFecSal = $_POST["mesFecSal"];
                $salidaH = $_POST["salidaH"];
                $salidaM = $_POST["salidaM"];

                $fechaNac = $diaFec."-".$mesFec."-".$anioFec;
                $newLlegada = "2019-".$mesFecLleg."-".$diaFecLleg." ".$llegadaH.":".$llegadaM.":00";
                $newSalida = "2019-".$mesFecSal."-".$diaFecSal." ".$salidaH.":".$salidaM.":00";

                $mesPago = $_POST["mesPago"];
                $habitacion = $_POST["habitacion"];
                $monto = 0.00;          
                $thisMonth = date("m");

                if ($mesPago == 0) {
                    $monto = calcularMonto($thisMonth, $habitacion);
                }

                $_SESSION["arrInvitado"]["monto"] = $monto;
                
                echo '
                    <div class="modal-container">
                        <div class="modal-datos">
                            <div class="modal-datos-top">
                                <h2>Registro de Invitado</h2>
                                <a class="btn-form btn-main darkblue-btn" href="registroInvitado.php">Corregir datos</a>
                            </div>
                            <div class="modal-mid-container">
                                <form class="modal-datos-mid" name="formActInf" method="POST" action="subirPDF.php" enctype="multipart/form-data">
                                    <br>
                                    <p>La información que ingresaste es la siguiente.</p>
                                    <p>Nombre</p>
                                    <h4>'.$nombre.'</h4>
                                    <p>Estado</p>
                                    <h4>'.$estado.'</h4>
                                    <p>Ciudad</p>
                                    <h4>'.$ciudad.'</h4>
                                    <p>Fecha de Nacimiento</p>
                                    <h4>'.$fechaNac.'</h4>
                                    <p>Teléfono Celular</p>
                                    <h4>'.$telefonoCelular.'</h4>
                                    <p>Teléfono Fijo</p>
                                    <h4>'.$telefonoFijo.'</h4>
                                    <p>Tipo de Habitación</p>
                                    <h4>'.$habitacion.'</h4>
                                    <p>Acompañantes</p>
                                    <h4>'.$acompanantes.'</h4>
                                    <p>Fecha y hora de llegada</p>
                                    <h4>'.$newLlegada.'</h4>
                                    <p>Fecha y hora de salida</p>
                                    <h4>'.$newSalida.'</h4>
                                    <p>Antes de continuar revisa que la información que ingresaste es correcta.</p><br>
                                    <p id="bigText">IMPORTANTE</p><br>
                                    <p id="bigText">Para quedar debidamente registrado es necesario que subas el recibo/voucher de tu pago.</p><br>
                                    ';
                                    if ($monto >= 1) {
                                        echo '
                                        <p id="bigText">Para realizar el pago es necesario que deposites la cantidad exacta 
                                        a la siguiente cuenta</p>
                                        <p id="bigText">LORENA DEL CARMEN DUARTE CARRILLO<br>
                                        BANORTE<br>
                                        Cuenta
                                        1027869988<br>
                                        Clave Interbancaria
                                        072 930 010278699881</p>
                                        <p id="bigText">Tu monto a pagar es de:<br><br>$'.$monto.'</p><br>
                                        ';
                                    }
                                    echo '
                                    <p id="bigText">Para validar tu pago es necesario que el/los escaneo(s) o 
                                    foto(s) de tu(s) recibo(s)/voucher(s) tenga(n) escrito(s) tu nombre para
                                    verificar tu identidad.<br><br>
                                    Si son varios los puedes subir en un documento de Word, o en una carpeta 
                                    comprimida en .zip o .rar</p><br>
                                    <p id="bigText">Una vez que subas tu recibo de pago automaticamente quedarás registrado 
                                    y se descargará tu entrada al congreso.</p><br>
                                    <p><span>*</span>Sube aquí tu recibo(s)/voucher(s) de pago en un 
                                    documento de Word, una imagen/foto o una carpeta comprimida
                                    en .zip o .rar</p>
                                    <input type="file" name="pdf" id="pdf" class="input-form input-file" required>
                                    <input style="display: none;" type="text" name="key" value="key">

                                    <div class="modal-datos-mid-bottom inline-buttons">
                                        <input class="btn-main" type="submit" name="submit" value="Subir recibo">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                ';

        	?>

        	<div class="datosCIOFF">
                <p>Consejo Internacional de Organizaciones de Festivales de Folklore y de las Artes Tradicionales</p>
            </div>

        </div>

    </div>

</body>
</html>