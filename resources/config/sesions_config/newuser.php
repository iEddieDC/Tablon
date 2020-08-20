<?php
include_once '../config/connect/functions.php';
class NewUser extends DB
{

    public function create_new_user()
    {
        #validación nombre de usuario#
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {   
            $buscarUsuario = $this->connect()->prepare("SELECT * FROM users
            WHERE user_name = '$_POST[username]'");//preparamos la consulta a la BD
            $buscarUsuario->execute();
            $count = $buscarUsuario->rowCount();

            #validación exista el email
            $buscarEmail = $this->connect()->prepare("SELECT * FROM users WHERE user_email = '$_POST[email]'");
            $buscarEmail->execute();
            $countE = $buscarEmail->rowCount();//rowcount cuenta si hay resultados

            /*si es IF el usuario ya existe, sino se registra*/
            if ($count == 1 ) {
                echo "<br />" . "El Nombre de Usuario ya existe." . "<br />";
                echo "Por favor escoga otro Nombre";
            } else if ($countE == 1){
                echo "<br />" . "El Email ya existe." . "<br />";
                echo "Por favor escoga otro Email";
            }else{
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
                if($registro){
                    ?>
                    <script type ="text/javascript">
                        alert("Se ha registrado un Usuario");
                    </script>
                    <?php 
                }else{
                    ?>
                    <script type ="text/javascript">
                        alert("Hubo algun error! Por favor registrese de nuevo!");
                    </script>
                    <?php 
                }
            }
        }

?>
        <script src="../js/functions.js"></script>
        <header>
            <h3>Crear un nuevo usuario</h3>
        </header>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
            <!--Este metodo sirve para mediante server mandarselo a si mismo-->
            <div class="DivHijo">
                <label>Nombre de usuario</label>
                <input type="text" name="username" id="username" placeholder="Ej: Usuario1725" maxlength="32" require><br>
            </div>

            <div class="DivHijo">
                <label>Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Escribe aquí tu contraseña" maxlength="8" require></textarea><br>
                <button class="btn btn-primary" type="button" onclick="mostrarContrasena()">Mostrar Contraseña</button>
            </div>

            <div class="DivHijo">
                <label>Correo Electronico</label>
                <input type="text" name="email" id="email" placeholder="Ej: correo@Outlook.com" require><br>
            </div>

            <input type="submit" value="Crear" class="boton">
            <input type="reset" value="Limpiar campos" class="boton"><br>
        </form>
<?php
    }
} //fin doc
?>