<?php
/*en este doc se valida que exista el usuario en la bd*/
include_once '../connect/functions.php';

class User extends DB{
    /*función para comprobar que existe el usuario*/
    public function userExists($user, $pass){
        $pass = $pass;//variable para transformar a hash el pass y compararlo con la tabla 

        $query = $this->connect()->prepare('SELECT * FROM users WHERE user_name = :user AND user_pass = :pass');//este prepare sirve para hacer una consulta a la DB
        $query->execute(['user' => $user, 'pass' => $pass]);//ejecutamos el query y pasamos los valores de las variables temporales a las variables locales
       
    
        /*validación del login*/
        if($query->rowCount()){//si hay fila
            return true;
        }else{//si no hay filas
            return false;
        }
    }
}

?>