<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Error!</title>
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
<body class="container alfondo">
<header class="mb-3">
    <?php include "header.php" ?>
</header>
<div class="container text-center p-5 alfrente">
    <img src="<?php echo SERVERURL ?>resources/img/icons/error.png" alt="">
    <h1 class="mt-5">¡Alto!</h1>
    <h3 class="mt-2">No tienes los permisos necesarios para visualizar esta página.</h3>
    <h3>Vuelve haciendo click en el logo de cualtos-chan para ver el contenido disponible.</h3>
    <!--<div>Iconos diseñados por <a href="https://www.flaticon.es/autores/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.es/" title="Flaticon">www.flaticon.es</a></div>-->
</div>
<!--<div>Iconos diseñados por <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.es/" title="Flaticon">www.flaticon.es</a></div>-->
</body>
<!--Footer-->
<footer class="mt-3">
    <?php include "footer.php" ?>
</footer>
</html>