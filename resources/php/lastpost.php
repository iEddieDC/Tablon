<?php
require_once 'resources/config/consulta.php';
require_once 'resources/cookies/cookie.php';

$cookie = new Cookie();
$extraer = new Topics(); //instanciar objeto
$numPost = new Topics();
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

            <h3><?php $cookie->Cookie_dia(); ?></h3><br>
            <h3><?php $cookie->Cookie_total(); ?></h3><br>
            <h3><?php $numPost->num_posts(); ?></h3><br>
        </div>
        <div id="UltimosPost">
            <h3>Ultimos Post</h3>
            <ul id="LastPost">
                <?php $extraer->extraer_ult(); ?>
            </ul>
        </div>
    </main>
</body>

</html>