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

  <div class="row">
    <div class="col-sm-3">
      <h4 class="text-center">Estadisticas</h4>
      <hr>
      <h5><?php $contador->VerificaUsuario(); ?></h5><br>
      <hr>
      <h5><?php $numPost->num_posts(); ?></h5><br>
      <hr>
    </div>
    <div class="col-sm-8">
      <h2>Ultimos Post</h2>
      <ul id="LastPost">
        <br>
        <?php $extraer->extraer_ult(); ?>
      </ul>
    </div>
  </div>
</body>

</html>