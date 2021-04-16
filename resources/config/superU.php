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
        $consulta->execute();
    ?><form method="post">
            <div class="container bg-light rounded ">
                <div class="row">
                    <div class="col-sm">
                        ID de hilo
                    </div>
                    <div class="col-sm">
                        Nombre hilo
                    </div>
                    <div class="col-sm">
                        Fecha de publicación
                    </div>
                    <div class="col-sm">
                        Id usuario
                    </div>
                    <div class="col-sm">
                        Nombre usuario
                    </div>
                    <div class="col-sm">
                        Seleccionar
                    </div>
                </div>
            </div>
            <?php
            foreach ($consulta as $topic) : ?>
                <div class="container mt-3">
                <div class="row">
                    <div class="col-sm">
                        <?php echo $topic[0]; //id ?>
                    </div>
                    <div class="col-sm">
                        <a href="topic/<?php echo $topic[0] ?>">
                            <?php echo $topic[1]; //nombre publicacion
                        ?>
                        </a>
                    </div>
                    <div class="col-sm">
                        <?php echo $topic[2]; //fecha?>
                    </div>
                    <div class="col-sm">
                        <?php echo $topic[3]; //id user?>
                    </div>
                    <div class="col-sm">
                        <?php echo $topic[4]; //nombre user?>
                    </div>
                    <div class="col-sm">
                        <input type="checkbox" name="eliminar[]" value="<?php echo $topic["topic_id"]; //id  ?>" />
                    </div>
                </div>
            </div>
            
            <hr>
            <?php endforeach;
            ?>
            <input type="submit" name="borrar" class="btn btn-danger" value="Borrar publicaciones"></input>
            <button class="btn btn-primary ">Refrescar</button>
        </form>
<?php
        /*funcion borrar elementos seleccionados*/
        if (isset($_POST['borrar'])) {
            //mensaje sin seleccion
            if (empty($_POST['eliminar'])) {
                echo '<h3>¡No se ha seleccionado ningún registro!</h3>';
            } else {
                foreach ($_POST['eliminar'] as $id_borrar) {
                    $borrarPublicacion = $this->connect()->prepare("DELETE from topics where topic_id = '$id_borrar'");
                    $borrarPublicacion->execute();
                }
            }
        }
    }
}
?>