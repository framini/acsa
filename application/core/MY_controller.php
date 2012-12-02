<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	function __construct()
	{
		 parent::__construct();
		 
		 //Chequeamos que el usuario este logueado
		 if(!$this->auth_frr->is_logged_in())
         {
             redirect('adm/ew');
             die();
         }
		 
		 //Si el usuario logueado fue eliminado, tenemos que forzar su cierre de sesion
		 if( !$this->auth_frr->user_exists() ) {
		 	$this->auth_frr->logout();
			redirect('adm/ew');
            die();
		 } 
		 
		 //Chequeamos si se trata de ejecutar alguna funcion administrativa
		 if( "adm" == $this->uri->segment(1)) {

			$permiso = $this->uri->segment(3) != FALSE ? $this->uri->segment(3) : 'index';
			
		 	//Comprobamos que el usuario tenga los permisos necesarios
		 	//Parametros (permiso, controladora, grupo)
		 	if(!$this->roles_frr->tiene_permisos($permiso, $this->uri->segment(2), $this->uri->segment(3))) {
		 		//Si no tiene permisos los redireccionamos a la web de error	 
             	redirect('adm/error/m');
            	die();
			}
		 }
	}
}