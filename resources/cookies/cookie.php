<?php
class Cookie
{
    public function Cookie_total()
    {
        /*Aqui se almacenan las visitas totales a la pagina durante un año*/
        if (isset($_COOKIE['contador'])) { //verificamos que exista la cookie CONTADOR
            setcookie('contador', $_COOKIE['contador'] + 1, time() + 365 * 24 * 60 * 60); //le suma 1 
            echo "VISITAS TOTALES: " . $_COOKIE['contador']; //imprimimos el numero de visitas
        } else {
            setcookie('contador', 1, time() + 365 * 24 * 60 * 60); //le pasamos el valor a la cookie y le damos validez de un AÑO
            echo "¡Bienvenido eres el primer usuario de este año!";
        }
    }
    public function Cookie_dia()
    {
        /*Aqui se almacenan las visitas totales a la pagina durante un año*/
        if (isset($_COOKIE['contador2'])) { //verificamos que exista la cookie CONTADOR
            setcookie('contador2', $_COOKIE['contador2'] + 1, time() + 86400); //le suma 1 
            echo "HOY: " . $_COOKIE['contador2']; //imprimimos el numero de visitas
        } else {
            setcookie('contador2', 1, time() + 86400); //le pasamos el valor a la cookie y le damos validez de un dia
            echo "¡Bienvenido eres el primer usuario de este dia!";
        }
    }
}
