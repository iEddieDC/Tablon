<?php
require_once '../config/user_config.php'; //llamamos al doc de consultas

$query = new user_pow; //creamos un objeto para las consultas

session_start(); //Buscamos la sesión 
error_reporting(0);

//Extraemos la variable 'rol' para que los demas usuarios que no sean admin no vean esta pagina
/*validacion*/
if ($_SESSION['rol'] != 0) {
    include "adm_error.php";
} else { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página de usuario</title>
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
        <main class=" alfrente p-3 shadow rounded border">
            <h4 class="font-weight-bold m-5 text-center">Mis publicaciones</h4>
            <div class="container border p-4 mt-2 ">
                <p class="text-justify mb-4">En este apartado usted puede visualizar y gestionar todas las publicaciones que ha realizado.</p>
                <?php $query->mis_hilos(); ?>
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