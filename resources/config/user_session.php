<?php
/*manejar la sesión*/
class UserSession{

        public function __construct(){//iniciamos la sesión*/
            session_start();
        }

        public function setCurrentUser($user){//Guardamos la sesión
            $_SESSION['user_name'] = $user;
        }
    
        public function getCurrentUser(){//Devolver la sesión
            return $_SESSION['user_name'];
        }
    
        public function closeSession(){//Cerrar la sesión
            session_unset();
            session_destroy();
        }
    }

?>