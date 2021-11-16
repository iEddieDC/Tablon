<?php
include_once '../config/consulta.php';
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas frecuentes</title>
    <!--CSS bootstrap-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/bootstrap/css/bootstrap.min.css">
    <!---Javascript & Jquery-->
    <script src="<?php echo SERVERURL ?>resources/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo SERVERURL ?>resources/bootstrap/js/bootstrap.min.js"></script>
    <!--CSS personalizados-->
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>/resources/style/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>/resources/style/Colors.css">
    <!--JS Personalizado-->
    <script src="<?php echo SERVERURL ?>resources/js/animations.js"></script>
    <script src="<?php echo SERVERURL ?>resources/js/likes.js"></script>
    <!--Font awesome-->
    <script src="https://kit.fontawesome.com/1accfe0cc0.js" crossorigin="anonymous"></script>
</head>
<!--Header-->
<header class="mb-3">
    <?php include 'header.php'; ?>
</header>
<!--Cuerpo-->

<body class="container alfondo">
    <main class=" alfrente pt-4 shadow rounded border" id="IndexMain">
        <hr>
        <h2 class="text-center m-4">Preguntas frecuentes</h2>
        <hr>
        <ul class="list-group m-5 p-3 registros">
            <li class="list-group-item">
                <h3 class="m-2 text-center">¿Por qué se creó CUALTOS-CHAN?</h3>
                <hr>
                <p class="m-3">Cualtos-chan nace ante la necesidad de tener una plataforma dedicada a los alumnos universitarios. Un sitio donde alumnos, docentes y aspirantes pueden interactuar y conseguir información sobre el Centro Universitario de los Altos.</p>
            </li>
            <li class="list-group-item">
                <h3 class="m-2 text-center">¿Es necesario registrarse para publicar en CUALTOS-CHAN?</h3>
                <p class="m-3">La respuesta simple es <text class="text-danger">NO</text>.</p>
                <p class="m-3">Cualtos-chan es un tablón de imágenes anónimo, esto significa que puedes realizar publicaciones y/o comentarios en cualquier tablón sin la necesidad de tener una cuenta.</p>
                <p class="m-3">Solo los usuarios que lo deseen pueden registrarse y publicar con un nombre de usuario, además de que recibirán notificaciones al correo registrado. </p>
                <p class="alert alert-danger">OJO, recuerda que este es un sitio web escolar, cualquier infracción y comportamiento no ético será consignado a las autoridades correspondientes.</p>
            </li>
            <li class="list-group-item">
                <h3 class="m-2 text-center">¿Cómo funciona?</h3>
                <hr>
                <p class="m-3">Cualtos-chan se nutre gracias a la interacción de los propios usuarios, es tan simple como crear una consulta y esperar a que los usuarios la respondan, a continuación se listas algunos ejemplos.</p>
                <p class="m-3 font-weight-bold">Para visualizar los temas/hilos.</p>
                <p class="m-3">En la página principal, desplázate al apartado “Tablones” y selecciona algún tablón que sea de tu interés, además al final de todos los tablones siempre encontraras el tablón “General”, este mezcla todos los hilos creados sin importar el tablón/categoría al que pertenezcan. </p>
                <p class="m-3 font-weight-bold">Para crear una publicación.</p>
                <p class="m-3">Simplemente dirígete a la parte superior del sitio donde se encuentra el botón
                    <button type="button" class="btn btn-all text-white">
                        <i class="mr-1 far fa-file"></i>
                        Crear
                    </button>, luego de eso te aparecerá un formulario, simplemente rellena los datos que se te piden con relación al tema que quieres comenzar.
                </p>
                <p class="m-3 font-weight-bold">Para realizar un comentario.</p>
                <p class="m-3">Selecciona el hilo de tu interés, simplemente desplázate al lado inferior de la pantalla y escribe en el siguiente apartado:</p>
                <div class="text-center"><img src="<?php echo SERVERURL ?>/resources/img/icons/comentar.png" alt=""></div>
                <p class="m-3">Luego simplemente añade una imagen si lo deseas y haz click en comentar.</p>
                <p class="m-3 font-weight-bold">Registrarse</p>
                <p class="m-3">Dirígete a la parte superior del sitio y ubica el botón
                    <a class="btn btn btn-all text-white">
                        <i class="mr-1 fas fa-user-plus"></i>
                        Registrarse
                    </a>
                </p>
                <p class="m-3">Completa el formulario.</p>
                <p class="m-3 font-weight-bold">Iniciar sesión</p>
                <p class="m-3">Ubica en la parte superior del sitio el botón
                    <a class="btn btn-outline-secondary action-button text-dark">
                        <i class="mr-1 fas fa-sign-in-alt"></i>
                        Iniciar sesión
                    </a>
                </p>
                <p class="m-3">Ingresa tus datos y da click en iniciar sesión.</p>
            </li>
            <li class="list-group-item">
                <h3 class="m-2 text-center">¿Es seguro utilizar CUALTOS-CHAN?</h3>
                <p class="m-2">El sitio es completamente seguro, cuenta con el respaldo de ser un proyecto de la Universidad de Guadalajara además de los certificados correspondientes.</p>
                <p class="alert alert-danger">NOTA: Queda a responsabilidad del propio usuario la publicación de datos personales de manera publica, así como el contenido que publique y/o consulte.</p>
            </li>
        </ul>
    </main>
</body>
<!--Footer-->
<footer class="mt-3">
    <?php include 'footer.php'; ?>
</footer>

</html>