<?php 
include_once 'functions.php';
class ClassVisitas extends DB
{ 
    #Verifica que el usuario haya visitado recientemente el sitio
    public function VerificaUsuario()
    {
        $Select = $this->connect()->prepare('SELECT * FROM visitas WHERE Ip=:ip AND Data=:datas ORDER BY Id DESC');
        $Select->bindParam(":ip", $this->Ip, PDO::PARAM_STR);
        $Select->bindParam(":datas", $this->Data, PDO::PARAM_STR);
        $Select->execute();
        if ($Select->rowCount() == 0) {
            $this->ContandoVisitas();
        } else {
            $FSelect = $Select->fetch(PDO::FETCH_ASSOC);
            $HoraDB = strtotime($FSelect['Hora']);
            $HoraActual = strtotime($this->Hora);
            $HoraExtraer = $HoraActual - $HoraDB;

            if ($HoraExtraer > $this->Limite) {
                $this->ContandoVisitas();
            }
        }
        echo "Total de visitas: " . $Select->rowCount() . "";
    }

    #Inserta un visita en la BD
    private function ContandoVisitas()
    {
        $Select = $this->connect()->prepare('INSERT into visitas values (:id , :ip , :datas , :hora)');
        $Select->bindParam(":id", $this->Id, PDO::PARAM_STR);
        $Select->bindParam(":ip", $this->Ip, PDO::PARAM_STR);
        $Select->bindParam(":datas", $this->Data, PDO::PARAM_STR);
        $Select->bindParam(":hora", $this->Hora, PDO::PARAM_STR);
        $Select->execute();
    }
}
?>
