<?php
class inventario{
	private $db;
	private $modulo;
	private $modulos;
	public $table;
	public $tId;
	
	public function __construct(){
		include('class_PgSQL.php');
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
	public function mod_usu($user){
		$sql = "SELECT m.cmodulo,m.modulo,m.mod_url,m.mod_img FROM adm_mod m INNER JOIN adm_mod_det md ON m.cmodulo=md.cmodulo INNER JOIN adm_mod_usu mu ON md.cmodulo_det=mu.cmodulo_det WHERE mu.cusuario = '$user' GROUP BY m.cmodulo,m.modulo,m.mod_url,m.mod_img";
		$mod_user = $this->db->query($sql);
		if(empty($mod_user)){
			return false;
		}else{
			return $mod_user;
		}
	}
}
?>