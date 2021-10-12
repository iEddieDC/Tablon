<?php
require 'config.php';
class DB
{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;
    public $Id, $Ip, $Data, $Hora, $Limite;

    public function __construct()
    {
        #para las visi tas
        $this->Id = 0;
        $this->Ip = $_SERVER['REMOTE_ADDR'];
        $this->Data = date("Y/m/d");
        $this->Hora = date("H:i");
        $this->Limite = 50; //tiempo limite para el registro de ip
        #para la conexion
        $this->host     = 'localhost';
        $this->db       = 'tablon';
        /*para local*/
        $this->user     = 'root';
        $this->password = "root";
        /*para pagina*/
       //$this->user     = 'tablon';
        //$this->password = "nVasM0&fLc";

        $this->charset  = 'utf8mb4';
    }

    function connect()
    {

        try {

            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($connection, $this->user, $this->password, $options);

            return $pdo;
        } catch (PDOException $e) {
            print_r('Error connection: ' . $e->getMessage());
        }
    }
}
