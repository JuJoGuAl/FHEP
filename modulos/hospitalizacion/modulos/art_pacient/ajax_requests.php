<?php
include_once("../../../../clases/class_almacen.php");
include_once("../../../../clases/class_proveedor.php");
include_once("../../../../clases/class_articulos.php");
include_once("../../../../clases/class_compras.php");
$table="";
$titles="";
$row_clas="";
$row=0;
if(isset($_POST['action'])){
	$objeto=$_POST['action'];
	switch ($objeto){
		case 'Almacenes':
		$titles='<tr><th>CODIGO</th><th>ALMACEN</th><th>DEPARTAMENTO</th></tr>';
		break;
		case 'Proveedores':
		$titles='<tr><th>C-PROVEEDOR</th><th>CODIGO</th><th>PROVEEDOR</th></tr>';
		break;
		case 'Articulos':
		$titles='<tr><th>C-ARTI</th><th width="200px">C-BARRA</th><th>DESCRIPCION</th><th class="hidden">IVA</th><th class="hidden">UND</th></tr>';
		break;
		case 'ODC':
		$titles='<tr><th>C-ODC</th><th class="hidden">C-PROV</th><th>PROVEEDOR</th><th>MONTO</th></tr>';
		break;
	}
	$table.='
	<table width="100%" class="table table-striped table-bordered table-hover datatables" id="'.$objeto.'_tbl">
		<thead>			
			'.$titles.'
		</thead>
		<tbody>
	';
	if($objeto=='Almacenes'){
		$alm = new almacen();
		$dat_alm = $alm->list_alm();
		if (!empty($dat_alm)){
			foreach ($dat_alm as $key1 => $value1){
				$row++;
				$row_clas = ($row%2==0) ? 'odd' : 'even' ;
				$table.='<tr class="gradeA '.$row_clas.'"><td class="'.$objeto.'_id">'.$value1['calmacen'].'</td><td class="'.$objeto.'_name">'.$value1['almacen'].'</td><td>'.$value1['departamento'].'</td></tr>';
			}
		}
	}
	else if($objeto=='Proveedores'){
		$prov = new proveedor();
		$dat_prov = $prov->list_prov();
		if (!empty($dat_prov)){
			foreach ($dat_prov as $key2 => $value2){
				$row++;
				$row_clas = ($row%2==0) ? 'odd' : 'even' ;
				$table.='<tr class="gradeA '.$row_clas.'"><td class="'.$objeto.'_id">'.$value2['cproveedor'].'</td><td>'.$value2['codigo'].'</td><td class="'.$objeto.'_name">'.$value2['nombre'].'</td></tr>';
			}
		}
	}
	else if($objeto=='Articulos'){
		$art = new articulo();
		$dat_art = $art->list_art();
		if (!empty($dat_art)){
			foreach ($dat_art as $key3 => $value3){
				$row++;
				$row_clas = ($row%2==0) ? 'odd' : 'even' ;
				$table.='<tr class="gradeA '.$row_clas.'"><td class="'.$objeto.'_id">'.$value3['carticulo'].'</td><td class="'.$objeto.'_code">'.$value3['cbarra'].'</td><td class="'.$objeto.'_name">'.$value3['articulo'].'</td><td class="'.$objeto.'_iva hidden">'.$value3['iva'].'</td><td class="'.$objeto.'_und hidden">'.$value3['cunidad'].'</td></tr>';
			}
		}
	}
	else if($objeto=='ODC'){
		$odc = new compra();
		$dat_odc = $odc->list_ODC();
		if (!empty($dat_odc)){
			foreach ($dat_odc as $key4 => $value4){
				$row++;
				$row_clas = ($row%2==0) ? 'odd' : 'even' ;
				$table.='<tr class="gradeA '.$row_clas.'"><td class="'.$objeto.'_id">'.$value4['corden'].'</td><td class="'.$objeto.'_id_prov hidden">'.$value4['cproveedor'].'</td><td class="'.$objeto.'_name">'.$value4['nombre'].'</td><td>'.$value4['monto_total'].'</td></tr>';
			}
		}
	}
	$table.='
				</tbody>
				</table>';
	if($objeto=='und'){
		$select='';
		$und = new articulo();
		$dat_und = $und->list_und();
		if (!empty($dat_und)){
			foreach ($dat_und as $key4 => $value4){
				$select.='<option class="'.$value4['cunidad'].'" value="'.$value4['multiplicador'].'">'.$value4['unidad'].'</option>';
			}
		}
		$table=$select;
	}else if($objeto=='ODC_det'){
		$table='';
		$odc_det = new compra();
		$dat_odc_det = $odc_det->ODC_DET($_POST['odc']);
		if (!empty($dat_odc_det)){
			foreach ($dat_odc_det as $key5 => $value5){
				$odc_det=$value5['corden_det'];
				$table.='<tr id="art_'.$odc_det.'">';
				$table.='<td><button name="del_art'.$odc_det.'" id="del_art'.$odc_det.'" class="btn btn-default btn-xs" type="button"><i class="fa fa-times"></i></button><input name="cart'.$odc_det.'" id="cart'.$odc_det.'" type="text" disabled="disabled" class="form-control hidden" value="'.$value5['carticulo'].'"></td>';
				$table.='<td><input name="cbarra'.$odc_det.'" id="cbarra'.$odc_det.'" class="form-control" readonly value="'.$value5['barra'].'"></td>';
				$table.='<td><input name="art'.$odc_det.'" id="art'.$odc_det.'" class="form-control" readonly value="'.$value5['articulo'].'"></td>';
				$table.='<td><input name="art'.$odc_det.'" id="art'.$odc_det.'" class="form-control" readonly value="'.$value5['cunidad'].'"></td>';
				$table.='<td><input name="cal'.$odc_det.'" id="cant'.$odc_det.'" class="form-control numeric" value="'.$value5['cant'].'"></td>';
				$table.='<td><input name="cal'.$odc_det.'" id="costou'.$odc_det.'" class="form-control numeric" value="'.$value5['costo_u'].'"></td>';
				$table.='<td><input name="cal'.$odc_det.'" id="imp'.$odc_det.'" class="form-control numeric" value="'.$value5['iva'].'"></td>';
				$table.='<td><input name="costot'.$odc_det.'" id="costot'.$odc_det.'" class="form-control" readonly value="'.$value5['costo_t'].'"></td>';
				$table.='</tr>';
			}
		}
	}
	echo $table;
}
?>