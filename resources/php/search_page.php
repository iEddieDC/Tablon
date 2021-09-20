<?php
/*conexión a la base de datos*/
require_once '../config/consulta.php';
$extraer = new Topics(); //instanciar objeto 
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="<?php echo SERVERURL ?>resources/bootstrap/css/bootstrap.css">
<!--Header-->
<header class="mb-3 ">
    <?php include "header_others.php" ?>
</header>

<!--Cuerpo-->
<body class="container alfondo">
    <main class="border p-3 alfrente shadow">
        <!--Acceder a la función de busqueda-->
        <?php $extraer->search(); ?>
    </main>
</body>

<!--Footer-->
<footer class="mt-3">
    <?php include "footer.php" ?>
</footer>

</html>