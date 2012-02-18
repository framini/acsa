<?php

class Restrict extends CI_Controller
{
    function __construct() {
        parent::__construct();
        
        $this->load->library('roles_frr');
        
    }
    
    function index()
    {
          $user_id = $this->auth_frr->get_user_id();
          $role_id = $this->roles_frr->get_role_id($user_id);
          
          if($role_id == 1)
          {
              $this->load->view('restrict');
          }
          else
          {
              $this->load->view('error');
          }
        
    }
}
