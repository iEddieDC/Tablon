<?php
/*en este doc se valida que exista el usuario en la bd*/
include_once '../connect/functions.php';

class User extends DB{
    /*función para comprobar que existe el usuario*/
    public function userExists($user, $pass){
        $pass = $pass;//variable para transformar a hash el pass y compararlo con la tabla 

        $query = $this->connect()->prepare('SELECT * FROM users WHERE user_name = :user AND user_pass = :pass');//este prepare sirve para hacer una consulta a la DB
        $query->execute(['user' => $user, 'pass' => $pass]);//ejecutamos el query y pasamos los valores de las variables temporales a las variables locales
        /* en esta comprobación validamos que existan los datos enviados*/
       
        /*validación del login*/
        if($query->rowCount()){//si hay filas
            return true;
        }else{//si no hay filas
            return false;
        }
    }

    /*Guardamos el nombre de usuario (Mediante esta consulta se toma el nombre de usuario para la bienvenida) */
    public function setUser($user){
        $query = $this->connect()->prepare('SELECT * FROM users WHERE user_name = :user');
        $query->execute([':user' => $user]);
        /*barrido*/
        foreach ($query as $currentUser){
            $this->username = $currentUser['user_name'];
        }
    }

}

?>