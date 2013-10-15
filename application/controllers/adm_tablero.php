<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Adm_Tablero extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	function index() {


		//Cargamos el archivo que contiene la info con la que se contruye el menu
		$this -> config -> load('menu_permisos', TRUE);

		$data['gestiones_disponibles'] = $this -> roles_frr -> gestiones_disponibles($this -> uri -> segment(2));

		if (count($data['gestiones_disponibles']) > 0) {
			foreach ($data['gestiones_disponibles'] as $key => $gestion) {
				$data['data_menu'][$gestion] = $this -> config -> item($gestion, 'menu_permisos');
			}
		} else {
			$data['error_sin_permiso'] = $this -> config -> item('error_sin_permiso', 'menu_permisos');
		}

		if ($message = $this -> session -> flashdata('message')) {
			$data['message'] = $message;
		}

		$data['titulo_gestion'] = "Menu Tablero de Administracion";
		$this -> template -> set_content('seguridad/main', $data);
		$this -> template -> build();
	}

	function tablero_control() {

		$this->load->library('Tablero_frr');

		if ($this -> auth_frr -> es_admin()) {
			//print_r($this->uri->segment(2)); die();
			if($this->uri->segment(4) && $this->input->get('id')) {
				//print_r($this->input->get('id')); die();
				//Buscamos el detalle de algun indicador en particular
				$data['ewarrants'] = $this -> tablero_frr -> get_resultados_tablero( $this->input->get('id'));

				if ($data['ewarrants'] != null) {
					if ($message = $this -> session -> flashdata('message')) {
						$data['message'] = $message;
					}
					$this -> template -> set_content('tablero/tabler_level_1', $data);
					$this -> template -> build();
				} else {
					$this -> template -> set_content('ewarrants/sin_permiso', array('msg' => 'Actualmente no hay indicadores dados de alta con ese ID'));
					$this -> template -> build();
				}


			} else {
				//Mostramos el level 0
				$data['ewarrants'] = $this -> tablero_frr -> get_resultados_tablero();

				if ($data['ewarrants'] != null) {
					if ($message = $this -> session -> flashdata('message')) {
						$data['message'] = $message;
					}
					$this -> template -> set_content('tablero/tabler_level_0', $data);
					$this -> template -> build();
				} else {
					$this -> template -> set_content('ewarrants/sin_permiso', array('msg' => 'Actualmente no hay indicadores dados de alta'));
					$this -> template -> build();
				}
			}
			
		}

	}

	function check_idindicador() {
		if ($this -> auth_frr -> es_admin()) {
			$this->load->model('tablero/tablero_model');

			if( $this->tablero_model->check_indicador($this->input->post('id'))) {
				echo "false";
			} else {
				echo "true";
			}
		}
	}

	function gestionar_indicadores() {
		$this -> breadcrumb -> append_crumb('Home', site_url('adm/home'));
		$this -> breadcrumb -> append_crumb('Tablero de Control', site_url() . "adm/tablero/");
		$this -> breadcrumb -> append_crumb('Gestionar Indicadores', site_url() . "/tablero/gestionar_indicadores");

		//Cargamos el archivo que contiene la info con la que se contruye el menu
		$this -> config -> load('menu_permisos', TRUE);

		//Obtenemos los permisos del usuario logueado asociados a la controladora productos y grupo gestionar_roles
		$data['permisos'] = $this -> roles_frr -> permisos_role_controladora_grupo($this -> uri -> segment(2), $this -> uri -> segment(3));

		//Procesamos los permisos obtenidos
		if (count($data['permisos']) > 0) {
			foreach ($data['permisos'] as $key => $row) {
				$data['data_menu'][$row['permiso']] = $this -> config -> item($row['permiso'], 'menu_permisos');
			}
		}

		//Obtenemos todas las empresas cargadas en el sistema
		$this -> load -> library('tablero_frr');
		$data['indicadores'] = $this -> tablero_frr -> get_indicadores();

		if ($message = $this -> session -> flashdata('message')) {
			$data['message'] = $message;
		}

		if ($errormsg = $this -> session -> flashdata('errormsg')) {
			$data['errormsg'] = $errormsg;
		}

		$this -> template -> set_content('tablero/gestionar_indicadores', $data);
		$this -> template -> build();
	}

	function alta_indicador() {

		//Solamente los admins de argentina clearing pueden crear empresas, asi que lo primero que chequeamos
		//es que el usuario sea admin
		if ($this -> auth_frr -> es_admin()) {
			$this -> load -> library('tablero_frr');

			$this -> form_validation -> set_error_delimiters('<p><i class="icon-exclamation-sign"></i> ', '</p>');

			$this -> form_validation -> set_rules('id', 'ID del Indicador', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('descripcion', 'Precio', 'trim|xss_clean');
			$this -> form_validation -> set_rules('tipo', 'Calidad', 'trim|xss_clean');
			$this -> form_validation -> set_rules('calculo_nominador', 'Calculo Nominador', 'trim|xss_clean');
			$this -> form_validation -> set_rules('relative', 'Relative', 'trim|xss_clean');
			$this -> form_validation -> set_rules('calculo_denominador', 'Calculo Denominador', 'trim|xss_clean');
			$this -> form_validation -> set_rules('relacion_objetivo', 'Relacion Objetivo', 'trim|xss_clean');
			$this -> form_validation -> set_rules('drilldown', 'Drilldown', 'trim|xss_clean');


			$data['errors'] = array();

			//Chequeamos que los datos enviados por formulario sean correctos
			if ($this -> form_validation -> run()) {
				if (!is_null($data = $this -> tablero_frr -> alta_indicador(
							$this -> form_validation -> set_value('id'), 
							$this -> form_validation -> set_value('descripcion'), 
							$this -> form_validation -> set_value('tipo'), 
							$this -> form_validation -> set_value('calculo_nominador'),
							$this -> form_validation -> set_value('relative'),
							$this -> form_validation -> set_value('calculo_denominador'),
							$this -> form_validation -> set_value('relacion_objetivo'),
							$this -> form_validation -> set_value('drilldown')
							))) {
					//Nos fijamos si la petición se hizo via AJAX
					if ($this -> input -> is_ajax_request()) {
						$resultados['message'] = "El indicador ha sido dado de alta correctamente!";
						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						//El producto se creo correctamente
						$message = "El indicador ha sido dado de alta correctamente!";
						$this -> session -> set_flashdata('message', $message);
						redirect('adm/productos/gestionar_productos');
					}

				}
			} else {
				//Si la peticion se hizo via AJAX
				if ($this -> input -> is_ajax_request()) {
					$resultados['error'] = true;
					//Chequeamos que alguno de los campos requeridos este vacio
					//Si esta vacio mostramos un mensaje general
					if (!$this -> input -> post('id')) {
						$resultados['message'] = "El ID del indicador es requerido";
					}
					//Devolvemos los resultados en JSON
					echo json_encode($resultados);
					//Ya no tenemos nada que hacer en esta funcion
					return;
				}
			}

			$this -> template -> set_content('tablero/alta_indicador', $data);
			$this -> template -> build();

		}
	}



}