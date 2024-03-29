<?php
include_once '../connect/functions.php';
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new DB();
    $query = $db->connect()->prepare('SELECT * FROM users WHERE user_name = :username AND user_pass = :password');
    $query->execute(['username' => $username, 'password' => $password]);

    #comprueba que haya un login correcto y crea la sesión ademas de las variables SESSION
    if ($query->rowCount()) {
        session_start(); //genera una variable especial 
        $_SESSION['acceso'] = true; //por default, dura hasta que se cierra el navegador
        $_SESSION['user'] = $username; //paso a variable SESSION mi usuario
    }

    #Creamos una consulta para extraer el rol
    $row = $query->fetch(PDO::FETCH_NUM);
    if ($row == true) {
        $id = $row[0]; //[]numero de columna para ID de usuario
        $_SESSION['id'] = $id; //Pasa el id a la variable superglobal SESSION id
        $rol = $row[5]; //[]numero de columna para user_level
        $_SESSION['rol'] = $rol; //Pasa el numero de rol a la variable superglobal SESSION rol

        switch ($rol) {
            case 0: //Usuario normal
                echo "user";
                header("location: user_page");
                break;
            case 2: // Usuario Administrador
                echo "Admin";
                header("location: admin_config");
                break;
                #Nota: Se pueden añadir pestañas y acciones unicas para cada uno
            default:
            header ("location: login");
        }
    } else {
        # No existe el usuario
        header ("location: login");
        ?>
        <!--<script type="text/javascript">
            alert("Nombre de usuario y/o contraseña incorrecto");
        </script>-->
        <?php
        
        
    }
}
?>