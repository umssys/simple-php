<?php

class Controller {

    private $Modules;
    private $rootDir;
    private $hostName;

    function __construct() {
        date_default_timezone_set('America/Bogota');
        $this->rootDir = __DIR__ . '/../../';
        $this->hostName = $_SERVER['SERVER_NAME'];
        $this->Modules = $this->getModules();
        session_start();
    }

    public function cargarPagina() {
        if ($this->validarSesion()) {
            echo $this->cargarHTML();
        } else {
            echo $this->cargarLogin();
        }
    }

    private function validarSesion() {
        return true;
        $taquilla = isset($_SESSION['taquilla_id']) ? $_SESSION['taquilla_id'] : null;
        if (!$taquilla || $taquilla === '') {
            return false;
        }
        return true;
    }

    private function cargarHTML() {
        $archivo = end($this->Modules);
        $mod = null;
        foreach ($this->Modules as $r) {
            $mod .= '/' . $r;
        }
        $pageContent = file_get_contents($this->rootDir . 'app/view/masterpage.html');
        $modulePath = 'app/view/forma' . $mod . '/' . $archivo . '.html';
        $moduleContent = null;
        if (\file_exists($modulePath)) {
            $moduleContent = file_get_contents($modulePath);
        } else {
            header('HTTP/1.1 404 Not Found');           
            echo file_get_contents('public/error-404.html');
            return false;
        }
        $menu = file_get_contents($this->rootDir . 'app/view/assets/menu.admin.html');
        $render = str_replace(['##MENUPRINCIPAL##', '##CONTENIDOS##', '##MODULO##', '##MODULOJS##', '##HOSTNAME##'], [$menu, $moduleContent, $archivo, $mod, $this->hostName], $pageContent);
        return $render;
    }

    private function cargarLogin($ms) {
        $archivo = $ms;
        $mod = $ms;
        if (strpos($ms, '/')) {
            $submodulo = substr($ms, strpos($ms, '/') + 1);
            $archivo = substr($ms, 0, strpos($ms, '/'));
            $archivo = 'modulo/' . $submodulo . '/' . substr($ms, strpos($ms, '/') + 1);
            $mod = substr($ms, 0, strpos($ms, '/'));
        }
        $pageContent = file_get_contents('app/view/pagmaestra.html');
        $moduleContent = file_get_contents('app/view/forma/inicio/login.html');
        $render = str_replace(['##CONTENIDOS##', '##MODULO##', '##MODULOJS##'], [$moduleContent, $archivo, $mod], $pageContent);
        return $render;
    }

    public function cerrarCesion() {
        unset($_SESSION['taquilla_id']);
        header('Location: /');
        return true;
    }

    private function getModules() {
        $requestUri = substr($_SERVER['REQUEST_URI'], 1);
        $modules = explode('/', $requestUri);
        if ($modules && $modules[0] === '') {
            $modules = ['inicio'];
        }
        return $modules;
    }

    public function startProcess() {
        $path = '';
        foreach ($this->Modules as $rowPath) {
            $path .= $rowPath !== 'index.php' ? '/' . $rowPath : '';
        }
        $module = $path . '/' . $_POST['modulo'];
        $accion = $_POST['accion'];
        require "app/controller/modules" . $module . '/' . $_POST['modulo'] . "Controller.php";
        require "app/controller/modules" . $module . '/' . $_POST['modulo'] . "Model.php";
        $clase = $_POST['modulo'] . "Controller";
        new $clase(true, $accion);
    }

}
