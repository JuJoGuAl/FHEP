<?php
include_once("./clases/class_permisos.php");
$modulo = new permisos;
$datos = $modulo->get_mod($_GET['mod']);
foreach ($datos as $key => $value) {
	$perm = $modulo->menu_user($_SESSION['user_log'],$value['cmodulo']);
	if(empty($perm)){
		//Vacio: Sin permisos
		$tpl->gotoBlock( "_ROOT" );
		$tpl->newBlock("validar");
	}else{
		$tpl->newBlock("mod_principal");
		$tpl->assign("home",$_GET['mod']);
		// Array, con Permisos
		foreach($perm as $clave=>$valor){
			//echo "Modulo: ".$value['cmodulo']." Menu : ".$valor['menu']." Sub Menu: ".$valor['submenu']." Opcion: ".$valor['modulo']."<br>";
			$tpl->newBlock( "menu_modulo" );
			$tpl->assign("nom_menu",$valor['menu']);
			$tpl->assign("ico_menu",$valor['icon']);//Aqui Arme el Menu PRINCIPAL
			$submenu=$modulo->sub_menu_user($_SESSION['user_log'],$value['cmodulo'],$valor['cmenu']);//Consulto el SUB-MENU del MENU Principal
			foreach ($submenu as $clave1 => $valor1){
				$tpl->assign("sub_menu1",'<ul class="nav nav-second-level collapse">');
				$tpl->assign("sub_menu2",'</ul>');
				$tpl->assign("arrow",'<span class="fa arrow">');
				$mod_det=$modulo->mod_x_sub($_SESSION['user_log'],$value['cmodulo'],$valor['cmenu'],$valor1['csubmenu']);//Consulto las Opciones del SUB-MENU
				if($valor1['csubmenu']!=0){//Si Sub Menu no es 0 (tiene sub menu), consulto sus detalles
					$tpl->newBlock("submenu_modulo");
					$tpl->assign("nom_submenu",$valor1['submenu']);
					$tpl->assign("url_submenu","./");
					if($valor1['csubmenu']!=0){
						$tpl->assign("sub_menu3",'<ul class="nav nav-third-level collapse">');
						$tpl->assign("sub_menu4",'</ul>');
						$tpl->assign("arrow1",'<span class="fa arrow">');
						foreach ($mod_det as $clave2 => $valor2){
							$tpl->newBlock("modulo");
							$tpl->assign("nom_mod",$valor2['modulo']);
							$tpl->assign("url_mod",$valor2['det_url']);
							$tpl->assign("url_mod_dad",$_GET['mod']);
						}			
					}
				}else{//Si es 0, No muestro SUB, voy directo a los detalles
					foreach ($mod_det as $clave2 => $valor2){
						$tpl->newBlock("submenu_modulo");
						$tpl->assign("nom_submenu",$valor2['modulo']);
						$tpl->assign("url_submenu",'?mod='.$_GET['mod'].'&submod='.$valor2['det_url']);
					}
				}
			}
		}
	}
}
?>