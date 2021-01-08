
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>

</head>

<body >
    <span class="icon-menu"></span>
    <div  class="container-fluid navbar-inverse bg-primary" >
        <nav  class="navbar navbar-dark navbar-expand-md text-white bg-primary navigation-clean-search">
            <div class="container-fluid"><a class="navbar-brand" href="<?php echo SERVERURL ?>">
                    <h1 >CUAltos Chan</h1>
                </a>
                <button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav">
                        <li><a class="btn btn-primary" href="upload">Crear un hilo</a></li>
                        <li><a class="btn btn-primary" href="create-cat">Crear una categoría</a></li>
                        <!--MODAL-->
                        <li>
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
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true"><h1>REGLAS</h1></span>
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
                    </ul>
                    <form class="form-inline mr-auto" target="_self">
                        <div class="form-group"><label for="search-field"></label></div>
                    </form>
                    <span class="btn btn-primary">
                    <a class="text-white" href="register">Registrarse</a>
                    </span>
                    <!--Pequeño php isset que sirve para ocultar o mostrar el boton de cerrar sesión y iniciar sesión-->
                    <?php if (isset($_SESSION['user'])){?>
                        <a class=" btn btn-light login" id="nologin" href="resources/config/sesions_config/logout.php">Cerrar sesión</a>
                    <?php }else{ ?>
                        <a class="btn btn-light action-button" role="button" href="login">Iniciar sesión</a>
                    </span>
                    <?php }?>
                    
                
                </div>
            </div>
        </nav>
    </div>

</body>

</html>