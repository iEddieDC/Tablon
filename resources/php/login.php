
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="../css/login.css"-->
    <link rel="stylesheet" href="resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <title>Login</title>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<?php include 'header.php';?>
<body>
    <header>
        <h3>Iniciar sesión</h3>
    </header>
    <div id="formulario">
    <form action="comprobarlogin" method="POST">
        <p>Nombre de usuario: <br>
        <input type="text" name="username"></p>
        <p>Password: <br>
        <input type="password" name="password"></p>
        <p class="center"><input type="submit" value="Iniciar Sesión"></p>
    </form>
    </div>
</body>
</html>
<?php include 'footer.php';?>