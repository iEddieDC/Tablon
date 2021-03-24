<?php
require_once '../config/consulta.php';

$extraer = new Topics();//instanciar objeto

session_start();


$postid = $_POST['id'];
$user = $_SESSION['id'];

$contar_likes = $this->connect()->prepare('SELECT * FROM likes WHERE user = :user_id AND post = :topic_id');
$contar_likes->execute(array(
    ':user_id' => $user,
    ':topic_id' => $postid
    ));
$cLikes = $contar_likes->rowCount();

/*si no le hemos dado like*/
if($cLikes == 0) {
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
}else{
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

/*imagenes de like*/
if($cLike == 0) {
    $megusta = "<img src='resources/img/icons/heart_no.png'>";
} else{
    $megusta = "<img src='resources/img/icons/heart.png'>";
}

$return = array("img"=>$megusta);

echo json_encode($return);