<?php
include_once '../config/consulta.php';

$article = new Topics();
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS bootstrap-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <!--CSS personalizado-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>resources/style/Colors.css">
    <title>Hilo</title>
    <header class="mb-1">
        <?php include "header_others.php" ?>
    </header>
</head>

<body class="container alfondo">
    <main class="border rounded mt-3 mb-3  p-3 alfrente">
        <?php $article->extraer_uno(); ?>
        <?php $article->create_reply(); ?>
        <?php include "view_coments.php" ?>
    </main>
</body>
<?php include "footer.php" ?>
</html>