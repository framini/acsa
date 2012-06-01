<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
                  
    function __construct() {
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('auth_frr');
		$this->lang->load('auth_frr');
                
        if (!$this->auth_frr->is_logged_in()) 
        {
            redirect('');
        }
	}
    
	function index() {
		$this->load->library('ws_frr');
		
		$data['tweets'] = $this->ws_frr->get_tweets('alvaronbamartin');
		$data['cotizacion'] = $this->ws_frr->obtener_cotizacion(array('ARS', 'EUR'));
		
	    $this->template->set_content('home', $data);
        $this->template->build();
	}                
}