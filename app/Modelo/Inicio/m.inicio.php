<?php
namespace app\Modelo;
//require "../modelo/db.php";
//use
class m_inicio {

    function __construct() {
        $this->dbo = new db();
    }

    private static $dbo;

    public function consultarEmpleado($P) {
        $consulta = "";
        switch ($P['tipo']) {
            case "tabla":
                $consulta = "select emp_conse,emp_nombre,emp_apellido,emp_profesion,emp_telefono,emp_movil from empleado";
                break;
            case "formulario":
                $consulta = "select * from empleado";
                break;
        }

        if (isset($P['emp_conse'])) {
            $consulta.=" where emp_conse='" . $P['emp_conse'] . "'";
        }
        $this->dbo->conectar();
        $res = $this->dbo->consultar($consulta);
        $this->dbo->desconectar();
        echo $this->convertirResultset($res);
    }

    public function grabarEmpleado($P) {
        $emp_nombre = $P['emp_nombre'];
        $emp_apellido = $P['emp_apellido'];
        $emp_documento = $P['emp_documento'];
        $emp_fechanacimiento = $P['emp_fechanacimiento'];
        $emp_ciudadresidencia = $P['emp_ciudadresidencia'];
        $emp_profesion = $P['emp_profesion'];
        $emp_genero = $P['emp_genero'];
        $emp_observacion = $P['emp_observacion'];
        $emp_telefono = $P['emp_telefono'];
        $emp_movil = $P['emp_movil'];
        $emp_correoelectronico = $P['emp_correoelectronico'];
        $consulta = "insert into empleado(emp_nombre
										,emp_apellido
										,emp_documento
										,emp_fechanacimiento
										,emp_ciudadresidencia
										,emp_profesion
										,emp_genero
										,emp_observacion
										,emp_telefono
										,emp_movil
										,emp_correoelectronico
										)
								  values('$emp_nombre'
										,'$emp_apellido'
										,'$emp_documento'
										,'$emp_fechanacimiento'
										,'$emp_ciudadresidencia'
										,'$emp_profesion'
										,'$emp_genero'
										,'$emp_observacion'
										,'$emp_telefono'
										,'$emp_movil'
										,'$emp_correoelectronico'										  
										)										
									";

        //echo $consulta;
        $this->dbo->conectar();
        $this->dbo->ejecutar($consulta);
        echo $this->dbo->capturarInsertedID();
        $this->dbo->desconectar();
    }

    public function editarEmpleado($P) {
        $emp_conse = $P['emp_conse'];
        $emp_nombre = $P['emp_nombre'];
        $emp_apellido = $P['emp_apellido'];
        $emp_documento = $P['emp_documento'];
        $emp_fechanacimiento = $P['emp_fechanacimiento'];
        $emp_ciudadresidencia = $P['emp_ciudadresidencia'];
        $emp_profesion = $P['emp_profesion'];
        $emp_genero = $P['emp_genero'];
        $emp_observacion = $P['emp_observacion'];
        $emp_telefono = $P['emp_telefono'];
        $emp_movil = $P['emp_movil'];
        $emp_correoelectronico = $P['emp_correoelectronico'];

        $consulta = "update empleado set
	    						emp_nombre='$emp_nombre'
	    						,emp_apellido='$emp_apellido'
	    						,emp_documento='$emp_documento'
	    						,emp_fechanacimiento='$emp_fechanacimiento'
	    						,emp_ciudadresidencia='$emp_ciudadresidencia'
	    						,emp_profesion='$emp_profesion'
	    						,emp_genero='$emp_genero'
	    						,emp_observacion='$emp_observacion'
	    						,emp_telefono='$emp_telefono'
	    						,emp_movil='$emp_movil'
	    						,emp_correoelectronico='$emp_correoelectronico'
	    				where emp_conse=$emp_conse
						";

        $this->dbo->conectar();
        $this->dbo->ejecutar($consulta);
        $this->dbo->desconectar();
    }

    public function borrarEmpleado($P) {
        $consulta = "delete from empleado where emp_conse=" . $P["emp_conse"];
        $this->dbo->conectar();
        $this->dbo->ejecutar($consulta);
        $this->dbo->desconectar();
    }

    private function convertirResultset($rst) {
        $rstStr = "";
        foreach ($rst as $linea) {
            foreach ($linea as $campo) {
                $rstStr.=$campo . "||@||";
            }
            $rstStr = substr($rstStr, 0, strrpos($rstStr, '||@||'));
            $rstStr.='<<<br>>>';
        }
        $rstStr = substr($rstStr, 0, strrpos($rstStr, '<<<br>>>'));
        return $rstStr;
    }

}

?>