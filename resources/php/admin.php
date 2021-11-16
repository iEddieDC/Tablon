<?php
require_once '../config/superU.php'; //llamamos al doc de consultas

$query = new Admin_pow; //creamos un objeto para las consultas

session_start(); //Buscamos la sesión 
error_reporting(0);

//Extraemos la variable 'rol' para que los demas usuarios que no sean admin no vean esta pagina
/*validacion*/
if ($_SESSION['rol'] != 2) {
    include "adm_error.php";
} else { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pestaña de administrador</title>
        <!--CSS Bootstrap-->
        <link rel="stylesheet" href="resources/bootstrap/css/bootstrap.min.css">
        <!--Javascript & Jquery Bootstrap-->
        <script src="resources/js/jquery-3.2.1.min.js"></script>
        <script src="resources/bootstrap/js/bootstrap.min.js"></script>
        <!--JS Personalizado-->
        <script src="<?php echo SERVERURL ?>/resources/js/animations.js"></script>
        <script src="<?php echo SERVERURL ?>/resources/js/likes.js"></script>
        <!--CSS personalizado-->
        <link rel="stylesheet" href="resources/style/main.css">
        <link rel="stylesheet" href="resources/style/Colors.css">
        <!--Font awesome-->
        <script src="https://kit.fontawesome.com/1accfe0cc0.js" crossorigin="anonymous"></script>
        <!--alertas-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </head>
    <header class="mb-3">
        <?php include "header.php" ?>
    </header>

    <body class="container alfondo">
        <main class="border p-3 alfrente shadow">
            <h4 class="font-weight-bold m-5 text-center">Tablones o categorías</h4>
            <div class="container border p-4 mt-2 ">
                <p class="text-justify mb-4">En este apartado usted podra crear las categorías necesarias para el funcionamiento del tablón. Es recomendable que haga una encuesta primero o un analisis para crear la categoría necesaria.</p>
                <?php $query->ver_cat(); ?>
            </div>
            <h4 class="font-weight-bold m-5 text-center">Gestionar publicaciones</h4>
            <div class="container border p-4 hilos">
                <!--Administrar hilos-->
                <?php $query->ver_hilos(); ?>
            </div>
            <h4 class="font-weight-bold m-5 text-center">Gestión usuarios</h4>
            <div class="container border p-4 mt-2 ">
                <p class="text-justify mb-4">En este apartado usted podra ascender usuarios a administradores o borrarlos.</p>
                <p class="text-justify mb-4">Recuerde Nivel de usuario 0 para usuarios normales <br>
                    Nivel de usuario 2 para administradores</p>
                <!--Administrar hilos-->
                <?php $query->ascend(); ?>
            </div>
        </main>
    </body>
    <footer class="mt-3">
        <?php include "footer.php" ?>
    </footer>

    </html>

<?php
}
?>