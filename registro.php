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

    $SQL            = "SELECT actualizado, faseRegistro, pagado FROM usuario WHERE idUsuario = $idUser;";
    $res            = RunQuery($con, $SQL);
    $arr_user       = mysqli_fetch_assoc($res);
    $actualizado    = $arr_user["actualizado"];
    $faseRegistro   = $arr_user["faseRegistro"];
    $pagado         = $arr_user["pagado"];
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
                if ($actualizado == 1 && $faseRegistro == 0) {
                    // el usuario ya actualizo su informacion pero no ha respondido el form de registro
                    echo '
                        <div class="modal-container">
                            <div class="modal-datos">
                                <div class="modal-datos-top">
                                    <h2>Registro al Congreso</h2>
                                    <a class="btn-form btn-main darkblue-btn" style="left: 67%; z-index: 4; top: 4.5%;"
                                    href="registroInvitado.php">Registrar un invitado</a>
                                </div>
                                <div class="modal-mid-container">
                                    <form id="formReg" class="modal-datos-mid" name="formActInf" method="POST" action="p_registro1.php" enctype="multipart/form-data">
                                        <h4>Nota: Tus datos como tu nombre, tu número de socio, estado y ciudad ya están alamacenados,
                                        por lo tanto no te los pediremos en el llenado de este formulario.<br><br>
                                        Si estás registrado en la plataforma con dos agrupaciones o más, por favor, contesta 
                                        este formulario con solo una de ellas.</h4>
                                        <br>
                                        <p><span>*</span>Campos requeridos</p>
                                        <p><span>*</span>Si ya realizaste tu pago en su totalidad o ya pagaste alguna parte
                                         de tu registro, por favor, selecciona el mes en que realizaste el pago</p>
                                        <select class="input-form comboBox monthCombo" name="mesPago" form="formReg" style="width: 56%;" required>
                                            <option selected disabled value="">Mes</option>
                                            <option value="0">No he pagado aún</option><option value="6">Junio</option>
                                            <option value="7">Julio</option><option value="8">Agosto</option><option value="9">Septiembre</option>
                                            <option value="10">Octubre</option><option value="11">Noviembre</option>
                                        </select>
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
                                        <p><span>*</span>Personas con las que compartirá habitación<br> (separar cada uno de ellos con una coma (","), en caso de no tener, 
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
                    Disconnect($con);

                } elseif ($actualizado == 1 && $faseRegistro == 1) {
                    // el usuario ya actualizo y respondio el form de registro
                    $SQLreg        = "SELECT * FROM registrocongreso WHERE numSocio = $numSocio;";
                    $resreg        = RunQuery($con, $SQLreg);
                    $arr_assoc_reg = mysqli_fetch_assoc($resreg);
                    
                    $correo           = $arr_assoc_reg["correo"];
                    $nombre           = $arr_assoc_reg["nombre"];
                    $fechaNacimiento  = $arr_assoc_reg["fechaNacimiento"];
                    $estado           = $arr_assoc_reg["estado"];
                    $ciudad           = $arr_assoc_reg["ciudad"];
                    $telefonoCelular  = $arr_assoc_reg["telefonoCelular"];
                    $telefonoFijo     = $arr_assoc_reg["telefonoFijo"];
                    $grupo            = $arr_assoc_reg["grupo"];
                    $puestoEnGrupo    = $arr_assoc_reg["puestoEnGrupo"];
                    $habitacion       = $arr_assoc_reg["habitacion"];
                    $acompanantes     = $arr_assoc_reg["acompanantes"];
                    $fechaHoraLlegada = $arr_assoc_reg["fechaHoraLlegada"];
                    $fechaHoraSalida  = $arr_assoc_reg["fechaHoraSalida"];
                    $monto            = $arr_assoc_reg["monto"];

                    // convierto las fechas a un formato dia mes annio
                    $newFecha = date("d-m-Y", strtotime($fechaNacimiento));
                    $newFechaHoraLlegada = date("d-m-Y H:i", strtotime($fechaHoraLlegada));
                    $newFechaHoraSalida = date("d-m-Y H:i", strtotime($fechaHoraSalida));
                    
                    echo '
                        <div class="modal-container">
                            <div class="modal-datos">
                                <div class="modal-datos-top">
                                    <h2>Registro al Congreso</h2>
                                    <a class="btn-form btn-main darkblue-btn" style="left: 68%; z-index: 4; top: 4.6%;" 
                                    href="registroInvitado.php">Registrar un invitado</a>
                                </div>
                                <div class="modal-mid-container">
                                    <form class="modal-datos-mid" name="formActInf" method="POST" action="subirPDF.php" enctype="multipart/form-data">
                                        <h4>Nota: Para corregir tus datos como el nombre de tu agrupación o tu cargo dentro de la misma es necesario
                                        que des clic al apartado "Actualizar Información" y envíes el formulario (actualizar tus datos), después regresa a esta pantalla
                                        y da clic en el botón "Corregir datos" en la parte superior del formulario, si solo te equivocaste en 
                                        algún campo del formulario de registro al congreso solo da clic al botón "Corregir datos".</h4>
                                        <br>
                                        <p>La información que ingresaste es la siguiente.</p>
                                        <p>Número de socio: '.$numSocio.'</p>
                                        <p>Nombre</p>
                                        <h4>'.$nombre.'</h4>
                                        <p>Estado</p>
                                        <h4>'.$estado.'</h4>
                                        <p>Ciudad</p>
                                        <h4>'.$ciudad.'</h4>
                                        <p>Grupo</p>
                                        <h4>'.$grupo.'</h4>
                                        <p>Cargo en su agrupación</p>
                                        <h4>'.$puestoEnGrupo.'</h4>
                                        <p>Fecha de Nacimiento</p>
                                        <h4>'.$newFecha.'</h4>
                                        <p>Teléfono Celular</p>
                                        <h4>'.$telefonoCelular.'</h4>
                                        <p>Teléfono Fijo</p>
                                        <h4>'.$telefonoFijo.'</h4>
                                        <p>Tipo de Habitación</p>
                                        <h4>'.$habitacion.'</h4>
                                        <p>Personas con las que compartirá habitación</p>
                                        <h4>'.$acompanantes.'</h4>
                                        <p>Fecha y hora de llegada</p>
                                        <h4>'.$newFechaHoraLlegada.'</h4>
                                        <p>Fecha y hora de salida</p>
                                        <h4>'.$newFechaHoraSalida.'</h4>
                                        <p>Antes de continuar revisa que la información que ingresaste es correcta.</p><br>
                                        <p id="bigText">IMPORTANTE</p><br>
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
                                            <p id="bigText">Tu monto total a pagar es de:<br><br>$'.$monto.'</p><br>
                                            ';
                                        }
                                        echo '
                                        <p id="bigText" style="color: rgb(0,120,190); font-weight: bold;">NOTA: Si ya has realizado anteriormente 
                                        algún pago es necesario que verifiques la cantidad que hasta el momento has cubierto,
                                         y partiendo de ese número determines la cantidad que tienes que pagar para liquidar el pago completo.</p>
                                        <p id="bigText">Para validar tu pago es necesario que el/los escaneo(s) o 
                                        foto(s) de tu(s) recibo(s)/voucher(s) tenga(n) escrito(s) tu nombre para
                                        verificar tu identidad.<br><br>
                                        Si son varios los puedes subir en un documento de Word, o en una carpeta 
                                        comprimida en .zip o .rar</p><br>
                                        <p><span>*</span>Sube aquí tu recibo(s)/voucher(s) de pago en un 
                                        documento de Word, una imagen/foto o una carpeta comprimida
                                        en .zip o .rar</p>
                                        <input type="file" name="pdf" id="pdf" class="input-form input-file" required>
                                        <input style="display: none;" type="text" name="key" value="notkey">
                                        <div class="modal-datos-mid-bottom inline-buttons">
                                            <input class="btn-main" type="submit" name="submit" value="Subir recibo">
                                        </div>
                                    </form>
                                    <form class="btn-form" method="POST" name="formCorregir" action="corregir.php">
                                        <input style="display: none;" type="text" name="key" value="key">
                                        <input class="btn-main darkblue-btn" type="submit" value="Corregir datos">
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
                    Disconnect($con);
                } elseif ($actualizado == 1 && $faseRegistro == 3) {
                    // es faseRegistro 3 si el usuario quiere corregir sus datos
                    $SQL = "SELECT correo, fechaNacimiento, telefonoCelular, telefonoFijo,
                     acompanantes, fechaHoraLlegada, fechaHoraSalida FROM registrocongreso 
                     WHERE numSocio = $numSocio;";
                    $resSQLUP        = RunQuery($con, $SQL);
                    $arr_ass_UP      = mysqli_fetch_assoc($resSQLUP);
                    $correo          = $arr_ass_UP["correo"];
                    $fechaNacimiento = $arr_ass_UP["fechaNacimiento"];
                    $telefonoCelular = $arr_ass_UP["telefonoCelular"];
                    $telefonoFijo    = $arr_ass_UP["telefonoFijo"];
                    $acompanantes    = $arr_ass_UP["acompanantes"];
                    // se imprimen los datos antes ingresados para hacer update
                    echo '
                        <div class="modal-container">
                            <div class="modal-datos">
                                <div class="modal-datos-top">
                                    <h2>Actualizar Registro al Congreso</h2>
                                </div>
                                <div class="modal-mid-container">
                                    <form id="formReg" class="modal-datos-mid" name="formActInf" method="POST" action="p_registro_update.php" enctype="multipart/form-data">
                                        <h4>Nota: Tus datos como tu nombre, tu número de socio, estado y ciudad ya están alamacenados,
                                        por lo tanto no te los pediremos en el llenado de este formulario.<br><br>
                                        Si estás registrado en la plataforma con dos agrupaciones o más, por favor, contesta 
                                        este formulario con solo una de ellas.</h4>
                                        <br>
                                        <p><span>*</span>Campos requeridos</p>
                                        <p><span>*</span>Si ya realizaste tu pago en su totalidad o ya pagaste alguna parte
                                         de tu registro, por favor, selecciona el mes en que realizaste el pago</p>
                                        <select class="input-form comboBox monthCombo" name="mesPago" form="formReg" style="width: 56%;" required>
                                            <option selected disabled value="">Mes</option>
                                            <option value="0">No he pagado aún</option><option value="6">Junio</option>
                                            <option value="7">Julio</option><option value="8">Agosto</option><option value="9">Septiembre</option>
                                            <option value="10">Octubre</option><option value="11">Noviembre</option>
                                        </select>
                                        <p><span>*</span>Correo</p>
                                        <input type="email" name="correo" class="input-form" minlength="5" maxlength="99" value="'.$correo.'" required>
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
                                        <input type="text" name="telefono" class="input-form" maxlength="10" value="'.$telefonoCelular.'" required>
                                        <p>Teléfono Fijo</p>
                                        <input type="text" name="telefonoFijo" class="input-form" minlength="5" maxlength="49" value="'.$telefonoFijo.'">
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
                                        <textarea rows="4" cols="73" name="acompanantes" class="input-area input-area-short" minlength="1" maxlength="499" required>'.$acompanantes.'</textarea>
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
                                            <input class="btn-main" type="submit" name="submit" style="margin-left: -10px;" value="Actualizar registro">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
                    Disconnect($con);
                } elseif ($actualizado == 1 && $faseRegistro == 4 && $pagado == 0) {
                    // el usuario ya subio su recibo, el recibo se está comprobando
                    echo '
                        <div class="modal-container">
                            <div class="modal-datos modal-small">
                                <div class="modal-datos-top">
                                    <h2>Registro al Congreso</h2>
                                    <a class="btn-form btn-main darkblue-btn" style="left: 69%; z-index: 4; top: 6.9%;" 
                                    href="registroInvitado.php">Registrar un invitado</a>
                                </div>
                                <div class="modal-mid-container">
                                    <br><br>
                                    <img class="align-img small-alert" src="static/img/alert2.png" alt="Alerta"><br><br><br>
                                    <h2 class="align-center">¡Perfecto! Estás a un paso de estar registrado</h2><br><br>
                                    <h3 class="align-center">Estamos verificando tu recibo, una vez verificado podrás generar tu entrada.</h3>
                                    <form class="btn-form" method="POST" name="formCorregir" action="corregirPDF.php">
                                        <input style="display: none;" type="text" name="key" value="key">
                                        <input class="btn-main darkblue-btn" type="submit" value="Corregir recibo">
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
                    Disconnect($con);
                } elseif ($actualizado == 1 && $faseRegistro == 4 && $pagado == 1) {
                    // el usuario ya subio su recibo y puede generar su entrada en pdf
                    
                    echo '<a class="btn-form btn-main darkblue-btn" style="left: 330px;"
                    href="registroInvitado.php">Registrar un invitado</a>';
                    echo '
                        <div class="modal-container">
                            <div class="modal-datos modal-small">
                                <div class="modal-datos-top">
                                    <h2>Registro al Congreso</h2>
                                </div>
                                <div class="modal-mid-container">
                                    <br>
                                    <img class="align-img" src="static/img/success.png" alt="Registro completado."><br><br>
                                    <h2 class="align-center">¡Listo! Estás registrado</h2><br>
                                    <h3 class="align-center">Tu recibo ha sido verificado, da clic al siguiente botón para generar tu entrada.</h3>
                                    <div class="modal-datos-mid-bottom margin-final">
                                        <input type="button" class="btn-main" onclick="window.location.href = \'entrada.php\';" value="Generar entrada">
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                    Disconnect($con);
                } else {
                    // el usuario no ha actualizado sus datos
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
                    Disconnect($con);
                }
            ?>

            <div class="datosCIOFF">
                <p>Consejo Internacional de Organizaciones de Festivales de Folklore y de las Artes Tradicionales</p>
            </div>

        </div>

    </div>

</body>
</html>