<?php

class administrarController {

    private $m;
    private $post;
    private $files;
    private $response;
    private $validateMessage;

    function __construct($active = FALSE, $accion) {
        $active ? true : die('ACCESS DENIED');
        $className = (string) __CLASS__;
        $className = str_replace("Controller", "Model", $className);
        
    }

    public function consultar() {
        $this->m->consultar($this->post);
        return $this->Response();
    }

    public function guardar() {
        if (!$this->validar()) {
            $this->response = $this->validateMessage;
        } else {
            $this->m->guardar($this->post);
        }        
        return $this->Response();
    }

    public function editar() {
        if (!$this->validar()) {
            $this->response = $this->validateMessage;            
        } else {
            $res = $this->m->editar($this->post);
        }        
        return $this->Response();
    }

    public function borrar() {
        $res = $this->m->borrar($this->post);
        return $this->Response();
    }

    private function validar() {
        $data = $this->post;
        if ($data['id'] !== "" && !is_numeric($data['id'])) {
            $this->validateMessage = "No se ha enviado el formulario";
            return false;
        }
        if ($data['liga_id'] === "" || !is_numeric($data['liga_id'])) {            
            $this->validateMessage = "Debe seleccionar una liga para el equipo, si no existe, diríjase al panel de Administración de paises y cree el apropiado";
            return false;
        }
        return true;
    }

    private function Response($type = null) {
        if (!$type) {
            $type = $this->m->getResult()['type'];
        }
        if (!$this->response) {
            $this->response = $this->m->getResult()['output'];
        }
        $response = [
            "returned" => $type,
            "content" => $this->response
        ];
        echo json_encode($response);
    }

    public function cargarArchivo() {
        $post=$this->post;
        $files=$this->files;
        $destino=$post['destino'];
        $uploaddir = '' . $destino;
        $pfx = $post['pfx'];
        $ext = explode('.', $files['userfile']['name']);
        $extension = $ext[1];
        $newname = $pfx . $ext[0];
        $uploadfile = $uploaddir . $newname . '.' . $extension;
        if (move_uploaded_file($files['userfile']['tmp_name'], $uploadfile)) {
            echo $newname . '.' . $extension;
        } else {
            echo "error";
        }
    }

}
