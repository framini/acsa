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
		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();
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

	function get_indicador_by_id($id) {
		$this -> db -> where('idIndicador', $id);
		$this -> db -> from('indicador');
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1)
			return $query -> row();
		return NULL;
	}

	function modificar_indicador($id, $data) {
		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();
		$this -> db -> where('idIndicador', $id);
		if ($this -> db -> update('indicador', $data))
			return true;
		else
			return false;
	}

	function get_reporte($idIndicador = NULL) {
		$anioMin = 2007;
		$anioMax = 2013;
		
		$this -> db -> select();
		$this -> db -> from("vw_reporte");

		$idIndicador = '01_CantidadAseguradoras';

		if(!is_null($idIndicador)) {
			$this -> db -> where('idIndicador', $idIndicador);
		}
		//$this -> db -> where('anio >', 2008);
		// $this->db->where("Anio BETWEEN $anioMin AND $anioMax");
		// $this->db->order_by('Anio', 'asc');
		// $this -> db -> where('idIndicador', '01_CantidadAseguradoras');
		$query = $this -> db -> get();
		if ($query -> num_rows() > 0)
			return $query;
		return NULL;

	}
}