<?php
function CadenaLimpia($event){
	$contenido = eregi_replace("<[^>]*>","",$event);	
	return $contenido;
}

function numeros($num,$dec=2){
	$num_fix=number_format($num, $dec, ',', '.');
	return $num_fix;
}
function Get_Mes($dato){
	$mes = $dato;
	if($mes == "01"){
		$mes = "Enero";
	}elseif($mes == "02"){
		$mes = "Febrero";
	}elseif($mes == "03"){
		$mes = "Marzo";
	}elseif($mes == "04"){
		$mes = "Abril";
	}elseif($mes == "05"){
		$mes = "Mayo";
	}elseif($mes == "06"){
		$mes = "Junio";
	}elseif($mes == "07"){
		$mes = "Julio";
	}elseif($mes == "08"){
		$mes = "Agosto";
	}elseif($mes == "09"){
		$mes = "Septiembre";
	}elseif($mes == "10"){
		$mes = "Octubre";
	}elseif($mes == "11"){
		$mes = "Noviembre";
	}elseif($mes == "12"){
		$mes = "Diciembre";
	}
	return ($mes);
}
?>