<?php
class almacen{
	private $db;
	public $table;
	public $tId;
	
	public function __construct(){
		include_once('class_PgSQL.php');
		$this->table = "almacen";
		$this->tId = "calmacen";
		$this->db = new pgsql($this->table, $this->tId);
		$this->db->fields = array (
			array ('private',	$this->tId, "''"),
			array ('public',    'almacen'),
			array ('public',    'status','1'),
			array ('public',    'cdepartamento'),
			array ('public',    'compra'),
			array ('public',    'stock'),
			array ('system',   '(SELECT departamento FROM departamento WHERE cdepartamento=almacen.cdepartamento) AS departamento')
		);
	}	
	public function list_alm(){
		$alm = $this->db->getRecords("status='1' and compra='1'");
		if(empty($alm)){
			return false;
		}else{
			return $alm;
		}
	}
}
?>