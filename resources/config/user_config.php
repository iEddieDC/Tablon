<?php
/*En este archivo se realizan todas las consultas necesarias para el usuario*/

include_once 'connect/functions.php';

/*clase donde se realizaran las consultas*/
class User_pow extends DB {
    /*función para que el usuario acceda rapidamente a los hilos que  ha publicado*/
    public function mis_hilos(){
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