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

    // obtencion de ultimo id y autoincremento
    function obtener_ultimo_id($con, $nombreTabla, $nombreID) {
        $SQL = "SELECT * FROM $nombreTabla ORDER BY $nombreID ASC;";
        $query = RunQuery($con, $SQL);
        $resutadoTodo = obtener_arreglo_assoc($query);
        $filas = mysqli_num_rows($query);
        if ($filas == 0) {
        	$id = 1;
        	return $id;
        } else {
        	$id = $resutadoTodo[$filas - 1][$nombreID];	
        }
        $id++;
        return $id;
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

?>