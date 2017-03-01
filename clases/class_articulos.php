<?php
class articulo{
	private $db;
	public $table;
	public $tId;
	public $db2;
	public $db3;
	
	public function __construct(){
		include_once('class_PgSQL.php');
		$this->table = "art_generico";
		$this->tId = "cart_generico";
		$this->db = new pgsql($this->table, $this->tId);
		$this->db->fields = array (
			array ('private',	$this->tId, "''"),
			array ('public',    'art_generico'),
			array ('public',    'clasificacion'),
			array ('public',    'costo_actual'),
			array ('public',    'costo_prom'),
			array ('public',    'costo_ant'),
			array ('public',    'cantidad'),
			array ('public',    'status')
		);
		$this->db2 = new pgsql('art_comercial', 'cart_comercial');
		$this->db2->fields = array (
			array ('private',	'cart_comercial', "''"),
			array ('public',    'cbarra'),
			array ('public',    'art_comercial'),
			array ('public',    'cart_generico'),
			array ('public',    'costo_actual'),
			array ('public',    'costo_prom'),
			array ('public',    'costo_ant'),
			array ('public',    'cunidad'),
			array ('public',    'iva'),
			array ('public',    'cantidad'),
			array ('public',    'status'),
			array ('system',   '(SELECT art_generico FROM art_generico WHERE cart_generico=art_generico.cart_generico) AS generico')
		);
		$this->db3 = new pgsql('art_und', 'cunidad');
		$this->db3->fields = array (
			array ('private',	'cunidad', "''"),
			array ('public',    'unidad'),
			array ('public',    'multiplicador')
		);
	}
	public function list_art_comer(){
		$art = $this->db2->getRecords("status='1'");
		if(empty($art)){
			return false;
		}else{
			return $art;
		}
	}
	public function list_und(){
		$unds = $this->db3->getRecords('','cunidad ASC');
		if(empty($unds)){
			return false;
		}else{
			return $unds;
		}
	}
}
?>