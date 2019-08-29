<?php
	session_start();
    if (!$_SESSION['sesion']) { header("Location:index.php"); }
?>

<?php 

    include("Connection.php");
    $con       = Connect();
    $idUser    = $_SESSION["idUsuario"];
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
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <title>Error</title>
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
                        <a href="actualizar.php">Actualizar Información</a>
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
                    <a href="cerrarSesion.php">Cerrar Sesión</a>
                </li>
            </ul>

        </div>

        <div class="contenido">
            <div id="modal-alerta-in" class="modal-alerta">
                <img src="static/img/alert2.png" alt="Alerta">
                <div class="cont-textBox">
                    <p>¡Ocurrió un error!</p>
                    <!-- <h6>Código de Error: 222</h6> -->
                </div>
                <div class="cont-alerta-btn">
                    <form>
                        <input type="button" class="btn-main" onclick="window.location.href = 'miCuenta.php';" value="Volver a Mi Cuenta"/>
                    </form>
                </div>
            </div>

            <div class="datosCIOFF">
                <p>Consejo Internacional de Organizaciones de Festivales de Folklore y de las Artes Tradicionales</p>
            </div>

        </div>

    </div>

</body>
</html>