<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/nuevos.css">
    <title>Header</title>
</head>

<body>
    <div class="container-fluid navbar-inverse bg-primary">
        <nav class="navbar navbar-dark navbar-expand-md text-white bg-primary navigation-clean-search">
            <div class="container-fluid"><a class="navbar-brand" href="#"><h1>Cualtos Chan</h1></a>
                <button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav">
                        <li><a class="nav-link text-white" href="resources/php/upload.php">Crear un hilo</a></li>
                        <li><a class="nav-link text-white" href="resources/php/createcategory.php">Crear una categoría</a></li>
                        <li> <a class="nav-link text-white" href="resources/html/rules.html">Reglas</a>
                    </ul>
                    <form class="form-inline mr-auto" target="_self">
                        <div class="form-group"><label for="search-field"></label></div>
                    </form>
                    <span class="navbar-text "><a class="text-white login" href="resources/php/register.php">Registrarse</a></span>
                    <a class="btn btn-light action-button" role="button" href="resources/php/login.php">Iniciar sesión</a>
                    <span class="navbar-text "><a class="text-white login" href="resources/config/sesions_config/logout.php">Cerrar sesión</a></span>
                </div>
            </div>
        </nav>
    </div>
</body>

</html>