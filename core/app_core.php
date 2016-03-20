<?php

namespace core;

use app\Controlador\inicio;

session_start();

use core\system\Compilador;

abstract class app_core extends Compilador {

    function __construct($auth = false) {
        $auth ? true : die('Access Denied');
        parent::__construct(true);
    }

    protected function iniciarModulo($modulo) {
        $modulos=[
            "inicio" => "app\\Controlador\\inicio\\inicioControl"
        ];
        return $modulos[$modulo];
    }

}
