<?php
class proveedor{
	private $db;
	public $table;
	public $tId;
	
	public function __construct(){
		include_once('class_PgSQL.php');
		$this->table = "proveedores";
		$this->tId = "cproveedor";
		$this->db = new pgsql($this->table, $this->tId);
		$this->db->fields = array (
			array ('private',	$this->tId, "''"),
			array ('public',    'cdata'),
			array ('public',    'credito'),
			array ('public',    'cresidencia'),
			array ('public',    'ctipo_prov'),
			array ('public',    'ctipo_ret'),
			array ('public',    'cnc'),
			array ('public',    'status'),
			array ('system',   '(SELECT codigo FROM data WHERE cdata=proveedores.cdata) AS codigo'),
			array ('system',   '(SELECT nombre FROM data WHERE cdata=proveedores.cdata) AS nombre')
		);
	}
	public function list_prov(){
		$where="status='1'";
		$prov = $this->db->getRecords($where);
		if(empty($prov)){
			return false;
		}else{
			return $prov;
		}
	}
}
?>