<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Modelo de datos para el Tablero de control
 *
 */
class Tablero_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function alta_indicador($data) {

		if ($this -> db -> insert('indicador', $data)) {
			$id_indicador = $this -> db -> insert_id();
			return array('idIndicador' => $id_indicador);
		}
		return NULL;

	}

	function check_indicador($id_indicador) {

		$this->db->where('idIndicador', $id_indicador);
		$query = $this->db->get('indicador');
		if ($query->num_rows() == 1) return TRUE;
		return NULL;

	}

	function get_indicadores() {
		$this -> db -> select();
		$this -> db -> from("indicador");
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0)
			return $query;
		return NULL;
	}
}