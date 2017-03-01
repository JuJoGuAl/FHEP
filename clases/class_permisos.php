<?php
class permisos{
	private $db;
	private $modulo;
	private $modulos;
	public $table;
	public $tId;
	
	public function __construct(){
		include_once('class_PgSQL.php');
		$this->table = "adm_mod_usu u, adm_mod_det d";
		$this->tId = "cpermiso";//No existe actualmente
		$this->db = new pgsql($this->table, $this->tId);
		$this->db->fields = array (
			array ('public',    'u.cusuario'),
			array ('public',    'u.cmodulo_det'),
			array ('public',   'd.det_url'),
			array ('public',   'd.modulo')
		);
		$this->modulo = new pgsql('adm_mod', 'cmodulo');
		$this->modulo->fields = array (
			array ('private',	'cmodulo', "''"),
			array ('public',    'modulo'),
			array ('public',    'mod_url'),
			array ('public',    'mod_img')
		);
		$this->modulos = new pgsql('adm_mod_det', 'cmodulo_det	');
		$this->modulos->fields = array (
			array ('private',	'cmodulo_det', "''"),
			array ('public',    'cmodulo'),
			array ('public',    'menu'),
			array ('public',    'menu_sub'),
			array ('public',    'det_url'),
			array ('public',    'modulo')
		);
	}
	
	public function validar($user){
		$where = "u.cusuario = '$user'";
		$user = $this->db->getRecords($where);
		if(empty($user)){
			return false;
		}else{
			return $user;
		}
	}
	public function val_mod($user,$mod){
		$where = "d.cmodulo_det=u.cmodulo_det and u.cusuario = '$user' and d.det_url='$mod'";
		$user = $this->db->getRecords($where);
		if(empty($user)){
			return false;
		}else{
			return $user;
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
	public function get_mod($mod){
		$where = "mod_url = '$mod'";
		$mod = $this->modulo->getRecords($where);
		if(empty($mod)){
			return false;
		}else{
			return $mod;
		}
	}
	public function menu_user($user,$mod){
		//$sql = "SELECT count(m.cmodulo) as cuenta FROM adm_mod m INNER JOIN adm_mod_det md ON m.cmodulo=md.cmodulo INNER JOIN adm_mod_usu mu ON md.cmodulo_det=mu.cmodulo_det WHERE mu.cusuario = '$user' and m.cmodulo='$mod'";
		//$sql = "SELECT m.menu, ms.submenu, md.modulo FROM adm_mod_usu u INNER JOIN adm_mod_det md ON u.cmodulo_det=md.cmodulo_det INNER JOIN adm_mod mo ON md.cmodulo=mo.cmodulo INNER JOIN adm_menu_sub ms ON md.menu_sub=ms.csubmenu INNER JOIN adm_menu m ON md.menu=m.cmenu WHERE cusuario='$user' and mo.cmodulo='$mod'";
		//$sql = "SELECT m.cmenu,m.menu,ms.csubmenu,m.icon FROM adm_mod_usu u INNER JOIN adm_mod_det md ON u.cmodulo_det=md.cmodulo_det INNER JOIN adm_mod mo ON md.cmodulo=mo.cmodulo INNER JOIN adm_menu_sub ms ON md.menu_sub=ms.csubmenu INNER JOIN adm_menu m ON md.menu=m.cmenu WHERE cusuario='$user' and mo.cmodulo='$mod' GROUP BY m.cmenu,m.menu,ms.csubmenu,m.icon ORDER BY m.cmenu ASC";
		$sql = "SELECT m.cmenu,m.menu,sum(ms.csubmenu) as submenu,m.icon FROM adm_mod_usu u INNER JOIN adm_mod_det md ON u.cmodulo_det=md.cmodulo_det INNER JOIN adm_mod mo ON md.cmodulo=mo.cmodulo INNER JOIN adm_menu_sub ms ON md.menu_sub=ms.csubmenu INNER JOIN adm_menu m ON md.menu=m.cmenu WHERE cusuario='$user' and mo.cmodulo='$mod' GROUP BY m.cmenu,m.menu,m.icon ORDER BY m.cmenu ASC";
		$menu = $this->db->query($sql);
		return $menu;
		/*if($per_mod[0]['cuenta']==0){
			return false;
		}else{
			return true;
		}*/
	}
	public function sub_menu_user($user,$mod,$menu){
		//$sql = "SELECT ms.csubmenu,ms.submenu FROM adm_mod_usu u INNER JOIN adm_mod_det md ON u.cmodulo_det=md.cmodulo_det INNER JOIN adm_mod mo ON md.cmodulo=mo.cmodulo INNER JOIN adm_menu_sub ms ON md.menu_sub=ms.csubmenu INNER JOIN adm_menu m ON md.menu=m.cmenu WHERE cusuario='$user' and mo.cmodulo='$mod' and m.cmenu='$menu' GROUP BY ms.csubmenu,ms.submenu ORDER BY ms.csubmenu ASC";
		$sql = "SELECT ms.csubmenu,ms.submenu FROM adm_mod_usu u INNER JOIN adm_mod_det md ON u.cmodulo_det=md.cmodulo_det INNER JOIN adm_mod mo ON md.cmodulo=mo.cmodulo INNER JOIN adm_menu_sub ms ON md.menu_sub=ms.csubmenu INNER JOIN adm_menu m ON md.menu=m.cmenu WHERE cusuario='$user' and mo.cmodulo='$mod' and m.cmenu='$menu' GROUP BY ms.csubmenu,ms.submenu ORDER BY ms.csubmenu ASC";
		$sub_menu = $this->db->query($sql);
		return $sub_menu;
	}
	public function mod_x_sub($user,$mod,$menu,$submenu){
		//$sql = "SELECT md.cmodulo_det,md.modulo,md.det_url FROM adm_mod_usu u INNER JOIN adm_mod_det md ON u.cmodulo_det=md.cmodulo_det INNER JOIN adm_mod mo ON md.cmodulo=mo.cmodulo INNER JOIN adm_menu_sub ms ON md.menu_sub=ms.csubmenu INNER JOIN adm_menu m ON md.menu=m.cmenu WHERE cusuario='$user' and mo.cmodulo='$mod' and m.cmenu='$menu' and ms.csubmenu='$submenu' ORDER BY md.cmodulo_det ASC";
		$sql = "SELECT md.cmodulo_det,md.modulo,md.det_url FROM adm_mod_usu u INNER JOIN adm_mod_det md ON u.cmodulo_det=md.cmodulo_det INNER JOIN adm_mod mo ON md.cmodulo=mo.cmodulo INNER JOIN adm_menu_sub ms ON md.menu_sub=ms.csubmenu INNER JOIN adm_menu m ON md.menu=m.cmenu WHERE cusuario='$user' and mo.cmodulo='$mod' and m.cmenu='$menu' and ms.csubmenu='$submenu' ORDER BY md.cmodulo_det ASC";
		$mod_sub = $this->db->query($sql);
		return $mod_sub;
	}
}
?>