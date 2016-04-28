<?php

class db {

    private $link;
    
    private $error;

    public function conectar() {
        if ($_SERVER['SERVER_NAME'] === 'apuesta.jeus' || $_SERVER['SERVER_NAME'] === 'aviasymwww.com'){
            $this->link = mysqli_connect('localhost', 'apuesta_usr', 'Apuesta2016', 'apuesta_db', '3306');
        } else {
            $this->link = mysqli_connect('localhost', 'umssysco_apuesta', 'Apuesta2016', 'umssysco_apuesta', '3306');
        }
    }

    public function consultar($strConsulta = null) {
        if ($strConsulta === null || $strConsulta === "") {
            return false;
        }
        $res = mysqli_query($this->link, $strConsulta);
        if (!$res){
            $this->error = mysqli_error($this->link);
        }
        $response = array();
        while ($linea = mysqli_fetch_assoc($res)) {
            array_push($response, $linea);
        }
        return $response;
    }

    public function ejecutar($strConsulta = null) {
        if ($strConsulta === null || $strConsulta === "") {
            return false;
        }
        if (!$res = mysqli_query($this->link, $strConsulta)) {
            $this->error = mysqli_error($this->link);
            return false;
        }
        return true;
    }

    public function getInsertedID() {
        return mysqli_insert_id($this->link);
    }

    public function desconectar() {
        mysqli_close($this->link);
    }
    
    public function getError(){
        return $this->error;
    }

}
