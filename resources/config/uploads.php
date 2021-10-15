<?php
/*Conexión a la BD mediante PDO//require once para que muera la conexión con este doc-*/
include_once '../config/connect/functions.php';

class Upload extends DB{
        /* Función 3 -Para crear un topic en donde sea-*/
            public function create_topic()
            {
                /*pide acceso al servidor y despues valida que no esten vacios*/
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
                    $check = @getimagesize($_FILES['image']['tmp_name']);/*valida que sea una imagen y le da un nombre temporal*/
                    if ($check !== false) {
                        //$folder = "../img/uploads/";/*para local*/
                        $folder = 'https://apps.cualtos.udg.mx/app/tablon/resources/img/uploads/'; /*para servidor*/
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
                                <label class=" input100  text-muted col-sm-2 col-form-label">Imagen</label>
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

                            <input type="submit" value="Crear nuevo hilo" class="btn btn-reg btn-lg btn-block">
                            <input type="reset" value="Limpiar campos" class="btn btn-secondary btn-lg btn-block"><br>
                        </form>
                    </div>
                </div>

            <?php
            } //fin create_topic
        }?>