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
   
        $sql_topics = $this->connect()->prepare('SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by, user_name FROM topics, users WHERE topic_by = user_id order by topic_date desc LIMIT :iniciar,:ntopics');
        //pasamos los parametros
        $sql_topics->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);//topics
        $sql_topics->bindParam(':ntopics', $topic_x_page, PDO::PARAM_INT);//topics totales

        $sql_topics->execute();
        //Resultado ahora hace la consulta para consultar todos los hilos
        $resultado = $sql_topics->fetchAll();
        /*fin paginación*/

        ?>
        <!--Comienza HTML-->
        <?php foreach ($resultado as $topic) : ?>
            <!--foreach inicio -->
            <div class="container border-top rounded mb-3 shadow">
            <div class="card mt-3" >
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
                
                <li class="page-item <?php echo $_GET['pagina']<=1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?php echo SERVERURL ?>topics/?pagina=<?php echo $_GET['pagina']-1?>">
                        Anterior
                    </a>
                </li>

                <?php for($i=0; $i<$pages; $i++):?>

                <li class="page-item 
                <?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?>">
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
                        <img class=" rounded img-fluid" src="<?php echo SERVERURL ?>resources/img/uploads/<?php echo $article['topic_image'] ?>"/>
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
                $folder = '../img/uploads/'; /*revisar permisos de la carpeta en el servidor*/
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
            <div class="wrap-input100  validate-input" data-validate = "¡El título es necesario!">
                <input class="input100 form-control" type="text" name="title" id="title" placeholder="Título del post" required>
                <span class="focus-input100"></span>
            </div>

            <div class="wrap-input100 validate-input" data-validate = "¡Descripción necesaria!">
                <textarea class="input100 form-control" name="subject" id="post" rows="8" cols="50" maxlength="500" placeholder="Escribe aquí la descripción del post" required></textarea>
                <span class="focus-input100"></span>
            </div>

            <div class="">
                <label class=" input100  text-muted col-sm-2 col-form-label">Archivo</label>
                <input class="form-control" type="file" name="image" id="image" required><br>
            </div>
                    

            <div class="mb-2">
                <label class=" input100 text-muted col-sm-2 col-form-label">Categoría</label>
                <select class="form-control"name="category" id="category">
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
                <a href="topic/<?php echo $last['topic_id'] ?>"><?php //mediante esta linea se extrae el ID del topic y se busca en la base de datos para cargarlo despues
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
                    <a href="resources/php/topic_cat.php?q=<?php echo $last['cat_id'] ?>" class="btn btn-primary rounded-pill">Ver categoría</a>
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

    /*función 6 -Consulta para mostrar hilos de una sola categoria*/
    public function topics_cat()
    {
        /*Consulta para id de categoria*/
        $id = isset($_GET['q']) ? $_GET['q'] : false; //busca la cadena q para id y si no existe lo hace boolean false
        
        if (!$id) { //validacion del id
            header('Location: topics.php');
        }
        /*consulta para extraer los hilos de la categoria*/
        $state = $this->connect()->prepare('SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by, user_name FROM topics,users WHERE topic_cat = :id AND topic_by = user_id order by topic_date desc LIMIT 12');
        $state->execute(array(
            ':id' => $id
        ));
        $resultado = $state->fetchAll();


        /*Paginación*/
        //numero de hilos por pagina
        $topic_x_page = 12;
        //Contar hilos de la base de datos
        $total_topics_bd = $state->rowCount();
        //echo $total_topics_bd;
        //dividir las paginas entre los articulos
        $pages = $total_topics_bd / $topic_x_page;
        //redondear el numero de paginas
        $pages = ceil($pages); 
        //echo $pages;
        
        $iniciar = ($_GET['page']-1)*$topic_x_page;
        //echo $iniciar;
    ?>
        
        <?php foreach ($resultado as $topic) : 
            /*contar los comentarios de cada publicacion*/
            $contar_comentarios = $this->connect()->prepare('SELECT * FROM replies WHERE reply_topic = :id ');
            $contar_comentarios->execute(array(
                ':id' => $topic['topic_id']
            ));
            $num_com = $contar_comentarios->rowCount();

            /*contar el numero de likes dependiendo de nuestro ID*/
            $contar_likes = $this->connect()->prepare('SELECT * FROM likes WHERE user = :user_id AND post = :topic_id');
            $contar_likes->execute(array(
                ':user_id' => $_SESSION['id'],
                ':topic_id' => $topic['topic_id']
            ));
            $cLikes = $contar_likes->rowCount();//
        ?>
        <!--Comienza HTML-->
        <!--foreach inicio -->
        <div class="container border-top rounded mb-3 shadow">
            <div class="card mt-3" >
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
            <!--Seccion de likes y comentarios-->
            <div class="hl-section-likes">
                <!--si no hemos dado like se muestra vacio el corazón-->
                <script src="<?php echo SERVERURL ?>/resources/js/likes.js"></script>
                <?php if($cLikes == 0){?>
                    <div id="<?php echo $topic['topic_id']?>" class="like">
                    <a class ="btn btn-outline-primary m-3 p-2">
                        <?php echo $cLikes;?>
                        <img src="<?php echo SERVERURL?>resources/img/icons/heart_no.png" alt="">
                    </a>
                    </div>
                <!--si ya dimos like, corazón rojo-->
                <?php }else{?>
                    <div id="<?php echo $topic['topic_id']?>" class="like">
                    <a class ="btn btn-outline-primary m-3 p-2">
                        <?php echo $cLikes;?>
                        <img src="<?php echo SERVERURL ?>resources/img/icons/heart.png" alt="">
                    </a>
                    </div>
                <?php }?>
                <a class="btn btn-outline-primary m-3 p-2" href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>">
                    <?php echo $num_com;?>
                    <img src="<?php echo SERVERURL ?>resources/img/icons/coment.png" alt="" srcset="">
                </a><!-- construye un enlace con el id que se encuentre en la base de datos -->
            </div>
        </div>
        <?php endforeach ?>
        <!--Paginacion-->
        <nav aria-label="...">
            <ul class="pagination">
                
                <?php for($i=0; $i<$pages; $i++):?>
                <li class="page-item 
                <?php echo $_GET['page']==$i+1 ? 'active' : '' ?>">
                    <a class="page-link" 
                        href="topic_cat.php?q=<?php echo $id?>&page=<?php echo $i+1?>">
                     <?php echo $i+1?>
                    </a>
                </li>
                <?php endfor ?>
                
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

                    /*validamos no se repita la categoria*/
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
        <!--Comienza HTML-->
        

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

    /* Función 9 -Para crear un comentario en donde sea-*/
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
                
                $msg = "Imagen creada con éxito";
            } else {
                $error = "El archivo no es una imagen";
            }
        }?>
        <div class="container p-2">
        <form class="form-inline text-center" action="" method="post" enctype="multipart/form-data">
            <label for="email" class="mr-sm-2"></label>
            <input type="text" class="form-control mb-2 mr-sm-2 " placeholder="Escribe un comentario" name="content">
            <span class="btn btn-primary btn-file  mb-2 mr-sm-2"  >
                <img src="<?php echo SERVERURL ?>resources/img/icons/subir.png" style="height: 20px"><input type="file" name="image" >
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
            <div class="card" >
            
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
                
        <?php endforeach ?>

        
        
<?php
    } //fin view coments
} //fin clase TOPICS 
?>