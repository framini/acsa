<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo de datos para Templates
 *
 */
class Templates extends CI_Model
{

	function __construct()
	{
		parent::__construct();

	}
	
	/**
	 * Metodo utilizado para persistir un template en la base de datos
	 */
	function create_template($data) {
		$data['edit_date'] = date('Y-m-d H:i:s');
		$this->db->insert('templates', $data);
		
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return NULL;
		}
	}
	
	function obtener_template($template_group, $template) {
		$sql = "SELECT templates.nombre, 
				templates.template_id, 
				templates.data, 
				templates.edit_date,
				templates_groups.nombre
		FROM	templates_groups, templates
		WHERE  templates_groups.template_group_id  = templates.template_group_id ";
				

		if ($template != '')
		{
			$sql .= " AND templates.nombre = '".$this->db->escape_str($template)."' ";
		}

				
		$query = $this->db->query($sql);
		
		$row = $query->row_array();
		
		return $row['data'];
	}
}