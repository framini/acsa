<?php

class Tester extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->library('auth_frr');
        
        //Si no esta logueado lo redirecciona al root
        if(!$this->auth_frr->is_logged_in())
        {
            redirect('');
        }
    }


    function index()
    {
        /*$this->load->library('roles_frr');
        
        //$this->roles->role_usuario();
        $permisos = $this->roles_frr->permisos_role();
        
        ($permisos) ? print_r($permisos) : print_r('NO TIENE PERMISOS');*/
        //$this->load->model('users');
        //$user = $this->users->get_user_by_login("quique");
       //print_r($user->user_id);
        
        /*$this->load->model('productos/financiero');
        echo $this->financiero->test();
        die();*/
       echo CI_VERSION; 
        
        /* if($permisos && in_array('baja_usuario', $permisos))
        {
            echo "TIENE EL PODER";
        }
        else
        {
            echo "NO TIENE PERMISO";
        }*/
        
       /*echo  $this->router->fetch_class(); // class = controller
       echo $this->router->fetch_method();*/
    }
    
    function ban($user)
    {
        $this->load->model('auth/users');
        
        $this->users->ban_user($user);
    }
    
    function limited_access()
    {
        echo $this->router->fetch_method();
    }
	
	function twig() {
		$this->load->library('twig');
		$data['title'] = "Testing Twig!!";
		$this->twig->display('welcome_message.php', $data);
	}
    
}
