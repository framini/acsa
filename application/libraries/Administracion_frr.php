<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Administracion_frr {
    
    private $error = array();

    public function __construct() {
        $this->ci = & get_instance();
		$this->ci->load->model('admin/grupos_fields');
		$this->ci->load->model('admin/fields');
		$this->ci->load->model('admin/forms');
    }
	
	/**
   	* Devuelve todos los grupos de fields cargadas en el sistema
   	* @return type 
   	*/
     function get_grupos_fields() {
      
        $grupos_fields = $this->ci->grupos_fields->get_grupos_fields();
      
        foreach ($grupos_fields->result() as $row){
          
           $data[] = array(
                'grupos_fields_id'     => $row->grupos_fields_id,
                'grupos_fields_nombre' => $row->grupos_fields_nombre
           );
       }

       return $data;
    }
	 /**
	  * Devuelve una lista con todos los fields type del sistema
	  */
	 function get_fields_types() {
	 	$fields_types = $this->ci->fields->get_fields_types();
      
        foreach ($fields_types->result() as $row){
          
           $data[] = array(
                'fields_type_id'     => $row->fields_type_id,
                'fields_type_nombre' => $row->fields_type_nombre
           );
       }

       return $data;
	 }
	 
	 /**
	  * Devuelve el nombre de un field type en base a su ID
	  */
	 function get_field_type_by_id($fields_type_id) {
	   if(!is_null($field_type = $this->ci->fields->get_field_type_by_id($fields_type_id))) {
	   		return $field_type->fields_type_nombre;
	   } else {
	   	return null;
	   }
	 }
	 
	 /**
	  * Devuelve un form en base a su ID
	  */
	 function get_form_by_id($form_id) {
	   if(!is_null($form = $this->ci->forms->get_form_by_id($form_id))) {
	   		return $form;
	   } else {
	   	return null;
	   }
	 }
	 
	 function get_orden_siguiente_field($grupos_fields_id) {
	 	if(!is_null($orden = $this->ci->fields->get_orden_siguiente_field($grupos_fields_id))) {
	 		$orde_siguiente = $orden->fields_posicion + 1;
	   		return($orde_siguiente);
		} else {
		   	return null;
		}
	 }
	 
	 function get_fields_grupo_fields($grupo_fields_id) {
	 	if(!is_null($orden = $this->ci->grupos_fields->get_fields_grupo_fields($grupo_fields_id))) {
	 		foreach ($orden->result() as $row)
            {
               $data[] = array(
                    'fields_nombre' => $row->fields_nombre, 
                    'fields_id' => $row->fields_id, 
                    'fields_label' => $row->fields_label, 
                    'fields_instrucciones' => $row->fields_instrucciones, 
                    'fields_value_defecto' => $row->fields_value_defecto, 
                    'fields_requerido' => $row->fields_value_defecto, 
                    'fields_hidden' => $row->fields_hidden, 
                    'fields_posicion' => $row->fields_posicion,
                    'fields_type'    => $this->get_field_type_by_id($row->fields_type_id),
                    'fields_constructor' => $this->ci->fieldstypes_frr->get_field_contructor($this->get_field_type_by_id($row->fields_type_id)),
                    'fields_option_items' => $row->fields_option_items
               );
            }
            return $data;
		} else {
		   	return null;
		}
	 }
	/**
	 * Método utilizado para procesar el conjunto de fields asociados a un grupo de fields.
	 * El objetivo de esta funciona es devolver un array listo para ser mostrado en la vista
	 */
	function parser_field_type($fields) {
		foreach ($fields as $field) {
			$data[] = $this->ci->fieldstypes_frr->get_formato_array_field($field);
		}
		
		return ($data);
	}
	
	function create_grupos_fields($grupos_fields_nombre) {
		//Validaciones para los campos requeridos
		$data = array(
			'grupos_fields_nombre' => $grupos_fields_nombre
		);
		if(!$this->is_nombre_grupo_fields_disponible($grupos_fields_nombre)) {
			$this->error['grupos_fields_nombre'] = 'El nombre ya esta siendo utilizado por otro grupo!';
		}
		//Solamente creamos si los campos pasaron la validacion	
		if(empty($this->error)) {
			if($this->ci->grupos_fields->create_grupo_fields($data)) {
			return true;
			} 
		}	
		
		return NULL;
	}
	
	function create_fields($fields_nombre, $fields_label, $fields_instrucciones, $fields_value_defecto, $fields_requerido, $fields_hidden, $fields_posicion, $grupo_field_id, $fields_type_id,$fields_option_items) {
		$data = array(
			'fields_nombre' => $fields_nombre, 
			'fields_label' => $fields_label, 
			'fields_instrucciones' => $fields_instrucciones, 
			'fields_value_defecto' => $fields_value_defecto, 
			'fields_requerido' => $fields_requerido, 
			'fields_hidden' => $fields_hidden, 
			'fields_posicion' => $fields_posicion,
			'fields_type_id'  => $fields_type_id,
			'fields_option_items' => $fields_option_items
		);
		//Validaciones para los campos requeridos
		if(!$this->is_nombre_fields_disponible($fields_nombre)) {
			$this->error['fields_nombre'] = 'El nombre del field ya esta siendo utilizado!';
		}
		//Solamente creamos si los campos pasaron la validacion	
		if(empty($this->error)) {
			if($this->ci->fields->create_fields($data, $grupo_field_id)) {
			return true;
			} 
		}	
		
		return NULL;
	}
	
	function create_form($forms_nombre, $forms_nombre_action, $grupos_fields_id, $forms_descripcion, $forms_titulo, $forms_texto_boton_enviar) {
		$data = array(
			'forms_nombre' => $forms_nombre, 
			'forms_nombre_action' => $forms_nombre_action, 
			'grupos_fields_id' => $grupos_fields_id,
			'forms_descripcion' => $forms_descripcion,
			'forms_titulo' => $forms_titulo,
			'forms_texto_boton_enviar' => $forms_texto_boton_enviar
		);
		//Validaciones para los campos requeridos
		if(!$this->is_nombre_form_disponible($forms_nombre)) {
			$this->error['fields_nombre'] = 'El nombre del Form ya esta siendo utilizado!';
		}
		//Solamente creamos si los campos pasaron la validacion	
		if(empty($this->error)) {
			if($this->ci->forms->create_form($data)) {
			return true;
			} 
		}	
		
		return NULL;
	}
	
	function is_nombre_grupo_fields_disponible($grupos_fields_nombre) {
		return $this->ci->grupos_fields->is_nombre_grupo_fields_disponible($grupos_fields_nombre);
	}
	
	function is_nombre_fields_disponible($fields_nombre) {
		return $this->ci->fields->is_nombre_fields_disponible($fields_nombre);
	}
	
	function is_nombre_form_disponible($form_nombre) {
		return $this->ci->forms->is_nombre_form_disponible($form_nombre);
	}
	
	/**
	 * Devuelve el mensaje de error.
	 * Puede ser usada tras cualquier operacion fallida, como de login o registro.
	 *
	 * @return	string
	 */
	 function get_error_message() {
		return $this->error;
	 }
}