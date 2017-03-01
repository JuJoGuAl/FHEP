<?php
class compra{
	private $db;
	public $table;
	public $tId;
	
	public function __construct(){
		include_once('class_PgSQL.php');
		$this->table = "ordencompra o, proveedores p";
		$this->tId = "o.corden";
		$this->db = new pgsql($this->table, $this->tId);
		$this->db->fields = array (
			array ('private',	$this->tId, "''"),
			array ('public',    'o.cproveedor'),
			array ('public',    'o.fecha_orden'),
			array ('public',    'o.status'),
			array ('public',    'o.monto_total'),
			array ('public',    'p.cdata'),
			array ('system',   '(SELECT nombre FROM data WHERE cdata=p.cdata) AS nombre')
		);
		$this->db2 = new pgsql('ordencompra_det od', 'corden_det');
		$this->db2->fields = array (
			array ('private',	'corden_det', "''"),
			array ('public',	'corden', "''"),
			array ('public',    'carticulo'),
			array ('public',    'cunidad'),
			array ('public',    'cant'),
			array ('public',    'costo_u'),
			array ('public',    'iva'),
			array ('public',    'costo_t'),
			array ('system',   '(SELECT cbarra FROM articulos WHERE carticulo=od.carticulo) AS barra'),
			array ('system',   '(SELECT articulo FROM articulos WHERE carticulo=od.carticulo) AS articulo')
		);
	}
	public function list_ODC(){
		$odc = $this->db->getRecords("status='PROCESADA'");
		if(empty($odc)){
			return false;
		}else{
			return $odc;
		}
	}
	public function ODC_DET($odc){
		$where = "corden = '$odc'";
		$odc_det = $this->db2->getRecords($where);
		if(empty($odc_det)){
			return false;
		}else{
			return $odc_det;
		}
	}
}
?>