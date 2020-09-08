<?php 
require_once '../config/consulta.php';

$reply = new Topics();//instanciar objeto
    

?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Replies</title>
    </head>
    <body>
    <?php $reply -> view_coments();?>
    </body>
    </html>