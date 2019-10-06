<?php
	session_start();
	if (!$_SESSION['sesion']) { header("Location:index.php"); }
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

            <div class="modal-container">
                <div class="modal-datos modal-small">
                    <div class="modal-datos-top">
                        <h2>Registro de Invitado</h2>
                    </div>
                    <div class="modal-mid-container">
                    	<a class="btn-form btn-main darkblue-btn" href="registro.php">Volver al inicio</a>
                        <br>
                        <img class="align-img" src="static/img/success.png" alt="Registro completado."><br><br>
                        <h2 class="align-center">¡Listo! Estás registrado</h2><br>
                        <h3 class="align-center">Da clic al siguiente botón para generar tu entrada.</h3>
                        <div class="modal-datos-mid-bottom margin-final">
                            <input type="button" class="btn-main" onclick="window.location.href = 'entradaInvitado.php';" value="Generar entrada">
                        </div>
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