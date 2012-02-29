<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fieldstypes_frr {
    
    private $error = array();

    public function __construct() {
        $this->ci = & get_instance();
    }
	
	//Devuelve el constructor del field correspondiente al tipo de field que se le pasa como parametro
	function get_field_contructor($field_type, $is_hidden = false) {
		if($is_hidden) {
			return "form_hidden";
		} else if($field_type == "textarea") {
			return "form_textarea";
		} else if($field_type == "checkbox") {
			return "form_checkboxes";
		} else if($field_type == "radio") {
			return "form_radios";
		} else if($field_type == "dropdown") {
			return "form_dropdown";
		} else if($field_type == "password") {
			return "form_password";
		} else if($field_type == "multiselect") {
			return "form_multiselect";
		} else {
			return "form_input";
		}
		
	}
	
	function get_formato_array_field($field) {
		$data['name'] = $field['fields_nombre'];
		$tipo_field = $field['fields_type'];
		if($tipo_field == "dropdown" || $tipo_field == "multiselect") {
			$data['atributos'] = $this->parse_field_options($field['fields_option_items']);
		} else if($tipo_field == "checkbox" || $tipo_field == "radio") {
			$data['atributos'] = $this->parse_field_options($field['fields_option_items']);		
		} else {
			$data['atributos'] = $this->create_array_atributos($field);
		}
		return $data;
	}
	
	/**
	 * Parsea el texto almacenado en fields.fields_option_items 
	 */
	function parse_field_options($options) {
		//Creamos un JSON en base a las opciones que recibimos como parametro
		//Y lo devolvemos en forma de array
		$optJSON = json_decode("{" . $options . "}", true);
		return($optJSON);
	}
	
	function create_array_atributos($field) {
		return array(
	        'value'             => $field['fields_value_defecto'],
	        'class'             => 'text span5',
	        'id'                => $field['fields_nombre']
		);
	}
	
	function create_array_atributos_checkbox_radio($field) {
		return array(
	        'value'             => $field['fields_value_defecto'],
	        'id'                => $field['fields_nombre']
		);
	}
}