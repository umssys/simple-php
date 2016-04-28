<?php

require __DIR__ . "/../../data/db.php";

class administrarTorneoModel {

    private $result;
    private $primaryTable;

    function __construct($active) {
        $active ? true : die('ACCESS DENIED');
        $this->dbo = new db();
        $this->primaryTable = "torneo";
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
                $consulta = "select pt.id, lg.nombre as liga, eq.nombre as equipo "
                    . "from $this->primaryTable pt "
                    . "inner join liga lg on pt.liga_id = lg.id "
                    . "inner join equipo eq on eq.id = pt.equipo_id "                   
                    . "where pt.estado <> 'X' "
                    . "order by lg.nombre, eq.nombre";
                break;
            case "formulario":
                $consulta = "select * from $this->primaryTable where id=" . $P['_conse'];
                break;
            case "liga":
                $consulta = "select id, nombre as html from liga where estado = 'A' order by nombre";
                break;
            case "equipo":
                $consulta = "select id, nombre as html from equipo where estado = 'A' order by nombre";
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
        $consulta = "insert into $this->primaryTable(equipo_id
                                            ,liga_id
                                            ,estado
                                            )
                              values(       '" . $P["equipo_id"] . "',
                                            '" . $P["liga_id"] . "' ,
                                            'A'
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
        $consulta = "update $this->primaryTable set equipo_id = '" . $P['equipo_id'] . "'
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
