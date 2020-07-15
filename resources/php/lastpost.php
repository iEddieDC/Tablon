<?php
require_once 'resources/config/consulta.php';

$extraer = new Topics();//instanciar objeto

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Últimos post</title>
</head>
<body>
    <main>
    <div id="Estadisticas">
        <h3>ONLINE</h3><br>
        <h3>HOY</h3><br>
        <h3>POSTS</h3><br>
    </div>
    <div id="UltimosPost">
        <h3>Ultimos Post</h3>
    <ul id="LastPost">
        <?php $extraer -> extraer_ult();?>
    </ul>
    </div>
    </main>
</body>
</html>