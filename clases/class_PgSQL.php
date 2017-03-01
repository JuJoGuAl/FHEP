<?php
class Database extends PDO
{
	private $dbname = "fhep";
	private $host = "192.168.0.66";
	private $user = "postgres";
	private $pass = "224805";
	private $port = "5432";
	private $dbh;

	//Función para la conexión
	public function __construct(){
		try{
			$this->dbh = parent::__construct("pgsql:host=$this->host;port=$this->port;dbname=$this->dbname;user=$this->user;password=$this->pass");
	    } catch(PDOException $e){
	    	echo  utf8_encode($e->getMessage());
	    }
	}
	//Función para Cerrar Conexión PDO
	public function close_con(){
		$this->dbh = null;
	}

}
class pgsql extends PDO{
	private $linkid;      // Link de la BD PostgreSQL
	private $result;      // Resultado del QUERY
	private $querycount;  // Total de Querys Ejecutadas
	public $table;		  // Nombre de la Tabla a trabajar
	/** Campos de la Tabla
	fieldName: nombre del campo en la tabla
	class: tipo de campo (public, private, system)
	*/
	public $fields;
	public $campoId;	  // Campo llave de la Tabla

	public function __construct ($table, $campoId){
		$this->table = $table;
		$this->campoId = $campoId;
		$this->fields = array ();
		$this->linkid = new Database();
	}
	//Metodos Publicos
	/** Devuelve los registros de la tabla
	* @param $where_str: Cadena=''. Condición para filtrar resultados.
	* @param $order_str: Cadena=''. Campo sobre el que se ordenarán los registros.
	* @param $count: Entero =false . Número de registros a devolver. Si es false, toda la tabla
	* @param $start: Entero =0. Indica a partir de qué registros se devuelven datos, por default 0.
	*/
	public function getRecords($where_str=false, $order_str=false, $count=false, $start=0){
		$where =$where_str ? "WHERE $where_str" : "";
		$order =$order_str ? "ORDER BY $order_str" : "";
		$limit = $count ? "LIMIT $start, $count" : "";
		$campos =$this->getAllFields();
		//$campos = "*";
		$sql = "SELECT $campos FROM {$this->table} $where $order $limit";
		//echo $sql;
		return $this->query($sql);
	}
	/** Devuelve un registro de la tabla
	* @param $id: Entero. Id del registro a devolver.
	*/
	public function getRecord($id){
		return $this->getRecords("{$this->campoId}=$id", false, 1);
	}
	/** Inserta un Registro en la BD
	* @param $sysData_str: Int, si es 1 la BD coloca el ID, si es 0 el ID es colocado por el Usuario.
	*/
	public function insertRecord ($data,$sysData_str){
		$response="Query is Empty!";
		$campos = $this->getTableFields();
		$data =implode ("', '", $data);
		if ($sysData_str==1){
			$sysData =$this->getDefaultValues();
			if($sysData){
			$sysData .= ",";
			$sql ="INSERT INTO {$this->table} ($campos) VALUES ($sysData '$data')";
			}
		}
		else{
			$sql ="INSERT INTO {$this->table} ($campos) VALUES ('$data')";
		}
		try{			
			//$query = $this->con->prepare('INSERT INTO users (nombre,apellidos,fecha_registro) values (?,?,?)');
			$query = $this->linkid->prepare($sql);
			//$query->bindParam(1,$nombre);
			//$query->bindParam(2,$apellidos);
			//$query->bindParam(3,$fecha_registro);
			$response=$query->execute();
			$this->linkid->close_con();	
		}catch(PDOException $e){
			$response=$e->getMessage();
		}
		return $response;
	}
	public function updateRecord($id, $data){
		$campos = $this->getEditableFields (true);
		$datos = array();
		foreach ($campos as $ind => $campo){
			$current_data =$data[$ind];
			if($current_data != ""){
				array_push ($datos, "$campo='$current_data'"); 
			}
		}
		$datos =implode (", ", $datos);
		$sql = "UPDATE {$this->table} SET $datos WHERE {$this->campoId}=$id";
		return $this->query($sql);
	}
	public function deleteRecord($id){
		$sql = "DELETE FROM {$this->table} WHERE {$this->campoId}=$id";
		return $this->query($sql);
	}
	public function deleteRecords($where_str=false){
		$where =$where_str ? "WHERE $where_str" : "";
		$sql="DELETE FROM {$this->table} $where";
		return $this->query($sql);
	}
	// Metodos privados
	public function query($sql=false){
		$response=false;
		if ($sql==false){
			$response="Query is Empty!";
		}else{
			try{
				@$query = $this->linkid->prepare($sql);
				$query->execute();
				$this->linkid->close_con();
				$response=($query->fetchAll(PDO::FETCH_ASSOC));
			
			}catch(PDOException $e){
				$response=$e->getMessage();
			}
		}
		return $response;
	}
	private function getFieldsByType ($type=''){
		$return =array ();
		$types =explode ('|', $type);
		foreach ($this->fields as $field){
			$includeField =false;
			foreach ($types as $t){
				if ($field[0] == $t){
					array_push ($return, $field);
				}
			}
		}
		return $return;
	}
	private function getNameFields ($type){
		$return =array ();
		$fields =$this->getFieldsByType ($type);
		foreach ($fields as $field){
			array_push ($return, $field[1]);
		}
		return $return;
	}
	private function getEditableFields ($asArray=false){
		$return =$this->getNameFields ('public');
		return $asArray ? $return : implode (', ', $return);
	}
	private function getTableFields ($asArray=false){
		$temp =$this->getNameFields ('private');
		foreach($temp as $r)$return[] = $r;
		$temp =$this->getNameFields ('public');
		foreach($temp as $r)$return[] = $r;
		return $asArray ? $return : implode (', ', $return);
	}
	private function getAllFields ($asArray=false){
		$return =$this->getNameFields ('public|private|system');
		return $asArray ? $return : implode (', ', $return);
	}
	private function getDefaultValues ($asArray=false){
		$return =array ();
		$fields =$this->getFieldsByType ('private');
		foreach ($fields as $field){
			array_push ($return, $field[2]);
		}
		return $asArray ? $return : implode (', ', $return);
	}
}
?>