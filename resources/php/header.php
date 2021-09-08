<!--Este header es para el index-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
</head>

<body>
    <main>
        <!--Navbar-->
        <div class="navbar UDG navbar-expand-lg justify-content-between shadow-sm ">
            <a class="navbar-brand text-dark" href="index.php">
                <h1>
                    <img alt="Enlace al sitio de la Universidad de Guadalajara" src="resources/img/icons/udg-leon-vector-logo3.png" style="width: 50px; height: 50px;">
                    Cualtos-chan
                </h1>
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
            <!--Buscador-->

        </div>
        <span class="icon-menu"></span>
        <div class="container-fluid navbar-inverse  bg-light rounded-bottom shadow-sm">
            <!--Navbar sticky-->
            <nav class="navbar navbar-expand-sm navbar-light bg-light">
                <div class="container">

                    <div class="collapse navbar-collapse" id="navbar1">
                        <ul class="navbar-nav">
                            <li class="nav-item active mr-2">

                                <a class="btn btn-primary" href="upload"><i class="far fa-file-alt"></i> Crear un hilo</a>
                            </li>
                            <li class="nav-item active">
                                <!--MODAL-->
                                <!-- Button trigger modal -->

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalScrollable">
                                    <i class="fas fa-ruler"></i>
                                    Reglas
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark" id="exampleModalScrollableTitle">Lee las reglas atentamente</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </button>
                                            </div>

                                            <div class="modal-body text-dark">
                                                <h1>El tablón de imagenes es una comunidad</h1>
                                                <h2>y para mantener el orden se han creado las siguientes reglas:</h2>
                                                <ul>
                                                    <li>1.- No se aceptan insultos. Trata a las demas personas con respeto, recuerda que en su mayoria son alumnos.</li>
                                                    <li>2.- El spam no es bienvenido. Hacer spam es publicar cualquier tema de manera masiva, ya sea una pagina web, canal de youtube, algun FB etc.</li>
                                                    <li>3.- No republiques posts viejos. Los post que ya han sido resueltos y fueron publicados hace un tiempo deben mantenerse así.</li>
                                                    <li>4.- Evita ser troll. Está comunidad se mantiene gracias a que los usuarios se ayudan entre si.</li>
                                                </ul>

                                                <adver>NO ROMPAS LAS REGLAS, DE LO CONTRARIO TUS COMENTARIOS O POST SERAN BORRADOS.</adver>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Entendido</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!--para boton extra en caso de ser necesario-->
                            <li class="nav-item">
                                <a class="nav-link" href="#"></a>
                            </li>
                        </ul>
                        <!--formulario/ barra de busqueda-->
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <form class="form-inline my-2 my-lg-0" method="get" action="resources/php/search_page.php">
                                    <input type="text" class="form-control " name="busqueda" placeholder="Buscar">
                                    <button type="submit" class="btn btn-outline-success" value="Buscar" name="enviar">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </li>
                            <!--Pequeño php isset que sirve para ocultar o mostrar el boton de cerrar sesión y iniciar sesión, dependiendo si hay usuario login o no-->
                            <li class="nav-item active">
                                <?php if (isset($_SESSION['user'])) { ?>
                                    <a class=" btn btn-outline-primary ml-2 mr-2 login" id="nologin" href="resources/config/sesions_config/logout.php">Cerrar sesión</a>
                                <?php } else { ?>
                                    <span class="btn btn-primary ml-2">
                                        <a class="text-white" href="register">Registrarse</a>
                                    </span>
                                    <span>
                                        <a class="btn btn-outline-secondary action-button mr-2" role="button" href="login">Iniciar sesión</a>
                                    </span>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </main>
</body>

</html>