<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Adm_General extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (!$this -> auth_frr -> is_logged_in()) {
			redirect('adm/ew');
			die();
		}
	}

	function index() {
		$this -> template -> set_content('general/confirmacion');
		$this -> template -> build();
	}

}
