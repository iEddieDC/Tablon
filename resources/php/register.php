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

    <!--CSS bootstrap-->
    <link rel="stylesheet" href="resources/bootstrap-4.5.2/css/bootstrap.min.css">
    <!---Javascript & Jquery-->
    <script src="resources/js/bs4-form-validation.min.js"></script>
    <script src="resources/js/jquery-3.2.1.min.js"></script>
    <script src="resources/js/functions.js"></script>
    <script src="resources/bootstrap-4.5.2/js/bootstrap.min.js"></script>
    <!--alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!--CSS personalizados-->
    <link rel="stylesheet" type="text/css" href="resources/style/Colors.css">
    <link rel="stylesheet" type="text/css" href="resources/style/main.css">
</head>
<header class="mb-3">
    <?php include 'header.php'; ?>
</header>

<body class="container alfondo">
    <main class="rounded shadow">
        <!--Llamamos a la función para registrar los datos del Form-->
        <?php $newuser->create_new_user(); ?>
        <!--Inicializo bs4 validacion de formulario-->
        <script>
            let form = new Validation("register-form");
        </script>

        <!--Formulario para registrase-->
        <div id="register-form" class="container-contact100">
            <div class="wrap-contact100">
                <span class="contact100-form-symbol">
                    <img src="resources/img/icons/user-plus.png" alt="SYMBOL-MAIL">
                </span>
                <!--Mediante action se lo enviamos a si mismo-->
                <form class="contact100-form flex-sb flex-w" action="register" method="post" enctype="multipart/form-data">

                    <span class="contact100-form-title">
                        Registrarse
                    </span>

                    <label class=" input100 col-sm-2 col-form-label">Usuario</label>
                    <div class="wrap-input100  validate-input">
                        <input class="input100 form-control" type="text" name="username" id="username" placeholder="Ej: Usuario1725" maxlength="32" minlength="4" required>
                        <span class="focus-input100"></span>
                    </div>

                    <label>Contraseña</label>
                    <div class="wrap-input100 validate-input">
                        <input class="input100 form-control" type="password" name="password" id="password" placeholder="Contraseña" maxlength="32" minlength="6" required>
                        <span class="focus-input100"></span>
                        <span class="espacio">No debe contener espacios</span>
                        <span class="vacio">No debe quedar vacío</span>
                    </div>
                    <label>Confirma Contraseña</label>
                    <div class="wrap-input100 validate-input">
                        <input class="input100 form-control" type="password" name="password2" id="password2" placeholder="Contraseña" maxlength="32" minlength="6" required>
                        <span class="no alert-danger">¡No coinciden las contraseñas!</span>
                        <span class="si  alert-success">Las contraseñas coinciden.</span>
                    </div>

                    <label>Correo Electronico</label>
                    <div class="wrap-input100 validate-input">
                        <input class="input100 form-control" type="text" name="email" id="email" placeholder="Ej: correo@Outlook.com" maxlength="255" required>
                        <span class="focus-input100"></span>
                    </div>
                    <!-- Button HTML (Modal) & Submit -->
                    <input type="submit" value="Crear" button type="button" class="btn btn-primary btn-lg btn-block">
                    <input type="reset" value="Limpiar campos" button type="button" class="btn btn-secondary btn-lg btn-block"><br>
                </form>
                <!--Validaciones de caracteres-->
                <script>
                    form.requireText("username", 3, 32, ["#", "!", "@", "$", "%", "&", "/", "(", ")"], [""]);
                    form.requireText("password", 6, 32, ["#", "!", "@", "$", "%", "&", "/", "(", ")"], [""]);
                    form.requireText("email", 6, 32, ["#", "!", "$", "%", "&", "/", "(", ")"], ["@", "."]);
                </script>
            </div>
        </div>
    </main>
</body>
<footer class="mt-3"><?php include 'footer.php'; ?></footer>
</html>
