<!--Pagina principal-->
<?php
session_start();
/*Mensaje de sesión activa*/

error_reporting(0);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cualtos chan</title>
    <!--CSS Bootstrap-->
    <link rel="stylesheet" href="resources/bootstrap/css/bootstrap.css">
    <!--Font awesome-->
    <script src="https://kit.fontawesome.com/1accfe0cc0.js" crossorigin="anonymous"></script>
    <!--Jquery & Bootsrap js-->
    <script src="resources/js/jquery-3.2.1.min.js"></script>
    <script src="resources/bootstrap/js/bootstrap.min.js"></script>
    <!--CSS personalizado-->
    <link rel="stylesheet" href="resources/style/main.css">
    <link rel="stylesheet" href="resources/style/Colors.css">
</head>
<!--Header-->

    <header class="mb-3"><!--stickytop **Falla con el modal ¿?**-->
        <?php include 'resources/php/header.php';?>
    </header>
    
<!--Cuerpo-->
    <body class="container alfondo">
        <main class=" alfrente pt-4 shadow rounded border" id="IndexMain">
            <div class="container-fluid" id="phpCategories">
                <?php include 'resources/php/categories.php'; ?>
            </div>
            <div class="container-fluid mt-4">
                <hr>
                <?php include 'resources/php/lastpost.php'; ?>
            </div>
        </main>
    </body>
<!--Footer-->
    <footer class="mt-3">
        <?php include 'resources/php/footer.php'; ?>
    </footer>
      
    
