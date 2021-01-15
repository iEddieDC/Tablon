<?php
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
require_once '../config/consulta.php';

$create_cat = new Topics();

session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <!--CSS bootstrap-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <!---Javascript & Jquery-->
    <script src="<?php echo SERVERURL ?>/resources/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/bootstrap-4.5.2/js/bootstrap.min.js"></script>
    <!--CSS personalizados-->
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>resources/style/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>/resources/style/Colors.css">
</head>
<header class="mb-3">
<?php include 'header.php';?>
</header>
<body class="container alfondo">
    <!--Formulario para registrar una categoría nueva-->
    <div class="container-contact100 shadow">
        <div class="wrap-contact100">
            <span class="contact100-form-symbol">
                <img src="resources/img/icons/stack.png" alt="SYMBOL-MAIL">
            </span>
            <!--Mediante action se lo enviamos a si mismo-->
            <form class="contact100-form flex-sb flex-w" action="create-cat" method="post" enctype="multipart/form-data">

                <span class="contact100-form-title">
                    Registrar una categoría
                </span>

                
                <div class="wrap-input100  validate-input">
                    <input class="input100 form-control" type="text" name="title" id="title" placeholder="Título de la categoría" required>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <textarea class="input100 form-control" name="subject" id="post" rows="8" cols="20" maxlength="63" placeholder="Escribe aquí la descripción de la categoría" required></textarea>
                    <span class="focus-input100"></span>
                </div>

                <input type="submit" name="enviar" value="Crear" button type="button" class="btn btn-primary btn-lg btn-block">
                <input type="reset" value="Limpiar campos" button type="button" class="btn btn-secondary btn-lg btn-block">
            </form>
        </div>
    </div>

    <?php $create_cat->create_category(); ?>
</body>
<footer class="mt-3">
<?php include 'footer.php'; ?>
</footer>
</html>
