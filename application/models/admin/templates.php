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
	function create_template($data, $g_id) {
		$data['template_group_id'] = $g_id;
		$data['edit_date'] = date('Y-m-d H:i:s');
		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();
		
		$this->db->insert('templates', $data);
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function modificar_template($template_id, $data) {
		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();
		$this->db->where('template_id', $template_id);
		if($this->db->update('templates', $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Metodo utilizado para obtener todos los grupos de templates cargados en el sistema
	 */
	function get_templates() {
		$this->db->select();
        $this->db->from("templates");
		$this->db->order_by('template_group_id', 'asc');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) return $query;
        return NULL;
	}
	
	function get_template_by_id($template_id) {
		$this->db->select();
		$this->db->where('template_id', $template_id);
		$query = $this->db->get('templates');
		
		if($query->num_rows() == 1) {
			return $query->row();
		}
		return NULL;
	}

	function get_template_by_name( $template, $template_group_id = NULL ) {
		$this->db->select();
		$this->db->where('nombre', $template);
		
		if( !is_null($template_group_id) ) {
			$this->db->where('template_group_id', $template_group_id);
		}
		
		$query = $this->db->get('templates');
		
		if($query->num_rows() == 1) {
			return $query->row();
		}
		return NULL;
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
		
		if ($template_group != '')
		{
			$sql .= " AND templates_groups.nombre = '".$this->db->escape_str($template_group)."' ";
		}

				
		$query = $this->db->query($sql);
		
		$row = $query->row_array();
		
		if( count($row) > 0 ) {
			return $row['data'];
		} else {
			return NULL;
		}
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
		$campos_generales = FE . "entry_id, " . FE . "autor_id, " . FE . "ip_address, " . FE . "titulo, " . FE . "entry_date, " . FE . "edit_date, ";
		
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
		$campos_generales = FE . "entry_id, " . FE . "autor_id, " . FE . "ip_address, " . FE . "titulo, " . FE . "entry_date, " . FE . "edit_date, ";
		
		$query = $this->db->query("SELECT {$campos_generales}{$campos} FROM forms_entradas as Fe LEFT JOIN forms_data as Fd ON Fe.entry_id = Fd.entry_id WHERE Fd.forms_id = {$form_id} AND Fd.entry_id = {$entry_id}");
		
		if ($query->num_rows() > 0) return $query;
        return null;	
	}
	
	function get_grupo_template_by_template_id( $template_id ) {
		$this->db->select('template_group_id');
		$this->db->where('template_id', $template_id);

		$query = $this->db->get('templates');

		return $query->row()->template_group_id;
	}
	
	/**
	 * Chequea si el nombre del template esta disponible para registro
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_nombre_template_disponible($nombre_template, $grupo_template_id = NULL) {
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(nombre)=', strtolower($nombre_template));
		if( !is_null($grupo_template_id) ) {
			$this->db->where('template_group_id', $grupo_template_id );
		}

		$query = $this->db->get('templates');
		return $query->num_rows() == 0;
	}
	
	function eliminar_template($template_id) {
		//Comenzamos la transaccion
		$this->db->trans_start();

		//Eliminamos el template
		$this->db->where('template_id', $template_id);
		$this->db->delete('templates');
		
		//Comitiamos la transaccion
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
        	return TRUE;
        }
	}
	
	
}