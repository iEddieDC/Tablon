<?php
include_once 'functions.php';
class NewUser extends DB
{
    
    public function create_new_user(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {   /*validación exista el nombre de usuario*/
        $buscarUsuario = $this->connect()->prepare("SELECT * FROM users
        WHERE user_name = '$_POST[username]'");
        $buscarUsuario->execute();
        $count = $buscarUsuario->rowCount();
         
        /*validación email*/
    /*if/else si es IF el usuario ya existe, sino se registra*/
    if ($count == 1) {
        echo "<br />". "El Nombre de Usuario ya existe." . "<br />";
        echo "Por favor escoga otro Nombre";
    }else{
        $form_pass = $_POST['password'];//para encriptar la contrasenia
        $hash = password_hash($form_pass, PASSWORD_BCRYPT);//hacemos hash a la contrasenia

        $state = $this->connect()->prepare('INSERT INTO users (user_name, user_pass, user_email) VALUES (:user, :pass, :email)');/*preparamos las variables para pasar los archivos a la BD*/
                /*Ejecutamos state para ingresar mediante POST los datos*/
                $state->execute(array(
                    ':user' => $_POST['username'],
                    ':pass' => $hash,
                    ':email' => $_POST['email']
                ));
                echo "Usuario creado con éxito";
        }
    }
    
    ?>
        <header>
            <h3>Crear un nuevo usuario</h3>
        </header>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
            <!--Este metodo sirve para mediante server mandarselo a si mismo-->
            <div class="DivHijo">
                <label>Nombre de usuario</label>
                <input type="text" name="username" id="username" placeholder="Ej: Juanito1725" maxlength="32" require><br>
            </div>

            <div class="DivHijo">
                <label>Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Escribe aquí la descripción del post" maxlength="8" require></textarea><br>
            </div>

            <div class="DivHijo">
                <label>Correo Electronico</label>
                <input type="text" name="email" id="email" placeholder="Ej: correo@dominio.com" require><br>
            </div>

            <input type="submit" value="Crear" class="boton">
            <input type="reset" value="Limpiar campos" class="boton"><br>
        </form>
<?php
    }
}//fin doc
?>