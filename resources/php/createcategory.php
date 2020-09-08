<?php
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
require_once '../config/consulta.php';

$create_cat = new Topics();

session_start();

if (isset($_SESSION['acceso'])) {
    #echo ($_SESSION['acceso']);
    echo "Bienvenido ", ($_SESSION['user']);
} else {
    #mensaje o acciones sin sesion
}
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
    <?php include 'header.php'; ?>
    <?php $create_cat->create_category(); ?>
</body>
</html>
<?php include 'footer.php'; ?>
