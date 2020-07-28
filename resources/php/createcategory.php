<?php 
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
require_once '../config/consulta.php';

$create_cat = new Topics();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <link rel="stylesheet" href="../css/Main.css">
</head>
<body>
<?php include 'header.php';?>
    <?php $create_cat -> create_category(); ?>
</body>
</html>
<?php include 'footer.php';?>
<?php include 'upload.php';?>