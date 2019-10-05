<?php 
    // ---------------------------------------------------------------------------------
    // ============================= FUNCIONES DE CONEXION =============================
    // ---------------------------------------------------------------------------------
    function Connect() { 
		$Params     = parse_ini_file("config.ini");
		$ServerName = $Params["Server"];
		$User       = $Params["UserName"];
		$Password   = $Params["Password"];
		$Bd         = $Params["DataBase"];
		$Connection = mysqli_connect($ServerName, $User, $Password, $Bd);
		return $Connection;
	}

	function RunQuery($Connection, $SQL) {
		$query = mysqli_query($Connection, $SQL);
		return $query;
	}

	function Disconnect($Connection) {
		mysqli_close($Connection);
    }
    
    // ---------------------------------------------------------------------------------
    // ====================== FUNCIONES DE PROCESAMIENTO DE DATOS ======================
    // ---------------------------------------------------------------------------------
    function obtener_arreglo_assoc($consulta) {
        $i = 0;
        $filas = array();
        while ($fila = mysqli_fetch_assoc($consulta)) { 
            foreach ($fila AS $key => $value) {
                $filas[$i][$key] = $fila[$key];
            }
            $i++;
        }
        return $filas;
    }

    function genText() {
        $randomStr = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited
        
        for ($i=0; $i < 5; $i++) {
            $randomStr .= $codeAlphabet[random_int(0, $max-1)];
        }
        return $randomStr;
    }

    function obtener_ip() {
        $ip = "";
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } else if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if(isset($_SERVER["HTTP_X_FORWARDED"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED"];
        } else if(isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_FORWARDED_FOR"];
        } else if(isset($_SERVER["HTTP_FORWARDED"])) {
            $ip = $_SERVER["HTTP_FORWARDED"];
        } else if(isset($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
        } else {
            $ip = "DESCONOCIDA";
        }
        return $ip;
    }

    function calcularMonto($mesNum, $habitacionStr) {
        $monto = 0;
        $diaNow = date("d");
        switch ($mesNum) {
            case 6:
                if ($habitacionStr == "Individual") {
                    $monto = 5998.00;
                } elseif ($habitacionStr == "Doble") {
                    $monto = 4544.50;
                } elseif ($habitacionStr == "Triple") {
                    $monto = 4054.00;
                } elseif ($habitacionStr == "Cuadruple") {
                    $monto = 3808.75;
                } else {
                    $monto = 1.00;
                }
                break;

            case 7:
                if ($habitacionStr == "Individual") {
                    $monto = 6297.90;
                } elseif ($habitacionStr == "Doble") {
                    $monto = 4771.73;
                } elseif ($habitacionStr == "Triple") {
                    $monto = 4256.70;
                } elseif ($habitacionStr == "Cuadruple") {
                    $monto = 3999.19;
                } else {
                    $monto = 1.00;
                }
                break;

            case 8:
                if ($habitacionStr == "Individual") {
                    $monto = 6597.80;
                } elseif ($habitacionStr == "Doble") {
                    $monto = 4998.95;
                } elseif ($habitacionStr == "Triple") {
                    $monto = 4459.40;
                } elseif ($habitacionStr == "Cuadruple") {
                    $monto = 4189.63;
                } else {
                    $monto = 1.00;
                }
                break;

            case 9:
                if ($habitacionStr == "Individual") {
                    $monto = 6897.70;
                } elseif ($habitacionStr == "Doble") {
                    $monto = 5226.18;
                } elseif ($habitacionStr == "Triple") {
                    $monto = 4662.10;
                } elseif ($habitacionStr == "Cuadruple") {
                    $monto = 4380.06;
                } else {
                    $monto = 1.00;
                }
                break;

            case 10:
                if ($habitacionStr == "Individual") {
                    $monto = 7197.60;
                } elseif ($habitacionStr == "Doble") {
                    $monto = 5453.40;
                } elseif ($habitacionStr == "Triple") {
                    $monto = 4864.80;
                } elseif ($habitacionStr == "Cuadruple") {
                    $monto = 4570.50;
                } else {
                    $monto = 1.00;
                }
                break;

            case 11:
                if ($diaNow <= 20) {
                    if ($habitacionStr == "Individual") {
                        $monto = 7497.50;
                    } elseif ($habitacionStr == "Doble") {
                        $monto = 5680.63;
                    } elseif ($habitacionStr == "Triple") {
                        $monto = 5067.50;
                    } elseif ($habitacionStr == "Cuadruple") {
                        $monto = 4760.94;
                    } else {
                        $monto = 1.00;
                    }
                } else {
                    if ($habitacionStr == "Individual") {
                        $monto = 7797.40;
                    } elseif ($habitacionStr == "Doble") {
                        $monto = 5907.85;
                    } elseif ($habitacionStr == "Triple") {
                        $monto = 5270.20;
                    } elseif ($habitacionStr == "Cuadruple") {
                        $monto = 4951.38;
                    } else {
                        $monto = 1.00;
                    }
                }
                break;
            
            default:
                // error
                $monto = 1.00;
                break;
        }
        return $monto;
    }

    function printHTML($con, $idUser) {
        mysqli_query($con, "SET NAMES 'utf8'");
        $SQL       = "SELECT nombreDir FROM grupo WHERE idUsuario = $idUser;";
        $resultado = mysqli_query($con, $SQL);
        $arr_assoc = mysqli_fetch_assoc($resultado);
        $nombreDir = $arr_assoc["nombreDir"];
        echo '
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
                                            <input type="button" class="btn-main" onclick="window.location.href = \'p_logout.php\';" value="Aceptar">
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
                                <p>'.$nombreDir.'</p>
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
                                        <br>
                                        <img class="align-img" src="static/img/success.png" alt="Registro completado."><br><br>
                                        <h2 class="align-center">¡Listo! Estás registrado</h2><br>
                                        <div class="modal-datos-mid-bottom margin-final">
                                            <!--<input type="button" class="btn-main" onclick="window.location.href = \'registro.php\';" value="Volver">-->
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
        ';
    }

?>
