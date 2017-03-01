<?php
include_once("./clases/class_permisos.php");
include_once("./clases/class_inventario.php");
/*$modulo = new permisos;
$datos = $modulo->get_mod($_GET['mod']);
foreach ($datos as $key => $value) {
	$tpl->newBlock("modulo_desc");
	$tpl->assign( "nom_mod", $value['modulo']);
	$perm = $modulo->perm_mod($_SESSION['user_log'],$value['cmodulo']);
	if(empty($perm)){
		//Vacio: Sin permisos
		$tpl->gotoBlock( "_ROOT" );
		$tpl->newBlock( "validar" );
	}else{
		// Array, con Permisos
	}
}*/
/*$data = new permisos;
$mod_users=$data->mod_usu($_SESSION['user']);
foreach ($mod_users as $key => $value) {
	$tpl->newBlock( "menu_home" );
	$tpl->assign( "nom_mod",  $value['modulo']);
	$tpl->assign( "img_mod",  $value['mod_img']);
	$tpl->assign( "url_mod",  $value['mod_url']);
}*/
?>