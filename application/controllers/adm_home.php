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

		//$data['tweets'] = $this->ws_frr->get_tweets('alvaronbamartin');
		$data['cotizacion'] = $this -> ws_frr -> obtener_cotizacion(array('ARS', 'EUR'));
		$data['cuentas'] = $this -> ws_frr -> get_cuentas_twitter_y_tweets();

		$this -> template -> set_content('home', $data);
		$this -> template -> build();
	}

}
