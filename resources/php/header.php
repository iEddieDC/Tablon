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
        <div class="navbar UDG  navbar-expand-lg justify-content-between shadow-sm  ">
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
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <div class="container-fluid navbar-inverse bg-light rounded-bottom shadow-sm ">
            <!--Navbar desplegable sticky-->
            <nav class="navbar navbar-dark navbar-expand-md text-white navigation-clean-search ">
                <div class="container-fluid">
                    <!--Botón desplegable-->
                    <button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler btn-outline-primary mb-3 btn-lg btn-block"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"><img src="resources/img/icons/menu.png"></span></button>
                    
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="nav navbar-nav">
                            <!--Botón crear hilo-->
                            <li><a class="btn btn-primary mx-auto" href="upload">Crear un hilo</a></li>
                            <!--MODAL-->
                            <li>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mx-auto" data-toggle="modal" data-target="#exampleModalScrollable">
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
                                                <h1>y para mantener el orden se han creado las siguientes reglas:</h1>
                                                <ul>
                                                    <li>1.- No se aceptan insultos. Trata a las demas personas con respeto, recuerda que en su mayoria son alumnos.</li>
                                                    <li>2.- El spam no es bienvenido. Hacer spam es publicar cualquier tema de manera masiva, ya sea una pagina web, canal de youtube, algun FB etc.</li>
                                                    <li>3.- No republiques posts viejos. Los post que ya han sido resueltos y fueron publicados hace un tiempo deben mantenerse así.</li>
                                                    <li>4.- Evita ser troll. Está comunidad se mantiene gracias a que los usuarios se ayudan entre si.</li>
                                                </ul>

                                                <adver>NO ROMPAS LAS REGLAS, DE LO CONTRARIO TUS COMENTARIOS O POST SERAN BORRADOS.</adver>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        
                        <!--Pequeño php isset que sirve para ocultar o mostrar el boton de cerrar sesión y iniciar sesión-->
                        <?php if (isset($_SESSION['user'])) { ?>
                            <li><a class=" btn btn-light login mx-auto" id="nologin" href="resources/config/sesions_config/logout.php">Cerrar sesión</a></li>
                        <?php } else { ?>
                            <li><a class="btn btn-outline-primary mx-auto" role="button" href="login">Iniciar sesión</a></li>
                            <!--Botón registro-->
                        <span class="btn btn-primary mx-auto">
                        <li><a class="text-white" href="register">Registrarse</a></li>
                        </span>
                            
                        <?php } ?>
                    </div>
                </div>
            </nav>
        </div>
    </main>
</body>

</html>