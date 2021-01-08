<?php
require_once '../config/consulta.php';

$extraer = new Topics();//instanciar objeto

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo SERVERURL ?>resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="<?php echo SERVERURL ?>resources/bootstrap-4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="container-fluid p-3">
    <main>
    <?php include "header.php"?>
    <?php include "upload.php"?>
    <?php $extraer -> topics_cat();?>
    </main>
</body>
</html>