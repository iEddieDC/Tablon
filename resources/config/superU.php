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
                            <input type="checkbox" name="eliminar[]" value="<?php echo $topic["topic_id"]; //id
                                                                            ?>" />
                        </div>
                    </div>
                </div>


            <?php endforeach; ?>

            <button class="btn btn-primary">Refrescar</button>
            <input type="submit" name="borrar" class="btn btn-danger" value="Borrar publicaciones"></input>

        </form>

        <?php
        /*funcion borrar elementos seleccionados*/
        if (isset($_POST['borrar'])) {
            //mensaje sin seleccion
            if (empty($_POST['eliminar'])) {
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
            } else {
                foreach ($_POST['eliminar'] as $id_borrar) {
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
            <input type="submit" name="borrar" class="btn btn-danger" value="Borrar categorias"></input>
        </form>
        <?php
        /*funcion borrar elementos seleccionados*/
        if (isset($_POST['borrar'])) {
            //mensaje sin seleccion
            if (empty($_POST['eliminar'])) {
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
}
?>