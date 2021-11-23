<?php
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
include_once '../config/connect/functions.php';
/*Clase para hacer nuevas publicaciones, comentarios y categorias*/
class Creates extends DB{
        /* Función 3 -Para crear un topic en donde sea-*/
    public function create_topic()
    {
        //Consultar el id del ultimo topic para renombrar el nuevo
        $consulta = $this->connect()->prepare('SELECT topic_id FROM topics order by topic_id desc limit 1');
        $consulta->execute();
        /*concatenamos y pasamos a una variable numerica*/
        $save_id = $consulta->fetchAll();
        $id = $save_id[0]["topic_id"] + 1; //sumamos 1 para que tenga el id del topic nuevo
        /*validación si no hay topics creados*/
        if ($id == null) {
            $id = 0;
        }
        /*pide acceso al servidor y despues valida que no esten vacios*/
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
            $check = @getimagesize($_FILES['image']['tmp_name']);/*valida que sea una imagen y le da un nombre temporal*/
            if ($check !== false) {
                $folder = "../img/uploads/";/*para local*/
                //$folder = 'https://apps.cualtos.udg.mx/app/tablon/resources/img/uploads/'; /*para servidor*/
                $archivo = $folder . $id . $_FILES['image']['name']; //topic_id//image campo de form //name nombre del archivo
                move_uploaded_file($_FILES['image']['tmp_name'], $archivo); //obtiene la imagen y la pone en esa ruta con su nombre

                $state = $this->connect()->prepare('INSERT INTO topics (topic_title, topic_subject, topic_image, topic_cat,topic_by) VALUES (:title, :subject, :image, :cat, :by)');/*preparamos las variables para pasar los archivos a la BD*/
                /*Ejecutamos state para ingresar mediante POST los datos*/
                if (isset($_SESSION['acceso'])) {
                    $state->execute(array(
                        ':cat' => $_POST['category'],
                        ':title' => $_POST['title'],
                        ':subject' => $_POST['subject'],
                        ':image' => $id . $_FILES['image']['name'],
                        'by' => $_SESSION['id']
                    ));
                } else {
                    $state->execute(array(
                        ':cat' => $_POST['category'],
                        ':title' => $_POST['title'],
                        ':subject' => $_POST['subject'],
                        ':image' => $id . $_FILES['image']['name'],
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
        <div class="registros container-contact100 border rounded">
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
                        <input class="input100 form-control" type="text" name="title" id="title" maxlength="80" placeholder="Título del post" required>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="¡Descripción necesaria!">
                        <textarea class="input100 form-control" name="subject" id="post" rows="8" cols="50" maxlength="500" placeholder="Escribe aquí la descripción del post" required></textarea>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="">
                        <label class=" input100 col-sm-2 col-form-label">Imagen</label>
                        <input class="form-control" type="file" name="image" id="image" required><br>
                    </div>


                    <div class="mb-2">
                        <label class=" input100  col-sm-2 col-form-label">Categoría</label>
                        <select class="form-control" name="category" id="category">
                            <?php foreach ($categorie as $output) { ?>
                                <option value="<?php echo $output["cat_id"] ?>"><?php echo $output["cat_name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <input type="submit" value="Crear nuevo hilo" button type="button" class="btn btn-reg btn-lg btn-block">
                    <input type="reset" value="Limpiar campos" button type="button" class="btn btn-secondary btn-lg btn-block"><br>
                </form>
            </div>
        </div>

        <?php
    } //fin create_topic

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
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
                    $check = @getimagesize($_FILES['image']['tmp_name']);/*valida que sea una imagen y le da un nombre temporal*/
                    if ($check !== false) {
                        $folder = "../img/categorie/";/*para local*/
                        //$folder = 'https://apps.cualtos.udg.mx/app/tablon/resources/img/uploads/'; /*para servidor*/
                        $archivo = $folder . $_FILES['image']['name']; //topic_id//image campo de form //name nombre del archivo
                        move_uploaded_file($_FILES['image']['tmp_name'], $archivo); //obtiene la imagen y la pone en esa ruta con su nombre

                        #validación nombre de categoria no se repita# 
                        $buscarCat = $this->connect()->prepare("SELECT * FROM categories WHERE cat_name = '$_POST[title]'"); //preparamos la consulta a la BD
                        $buscarCat->execute();
                        $count = $buscarCat->rowCount();

                        /*validamos no se repita la categoria*/
                        if ($count == 1) { ?>
                            <script type="text/javascript">
                                alert("¡ERROR! \n¡La categoría ya existe! \n Por favor cree una diferente");
                            </script>
                        <?php
                        } else {
                            #ingresamos los datos si no se repite la cat
                            $state = $this->connect()->prepare('INSERT INTO categories (cat_name, cat_description, cat_image) VALUES (:title, :subject, :image)');/*preparamos las variables para pasar los archivos a la BD*/
                            /*Ejecutamos state para ingresar mediante POST los datos*/
                            $state->execute(array(
                                ':title' => $_POST['title'],
                                ':subject' => $_POST['subject'],
                                ':image' => $_FILES['image']['name'],
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

    /* Función 9 -Para crear un comentario en donde sea-*/
    public function create_reply()
    {
        //Consultar el id del ultimo reply para renombrar el nuevo
        $consulta = $this->connect()->prepare('SELECT reply_id FROM replies order by reply_id desc limit 1');
        $consulta->execute();
        /*concatenamos y pasamos a una variable numerica*/
        $save_id = $consulta->fetchAll();
        $id = $save_id[0]["reply_id"] + 1; //sumamos 1 para que tenga el id del reply nuevo
        /*validación si no hay replies creados*/
        if ($id == null) {
            $id = 0;
        }
        /*pide acceso al servidor y despues valida que no esten vacios*/
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
            $check = @getimagesize($_FILES['image']['tmp_name']);/*valida que sea una imagen y le da un nombre temporal*/
            /*If existe imagen en el comentario*/
            if ($check !== false) {
                $folder = '../img/uploads/coments/'; //ruta donde se guardan los archivos/*para local*/
                //$folder = 'https://apps.cualtos.udg.mx/app/tablon/resources/img/uploads/'; /*para servidor*/
                $archivo = $folder . $id . $_FILES['image']['name']; //reply_id//image campo de form// name nombre del archivo
                move_uploaded_file($_FILES['image']['tmp_name'], $archivo); //obtiene la imagen y la pone en esa ruta con su nombre

                /*Consulta para insertar los datos*/
                $state = $this->connect()->prepare('INSERT INTO replies (reply_content, reply_image, reply_topic, reply_by) VALUES (:content, :image, :topic, :by)'); //preparamos las variables para pasar los archivos a la BD
                /*Ejecutamos state para ingresar mediante POST los datos*/
                if (isset($_SESSION['acceso'])) { //if existe un usuario logueado
                    $state->execute(array(
                        ':content' => $_POST['content'],
                        ':image' => $id . $_FILES['image']['name'],
                        ':topic' => $_SESSION["topic_id"],
                        'by' => $_SESSION['id']
                    ));
                } else { //no existe usuario logueado
                    $state->execute(array(
                        ':content' => $_POST['content'],
                        ':image' => $id . $_FILES['image']['name'],
                        ':topic' => $_SESSION["topic_id"],
                        'by' => 6
                    ));
                }
            ?>
                <!--Mensaje flotante para correcto-->
                <script type="text/javascript">
                    Swal.fire({
                        icon: 'success',
                        title: '¡Comentario Creado!',
                        footer: '<a href="">Recargar.</a>',
                        showConfirmButton: false,
                        timer: 5500
                    })
                </script>
                <?php
                /*else if no existe imagen en el comentario*/
            } else if ($check == false) {
                /*if no existe texto ni imagen*/
                if (empty($_POST['content'])) {
                ?>
                    <!--Mensaje flotante para error campo texto vacio-->
                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'error',
                            title: '¡No hay texto!',
                            text: 'Tu comentario debe contener texto, opcionalmente puedes añadir una imagen.',
                            footer: '<a href="">Recargar.</a>',
                            showConfirmButton: true,
                            timer: 5500
                        })
                    </script>
                <?php
                    /*else existe al menos texto en el comentario*/
                } else {
                    /*Consulta para insertar el texto a la bd*/
                    $state = $this->connect()->prepare('INSERT INTO replies (reply_content, reply_topic, reply_by) VALUES (:content, :topic, :by)');/*preparamos las variables para pasar los archivos a la BD*/
                    /*Ejecutamos state para ingresar mediante POST los datos*/
                    if (isset($_SESSION['acceso'])) { //user logueado
                        $state->execute(array(
                            ':content' => $_POST['content'],
                            ':topic' => $_SESSION["topic_id"],
                            'by' => $_SESSION['id']
                        ));
                    } else {
                        $state->execute(array( //user anonimo
                            ':content' => $_POST['content'],
                            ':topic' => $_SESSION["topic_id"],
                            'by' => 6
                        ));
                    }
                ?>
                    <!--Mensaje flotante para correcto-->
                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'success',
                            title: '¡Comentario Creado!',
                            footer: '<a href="">Recargar.</a>',
                            showConfirmButton: false,
                            timer: 5500
                        })
                    </script>
        <?php
                }
            }
        } ?>

        <form class="mt-2 p-1" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Escribe un comentario..." name="content">
                <small class="form-text text-muted m-2">Recuerda ser respetuoso.</small>
                <div class="btn-group m-2 p-2">
                    <label class="btn btn-file  form-control border-secondary">
                        <i class="mr-1 fas fa-camera"></i>
                        <input type="file" hidden name="image">
                    </label>
                    <input type="submit" value="Comentar" class="btn btn-reg form-control" style="color:white">
                </div>
            </div>
        </form>

    <?php
    } //fin create_reply
}//fin upload
    ?>