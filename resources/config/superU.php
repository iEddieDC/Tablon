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
        ?><input type="submit" class="btn btn-primary borrado" value="Borrar"></input><?php
        foreach ($consulta as $topic) : ?>
            <div class="form-check">
                <input class="form-check-input select" type="checkbox" value="" id="<?php echo $topic[0]; //id ?>" />
                <label class="form-check-label" for="flexCheckDefault">
                    <?php echo $topic[0]; //id ?>
                    <a href="topic/<?php echo $topic[0] ?>">
                        <?php echo $topic[1]; //nombre publicacion?>
                    </a>
                    <?php echo $topic[2]; //fecha?>
                    <?php echo $topic[3]; //id user?>
                    <?php echo $topic[4]; //nombre user?>
                </label>
            </div>
             
<?php endforeach;
    }
}

?>