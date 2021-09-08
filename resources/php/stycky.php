<nav class="navbar navbar-expand-sm sticky-top navbar-light bg-light">
    <div class="container">

        <div class="collapse navbar-collapse" id="navbar1">
            <ul class="navbar-nav">
                <li class="nav-item active mr-2">
                    <a class="btn btn-primary" href="upload">Crear un hilo</a>
                </li>
                <li class="nav-item active">
                    <!--MODAL-->
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#exampleModalScrollable">
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
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </li>
                <!--Pequeño php isset que sirve para ocultar o mostrar el boton de cerrar sesión y iniciar sesión, dependiendo si hay usuario login o no-->
                <li class="nav-item active">
                    <?php if (isset($_SESSION['user'])) { ?>
                        <a class=" btn btn-light login" id="nologin" href="resources/config/sesions_config/logout.php">Cerrar sesión</a>
                    <?php } else { ?>
                        <span class="btn btn-primary">
                            <a class="text-white" href="register">Registrarse</a>
                        </span>
                        <span>
                            <a class="btn btn-light action-button" role="button" href="login">Iniciar sesión</a>
                        </span>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
</nav>