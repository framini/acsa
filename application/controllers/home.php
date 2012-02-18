<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
                  
                  function __construct()
	{
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
    
                  function index()
                  {
                      $this->template->build();
                  }
                    
}