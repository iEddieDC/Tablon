<?php
include_once '../config/consulta.php';
include_once '../config/Uploads.php';

$article = new Topics();
$create_com = new Creates();
session_start();
error_reporting(0);
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
    <!--CSS personalizados-->
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>resources/style/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>/resources/style/Colors.css">
    <!--JS Personalizado-->
    <script src="<?php echo SERVERURL ?>/resources/js/animations.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/js/likes.js"></script>
    <!--Font awesome-->
    <script src="https://kit.fontawesome.com/1accfe0cc0.js" crossorigin="anonymous"></script>
    <!--alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title><?php echo $article->titulo_topic(); ?></title>
    <header class="mb-1">
        <?php include "header.php" ?>
    </header>
</head>

<body class="container alfondo">
    <div class="border rounded alfrente mb-2 mt-3">
        <?php $article->extraer_uno(); ?>
    </div>
    <div class="alfrente border rounded p-4 mb-2 " id="comentarios" >
        <?php 
        /*llamamos a la función para ver comentarios*/
        $article->view_coments(); 
        /*llamamos a la función para crear comentarios*/
        $create_com->create_reply();
        ?>
    </div>
</body>
<footer class="mt-3">
    <?php include "footer.php" ?>
</footer>

</html>