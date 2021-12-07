<?php
/*En este archivo se realizan todas las consultas necesarias para el usuario*/

include_once 'connect/functions.php';

/*clase donde se realizaran las consultas*/
class User_pow extends DB
{
    /*función para que el user vea sus datos*/
    public function mis_datos()
    {
        /*datos de usuario*/
        $consulta = $this->connect()->prepare('SELECT * FROM users where user_id = :user');
        $consulta->execute(array(
            'user' => $_SESSION['id']
        ));
        $datos = $consulta->fetchAll();
        /*hilos creados*/
        $num_hilos = $this->connect()->prepare('SELECT * FROM `topics` WHERE topic_by = :user');
        $num_hilos->execute(array(
            'user' => $_SESSION['id']
        ));
        $hilos = $num_hilos->rowCount();
        /*comentarios realizados*/
        $num_comen = $this->connect()->prepare('SELECT * FROM replies WHERE reply_by = :user');
        $num_comen->execute(array(
            'user' => $_SESSION['id']
        ));
        $comentarios = $num_comen->rowCount();
?>
        <?php foreach ($datos as $user) : ?>
            <div class="container mt-5 mb-5">
                <div class="d-flex flex-row justify-content-between align-items-center p-5 bg-dark text-white">
                    <h3 class="display-5"><?php echo $user["user_name"] ?></h3><i><?php echo $user["user_email"] ?></i>
                </div>
                <div class="p-3 bg-black ">
                    <h5>Tus estadísticas</h5>
                </div>
                <div class="container text-white">
                    <div class="row">
                        <div class="p-3 col-sm bg-primary text-center ">
                            <h4><?php echo $hilos ?></h4>
                            <h6>Publicaciones</h6>
                        </div>

                        <div class="p-3 col-sm  bg-success text-center ">
                            <h4><?php echo $comentarios ?></h4>
                            <h6>Respuestas</h6>
                        </div>

                        <div class="p-3 col-sm bg-warning text-center skill-block">
                            <h4>80%</h4>
                            <h6>Ovaciones</h6>
                        </div>

                        <div class="p-3 col-sm bg-danger text-center skill-block">
                            <h4>75%</h4>
                            <h6>Reportes recibidos</h6>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php
    }

    /*función para que el usuario acceda rapidamente a los hilos que ha publicado*/
    public function mis_hilos()
    {
        $consulta = $this->connect()->prepare('SELECT * FROM `topics` WHERE topic_by = :user order by topic_date desc');
        $consulta->execute(array(
            'user' => $_SESSION['id']
        ));
        $user = $consulta->fetchAll();
    ?>
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
                        Seleccionar</p>
                    </div>
                </div>
            </div>
            <?php foreach ($user as $topic) : ?>
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
                            <p><?php echo $topic[4]; //nombre user
                                ?></p>
                        </div>
                        <div class="col-sm">
                            <input type="checkbox" name="topic[]" value="<?php echo $topic["topic_id"]; //id
                                                                            ?>" />
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary">Refrescar</button>
                <input type="submit" name="del_topic" class="btn btn-danger" value="Borrar publicaciones"></input>

        </form>

        <?php endforeach;


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
    }
?>