<?php
ob_start();
session_start();
include("./clases/class_TemplatePower.php");
include("./clases/functions.php");
$tpl = new TemplatePower("./estilos/cuerpo.tpl");
$mod_error="./estilos/mod_404.tpl";
$mod_sub_error="./estilos/mod_sub_404.tpl";
if(!isset($_SESSION['user_log'])){
	$tpl->assignInclude("contenido","estilos/login.tpl");
}else{
	$tpl->assignInclude("menu_user","estilos/menu_user.tpl");
	if(!isset($_GET['mod'])){
		$mod='home';
		$submod='home';
	}else{
		$mod=strtolower($_GET['mod']);
		if(!isset($_GET['submod'])){
			$submod='home';
		}else{
			$submod=strtolower($_GET['submod']);
		}
	}
	$file_tpl="./modulos/".$mod."/estilo/index.tpl";
	$file_sub_tpl="./modulos/".$mod."/modulos/".$submod."/estilo/index.tpl";
	if (file_exists($file_tpl)){
		if ($mod<>'home'){
			$tpl->assignInclude("menu", "estilos/menu.tpl");
		}//Solo muestro el MENU si estoy en INICIO
		if(!isset($_GET['submod'])){//pregunto si estoy en submodulo
			$tpl->assignInclude("contenido",$file_tpl);
		}else{//si estoy en submodulo, pregunto si existe
			if (file_exists($file_sub_tpl)){
				$tpl->assignInclude("contenido",$file_sub_tpl);
			}else{
				$tpl->assignInclude("contenido",$mod_sub_error);
			}
		}
	}else{
		$tpl->assignInclude("contenido",$mod_error);
	}
}
$tpl->prepare();
$tpl->assign("nom_web",'FHEP - Sistema');
$tpl->assign("fecha_sis","ACA IRIA LA FECHA A LA DERECHA");
if(isset($_GET['submod'])){
	$tpl->assign("link_sub",'?mod='.@$mod);
}
if(!isset($_SESSION['user_log'])){	
}else{
	$tpl->assign("user",  $_SESSION['user_log']);
	$file_php="./modulos/".$mod."/index.php";
	$file_sub_php="./modulos/".$mod."/modulos/".$submod."/index.php";
	//echo $file_sub_php;
	if (file_exists($file_php)){
		if ($mod<>'home'){
			include('./modulos/menu.php');
		}
		if(!isset($_GET['submod'])){//pregunto si estoy en submodulo
			include($file_php);
		}else{
			if (file_exists($file_sub_php)){
				include($file_sub_php);
			}
		}
	}else{
		//echo "El fichero: $file_php no existe<br>";
	}
}
$tpl->printToScreen();
ob_end_flush();
?>