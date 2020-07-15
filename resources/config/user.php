<?php
/*en este doc se valida que exista el usuario en la bd*/
include_once 'functions.php';

class User extends DB{
    
    private $username;

    /*función para comprobar que existe el usuario*/
    public function userExists($user, $pass){
        $pass = $pass;//variable para transformar a md5 el pass y compararlo con la tabla (de momento no tengo un hash asi que esta normal.)

        $query = $this->connect()->prepare('SELECT * FROM users WHERE user_name = :user AND user_pass = :pass');//este prepare sirve para hacer una consulta a la DB
        $query->execute(['user' => $user, 'pass' => $pass]);//ejecutamos el query y pasamos los valores de las variables temporales a las variables locales

        /* en esta comprobación validamos que existan filas con los datos enviados*/
        /*validación del login*/
        if($query->rowCount()){//si hay filas
            return true;
        }else{//si no hay filas
            return false;
        }
    }

    /*asignar a un nombre de usuario las variables*/
    public function setUser($user){
        $query = $this->connect()->prepare('SELECT * FROM users WHERE user_name = :user');
        $query->execute(['user' => $user]);

        /*barrido*/
        foreach ($query as $currentUser){
            $this->username = $currentUser['user_name'];
        }
    }

}

?>