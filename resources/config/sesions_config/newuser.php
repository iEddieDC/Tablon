<?php
include_once '../config/connect/functions.php';

class NewUser extends DB
{

    public function create_new_user()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            #validación nombre de usuario no se repita# 
            $buscarUsuario = $this->connect()->prepare("SELECT * FROM users
            WHERE user_name = '$_POST[username]'"); //preparamos la consulta a la BD
            $buscarUsuario->execute();
            $count = $buscarUsuario->rowCount();

            #validación no se repita el email
            $buscarEmail = $this->connect()->prepare("SELECT * FROM users WHERE user_email = '$_POST[email]'");
            $buscarEmail->execute();
            $countE = $buscarEmail->rowCount(); //rowcount cuenta si hay resultados

            /*Validaciones*/
            if ($count == 1) { //nombre de Usuario registrado
?>
                <script type="text/javascript">
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: '¡Nombre de usuario ocupado! Por favor escoja otro',
                        footer: '<a href="index.php">Volver al inicio</a>'
                    })
                </script>
            <?php
            } else if ($countE == 1) { //Email registrado
            ?>
                <script type="text/javascript">
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: '¡El correo electronico ya esta registrado!\nPor favor escoja otro.',
                        footer: '<a href="index.php">Volver al inicio</a>'
                    })
                </script>
                <?php
            } else {
                //$form_pass = $_POST['password'];//para encriptar la contrasenia
                // $hash = password_hash($form_pass, PASSWORD_BCRYPT);//hacemos hash a la contrasenia
                $registro = $this->connect()->prepare('INSERT INTO users (user_name, user_pass, user_email) VALUES (:user, :pass, :email)');/*preparamos las variables para pasar los archivos a la BD*/
                /*Ejecutamos state para ingresar mediante POST los datos*/
                $registro->execute(array(
                    ':user' => $_POST['username'],
                    //':pass' => $hash,
                    ':pass' => $_POST['password'],
                    ':email' => $_POST['email']
                ));
                #mensaje registro 
                if ($registro) {
                ?>
                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'success',
                            title: '¡Usuario nuevo registrado!',
                            footer: '<a href="login">Iniciar sesión</a>',
                            showConfirmButton: false,
                            timer: 5500
                        })
                    </script>
                <?php
                } else {
                ?>
                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: '¡Hubo algun error, Por favor registrese de nuevo!',
                            footer: '<a href="index.php">Volver al inicio</a>'
                        })
                    </script>
        <?php
                }
            }
        }

        ?>
        <!--Script validar contraseña-->



<?php
    }
} //fin doc
?>