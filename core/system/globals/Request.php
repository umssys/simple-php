<?php
namespace core\system\globals;

class Request{
    
    private $s;
    
    function __construct($auth = false){
        $auth ? true : die('Access Denied');
        $this->fetch();
        //print_r($this->s);
    }
    private function fetch(){
        foreach($_REQUEST as $llave => $valor){
            $this->s[$llave]=$valor;
        }
    }
    public function leer($llave){
        return $this->s[$llave];
    }
    
    public function cargar($llave, $valor){
        $this->s=[$llave => $valor];
    }
    
    public function volcarLlaves(){
        return array_keys($this->s);
    }
}