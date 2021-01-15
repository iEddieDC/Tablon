<!--Pagina principal-->
<?php
session_start();
/*Mensaje de sesión activa*/
if (isset($_SESSION['acceso'])) {
    #echo ($_SESSION['acceso']);
    ?>
    <div class="col-2 text-white border-danger bg-success rounded-top">
     <h7>En sesión: 
     <?php echo($_SESSION['user']);?>
     </h7>
</div>
     <?php 
} else {
    #mensaje o acciones sin sesion
}
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cualtos chan</title>
    <!--CSS Bootstrap-->
    <link rel="stylesheet" href="resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <!--Jquery & Bootsrap js-->
    <script src="resources/js/jquery-3.2.1.min.js"></script>
    <script src="resources/bootstrap-4.5.2/js/bootstrap.min.js"></script>
    <!--CSS personalizado-->
    <link rel="stylesheet" type="text/css" href="resources/style/main.css">
    <link rel="stylesheet" type="text/css" href="resources/style/Colors.css">
</head>
<body>
<header class="mb-3">
<?php include 'resources/php/header.php'; ?>
</header>
<body class="container alfondo">
    <main class=" alfrente pt-4 shadow rounded border" id="IndexMain">
        <div class="container-fluid " id="phpCategories">
            <?php include 'resources/php/categories.php'; ?>
        </div>
        <div class="container-fluid mt-4">
                <hr>
                <?php include 'resources/php/lastpost.php'; ?>
        </div>
    </main>
</body>
<footer class="mt-3">
<?php include 'resources/php/footer.php'; ?>
</footer>
</html>
</head>
