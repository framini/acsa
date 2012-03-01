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
	}
	
	/**
	 * Método para crear un nuevo grupo de fields
	 */
	function create_grupo_fields($data) {
		if($this->db->insert('grupos_fields', $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Método para modificar grupo de fields
	 */
	function modificar_grupo_fields($grupo_field_id, $data) {
		$this->db->where('grupos_fields_id', $grupo_field_id);
		if($this->db->update('grupos_fields', $data)) {
			return true;
		} else {
			return false;
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
        $this->db->from("grupos_fields_fields");
		$this->db->join('fields', 'fields.fields_id = grupos_fields_fields.fields_id');
		$this->db->where('grupos_fields_fields.grupos_fields_id', $grupo_field_id);
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