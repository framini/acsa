<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Adm_Home extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this -> lang -> load('auth_frr');

		if (!$this -> auth_frr -> is_logged_in()) {
			redirect('adm/ew');
		}
	}

	function index() {
		$this -> load -> library('ws_frr');

		$data['cotizacion'] = $this -> ws_frr -> obtener_cotizacion(array('ARS', 'EUR'));
		
		if( $this -> auth_frr -> es_admin() ) {
			$data['estadisticas_usuarios'] = count( $this -> auth_frr -> get_users() );
			$data['estadisticas_empresas'] = count( $this -> empresas_frr -> get_empresas() );
			$data['estadisticas_ewarrants'] = count( $this -> ewarrants_frr -> get_warrants_habilitados() );
		}
		
		$this -> template -> set_content('home', $data);
		$this -> template -> build();
	}

}
