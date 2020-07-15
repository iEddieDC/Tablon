<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <link rel="stylesheet" href="../css/Main.css">
</head>
<body>
<?php include 'header.php';?>
    <header><h3>Crear una nueva categoría</h3></header>
    <div id="formulario">
    <form action="" method="post">
        <div class="DivHijo">
         <label>TÍTULO</label>
            <input type="text" name="title" id="title" placeholder="Título de la categoría" require><br>
         </div>
         <div class="DivHijo">
        <label>DESCRIPCIÓN</label>
        <textarea name="desc" id="post" rows="8" cols="20" maxlength="120" placeholder="Escribe aquí la descripción de la categoría" require></textarea><br>
        </div>
        <input type="submit" value="Crear" class="boton">
        <input type="reset" value="Limpiar campos" class="boton"><br>
    </form>
    </div>
</body>
</html>
<?php include 'footer.php';?>
<?php include 'upload.php';?>