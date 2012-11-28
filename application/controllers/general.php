<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller {
                  
                 public function __construct() 
                 {
                     parent::__construct();
                     
                     if(!$this->auth_frr->is_logged_in())
                     {
                         redirect('ew');
                         die();
                     }
                     
                     $this->load->helper(array('form', 'url'));
                     $this->load->library('form_validation');
                     $this->load->library('security');
                     $this->load->library('auth_frr');
                     $this->load->library('session');
                     $this->load->library('ewarrants_frr');
                     $this->lang->load('auth_frr');
                     $this->load->model('ewarrants/ewarrants_model');
                 }
				 
				 function index() {
				 	$this->template->set_content('general/confirmacion');
                    $this->template->build();
				 }
}