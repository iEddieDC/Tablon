<?php
include_once 'connect/functions.php';
include "config.php";
class Topics extends DB
{
    /* Función 1 -Para extraer y hacer los topics-*/
    public function extraer_db()
    {
        $state = $this->connect()->prepare('SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by, user_name FROM topics, users WHERE topic_by = user_id');
        $state->execute();

        //numero de hilos por pagina
        $topic_x_page = 10;
        //Contar hilos de la base de datos
        $total_topics_bd = $state->rowCount();
        $pages = $total_topics_bd / $topic_x_page;
        $pages = ceil($pages); //redondear el numero de paginas
?>
        <!--Comienza HTML-->
        <?php
        //validamos que se vaya a la pagina 1 
        if(!$_GET){
             echo "<script>
            
             window.location= 'topics/?pagina=1'
            </script>";
        }
        //validamos que no agreguen más paginas en el navegador
        if($_GET['pagina'] > $pages || $_GET['pagina'] <= 0 ){
            header('Location: $topics/pagina=1');
        }
        //para tomar la pagina y el # topics que debemos mostrar
        $iniciar = ($_GET['pagina']-1) * $topic_x_page;
   
        $sql_topics = $this->connect()->prepare('SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by, user_name FROM topics, users WHERE topic_by = user_id LIMIT :iniciar,:ntopics');
        //pasamos los parametros
        $sql_topics->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);//topics
        $sql_topics->bindParam(':ntopics', $topic_x_page, PDO::PARAM_INT);//topics totales

        $sql_topics->execute();

        $resultado = $sql_topics->fetchAll();

        ?>
        <?php foreach ($resultado as $topic) : ?>
            <!--foreach inicio -->
            <div class="article">
                <h4>
                    <?php echo $topic['topic_title'] ?>
                    <div class="topic_image">
                        <!-- construye un enlace con el id que se encuentre en la base de datos -->
                        <a href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>">
                            <img src="<?php echo SERVERURL ?>resources/img/uploads/<?php echo $topic['topic_image'] ?>" /><!-- construye un enlace con la imagen que se encuentre en la base de datos -->
                        </a>
                    </div>
                    <!--id del creador del post-->
                    <h4>Publicado por:</h4>
                    <?php echo $topic['user_name'] ?>
                    <!--Fecha de publicación-->
                    <?php echo $topic['topic_date'] ?>
                    <!--id de publicación-->
                    <?php echo $topic['topic_id'] ?>
                </h4>
                <div class="content">
                    <p><?php echo $topic['topic_subject'] ?></p>
                    <hr>
                </div>
                <a id="Respuestas" href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>"><img src="<?php echo SERVERURL ?>resources/img/icons/mas.png" alt="" srcset="">Respuestas</a><!-- construye un enlace con el id que se encuentre en la base de datos -->
            </div>
        <!--foreach cerrado -->
        <?php endforeach; ?>
        <!--Paginacion-->
        <nav aria-label="...">
            <ul class="pagination">

                <li class="page-item <?php echo $_GET['pagina']<=1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?php echo SERVERURL ?>topics/?pagina=<?php echo $_GET['pagina']-1?>">
                        Anterior
                    </a>
                </li>

                <?php for($i=0; $i<$pages; $i++):?>

                <li class="page-item <?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?>">
                    <a class="page-link" 
                     href="<?php echo SERVERURL ?>topics/?pagina=<?php echo $i+1?>">
                    <?php echo $i+1?>
                    </a>
                </li>

                <?php endfor ?>

