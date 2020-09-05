<?php
include_once '../config/consulta.php';

$article = new Topics();
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
    <title>Hilo</title>
    <link rel="stylesheet" href="../css/Main.css">
    <?php $article->create_reply();?>
</head>
    <body>
        <?php $article->extraer_uno(); ?>
        
        <a href="topics.php"> <div id="boton">Regresar</div></a>    
    </body>
</html>