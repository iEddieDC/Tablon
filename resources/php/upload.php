<?php 
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
require_once '../config/consulta.php';

$create_topic = new Topics();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear hilo</title>
</head>
<body>
    <div id="formulario">
    <?php $create_topic -> create_topic(); ?>
    </div>
</body>
</html>
