<?php
require_once "../config/sesions_config/newuser.php";
$newuser = new NewUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar un usuario</title> 
    <link rel="stylesheet" href="resources/bootstrap-4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include 'header.php';?>
    <?php $newuser -> create_new_user(); ?>
</body>
</html>
<?php include 'footer.php';?>
