<?php

class ticketController {

    private $m;
    private $post;
    private $files;
    private $response;
    private $validateMessage;

    function __construct($active = FALSE, $accion) {
        $active ? true : die('ACCESS DENIED');
        $className = (string) __CLASS__;
        $className = str_replace("Controller", "Model", $className);
        $this->m = new $className(true);
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->$accion();
    }

    public function consultar() {
        $this->m->consultar($this->post);        
        return $this->Response();
    }
    

    private function Response($type = null) {
        if (!$type){
            $type = $this->m->getResult()['type'];
        }
        if (!$this->response){
            $this->response = $this->m->getResult()['output'];
        }
        $response = [
            "returned" => $type,
            "content" => $this->response
        ];
        echo json_encode($response);
    }
    
    

}
