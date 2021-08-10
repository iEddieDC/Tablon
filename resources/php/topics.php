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
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <!--CSS personalizados-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/style/main.css">
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/style/Colors.css">
    <title>Publicaciones</title>
</head>
<!--Header-->
<header class="mb-3 ">
    <?php include "header_others.php" ?>
</header>
<!--Cuerpo-->
<body class="container alfondo">
    <main class="border p-3 alfrente shadow">
        <?php $result->extraer_db(); ?>
    </main>
</body>
<!--Footer-->
<footer class="mt-3">
    <?php include "footer.php" ?>
</footer>

</html>