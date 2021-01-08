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
    <!--<link rel="stylesheet" href="<?php echo SERVERURL ?>resources/css/main.css">-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <title>Publicaciones</title>
</head>
<body class="container-fluid p-3">
    <!--Incluimos los php correspondientes-->
    <?php include "header.php"?>
    <?php include "upload.php"?>
    <h3>Publicaciones</h3>
    <section id="topics">
        <?php $result->extraer_db(); ?>
    </section>
    <?php include "footer.php"?>
</body>
</html>