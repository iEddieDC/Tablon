<?php 
require_once '../config/superU.php';//llamamos al doc de consultas

$query = new Admin_pow;//creamos un objeto para las consultas

session_start(); //Buscamos la sesión 

//echo $_SESSION['rol'];
//Extraemos la variable 'rol' para que los demas usuarios que no sean admin no vean esta pagina
/*validacion*/
if($_SESSION['rol'] != 2){
    echo "Usted no es administrador!";
}else{?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS Bootstrap-->
    <link rel="stylesheet" href="resources/bootstrap/css/bootstrap.min.css">
    <!--Javascript & Jquery Bootstrap-->
    <script src="resources/js/jquery-3.2.1.min.js"></script>
    <script src="resources/bootstrap/js/bootstrap.min.js"></script>
    <!--CSS personalizado-->
    <link rel="stylesheet" href="resources/style/main.css">
    <link rel="stylesheet" href="resources/style/Colors.css">
</head>
<header class="mb-3">
<?php include "header_others.php"?>
</header>
<body class="container alfondo">
    <main class="border p-3 alfrente shadow">
    <h4 class="font-weight-bold mt-3 text-center">Gestionar publicaciones</h4>
        <div class="container border p-2 hilos">
            <!--Administrar hilos-->
            <?php $query ->ver_hilos();?>
        </div>
    <h4 class="font-weight-bold mt-3 text-center">Crear una categoría</h4>
        <div class="container border p-2 mt-2 ">
            <p class="text-justify p-2">En este apartado usted podra crear las categorías necesarias para el funcionamiento del tablón. Es recomendable que haga una encuesta primero o un analisis para crear la categoría necesaria.</p>
            <a class="btn btn-primary d-block mx-auto" href="create-cat">Presione aquí para crear</a>
        </div>
    </main>
</body>
<footer class="mt-3">
    <?php include "footer.php"?>
</footer>
</html>

<?php
}
?>