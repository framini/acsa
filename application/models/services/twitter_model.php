<?php

class  Twitter_model extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }
	
	function agregar_usuario($usuario) {
		$data['usuario'] = $usuario;
		if ($this->db->insert('twitter', $data)) {
            return true;
        }
        return NULL;
	}
	
	function eliminar_usuario($usuario) {
		$this->db->where('usuario', $usuario);
		if ($this->db->delete('twitter')) {
            return true;
        }
        return NULL;
	}
	
	function get_user_by_username($usuario) {
		$this->db->where('usuario', $usuario);

		$query = $this->db->get('twitter');
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}
	
	function get_cuentas() {
		$this->db->select();
        $this->db->from("twitter");
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) return $query;
        return NULL;
	}
}