<?php
require_once 'resources/config/consulta.php';

$extraer = new Topics();//instanciar objeto

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoría</title>
</head>
<header id="phpCatHeader">
    <h2>Categorías</h2>
</header>
<body>
    <main>
    <?php $extraer -> extraer_cat();?>
    <a href="resources/php/topics.php"><h3>Todas</h3></a>
    </main>
</body>
</html>