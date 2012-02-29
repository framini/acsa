$(function() {
	//Por default el campo de Options está oculto
	$('#fields_option_items').hide();
	
	$('select[name=fields_type_id]').on('change', function() {
		//-----------------	
		//1 = text
		//2 = textarea
		//3 = checkbox
		//4 = radio
		//5 = dropdown
		//6 = multiselect
		//-----------------
		if($(this).val() == "5" || $(this).val() == "6") {
			$('#valor_defecto').slideUp('slow');
			$('#tipo_hidden').slideUp('slow');
			$('#valor_defecto').slideUp('slow');
			$('#fields_option_items').slideDown('slow');
		} else if($(this).val() == "1") {
			$('#valor_defecto').slideDown('slow');
			$('#tipo_hidden').slideDown('slow');
			
			$('#fields_option_items').slideUp('slow');
		} else if($(this).val() == "2") {
			$('#valor_defecto').slideUp('slow');
			$('#tipo_hidden').slideUp('slow');
			$('#fields_value_defecto').slideDown('slow');
		} else if($(this).val() == "3" || $(this).val() == "4") {
			$('#valor_defecto').slideUp('slow');
			$('#tipo_hidden').slideUp('slow');
			$('#valor_defecto').slideUp('slow');
			$('#fields_option_items').slideDown('slow');
		} else {
			$('#valor_defecto').slideUp('slow');
			$('#fields_option_items').slideUp('slow');
		}
	});
});