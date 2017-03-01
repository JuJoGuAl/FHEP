$.fn.mulValues = function() {
	var sum = 1; 
	this.each(function() {
		var val = $(this).val();
		sum = parseFloat('0'+val)*sum;		
	});
	return sum.toFixed(2);
};
$.fn.sumValues = function() {
	var sum = 0; 
	this.each(function() {
		if ( $(this).is(':input') ) {
			var val = $(this).val();
		} else {
			var val = $(this).text();
		}
		sum += parseFloat( ('0' + val).replace(/[^0-9-\.]/g, ''), 10 );		
	});
	return sum.toFixed(2);
};
/*
Utilizado en Inv_recep
Valida que el campo tenga un valor y / o una propiedad
*/
function validar(obj){
	element=$('#'+obj+'_c');
	var val='', label = $("label[for='"+obj+"_c']").text();
	/*if (typeof attr !== typeof undefined && attr !== false){
		val=obj.attr('data-code');
	}else{
		if (obj.is(':input')){
			val = obj.val();
		 }else{
		 	val = obj.text();
		}
	}*/
	if (element.is(':input')){
		val = element.val();
	 }else{
	 	val = element.text();
	}
	if(val==''){
		$('#'+obj+'_g').addClass("has-error");
		$('#log_error').html('El Campo '+label+' es requerido!');
		$('#log_error').fadeIn('slown');
		return false;
	}else{
		//$('#'+obj+'_g').removeClass("has-error");
		$('.has-error').removeClass("has-error");
		$('#log_error').fadeOut('slown');
		return true;
	}
}
function IsNumber(obj){
	var vRegExp = /[0-9 -()+]+$/;
	element=$('#'+obj+'_c');
	var val='', label = $("label[for='"+obj+"_c']").text();
	if (element.is(':input')){
		val = element.val();
	 }else{
	 	val = element.text();
	}
	if(val!=''){
		if(val<=0){
			$('#'+obj+'_g').addClass("has-error");
			$('#log_error').html('El Campo '+label+' no puede ser 0');
			$("#log_error").fadeIn('slown');
			return false;
		}else{
			if(val.match(vRegExp)){
			$('#'+obj+'_g').removeClass("has-error");
			$("#log_error").fadeOut('slown');
			return true;
		}else{
			$('#'+obj+'_g').addClass("has-error");
			$('#log_error').html('El Campo '+label+' debe contener solo números');
			$("#log_error").fadeIn('slown');
			return false;
		}
		}
	}	
}
function ver_totales(obj){
	var vRegExp = /[0-9 -()+]+$/;
	element=$('#'+obj+'_c');
	var val='', label = $("label[for='"+obj+"_c']").text();
	if (element.is(':input')){
		val = element.val();
	 }else{
	 	val = element.text();
	}
	if(val!=''){
		if(val<=0){
			$('#'+obj+'_g').addClass("has-error");
			$('#log_error').html('El Campo '+label+' no puede ser 0');
			$("#log_error").fadeIn('slown');
			return false;
		}else{
			if(val.match(vRegExp)){
			$('#'+obj+'_g').removeClass("has-error");
			$("#log_error").fadeOut('slown');
			return true;
		}else{
			$('#'+obj+'_g').addClass("has-error");
			$('#log_error').html('El Campo '+label+' debe contener solo números');
			$("#log_error").fadeIn('slown');
			return false;
		}
		}
	}	
}
/*
Utilizado en Inv_recep
Cuenta las Rows que tenga una tabla
*/
function count_row(tbl){
	var id = tbl.attr('id'), table=$('#'+id+' tbody tr').length;
	if(table<=0){
		$('#log_error').html('No existen detalles para la transacción');
		$('#log_error').fadeIn('slown');
		return false;
	}else{
		$('#log_error').fadeOut('slown');
		return true;
	}
}
function IsMail(valor){
	var vRegExp = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;		
	var nomcamp = valor.attr('name');
	if (valor.val()!=''){
		if(valor.val().match(vRegExp)){
		$("#obg_"+nomcamp).fadeOut('slown');
		return true;
	}else{
		$("#obg_"+nomcamp).html('Formato de correo invalido');
		$("#obg_"+nomcamp).fadeIn('slown');
		return false;
	}
	}	
}
function IsRif(valor){
	var vRegExp = /^(j|J)(-)(\d{8})(-)(\d{1})$/;		
	var nomcamp = valor.attr('name');
	if (valor.val()!=''){
		if(valor.val().match(vRegExp)){
		$("#obg_"+nomcamp).fadeOut('slown');
		return true;
	}else{
		$("#obg_"+nomcamp).html('El Rif no cumple con el Formato requerido');
		$("#obg_"+nomcamp).fadeIn('slown');
		return false;
	}
	}	
}
function IsLoggin(valor){
	var vRegExp = /^[a-zA-Z0-9_-]{3,20}$/;		
	var nomcamp = valor.attr('name');
	if (valor.val()!=''){
		if(valor.val().match(vRegExp)){
		$("#obg_"+nomcamp).fadeOut('slown');
		return true;
	}else{
		$("#obg_"+nomcamp).html('El Login solo puede contener entre 3 a 20 Car&aacute;cteres<br>(a-z), (0-9) (_ y -)');
		$("#obg_"+nomcamp).fadeIn('slown');
		return false;
	}
	}	
}
function isLetter(valor){
	var vRegExp = /^[ a-zA-Z]{3,50}$/;		
	var nomcamp = valor.attr('name');
	if (valor.val()!=''){
		if(valor.val().match(vRegExp)){
		$("#obg_"+nomcamp).fadeOut('slown');
		return true;
	}else{
		$("#obg_"+nomcamp).html('El Campo debe contener entre 3 a 50 Car&aacute;cteres');
		$("#obg_"+nomcamp).fadeIn('slown');
		return false;
	}
	}	
}
//Con esta funcion obligo a que un text solo acepte numeros
function acceptNum(e){
	// Allow: backspace, delete, tab, escape, enter and .
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		// Allow: Ctrl+A, Command+A
		(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
		// Allow: home, end, left, right, down, up
		(e.keyCode >= 35 && e.keyCode <= 40)){
			// let it happen, don't do anything
		return;
	}
	// Ensure that it is a number and stop the keypress
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		return e.preventDefault();
	}
}