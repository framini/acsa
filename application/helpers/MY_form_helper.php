<?php
function form_input($data = '', $value = '', $extra = '')
{
	$defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);
	if(!is_array($value)) {
		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	}	
	else {
		return "<input "._parse_form_attributes($value, $defaults).$extra." />";
	}
}

function form_textarea($data = '', $value = '', $extra = '')
{
	$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'cols' => '40', 'rows' => '10');

	if ( ! is_array($data) OR ! isset($data['value']))
	{
		$val = $value;
	} 
	else
	{
		$val = $data['value'];
		unset($data['value']); // textareas don't use the value attribute
	}
	
	$name = (is_array($data)) ? $data['name'] : $data;
	
	if(is_array($value)) {
		$val = $value['value'];
		return '<textarea '._parse_form_attributes($value, $defaults).$extra.'>'.form_prep($val, $name)."</textarea>\n";
	}
	return '<textarea '._parse_form_attributes($data, $defaults).$extra.'>'.form_prep($val, $name)."</textarea>\n";
}

function form_checkbox($data = '', $value = '', $checked = FALSE, $extra = '')
{
	$defaults = array('type' => 'checkbox', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

	if (is_array($data) AND array_key_exists('checked', $data))
	{
		$checked = $data['checked'];

		if ($checked == FALSE)
		{
			unset($data['checked']);
		}
		else
		{
			$data['checked'] = 'checked';
		}
	}
	
	//Nuevo
	if(!is_array($data) && is_array($value)) {
		return "<input "._parse_form_attributes($value, $defaults).$extra." />";
	}
	//Fin nuevo

	if ($checked == TRUE)
	{
		$defaults['checked'] = 'checked';
	}
	else
	{
		unset($defaults['checked']);
	}

	return "<input "._parse_form_attributes($data, $defaults).$extra." />";
}

function form_checkboxes($data = '', $value = '', $checked = FALSE, $extra = '')
{
	//Recorremos el array value en busqueda de todos los checkboxes definidos
	$cont = 0;
	echo '<div class="span6 control-group">';
	foreach($value as $key => $val) {
		echo '<label for="'. $data .'" class="checkbox">' ;
		echo '<input type="checkbox" name="'. $data .'" value="'. $val .'" />';
		echo $key . '</label>';
		$cont++;
	}
	echo '</div>';
}

function form_radios($data = '', $value = '', $checked = FALSE, $extra = '')
{
	//Recorremos el array value en busqueda de todos los checkboxes definidos
	$cont = 0;
	echo '<div class="span6 control-group">';
	foreach($value as $key => $val) {
		echo '<label for="'. $data .'" class="radio">' ;
		echo '<input type="radio" name="'. $data .'" value="'. $val .'" />';
		echo $key . '</label>';
		$cont++;
	}
	echo '</div>';
}