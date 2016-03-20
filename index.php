<?php

namespace General;

include "core/ini.php";

use app\Controlador\Controlador;

class index {

    function __construct() {
        new ini();
        $this->inicializarApp();
    }

    private function inicializarApp() {
        $C = new Controlador(true);
        $C->iniciarApp();
    }

}

new index;
