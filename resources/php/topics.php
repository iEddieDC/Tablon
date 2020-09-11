<?php
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
include_once '../config/consulta.php';

$result = new Topics();

session_start();

if(isset($_SESSION['acceso'])){
    #echo ($_SESSION['acceso']);
    echo "Bienvenido ", ($_SESSION['user']);
} else {
    #mensaje o acciones sin sesion
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../bootstrap-4.5.2/css/bootstrap.min.css">
    <title>Publicaciones</title>
</head>
<body>
    <!--Inluimos los php correspondientes-->
    <?php include "header.php"?>
    <?php include "upload.php"?>
    <header><h3>Publicaciones</h3></header>
    <section id="topics">
        <?php $result->extraer_db(); ?>
    </section>
    <hr>
    <?php include "footer.php"?>
</body>
</html>