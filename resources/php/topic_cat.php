<?php
require_once '../config/consulta.php';

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
    <?php $extraer -> topics_cat();?>
    </main>
</body>
</html>