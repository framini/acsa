<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo de datos para Templates
 *
 */
define("FE", "Fe.");
define("FD", "Fd.");

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
	
	/**
	 * Obtenemos todo el contenido de un form
	 */
	function get_contenido_by_form($fields_grupo_fields, $form_id) {

		$campos = "";
		$indice = 0;
		
		foreach($fields_grupo_fields as $field) {
			//Fd es el alias de form_data
			//field_id_ es el prefijo que tienen todas las columnas en forms data
			//Ver de hacer esto en alguna otra parte
			$campos .= FD . "field_id_" . $field;
			if($indice < count($fields_grupo_fields) - 1) {
				$campos .= ", ";
			}
			$indice++;
		}
		//Declaramos los campos generales a todos los forms
		$campos_generales = FE . "entry_id, " . FE . "autor_id, " . FE . "ip_address, " . FE . "titulo, " . FE . "url_titulo, " . FE . "entry_date, " . FE . "edit_date, ";
		
		$query = $this->db->query("SELECT {$campos_generales}{$campos} FROM forms_entradas as Fe LEFT JOIN forms_data as Fd ON Fe.entry_id = Fd.entry_id WHERE Fd.forms_id = {$form_id}");
		
		if ($query->num_rows() > 0) return $query;
        return null;	
	}
	
	/**
	 * Obtenemos una entrada en particular
	 */
	function get_contenido_by_form_y_entry_id($fields_grupo_fields, $form_id, $entry_id) {

		$campos = "";
		$indice = 0;
		
		foreach($fields_grupo_fields as $field) {
			//Fd es el alias de form_data
			//field_id_ es el prefijo que tienen todas las columnas en forms data
			//Ver de hacer esto en alguna otra parte
			$campos .= FD . "field_id_" . $field;
			if($indice < count($fields_grupo_fields) - 1) {
				$campos .= ", ";
			}
			$indice++;
		}
		//Declaramos los campos generales a todos los forms
		$campos_generales = FE . "entry_id, " . FE . "autor_id, " . FE . "ip_address, " . FE . "titulo, " . FE . "url_titulo, " . FE . "entry_date, " . FE . "edit_date, ";
		
		$query = $this->db->query("SELECT {$campos_generales}{$campos} FROM forms_entradas as Fe LEFT JOIN forms_data as Fd ON Fe.entry_id = Fd.entry_id WHERE Fd.forms_id = {$form_id} AND Fd.entry_id = {$entry_id}");
		
		if ($query->num_rows() > 0) return $query;
        return null;	
	}
}