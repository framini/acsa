<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo de datos para grupos de fields
 *
 */
class Grupos_fields extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		
		$this->load->dbforge();
	}
	
	/**
	 * Método para crear un nuevo grupo de fields
	 */
	function create_grupo_fields($data) {
		$this->db->insert('grupos_fields', $data);
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Método para modificar grupo de fields
	 */
	function modificar_grupo_fields($grupo_field_id, $data, $actualizar = FALSE) {
		if($actualizar) {
			//Chequiamos que los fiels asociados al grupo esten presenten en la tabla forms_data
			$fields = $this->get_fields_grupo_fields($grupo_field_id);
			//Procesamos los resultados
			foreach ($fields->result() as $row)
	        {
	           $campos[] = array(
	                'fields_id' => $row->fields_id,
	                'fields_value_defecto' => $row->fields_value_defecto
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

		//Actualizamos los datos del grupo
		$this->db->where('grupos_fields_id', $grupo_field_id);
		if($this->db->update('grupos_fields', $data)) {
			return true;
		} else {
			return false;
		}
	}

	function eliminar_grupo_fields($grupo_field_id) {
		
		$fields = $this->get_fields_grupo_fields($grupo_field_id);
		
		//Comenzamos la transaccion
		$this->db->trans_start();
		if(!empty($fields)) {
			//Procesamos los resultados
			foreach ($fields->result() as $row)
	        {
	           $campos[] =  $row->fields_id;
	        }
			
			
			//Chequeamos que campos son los que tenemos que eliminar en forms_data
	        foreach ($campos as $row) {
				//Eliminamos el registro de forms_data
				if($this->administracion_frr->existe_columna('field_id_' . $row)) {
					$this->dbforge->drop_column('forms_data', 'field_id_' . $row);
				}
	        }
			
			//Eliminamos cada uno de los fields que pertenecen al grupo
			$this->db->where('grupos_fields_id', $grupo_field_id);
			$this->db->delete('fields');

		}
		//Eliminamos el grupo de fields
		$this->db->where('grupos_fields_id', $grupo_field_id);
		$this->db->delete('grupos_fields');
		//Comitiamos la transaccion
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
        	return TRUE;
        }
	}
	
	/**
	 * Devuelve todas los grupos de fields cargadas en el sistema
	 */
     function get_grupos_fields() {
        $this->db->select();
        $this->db->from("grupos_fields");
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) return $query;
        return NULL;
     }
	 
	 /**
	  * Metodo utilizado para determinar si un grupo de fields esta o no en uso
	  */
	 function grupo_fields_en_uso($grupo_field_id) {
	 	$this->db->where('grupos_fields_id', $grupo_field_id);
        
        if ($this->db->count_all_results('forms') > 0) return TRUE;
        return NULL;
	 }
	 
	 
	 
	 /**
	  * Devuelve un registro de un grupo de fields en base al ID pasado como parametro
	  */
	 function get_grupo_field_by_id_row($grupo_field_id) {
        $this->db->select();
		$this->db->where('grupos_fields_id', $grupo_field_id);
        $this->db->from("grupos_fields");
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) return $query;
        return NULL;
     }
	 
	 /**
	  * Devuelve el nombre de un grupo de fields en base a un ID
	  */
	 function get_grupo_field_by_id($grupo_field_id) {
	 	$this->db->select();
		$this->db->where('grupos_fields_id', $grupo_field_id);
		$query = $this->db->get('grupos_fields');
		
		if($query->num_rows() == 1) {
			return $query->row();
		}
		return NULL;
	 }
	 
	 
	 /**
	 * Devuelve todos los fields asociados al grupo
	 */
     function get_fields_grupo_fields($grupo_field_id) {
        $this->db->select('fields.fields_nombre, fields.fields_id, fields.fields_label, fields.fields_instrucciones, fields.fields_value_defecto, fields.fields_requerido, fields.fields_hidden, fields.fields_posicion, fields.fields_type_id, fields.fields_option_items');
        $this->db->from("fields");
		$this->db->where('grupos_fields_id', $grupo_field_id);
		$this->db->order_by('fields.fields_posicion');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) return $query;
        return NULL;
     }
	
	/**
	 * Chequea si el username esta disponible para registro
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_nombre_grupo_fields_disponible($grupos_fields_nombre) {
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(grupos_fields_nombre)=', strtolower($grupos_fields_nombre));

		$query = $this->db->get('grupos_fields');
		return $query->num_rows() == 0;
	}
}