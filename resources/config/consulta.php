<?php
/*En este documento se realizan la mayor parte de consultas a la base de datos relacionadas con los hilos*/
include_once 'connect/functions.php';

class Topics extends DB
{
    /* Función 1 -Para extraer todos los hilos-*/
    public function extraer_db()
    {
        //state hace la consulta para contar los hilos
        $state = $this->connect()->prepare('SELECT topic_id FROM topics');
        $state->execute();

        /*paginación*/
        //numero de hilos por pagina
        $topic_x_page = 12;
        //Contar hilos de la base de datos
        $total_topics_bd = $state->rowCount();
        $pages = $total_topics_bd / $topic_x_page;
        $pages = ceil($pages); //redondear el numero de paginas


        //validamos que se vaya a la pagina 1 
        if (!$_GET) {
            echo "<script>
             window.location= 'topics/?pagina=1'
            </script>";
        }
        //validamos que no agreguen más paginas en el navegador
        if ($_GET['pagina'] > $pages || $_GET['pagina'] <= 0) {
            include "error.php";
        }
        //para tomar la pagina y el # topics que debemos mostrar
        $iniciar = ($_GET['pagina'] - 1) * $topic_x_page;

        $sql_topics = $this->connect()->prepare('SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by, user_name FROM topics, users WHERE topic_by = user_id order by topic_date desc LIMIT :iniciar,:ntopics');
        //pasamos los parametros
        $sql_topics->bindParam(':iniciar', $iniciar, PDO::PARAM_INT); //topics
        $sql_topics->bindParam(':ntopics', $topic_x_page, PDO::PARAM_INT); //topics totales

        $sql_topics->execute();
        //Resultado ahora hace la consulta para consultar todos los hilos
        $resultado = $sql_topics->fetchAll();
        /*fin paginación*/

?>
        <!--Comienza HTML-->
        <?php foreach ($resultado as $topic) : ?>
            <!--foreach inicio -->
            <div class="container border-top rounded mb-3 shadow">
                <div class="card mt-3">
                    <div class="col-lg-12 my-5">
                        <!-- construye un enlace con el id que se encuentre en la base de datos -->
                        <a href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>">
                            <!-- construye un enlace con la imagen que se encuentre en la base de datos -->
                            <img class="rounded float-left mr-2" style="width: 18rem;" src="<?php echo SERVERURL ?>resources/img/uploads/<?php echo $topic['topic_image'] ?>" />
                        </a>
                        <h4 class="font-weight-bold">
                            <?php echo $topic['topic_title'] ?>
                        </h4>
                        Publicado por
                        <a class="text-primary">
                            <!--id del creador del post-->
                            <?php echo $topic['user_name'] ?>
                        </a>
                        <!--Fecha de publicación-->
                        el dia
                        <?php echo $topic['topic_date'] ?>

                        <!--id de publicación-->
                        <p class="font-weight-bold">ID de hilo
                            <a class="text-primary"><?php echo $topic['topic_id'] ?></a>
                        </p>
                        <hr>
                        <div class="card-text">
                            <p><?php echo $topic['topic_subject'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button class="btn btn-light m-2 p-2 fas fa-heart fa-2x btn-like" data-toggle="tooltip" data-placement="bottom" title="Me gusta" id="like"></button>
                    <a class="btn btn-light m-2 p-2 fas fa-comment-alt fa-2x btn-comment" data-toggle="tooltip" data-placement="bottom" title="Comentarios" href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>"></a>
                </div>
            </div>
            <!--foreach cerrado -->
        <?php endforeach; ?>
        <!--Paginacion-->
        <nav aria-label="...">
            <ul class="pagination">

                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?php echo SERVERURL ?>topics/?pagina=<?php echo $_GET['pagina'] - 1 ?>">
                        Anterior
                    </a>
                </li>

                <?php for ($i = 0; $i < $pages; $i++) : ?>

                    <li class="page-item 
                <?php echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>">
                        <a class="page-link" href="<?php echo SERVERURL ?>topics/?pagina=<?php echo $i + 1 ?>">
                            <?php echo $i + 1 ?>
                        </a>
                    </li>

                <?php endfor ?>

                <li class="page-item
                <?php echo $_GET['pagina'] >= $pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?php echo SERVERURL ?>topics/?pagina=<?php echo $_GET['pagina'] + 1 ?>">
                        Siguiente
                    </a>
                </li>
            </ul>
        </nav>
        <?php
    }
    public function titulo_topic(){
        $id = isset($_GET['q']) ? $_GET['q'] : false; //busca la cadena q para id y si no existe lo hace boolean false

        /*preparamos la consulta a la bd*/
        $state =  $this->connect()->prepare("SELECT topic_title FROM topics WHERE topic_id = :id");
        $state->execute(array(
            ':id' => $id
        ));
        unset($_SESSION["topic_id"]);

        $_SESSION["topic_id"] = $id; //Variable globar para obtener el ID del topic actual

        $article = $state->fetch(); //devuelve la siguiente fila del conjunto de resultados (1 arreglo)
        echo $article[0];
    }
    /* Función 2 -Para extraer uno y hacer un topic en base al ID de los topics-*/
    public function extraer_uno()
    {
        $id = isset($_GET['q']) ? $_GET['q'] : false; //busca la cadena q para id y si no existe lo hace boolean false

        if (!$id) { //validacion del id
            //header('Location: ../php/topics.php');
        }
        /*preparamos la consulta a la bd*/
        $state =  $this->connect()->prepare("SELECT *, user_name FROM topics, users WHERE topic_id = :id AND topic_by = user_id");
        $state->execute(array(
            ':id' => $id
        ));
        unset($_SESSION["topic_id"]);

        $_SESSION["topic_id"] = $id; //Variable globar para obtener el ID del topic actual

        $article = $state->fetch(); //devuelve la siguiente fila del conjunto de resultados (1 arreglo)

        /*contar numero de comentarios*/
        $comentarios = $state =  $this->connect()->prepare("SELECT * FROM replies WHERE reply_topic = :id");
        $comentarios->execute(array(
            ':id' => $id
        ));

        $comentarios = $state->rowCount(); //devuelve la siguiente fila del conjunto de resultados (1 arreglo)

        if ($article == null) { //validacion que sean solo los registros de la bd
            include 'error.php';
        } else {

            $url = $_SERVER["REQUEST_URI"]; //obtenemos la URL actual
        ?>
        
            <!--Comienza HTML-->
            <div class="container">
                <div class="row mb-5">
                    <div class="col-1 mt-2 dot shadow-sm rounded-right ">
                        <p class="text-white">ID
                            <a class="text-primary">
                                <?php echo $article['topic_id'] ?>
                            </a>
                        </p>
                    </div>
                    <div class="col-10">
                        <h2 class="font-weight-bold mt-3"><?php echo $article['topic_title'] ?></h2>
                    </div>
                </div>
                <hr>

                <div class="container">
                    <p class="mb-2"><?php echo  $article['topic_subject'] ?></p>
                    <img class=" rounded img-fluid" src="<?php echo SERVERURL ?>resources/img/uploads/<?php echo $article['topic_image'] ?>" />
                    <hr>
                </div>
                <div class="container">

                </div>
                <div class="container mb-4">

                    <!--nombre del creador del post-->
                    <p class="text-secondary mt-2">Publicado por
                        <t class="text-primary">
                            <?php echo $article['user_name'] ?>
                        </t>
                        <!--Fecha de publicación-->
                        el dia
                        <?php echo $article['topic_date'] ?>
                        <!--id de publicación-->
                    <p class="text-right">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url ?>">Compartir</a>
                        <a href="#comentarios"> <?php echo $comentarios ?> Comentarios</a>

                    </p>
                    </p>

                </div>
            </div>

        <?php
        } //fin else
    } //Fin extraer uno


    /*función 4 -Extraer los ultimos post para el Index-*/
    public function extraer_ult()
    {
        /*consulta para hacer la lista*/
        $state = $this->connect()->prepare('SELECT topic_id, topic_date, cat_name, topic_title FROM topics, categories WHERE cat_id=topic_cat order by topic_date desc limit 5');
        $state->execute();
        $result = $state->fetchAll();
        ?>
        <!--Comienza HTML-->
        <!--foreach inicio -->
        <?php foreach ($result as $last) : ?>
            <a href="topic/<?php echo $last['topic_id'] ?>">
                <!--mediante esta linea se extrae el ID del topic y se busca en la base de datos para cargarlo despues-->
                <?php list($id, $date, $cat, $name) = $last; ?>
                <i class="fas fa-history"></i>
                <!--<img src="resources/img/icons/history.png" >-->
                <?php
                echo "$name > $cat > $date  <br>";
                ?>
            </a>

            <hr>
        <?php endforeach; ?>
        <!--foreach cerrado -->
    <?php
    } //fin función extraer ultimos

    /*función 5 -Extrae las categorias-*/
    public function extraer_cat()
    {
        /*consulta para hacer la lista de categorias*/
        $state = $this->connect()->prepare('SELECT cat_name, cat_id, cat_description, cat_image FROM categories Order by cat_name ASC ');
        $state->execute();
        $result = $state->fetchAll();

        /*consulta para extraer topics aleatorios*/
        $topics = $this->connect()->prepare('SELECT * FROM topics order by rand() desc LIMIT 10');
        $topics->execute();
        $carrousel = $topics->fetchAll();
    ?>
        <!--Comienza HTML-->
        <hr>
        <h2 class="text-center">Publicaciones aleatorias</h2>
        <hr>
        <!--Carrousel-->

        <div id="carouselExampleControls" class="carousel slide p-5" data-ride="carousel">
            <div class="carousel-inner">
                <!--Foreach para mostrar los topics en pantalla-->
                <?php foreach ($carrousel as $topic) : ?>
                    <div class="carousel-item" style="transition: ease-out 0.4s;">
                        <a href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>">
                            <img class="d-block w-100 bg-dark rounded border border-dark" src="resources/img/uploads/<?php echo $topic['topic_image'] ?>" height="500" width="700">
                        </a>
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="text-white bg-dark rounded"><?php echo $topic['topic_title'] ?></h5>
                            <p class="text-dark bg-white rounded"><?php echo $topic['topic_subject'] ?></p>
                            <!--<span class="btn btn-dark">
                                        <a class="text-white" href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>">Ver hilo</a>
                                    </span>-->
                        </div>
                    </div>
                <?php endforeach ?>
                <!--Con este item comienza el carrousel para la presentación-->
                <div class="carousel-item active" style="transition: ease-out 0.4s;">
                    <img class="d-block w-100 rounded border border-dark" src="resources/img/icons/wel_msg.jpg" height="500" width="700" alt="First slide">
                    <div class="carousel-caption d-none d-md-block ">
                        <h5 class="text-white bg-dark rounded">¡Comienza a explorar!</h5>
                        <p class="text-dark bg-white rounded">Haz click en las flechas derecha o izquierda para ver los diferentes hilos que hay para ti, entra a cualquiera de ellos haciendo click en la imagen.</p>
                    </div>
                </div>
            </div>
            <!--Control anterior/siguiente-->
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <!--Fin carrousel-->

        <!--Categorias-->
        <hr>
        <h2 class="text-center mt-3">Tablones</h2>
        <hr>
        <!--foreach inicio -->
        <div class="row m-1">
            <?php foreach ($result as $last) : ?>
                <div class="col-sm-3 mt-3 ">
                    <div class="card cat_card">
                        <div class="embed-responsive embed-responsive-16by9">
                            <a href="categoria/?q=<?php echo $last['cat_id'] ?>/"><img class="card-img-top Card image cap embed-responsive-item" src="<?php echo SERVERURL ?>resources/img/categorie/<?php echo $last['cat_image'] ?> "></a>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title text-uppercase text-center">
                                <?php list($name) = $last;
                                echo " $name <br> "; ?>
                            </h5>
                            <p class="card-text text-justify">
                                <?php echo $last['cat_description'] ?>
                            </p>
                            <a href="categoria/?q=<?php echo $last['cat_id'] ?>/" class="btn btn-all" style="color:white">Ver tablón</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-sm-3 mt-3 ">
                <div class="card cat_card">
                    <div class="embed-responsive embed-responsive-16by9">
                        <a href="<?php echo SERVERURL ?>topics"><img class="card-img-top Card image cap embed-responsive-item" src="<?php echo SERVERURL ?>resources/img/categorie/general.png"></a>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title text-uppercase text-center">
                            General
                        </h5>
                        <p class="card-text text-justify">
                            Todo el contenido del tablón con hilos de diferentes categorías.
                        </p>
                        <a href="<?php echo SERVERURL ?>topics" class="btn btn-all" style="color:white">Ver categoría</a>
                    </div>
                </div>
            </div>

        </div>
        <!--foreach cerrado -->
    <?php
    } //fin función extraer categorias

    /*función 6 -Consulta para mostrar hilos de una sola categoria*/
    public function topics_cat()
    {
        /*Consulta para id de categoria*/
        $id = isset($_GET['q']) ? $_GET['q'] : false; //busca la cadena q para id y si no existe lo hace boolean false

        if (!$id) { //validacion del id
            header('Location: topics.php');
        }


        /*consultar la cantidad de articulos totales*/
        $state =  $this->connect()->prepare('SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by, user_name FROM topics,users WHERE topic_cat = :id AND topic_by = user_id order by topic_date desc ');
        $state->execute(array(
            ':id' => $id
        ));
        $result = $state->fetchAll(); //devuelve la siguiente fila del conjunto de resultados (1 arreglo) 
        /*Consulta el nombre de la categoria*/
        $name = $this->connect()->prepare('SELECT * FROM categories WHERE cat_id = :id');
        $name->execute(array(
            ':id' => $id
        ));
        $rname = $name->fetchAll();

    ?>
        <?php if ($rname != false) { ?>
            <!--Comienza HTML-->
            <h2 class="text-center border p-5 mb-3"><?php echo $rname[0][1] ?></h2>

            <!--foreach inicio -->
            <?php foreach ($result as $topic) : ?>
                <div class="container border-top mt-3 p-3 mb-3 rounded ">
                    <div class="card shadow">
                        <div class="col-lg-12 mt-3">
                            <!-- construye un enlace con el id que se encuentre en la base de datos -->
                            <a href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>">
                                <!-- construye un enlace con la imagen que se encuentre en la base de datos -->
                                <img class="rounded float-left mr-2" data-toggle="tooltip" data-placement="bottom" title="Foto de la publicación" height="300" width="300" src="<?php echo SERVERURL ?>resources/img/uploads/<?php echo $topic['topic_image'] ?>" />
                            </a>
                            <h4 class="font-weight-bold">
                                <?php echo $topic['topic_title'] ?>
                            </h4>
                            Publicado por
                            <t class="text-primary">
                                <!--id del creador del post-->
                                <?php echo $topic['user_name'] ?>
                            </t>
                            el dia
                            <!--Fecha de publicación-->
                            <?php echo $topic['topic_date'] ?>
                            <p class="font-weight-bold">ID de hilo
                                <!--id de publicación-->
                                <a class="text-primary"><?php echo $topic['topic_id'] ?></a>
                            </p>
                            <hr>
                            <div class="card-text">
                                <p><?php echo $topic['topic_subject'] ?></p>
                            </div>

                        </div>
                        <div class="buttons ml-3 mb-4 mt-1">
                            <button class="btn btn-light fas fa-star fa btn-like" data-toggle="tooltip" data-placement="bottom" title="Ovacionar" id="like"></button>
                            <a class="btn btn-light  fas fa-comment-alt fa btn-comment" data-toggle="tooltip" data-placement="bottom" title="Comentarios" href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>"></a>
                            <a class="btn btn-light  fas fa-share fa btn-comment" data-toggle="tooltip" data-placement="bottom" title="Compartir en FB"  href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SERVERURL?>topic/<?php echo $topic['topic_id'] ?>"></a>
                            
                        </div>


                    </div>

                </div>
            <?php endforeach ?>

        <?php
        } else {
            include "error.php";
        }
    }

    /* Función 8 -Para contar el # de posts publicados-*/
    public function num_posts()
    {
        $state = $this->connect()->prepare('SELECT COUNT(*) FROM topics');
        $state->execute();

        $prim = $state->fetchAll();
        foreach ($prim as $a) : //imprimimos mediante el foreach para tomar la casilla 0 que es el contador
        ?>
            <i class="far fa-newspaper"></i>
            <!--<IMG src="resources/img/icons/newspaper.png">-->
        <?php echo "POSTS: " . $a[0];
        endforeach;
    }


    /*Funcion 9 ver comentarios*/
    public function view_coments()
    {
        $replie = $this->connect()->prepare('SELECT *, user_name FROM replies,users WHERE reply_topic = :id AND reply_by = user_id');/*preparamos las variables para pasar los archivos a la BD*/
        $replie->execute(array(
            ':id' => $_SESSION["topic_id"]
        ));

        $replies = $replie->fetchAll();

        ?>
        <!--Comienza HTML-->
        <?php foreach ($replies as $reply) : ?>
            <div class="card">
                <div class="col-lg-12 my-5">
                    <!--id del creador del comentario-->
                    Publicado por
                    <t class="text-primary"> <?php echo $reply['user_name'] ?></t>
                    <!--fecha del comentario-->
                    el
                    <?php echo $reply['reply_date'] ?>
                    <!--imagen del comentario-->
                    <?php
                    /*if validamos que el comentario tenga imagen, sino le ponemos la imagen de stock*/
                    if (isset($reply['reply_image'])) { ?>
                        <img class="rounded float-left mr-2" style="width: 18rem;" src="<?php echo SERVERURL ?>resources/img/uploads/coments/<?php echo $reply['reply_image'] ?>" />
                    <?php } else { ?>
                        <img class="rounded float-left mr-2" style="width: 7rem;" src="<?php echo SERVERURL ?>resources/img/icons/stock_no_image.jpg" />
                    <?php } ?>
                    <hr>
                    <!--Seccion de texto-->
                    <p><?php echo  $reply['reply_content'] ?></p>
                </div>
            </div>
        <?php endforeach ?>
    <?php
    } //fin view coments

    /*Función 10* Buscar navbar*/
    public function search()
    { ?>


        <?php
        if (isset($_GET['enviar'])) {

            $busqueda = $_GET['busqueda'];
            $consulta =  $this->connect()->prepare("SELECT *,user_name FROM topics, users WHERE topic_by = user_id AND topic_title LIKE '%$busqueda%' ");
            $consulta->execute();
            $row = $consulta->fetchAll();
        }
        ?>
        <div class="container">
            <hr>
            <h2 class="text-center">Resultados de la búsqueda</h2>
            <p class="text-muted">Publicaciones relacionadas con : <?php echo $busqueda ?></p>
            <hr>

            <?php
            if ($row != false) {
                foreach ($row as $topic) : ?>
                    <div class="container border-top rounded mb-3 shadow">
                        <div class="card mt-3">
                            <div class="col-lg-12 my-5">
                                <!-- construye un enlace con el id que se encuentre en la base de datos -->
                                <a href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>">
                                    <!-- construye un enlace con la imagen que se encuentre en la base de datos -->
                                    <img class="rounded float-left mr-2" style="width: 18rem;" src="<?php echo SERVERURL ?>resources/img/uploads/<?php echo $topic['topic_image'] ?>" />
                                </a>
                                <div class="card-body">
                                    <!--Titulo del post-->
                                    <h4 class="card-title"><?php echo $topic['topic_title'] ?></h4>
                                    <!--id del creador del post-->
                                    Publicado por
                                    <a class="text-primary"><?php echo $topic['user_name'] ?></a>
                                    <!--Fecha de publicación-->
                                    el dia
                                    <p class="card-text"><small class="text-muted">Ultima actualización <?php echo $topic['topic_date'] ?></small></p>
                                    <hr>
                                    <!--Texto del post-->
                                    <p class="card-text"><?php echo $topic['topic_subject'] ?></p>
                                    <a href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>" class="btn btn-primary">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="buttons">
                            <button class="btn btn-light m-2 p-2 fas fa-heart fa-2x btn-like" data-toggle="tooltip" data-placement="bottom" title="Me gusta" id="like"></button>
                            <a class="btn btn-light m-2 p-2 fas fa-comment-alt fa-2x btn-comment" data-toggle="tooltip" data-placement="bottom" title="Comentarios" href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>"></a>
                        </div>
                    </div>
        </div>
    <?php endforeach; ?>

<?php } else { ?>
    <div class="container text-center p-5">
        <img src="<?php echo SERVERURL ?>resources/img/icons/search_not_found.png">
        <h1 class="mt-5">¡Sin resultados!</h1>
        <h3>Tu búsqueda no arrojo resultados, prueba con otras palabras.</h3>
        <!--<div>Iconos diseñados por <a href="https://www.flaticon.es/autores/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.es/" title="Flaticon">www.flaticon.es</a></div>-->
    </div>
<?php
            }
        } //fin clase TOPICS 
    } ?>