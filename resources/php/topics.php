<?php
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
include_once '../config/consulta.php';

$result = new Topics();

session_start();
/*Mensaje de sesión activa*/
if (isset($_SESSION['acceso'])) {
    #echo ($_SESSION['acceso']);
    ?>
    <div class="col-2 text-white border-danger bg-success rounded-top">
     <h7>En sesión: 
     <?php echo($_SESSION['user']);?>
     </h7>
</div>
     <?php 
} else {
    #mensaje o acciones sin sesion
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <!--CSS personalizados-->
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>resources/style/main.css">
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/style/Colors.css">
    <title>Publicaciones</title>
    </head>
<header class="mb-3">
<?php include "header_others.php"?>
</header>
<body class="container alfondo">
    <main class="border p-3 alfrente shadow">
    <?php $result -> extraer_db();?>
    </main>
</body>
<footer class="mt-3">
<?php include "footer.php"?>
</footer>
</html>