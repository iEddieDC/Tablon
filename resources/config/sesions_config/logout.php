<?php
    #Esta función esta asignada a un botón (Cerrar sesión)
    session_start();
if($_SESSION['user']){	
    session_unset();
    session_destroy();
    unset($_SESSION);
	header("location: ../../../index.php");
}
else{
	header("location: ../../../index.php");
}
?>