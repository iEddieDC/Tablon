<?php
/*conexión a la base de datos*/
require_once '../config/consulta.php';
$extraer = new Topics(); //instanciar objeto 
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="<?php echo SERVERURL ?>resources/bootstrap/css/bootstrap.css">
<header class="mb-3">
    <?php include 'header.php'; ?>
</header>

<body class="container alfondo">
    <!--Acceder a la función de busqueda-->
    <?php $extraer->search(); ?>
        <footer class="mt-3">
            <?php include 'footer.php'; ?>
        </footer>
</body>

</html>