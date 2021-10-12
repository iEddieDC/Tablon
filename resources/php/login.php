<?php
require_once '../config/consulta.php';
include_once '../config/connect/functions.php';

session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS bootstrap-->
    <link rel="stylesheet" href="resources/bootstrap/css/bootstrap.min.css">
    <!---Javascript & Jquery-->
    <script src="resources/js/jquery-3.2.1.min.js"></script>
    <script src="resources/bootstrap/js/bootstrap.min.js"></script>
    <!--JS Personalizado-->
    <script src="<?php echo SERVERURL ?>/resources/js/animations.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/js/likes.js"></script>
    <!--CSS personalizados-->
    <link rel="stylesheet" type="text/css" href="resources/style/Colors.css">
    <link rel="stylesheet" type="text/css" href="resources/style/main.css">
    <!--Font awesome-->
    <script src="https://kit.fontawesome.com/1accfe0cc0.js" crossorigin="anonymous"></script>
    <title>Login</title>
    
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<header class="mb-3">
<?php include 'header.php';?>
</header>
<body class="container alfondo">
    <main class="rounded shadow">
    <!--Formulario para registrar una categoría nueva-->
    <div class="registros container-contact100">
        <div class="wrap-contact100">
            <span class="contact100-form-symbol">
                <img src="resources/img/icons/user.png" alt="SYMBOL-MAIL">
            </span>
            <!--Mediante action se lo enviamos a si mismo-->
            <form class="contact100-form flex-sb flex-w" action="comprobarlogin" method="post" enctype="multipart/form-data">

                <span class="contact100-form-title">
                    Login
                </span>

                <label class=" col-sm-2 col-form-label">Usuario</label>
                <div class="wrap-input100  validate-input">
                    <input  class="input100 form-control" type="text" name="username" placeholder="Nombre de usuario" required>
                    <span class="focus-input100"></span>
                </div>

                <label>Contraseña</label>
                <div class="wrap-input100 validate-input">
                    <input class="input100 form-control" type="password" name="password" placeholder="Contraseña" required>
                    <span class="focus-input100"></span>
                </div>

                <input type="submit" value="Iniciar Sesión" button type="button" class="btn btn-reg  btn-lg btn-block">
            </form>
        </div>
    </div>
    </main>
</body>
<footer class="mt-3"><?php include 'footer.php';?></footer>
</html>
