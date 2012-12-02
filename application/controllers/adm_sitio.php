<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm_Sitio extends CI_Controller {
                  
         public function __construct() 
         {
             parent::__construct();
         }
		 
		 function index() {
			$this->core->generar_pagina();
		 }
}