<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo de datos para Extensiones
 *
 */

class Extensiones extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_extensiones() {
		$this->db->select();
        $this->db->from("extensiones");
		$this->db->order_by('id_extension', 'asc');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) return $query;
        return NULL;
	}
	
	function get_extensione_template($template, $grupo_template_id) {
		$this->db->select('template_extension');
        $this->db->from("templates");
		$this->db->where('nombre', $template);
		$this->db->where('template_group_id', $grupo_template_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) return $query->row();
        return NULL;
	}
}