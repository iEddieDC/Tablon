<?php
require_once '../config/consulta.php';

$extraer = new Topics();//instanciar objeto

session_start();

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
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS Bootstrap-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <!--Javascript & Jquery Bootstrap-->
    <script src="<?php echo SERVERURL ?>/resources/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/bootstrap-4.5.2/js/bootstrap.min.js"></script>
    <!--CSS personalizado-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/style/main.css">
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/style/Colors.css">
</head>
<header class="mb-3">
<?php include "header_others.php"?>
</header>
<body class="container alfondo">
    <main class="border p-3 alfrente shadow">
    <?php $extraer -> topics_cat();?>
    </main>
</body>
<footer class="mt-3">
    <?php include "footer.php"?>
</footer>
</html>