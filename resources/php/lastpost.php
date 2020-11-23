<?php
require_once 'resources/config/consulta.php';
include 'resources/config/estadisticas.php';

$contador = new ClassVisitas();
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
        <div class="row">
            <div class="col-3" id="Estadisticas" >
                <h4>Estadisticas</h4>
                <hr class="my-4">
                <h5><?php $contador->VerificaUsuario(); ?></h5><br>
                <hr class="my-2">
                <h5><?php $numPost->num_posts(); ?></h5><br>
                <hr class="my-1">
            </div>
            <div class="col" id="UltimosPost">
                <h2>Ultimos Post</h2> 
                <ul id="LastPost">
                    <br>
                    <?php $extraer->extraer_ult(); ?>
                </ul>
            </div>
        </div>
    </main>
</body>

</html>