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
    // con "SET NAMES 'utf8'" evito caracteres extranos en peticiones a MySQL
    mysqli_query($con, "SET NAMES 'utf8'");
    $SQL       = "SELECT * FROM grupo WHERE idUsuario = $idUser;";
    $resultado = RunQuery($con, $SQL);
    $arr_grupo = mysqli_fetch_assoc($resultado);

    // asignacion de variables para facil lectura
    $nombreGpo = $arr_grupo["nombreGpo"];
    $estado    = $arr_grupo["estado"];
    $ciudad    = $arr_grupo["ciudad"];
    $nombreDir = $arr_grupo["nombreDir"];
    $cargoGpo  = $arr_grupo["cargoGpo"];
    $resena    = $arr_grupo["resena"];
    $contacto  = $arr_grupo["contacto"];
    $img1      = $arr_grupo["img1"];
    $img2      = $arr_grupo["img2"];
    $img3      = $arr_grupo["img3"];

    $SQL            = "SELECT estatus, actualizado FROM usuario WHERE idUsuario = $idUser;";
    $res            = RunQuery($con, $SQL);
    $arr_user       = mysqli_fetch_assoc($res);
    $estatusMiembro = $arr_user["estatus"];
    $actualizado    = $arr_user["actualizado"];

    Disconnect($con);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="static/css/estilos.css">
    <script type="text/javascript" src="static/js/funciones.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <link rel="icon" type="image/ico" href="static/img/Logo_CIOFF_pequeno.png"/>
    <title>Mi Cuenta</title>
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
                        <a id="blue_a" href="miCuenta.php">Mi Cuenta</a>
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

            <?php
                if ($actualizado == 1) {
                    echo '
                        <div class="modal-container">
                            <div class="modal-datos">
                                <div class="modal-datos-top">
                                    <h2>Mi Cuenta</h2>
                                </div>
                                <div class="modal-mid-cuenta">
                                    
                                    <h3 class="modal-mid-cuenta-title bold">'.$nombreGpo.'</h3>
            
                                    <h4 class="modal-mid-cuenta-title">'.$estado.' - '.$ciudad.'</h4>

                                    <h4 class="modal-mid-cuenta-title">'.$nombreDir.' | '.$cargoGpo.'</h4>

                                    <h4 class="modal-mid-cuenta-title">- '.$estatusMiembro.' -</h4>
                                    
                                    <img class="img-main" src="'.$img1.'" alt="'.$nombreGpo.'">
                                    <img class="img-sec" src="'.$img2.'" alt="'.$nombreGpo.'">
                                    <img class="img-sec" src="'.$img3.'" alt="'.$nombreGpo.'">
            
                                    <div class="modal-mid-cuenta-text-container">
                                        <h4 class="modal-mid-cuenta-title">Reseña</h4>
                                        <p class="modal-mid-cuenta-text">'.$resena.'</p>
                                    </div>
            
                                    <div class="modal-mid-cuenta-text-container">
                                        <h4 class="modal-mid-cuenta-title">Contacto</h4>
                                        <p class="modal-mid-cuenta-text">'.$contacto.'</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                } else {
                    echo '
                        <div id="modal-alerta-in" class="modal-alerta">
                            <img src="static/img/alert2.png" alt="Alerta">
                            <div class="cont-textBox">
                                <p>Aún no has agregado información sobre tu agrupación.</p>
                                <br>
                                <p>Por favor, da clic al apartado "Actualizar Información"
                                del menú de la izquierda o al botón de abajo para 
                                agregar la información.</p>
                            </div>
                            <div class="cont-alerta-btn">
                                <form>
                                    <input type="button" class="btn-main" onclick="window.location.href =\'actualizar.php\';" value="Actualizar Información">
                                </form>
                            </div>
                        </div>
                    ';
                }
            ?>

            <div class="datosCIOFF">
                <p>Consejo Internacional de Organizaciones de Festivales de Folklore y de las Artes Tradicionales</p>
            </div>

        </div>

    </div>

</body>
</html>