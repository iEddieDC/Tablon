<?php
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
include_once '../config/consulta.php';

$create_topic = new Topics();

session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Crear hilo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS bootstrap-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/bootstrap/css/bootstrap.min.css">
    <!---Javascript & Jquery-->
    <script src="<?php echo SERVERURL ?>/resources/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/bootstrap/js/bootstrap.min.js"></script>
    <!--alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!--CSS personalizados-->
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>resources/style/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>/resources/style/Colors.css">
</head>
<header class="mb-3">
    <?php include "header_others.php" ?>
</header>
<body class="container alfondo">
    <main class="rounded shadow">
        <?php $create_topic->create_topic(); ?>
    </main>
</body>
<footer class="mt-3">
    <?php include 'footer.php'; ?>
</footer>

</html>