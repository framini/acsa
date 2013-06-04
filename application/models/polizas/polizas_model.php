<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Modelo de datos para users
 *
 */
class Polizas_model extends CI_Model {
	private $table_name = 'polizas';

	function __construct() {
		parent::__construct();

		$ci = &get_instance();
	}

	function emitir_poliza($data) {
		$data['created'] = date('Y-m-d H:i:s');
		if ($this->db->insert($this->table_name, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	function get_poliza_by_id($poliza) {
		$this->db->where('poliza_id', $poliza);
		$this->db->from($this->table_name);
		$query = $this->db->get();
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}
}
