<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Cotizacion extends REST_Controller
{
	function __construct()
	{
		 parent::__construct();
		 
		 $this->ci =& get_instance();
	}

	function cotizacion_monedas_get() {
	}
	
	
}