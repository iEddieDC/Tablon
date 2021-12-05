<!--Este header es para el index-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="resources/style/colors.css">
</head>
<link rel="icon" type="image/png" href="resources/img/icons/favicon.png" />

<body>
    <main>
        <!--Navbar-->
        <div class="UDG border-bottom-0 border-top-0 navbar navbar-expand-lg justify-content-between">
            <a class="navbar-brand" href="<?php echo SERVERURL ?>index.php">
                <!--<img alt="Enlace al sitio de la Universidad de Guadalajara" src="resources/img/icons/udg-leon-vector-logo3.png" style="width: 50px; height: 50px;">-->
                <div class="container-fluid">
                <img class="mr-2" alt="Cualtoschan" src="<?php echo SERVERURL ?>resources/img/icons/logo-leon-img.png" style="width: 70px; height: 70px;">
                    <img class="" alt="Cualtoschan" src="<?php echo SERVERURL ?>resources/img/icons/logo-v1.0.png" style="width: 255px; height: 60px;">
                     <!--<h1 class="font-weight-bold text-white">CuAltos-chan</h1>-->
                </div>
            </a>
            <!--Mostrar nombre de usuario-->
            <?php
            if (isset($_SESSION['acceso'])) {
                #echo ($_SESSION['acceso']);
            ?>
                <div class="col-2 text-white border-danger bg-success rounded">
                    <h7>En sesión:
                        <?php echo ($_SESSION['user']); ?>
                    </h7>
                </div>
            <?php
            } else {
                #mensaje o acciones sin sesion
            } ?>
            <!--Botón modo oscuro-->
            <button type="button" class="btn btn-dark rounded-pill ml-4 mr-4" id="Darkmode"><i id="DarkBtn" class="fas fa-moon"></i></button>
            <?php ?>
        </div>
        <!--Navbar sticky-->
        <nav class="navbar navbar-expand-lg border-top-0 border rounded-bottom shadow-sm">
            <button id="NavMenu" class="navbar-toggler btn-all p-3 mr-2 ml-auto" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <i id="Menu" class="fas fa-bars"></i>
            </button>


            <div class="collapse navbar-collapse" id="navbarText" style="transition: ease-out 0.3s;">
                <!-- Modal -->
                <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">Lee las reglas atentamente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </button>
                            </div>
                            <div class="modal-body ">
                                <h2>El tablón de imagenes es una comunidad.</h2>
                                <p>Para mantener el orden se han creado las siguientes reglas:
                                <p>
                                <ul>
                                    <li>1.- No se aceptan insultos. Trata a las demás personas con respeto, recuerda que en su mayoría son alumnos.</li>
                                    <li>2.- El spam no es bienvenido. Hacer spam es publicar cualquier tema de manera masiva, ya sea una página web, canal de youtube, publicaciones de otras redes sociales, etc.</li>
                                    <li>3.- No republiques posts viejos. Los post que ya han sido resueltos y fueron publicados hace un tiempo deben mantenerse así.</li>
                                    <li>4.- Evita ser troll. Está comunidad se mantiene gracias a que los usuarios se ayudan entre sí.</li>
                                </ul>
                                <p class="text-danger">NO ROMPAS LAS REGLAS, DE LO CONTRARIO TUS COMENTARIOS O POST SERÁN BORRADOS.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Entendido</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Botones-->
                <ul class="navbar-nav m-2">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <!--Home-->
                        <button type="button" class="btn btn-all text-white" onclick="window.location.href='<?php echo SERVERURL ?>index.php'">
                            <i class="mr-1 fa fa-home"></i>
                            
                        </button>
                        <!--botón Crear hilo-->
                        <button type="button" class="btn btn-all text-white" onclick="window.location.href='<?php echo SERVERURL ?>upload'">
                            <i class="mr-1 far fa-file"></i>
                            Crear
                        </button>
                        <!--botón reglas modal-->
                        <button type="button" class="btn btn-all text-white" data-toggle="modal" data-target="#exampleModalScrollable">
                            <i class="mr-1 fas fa-ruler"></i>
                            Reglas
                        </button>
                    </div>
                </ul>
                <!--formulario / barra de busqueda-->
                <ul class="navbar-nav ml-auto">
                    <!--Pequeño php isset que sirve para ocultar o mostrar el boton de cerrar sesión y iniciar sesión, dependiendo si hay usuario login o no-->
                    <?php if (isset($_SESSION['rol'])) {
                        if ($_SESSION['rol'] == 2) { ?>
                            <a class=" btn btn-danger  login m-2" id="nologin" href="<?php echo SERVERURL ?>admin_config">
                                Pestaña de administrador
                            </a>
                    <?php } else if ($_SESSION['rol'] == 0){ ?>
                            <a class=" btn btn-danger  login m-2" id="nologin" href="<?php echo SERVERURL ?>user_page">
                                Pestaña de usuario
                            </a>
                        <?php }
                    }
                 ?>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <a class=" btn btn-outline-secondary m-2 login " id="nologin" href="<?php echo SERVERURL ?>logout">
                            Cerrar sesión
                        </a>
                    <?php } else { ?>
                        <div class="btn-group m-2" id="botones" role="group" aria-label="Basic example">
                            <!--botón Registrarse-->
                            <a class="btn btn btn-all text-white" href="<?php echo SERVERURL ?>register">
                                <i class="mr-1 fas fa-user-plus"></i>
                                Registrarse
                            </a>
                            <!--botón Iniciar sesión-->
                            <a class="btn btn-outline-secondary action-button" href="<?php echo SERVERURL ?>login">
                                <i class="mr-1 fas fa-sign-in-alt"></i>
                                Iniciar sesión
                            </a>
                        </div>
                    <?php } ?>
                    <li class="nav-item m-2">
                        <form class="form-inline" method="get" action="<?php echo SERVERURL ?>search">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <input type="text" class="form-control border border-dark border-right-0" name="busqueda" placeholder="Buscar"></input>
                                <button type="submit" class="btn btn-outline-dark rounded-right" value="Buscar" name="enviar">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

    </main>

</body>


</html>