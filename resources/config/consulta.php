<?php
include_once 'functions.php';
class Topics extends DB
{
    /* Función 1 -Para extraer y hacer los topics-*/
    public function extraer_db()
    {
        $state = $this->connect()->prepare('SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by,user_name FROM topics, users WHERE topic_by = user_id');
        $state->execute();

        $result = $state->fetchAll();
    ?>
        <?php foreach ($result as $topic) : ?>
            <!--foreach inicio -->
            <div class="article">
                <h4>
                    <?php echo $topic['topic_title'] ?>
                    <div class="topic_image">
                        <!-- construye un enlace con el id que se encuentre en la base de datos -->
                        <a href="topic.php?q=<?php echo $topic['topic_id'] ?>">
                            <img src="../img/uploads/<?php echo $topic['topic_image'] ?>" /><!-- construye un enlace con la imagen que se encuentre en la base de datos -->
                        </a>
                    </div>
                    <!--id del creador del post-->
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
                <a id="Respuestas" href="topic.php?q=<?php echo $topic['topic_id'] ?>"><img src="../img/icons/mas.png" alt="" srcset="">Respuestas</a><!-- construye un enlace con el id que se encuentre en la base de datos -->
            </div>
            <!--Article-->
        <?php endforeach; ?>
        <!--foreach cerrado -->
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
        $article = $state->fetch(); //devuelve la siguiente fila del conjunto de resultados (1 arreglo)

        if ($article == null) { //validacion que sean solo los registros de la bd
            echo 'Error 404, Post no encontrado';
        } ?>

        <header id="main-header">
            <h1><?php echo $article['topic_title'] ?></h1>
        </header><!-- / #main-header -->
        <section id="main">
            <article>
                <!--Seccion de texto-->
                <div class="content">
                    <img class="" src="../img/uploads/<?php echo $article['topic_image'] ?>" />
                    <hr>
                    <p><?php echo  $article['topic_subject'] ?></p>
                    <?php echo $article['user_name'] ?>
                    <!--id del creador del post-->
                    <?php echo $article['topic_date'] ?>
                    <!--Fecha de publicación-->
                    <?php echo $article['topic_id'] ?>
                    <!--id de publicación-->
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
                $state->execute(array(
                    ':cat' => $_POST['category'],
                    ':title' => $_POST['title'],
                    ':subject' => $_POST['subject'],
                    ':image' => $_FILES['image']['name'],
                    'by' => $_POST['usuario']
                ));

                $msg = "Imagen creada con éxito";
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
        /*consulta para el usuario --- estos debo de borrarlo y buscar la forma de hacerlo anonimo si se registra o no--*/
        $sql = "SELECT user_id, user_name from users"; //consulta a la bd
        try {
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $ussuario = $stmt->fetchAll();
        } catch (Exception $ex) {
            echo ($ex->getMessage());
        }
    ?>

        <header>
            <h3>Crear un nuevo hilo</h3>
        </header>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
            <!--Este metodo sirve para mediante server mandarselo a si mismo-->
            <div class="DivHijo">
                <label>TÍTULO</label>
                <input type="text" name="title" id="title" placeholder="Título del post" require><br>
            </div>

            <div class="DivHijo">
                <label>DESCRIPCIÓN</label>
                <textarea name="subject" id="post" rows="8" cols="50" maxlength="500" placeholder="Escribe aquí la descripción del post" require></textarea><br>
            </div>

            <div class="DivHijo">
                <label>ARCHIVO</label>
                <input type="file" name="image" id="image" class="" require><br>
            </div>


            <div class="DivHijo">
                <label>CATEGORÍA</label>
                <select name="category" id="category">
                    <?php foreach ($categorie as $output) { ?>
                        <option value="<?php echo $output["cat_id"] ?>"><?php echo $output["cat_name"] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="DivHijo">
                <label>usuario</label>
                <select name="usuario" id="user">
                    <?php foreach ($ussuario as $outputt) { ?>
                        <option value="<?php echo $outputt["user_id"] ?>"><?php echo $outputt["user_name"] ?></option>
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
            <input type="submit" value="Crear" class="boton">
            <input type="reset" value="Limpiar campos" class="boton"><br>
        </form>
    <?php
    } //fin create_topic

    /*función 4 -Extraer los ultimos post para el Index-*/
    public function extraer_ult()
    { 
        /*consulta para hacer la lista*/
        $state = $this->connect()->prepare('SELECT topic_id, topic_date, cat_name, topic_title FROM topics, categories WHERE cat_id=topic_cat');
        $state->execute();

        $result = $state->fetchAll();
    ?>
    <!--foreach inicio -->
        <?php foreach ($result as $last) : ?>
            <li><a href="resources/php/topic.php?q=<?php echo $last['topic_id'] ?>"><?php //mediante esta linea se extrae el ID del topic y se busca en la base de datos para cargarlo despues
            list($id,$date, $cat, $name) = $last;
            echo "$date | $cat | $name <br>";
            ?></a></li><hr>
        <?php endforeach; ?>
        <!--foreach cerrado -->
<?php
    } //fin función extraer ultimos
    /*función 5 -Extrae las categorias-*/
    public function extraer_cat()
    { 
        /*consulta para hacer la lista*/
        $state = $this->connect()->prepare('SELECT cat_name, cat_id FROM categories ');
        $state->execute();

        $result = $state->fetchAll();
    ?>
    <!--foreach inicio -->
        <?php foreach ($result as $last) : ?>
            <li><a href="resources/php/topic_cat.php?q=<?php echo $last['cat_id'] ?>"><?php
            list($name) = $last;
            echo "| $name |<br> ";
            ?></a></li>
        <?php endforeach; ?>
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
        $result = $state->fetchAll(); //devuelve la siguiente fila del conjunto de resultados (1 arreglo) ?>
        <?php foreach ($result as $topic) : ?>
        <!--foreach inicio -->
        <div class="article">
                <h4>
                    <?php echo $topic['topic_title'] ?>
                    <div class="topic_image">
                        <!-- construye un enlace con el id que se encuentre en la base de datos -->
                        <a href="topic.php?q=<?php echo $topic['topic_id'] ?>">
                            <img src="../img/uploads/<?php echo $topic['topic_image'] ?>" /><!-- construye un enlace con la imagen que se encuentre en la base de datos -->
                        </a>
                    </div>
                    <!--id del creador del post-->
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
                <a id="Respuestas" href="topic.php?q=<?php echo $topic['topic_id'] ?>"><img src="../img/icons/mas.png" alt="" srcset="">Respuestas</a><!-- construye un enlace con el id que se encuentre en la base de datos -->
            </div>
            <!--Article-->
    <?php endforeach ?>
   <?php
    }
    /* Función 7 -Para crear una categoría-*/
    public function create_category()
    {
        /*Validar que los campos no estn vacíos*/
        if (isset($_POST['enviar'])) {
            if (empty($_POST['title'])) {
                echo "El campo título está vacío"; 
            }else if (empty($_POST['subject'])){
                echo "El campo descripción está vacío"; 
            }else{
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Si el campo "username" está vacío
            
                $state = $this->connect()->prepare('INSERT INTO categories (cat_name, cat_description) VALUES (:title, :subject)');/*preparamos las variables para pasar los archivos a la BD*/
                /*Ejecutamos state para ingresar mediante POST los datos*/
                $state->execute(array(
                    ':title' => $_POST['title'],
                    ':subject' => $_POST['subject'],
                ));

                $msg = "Categoría creada con éxito";
            } else {
                $error = "Hubo un error, intenta de nuevo";
            }
        }
    }
    ?>

<header><h3>Crear una nueva categoría</h3></header>
    <div id="formulario">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
        <div class="DivHijo">
         <label>TÍTULO</label>
            <input type="text" name="title" id="title" placeholder="Título de la categoría" require><br>
         </div>

         <div class="DivHijo"> 
        <label>DESCRIPCIÓN</label>
        <textarea name="subject" id="subject" rows="8" cols="20" maxlength="120" placeholder="Escribe aquí la descripción de la categoría" require></textarea><br>
        </div>
        <?php if (isset($error)) : ?>
                <p class="error"><?php echo $error; ?></p>
            <?php elseif (isset($msg)) : ?>
                <p class="ok"><?php echo $msg; ?></p>
            <?php endif; ?>

        <input type="submit" name="enviar" value="Crear" class="boton">
        <input type="reset" value="Limpiar campos" class="boton"><br>
    
    </form>
    </div>
    
    <?php
    } //fin create_category
}
?>