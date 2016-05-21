<?php

require __DIR__ . "/../../data/db.php";

class administrarEquipoModel {

    private $result;
    private $primaryTable;

    function __construct($active) {
        $active ? true : die('ACCESS DENIED');
        $this->dbo = new db();
        $this->primaryTable = "equipo";
    }

    private $dbo;

    public function consultar($P) {
        if (isset($P['_conse']) && !is_numeric($P['_conse'])){
            $this->setResult('Error al consultar el registro', 'error');
            return false;
        }
        $consulta = "";
        switch ($P['tipo']) {
            case "activo":
                $consulta = "select pt.id, pt.nombre as nombre, pt.imagen, pt.descripcion, lg.nombre as liga "
                    . "from $this->primaryTable pt "
                    . "inner join liga lg on pt.liga_id = lg.id "
                    . "where pt.estado <> 'X' " 
                    . "order by lg.nombre, pt.nombre";
                break;
            case "formulario":
                $consulta = "select * from $this->primaryTable where id=" . $P['_conse'];
                break;
            case "liga":
                $consulta = "select id, nombre as html from liga where estado='A' order by nombre";
                break;
        }

        $this->dbo->conectar(); 
        $res = $this->dbo->consultar($consulta);
        $this->dbo->desconectar();
        if ($this->dbo->getError() === null){
            $this->setResult($res, 'data');
        }
        else {
            $this->setResult("Ha ocurrido un error en la consulta", "error");
            return false;
        }        
        return true;
    }

    public function guardar($P) {
        $consulta = "insert into $this->primaryTable(nombre
                                            ,imagen
                                            ,descripcion
                                            ,liga_id
                                            ,estado
                                            )
                              values('" . $P["nombre"] . "',
                                            '" . $P["imagen"] . "',
                                            '" . $P["descripcion"] . "' ,
                                            " . $P["liga_id"] . ",
                                            '" . $P["estado"] . "'
                                            )										
                                    ";
        $this->dbo->conectar();

        if (!$this->dbo->ejecutar($consulta)) {
            $this->setResult('Error al guardar el registro.', 'error');
        } else {
            $this->setResult($this->dbo->getInsertedID(), 'id');
        }
        $this->dbo->desconectar();
        return true;
    }

    public function editar($P) {
        if (!is_numeric($P['id'])){
            $this->setResult('Error al editar el registro', 'error');
            return false;
        }
        $consulta = "update $this->primaryTable set nombre = '" . $P['nombre'] . "'
                            ,imagen = '" . $P['imagen'] . "'
                            ,descripcion = '" . $P['descripcion'] . "'
                            ,liga_id = '" . $P['liga_id'] . "'
                            ,estado = '" . $P['estado'] . "'  
            where id= " . $P['id'] . "
                    ";

        $this->dbo->conectar();
        if (!$this->dbo->ejecutar($consulta)) {
            $this->setResult('Error al editar el registro', 'error');
        } else {
            $this->setResult($this->dbo->getInsertedID(), 'ok');
        }
        $this->dbo->desconectar();
        return true;
    }

    public function borrar($P) {
        if (!is_numeric($P['id'])){
            $this->setResult('Error al borrar el registro', 'error');
            return false;
        }
        $consulta = "update $this->primaryTable set estado = 'X'                            
            where id= " . $P['id'] . "
                    ";
        $this->dbo->conectar();
        if (!$this->dbo->ejecutar($consulta)) {
            $this->setResult('Error al borrar el registro', 'error');
        } else {
            $this->setResult($this->dbo->getInsertedID(), 'ok');
        }
        $this->dbo->desconectar();
    }

    public function setResult($output, $type = "message") {
        $this->result = [
            "type" => $type,
            "output" => $output
        ];
        return true;
    }

    public function getResult() {
        return $this->result;
    }

}