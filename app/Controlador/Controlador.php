<?php

namespace app\Controlador;

use core\app_core;

class Controlador extends app_core {
    
    public $router;
    
    
    public function __construct($auth = false) {
        $auth ? true : die('Access Denied');
        parent::__construct(true);
    }

    public function iniciarApp() {
        $RequestUri = substr($this->server->leer("REQUEST_URI"), 1);
        $moduloStr = substr($RequestUri, 0, strpos($RequestUri, '/'));
        empty($moduloStr) ? $moduloStr="Inicio" : $moduloStr;
        $this->cargarModulo($moduloStr);
    }

    private function cargarModulo($moduloStr) {
        $moduloPath=$this->iniciarModulo($moduloStr);
        $modulo=new $moduloPath($this);
        $archivoConf = $this->server->leer('DOCUMENT_ROOT') . '/app/Controlador/' . $moduloStr . '/Conf/Router.yml';
        
    }

    private function cargarHTML() {
        echo "<pre>";
        print_r($_SERVER);
        echo "</pre>";
        $RequestUri = substr($_SERVER['REQUEST_URI'], 1);
        $PaginaSolicitada = $RequestUri ? $RequestUri : "inicio";
        print_r($PaginaSolicitada);
        $pagina = file_get_contents('app/vista/pagmaestra.html');
        $modulo = file_get_contents('app/vista/forma/f.' . $PaginaSolicitada . '.html');
        $pagina = str_replace('##CONTENIDOS##', $modulo, $pagina);
        return $pagina;
    }

    private function leerRouter($Class =  null) {
        
    }

}
