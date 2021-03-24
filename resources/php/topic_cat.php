<?php
//require_once '../config/consulta.php';
include_once '../config/connect/functions.php';

session_start();

if (isset($_SESSION['acceso'])) {
    #echo ($_SESSION['acceso']);
    ?>
    <div class="col-2 text-white border-danger bg-success rounded-top">
     <h7>En sesión: 
     <?php echo($_SESSION['user']);?>
     </h7>
</div>
     <?php 
} else {
    #mensaje o acciones sin sesion
}
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS Bootstrap-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <!--Javascript & Jquery Bootstrap-->
    <script src="<?php echo SERVERURL ?>/resources/js/likes.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo SERVERURL ?>/resources/bootstrap-4.5.2/js/bootstrap.min.js"></script>
    <!--CSS personalizado-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/style/main.css">
    <link rel="stylesheet" href="<?php echo SERVERURL ?>/resources/style/Colors.css">
</head>
<header class="mb-3">
<?php include "header_others.php"?>
</header>
<body class="container alfondo">
    <main class="border p-3 alfrente shadow">
    <script>$(".like").click(function(){
        var id = this.id;
        alert(id);
    });</script>
    <?php 
    
    class Topics extends DB{
    
    public function extraer_db(){
    /*Consulta para id de categoria*/
        $id = isset($_GET['q']) ? $_GET['q'] : false; //busca la cadena q para id y si no existe lo hace boolean false
        
        if (!$id) { //validacion del id
            header('Location: topics.php');
        }
        /*consulta para extraer los hilos de la categoria*/
        $state = $this->connect()->prepare('SELECT topic_id, topic_title, topic_image, topic_subject, topic_date, topic_by, user_name FROM topics,users WHERE topic_cat = :id AND topic_by = user_id order by topic_date desc LIMIT 12');
        $state->execute(array(
            ':id' => $id
        ));
        $resultado = $state->fetchAll();


        /*Paginación*/
        //numero de hilos por pagina
        $topic_x_page = 12;
        //Contar hilos de la base de datos
        $total_topics_bd = $state->rowCount();
        //echo $total_topics_bd;
        //dividir las paginas entre los articulos
        $pages = $total_topics_bd / $topic_x_page;
        //redondear el numero de paginas
        $pages = ceil($pages); 
        //echo $pages;
        
        $iniciar = ($_GET['page']-1)*$topic_x_page;
        //echo $iniciar;
    ?>
        
        <?php foreach ($resultado as $topic) : 
            /*contar los comentarios de cada publicacion*/
            $contar_comentarios = $this->connect()->prepare('SELECT * FROM replies WHERE reply_topic = :id ');
            $contar_comentarios->execute(array(
                ':id' => $topic['topic_id']
            ));
            $num_com = $contar_comentarios->rowCount();

            /*contar el numero de likes dependiendo de nuestro ID*/
            $contar_likes = $this->connect()->prepare('SELECT * FROM likes WHERE user = :user_id AND post = :topic_id');
            $contar_likes->execute(array(
                ':user_id' => $_SESSION['id'],
                ':topic_id' => $topic['topic_id']
            ));
            $cLikes = $contar_likes->rowCount();//
            
        ?>
        <!--Comienza HTML-->
        <!--foreach inicio -->
        <div class="container border-top rounded mb-3 shadow">
            <div class="card mt-3" >
                <div class="col-lg-12 my-5">
                <!-- construye un enlace con el id que se encuentre en la base de datos -->
                <a href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>">
                <!-- construye un enlace con la imagen que se encuentre en la base de datos -->
                    <img class="rounded float-left mr-2" style="width: 18rem;" src="<?php echo SERVERURL ?>resources/img/uploads/<?php echo $topic['topic_image'] ?>" />
                </a>
                <h4 class="font-weight-bold">
                    <?php echo $topic['topic_title'] ?>
                </h4>
                Publicado por 
                <a class="text-primary">
                <!--id del creador del post-->
                <?php echo $topic['user_name'] ?>
                </a>
                el dia
                <!--Fecha de publicación-->
                <?php echo $topic['topic_date'] ?>
                <p class="font-weight-bold">ID de hilo
                <!--id de publicación-->
                <a class="text-primary"><?php echo $topic['topic_id'] ?></a>
                </p>
                <hr>
                <div class="card-text">
                    <p><?php echo $topic['topic_subject'] ?></p>
                </div>
                </div>
            </div>
            <!--Seccion de likes y comentarios-->
            <div class="hl-section-likes">
                <!--si no hemos dado like se muestra vacio el corazón-->
                <?php if($cLikes == 0){?>
                    <div id="<?php echo $topic['topic_id']?>" class="like">
                    <a class ="btn btn-outline-primary m-3 p-2">
                        <?php echo $cLikes;?>
                        <img src="<?php echo SERVERURL ?>resources/img/icons/heart_no.png" alt="">
                    </a>
                    </div>
                <!--si ya dimos like, corazón rojo-->
                <?php }else{?>
                    <div id="<?php echo $topic['topic_id']?>" onClick="like();" class="like">
                    <a class ="btn btn-outline-primary m-3 p-2">
                        <?php echo $cLikes;?>
                        <img src="<?php echo SERVERURL ?>resources/img/icons/heart.png" alt="">
                    </a>
                    </div>
                <?php }?>
                <a class="btn btn-outline-primary m-3 p-2" href="<?php echo SERVERURL ?>topic/<?php echo $topic['topic_id'] ?>">
                    <?php echo $num_com;?>
                    <img src="<?php echo SERVERURL ?>resources/img/icons/coment.png" alt="" srcset="">
                </a><!-- construye un enlace con el id que se encuentre en la base de datos -->
            </div>
        </div>
        <?php endforeach ?>
        <!--Paginacion-->
        <nav aria-label="...">
            <ul class="pagination">
                
                <?php for($i=0; $i<$pages; $i++):?>
                <li class="page-item 
                <?php echo $_GET['page']==$i+1 ? 'active' : '' ?>">
                    <a class="page-link" 
                        href="topic_cat.php?q=<?php echo $id?>&page=<?php echo $i+1?>">
                     <?php echo $i+1?>
                    </a>
                </li>
                <?php endfor ?>
                
            </ul>
        </nav>
   <?php } }?>
   
   <?php $extraer = new Topics();//instanciar objeto
   $extraer->extraer_db(); ?>
    </main>
</body>
<footer class="mt-3">
    <?php include "footer.php"?>
</footer>
</html>