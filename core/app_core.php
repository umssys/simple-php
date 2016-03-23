<?php

namespace core;

session_start();

use core\system\Compilador;

abstract class app_core extends Compilador {

    function __construct($auth = false) {
        $auth ? true : die('Access Denied');
        parent::__construct(true);
    }

    protected function iniciarModulo($modulo) {        
        $modulos=[
            "Inicio" => "app\\Controlador\\Inicio\\inicioControl"
        ];
        $moduloCarga = @$modulos[$modulo] ? $modulos[$modulo] : die('Access Denied');
        return $moduloCarga;
    }

}
