<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
                  
    function __construct() {
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('auth_frr');
		$this->lang->load('auth_frr');
                
        if (!$this->auth_frr->is_logged_in()) 
        {
            redirect('ew');
        }
	}
    
	function index() {
		$this->load->library('ws_frr');
		
		//$data['tweets'] = $this->ws_frr->get_tweets('alvaronbamartin');
		$data['cotizacion'] = $this->ws_frr->obtener_cotizacion(array('ARS', 'EUR'));
		$data['cuentas'] = $this->ws_frr->get_cuentas_twitter_y_tweets();
		
	    $this->template->set_content('home', $data);
        $this->template->build();
	}                
}