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
                                </div>
                                <div class="modal-mid-container">
                                    <form class="modal-datos-mid" name="formActInf" method="POST" action="p_registro1.php" enctype="multipart/form-data">
                                        <h4>Nota: Tus datos como tu nombre, tu número de socio, estado y ciudad ya están alamacenados,
                                        por lo tanto no te los pediremos en el llenado de este formulario.<br><br>
                                        Si estás registrado en la plataforma con dos agrupaciones o más, por favor, contesta 
                                        este formulario con solo una de ellas.</h4>
                                        <br>
                                        <p><span>*</span>Campos requeridos</p>
                                        <p><span>*</span>Correo</p>
                                        <input type="email" name="correo" class="input-form" placeholder="miCorreo@mail.com" minlength="5" maxlength="99" required>
                                        <p><span>*</span>Fecha de Nacimiento</p>
                                        <input type="date" name="fechaNac" class="input-form" placeholder="dd/mm/aaaa" required>
                                        <p><span>*</span>Teléfono Celular</p>
                                        <input type="text" name="telefono" class="input-form" placeholder="442 123 4567" minlength="5" maxlength="49" required>
                                        <p>Teléfono Fijo</p>
                                        <input type="text" name="telefonoFijo" class="input-form" placeholder="123 4567" minlength="5" maxlength="49">
                                        <p><span>*</span>Tipo de Habitación</p>
                                        <input type="radio" name="habitacion" class="radioBTN" value="Individual" required> Individual - $1000.00 MXN
                                        <br><br>
                                        <input type="radio" name="habitacion" class="radioBTN" value="Doble" required>  Doble - $2000.00 MXN
                                        <br><br>
                                        <input type="radio" name="habitacion" class="radioBTN" value="Triple" required>  Triple - $3000.00 MXN
                                        <br><br>
                                        <input type="radio" name="habitacion" class="radioBTN" value="Cuadruple" required>  Cuádruple - $4000.00 MXN
                                        <p><span>*</span>Acompañantes (separar cada uno de ellos con un espacio, en caso de no tener, 
                                        llena este campo con un guión "-")</p>
                                        <textarea rows="4" cols="73" name="acompanantes" class="input-area input-area-short" minlength="1" maxlength="499" required></textarea>
                                        <p><span>*</span>Fecha de llegada</p>
                                        <input type="date" name="llegadaF" class="input-form" required>
                                        <p><span>*</span>Hora de llegada</p>
                                        <input type="time" name="llegadaH" class="input-form" required>
                                        <p><span>*</span>Fecha de salida</p>
                                        <input type="date" name="salidaF" class="input-form" required>
                                        <p><span>*</span>Hora de salida</p>
                                        <input type="time" name="salidaH" class="input-form" required>
                                        
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

                    if ($newFechaHoraLlegada == "0000-00-00 00:00:00") {
                        $newFechaHoraLlegada = "Aún no has agregado una fecha y hora de llegada.";
                    }

                    if ($newFechaHoraSalida == "0000-00-00 00:00:00") {
                        $newFechaHoraSalida = "Aún no has agregado una fecha y hora de llegada.";
                    }

                    echo '
                        <div class="modal-container">
                            <div class="modal-datos">
                                <div class="modal-datos-top">
                                    <h2>Registro al Congreso</h2>
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
                                        <p>Acompañantes</p>
                                        <h4>'.$acompanantes.'</h4>
                                        <p>Fecha y hora de llegada</p>
                                        <h4>'.$newFechaHoraLlegada.'</h4>
                                        <p>Fecha y hora de salida</p>
                                        <h4>'.$newFechaHoraSalida.'</h4>
                                        <p>Monto a pagar</p>
                                        <h4>'.$monto.'</h4>
                                        
                                        <p>Si tus datos son correctos da clic al botón de abajo para generar tu recibo de registro al congreso.</p>

                                        <p><span>*</span>Sube aquí tu recibo ya pagado en PDF</p>
                                        <input type="file" accept="application/pdf" name="pdf" id="pdf" class="input-form input-file" required>

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
                    $SQL             = "SELECT correo, fechaNacimiento, telefonoCelular, telefonoFijo, acompanantes 
                        FROM registrocongreso WHERE numSocio = $numSocio;";
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
                                    <h2>Registro al Congreso</h2>
                                </div>
                                <div class="modal-mid-container">
                                    <form class="modal-datos-mid" name="formActInf" method="POST" action="p_registro_update.php" enctype="multipart/form-data">
                                        <h4>Nota: Tus datos como tu nombre, tu número de socio, estado y ciudad ya están alamacenados,
                                        por lo tanto no te los pediremos en el llenado de este formulario.<br><br>
                                        Si estás registrado en la plataforma con dos agrupaciones o más, por favor, contesta 
                                        este formulario con solo una de ellas.</h4>
                                        <br>
                                        <p><span>*</span>Campos requeridos</p>
                                        <p><span>*</span>Correo</p>
                                        <input type="email" name="correo" class="input-form" minlength="5" maxlength="99" value="'.$correo.'" required>
                                        <p><span>*</span>Fecha de Nacimiento</p>
                                        <input type="date" name="fechaNac" class="input-form" value="'.$fechaNacimiento.'" required>
                                        <p><span>*</span>Teléfono Celular</p>
                                        <input type="text" name="telefono" class="input-form" minlength="5" maxlength="49" value="'.$telefonoCelular.'" required>
                                        <p>Teléfono Fijo</p>
                                        <input type="text" name="telefonoFijo" class="input-form" minlength="5" maxlength="49" value="'.$telefonoFijo.'">
                                        <p><span>*</span>Tipo de Habitación</p>
                                        <input type="radio" name="habitacion" class="radioBTN" value="Individual" required> Individual - $1000.00 MXN
                                        <br><br>
                                        <input type="radio" name="habitacion" class="radioBTN" value="Doble" required>  Doble - $2000.00 MXN
                                        <br><br>
                                        <input type="radio" name="habitacion" class="radioBTN" value="Triple" required>  Triple - $3000.00 MXN
                                        <br><br>
                                        <input type="radio" name="habitacion" class="radioBTN" value="Cuadruple" required>  Cuádruple - $4000.00 MXN
                                        <p><span>*</span>Acompañantes (separar cada uno de ellos con un espacio, en caso de no tener, 
                                        llena este campo con un guión "-")</p>
                                        <textarea rows="4" cols="73" name="acompanantes" class="input-area input-area-short" minlength="1" maxlength="499" required>'.$acompanantes.'</textarea>
                                        <br><br>
                                        <h4>Nota: Asegúrate de ingresar correctamente la fecha, la hora la puedes ingresar en formato de 24 hrs o 12 hrs (en ambos formatos es necesario
                                        que especifiques si es a.m. o p.m.) </h4>
                                        <p><span>*</span>Fecha de llegada</p>
                                        <input type="date" name="llegadaF" class="input-form" required>
                                        <p><span>*</span>Hora de llegada</p>
                                        <input type="time" name="llegadaH" class="input-form" required>
                                        <p><span>*</span>Fecha de salida</p>
                                        <input type="date" name="salidaF" class="input-form" required>
                                        <p><span>*</span>Hora de salida</p>
                                        <input type="time" name="salidaH" class="input-form" required>
                                        
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
                }
            ?>

            <div class="datosCIOFF">
                <p>Consejo Internacional de Organizaciones de Festivales de Folklore y de las Artes Tradicionales</p>
            </div>

        </div>

    </div>

</body>
</html>