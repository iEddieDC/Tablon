<?php
include_once '../config/consulta.php';

$article = new Topics();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hilo</title>
    <link rel="stylesheet" href="../css/Main.css">
</head>
    <body>
        <?php $article->extraer_uno(); ?>
        <a href="topics.php"> <div id="boton">Regresar</div></a>    
    </body>
</html>