<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Administracion_frr {
    
    private $error = array();
	//Utilizada para almancenar los datos de fields comunes a todos los forms
	private $datos_entradas = array();
	//Utilizada para almacenar los datos comunes a todas las entradas. Como autor, fecha de creacion, etc
	private $datos_extras_entradas = array();

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
      	if(isset($grupos_fields) ) {
      		foreach ($grupos_fields->result() as $row){
          
	           $data[] = array(
	                'grupos_fields_id'     => $row->grupos_fields_id,
	                'grupos_fields_nombre' => $row->grupos_fields_nombre
	           );
	       }
	
	       return $data;
      	}
        return NULL;
    }
	 /**
	  * Obtiene todos los formularios del sistema
	  */
	 function get_forms() {
	 	
		$forms = $this->ci->forms->get_forms();
		if(isset($forms)) {
			foreach ($forms->result() as $row){
          
		           $data[] = array(
		                'forms_id'     => $row->forms_id,
		                'forms_nombre' => $row->forms_nombre,
		                'forms_nombre_action' => $row->forms_nombre_action,
		                'grupos_fields_id' => $row->grupos_fields_id,
		                'grupos_fields_nombre' => $this->get_grupo_field_by_id($row->grupos_fields_id),
		                'forms_descripcion' => $row->forms_descripcion,
		                'forms_titulo' => $row->forms_titulo,
		                'forms_texto_boton_enviar' => $row->forms_texto_boton_enviar,
		           );
		    }
		
		    return $data;
		}
		return NULL;
	 }
	 
	 /**
	  * Devuelve el nombre de un grupo de fields en base a un ID
	  */
	 function get_grupo_field_by_id($grupo_field_id) {
	 	$grupo_field = $this->ci->grupos_fields->get_grupo_field_by_id($grupo_field_id);
		if($grupo_field) {
			return $grupo_field->grupos_fields_nombre;
		}
	 	return NULL;
	 }
	 
	 function get_grupo_field_by_id_row($grupo_field_id) {
      
        $grupos_fields = $this->ci->grupos_fields->get_grupo_field_by_id_row($grupo_field_id);
      	
		if($grupos_fields) {
			foreach ($grupos_fields->result() as $row){
          
	           $data[] = array(
	                'grupos_fields_id'     => $row->grupos_fields_id,
	                'grupos_fields_nombre' => $row->grupos_fields_nombre
	           );
	       }

       	   return $data;
		}
        return NULL;
    }
	 /**
	 * Devuelve el grupos_fields_id al cual pertence el field
	 */
	 function get_field_group_id($id) {
	 	$grupo_field_id = $this->ci->fields->get_field_group_id($id);
		if($grupo_field_id) {
			return $grupo_field_id;
		} else {
			return NULL;
		}
	 }
	 
	 /**
	  * Devuelve el nombre de un grupo de fields en base a un ID
	  */
	 function get_field_by_id($field_id) {
	 	$field = $this->ci->fields->get_field_by_id($field_id);
		if($field) {
			return $field;
		}
	 	return NULL;
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
	 
	 /**
	  * Devuelve todos los fields asociados al grupo 
	  */
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
		if(count($fields) > 0) {
			foreach ($fields as $field) {
				$data[] = $this->ci->fieldstypes_frr->get_formato_array_field($field);
			}
			
			return ($data);
		} else {
			return NULL;
		}
	}
	
	function get_entry_by_id($entry_id) {
		$entry = $this->ci->forms->get_entry_by_id($entry_id);
		if($entry) {
			return $entry;
		}
	 	return NULL;
	}
	
	/**
	 * Devuelve en un array los datos almacenados en los fields del form
	 */
	function get_entry_datos_fields($entry) {
		$form_id = $entry->forms_id;
		$entry_id = $entry->entry_id;
		
		//Obtenemos el form al cual pertenece la entrada
		$form = $this->get_form_by_id($form_id);
		$grupo_fields_id = $form->grupos_fields_id;
		
		//Obtenemos el conjunto de fields asociados al grupo de fields
		$fields = $this->get_fields_grupo_fields($grupo_fields_id);
		
		foreach ($fields as $field) {
			//Buscamos los campos custom para el formulario
			if($f = in_object("field_id_" . $field['fields_id'], $entry)) {
				$campos[$f]['atributos'] = array(
					'value'             => $entry->$f,
			        'class'             => 'text span5',
			        'id'                => $entry->$f
				);
			}
		}
		//Seteamos los campos comunes a todos los forms
		$campos['titulo']['atributos'] = array(
					'value'             => $entry->titulo,
			        'class'             => 'text span5',
			        'id'                => 'titulo'
		);
		$campos['url_titulo']['atributos'] = array(
					'value'             => $entry->url_titulo,
			        'class'             => 'text span5',
			        'id'                => 'url_titulo'
		);
		
		if(isset($campos)) {
			return $campos;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Metodo utilizado para parsear el arreglo POST proveniente de los forms generados dinamicamente
	 * Devuelve el conjunto de datos a insertar si los datos fueron correctamente parseados y validados
	 */
	function parser_post($post) {
		if(count($post) > 0) {
			$data = array();
			foreach ($post as $key => $value) {
				//Obtenemos el registro del feild
				if(!is_null($f = $this->ci->fields->get_field_by_id(field_name_parser($key)))) {
					//Lo almacenamos en una array con la estructura que utiliza la tabla en BDD
					$data['field_id_' . $f->fields_id] = $value;
					
					//Chequeamos si el campo es requerido
					if($f->fields_requerido != 0) {
						//Si es requerido, seteamos reglas de validacion
						$this->ci->form_validation->set_rules('field_id_' . $f->fields_id,$f->fields_label, 'trim|required|xss_clean');
					} else {
						//Si no es requerido solo lo limpiamos
						$this->ci->form_validation->set_rules('field_id_' . $f->fields_id,$f->fields_label, 'trim|xss_clean');
					}
				}
			}

			//Validacion datos comunes todos los forms
			$this->ci->form_validation->set_rules('titulo', 'Titulo', 'trim|required|xss_clean');
			$this->ci->form_validation->set_rules('url_titulo', 'Titulo', 'trim|required|xss_clean');

			if($this->ci->form_validation->run()) {
				
				//Datos comunes a todos los forms
				$this->datos_entradas['titulo'] = $this->ci->form_validation->set_value('titulo');
				$this->datos_entradas['url_titulo'] = $this->ci->form_validation->set_value('url_titulo');
				
				return $data;
			} else {
				
				$this->error['datos_incompletos'] = 'Completa los fields requeridos!';
				return NULL;
			}
		} else {
			return NULL;
		}
	}
	
	/**
	 * Metodo utilizado para persistir los datos enviados por los forms creados dinamicamente
	 */
	function persistir_datos_form($forms_id,$data) {
		$data['forms_id'] = $forms_id;
		if(empty($this->error)) {
			if($this->ci->forms->persistir_datos_form($data, $this->get_datos_entradas())) {
				return true;
			} 
		}
		
		return NULL;
	}
	
	/**
	 * Metodo utilizado para actualizar los datos enviados por los forms creados dinamicamente
	 */
	function actualizar_datos_form($forms_id, $data, $entry_id) {
		if(empty($this->error)) {
			if($this->ci->forms->actualizar_datos_form($data, $this->get_datos_entradas(), $entry_id)) {
				return true;
			} 
		}
		
		return NULL;
	}
	
	/**
	 * Metodo para chequear la existencia de una columna en una tabla
	 */
	function existe_columna($columna, $tabla = "forms_data") {
		if ($this->ci->fields->existe_columna($columna, $tabla)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	
	/**
	 * Método utilizado para crear un nuevo grupo de fields
	 */
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
	
	function modificar_grupos_fields($grupo_field_id, $grupos_fields_nombre) {
		//Validaciones para los campos requeridos
		$data = array(
			'grupos_fields_nombre' => $grupos_fields_nombre
		);
		
		if(!$this->verificacion_nombre_grupo_field($grupo_field_id, $grupos_fields_nombre)) {
			$this->error['grupos_fields_nombre'] = 'El nombre ya esta siendo utilizado por otro grupo!';
		} 
		//Solamente modificamos si los campos pasaron la validacion	
		if(empty($this->error)) {
			//Chequeamos si el grupo esta siendo usado por algun formulario
			if($this->grupo_fields_en_uso($grupo_field_id)) {
				//Si esta siendo utilizado chequeamos que los fields que pertenecen al grupo esten creados en forms_data
				if($this->ci->grupos_fields->modificar_grupo_fields($grupo_field_id, $data, TRUE)) {
					return true;
				} else {
					return NULL;
				}
			} else {
				//El grupo no esta siendo usado por ningun formulario
				if($this->ci->grupos_fields->modificar_grupo_fields($grupo_field_id, $data, FALSE)) {
					return true;
				} else {
					return NULL;
				}
			}
		}	
		
		return NULL;
	}
	/**
	 * Metodo para comprobar si un grupo de fields esta siendo usado por al menos un formulario
	 */
	function grupo_fields_en_uso($grupo_field_id) {
		if($this->ci->grupos_fields->grupo_fields_en_uso($grupo_field_id)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Metodo para comprobar si un grupo de fields esta siendo usado por al menos un formulario
	 */
	function field_en_uso($field_id) {
		if($this->ci->fields->existe_columna('field_id_' . $field_id, 'forms_data')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function modificar_form($forms_id, $data) {
		
		//Validaciones para los campos requeridos
		if(!$this->verificacion_nombre_form($forms_id, $data['forms_nombre'])) {
			$this->error['fields_nombre'] = 'El nombre del Form ya esta siendo utilizado!';
		}
		//Solamente creamos si los campos pasaron la validacion	
		if(empty($this->error)) {
			//Si el grupo no estaba siendo usado por otro form
			//actualizamos la tabla forms_data con los nuevos fields
			if(!$this->grupo_fields_en_uso($data['grupos_fields_id'])) {
				if($this->ci->forms->modificar_form($forms_id, $data, TRUE)) {
					return TRUE;
				} else {
					return NULL;
				}
			} else {
				//El grupo ya esta en uso con lo cual no actualizamos la tabla forms_data
				if($this->ci->forms->modificar_form($forms_id, $data, FALSE)) {
					return TRUE;
				} else {
					return NULL;
				}
			}
			 
		}	
		
		return NULL;
	}
	
	function modificar_field($field_id, $data) {
		if(!$this->verificacion_nombre_field($field_id, $data['fields_nombre'])) {
			$this->error['grupos_fields_nombre'] = 'El nombre ya esta siendo utilizado por otro field!';
		}
		//Solamente modificamos si los campos pasaron la validacion	
		if(empty($this->error)) {
			//Chequeamos que el grupo al cual pertence el field este en uso por al menos un form
			if($this->grupo_fields_en_uso($data['grupos_fields_id'])) {
				//Si el field no esta en uso (Es nuevo al grupo) lo creamos
				if(!$this->field_en_uso($field_id)) {
					//Actualizamos el field y creamos la columna en forms_data
					if($this->ci->fields->modificar_field($field_id, $data, TRUE)) {
						return TRUE;
					} 
				} else {
					//Actualizamos el field
					if($this->ci->fields->modificar_field($field_id, $data, FALSE)) {
						return true;
					}
				}
				
			} else {
				if($this->ci->fields->modificar_field($field_id, $data, FALSE)) {
					return true;
				} 
			}
		}	
		
		return NULL;
	}
	
	function verificacion_nombre_grupo_field($grupo_field_id, $nombre) {
		//Si el nombre esta disponible entramos
		//O sino chequeamos que se esten editando otros datos de un grupo que no sea su nombre
		if($this->is_nombre_grupo_fields_disponible($nombre) || $this->is_mismo_grupo($nombre, $grupo_field_id)) {
			return true;
		} else {
			return false;
		}
	}
	
	function verificacion_nombre_field($field_id, $field_nombre) {
		//Si el nombre esta disponible entramos
		//O sino chequeamos que se esten editando otros datos de un grupo que no sea su nombre
		if($this->is_nombre_fields_disponible($field_nombre) || $this->is_mismo($field_id, $field_nombre)) {
			return true;
		} else {
			return false;
		}
	}
	
	function verificacion_nombre_form($form_id, $form_nombre) {
		if($this->is_nombre_form_disponible($form_nombre) || $this->is_mismo($form_id, $form_nombre, "forms")) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Funcion usada para verificacion a la hora de modificar un grupo de fields
	 * Sirve para validar que se este modificando datos en el grupo de fields correcto
	 * Chequea que en caso de que el nombre del grupo ya este en el sistema se lo compare
	 * con el nombre del grupo con el ID de empresa a editar. En caso de ser el mismo
	 * es valido realizar la modificacion de datos
	 */
	function is_mismo_grupo($nombre, $id) {
		$gf = $this->get_grupo_field_by_id($id);

		if($gf  == $nombre) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Funcion usada para verificacion a la hora de modificar un field
	 */
	function is_mismo($id, $nombre, $tipo = null) {
		if(isset($tipo) && $tipo == "forms") {
			$f = $this->get_form_by_id($id);
			if($f->forms_nombre  == $nombre) {
			return true;
			} else {
				
				return false;
			}
		} else {
			$f = $this->get_field_by_id($id);
			if($f->fields_nombre  == $nombre) {
				return true;
			} else {
				return false;
			}
		}
		
		
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
			'fields_option_items' => $fields_option_items,
			'grupos_fields_id' => $grupo_field_id
		);
		//Validaciones para los campos requeridos
		if(!$this->is_nombre_fields_disponible($fields_nombre)) {
			$this->error['fields_nombre'] = 'El nombre del field ya esta siendo utilizado!';
		}
		//Solamente creamos si los campos pasaron la validacion	
		if(empty($this->error)) {
			//Chequeamos que el grupo al cual pertence el field este en uso por al menos un form
			if($this->grupo_fields_en_uso($grupo_field_id)) {
				//Si el grupo esta siendo usado por algun formulario creamos el nuevo campo en forms_data
				if($this->ci->fields->create_fields($data, TRUE)) {
					return TRUE;
				} 
			} else {
				if($this->ci->fields->create_fields($data, FALSE)) {
					return true;
				} 
			}
			/*if($this->ci->fields->create_fields($data, $grupo_field_id)) {
			return true;
			} */
		}	
		
		return NULL;
	}

	function eliminar_field($field_id) {
		if($this->ci->fields->eliminar_field($field_id)) {
			return true;
		} else {
        	return false;
        }  
	}
	
	function eliminar_grupo_fields($grupo_field_id) {
		if($this->ci->grupos_fields->eliminar_grupo_fields($grupo_field_id)) {
			return true;
		} else {
        	return false;
        }   
	}
	
	function eliminar_form($form_id) {
		if($this->ci->forms->eliminar_form($form_id)) {
			return true;
		} else {
        	return false;
        }
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
			//Si el grupo no estaba siendo usado por otro form
			//actualizamos la tabla forms_data con los nuevos fields
			if(!$this->grupo_fields_en_uso($data['grupos_fields_id'])) {
				if($this->ci->forms->create_form($data, TRUE)) {
					return TRUE;
				} 
			} else {
				//El grupo de fields ya esta siendo utilizado por otro form con lo cual los fields ya deben estar presentens en forms_data
				if($this->ci->forms->create_form($data, FALSE)) {
					return TRUE;
				} 
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
	 
	 /**
	  * Devuelve un arreglo con todos los datos comunes a los forms
	  */
	 function get_datos_entradas() {
		return $this->datos_entradas;
	 }
	 
	 /**
	  * Devuelve un arreglo con todos los datos extras de una entrada
	  * Ejemplo: fecha de creacion, fecha de edicion, autor, etc
	  */
	 function get_datos_extras_entradas($entry) {

	 	//Seteamos datos extras comunes a todas las entries
		$this->datos_extras_entradas['numero_entrada'] = $entry->entry_id;
		$this->datos_extras_entradas['form'] = $entry->forms_id;
		$this->datos_extras_entradas['autor'] = $entry->autor_id;
		$this->datos_extras_entradas['fecha_creacion'] = $entry->entry_date;
		$this->datos_extras_entradas['fecha_edicion'] = $entry->edit_date;
		
	 	return $this->datos_extras_entradas;
	 }
}