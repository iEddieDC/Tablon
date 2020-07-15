<?php
include_once 'functions.php';
class Topics extends DB
{

    public function extraer_db()
    {

        $state = $this->connect()->prepare('SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by FROM topics');
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
                    <?php echo $topic['topic_by'] ?>
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
    /* Funcion 2 */
    public function extraer_uno()
    {
        $id = isset($_GET['q']) ? $_GET['q'] : false; //busca la cadena q para id y si no existe lo hace boolean false

        if (!$id) { //validacion del id
            header('Location: ../php/topics.php');
        }
        /*preparamos la consulta a la bd*/
        $state =  $this->connect()->prepare("SELECT * FROM topics WHERE topic_id = :id");
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
                    <?php echo $article['topic_by'] ?>
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
    /* Funcion 3 */
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
    /*función 5*/
    public function extraer_ult()
    { 
        /*consulta para hacer la lista*/
        $state = $this->connect()->prepare('SELECT topic_id, topic_date, cat_name, topic_title FROM topics, categories WHERE cat_id=topic_cat');
        $state->execute();

        $result = $state->fetchAll();
    ?>
    <!--foreach inicio -->
        <?php foreach ($result as $last) : ?>
            <li><a href="resources/php/topic.php?q=<?php echo $last['topic_id'] ?>"><?php
            list($id,$date, $cat, $name) = $last;
            echo "$date | $cat | $name <br>";
            ?></a></li><hr>
        <?php endforeach; ?>
        <!--foreach cerrado -->
<?php
    } //fin función extraer ultimos
}
?>