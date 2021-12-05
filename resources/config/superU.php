<?php
/*En este archivo se realizan todas las consultas necesarias para el administrador*/

include_once 'connect/functions.php';

/*clase donde se realizaran las consultas*/
class Admin_pow extends DB
{

    /*función 1 para extraer todos los hilos en forma de lista*/
    public function ver_hilos()
    {
        $consulta = $this->connect()->prepare('SELECT topic_id, topic_title, topic_date, topic_by, user_name FROM topics, users WHERE topic_by = user_id order by topic_date desc');
        $consulta->execute(); ?>
        <form method="post">
            <div class="container rounded border-bottom">
                <div class="row">
                    <div class="col-sm">
                        ID de hilo</p>
                    </div>
                    <div class="col-sm">
                        Nombre hilo</p>
                    </div>
                    <div class="col-sm">
                        Fecha de publicación</p>
                    </div>
                    <div class="col-sm">
                        Id usuario</p>
                    </div>
                    <div class="col-sm">
                        Nombre usuario</p>
                    </div>
                    <div class="col-sm">
                        Seleccionar</p>
                    </div>
                </div>
            </div>
            <?php foreach ($consulta as $topic) : ?>
                <div class="container mt-3 mb-3 border-bottom">
                    <div class="row mt-3 mb-3">
                        <div class="col-sm">
                        <p><?php echo $topic[0]; //id 
                            ?></p>
                        </div>
                        <div class="col-sm">
                            <a href="topic/<?php echo $topic[0] ?>">
                                <?php echo $topic[1]; //nombre publicacion
                                ?>
                            </a>
                        </div>
                        <div class="col-sm">
                        <p><?php echo $topic[2]; //fecha
                            ?></p>
                        </div>
                        <div class="col-sm">
                        <p><?php echo $topic[3]; //id user
                            ?></p>
                        </div>
                        <div class="col-sm">
                            <p><?php echo $topic[4]; //nombre user
                            ?></p>
                        </div>
                        <div class="col-sm">
                            <input type="checkbox" name="topic[]" value="<?php echo $topic["topic_id"]; //id
                                                                            ?>" />
                        </div>
                    </div>
                </div>


            <?php endforeach; ?>

            <button class="btn btn-primary">Refrescar</button>
            <input type="submit" name="del_topic" class="btn btn-danger" value="Borrar publicaciones"></input>

        </form>

        <?php
        /*funcion borrar elementos seleccionados*/
        if (isset($_POST['del_topic'])) {
            //mensaje sin seleccion
            if (empty($_POST['topic'])) {
        ?>

                <!--Mensaje flotante para Error-->
                <script type="text/javascript">
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: '¡Hilo no borrado, Por favor intente de nuevo!',
                        footer: '<a href="index.php">Volver al inicio</a>'
                    })
                </script>
                <?php
            } else {
                foreach ($_POST['topic'] as $id_borrar) {
                    $borrarPublicacion = $this->connect()->prepare("DELETE from topics where topic_id = '$id_borrar'");
                    $borrarPublicacion->execute();
                ?>
                    <!--Mensaje flotante para correcto-->
                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'success',
                            title: '¡Publicación borrada!',
                            footer: '<a href="">Recargar.</a>',
                            showConfirmButton: false,
                            timer: 5500
                        })
                    </script>
        <?php
                }
            }
        }
    }
    public function ver_cat()
    {
        $consulta = $this->connect()->prepare('SELECT * FROM categories');
        $consulta->execute(); ?>

        <form method="post">
            <div class="container rounded border-bottom">
                <div class="row">
                    <div class="col-sm">
                        <p>ID de hilo</p>
                    </div>
                    <div class="col-sm">
                        <p>Nombre hilo</p>
                    </div>
                    <div class="col-sm">
                        <p> Fecha de publicación</p>
                    </div>
                    <div class="col-sm">
                        <p>Id usuario</p>
                    </div>
                    <div class="col-sm">
                        <p>Nombre usuario</p>
                    </div>
                    <div class="col-sm">
                        <p>Seleccionar</p>
                    </div>
                </div>
            </div>
            <?php foreach ($consulta as $cat) : ?>
                <div class="container mt-3 mb-3 border-bottom">
                    <div class="row mt-3 mb-3">
                        <div class="col-sm">
                        <p><?php echo $cat['cat_id']; //id 
                            ?></p>
                        </div>
                        <div class="col-sm">
                            <a href="cat/<?php echo $cat[0] ?>">
                                <?php echo $cat['cat_name']; //nombre publicacion
                                ?>
                            </a>
                        </div>
                        <div class="col-sm">
                        <p><?php echo $cat['cat_description']; //fecha
                            ?></p>
                        </div>
                        <div class="col-sm">
                        <p><?php echo $cat['cat_image']; //id user
                            ?></p>
                        </div>
                        <div class="col-sm">
                        <p><?php echo $cat[4]; //nombre user
                            ?></p>
                        </div>
                        <div class="col-sm">
                            <input type="checkbox" name="eliminar[]" value="<?php echo $cat["cat_id"]; //id
                                                                            ?>" />
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
            <a class="btn btn-primary mx-auto" href="create-cat">Presione aquí para crear</a>
            <input type="submit" name="del_cat" class="btn btn-danger" value="Borrar categorias"></input>
        </form>
        <?php
        /*funcion borrar elementos seleccionados*/
        if (isset($_POST['del_cat'])) {
            //mensaje sin seleccion
            if (empty($_POST['eliminar'])) {
        ?>
                <!--Mensaje flotante para Error-->
                <script type="text/javascript">
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: '¡Categoria no borrada, Por favor intente de nuevo!',
                        footer: '<a href="index.php">Volver al inicio</a>'
                    })
                </script>
                <?php
            } else {
                foreach ($_POST['eliminar'] as $id_borrar) {
                    $borrarPublicacion = $this->connect()->prepare("DELETE from categories where cat_id = '$id_borrar'");
                    $borrarPublicacion->execute();
                ?>
                    <!--Mensaje flotante para correcto-->
                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'success',
                            title: '¡Categoria borrada!',
                            footer: '<a href="">Recargar.</a>',
                            showConfirmButton: false,
                            timer: 5500
                        })
                    </script>
