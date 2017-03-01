<script>
	$(document).ready(function(){
		var action = "",location = "",save = false,button = "",article = false,counter = 0,rows=0;
		$('#f_fact_c').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			language: "es"
		});
		$(".numeric").keydown(function (e){
			acceptNum(e);
		});
		$('#ch_don').change(function(){
			$('.donate').attr('disabled', function(_, attr){ return !attr});
			$('#ODC_btn').attr('disabled', function(_, attr){ return !attr});

		});
		$('#Modal_').on('hidden.bs.modal', function (){
			if(save==true){
				if(action=='ODC'){
					var odc=$('.datatables tbody tr.success .'+action+'_id').text();
					$('#Articulos_btn').addClass('disabled');
					$('#Proveedores_btn').attr('disabled',true);
					$('#Proveedores_n').val($('.datatables tbody tr.success .'+action+'_name').text());
					$('#Proveedores_c').val($('.datatables tbody tr.success .'+action+'_id_prov').text());
					//alert(odc);
					/*$.ajax({
						url: './modulos/inventario/modulos/inv_recep/'+location+'.php',
						type: 'POST',
						data: 'action=ODC_det&odc='+odc,
						dataType: 'html'
					})
					.done(function(data){
						$("#inv_recep_det tbody").append(data);
						calculos();
					})
					.fail(function(){
					});*/
				}
				if ($('.datatables tbody tr.success').hasClass('success')){
					$('#'+action+'_n').val($('.datatables tbody tr.success .'+action+'_name').text());
					$('#'+action+'_c').val($('.datatables tbody tr.success .'+action+'_id').text());
				}
			}
			if(article==true){
				if(save==true){
					if ($('.datatables tbody tr.success').hasClass('success')){
						var barra=$('.datatables tbody tr.success .'+action+'_code').text(),desc=$('.datatables tbody tr.success .'+action+'_name').text(),
						u=$('.datatables tbody tr.success .'+action+'_und').text(),c=$('.datatables tbody tr.success .'+action+'_cant').text(),
						co=$('.datatables tbody tr.success .'+action+'_cst').text(),cart=$('.datatables tbody tr.success .'+action+'_id').text(),
						iva=$('.datatables tbody tr.success .'+action+'_iva').text();
						counter++;
						var tr ='<tr id="art_'+counter+'">';
						tr=tr+'<td><button name="del_art'+counter+'" id="del_art'+counter+'" class="btn btn-default btn-xs" type="button"><i class="fa fa-times"></i></button><input name="cart'+counter+'" id="cart'+counter+'" type="text" disabled="disabled" class="form-control hidden"></td>';
						tr=tr+'<td><input name="cbarra'+counter+'" id="cbarra'+counter+'" class="form-control" readonly></td>';
						tr=tr+'<td><input name="art'+counter+'" id="art'+counter+'" class="form-control" readonly></td>';
						tr=tr+'<td><select name="und'+counter+'" id="und'+counter+'" class="form-control"></select></td>';
						tr=tr+'<td><input name="cal'+counter+'" id="cant'+counter+'" class="form-control numeric" value="0"></td>';
						tr=tr+'<td><input name="cal'+counter+'" id="costou'+counter+'" class="form-control numeric" value="0"></td>';
						tr=tr+'<td><input name="cal'+counter+'" id="imp'+counter+'" class="form-control numeric"></td>';
						tr=tr+'<td><input name="costot'+counter+'" id="costot'+counter+'" class="form-control" readonly value="0"></td>';
						tr=tr+'</tr>';
						$("#inv_recep_det tbody").append(tr);
						$('#cart'+counter).val(cart);
						$('#cbarra'+counter).val(barra);
						$('#art'+counter).val(desc);
						$('#imp'+counter).val(iva);
						rows++;
						totaliza();
						$.ajax({
							url: './modulos/inventario/modulos/inv_recep/'+location+'.php',
							type: 'POST',
							data: 'action=und',
							dataType: 'html'
						})
						.done(function(data){
							$('#und'+counter).append(data);
						})
						.fail(function(){
						});
						$(".numeric").keydown(function (e){
							acceptNum(e);
						});
						function totaliza(){
							var sub_total=$('input[name^="costot"]').sumValues();
							$('#inv_recep_sub_total_c').val(parseFloat(sub_total));
							$('#inv_recep_total_c').val(parseFloat(sub_total));
							$('#inv_recep_art_c').val(parseFloat(rows));
						}
						$('.form-control').on("input", function (){
							var number = this.name.replace('cal',''), imp=parseFloat('1.'+$('#imp'+number).val());
							var costot = (($('#cant'+number).val()*$('#costou'+number).val())*imp).toFixed(2);
							$('input[name^="costot'+number+'"]').val(costot);
							totaliza();
						});
						$('#del_art'+counter).click(function (){
							var number = this.name.replace('del_art','');
							$('#art_'+number).remove();
							rows--;
							totaliza();
						});
					}
				}
			}
		});
		function send(){
			var cprov='Proveedores', codc='ODC', nfact='factura', ndoc='control', don='donado', calma='Almacenes',
			ffac='f_fact', ob='observacion',table = $('#inv_recep_det'), total_rece='inv_recep_total', valido=true;
			valido = valido && validar(cprov);
			valido = valido && IsNumber(cprov);
			valido = valido && validar(nfact);
			valido = valido && IsNumber(nfact);			
			valido = valido && validar(calma);
			valido = valido && IsNumber(calma);
			valido = valido && validar(ffac);
			if ($('#ch_don').is((':checked'))==false){
				//valido = valido && validar(codc);
				valido = valido && validar(ndoc);
				valido = valido && IsNumber(ndoc);
			}
			valido = valido && count_row(table);
			valido = valido && IsNumber(total_rece);
		}
		$(document).on('click', '.btn', function(e){
			button = $(this).attr('id');
			switch (button){
				case 'Modal_Save':
					save=true;
				break;
				case 'Almacenes_btn':
					action='Almacenes';
					location='ajax_requests';
					save=false;
					article=false;
				break;
				case 'ODC_btn':
					action='ODC';
					location='ajax_requests';
					save=false;
					article=false;
				break;
				case 'Proveedores_btn':
					action='Proveedores';
					location='ajax_requests';
					save=false;
					article=false;
				break;
				case 'Articulos_btn':
					action='Articulos';
					location='ajax_requests';
					save=false;
					article=true;
				break;
				case 'bt_new':
					window.location.href = "?mod=inventario&submod=INV_RECEP";
				break;
				case 'bt_save':
					//alert("Form_Submit");
					send();
				break;
				case 'bt_exit':
					window.location.href = "?mod=inventario";
				break;
				default:
					action='undefined';
					location='undefined';
			}
		});
		$(document).on('click', '.search_data', function(e){
			$('#Modal_Content').html('');
			$('#Modal_loader').show();
			$.ajax({
				url: './modulos/inventario/modulos/inv_recep/'+location+'.php',
				type: 'POST',
				data: 'action='+action,
				dataType: 'html'
			})
			.done(function(data){
				$('#ModalLabel').html('');
				$('#ModalLabel').html(action);
				$('#Modal_Text').html('');
				$('#Modal_Text').html('Filtre según el criterio ingresándolo en el recuadro de <strong>Filtrar</strong>');
				$('#Modal_Text').show();
				$('#Modal_Content').html('');
				$('#Modal_Content').html(data);
				$('#Modal_loader').hide();
				$('.datatables').DataTable({
					responsive: true
				});
				$('.datatables tbody').on( 'click', 'tr', function (){
					if ($(this).hasClass('success')){
						$(this).removeClass('success');
					}else{
						$('.datatables tbody tr.success').removeClass('success');
						$(this).addClass('success');
					}
				});
			})
			.fail(function(){
				$('#ModalLabel').html('');
				$('#ModalLabel').html('Error');
				$('#Modal_Text').html('');
				$('#Modal_Text').hide();
				$('#Modal_Content').html('<i class="fa fa-warning"></i> Ocurrió un problema al intentar cargar la información, consulte a soporte');
				$('#Modal_loader').hide();
			});
		});
	});
