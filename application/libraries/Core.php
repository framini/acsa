<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core {
	var $ci;

	/**
	 * Constructor
	 */
	function __construct()
	{
		// Call initialize to do the heavy lifting
		$this->_initialize_core();
	}
	
	function _initialize_core()
	{
		$this->ci =& get_instance();

	}
	
	function generar_pagina() {
		$template_group = $this->ci->uri->segment(1);
		$template = $this->ci->uri->segment(2);

		$this->ci->template->run_template_engine($template_group, $template);
	}
}