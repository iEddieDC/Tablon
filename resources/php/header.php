<?php 
require_once("./mainlogin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Header</title>
</head>
<body>
    <div class="NavBar">
        <ul id="Ulheader">
            <li style="float:left"><a href="">Reglas</a></li>
            <li style="float:left"><a href="">Preguntas frecuentes</a></li>
            <li style="float:left"><a href="resources/php/createcategory.php">Crear una categoría</a></li>
            <input type="search" id="search" placeholder="ID de hilo a buscar">
            <li style="float:right"><a href="resources/php/register.php">Registro</a></li>
            <?php
            if($estado==true){
                ?>
                <li style="float:right"><a href="resources/config/logout.php">Cerrar sesión</a></li>
                <?php
            }else{
                ?>
                <li style="float:right"><a href="mainlogin.php">Login</a></li>
                <?php
            }
            ?>
            
        </ul>
        
</div>
</body>
</html>