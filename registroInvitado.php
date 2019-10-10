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

        		echo '
                    <div class="modal-container">
                        <div class="modal-datos">
                            <div class="modal-datos-top">
                                <h2>Registro de Invitado</h2>
                            </div>
                            <div class="modal-mid-container">
                                <a class="btn-form btn-main darkblue-btn" href="registro.php">Volver</a>
                                <form id="formReg" class="modal-datos-mid" name="formActInf" method="POST" action="registroInvitado2.php" enctype="multipart/form-data">
                                    <p><span>*</span>Campos requeridos</p>
                                    <p><span>*</span>Si ya realizaste tu pago en su totalidad o ya pagaste alguna parte
                                     de tu registro, por favor, selecciona el mes en que realizaste el pago</p>
                                    <select class="input-form comboBox monthCombo" name="mesPago" form="formReg" style="width: 56%;" required>
                                        <option selected disabled value="">Mes</option>
                                        <option value="0">No he pagado aún</option><option value="6">Junio</option>
                                        <option value="7">Julio</option><option value="8">Agosto</option><option value="9">Septiembre</option>
                                        <option value="10">Octubre</option><option value="11">Noviembre</option>
                                    </select>
                                    <p><span>*</span>Nombre completo</p>
                                    <input type="text" name="nombre" class="input-form" minlength="5" maxlength="99" required>
                                    <p><span>*</span>Estado</p>
                                    <input type="text" name="estado" class="input-form" minlength="3" maxlength="29" required>
                                    <p><span>*</span>Ciudad</p>
                                    <input type="text" name="ciudad" class="input-form" minlength="3" maxlength="99" required>
                                    <p><span>*</span>Correo</p>
                                    <input type="email" name="correo" class="input-form" placeholder="miCorreo@mail.com" minlength="5" maxlength="99" required>
                                    <p><span>*</span>Fecha de Nacimiento</p>
                                    <select class="input-form comboBox" name="diaFec" form="formReg" required>
                                        <option selected disabled value="">Día</option>
                                        <option value="01">1</option><option value="02">2</option><option value="03">3</option>
                                        <option value="04">4</option><option value="05">5</option><option value="06">6</option>
                                        <option value="07">7</option><option value="08">8</option><option value="09">9</option>
                                        <option value="10">10</option><option value="11">11</option><option value="12">12</option>
                                        <option value="13">13</option><option value="14">14</option><option value="15">15</option>
                                        <option value="16">16</option><option value="17">17</option><option value="18">18</option>
                                        <option value="19">19</option><option value="20">20</option><option value="21">21</option>
                                        <option value="22">22</option><option value="23">23</option><option value="24">24</option>
                                        <option value="25">25</option><option value="26">26</option><option value="27">27</option>
                                        <option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                    <select class="input-form comboBox monthCombo" name="mesFec" form="formReg" required>
                                        <option selected disabled value="">Mes</option>
                                        <option value="01">Enero</option><option value="02">Febrero</option><option value="03">Marzo</option>
                                        <option value="04">Abril</option><option value="05">Mayo</option><option value="06">Junio</option>
                                        <option value="07">Julio</option><option value="08">Agosto</option><option value="09">Septiembre</option>
                                        <option value="10">Octubre</option><option value="11">Noviembre</option><option value="12">Diciembre</option>
                                    </select>
                                    <input type="number" name="anioFec" class="input-form comboBox" placeholder="2019" min="1900" max="2019" required>
                                    <p><span>*</span>Teléfono Celular</p>
                                    <input type="text" name="telefono" class="input-form" placeholder="4421234567" maxlength="10" required>
                                    <p>Teléfono Fijo</p>
                                    <input type="text" name="telefonoFijo" class="input-form" placeholder="123 4567" minlength="5" maxlength="49">
                                    <p><span>*</span>Tipo de Habitación</p>
                                    <input type="radio" name="habitacion" class="radioBTN" value="Individual" required> Sencilla
                                    <br><br>
                                    <input type="radio" name="habitacion" class="radioBTN" value="Doble" required>  Doble
                                    <br><br>
                                    <input type="radio" name="habitacion" class="radioBTN" value="Triple" required>  Triple
                                    <br><br>
                                    <input type="radio" name="habitacion" class="radioBTN" value="Cuadruple" required>  Cuádruple
                                    <p><span>*</span>Personas con las que compartirá habitación (separar cada uno de ellos con una coma (","), en caso de no tener, 
                                    llena este campo con un guión "-")</p>
                                    <textarea rows="4" cols="73" name="acompanantes" class="input-area input-area-short" minlength="1" maxlength="499" required></textarea>
                                    <p><span>*</span>Fecha y hora de llegada</p>
                                    <select class="input-form comboBox" name="diaFecLleg" form="formReg" required>
                                        <option selected disabled value="">Día</option>
                                        <option value="01">1</option><option value="02">2</option><option value="03">3</option>
                                        <option value="04">4</option><option value="05">5</option><option value="06">6</option>
                                        <option value="07">7</option><option value="08">8</option><option value="09">9</option>
                                        <option value="10">10</option><option value="11">11</option><option value="12">12</option>
                                        <option value="13">13</option><option value="14">14</option><option value="15">15</option>
                                        <option value="16">16</option><option value="17">17</option><option value="18">18</option>
                                        <option value="19">19</option><option value="20">20</option><option value="21">21</option>
                                        <option value="22">22</option><option value="23">23</option><option value="24">24</option>
                                        <option value="25">25</option><option value="26">26</option><option value="27">27</option>
                                        <option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                    <select class="input-form comboBox monthCombo" name="mesFecLleg" form="formReg" required>
                                        <option selected disabled value="">Mes</option>
                                        <option value="10">Octubre</option><option value="11">Noviembre</option>
                                    </select>
                                    <select class="input-form comboBox" name="llegadaH" form="formReg" required>
                                        <option selected disabled value="">Hora</option>
                                        <option value="00">00</option><option value="01">01</option><option value="02">02</option>
                                        <option value="03">03</option><option value="04">04</option><option value="05">05</option>
                                        <option value="06">06</option><option value="07">07</option><option value="08">08</option>
                                        <option value="09">09</option><option value="10">10</option><option value="11">11</option>
                                        <option value="12">12</option><option value="13">13</option><option value="14">14</option>
                                        <option value="15">15</option><option value="16">16</option><option value="17">17</option>
                                        <option value="18">18</option><option value="19">19</option><option value="20">20</option>
                                        <option value="21">21</option><option value="22">22</option><option value="23">23</option>
                                    </select>
                                    <select class="input-form comboBox" name="llegadaM" form="formReg" required>
                                        <option selected disabled value="">Minutos</option>
                                        <option value="00">00</option>
                                        <option value="15">15</option><option value="30">30</option><option value="45">45</option>
                                    </select>
                                    <p><span>*</span>Fecha y hora de salida</p>
                                    <select class="input-form comboBox" name="diaFecSal" form="formReg" required>
                                        <option selected disabled value="">Día</option>
                                        <option value="01">1</option><option value="02">2</option><option value="03">3</option>
                                        <option value="04">4</option><option value="05">5</option><option value="06">6</option>
                                        <option value="07">7</option><option value="08">8</option><option value="09">9</option>
                                        <option value="10">10</option><option value="11">11</option><option value="12">12</option>
                                        <option value="13">13</option><option value="14">14</option><option value="15">15</option>
                                        <option value="16">16</option><option value="17">17</option><option value="18">18</option>
                                        <option value="19">19</option><option value="20">20</option><option value="21">21</option>
                                        <option value="22">22</option><option value="23">23</option><option value="24">24</option>
                                        <option value="25">25</option><option value="26">26</option><option value="27">27</option>
                                        <option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                    <select class="input-form comboBox monthCombo" name="mesFecSal" form="formReg" required>
                                        <option selected disabled value="">Mes</option>
                                        <option value="11">Noviembre</option><option value="12">Diciembre</option>
                                    </select>
                                    <select class="input-form comboBox" name="salidaH" form="formReg" required>
                                        <option selected disabled value="">Hora</option>
                                        <option value="00">00</option><option value="01">01</option><option value="02">02</option>
                                        <option value="03">03</option><option value="04">04</option><option value="05">05</option>
                                        <option value="06">06</option><option value="07">07</option><option value="08">08</option>
                                        <option value="09">09</option><option value="10">10</option><option value="11">11</option>
                                        <option value="12">12</option><option value="13">13</option><option value="14">14</option>
                                        <option value="15">15</option><option value="16">16</option><option value="17">17</option>
                                        <option value="18">18</option><option value="19">19</option><option value="20">20</option>
                                        <option value="21">21</option><option value="22">22</option><option value="23">23</option>
                                    </select>
                                    <select class="input-form comboBox" name="salidaM" form="formReg" required>
                                        <option selected disabled value="">Minutos</option>
                                        <option value="00">00</option>
                                        <option value="15">15</option><option value="30">30</option><option value="45">45</option>
                                    </select>

                                    <div class="modal-datos-mid-bottom">
                                        <input class="btn-main" type="submit" name="submit" value="Registrarse">
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