<?php
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
include_once '../config/consulta.php';

$result = new Topics();

session_start();

if(isset($_SESSION['acceso'])){
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
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../bootstrap-4.5.2/css/bootstrap.min.css">
    <title>Publicaciones</title>
</head>
<body>
    <!--Inluimos los php correspondientes-->
    <div class="container-fluid navbar-inverse bg-primary">
        <nav class="navbar navbar-dark navbar-expand-md text-white bg-primary navigation-clean-search">
            <div class="container-fluid"><a class="navbar-brand" href="#"><h1>Cualtos Chan</h1></a>
                <button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav">
                        <li><a class="nav-link text-white" href="resources/php/upload.php">Crear un hilo</a></li>
                    </ul>
                    <form class="form-inline mr-auto" target="_self">
                        <div class="form-group"><label for="search-field"></label></div>
                    </form>
                </div>
            </div>
        </nav>
    </div>
    <?php include "upload.php"?>
    <header><h3>Publicaciones</h3></header>
    <section id="topics">
        <?php $result->extraer_db(); ?>
    </section>
    <hr>
    <?php include "footer.php"?>
</body>
</html>