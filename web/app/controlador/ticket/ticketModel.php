<?php

require __DIR__ . "/../../data/db.php";

class ticketModel {

    private $result;
    private $primaryTable;

    function __construct($active) {
        $active ? true : die('ACCESS DENIED');
        $this->dbo = new db();
        $this->primaryTable = "ticket";
    }

    private $dbo;

    public function consultar($P) {
        if (isset($P['_conse']) && !is_numeric($P['_conse'])) {
            $this->setResult('Error al consultar el registro', 'error');
            return false;
        }
        $params = null;
        if (isset($P['params'])) {
            $params = json_decode($P['params']);
        }
        if (strlen($params->ticket_number) !== 17) {
            $this->setResult('El número de ticket no es válido', 'error');
            return false;
        }

        $consulta = "";
        switch ($P['tipo']) {
            case "ticket_info":
                $consulta = "select tk.id, tk.fechaRegistro as fecha, tq.sucursal as sucursal, tk.totalApuesta as valor, tk.numero as numero
                        from ticket tk
                        inner join taquilla tq on tk.taquilla_id = tq.id
                        where tk.numero = '" . $params->ticket_number . "'
                    ";
                break;
            case "apuesta_partido":
                $consulta = " 
                    select pa.id as apuesta, eq1.nombre as equipo_local, eq2.nombre as equipo_visita, eq3.nombre as equipo_apuesta
                    from apuesta ap
                    inner join partido pa on ap.partido_id = pa.id
                    inner join equipo eq1 on pa.equipo_local = eq1.id
                    inner join equipo eq2 on pa.equipo_visita = eq2.id inner join equipo eq3 on ap.equipo_id= eq3.id
                    inner join ticket tk on ap.ticket_id = tk.id
                    where tk.numero = '" . $params->ticket_number . "'
                    group by pa.id
                     ";
                break;
            case "apuesta_partido_parametros":
                $consulta = " 
                    select pa.id as apuesta, pp.parametro_nombre as descripcion, ap.valorGanar, ap.parametro_valor as factor, eq.nombre as equipo_apuesta,
                    IF(ap.equipo_lugar = 'L', pp.marca_local, pp.marca_visita) as marca
                    from apuesta ap
                    inner join partido pa on ap.partido_id = pa.id
                    inner join parametro_partido pp on ap.parametro_partido_id = pp.id
                    inner join ticket tk on ap.ticket_id = tk.id
                    inner join equipo eq on ap.equipo_id = eq.id
                    where tk.numero = '" . $params->ticket_number . "'
                    and ap.valorGanar > 0
                     ";
                //echo "parametros";
                break;
        }

        $this->dbo->conectar();
        $res = $this->dbo->consultar($consulta);
        $this->dbo->desconectar();
        if ($this->dbo->getError() === null) {
            $this->setResult($res, 'data');
        } else {
            $this->setResult("Ha ocurrido un error en la consulta", "error");
            return false;
        }
        return true;
    }

    public function guardar($P) {
        $nombre = strtoupper($P["nombre"]);
        $consulta = "insert into $this->primaryTable(nombre
                                            , imagen
                                            )
                              values('" . $nombre . "'
                                          , '" . $P["imagen"] . "'                                             
                                            )										
                                    ";
        $this->dbo->conectar();
        if (!$this->dbo->ejecutar($consulta)) {
            $this->setResult('Error al guardar el registro', 'error');
        } else {
            $this->setResult($this->dbo->getInsertedID(), 'id');
        }
        $this->dbo->desconectar();
        return true;
    }

    public function editar($P) {
        $nombre = strtoupper($P["nombre"]);
        if (!is_numeric($P['id'])) {
            $this->setResult('Error al editar el registro', 'error');
            return false;
        }
        $consulta = "update $this->primaryTable set nombre = '" . $nombre . "', imagen = '" . $P["imagen"] . "'
                                   
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
        if (!is_numeric($P['id'])) {
            $this->setResult('Error al borrar el registro', 'error');
            return false;
        }
        $consulta = "delete from $this->primaryTable where id= " . $P['id'];
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
