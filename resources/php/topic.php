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
    <link rel="stylesheet" href="<?php echo SERVERURL ?>resources/css/main.css">
    <link rel="stylesheet" href="<?php echo SERVERURL ?>resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <title>Hilo</title>
    
    <?php $article->create_reply();?>
</head>
    <body>
        <?php $article->extraer_uno(); ?>
        <?php $article-> view_coments();?>
        
    </body>
</html>