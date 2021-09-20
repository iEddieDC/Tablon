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
            header('Location: $topics/pagina=1');
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
                <a class="btn btn-outline-primary m-3 p-2" href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>"><img src="<?php echo SERVERURL ?>resources/img/icons/coment.png" alt="" srcset=""></a><!-- construye un enlace con el id que se encuentre en la base de datos -->
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

        if ($article == null) { //validacion que sean solo los registros de la bd
            echo 'Error 404, Post no encontrado';
        }
    ?>
        <!--Comienza HTML-->

        <main class="pt-4 mb-4">
            <div class="shadow container border rounded mb-3">
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
                <div class="container text-center">
                    <img class=" rounded img-fluid" src="<?php echo SERVERURL ?>resources/img/uploads/<?php echo $article['topic_image'] ?>" />
                    <hr>
                </div>
                <div class="container">
                    <p><?php echo  $article['topic_subject'] ?></p>
                    <!--nombre del creador del post-->
                    <p class="text-secondary mt-2">Publicado por
                        <a class="text-primary">
                            <?php echo $article['user_name'] ?>
                        </a>
                        <!--Fecha de publicación-->
                        el dia
                        <?php echo $article['topic_date'] ?>
                        <!--id de publicación-->
                    </p>
                </div>

                <?php
            } //Fin extraer uno

            /* Función 3 -Para crear un topic en donde sea-*/
            public function create_topic()
            {
                /*pide acceso al servidor y despues valida que no esten vacios*/
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
                    $check = @getimagesize($_FILES['image']['tmp_name']);/*valida que sea una imagen y le da un nombre temporal*/
                    if ($check !== false) {
                        $folder = "../img/uploads/";/*para local*/
                        //$folder = 'https://apps.cualtos.udg.mx/app/tablon/resources/img/uploads/'; /*para servidor*/
                        $archivo = $folder . $_FILES['image']['name']; //image campo de form //name nombre del archivo

                        move_uploaded_file($_FILES['image']['tmp_name'], $archivo); //obtiene la imagen y la pone en esa ruta con su nombre

                        $state = $this->connect()->prepare('INSERT INTO topics (topic_title, topic_subject, topic_image, topic_cat,topic_by) VALUES (:title, :subject, :image, :cat, :by)');/*preparamos las variables para pasar los archivos a la BD*/
                        /*Ejecutamos state para ingresar mediante POST los datos*/
                        if (isset($_SESSION['acceso'])) {
                            $state->execute(array(
                                ':cat' => $_POST['category'],
                                ':title' => $_POST['title'],
                                ':subject' => $_POST['subject'],
                                ':image' => $_FILES['image']['name'],
                                'by' => $_SESSION['id']
                            ));
                        } else {
                            $state->execute(array(
                                ':cat' => $_POST['category'],
                                ':title' => $_POST['title'],
                                ':subject' => $_POST['subject'],
                                ':image' => $_FILES['image']['name'],
                                'by' => 6
                            ));
                        }
                        /*Mensaje de exito, publicacion creada*/
                ?>
                        <script type="text/javascript">
                            Swal.fire({
                                icon: 'success',
                                title: '¡Publicación Creada!',
                                footer: '<a href="index.php">Ir al inicio.</a>',
                                showConfirmButton: false,
                                timer: 5500
                            })
                        </script>
                <?php
                    } else {
                        //echo "Apartados incompletos!";
                    }
                }
                /*consulta a la bd para sacar y luego almacenar la categoria correpondiente*/
                $sql = "SELECT cat_name, cat_id from categories"; //consulta a la bd
                try {
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute();
                    $categorie = $stmt->fetchAll();
                } catch (Exception $ex) {
                    echo ($ex->getMessage());
                }

                ?>
                <!--Comienza HTML-->

                <div class="container-contact100">
                    <div class="wrap-contact100">
                        <span class="contact100-form-symbol">
                            <img src="<?php echo SERVERURL ?>/resources/img/icons/image.png" alt="SYMBOL-MAIL">
                        </span>
                        <form class="contact100-form flex-sb flex-w" action="upload" method="post" enctype="multipart/form-data">
                            <!--Este metodo sirve para mediante server mandarselo a si mismo-->
                            <span class="contact100-form-title">
                                Crea un hilo
                            </span>
                            <div class="wrap-input100  validate-input" data-validate="¡El título es necesario!">
                                <input class="input100 form-control" type="text" name="title" id="title" placeholder="Título del post" required>
                                <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 validate-input" data-validate="¡Descripción necesaria!">
                                <textarea class="input100 form-control" name="subject" id="post" rows="8" cols="50" maxlength="500" placeholder="Escribe aquí la descripción del post" required></textarea>
                                <span class="focus-input100"></span>
                            </div>

                            <div class="">
                                <label class=" input100  text-muted col-sm-2 col-form-label">Archivo</label>
                                <input class="form-control" type="file" name="image" id="image" required><br>
                            </div>


                            <div class="mb-2">
                                <label class=" input100 text-muted col-sm-2 col-form-label">Categoría</label>
                                <select class="form-control" name="category" id="category">
                                    <?php foreach ($categorie as $output) { ?>
                                        <option value="<?php echo $output["cat_id"] ?>"><?php echo $output["cat_name"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <input type="submit" value="Crear" button type="button" class="btn btn-primary btn-lg btn-block">
                            <input type="reset" value="Limpiar campos" button type="button" class="btn btn-secondary btn-lg btn-block"><br>
                        </form>
                    </div>
                </div>

            <?php
            } //fin create_topic

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
                $state = $this->connect()->prepare('SELECT cat_name, cat_id, cat_description, cat_image FROM categories ');
                $state->execute();
                $result = $state->fetchAll();

                /*consulta para extraer topics aleatorios*/
                $topics = $this->connect()->prepare('SELECT * FROM topics');
                $topics->execute();
                $carrousel = $topics->fetchAll();
            ?>
                <!--Comienza HTML-->
                <!--Carrousel-->
                <h2 class="text-center">Publicaciónes aleatorias</h2>
                <hr>
                <div class="bd-example">
                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleCaptions" data-slide-to="0" class=""></li>
                            <li data-target="#carouselExampleCaptions" data-slide-to="1" class=""></li>
                            <li data-target="#carouselExampleCaptions" data-slide-to="2" class="active"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item">
                                <img class="d-block w-100" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17c0431e11a%20text%20%7B%20fill%3A%23555%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17c0431e11a%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22285.9000015258789%22%20y%3D%22217.7%22%3EFirst%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Publicacion aleatoria</h5>
                                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" data-src="holder.js/800x400?auto=yes&amp;bg=666&amp;fg=444&amp;text=Second slide" alt="Second slide [800x400]" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17c0431e11b%20text%20%7B%20fill%3A%23444%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17c0431e11b%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23666%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22247.2916717529297%22%20y%3D%22217.7%22%3ESecond%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Second slide label</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                            <div class="carousel-item active">
                                <img class="d-block w-100" data-src="holder.js/800x400?auto=yes&amp;bg=555&amp;fg=333&amp;text=Third slide" alt="Third slide [800x400]" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17c0431e11c%20text%20%7B%20fill%3A%23333%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17c0431e11c%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23555%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22276.9749984741211%22%20y%3D%22217.7%22%3EThird%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Third slide label</h5>
                                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <!--categorias-->
                <hr>
                <h2 class="text-center mt-3">Categorías</h2>
                <hr>
                <!--foreach inicio -->
                <div class="row m-1">
                    <?php foreach ($result as $last) : ?>
                        <div class="col-sm-3">
                            <div class="card mt-2" style="width: 15rem;">
                                <img class="card-img-top" src="<?php echo SERVERURL ?>resources/img/categorie/<?php echo $last['cat_image'] ?> ">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-uppercase text-center">
                                        <?php list($name) = $last;
                                        echo " $name <br> "; ?>
                                    </h5>
                                    <p class="card-text  font-weight-light text-justify">
                                        <?php echo $last['cat_description'] ?>
                                    </p>
                                    <a href="categoria/?q=<?php echo $last['cat_id'] ?>/" class="btn btn-primary">Ver categoría</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="col-sm-3">
                        <div class="card mt-3" style="height: 13rem;">
                            <div class="card-body text-center">
                                <h5 class="card-title text-uppercase text-center">General</h5>
                                <p class="card-text font-weight-light text-justify">Todo el contenido del tablón con hilos de diferentes categorías.</p>
                                <a href="topics" class="btn btn-primary">Ver categoría</a>
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
                /*Paginación*/
                /*consultar la cantidad de articulos totales*/
                $state =  $this->connect()->prepare('SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by, user_name FROM topics,users WHERE topic_cat = :id AND topic_by = user_id ');
                $state->execute(array(
                    ':id' => $id
                ));
                $result = $state->fetchAll(); //devuelve la siguiente fila del conjunto de resultados (1 arreglo) 

                //numero de hilos por pagina
                $topic_x_page = 1;
                //Contar hilos de la base de datos
                $total_topics_bd = $state->rowCount();

                //echo $total_topics_bd;
                //dividir las paginas entre los articulos
                $pages = $total_topics_bd / $topic_x_page;
                //redondear el numero de paginas
                $pages = ceil($pages);
                //echo $pages;
                //validamos que se vaya a la pagina 1 

                /*consulta para extraer los hilos de la categoria
         $sql_articulos = $this->connect()->prepare('SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by, user_name FROM topics,users WHERE topic_cat = :id AND topic_by = user_id order by topic_date desc LIMIT 1');
         $sql_articulos->execute(array(
             ':id' => $id
         ));
 
         $resultado = $sql_articulos->fetchAll();
         */

                $iniciar = ($_GET['page'] - 1) * $topic_x_page;
                //echo $iniciar;
            ?>
                <!--Comienza HTML-->
                <!--foreach inicio -->

                <?php foreach ($result as $topic) : ?>
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
                        </div>

                        <a class="btn btn-outline-primary m-3 p-2" href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>"><img src="<?php echo SERVERURL ?>resources/img/icons/coment.png" alt="" srcset=""></a><!-- construye un enlace con el id que se encuentre en la base de datos -->

                    </div>
                <?php endforeach ?>
                <!--Paginacion-->
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item <?php echo $_GET['page'] <= 0 ? 'disabled' : '' ?>">
                            <a class="page-link" href="categoria/?q=<?php echo $id ?>?page=<?php echo $_GET['page'] - 1 ?>">
                                Anterior
                            </a>
                        </li>

                        <?php for ($i = 0; $i < $pages; $i++) : ?>
                            <li class="page-item 
                <?php echo $_GET['page'] == $i + 1 ? 'active' : '' ?>">
                                <a class="page-link" href="<?php echo SERVERURL ?>categoria/?q=<?php echo $id ?>?page=<?php echo $i + 1 ?>">
                                    <?php echo $i + 1 ?>
                                </a>
                            </li>
                        <?php endfor ?>

                        <li class="page-item
                <?php echo $_GET['page'] >= $pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?php echo SERVERURL ?>categoria/?q=<?php echo $id ?>?page=<? echo $_GET['page'] + 1 ?>">
                                Siguiente
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php
            }

            /* Función 7 -Para crear una categoría-*/
            public function create_category()
            {
                /*Validar que los campos no estn vacíos*/
                if (isset($_POST['enviar'])) {
                    if (empty($_POST['title'])) {
                        echo "El campo título está vacío";
                    } else if (empty($_POST['subject'])) {
                        echo "El campo descripción está vacío";
                    } else {
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            #validación nombre de categoria no se repita# 
                            $buscarCat = $this->connect()->prepare("SELECT * FROM categories
                    WHERE cat_name = '$_POST[title]'"); //preparamos la consulta a la BD
                            $buscarCat->execute();
                            $count = $buscarCat->rowCount();

                            /*validamos no se repita la categoria*/
                            if ($count == 1) {
                ?>
                                <script type="text/javascript">
                                    alert("¡ERROR! \n¡La categoría ya existe! \n Por favor cree una diferente");
                                </script>
                            <?php
                            } else {

                                #ingresamos los datos si no se repite la cat
                                $state = $this->connect()->prepare('INSERT INTO categories (cat_name, cat_description) VALUES (:title, :subject)');/*preparamos las variables para pasar los archivos a la BD*/
                                /*Ejecutamos state para ingresar mediante POST los datos*/
                                $state->execute(array(
                                    ':title' => $_POST['title'],
                                    ':subject' => $_POST['subject'],
                                ));

                            ?>
                                <!--Mensaje flotante para correcto-->
                                <script type="text/javascript">
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Categoría Creada!',
                                        footer: '<a href="index.php">Ir al inicio.</a>',
                                        showConfirmButton: false,
                                        timer: 5500
                                    })
                                </script>
                            <?php
                            }
                        } else {
                            ?>
                            <!--Mensaje flotante para Error-->
                            <script type="text/javascript">
                                Swal.fire({
                                    icon: 'error',
                                    title: '¡Error!',
                                    text: '¡Hubo algun error, Por favor intente de nuevo!',
                                    footer: '<a href="index.php">Volver al inicio</a>'
                                })
                            </script>
                <?php
                        }
                    }
                }
                ?>
                <?php
            } //fin create_category

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

            /* Función 9 -Para crear un comentario en donde sea-*/
            public function create_reply()
            {

                /*pide acceso al servidor y despues valida que no esten vacios*/

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
                    $check = @getimagesize($_FILES['image']['tmp_name']);/*valida que sea una imagen y le da un nombre temporal*/
                    if ($check !== false) {
                        $folder = '../img/uploads/coments/'; //ruta donde se guardan los archivos/*para local*/
                        //$folder = 'https://apps.cualtos.udg.mx/app/tablon/resources/img/uploads/'; /*para servidor*/
                        $archivo = $folder . $_FILES['image']['name']; //image campo de form// name nombre del archivo
                        move_uploaded_file($_FILES['image']['tmp_name'], $archivo); //obtiene la imagen y la pone en esa ruta con su nombre

                        /*Consultar la id del hilo a comentar*/

                        $state = $this->connect()->prepare('INSERT INTO replies (reply_content, reply_image, reply_topic, reply_by) VALUES (:content, :image, :topic, :by)');/*preparamos las variables para pasar los archivos a la BD*/
                        /*Ejecutamos state para ingresar mediante POST los datos*/
                        if (isset($_SESSION['acceso'])) {
                            $state->execute(array(
                                ':content' => $_POST['content'],
                                ':image' => $_FILES['image']['name'],
                                ':topic' => $_SESSION["topic_id"],
                                'by' => $_SESSION['id']
                            ));
                        } else {
                            $state->execute(array(
                                ':content' => $_POST['content'],
                                ':image' => $_FILES['image']['name'],
                                ':topic' => $_SESSION["topic_id"],
                                'by' => 6
                            ));
                        }

                        $msg = "Imagen creada con éxito";
                    } else {
                        $error = "El archivo no es una imagen";
                    }
                } ?>
                <div class="container p-2">
                    <form class="form-inline text-center" action="" method="post" enctype="multipart/form-data">
                        <label for="email" class="mr-sm-2"></label>
                        <input type="text" class="form-control mb-2 mr-sm-2 " placeholder="Escribe un comentario" name="content">
                        <span class="btn btn-primary btn-file  mb-2 mr-sm-2">
                            <img src="<?php echo SERVERURL ?>resources/img/icons/subir.png" style="height: 20px"><input type="file" name="image">
                        </span>

                        <input type="submit" value="Comentar" class="btn btn-primary btn-file mb-2 mr-sm-2">

                    </form>
                </div>
            </div>

        </main>
    <?php
            } //fin create_reply

            /*Funcion 9 ver comentarios*/
            public function view_coments()
            {
                $replie = $this->connect()->prepare('SELECT * FROM replies WHERE reply_topic = :id');/*preparamos las variables para pasar los archivos a la BD*/
                $replie->execute(array(
                    ':id' => $_SESSION["topic_id"]
                ));

                $replies = $replie->fetchAll();

    ?>
        <!--Comienza HTML-->
        <h2>
            <header>Comentarios</header>
        </h2>
        <?php foreach ($replies as $reply) : ?>
            <div class="card">

                <div class="col-lg-12 my-5">
                    <!--Seccion de texto-->

                    <!--id del comentario-->

                    <!--imagen del comentario-->
                    <img class="rounded float-left mr-2" style="width: 18rem;" src="<?php echo SERVERURL ?>resources/img/uploads/coments/<?php echo $reply['reply_image'] ?>" />
                    <p><?php echo  $reply['reply_content'] ?></p>
                    <!--fecha del comentario-->
                    Publicado el
                    <?php echo $reply['reply_date'] ?>
                    <!--id del creador del comentario-->
                    <hr>
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

        <?php
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

                <a class="btn btn-outline-primary m-3 p-2" href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>"><img src="<?php echo SERVERURL ?>resources/img/icons/coment.png" alt="" srcset=""></a><!-- construye un enlace con el id que se encuentre en la base de datos -->
            </div>
            </div>
        <?php endforeach; ?>


<?php } //fin clase TOPICS 
        } ?>