<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo de datos para formularios
 *
 */
class Forms extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
	}
	
	/**
	 * Chequea si el nombre del form esta disponible
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_nombre_form_disponible($form_nombre) {
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(forms_nombre)=', strtolower($form_nombre));

		$query = $this->db->get('forms');
		return $query->num_rows() == 0;
	}
	
	/**
	 * Método para crear un nuevo Form
	 */
	function create_form($data, $actualizar = FALSE) {
		if($actualizar) {
			//Chequiamos que los fiels asociados al grupo esten presenten en la tabla forms_data
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

		$this->db->insert('forms', $data);
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Metodo utilizado para persistir en forms_data los datos enviados en los formularios 
	 */
	function persistir_datos_form($data, $entrada) {
		//Datos comunes a todos los forms
		$entrada['autor_id'] = $this->auth_frr->get_user_id();
		$entrada['ip_address'] = $this->session->userdata('ip_address');
		$entrada['entry_date'] = date('Y-m-d H:i:s');
		$entrada['edit_date'] = date('Y-m-d H:i:s');
		$entrada['forms_id'] = $data['forms_id'];
		
		//Comenzamos la transaccion
		$this->db->trans_start();
		
		$this->db->insert('forms_entradas', $entrada);
		//Almacenamos el entry_id devuelto del insert anterior
		$data['entry_id'] = $this->db->insert_id();
		
		$this->db->insert('forms_data', $data);

		//Comitiamos la transaccion
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
        	return TRUE;
        }
	}
	
	/**
	 * Metodo utilizado para persistir en forms_data los datos enviados en los formularios 
	 */
	function actualizar_datos_form($data, $entrada, $entry_id) {
		//Datos comunes a todos los forms
		$entrada['edit_date'] = date('Y-m-d H:i:s');

		//Comenzamos la transaccion
		$this->db->trans_start();
		
		$this->db->where('entry_id', $entry_id);
		$this->db->update('forms_entradas', $entrada);

		$this->db->where('entry_id', $entry_id);
		$this->db->update('forms_data', $data);

		//Comitiamos la transaccion
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
        	return TRUE;
        }
	}
	
	/**
	 * Devuelve un form en base al ID pasado como parametro
	 */
	function get_form_by_id($form_id)
	{
		$this->db->where('forms_id', $form_id);

		$query = $this->db->get('forms');
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}
	
	/**
	 * Devuelve un form en base al ID pasado como parametro
	 */
	function get_form_id_by_nombre($form_nombre)
	{
		$this->db->where('forms_nombre', $form_nombre);
		$query = $this->db->get('forms');
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}
	
	/**
	 * Metodo utilizado para ver si una entrada existe.
	 * Chequea en la tabla forms_entradas que exista una entrada con ese id
	 */
	function entry_exist($entry_id) {
		$this->db->where('entry_id', $entry_id);
		$this->db->from('forms_entradas');
		$count = $this->db->count_all_results();
		
		if ($count == 1) return true;
		return NULL;
	}
	
	/**
	 * Metodo utilizado para eliminar un entry del sistema
	 */
	function eliminar_entry($entry_id) {
		//Iniciamos la transacccion
		$this->db->trans_start();
		
		$this->db->where('entry_id', $entry_id);
		
		$tablas = array('forms_entradas', 'forms_data');
		$this->db->delete($tablas);
		
		//Comitiamos la transaccion
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE) {
            return NULL;
        } else {
        	return TRUE;
        }
	}
	
	/**
	 * Devuelve todas las entradas del sistema
	 */
	function get_entries() {
		$this->db->select();
        $this->db->from("forms_entradas");
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) return $query;
        return NULL;
	}
	
	/**
	 * Devuelve un entry en base al ID pasado como parametro
	 */
	function get_entry_by_id($entry_id) {
		$query = $this->db->query("SELECT * FROM forms_entradas as Fe INNER JOIN forms_data AS Fd ON Fd.entry_id = Fe.entry_id WHERE Fe.entry_id = {$entry_id}");

		if ($query->num_rows() > 0 ) return $query->row();
		return NULL;
	}
	
	/**
	 * Obtiene todos los forms del sistema
	 */
	function get_forms() {
		$query = $this->db->get('forms');
		if($query->num_rows() > 0) return $query;
		return NULL;
	}
	
	function eliminar_form($form_id) {
		//Comenzamos la transaccion
		$this->db->trans_start();
		
		$tablas = array('forms_data', 'forms', 'forms_entradas');
		$this->db->where('forms_id', $form_id);
		$this->db->delete($tablas);
		
		//Comitiamos la transaccion
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
        	return TRUE;
        }
	}
	
	/**
	 * Método para modificar un form
	 */
	function modificar_form($form_id, $data, $actualizar = FALSE) {
		
		if($actualizar) {
			//Chequiamos que los fiels asociados al grupo esten presenten en la tabla forms_data
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
		
		$this->db->where('forms_id', $form_id);
		$this->db->update('forms', $data);
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}