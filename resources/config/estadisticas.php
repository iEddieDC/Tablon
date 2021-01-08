<?php 
include_once 'connect/functions.php';
class ClassVisitas extends DB
{ 
    #Verifica que el usuario haya visitado recientemente el sitio
    public function VerificaUsuario()
    {
        //contador por ip
        $Select = $this->connect()->prepare('SELECT * FROM visitas WHERE Ip=:ip AND Data=:datas ORDER BY Id DESC');
        $Select->bindParam(":ip", $this->Ip, PDO::PARAM_STR);
        $Select->bindParam(":datas", $this->Data, PDO::PARAM_STR);
        $Select->execute();
        //contador global
        $SelectGlobal = $this->connect()->prepare('SELECT id FROM visitas');
        $SelectGlobal->execute();
        //Contador hoy
        $SelectDay = $this->connect()->prepare('SELECT * FROM visitas WHERE Data >= CURRENT_DATE() ');
        $SelectDay->execute();

        //si la ip no tiene visitas se agrega una, si no se cuenta el tiempo de permanencia y se agrega
        if ($Select->rowCount() == 0) {
            $this->InsertarVisitas();
        } else {
            $FSelect = $Select->fetch(PDO::FETCH_ASSOC);
            $HoraDB = strtotime($FSelect['Hora']);
            $HoraActual = strtotime($this->Hora);
            $HoraExtraer = $HoraActual - $HoraDB;
            if ($HoraExtraer > $this->Limite) {
                $this->InsertarVisitas();
            }
        }?>
        <IMG src="resources/img/icons/today.png">
        <?php
        echo "VISITAS HOY: " . $SelectDay -> rowCount() . "";
        echo "<br>";
        ?>
        <IMG src="resources/img/icons/earth.png">
        <?php
        echo "VISITAS GLOBALES: " . $SelectGlobal->rowCount() . ""; 
        echo "<br>";
        ?>
        <IMG src="resources/img/icons/user.png">
        <?php
        echo "TUS VISITAS: " . $Select->rowCount() . "";
    }

    #Inserta un visita en la BD
    private function InsertarVisitas()
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
