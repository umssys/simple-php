<?phpclass administrarTaquillaController {    private $m;    private $post;    private $response;    private $validateMessage;    function __construct($active = FALSE, $accion) {        $active ? true : die('ACCESS DENIED');        $className = (string) __CLASS__;        $className = str_replace("Controller", "Model", $className);        $this->m = new $className(true);        $this->post = $_POST;        $this->$accion();    }    public function consultar() {        $this->m->consultar($this->post);                return $this->Response();    }    public function guardar() {        if (!$this->validar()) {            $this->response = $this->validateMessage;            return $this->Response();        }        $this->m->guardar($this->post);        return $this->Response();    }    public function editar() {        if (!$this->validar()) {            $this->response = $this->validateMessage;            return $this->Response();        }        $res = $this->m->editar($this->post);        return $this->Response();    }    public function borrar() {        $res = $this->m->borrar($this->post);        return $this->Response();    }    private function validar() {        $data = $this->post;        if (!isset($data['id'])) {            $this->validateMessage = "No se ha enviado el formulario";            return false;        }        if ($data['sucursal'] === "") {            $this->validateMessage = "Debe asignar un nombre de sucursal";            return false;        }        if ($data['nombre'] === "" || $data['apellido'] === "") {            $this->validateMessage = "Debe asignar un nombre de responsable";            return false;        }        if ($data['telefono'] === "" && $data['celular'] === "") {            $this->validateMessage = "Debe escribir un teléfono de contacto, teléfono o celular";            return false;        }        return true;    }    private function Response($type = null) {        if (!$type){            $type = $this->m->getResult()['type'];        }        if (!$this->response){            $this->response = $this->m->getResult()['output'];        }        $response = [            "returned" => $type,            "content" => $this->response        ];        echo json_encode($response);    }}