
<?php
include_once 'resources/config/user.php';
include_once 'resources/config/user_session.php';


$userSession = new UserSession();
$user = new User();

$estado = false; //Variable true o false para comprobar que haya sesión y realizar modificaciones
if(isset($_SESSION['user'])){
    //echo "hay sesion";
    $estado = true;
    $user->setUser($userSession->getCurrentUser());

}else if(isset($_POST['username']) && isset($_POST['password'])){
    
    $userForm = $_POST['username'];
    $passForm = $_POST['password'];

    
    if($user->userExists($userForm, $passForm)){
        echo "Bienvenido $userForm";//imprimimos el nombre de usuario.
        $userSession->setCurrentUser($userForm);//asignamos el nombre de usuario a la sesion actual
        $user->setUser($userForm);
    }else{
        //echo "No existe el usuario";
        $errorLogin = "Nombre de usuario y/o password incorrecto";
        include_once 'resources/php/login.php';
    }
}else{
    //echo "login";
    include_once 'resources/php/login.php';
}
?>