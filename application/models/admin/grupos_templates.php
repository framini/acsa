<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Grupos_templates extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/templates');
	}
	
	/**
	 * Metodo utilizado para obtener todos los grupos de templates cargados en el sistema
	 */
	function get_grupos_templates() {
		$this->db->select();
        $this->db->from("templates_groups");
		$this->db->order_by('template_group_id', 'asc');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) return $query;
        return NULL;
	}
	
	function get_nombre_grupo_template_by_id($grupo_id) {
		$this->db->select('nombre');
		$this->db->where('template_group_id', $grupo_id);
		$query = $this->db->get('templates_groups');
		
		if($query->num_rows() == 1) {
			return $query->row();
		}
		return NULL;
	}
	
	function get_grupo_template_by_id($grupo_id) {
		$this->db->select();
		$this->db->where('template_group_id', $grupo_id);
		$query = $this->db->get('templates_groups');
		
		if($query->num_rows() == 1) {
			return $query->row();
		}
		return NULL;
	}
	
	function get_nombre_grupo_template_by_name($grupo_template) {
		$this->db->select('template_group_id');
		$this->db->where('nombre', $grupo_template);
		$query = $this->db->get('templates_groups');
		
		if($query->num_rows() == 1) {
			return $query->row();
		}
		return NULL;
	}
	
	function get_grupo_template_default() {
		$this->db->select('');
		$this->db->where('grupo_default', "y");
		$query = $this->db->get('templates_groups');
		
		if($query->num_rows() == 1) {
			return $query->row();
		}
		return NULL;
	}
	
	function is_nombre_grupo_template_disponible($nombre) {
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(nombre)=', strtolower($nombre));

		$query = $this->db->get('templates_groups');
		return $query->num_rows() == 0;
	}
	
	function create_grupo_templates($data) {
		$this->db->insert('templates_groups', $data);
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_templates_grupo_template($grupo_id) {
		$this->db->select();
        $this->db->from("templates");
		$this->db->where('template_group_id', $grupo_id);
		$this->db->order_by('template_group_id', 'asc');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) return $query;
        return NULL;
	}
	
	function eliminar_grupo_templates($grupo_template_id) {
		//Comenzamos la transaccion
		$this->db->trans_start();

		//Eliminamos cada uno de los templates que pertenecen al grupo
		$this->db->where('template_group_id', $grupo_template_id);
		$this->db->delete('templates');

		//Eliminamos el grupo de fields
		$this->db->where('template_group_id', $grupo_template_id);
		$this->db->delete('templates_groups');
		
		//Comitiamos la transaccion
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
        	return TRUE;
        }
	}
	
	function modificar_grupo_template($grupo_id, $data) {
		//Actualizamos los datos del grupo
		$this->db->where('template_group_id', $grupo_id);
		if($this->db->update('templates_groups', $data)) {
			return true;
		} else {
			return false;
		}
	}
}