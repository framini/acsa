<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class adm_Examples extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',$output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function objetivo()
    {
    	$this->load->library('grocery_CRUD');
        $this->grocery_crud->set_table('objetivo');
        $output = $this->grocery_crud->render();
 
        $this->_example_output($output);
    }

}