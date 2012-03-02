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
	function create_fields($data, $grupo_field_id) {
		$this->db->insert('fields', $data);
		//Chequeamos que se haya insertado la info
		if($this->db->affected_rows() > 0) {
			$fields_id = $this->db->insert_id();
			if($this->create_relacion_grupo_field($fields_id, $grupo_field_id)) {
				return true;
			}
		} 
		
		return false;
	}
	/**
	 * Inserta los datos en la tabla de relacion grupos_fields - fields
	 */
	function create_relacion_grupo_field($fields_id, $grupo_field_id) {
		$data = array(
			'grupos_fields_id' => $grupo_field_id,
			'fields_id' => $fields_id
		);
		$this->db->insert('grupos_fields_fields', $data);
		if($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
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
		$this->db->select_max('fields.fields_posicion')
				 ->from('grupos_fields_fields')
				 //->join('grupos_fields_fields', 'grupos_fields_fields.grupos_fields_id = grupos_fields.grupos_fields_id', 'left inner')
				 ->join('fields', 'grupos_fields_fields.fields_id = fields.fields_id', 'left inner')
				 ->where('grupos_fields_fields.grupos_fields_id', $grupos_fields_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) return $query->row();

        return null;
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
	 
	 /**
	 * Método para modificar un field
	 */
	function modificar_field($field_id, $data) {
		$this->db->where('fields_id', $field_id);
		$this->db->update('fields', $data);
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}