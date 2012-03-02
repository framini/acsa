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
		$this->db->insert('forms', $data);
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
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
	 * Obtiene todos los forms del sistema
	 */
	function get_forms() {
		$query = $this->db->get('forms');
		if($query->num_rows() > 0) return $query;
		return NULL;
	}
	
	/**
	 * Método para modificar un form
	 */
	function modificar_form($form_id, $data) {
		$this->db->where('forms_id', $form_id);
		$this->db->update('forms', $data);
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}