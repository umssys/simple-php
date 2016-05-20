<?phprequire "app/controlador/controlador.php";class index {    private $controlador;    function __construct() {        $this->controlador = new Controlador();        $this->execute();    }    private function execute() {                $method = $_SERVER['REQUEST_METHOD'];        switch ($method) {            case "GET":                $this->cargarPagina();                break;            case "POST":                $this->startProcess();                break;        }    }    private function cargarPagina() {        $this->controlador->cargarPagina();    }    private function startProcess() {                $modulo = $_POST['modulo'];        $accion = $_POST['accion'];        $clase = $modulo;        if (strpos($modulo, "_")) {            $moduloTmp = substr($modulo, 0, strpos($modulo, "_"));            $subModulo = substr($modulo, strpos($modulo, "_") + 1);            $subModulo = strtoupper($subModulo[0]) . substr($subModulo, 1);            $clase = $moduloTmp . $subModulo;            $modulo = $moduloTmp;        }        require "app/controlador/" . $modulo . "/" . $clase . "Controller.php";        require "app/controlador/" . $modulo . "/" . $clase . "Model.php";        $clase = $clase . "Controller";        new $clase(true, $accion);    }        }new index();