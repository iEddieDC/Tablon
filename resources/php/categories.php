<?php
require_once 'resources/config/consulta.php';

$extraer = new Topics();//instanciar objeto

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo SERVERURL ?>resources/bootstrap/css/bootstrap.css">
    <title>Categoría</title>
</head>
</div>
<body>
    <main>
    <?php $extraer -> extraer_cat();?>
    </main>
</body>
</html>