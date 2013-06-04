<?php

require(APPPATH . 'libraries/image-uploader/upload.php');

class Tester extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->library('auth_frr');
        
        //Si no esta logueado lo redirecciona al root
        if(!$this->auth_frr->is_logged_in())
        {
            redirect('ew');
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
	
	function carga() {
		//require(APPPATH.'libraries/' . 'image-uploader/upload.php');
		//echo APPPATH; die();
		//$this->load->file('image-uploader/upload.php', true);
		
		//$datos = $this->administracion_frr->parser_post($this->input->post());
		
		$upload_handler = new UploadHandler();
		
		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');
		
		switch ($_SERVER['REQUEST_METHOD']) {
		    case 'OPTIONS':
		        break;
		    case 'HEAD':
		    case 'GET':
		        $upload_handler->get();
		        break;
		    case 'POST':
		        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
		            $upload_handler->delete();
		        } else {
		            $upload_handler->post();
		        }
		        break;
		    case 'DELETE':
		        $upload_handler->delete();
		        break;
		    default:
		        header('HTTP/1.1 405 Method Not Allowed');
		}
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
