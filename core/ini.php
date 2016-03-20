<?php

namespace General;

class ini{

    function __construct() {
        $this->registrarClases();
    }

    private function registrarClases() {
        //print_r($_SERVER['REQUEST_URI']);
        spl_autoload_register(function($className) {
            if (!file_exists($className . ".php")) {
                throw new \Exception("La clase " . $className . " no pudo ser encontrada");
            }
            include $className . ".php";
        });
        return true;
    }

}
