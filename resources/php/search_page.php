<?php
/*conexión a la base de datos*/
require_once '../config/consulta.php';
$extraer = new Topics(); //instanciar objeto 

session_start();

error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de la busqueda</title>
    <!--CSS Bootstrap-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/bootstrap/css/bootstrap.min.css">
    <!--Javascript & Jquery Bootstrap-->
    <script type="text/javascript" src="<?php echo SERVERURL ?>/resources/js/likes.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/bootstrap/js/bootstrap.min.js"></script>
    <!--JS Personalizado-->
    <script src="<?php echo SERVERURL ?>/resources/js/animations.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/js/likes.js"></script>
    <!--CSS personalizado-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/style/main.css">
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/style/Colors.css">
    <!--Font awesome-->
    <script src="https://kit.fontawesome.com/1accfe0cc0.js" crossorigin="anonymous"></script>
    
</head>
<!--Header-->
<header class="mb-3 ">
    <?php include "header.php" ?>
</header>

<!--Cuerpo-->
<body class="container alfondo">
    <main class="border p-3 alfrente shadow">
        <!--Acceder a la función de busqueda-->
        <?php $extraer->search(); ?>
    </main>
</body>

<!--Footer-->
<footer class="mt-3">
    <?php include "footer.php" ?>
</footer>

</html>