                <li class="page-item
                <?php echo $_GET['pagina']>=$pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?php echo SERVERURL ?>topics/?pagina=<?php echo $_GET['pagina']+1?>">
                    Siguiente
                </a>
                </li>
            </ul>
        </nav>
    <?php
    }

    /* Función 2 -Para extraer y hacer un topic en base al ID de los topics-*/
    public function extraer_uno()
    {
        $id = isset($_GET['q']) ? $_GET['q'] : false; //busca la cadena q para id y si no existe lo hace boolean false

        if (!$id) { //validacion del id
            header('Location: ../php/topics.php');
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
          
        <header id="main-header">
        <a href="<?php echo SERVERURL ?>topics/"> <div id="boton">Regresar</div></a> 
            <h1><?php echo $article['topic_title'] ?></h1>
        </header><!-- / #main-header -->
        <section id="main">
            <article>
                <!--Seccion de texto-->
                <div class="content">
                    <img class="" src="<?php echo SERVERURL ?>resources/img/uploads/<?php echo $article['topic_image'] ?>" />
                    <hr>
                    <p><?php echo  $article['topic_subject'] ?></p>
                    <!--nombre del creador del post-->
                    <?php echo $article['user_name'] ?>
                    <!--Fecha de publicación-->
                    <?php echo $article['topic_date'] ?>
                    <!--id de publicación-->
                    <?php echo $article['topic_id'] ?>
                </div>
                 
            </article>
        </section>
        
    <?php
    } //Fin extraer uno

    /* Función 3 -Para crear un topic en donde sea-*/
    public function create_topic()
    {
        /*pide acceso al servidor y despues valida que no esten vacios*/
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
            $check = @getimagesize($_FILES['image']['tmp_name']);/*valida que sea una imagen y le da un nombre temporal*/
            if ($check !== false) {
                $folder = '../img/uploads/';
                $archivo = $folder . $_FILES['image']['name']; //image campo de form// name nombre del archivo
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
                $msg = "Imagen creada con éxito";
                header('Location:../../index.php');
            } else {
                $error = "El archivo no es una imagen";
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
        <header>
            <h3>Crear un nuevo hilo</h3>
        </header>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
            <!--Este metodo sirve para mediante server mandarselo a si mismo-->
            <div class="DivHijo">
                <label class="col-sm-2 col-form-label">TÍTULO</label>
                <input type="text" name="title" id="title" placeholder="Título del post" require><br>
            </div>

            <div class="DivHijo">
                <label class="col-sm-2 col-form-label">DESCRIPCIÓN</label>
                <textarea name="subject" id="post" rows="8" cols="50" maxlength="500" placeholder="Escribe aquí la descripción del post" require></textarea><br>
            </div>

            <div class="DivHijo">
                <label class="col-sm-2 col-form-label">ARCHIVO</label>
                <input type="file" name="image" id="image" class="" require><br>
            </div>


            <div class="DivHijo">
                <label class="col-sm-2 col-form-label">CATEGORÍA</label>
                <select name="category" id="category">
                    <?php foreach ($categorie as $output) { ?>
                        <option value="<?php echo $output["cat_id"] ?>"><?php echo $output["cat_name"] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <?php if (isset($error)) : ?>
                <p class="error"><?php echo $error; ?></p>
            <?php elseif (isset($msg)) : ?>
                <p class="ok"><?php echo $msg; ?></p>
            <?php endif; ?>
            <input type="submit" value="Crear" button type="button" class="btn btn-primary btn-lg btn-block">
            <input type="reset" value="Limpiar campos" button type="button" class="btn btn-secondary btn-lg btn-block"><br>
        </form>
    <?php
    } //fin create_topic

    /*función 4 -Extraer los ultimos post para el Index-*/
    public function extraer_ult()
    {
        /*consulta para hacer la lista*/
        $state = $this->connect()->prepare('SELECT topic_id, topic_date, cat_name, topic_title FROM topics, categories WHERE cat_id=topic_cat order by topic_date desc limit 10');
        $state->execute();
        $result = $state->fetchAll();
    ?>
        <!--Comienza HTML-->
        <!--foreach inicio -->
        <?php foreach ($result as $last) : ?>
                <a href="resources/php/topic.php?q=<?php echo $last['topic_id'] ?>"><?php //mediante esta linea se extrae el ID del topic y se busca en la base de datos para cargarlo despues
                list($id, $date, $cat, $name) = $last;
                ?>
                <img src="resources/img/icons/history.png" >
                <?php
                echo "$name > $cat > $date  <br>";
                ?></a>
            
            <hr>
        <?php endforeach; ?>
        <!--foreach cerrado -->
    <?php
    } //fin función extraer ultimos

    /*función 5 -Extrae las categorias-*/
    public function extraer_cat()
    {
        /*consulta para hacer la lista*/
        $state = $this->connect()->prepare('SELECT cat_name, cat_id,cat_description FROM categories ');
        $state->execute();
        $result = $state->fetchAll();
    ?>
        <!--Comienza HTML-->
        <header>
            <h2 class="text-center">Categorías</h2>
        </header>
        <!--foreach inicio -->
        <div class="row m-1">
        <?php foreach ($result as $last) : ?>
            <div class="col-sm-3">
                <div class="card mt-3" style="height: 13rem;" >
                    <div class="card-body text-center">
                    <h5 class="card-title text-uppercase text-center"><?php list($name) = $last;
                                        echo " $name <br> ";
                                        ?></h5>
                    <p class="card-text font-weight-light text-justify"><?php echo $last['cat_description'] ?></p>
                    <a href="categoria/<?php echo $last['cat_id'] ?>" class="btn btn-primary rounded-pill">Ver categoría</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="col-sm-3">
                <div class="card mt-3" style="height: 13rem;" >
                    <div class="card-body text-center">
                    <h5 class="card-title text-uppercase text-center">General</h5>
                    <p class="card-text font-weight-light text-justify">Todo el contenido del tablón con hilos de diferentes categorías.</p>
                    <a href="topics" class="btn btn-primary rounded-pill">Ver categoría</a>    
                </div>
                </div>
            </div>
        </div>
        <!--foreach cerrado -->
    <?php
    } //fin función extraer categorias

    /*función 6 -Consulta para mostrar topics de una sola categoria*/
    public function topics_cat()
    {
        /*Consulta*/
        $id = isset($_GET['q']) ? $_GET['q'] : false; //busca la cadena q para id y si no existe lo hace boolean false

        if (!$id) { //validacion del id
            header('Location: topics.php');
        }
        $state =  $this->connect()->prepare("SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by, user_name FROM topics,users WHERE topic_cat = :id AND topic_by = user_id");
        $state->execute(array(
            ':id' => $id
        ));
        $result = $state->fetchAll(); //devuelve la siguiente fila del conjunto de resultados (1 arreglo) 

        /*Paginación*/

        //numero de hilos por pagina
        $topic_x_page = 10;
        //Contar hilos de la base de datos
        $total_topics_bd = $state->rowCount();
        $pages = $total_topics_bd / $topic_x_page;
        $pages = ceil($pages); //redondear el numero de paginas
    ?>
        <!--Comienza HTML-->
        <!--foreach inicio -->
        <?php foreach ($result as $topic) : ?>
<div class="row">
    <div class="col-lg-12">
        <!-- construye un enlace con el id que se encuentre en la base de datos -->
            <a href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>">
        <!-- construye un enlace con la imagen que se encuentre en la base de datos -->
                <img class="rounded float-left mr-2" style="width: 18rem;" src="<?php echo SERVERURL ?>resources/img/uploads/<?php echo $topic['topic_image'] ?>" />
            </a>
            <h5 class=" font-weight-bold">
                <?php echo $topic['topic_title'] ?>
            </h5>
            <!--id del creador del post-->
            <?php echo $topic['user_name'] ?>
            <!--Fecha de publicación-->
            <?php echo $topic['topic_date'] ?>
            <!--id de publicación-->
            <?php echo $topic['topic_id'] ?>
            <div class="content">
                <p><?php echo $topic['topic_subject'] ?></p>
            </div>
        </div>
            <a class="btn btn-outline-primary m-3 p-2" href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>"><img src="<?php echo SERVERURL ?>resources/img/icons/mas.png" alt="" srcset=""></a><!-- construye un enlace con el id que se encuentre en la base de datos -->
</div>
<hr>
        <?php endforeach ?>
        <!--Paginacion-->
        <nav aria-label="...">
            <ul class="pagination">

                <li class="page-item <?php echo $_GET['pagina']<=1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="topics.php?pagina=<?php echo $_GET['pagina']-1?>">
                        Anterior
                    </a>
                </li>

                <?php for($i=0; $i<$pages; $i++):?>

                <li class="page-item <?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?>">
                    <a class="page-link" 
                     href="topics.php?pagina=<?php echo $i+1?>">
                    <?php echo $i+1?>
                    </a>
                </li>

                <?php endfor ?>

                <li class="page-item
                <?php echo $_GET['pagina']>=$pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="topics.php?pagina=<?php echo $_GET['pagina']+1?>">
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
                    WHERE cat_name = '$_POST[title]'");//preparamos la consulta a la BD
                    $buscarCat->execute();
                    $count = $buscarCat->rowCount();

                    if ($count == 1 ) {
                        ?>
                         <script type ="text/javascript">
                            alert("¡ERROR! \n¡La categoría ya existe! \n Por favor cree una diferente");
                        </script>
                        <?php 
                    }else{

                    #ingresamos los datos si no se repite la cat
                    $state = $this->connect()->prepare('INSERT INTO categories (cat_name, cat_description) VALUES (:title, :subject)');/*preparamos las variables para pasar los archivos a la BD*/
                    /*Ejecutamos state para ingresar mediante POST los datos*/
                    $state->execute(array(
                        ':title' => $_POST['title'],
                        ':subject' => $_POST['subject'],
                    ));

                        ?>
                         <script type ="text/javascript">
                            alert("¡CATEGORÍA CREADA CON EXITO!");
                        </script>
                        <?php 
                    }
                } else {
                        ?>
                         <script type ="text/javascript">
                            alert("¡ERROR! Por favor, intentelo de nuevo!");
                        </script>
                        <?php 
                }
            }
        }
    ?>
        <!--Comienza HTML-->
        <header>
            <h3>Crear una nueva categoría</h3>
        </header>
        <div id="formulario">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
                <div class="DivHijo">
                    <label class="col-sm-2 col-form-label">TÍTULO</label>
                    <input type="text" name="title" id="title"  placeholder="Título de la categoría" require><br>
                </div>

                <div class="DivHijo">
                    <label class="col-sm-2 col-form-label">DESCRIPCIÓN</label>
                    <textarea name="subject" id="post" rows="8" cols="20" maxlength="63" placeholder="Escribe aquí la descripción de la categoría" require></textarea><br>
                </div>
                <?php if (isset($error)) : ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php elseif (isset($msg)) : ?>
                    <p class="ok"><?php echo $msg; ?></p>
                <?php endif; ?>

                <input type="submit" name="enviar" value="Crear" button type="button" class="btn btn-primary btn-lg btn-block">
                <input type="reset" value="Limpiar campos" button type="button" class="btn btn-primary btn-lg btn-block"><br>

            </form>
        </div>

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
            <IMG src="resources/img/icons/newspaper.png">
            <?php echo "POSTS: " . $a[0];
        endforeach;
    }
    /* Función 9 -Para crear un topic en donde sea-*/
    public function create_reply()
    {

        /*pide acceso al servidor y despues valida que no esten vacios*/

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
            $check = @getimagesize($_FILES['image']['tmp_name']);/*valida que sea una imagen y le da un nombre temporal*/
            if ($check !== false) {
                $folder = '../img/uploads/coments/'; //ruta donde se guardan los archivos
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
                unset($_SESSION["topic_id"]);
                $msg = "Imagen creada con éxito";
            } else {
                $error = "El archivo no es una imagen";
            }
        }

    ?>
        <!--Comienza HTML-->
        <header>
            <h3>Crear un comentario</h3>
        </header>
        <div id="formulario">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
                <!--Este metodo sirve para mediante server mandarselo a si mismo-->
                <div class="DivHijo">
                    <label>COMENTARIO</label>
                    <textarea name="content" id="post" rows="8" cols="50" maxlength="500" placeholder="Escriba aquí su comentario" require></textarea><br>
                </div>

                <div class="DivHijo">
                    <label>ARCHIVO</label>
                    <input type="file" name="image" id="image" class="" require><br>
                </div>
                <?php if (isset($error)) : ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php elseif (isset($msg)) : ?>
                    <p class="ok"><?php echo $msg; ?></p>
                <?php endif; ?>
                <input type="submit" value="Crear" class="boton">
                <input type="reset" value="Limpiar campos" class="boton"><br>

            </form>
        </div>
    <?php
    } //fin create_reply

    /*Funcion 9*/
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
            <section id="main">
                <article>
                    <!--Seccion de texto-->
                    <div class="content">
                        <!--id del comentario-->
                        <?php //echo $reply['reply_id'] 
                        ?>
                        <!--imagen del comentario-->
                        <img class="" src="../img/uploads/coments/<?php echo $reply['reply_image'] ?>" />
                        <p><?php echo  $reply['reply_content'] ?></p>
                        <!--fecha del comentario-->
                        <?php echo $reply['reply_date'] ?>
                        <!--id del creador del comentario-->

                        <hr>
                    </div>
                </article>
            </section>
        <?php endforeach ?>
<?php
    } //fin view coments
} //fin clase TOPICS 
?>