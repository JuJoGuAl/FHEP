<?php
include_once("./clases/class_permisos.php");
$perm = new permisos();
$perm_val = $perm->val_mod($_SESSION['user_log'],$_GET['submod']);
if(!$perm_val){
	$tpl->gotoBlock( "_ROOT" );
	$tpl->newBlock( "validar" );
}else{
	$tpl->newBlock("inv_recep");
	foreach ($perm_val as $key1 => $value1){
		$tpl->assign("mod_name",$value1['modulo']);
	}
	$tpl->assign("date_now",date('d/m/Y'));
}
?>