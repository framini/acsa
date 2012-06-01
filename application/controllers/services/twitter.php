<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twitter extends MY_Controller {
                  
    function __construct() {
		parent::__construct();
	}
	
	function get() {

		if($this->input->post('nombre')) {
			$this->load->library('ws_frr');
			//$tweets = $this->ws_frr->get_tweets('CoachCMorales');
			$tweets = $this->ws_frr->get_tweets($this->input->post("nombre"));
			//$tweets = NULL;
			
			//Nos fijamos si se produjo un error
			if(!is_null($tweets)) {
				//Agregamos el usuario a la base de datos solo si ya no existe
				$this->load->model('services/twitter_model');
				if(is_null($this->twitter_model->get_user_by_username($this->input->post('nombre')))) {
					$this->agregar_twitteraccount();
				}
				print_r(json_encode($tweets));
				return;
			}
			
			print_r(json_encode(array('error' => 'No existe una cuenta con ese nombre de usuario')));
		}
	}
	
	function borrar_twitteraccount($nombre = NULL) {
		$this->load->model('services/twitter_model');
		
		$nombre = ($this->input->post('nombre')) ? $this->input->post('nombre') : $nombre;
		
		if($nombre && !is_null($usuario = $this->twitter_model->get_user_by_username($nombre))) {
			if($this->twitter_model->eliminar_usuario($nombre)) {
				$res['exito'] = "borrado";
				//echo json_encode($res);
			} else {
				$res['error'] = "error";
				//echo json_encode($res);
			}
		} else {
			$res['error'] = "error";
			//echo json_encode($res);
		}
		
		echo json_encode($res);
	}
	
	function agregar_twitteraccount($nombre = NULL) {
		$this->load->model('services/twitter_model');
		
		$nombre = ($this->input->post('nombre')) ? $this->input->post('nombre') : $nombre;
		
		if($nombre && is_null($usuario = $this->twitter_model->get_user_by_username($nombre))) {
			if($this->twitter_model->agregar_usuario($nombre)) {
				$res['exito'] = "agregado";
				//echo json_encode($res);
			} else {
				$res['error'] = "error";
				//echo json_encode($res);
			}
		} else {
			$res['error'] = "error";
			//echo json_encode($res);
		}
	}
}