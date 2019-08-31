<?php
    session_start();
    // si la sesion no esta vacia, si no esta vacia y existe 'sesion' volver a miCuenta
    if (!empty($_SESSION)) {
        if ($_SESSION['sesion']) {
            header("Location:miCuenta.php");
        }        
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="static/css/estilos.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
     <link rel="icon" type="image/ico" href="static/img/Logo_CIOFF_pequeno.png"/>
    <title>CIOFF México</title>
</head>
<style>
    html { background-color: black; }
</style>
<body>

    <div class="header">
        <h4>Consejo Internacional de Organizaciones de Festivales de Folklore y de las Artes Tradicionales</h4>
    </div>

    <div class="bg-image"></div>

    <div class="cont-login">
        <img class="logoCIOFF" src="static/img/Logo_CIOFF_chico.png" alt="Logo CIOFF Mexico">

        <div class="formLogin">
            <form action="p_login.php" method="post">
                <p>Número de Socio</p>
                <input name="numSocio" class="inputs" type="text" maxlength="5" required>
                <p>Contraseña</p>
                <input name="password" class="inputs" type="password" maxlength="10" required>
                
                <div class="cont-login-bot">
                    <input type="submit" class="btn-main" value="Iniciar Sesión">
                </div>
            </form>
        </div>
    </div>

    <div class="version-text">
        <h4>Ver #1.12</h4>
    </div>

</body>
<!-- <div>Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> -->
</html>