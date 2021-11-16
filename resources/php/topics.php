<?php
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
include_once '../config/consulta.php';

$result = new Topics();

session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS bootstrap-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/bootstrap/css/bootstrap.min.css">
    <!---Javascript & Jquery-->
    <script src="<?php echo SERVERURL ?>/resources/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/js/animations.js"></script>
    <!--JS Personalizado-->
    <script src="<?php echo SERVERURL ?>/resources/js/animations.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/js/likes.js"></script>
    <!--CSS personalizados-->
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>resources/style/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>/resources/style/Colors.css">
    <!--Font awesome-->
    <script src="https://kit.fontawesome.com/1accfe0cc0.js" crossorigin="anonymous"></script>
    <title>Publicaciones</title>
</head>
<!--Header-->
<header class="mb-3 ">
    <?php include "header.php" ?>
</header>
<!--Cuerpo-->
<body class="container alfondo">
    <main class="border p-3 alfrente shadow">
        <?php $result->extraer_db(); ?>
    </main>
</body>
<!--Footer-->
<footer class="mt-3">
    <?php include "footer.php" ?>
</footer>

</html>