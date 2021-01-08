<?php

session_start();

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
<body background="resources/img/icons/FORMAS.jpg">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cualtos chan</title>
    <link rel="stylesheet" href="resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="resources/bootstrap-4.5.2/js/bootstrap.min.js"></script>
    <!--<link rel="stylesheet" href="resources/css/Main.css">-->
</head>
<body>
<header class="mb-1">
<?php include 'resources/php/header.php'; ?>
</header>
<body class="container-fluid p-3">
    <main class=" bg-white pt-4" id="IndexMain">
        <div class="container-fluid" id="phpCategories">
            <?php include 'resources/php/categories.php'; ?>
        </div>
        <div class="container-fluid mt-4">
                <?php include 'resources/php/lastpost.php'; ?>
        </div>
    </main>
</body>
<footer class="pb-1">
<?php include 'resources/php/footer.php'; ?>
</footer>
</html>
