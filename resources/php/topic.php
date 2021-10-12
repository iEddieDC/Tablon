<?php
include_once '../config/consulta.php';

$article = new Topics();
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
    <title>Hilo</title>
    <header class="mb-1">
        <?php include "header.php" ?>
    </header>
</head>

<body class="container alfondo">
    <div class="border rounded alfrente mb-2 mt-3">
        <?php $article->extraer_uno(); ?>
    </div>
    <div class="alfrente border rounded p-4 mb-2">
        <?php $article->view_coments(); ?>
        <?php $article->create_reply(); ?>
    </div>
</body>
<?php include "footer.php" ?>
</html>