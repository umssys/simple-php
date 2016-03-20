<?php
namespace app\General;

class modulos {
    public function registroModulos(){
        return [
            "inicio" => new \app\Controlador\inicioControl()
        ];
    } 
       
}
