<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Adm_Tablero extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this -> load -> library('tablero_frr');
		$this->load->model('tablero/tablero_model');
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

			if( $this->tablero_model->check_indicador($this->input->post('id'))) {
				if($this->input->post('current') == $this->input->post('id')) {
					echo "true";
				} else {
					echo "false";
				}
				
			} else {
				echo "true";
			}
		}
	}

	function gestionar_indicadores() {
		$this -> breadcrumb -> append_crumb('Home', site_url('/adm/home'));
		$this -> breadcrumb -> append_crumb('Tablero de Control', site_url() . "/adm/tablero/");
		$this -> breadcrumb -> append_crumb('Gestionar Indicadores', site_url() . "/tablero/gestionar_indicadores");

		if ($this -> auth_frr -> es_admin()) {
			$this->load->library('grocery_CRUD');
			$this->grocery_crud->set_theme('datatables');
	        $this->grocery_crud->set_table('indicador');

	        $this->grocery_crud->unset_texteditor('Descripcion','full_text');
	        $this->grocery_crud->unset_texteditor('CalculoNumerador','full_text');
	        $this->grocery_crud->unset_texteditor('CalculoDenominador','full_text');
	        $this->grocery_crud->unset_texteditor('DrillDown','full_text');

	        $this->grocery_crud->set_rules('idIndicador', 'ID Indicador','trim|required|xss_clean|callback_idIndicador_check');

	        $this->grocery_crud->unique_fields('idIndicador');
	        $this->form_validation->set_message('is_unique', 'Este campo ya se encuentra en uso');

	        $output = $this->grocery_crud->render();

	        $data['crud'] = $this->load->view('crud_base.php',$output, true);
	 
	        $this -> template -> set_content('tablero/crud', $data);
			$this -> template -> build();
		}
	}

	function alta_indicador() {

		//Solamente los admins de argentina clearing pueden crear empresas, asi que lo primero que chequeamos
		//es que el usuario sea admin
		if ($this -> auth_frr -> es_admin()) {

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
						redirect('adm/tablero/gestionar_indicadores');
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

	function reporte() {
		// print_r(str_replace("\"", "", json_encode($this->tablero_frr->get_reporte()))); die();
		// $data['data'] = json_encode(array(
		// 	array(
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		)
		// 	),
		// 	array(
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		),
		// 		array(
		// 			"x" => 0,
		// 			"y" => 1
		// 		)
		// 	)
		// ));
		$data['data'] = str_replace("\"", "", json_encode($this->tablero_frr->get_reporte()));
		$this -> template -> set_content('tablero/reporte', $data);
		$this -> template -> build();
	}

	function gestionar_objetivos() {
		$this -> breadcrumb -> append_crumb('Home', site_url('/adm/home'));
		$this -> breadcrumb -> append_crumb('Tablero de Control', site_url() . "/adm/tablero/");
		$this -> breadcrumb -> append_crumb('Gestionar Objetivos', site_url() . "/tablero/gestionar_objetivos");

		if ($this -> auth_frr -> es_admin()) {
			$this->load->library('grocery_CRUD');
			$this->grocery_crud->set_theme('datatables');
	        $this->grocery_crud->set_table('objetivo');
	        $this->grocery_crud->field_type('user', 'hidden', $this->auth_frr->get_username());

	        $output = $this->grocery_crud->render();

	        $data['crud'] = $this->load->view('crud_base.php',$output, true);
	 
	        $this -> template -> set_content('tablero/crud', $data);
			$this -> template -> build();
		}
	}

	function indicador() {
		if ($this -> auth_frr -> es_admin()) {
			$this->load->library('grocery_CRUD');
			$this->grocery_crud->set_theme('datatables');
	        $this->grocery_crud->set_table('indicador');

	        $this->grocery_crud->field_type('user', 'hidden', $this->auth_frr->get_username());

	        $this->grocery_crud->unset_texteditor('Descripcion','full_text');
	        $this->grocery_crud->unset_texteditor('CalculoNumerador','full_text');
	        $this->grocery_crud->unset_texteditor('CalculoDenominador','full_text');
	        $this->grocery_crud->unset_texteditor('DrillDown','full_text');

	        $this->grocery_crud->set_rules('idIndicador', 'ID Indicador','trim|required|xss_clean|callback_idIndicador_check');

	        $this->grocery_crud->unique_fields('idIndicador');
	        $this->form_validation->set_message('is_unique', 'Este campo ya se encuentra en uso');

	        $output = $this->grocery_crud->render();

	        $data['crud'] = $this->load->view('crud_base.php',$output, true);
	 
	        $this -> template -> set_content('tablero/crud', $data);
			$this -> template -> build();
		}
	}

	public function idIndicador_check($str)
	{
	  $id = $this->uri->segment(5);
	  if(!empty($id) && is_numeric($id))
	  {
	   $username_old = $this->db->where("id",$id)->get('users')->row()->username;
	   $this->db->where("username !=",$username_old);
	  }
	  
	  $num_row = $this->db->where('username',$str)->get('users')->num_rows();
	  if ($num_row >= 1)
	  {
	   $this->form_validation->set_message('username_check', 'The username already exists');
	   return FALSE;
	  }
	  else
	  {
	   return TRUE;
	  }
	}

	/**
	 * Modifica un indicador registrado en el sistema
	 * NOTA: Solo disponible para admins
	 */
	function modificar_indicador() {
		//Solamente los admins se argentina clearing pueden crear empresas, asi que lo primero que chequeamos
		//es que el usuario sea admin
		if ($this -> auth_frr -> es_admin()) {

			$this -> form_validation -> set_error_delimiters('<p><i class="icon-exclamation-sign"></i> ', '</p>');

			$this -> form_validation -> set_rules('id', 'ID del Indicador', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('currid', 'Current ID', 'trim|xss_clean');
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

				if (!is_null($data = $this -> tablero_frr -> modificar_indicador(
						$this -> form_validation -> set_value('currid'),
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
						$resultados['message'] = "Se modifico el indicador correctamente!";
						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						//La empresa se creo correctamente
						$message = "Se modifico el indicador correctamente!";
						$this -> session -> set_flashdata('message', $message);
						redirect('adm/tablero/gestionar_indicadores');
					}

				} else {
					// //Chequeamos si la peticion se hizo via ajax
					// if ($this -> input -> is_ajax_request()) {
					// 	$resultados['message'] = $this -> productos_frr -> get_error_message();
					// 	$resultados['error'] = true;
					// 	//Devolvemos los resultados en JSON
					// 	echo json_encode($resultados);
					// 	//Ya no tenemos nada que hacer en esta funcion
					// 	return;
					// } else {
					// 	$data['errors'] = $this -> productos_frr -> get_error_message();
					// }
				}
			}

			//Solamente hacemos algo si está presente el id de la empresa en la URI
			if ($this->input->get('id')) {
				//Solamente cargamos los datos cuando no exista una request POST
				//Para no pisar los datos enviados por el usuarios
				if (!$this -> input -> post()) {
					//Obtenemos la empresa
					$data['row_indicador'] = $this -> tablero_frr -> get_indicador_by_id($this->input->get('id'));
					$data['currid'] = $this->input->get('id');
				}

				//Asignamos un texto al boton submit del formulario
				$data['tb'] = "Modificar Indicador";
				//Asignamos un titulo para el encabezado del formulario
				$data['tf'] = "Modificar Indicador";
				
				$this -> template -> set_content('tablero/alta_indicador', $data);
				$this -> template -> build();
			} else {
				redirect('adm/ew');
			}
		}
	}



}