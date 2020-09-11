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
    <link rel="stylesheet" href="resources/css/Main.css">
    <link rel="stylesheet" href="resources/bootstrap-4.5.2/css/bootstrap.min.css">
    </head>

<body>
    <header>
        <h1>CUALTOS-CHAN</h1>
    </header>

    <div class="container" id="phpHeader">
    <?php include 'resources/php/header.php';?>
    </div>
    
    <main class="container" id="IndexMain">

        <div class="container" id="phpCategories">  
        <?php include 'resources/php/categories.php';?>
        
        </div>
        <div class="container" id="phpLastPost">
        <?php include 'resources/php/lastpost.php';?>
        </div>
    </main>
    <div  class="container" id="phpFooter">
    <?php include 'resources/php/footer.php';?>
    </div>
</body>
    
</html>
