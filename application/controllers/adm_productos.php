<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Adm_Productos extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this -> lang -> load('auth_frr');
		$this -> load -> library('productos_frr');
	}
	
	function index() {
		//Cargamos el archivo que contiene la info con la que se contruye el menu
 		  $this->config->load('menu_permisos', TRUE);
		  
    	  $data['gestiones_disponibles'] = $this->roles_frr->gestiones_disponibles($this->uri->segment(2));
		  
		  if(count($data['gestiones_disponibles']) > 0) {
		  	foreach ($data['gestiones_disponibles'] as $key => $gestion) {
			  $data['data_menu'][$gestion] = $this->config->item($gestion, 'menu_permisos');
		  	}
		  } else {
		  	$data['error_sin_permiso'] = $this->config->item('error_sin_permiso', 'menu_permisos');
		  }
		  
		
          if ($message = $this->session->flashdata('message')) {
          	$data['message'] = $message;
          }
			
		  $data['titulo_gestion'] = "Menu de Productos";	
		  $this->template->set_content('seguridad/main', $data);
          $this->template->build(); 
	}
	
	/**
	 *  Muestra la pantalla con todos los productos del sistema
	 */
	function gestionar_productos() {
		$this -> breadcrumb -> append_crumb('Home', site_url('adm/home'));
		$this -> breadcrumb -> append_crumb('Productos', site_url() . "adm/productos/");
		$this -> breadcrumb -> append_crumb('Gestionar Productos', site_url() . "/productos/gestionar_productos");

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
		$this -> load -> library('productos_frr');
		$data['productos'] = $this -> productos_frr -> get_productos();

		if ($message = $this -> session -> flashdata('message')) {
			$data['message'] = $message;
		}

		if ($errormsg = $this -> session -> flashdata('errormsg')) {
			$data['errormsg'] = $errormsg;
		}

		$this -> template -> set_content('productos/gestionar_productos', $data);
		$this -> template -> build();
	}

	/**
	 * Da de alta una empresa en el sistema
	 * NOTA: Solo disponible para admins
	 */
	function registro_producto() {

		//Solamente los admins de argentina clearing pueden crear empresas, asi que lo primero que chequeamos
		//es que el usuario sea admin
		if ($this -> auth_frr -> es_admin()) {
			$this -> form_validation -> set_error_delimiters('<p><i class="icon-exclamation-sign"></i> ', '</p>');

			$this -> form_validation -> set_rules('nombre', 'Nombre del producto', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('precio', 'Precio', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('calidad', 'Calidad', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('aforo', 'Aforo', 'trim|required|xss_clean');

			$data['errors'] = array();

			//Chequeamos que los datos enviados por formulario sean correctos
			if ($this -> form_validation -> run()) {
				$this -> load -> library('productos_frr');
				if (!is_null($data = $this -> productos_frr -> create_producto($this -> form_validation -> set_value('nombre'), $this -> form_validation -> set_value('precio'), $this -> form_validation -> set_value('calidad'), $this -> form_validation -> set_value('aforo')))) {
					//Nos fijamos si la petición se hizo via AJAX
					if ($this -> input -> is_ajax_request()) {
						$resultados['message'] = "El producto se ha creado correctamente!";
						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						//El producto se creo correctamente
						$message = "El producto se ha creado correctamente!";
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
					if (!$this -> input -> post('nombre') || !$this -> input -> post('calidad') || !$this -> input -> post('precio') || !$this -> input -> post('aforo')) {
						$resultados['message'] = "Todos los campos son requeridos";
					}
					//Devolvemos los resultados en JSON
					echo json_encode($resultados);
					//Ya no tenemos nada que hacer en esta funcion
					return;
				}
			}

			//$data['tipos_empresas'] = $this->empresas_frr->get_tipos_empresas();
			$this -> load -> library('productos_frr');
			$data['tipos_producto'] = $this->productos_frr->get_tipos_producto();

			$this -> template -> set_content('productos/agregar_producto_form', $data);
			$this -> template -> build();

		}
	}
	
	/**
	 * Modifica un producto registrado en el sistema
	 * NOTA: Solo disponible para admins
	 */
	function modificar_producto() {
		//Solamente los admins se argentina clearing pueden crear empresas, asi que lo primero que chequeamos
		//es que el usuario sea admin
		if ($this -> auth_frr -> es_admin()) {

			$this -> form_validation -> set_error_delimiters('<p><i class="icon-exclamation-sign"></i> ', '</p>');

			$this -> form_validation -> set_rules('nombre', 'Nombre del producto', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('precio', 'Precio', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('calidad', 'Calidad', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('aforo', 'Aforo', 'trim|required|xss_clean');

			$data['errors'] = array();

			//Chequeamos que los datos enviados por formulario sean correctos
			if ($this -> form_validation -> run()) {

				if (!is_null($data = $this -> productos_frr -> modificar_producto($this -> uri -> segment(4), $this -> form_validation -> set_value('nombre'), $this -> form_validation -> set_value('precio'), $this -> form_validation -> set_value('calidad'), $this -> form_validation -> set_value('aforo')))) {
					//Nos fijamos si la petición se hizo via AJAX
					if ($this -> input -> is_ajax_request()) {
						$resultados['message'] = "Se modifico el producto correctamente!";
						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						//La empresa se creo correctamente
						$message = "Se modifico el producto correctamente!";
						$this -> session -> set_flashdata('message', $message);
						redirect('adm/productos/gestionar_productos');
					}

				} else {
					//Chequeamos si la peticion se hizo via ajax
					if ($this -> input -> is_ajax_request()) {
						$resultados['message'] = $this -> productos_frr -> get_error_message();
						$resultados['error'] = true;
						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						$data['errors'] = $this -> productos_frr -> get_error_message();
					}
				}
			}

			//Si la peticion se hizo via AJAX
			if ($this -> input -> is_ajax_request()) {
				$resultados['error'] = true;
				//Chequeamos que alguno de los campos requeridos este vacio
				//Si esta vacio mostramos un mensaje general
				if (!$this -> input -> post('nombre') || !$this -> input -> post('cuit')) {
					$resultados['message'] = "Los campos requeridos no pueden estar vacios";
				}
				//Devolvemos los resultados en JSON
				echo json_encode($resultados);
				//Ya no tenemos nada que hacer en esta funcion
				return;
			}
			//Solamente hacemos algo si está presente el id de la empresa en la URI
			if ($this -> uri -> segment(4)) {
				//Solamente cargamos los datos cuando no exista una request POST
				//Para no pisar los datos enviados por el usuarios
				if (!$this -> input -> post()) {
					//Obtenemos la empresa
					$data['row_producto'] = $this -> productos_frr -> get_producto_by_id($this -> uri -> segment(4));
				}

				//Asignamos un texto al boton submit del formulario
				$data['tb'] = "Modificar Producto";
				//Asignamos un titulo para el encabezado del formulario
				$data['tf'] = "Modificar Producto";
				
				$this -> load -> library('productos_frr');
				$data['tipos_producto'] = $this->productos_frr->get_tipos_producto();
				$this -> template -> set_content('productos/agregar_producto_form', $data);
				$this -> template -> build();
			} else {
				redirect('adm/ew');
			}
		}
	}

	/**
	 * Acá se muestra el formulario para eliminar una empresa dependiendo de la presencia o ausencia de los
	 * parametros que le suministramos
	 * NOTA: Solo disponible para admins
	 */
	function eliminar_producto($producto_id = NULL) {
		//Chequeamos que exista la confirmacion en la URI
		if ($this -> uri -> segment(5) == "si") {
			$this -> load -> library('productos_frr');
			if ($this -> productos_frr -> eliminar_producto($producto_id)) {
				$message = "El producto se ha eliminado correctamente!";
				$this -> session -> set_flashdata('message', $message);
				redirect('adm/productos/gestionar_productos');
			} else {
				$errormsg = "No se ha podido eliminar el producto!";
				$this -> session -> set_flashdata('errormsg', $errormsg);
			}
		}
		//Mostramos el template solo en el caso que exista un id de empresa
		if ($producto_id) {
			$this -> template -> set_content('general/confirma_operacion');
			$this -> template -> build();
		}
	}

	//Metodo para asociar comisiones a cada producto
	function comisiones() {
		//Solamente ingresamos en caso de ser una warrantera
		if( $this->auth_frr->is_warrantera() ) {
			$data['productos'] = $this -> productos_frr -> get_productos();

			
			//En este caso entramos en modo edicion
			if($this -> uri -> segment(4)) {
				$this -> form_validation -> set_rules('comision', 'Comision', 'trim|required|xss_clean');

				//Si entramos aca es porque tenemos que modificar el porcentaje de un producto
				if ( $this -> form_validation -> run() ) {
					$data = array(
						"empresa_id" => $this->auth_frr->get_empresa_id(),
						"comision" => $this -> form_validation -> set_value('comision'),
						"producto_id" => $this -> input -> post('productos')
					);

					$estado = $this -> productos_frr -> modificar_comision($data);

					//Nos fijamos si la petición se hizo via AJAX
					if ($this -> input -> is_ajax_request()) {
						$resultados['message'] = "La comision ha sido asociada correctamente";
						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						//El producto se creo correctamente
						$message = "La comision ha sido asociada correctamente";
						$this -> session -> set_flashdata('message', $message);
						redirect('adm/productos/gestionar_productos');
					}
				}

				$comision = $this-> productos_frr -> get_datos_producto_empresa_comision ( $this -> uri -> segment(4) );

				if( $comision ) {
					$data['comision'] = $comision;
				} else {
					//Mostrar mensaje de error
				}

			} else {
				$this -> form_validation -> set_rules('comision', 'Comision', 'trim|required|xss_clean');
				$this -> form_validation -> set_rules('productos', 'Producto', 'trim|required|xss_clean');

				if ( $this -> form_validation -> run() ) {
					$data = array(
						"empresa_id" => $this->auth_frr->get_empresa_id(),
						"comision" => $this -> form_validation -> set_value('comision'),
						"producto_id" => $this -> form_validation -> set_value('productos')
					);
					//estamos creando la comision de la empresa
					if (!is_null($d = $this -> productos_frr -> create_comision($data) ) ) {
						//Nos fijamos si la petición se hizo via AJAX
						if ($this -> input -> is_ajax_request()) {
							$resultados['message'] = "La comision ha sido asociada correctamente";
							//Devolvemos los resultados en JSON
							echo json_encode($resultados);
							//Ya no tenemos nada que hacer en esta funcion
							return;
						} else {
							//El producto se creo correctamente
							$message = "La comision ha sido asociada correctamente";
							$this -> session -> set_flashdata('message', $message);
							redirect('adm/productos/gestionar_productos');
						}
					}
				}
				
			}
			

			$this -> template -> set_content('productos/comisiones', $data);
			$this -> template -> build();
		}
	}

}
