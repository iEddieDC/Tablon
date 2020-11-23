<?php
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
include_once '../config/consulta.php';

$create_topic = new Topics();

if(isset($_SESSION['acceso'])){
    #echo ($_SESSION['acceso']);
    echo "rol numero =", ($_SESSION['rol']);
   echo "ID de user: ", ($_SESSION['id']);
} else {
    #mensaje o acciones sin sesion
    #echo"No hay usuario logueado";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear hilo</title>
    <link rel="stylesheet" href="../css/Main.css">
    <link rel="stylesheet" href="../bootstrap-4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div id="formulario">
    <?php $create_topic -> create_topic(); ?>
    </div>
</body>
</html>

