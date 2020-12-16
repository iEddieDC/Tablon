<?php

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
    <title>Cualtos chan</title>
    <link rel="stylesheet" href="resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="resources/bootstrap-4.5.2/js/bootstrap.min.js"></script>
    
    <!--<link rel="stylesheet" href="resources/css/Main.css">-->
</head>
<?php include 'resources/php/header.php'; ?>
<body>
    <main class="container-fluid" id="IndexMain">
        <div class="container-fluid" id="phpCategories">
            <?php include 'resources/php/categories.php'; ?>
        </div>
        <div class="container-fluid">
                <?php include 'resources/php/lastpost.php'; ?>
        </div>
    </main>
    <?php include 'resources/php/footer.php'; ?>
</body>

</html>
