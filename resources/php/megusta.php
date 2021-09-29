<?php
require_once '../config/consulta.php';

$extraer = new Topics(); //instanciar objeto

session_start();


$postid = $_POST['id'];
$user = $_SESSION['id'];
echo "si llega";


$contar_likes = $this->connect()->prepare('SELECT * FROM likes WHERE user = :user_id AND post = :topic_id');
$contar_likes->execute(array(
    ':user_id' => $user,
    ':topic_id' => $postid
));
$cLikes = $contar_likes->rowCount();

/*si no le hemos dado like*/
if ($cLikes == 0) {
    /*insertamos el like a la tabla likes*/
    $insertLike = $this->connect()->prepare('INSERT INTO likes (user,post,fecha) VALUES (:user,:post, now()');
    $insertLike->execute(array(
        ':user' => $user,
        ':post' => $postid
    ));
    /*actualizamos la tabla topics con un like a la publicacion correspondiente*/
    $updatePub = $this->connect()->prepare('UPDATE topics SET topic_likes = topic_likes+1 WHERE topic_id = :post');
    $insertLike->execute(array(
        ':post' => $postid
    ));
    /*si ya le hemos dado like*/
} else {
    /*quitamos el like a la tabla likes*/
    $insertLike = $this->connect()->prepare('DELETE FROM likes WHERE user = :user AND post = :post');
    $insertLike->execute(array(
        ':user' => $user,
        ':post' => $postid
    ));
    /*actualizamos la tabla topics con un like menos a la publicacion correspondiente*/
    $updatePub = $this->connect()->prepare('UPDATE topics SET topic_likes = topic_likes-1 WHERE topic_id = :post');
    $insertLike->execute(array(
        ':post' => $postid
    ));
}

$contar = $this->connect()->prepare("SELECT likes FROM publicaciones WHERE id_pub = " . $post . "");
$cont->execute(array($contar));
$likes = $cont['likes'];

if ($count >= 1) {
    $megusta = "<i class='fa fa-thumbs-o-up'></i> Me gusta";
    $likes = " (" . $likes++ . ")";
} else {
    $megusta = "<i class='fa fa-thumbs-o-up'></i> No me gusta";
    $likes = " (" . $likes-- . ")";
}

$datos = array('likes' => $likes, 'text' => $megusta);

echo json_encode($datos);
