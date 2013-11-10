<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo de datos para formularios
 *
 */
class fields extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
	}
	
	/**
	 * Método para crear un nuevo grupo de fields
	 */
	function create_fields($data, $actualizar = FALSE) {
		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();
		$this->db->insert('fields', $data);
		$query = $this->db->query('SELECT LAST_INSERT_ID()');
  		$row = $query->row_array();
  		$id = $row['LAST_INSERT_ID()'];
		//Chequeamos que se haya insertado la info
		if($this->db->affected_rows() > 0) {
			//Si ingresamos aca significa que el grupo al cual pertenece el field esta en uso
			if($actualizar) {
				//Si la columna no existe guardamos los datos en un array para luego poder crearlos en forms_data
				if(!$this->administracion_frr->existe_columna('field_id_' . $id)) {
						$campos_a_crear['field_id_' . $id] = array(
							'type' => 'TEXT',
							'null' => TRUE
						);
				}
				//Si entramos aca creamos los campos en forms_data
				if(isset($campos_a_crear)) {
					$this->dbforge->add_column('forms_data', $campos_a_crear);
				}
				
				return TRUE;
			} else {
				return true;
			}
			
		} 
		
		return false;
	}
	
	
	function eliminar_field($field_id) {

		//Eliminamos el registro de forms_data
		if($this->existe_columna('field_id_' . $field_id)) {
			$this->dbforge->drop_column('forms_data', 'field_id_' . $field_id);
		}
		//Comenzamos la transaccion
		$this->db->trans_start();
		
		//Eliminamos el registro de la tabla fields
		$this->db->where('fields_id', $field_id);
		$this->db->delete('fields');
		
		//Comitiamos la transaccion
		$this->db->trans_complete();
		
        if($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
        	return TRUE;
        }
	}
	
	/**
	 * Chequea si el nombre del field esta disponible
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_nombre_fields_disponible($fields_nombre) {
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(fields_nombre)=', strtolower($fields_nombre));

		$query = $this->db->get('fields');
		return $query->num_rows() == 0;
	}
	
	function get_orden_siguiente_field($grupos_fields_id) {
		$this->db->select_max('fields_posicion')
				 ->from('fields')
				 ->where('grupos_fields_id', $grupos_fields_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) return $query->row();

        return null;
	}
	
	/**
	 * Devuelve el grupos_fields_id al cual pertence el field
	 */
	function get_field_group_id($field_id) {
		$this->db->where('fields_id', $field_id);
		$this->db->select('grupos_fields_id');
		$this->db->from('fields');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->row()->grupos_fields_id;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Devuelve una lista con todos los fields types cargados
	 */
	function get_fields_types() {
		$query = $this->db->select()
                          ->from('fields_types')
                          ->get();

        if($query->num_rows() > 0)
        {
            return $query;
        }
		
		return NULL;
	}
	
	/**
	 * Devuelve el record de field type en base a un ID
	 *
	 */
	function get_field_type_by_id($field_type_id)
	{
		$this->db->where('fields_type_id', $field_type_id);

		$query = $this->db->get('fields_types');
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	  /**
	  * Devuelve el registro del field en base a un ID
	  */
	 function get_field_by_id($field_id) {
	 	$this->db->select();
		$this->db->where('fields_id', $field_id);
		$query = $this->db->get('fields');
		
		if($query->num_rows() == 1) {
			return $query->row();
		}
		return NULL;
	 }
	 
	 function get_field_by_nombre($nombre) {
	 	$this->db->select();
		$this->db->where('fields_nombre', $nombre);
		$query = $this->db->get('fields');
		
		if($query->num_rows() == 1) {
			return $query->row();
		}
		return NULL;
	 }
	 
	 function get_nombre_field_by_id($field_id) {
	 	$this->db->select('fields_nombre');
		$this->db->where('fields_id', $field_id);
		$query = $this->db->get('fields');
		
		if($query->num_rows() == 1) {
			return $query->row();
		}
		return NULL;
	 }
	 
	 /**
	 * Metodo para chequear la existencia de una columna en una tabla
	 */
	 function existe_columna($columna, $tabla = "forms_data") {
	 	
		if ($this->db->field_exists($columna, $tabla)) {
			return TRUE;
		} else {
			return FALSE;
		}
	 }
	 
	 /**
	 * Método para modificar un field
	 */
	function modificar_field($field_id, $data, $actualizar = FALSE) {
		if($actualizar) {
			//Chequeamos que los fields asociados al grupo esten presenten en la tabla forms_data
			$fields = $this->administracion_frr->get_fields_grupo_fields($data['grupos_fields_id']);
		
			//Procesamos los resultados
			foreach ($fields as $row)
	        {
	           $campos[] = array(
	                'fields_id' => $row['fields_id'],
	                'fields_value_defecto' => $row['fields_value_defecto']
	           );
	        }

			//Chequeamos que campos son los que tenemos que actualizar en forms_data
	        foreach ($campos as $row) {
	            //print_r($row['fields_nombre']);
				//Si la columna no existe guardamos los datos en un array para luego poder crearlos
				if(!$this->administracion_frr->existe_columna('field_id_' . $row['fields_id'])) {
					$campos_a_crear['field_id_' . $row['fields_id']] = array(
						'type' => 'TEXT',
						'null' => TRUE
					);
				}
	        }
			//Si entramos aca creamos los campos en forms_data
			if(isset($campos_a_crear)) {
				//Insertamos las columnas en forms_data
				foreach($campos_a_crear as $id => $campo) {
					$this->dbforge->add_column('forms_data', array($id => $campo));
				}
			}
		}
		unset($data['grupos_fields_id']);
		
		$this->db->where('fields_id', $field_id);
		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();
		if($this->db->update('fields', $data)) {
			return true;
		} else {
			return false;
		}
	}
}