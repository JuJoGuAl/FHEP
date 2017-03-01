<?php
include_once("./clases/class_permisos.php");
$data = new permisos;
$mod_users=$data->mod_usu($_SESSION['user_log']);
foreach ($mod_users as $key => $value) {
	$tpl->newBlock( "menu_home" );
	$tpl->assign( "nom_mod",  $value['modulo']);
	$tpl->assign( "img_mod",  $value['mod_img']);
	$tpl->assign( "url_mod",  $value['mod_url']);
}
?>