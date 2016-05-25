<?phprequire $_SERVER['DOCUMENT_ROOT'] . "app/data/db.php";class inicioModel {    private $result;    private $primaryTable;    function __construct($active) {        $active ? true : die('ACCESS DENIED');        $this->dbo = new db();        $this->primaryTable = "taquilla";    }    private $dbo;    public function consultar($P) {        if (isset($P['_conse']) && !is_numeric($P['_conse'])){            $this->setResult('Error al consultar el registro', 'error');            return false;        }        $consulta = "";        switch ($P['tipo']) {            case "activo":                $consulta = "select id, nombre, imagen "                    . "from $this->primaryTable "                    . "order by nombre";                break;            case "formulario":                $consulta = "select * from $this->primaryTable where id=" . $P['_conse'];                break;        }        $this->dbo->conectar();        $res = $this->dbo->consultar($consulta);        $this->dbo->desconectar();                if ($this->dbo->getError() === null){            $this->setResult($res, 'data');        }        else {            $this->setResult("Ha ocurrido un error en la consulta", "error");            return false;        }                return true;    }    public function guardar($P) {        $nombre = strtoupper($P["nombre"]);        $consulta = "insert into $this->primaryTable(nombre                                            , imagen                                            )                              values('" . $nombre . "'                                          , '" . $P["imagen"] . "'                                                                                         )										                                    ";        $this->dbo->conectar();        if (!$this->dbo->ejecutar($consulta)) {            $this->setResult('Error al guardar el registro', 'error');        } else {            $this->setResult($this->dbo->getInsertedID(), 'id');        }        $this->dbo->desconectar();        return true;    }    public function editar($P) {        $nombre = strtoupper($P["nombre"]);        if (!is_numeric($P['id'])){            $this->setResult('Error al editar el registro', 'error');            return false;        }        $consulta = "update $this->primaryTable set nombre = '" . $nombre . "', imagen = '" . $P["imagen"] . "'                                               where id= " . $P['id'] . "                    ";        $this->dbo->conectar();        if (!$this->dbo->ejecutar($consulta)) {            $this->setResult('Error al editar el registro', 'error');        } else {            $this->setResult($this->dbo->getInsertedID(), 'ok');        }        $this->dbo->desconectar();        return true;    }    public function borrar($P) {        if (!is_numeric($P['id'])){            $this->setResult('Error al borrar el registro', 'error');            return false;        }        $consulta = "delete from $this->primaryTable where id= " . $P['id'];        $this->dbo->conectar();        if (!$this->dbo->ejecutar($consulta)) {            $this->setResult('Error al borrar el registro', 'error');        } else {            $this->setResult($this->dbo->getInsertedID(), 'ok');        }        $this->dbo->desconectar();    }    public function setResult($output, $type = "message") {        $this->result = [            "type" => $type,            "output" => $output        ];        return true;    }        public function iniciarSesion($P){        $loginData = json_decode($P['loginData']);        $userName = $loginData[0]->value;        $userPass = hash('sha256', (string) $loginData[1]->value);        $consulta = "select id from taquilla where usuario='$userName' and password='$userPass' and estado='A'";        $this->dbo->conectar();        $res = $this->dbo->consultar($consulta);        if (!$res || count($res) === 0) {            $this->setResult('Usuario o contraseña inválidos', 'error');        } else {            $_SESSION['taquilla_id'] = $res[0]['id'];            $updateLastLoginQ = "update taquilla set ultimoAcceso='" . date('Y-m-d H:i:s') . "' where id=" . $res[0]['id'];            $this->dbo->ejecutar($updateLastLoginQ);            $this->setResult('Autorizado!', 'ok');        }        $this->dbo->desconectar();        return true;    }    public function getResult() {        return $this->result;    }}