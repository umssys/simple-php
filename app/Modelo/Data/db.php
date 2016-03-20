<?php
namespace app\Data;
class db{
	function __construct(){}
	private $link;
	public function conectar(){
		$this->link=mysqli_connect('localhost', 'avtrempusr', 'Avtr2015','avtrempdb', '3306');		
		}
	public function consultar($strConsulta){
		$res=mysqli_query($this->link, $strConsulta);
		$response=array();
		while($linea=mysqli_fetch_assoc($res)){
			array_push($response,$linea);
			}		
		return $response;
		}
	public function ejecutar($strConsulta){
		if (!$res=mysqli_query($this->link, $strConsulta)){
			echo mysqli_error($this->link);
			return false;
			}
		return true;
		}
	public function capturarInsertedID(){
		return mysqli_insert_id($this->link);
		}
	public function desconectar(){
		mysqli_close($this->link);
		}
	}
	
?>