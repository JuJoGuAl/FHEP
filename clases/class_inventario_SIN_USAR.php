<?php
class inventario{
	private $db;
	private $modulo;
	private $modulos;
	public $table;
	public $tId;
	
	public function __construct(){
		include_once('class_PgSQL.php');
		$this->table = "articulos";
		$this->tId = "carticulo";
		$this->db = new pgsql($this->table, $this->tId);
		$this->db->fields = array (
			array ('private',	'carticulo', "''"),
			array ('public',    'cbarra'),
			array ('public',    'articulo'),
			array ('public',    'clasificacion'),
			array ('public',    'costo_actual','0.00'),
			array ('public',    'costo_prom','0.00'),
			array ('public',    'costo_ant','0.00'),
			array ('public',    'status','1'),
			array ('public',    'principio'),
			array ('public',    'und')
		);
	}
	
	public function validar($user){
		$where = "cusuario = '$user'";
		$user = $this->db->getRecords($where);
		if(empty($user)){
			return false;
		}else{
			return $user[0];
		}
	}
}
?>