</script>
<!-- START BLOCK : inv_recep -->
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row"><div class="col-lg-12"><h2 class="page-header">{mod_name}</h2></div></div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading titulares">RECEPCION DE ARTICULOS</div>
					<div class="panel-body">
						<div class="modal fade" id="Modal_" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title" id="ModalLabel">Error</h4>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="panel panel-default">
												<div class="panel-heading" id="Modal_Text">Error!</div>
												<div class="panel-body">
													<div id="Modal_loader" style="display: none; text-align: center;">
														<img src="./img/loader.gif">
													</div>
													<div class="dataTable_wrapper" id="Modal_Content">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" id="Modal_Close" class="btn btn-default Modal_Close" data-dismiss="modal">CERRAR</button>
										<button type="button" id="Modal_Save" class="btn btn-primary Modal_Save" data-dismiss="modal">ACEPTAR</button>
									</div>
								</div>
							</div>
						</div>
						<form role="form" name="inv_recep_form" id="inv_recep_form">
							<div class="row">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#fact" data-toggle="tab" aria-expanded="true">FACTURA</a></li>
									<li class=""><a href="#det" data-toggle="tab" aria-expanded="false">DETALLE</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade active in" id="fact">
										<div class="col-xs-6 col-md-4">
											<div id="Transacciones_g" class="form-group input-group">
												<label class="control-label" for="Transacciones_c">TRANSACCION</label>
												<input id="Transacciones_c" type="text" disabled="disabled" class="form-control hidden">
												<input id="Transacciones_n" type="text" class="form-control numeric" autofocus>
												<span class="input-group-btn"><button id="btn_ctran" class="btn btn-default search_data" data-toggle="modal" data-target="#Modal_" type="button"><i class="fa fa-search"></i></button></span>
											</div>
											<div id="Proveedores_g" class="form-group input-group">
												<label class="control-label" for="Proveedores_c">PROVEEDOR</label>
												<input id="Proveedores_c" type="text" disabled="disabled" class="form-control hidden">
												<input id="Proveedores_n" type="text" disabled="disabled" class="form-control numeric">
												<span class="input-group-btn"><button id="Proveedores_btn" class="btn btn-default search_data" data-toggle="modal" data-target="#Modal_" type="button"><i class="fa fa-search"></i></button></span>
											</div>
											<fieldset class="donate">
												<div id="ODC_g" class="form-group input-group">
													<label class="control-label" for="ODC_c">ODC</label>
													<input id="ODC_n" type="text" disabled="disabled" class="form-control hidden">
													<input id="ODC_c" type="text" disabled="disabled" class="form-control numeric">
													<span class="input-group-btn"><button id="ODC_btn" class="btn btn-default search_data" data-toggle="modal" data-target="#Modal_" type="button"><i class="fa fa-search"></i></button></span>
												</div>
											</fieldset>
											<div id="factura_g" class="form-group input-group">
												<label class="control-label" for="factura_c">FACTURA</label>
												<input id="factura_c" type="text" class="form-control numeric">
											</div>
											<fieldset class="donate">
												<div id="control_g" class="form-group input-group">
													<label class="control-label" for="control_c">CONTROL</label>
													<input id="control_c" type="text" class="form-control numeric">
												</div>
											</fieldset>
											<div id="observacion_g" class="form-group input-group">
												<label class="control-label" for="observacion">NOTA</label>
												<textarea id="observacion" class="form-control" rows="3"></textarea>
											</div>
										</div>
										<div class="col-xs-6 col-md-4">
											<div id="ch_don_g" class="checkbox"><label class="control-label" for="ch_don"><input id="ch_don" type="checkbox"></label>¿DONADO?</div>
											<div class="form-group input-group">
												<label>ESTATUS</label>
												<input id="status_c" class="form-control" id="disabledInput" type="text" value="PENDIENTE" disabled="disabled">
											</div>
											<div class="form-group input-group">
												<label>ASIENTO</label>
												<input id="asiento_c" class="form-control" id="disabledInput" type="text" value="000000" disabled="disabled">
											</div>
											<div id="Almacenes_g" class="form-group input-group">
												<label class="control-label" for="Almacenes_c">ALMACEN</label>
												<input id="Almacenes_c" type="text" disabled="disabled" class="form-control hidden">
												<input id="Almacenes_n" type="text" disabled="disabled" class="form-control">
												<span class="input-group-btn"><button id="Almacenes_btn" class="btn btn-default search_data" data-toggle="modal" data-target="#Modal_" type="button"><i class="fa fa-search"></i></button></span>
											</div>
										</div>
										<div class="col-xs-6 col-md-4">
											<div id="f_fact_g" class="form-group input-group">
												<label class="control-label" for="f_fact_c">FECHA FACTURA</label>
												<input id="f_fact_c" type="text" class="form-control">
											</div>
											<div id="f_recep_g" class="form-group input-group">
												<label class="control-label" for="f_recep_c">FECHA RECEPCION</label>
												<input id="f_recep_c" class="form-control" type="text" value="{date_now}" disabled="disabled">
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="det">
										<div class="panel panel-default">
											<div class="panel-heading">ARTICULOS</div>
											<div class="panel-body">
												<div class="table-responsive">
													<table id="inv_recep_det" class="table table-hover">
														<thead>
															<tr>
																<th>#</th>
																<th width="50px">C-BARRA</th>
																<th>DESCRIPCION</th>
																<th width="140px">UND</th>
																<th width="80px">CANT</th>
																<th width="150px">PRECIO</th>
																<th width="80px">IVA(%)</th>
																<th width="150px">TOTAL</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>
													<p style="text-align:right;">
														<p></p>
														<a id="Articulos_btn" class="btn btn-default form-btn search_data" data-toggle="modal" data-target="#Modal_"><i class="fa fa-plus"></i> AGREGAR</a>
													</p>
												</div>
												<div class="row show-grid">
													<div class="col-xs-6 col-sm-4">
														<label class="control-label" for="inv_recep_art_c">ARTICULOS</label>
														<input id="inv_recep_art_c" type="text" readonly class="form-control">
													</div>
													<div class="col-xs-6 col-sm-4">
														<label class="control-label" for="inv_recep_sub_total_c">SUB TOTAL</label>
														<input id="inv_recep_sub_total_c" type="text" readonly class="form-control">
													</div>
													<!-- Optional: clear the XS cols if their content doesn't match in height -->
													<div class="clearfix visible-xs"></div>
													<div class="col-xs-6 col-sm-4">
														<label class="control-label" for="inv_recep_total_c">TOTAL</label>
														<input id="inv_recep_total_c" type="text" readonly class="form-control">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12"><p></p><div id="log_error" class="log_error alert alert-danger">MENSAJE DE ERROR</div></div>
							</div>
							<div class="row">
								<div class="col-lg-12">
								<p style="text-align:center;">
									<a id="bt_new" class="btn btn-default form-btn"><i class="fa fa-file-o"></i> NUEVO</a>
									<a id="bt_save" class="btn btn-default form-btn"><i class="fa fa-save"></i> GUARDAR</a>
									<a id="bt_print" class="btn btn-default form-btn"><i class="fa fa-print"></i> IMPRIMIR</a>
									<a id="bt_exit" class="btn btn-default form-btn"><i class="fa fa-sign-out"></i> SALIR</a>
								</p>
								</div>
							</div>
						</form>
					</div>
				</div>			
			</div>
		</div>
	</div>
</div>
<!-- END BLOCK : inv_recep -->