<?php
require_once '../config/consulta.php';

$reply = new Topics(); //instanciar objeto


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Replies</title>
    <!--CSS bootstrap-->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>resources/bootstrap/css/bootstrap.min.css">
    <!--CSS personalizados-->
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL ?>resources/style/Colors.css">
</head>
<main class="container p-4 shadow">
    <?php $reply->view_coments(); ?>
</main>
</body>

</html>