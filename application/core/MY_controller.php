<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	function __construct()
	{
		 parent::__construct();
		 
		 //Chequeamos que el usuario este logueado
		 if(!$this->auth_frr->is_logged_in())
         {
             redirect('');
             die();
         }
		 
		 //Chequeamos si se trata de ejecutar alguna funcion de la controladora entramos a este condicional
		 if($permiso = $this->uri->segment(2)) {
		 	//Comprobamos que el usuario tenga los permisos necesarios
		 	//Parametros (permiso, controladora, grupo)
		 	if(!$this->roles_frr->tiene_permisos($permiso, $this->uri->segment(1), $this->uri->segment(2))) {
		 		//Si no tiene permisos los redireccionamos a la web de error	 
             	redirect('error/m');
            	die();
			}
		 }
	}
}