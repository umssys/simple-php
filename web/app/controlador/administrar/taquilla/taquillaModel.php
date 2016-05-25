<?phprequire $_SERVER['DOCUMENT_ROOT'] . "app/data/db.php";class taquillaModel {    private $result;    private $primaryTable;    function __construct($active) {        $active ? true : die('ACCESS DENIED');        $this->dbo = new db();        $this->primaryTable = "taquilla";    }    private $dbo;    public function consultar($P) {        if (isset($P['_conse']) && !is_numeric($P['_conse'])) {            $this->setResult('Error al consultar el registro', 'error');            return false;        }        $consulta = "";        switch ($P['tipo']) {            case "activo":                $consulta = "select id,sucursal, concat(nombre, ' ', apellido) as responsable, concat(telefono, ' - ', celular) as telefonos, direccion "                        . "from $this->primaryTable "                        . "where estado='A'"                        . "order by sucursal";                break;            case "formulario":                $consulta = "select * from $this->primaryTable where id=" . $P['_conse'];                break;        }        $this->dbo->conectar();        $res = $this->dbo->consultar($consulta);        $this->dbo->desconectar();        if ($this->dbo->getError() === null) {            $this->setResult($res, 'data');        } else {            $this->setResult("Ha ocurrido un error en la consulta", "error");            return false;        }        return true;    }    public function guardar($P) {        $password = hash('sha256', $P["password"]);        $consulta = "insert into $this->primaryTable(sucursal                                            ,nombre                                            ,apellido                                            ,descripcion                                            ,telefono                                            ,celular                                            ,direccion                                            ,fechaRegistro                                            ,estado                                            ,usuario                                            ,password                                            )                              values('" . $P["sucursal"] . "',                                            '" . $P["nombre"] . "',                                            '" . $P["apellido"] . "',                                            '" . $P["descripcion"] . "',                                            '" . $P["telefono"] . "',                                            '" . $P["celular"] . "',                                            '" . $P["direccion"] . "',                                            '" . date('Y-m-d') . "',                                            'A',                                            '" . $P["usuario"] . "',                                            '" . $password . "'                                            )										                                    ";        $this->dbo->conectar();        if (!$this->dbo->ejecutar($consulta)) {            $this->setResult('Error al guardar el registro', 'error');        } else {            $this->setResult($this->dbo->getInsertedID(), 'id');        }        $this->dbo->desconectar();        return true;    }    public function editar($P) {        if (!is_numeric($P['id'])) {            $this->setResult('Error al editar el registro', 'error');            return false;        }        $password = hash('sha256', $P["password"]);        $consulta = "update $this->primaryTable set sucursal = '" . $P['sucursal'] . "'                            ,nombre = '" . $P['nombre'] . "'                            ,apellido = '" . $P['apellido'] . "'                            ,descripcion = '" . $P['descripcion'] . "'                            ,telefono = '" . $P['telefono'] . "'                            ,celular = '" . $P['celular'] . "'                            ,direccion = '" . $P['direccion'] . "'                            ,usuario = '" . $P['usuario'] . "'                            ,password = '" . $password . "'            where id= " . $P['id'] . "                    ";        $this->dbo->conectar();        if (!$this->dbo->ejecutar($consulta)) {            $this->setResult('Error al editar el registro', 'error');        } else {            $this->setResult($this->dbo->getInsertedID(), 'ok');        }        $this->dbo->desconectar();        return true;    }    public function borrar($P) {        if (!is_numeric($P['id'])) {            $this->setResult('Error al borrar el registro', 'error');            return false;        }        $consulta = "update $this->primaryTable set estado = 'X'                                        where id= " . $P['id'] . "                    ";        $this->dbo->conectar();        if (!$this->dbo->ejecutar($consulta)) {            $this->setResult('Error al editar el registro', 'error');        } else {            $this->setResult($this->dbo->getInsertedID(), 'ok');        }        $this->dbo->desconectar();    }    public function setResult($output, $type = "message") {        $this->result = [            "type" => $type,            "output" => $output        ];        return true;    }    public function getResult() {        return $this->result;    }}