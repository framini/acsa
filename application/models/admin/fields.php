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
		if($this->db->insert('fields', $data)) {
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
		if($this->db->insert('grupos_fields_fields', $data)) {
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
}