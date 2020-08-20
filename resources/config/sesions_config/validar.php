<?php
#aqui se llaman a las funciones que validan que el usuario exista y se crea la sesion
include_once '../connect/functions.php';
include_once 'user.php';

class sesion extends DB
{
    public function ses()
    {
        $user = new User();
        if (isset($_SESSION['acceso'])) {
            echo "hay sesion";
            echo $_SESSION['user'];
        } else if (isset($_POST['username']) && isset($_POST['password'])) { #SI existe un POST de formulario y no hay sesion iniciada
            #pasamos USERNAME y PASSWORD de post a variables
            $userForm = $_POST['username'];
            $passForm = $_POST['password'];
            if ($user->userExists($userForm, $passForm)) {
                echo "Bienvenido $userForm"; //imprimimos el nombre de usuario.
                $user->setUser($userForm);
                session_start(); //genera una cookie especial 
                $_SESSION['acceso'] = 1; //por default, dura hasta que se cierra el navegador
               # echo "<h1>Acceso correcto</h1>";
                #echo $_SESSION['acceso'];
                #echo "variable viva";
                $_SESSION['user'] = $_POST['username'];
                header("location: ../../../index.php");
            } else {
                echo "No existe el usuario";
                $errorLogin = "Nombre de usuario y/o password incorrecto";
                header("location: ../../php/login.php");
            }
        }else{
            //echo "login";
            header("location: ../../php/login.php");
        }
    }
}
