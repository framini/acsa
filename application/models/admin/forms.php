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
	function create_form($data) {
		if($this->db->insert('forms', $data)) {
			return true;
		} else {
			return false;
		}
	}
}