<?php
                }
            }
        }
    }

    public function ascend()
    {
        /*Se extrae la lista de los usuarios*/
        $users = $this->connect()->prepare("SELECT * FROM users");
        $users->execute(); ?>
        <form method="post">
            <div class="container rounded border-bottom">
                <div class="row">
                    <div class="col-sm">
                        <p>ID de usuario</p>
                    </div>
                    <div class="col-sm">
                        <p>Nombre usuario</p>
                    </div>
                    <div class="col-sm">
                        <p>Nivel</p>
                    </div>
                    <div class="col-sm">
                        <p>Email</p>
                    </div>
                    <div class="col-sm">
                        <p>Fecha de registro</p>
                    </div>
                    <div class="col-sm">
                        <p>Seleccionar</p>
                    </div>
                </div>
            </div>
            <?php foreach ($users as $item) : ?>
                <div class="container mt-3 mb-3 border-bottom">
                    <div class="row mt-3 mb-3">
                        <div class="col-sm">
                            <p><?php echo $item['user_id']; //id 
                                ?></p>
                        </div>
                        <div class="col-sm">
                            <?php echo $item['user_name']; ?>
                        </div>
                        <div class="col-sm">
                            <p><?php echo $item['user_level']; //level
                                ?></p>
                        </div>
                        <div class="col-sm">
                            <p><?php echo $item['user_email']; //email
                                ?></p>
                        </div>
                        <div class="col-sm">
                            <p><?php echo $item['user_date']; //fecha
                                ?></p>
                        </div>
                        <div class="col-sm">
                            <input type="checkbox" name="seleccion[]" value="<?php echo $item["user_id"]; //id
                                                                                ?>" />
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <input type="submit" name="ascender" class="btn btn-primary mx-auto" value="Ascender a administrador">
            <input type="submit" name="borrar" class="btn btn-danger" value="Borrar usuario">
        </form>
        <?php
        /*funcion hacer administrador a usuario en los elementos seleccionados*/
        if (isset($_POST['ascender'])) {
            if (empty($_POST['seleccion'])) {
        ?>
                <!--Mensaje flotante para Error-->
                <script type="text/javascript">
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: '¡Ha ocurrido un error, Por favor intente de nuevo!',
                        footer: '<a href="index.php">Volver al inicio</a>'
                    })
                </script>
                <?php
            } else {
                foreach ($_POST['seleccion'] as $user_adm) {
                    $hacerAdm = $this->connect()->prepare("UPDATE users SET user_level='2' where user_id = '$user_adm'");
                    $hacerAdm->execute();
                ?>
                    <!--Mensaje flotante para correcto-->
                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'success',
                            title: '¡Usuario ascendido!',
                            footer: '<a href="">Recargar.</a>',
                            showConfirmButton: false,
                            timer: 5500
                        })
                    </script>
                <?php
                }
            }
        } else if (isset($_POST['borrar'])) { //borrar usuario
                
                if (empty($_POST['seleccion'])) {//mensaje sin seleccion
                ?>
                <!--Mensaje flotante para Error-->
                <script type="text/javascript">
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: '¡Usuario no borrado, Por favor intente de nuevo!',
                        footer: '<a href="index.php">Volver al inicio</a>'
                    })
                </script>
                <?php
                } else {
                    foreach ($_POST['seleccion'] as $id_borrar) {
                        $borraruser = $this->connect()->prepare("DELETE from users where user_id = '$id_borrar'");
                        $borraruser->execute();
                ?>
                    <!--Mensaje flotante para correcto-->
                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'success',
                            title: '¡Usuario borrado!',
                            footer: '<a href="">Recargar.</a>',
                            showConfirmButton: false,
                            timer: 5500
                        })
                    </script>
<?php
                    }
                }
            }
    }
}
?>