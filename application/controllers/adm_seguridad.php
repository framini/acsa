<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Adm_Seguridad extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this -> lang -> load('auth_frr');
	}

	/**
	 * Main controla la pagina cuando ingresan a Seguridad
	 */
	public function index() {
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

		$data['titulo_gestion'] = "Menu de Seguridad";
		$this -> template -> set_content('seguridad/main', $data);
		$this -> template -> build();
	}

	/**
	 * Se llama a esta funcion para mostrar el formulario para crear roles
	 * Cuando viene con datos en el post se usa para crear el role
	 */
	function nuevo_role() {
		$data['permisos'] = $this -> roles_frr -> get_all_permisos();
		if ($this -> auth_frr -> es_admin())
			$data['empresas'] = $this -> auth_frr -> get_empresas();
		//titulo pagina
		$data['t'] = 'Agregar Role';
		//fa = form action
		$data['fa'] = $this -> uri -> uri_string();
		//texto boton
		$data['tb'] = 'Agregar';

		/*$this->template->set_content('seguridad/modificar_role_form', $data);
		 $this->template->build();*/

		$this -> form_validation -> set_rules('nombre', 'Nombre de Role', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('descripcion', 'Descripcion', 'trim|xss_clean');
		if ($this -> auth_frr -> es_admin())
			$this -> form_validation -> set_rules('empresa_id', 'Empresa', 'required');

		$data['permisos'] = $this -> roles_frr -> get_all_permisos();

		if ($this -> form_validation -> run()) {
			$role = $this -> input -> post('nombre');
			$descripcion = $this -> input -> post('descripcion');
			if ($this -> auth_frr -> es_admin())
				$empresa_id = $this -> input -> post('empresa_id');
			else
				$empresa_id = $this -> auth_frr -> get_empresa_id();
			//$tipo_empresa_id =  $this->input->post('tipo_empresa_id');

			/* Para obtener la empresa en base al id */
			$this -> load -> model("auth/empresas");
			$empresa = $this -> empresas -> get_empresa_by_id($empresa_id);
			$tipo_empresa_id = $empresa -> tipo_empresa_id;

			if ($this -> roles_frr -> agregar_role($role, $descripcion, $empresa_id, $tipo_empresa_id)) {
				// Una vez aca ya se agrego el role, ahora se tienen que agregar los permisos al role
				$permisos = $this -> roles_frr -> get_all_permisos();
				$role = $this -> roles_frr -> get_role_by_name($role);
				$role_id = $role -> role_id;

				if (count($permisos) > 0) {
					foreach ($permisos as $permiso) {
						$permiso = $permiso['permiso'];
						if ($this -> input -> post($permiso))
							$permi[] = array('role_id' => $role_id, 'permiso_id' => $this -> input -> post($permiso));
						//echo $this->input->post($permiso);

					}

					// Si se selecciono algun permiso se le asiga al role
					if (isset($permi))
						$this -> roles_model -> agrega_permisos_role($permi);
				}

				$message = "El role se ha creado correctamente!";
				//$this->session->set_flashdata('exito', $message);
				$this -> session -> set_flashdata('message', $message);
				redirect('adm/seguridad/gestionar_roles');
			} else {
				$errors = $this -> roles_frr -> get_error_message();
			}
		}

		if (isset($errors)) {
			$data['errors'] = $errors;
			$this -> template -> set_content('seguridad/modificar_role_form', $data);
		} else {
			$this -> template -> set_content('seguridad/modificar_role_form', $data);
		}

		$this -> template -> build();
	}

	/**
	 *  Muestra la pantalla con todos los roles del sistema
	 */
	function gestionar_roles() {
		$this -> breadcrumb -> append_crumb('Home', site_url('adm/home'));
		$this -> breadcrumb -> append_crumb('Seguridad', site_url() . "/adm/seguridad/");
		$this -> breadcrumb -> append_crumb('Gestionar Roles', site_url() . "/adm/admin/gestionar_roles");

		//Cargamos el archivo que contiene la info con la que se contruye el menu
		$this -> config -> load('menu_permisos', TRUE);

		//Obtenemos los permisos del usuario logueado asociados a la controladora seguridad y grupo gestionar_roles
		$data['permisos'] = $this -> roles_frr -> permisos_role_controladora_grupo($this -> uri -> segment(2), $this -> uri -> segment(3));

		//Procesamos los permisos obtenidos
		if (count($data['permisos']) > 0) {
			foreach ($data['permisos'] as $key => $row) {
				$data['data_menu'][$row['permiso']] = $this -> config -> item($row['permiso'], 'menu_permisos');
			}
		}

		$empid = $this -> auth_frr -> get_empresa_id();
		if ($this -> auth_frr -> es_admin())
			$data['roles'] = $this -> roles_frr -> get_roles();
		else
			$data['roles'] = $this -> roles_frr -> get_roles_empresa($empid);

		if ($message = $this -> session -> flashdata('message')) {
			$data['message'] = $message;
		}
		if ($errormsg = $this -> session -> flashdata('errormsg')) {
			$data['errormsg'] = $errormsg;
		}

		//Si la empresa no tiene roles creados
		if (!isset($data['roles'])) {
			$data['sin_roles'] = "Actualmente su empresa no tiene roles creados. Puede crear uno haciendo click en \"Agregar Role\" en la esquina superior derecha";
		}

		$this -> template -> set_content('seguridad/gestionar_roles', $data);
		$this -> template -> build();
	}

	/**
	 * Muestra la pantalla para edtiar un role especifico a editar
	 * @param type $role_id
	 */
	function modificar_role($role_id = NULL) {
		if ($role_id) {
			/*//Cargamos en data los permisos del role
			 $data['permisosRole'] = $this->roles_frr->get_permisos_role($role_id);
			 //Cargamos en data los permisos del sistema
			 if($this->auth_frr->es_admin()) {
			 $data['permisos'] = $this->roles_frr->get_all_permisos();
			 } else {
			 $data['permisos'] = $this->roles_frr->get_all_permisos_no_admin();
			 }*/

			//Cargamos en data la info cargada en el role
			$data['roleRow'] = $this -> roles_frr -> get_role_by_id($role_id);
			if ($this -> auth_frr -> es_admin())
				$data['empresas'] = $this -> auth_frr -> get_empresas();

			//print_r($role);
			/*$this->template->set_content('seguridad/modificar_role_form', $data);
			 $this->template->build();*/

			$this -> form_validation -> set_rules('nombre', 'Nombre de Role', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('descripcion', 'Descripcion', 'trim|required|xss_clean');
			//$this->form_validation->set_rules('empresa_id', 'Empresa', 'trim|required|xss_clean');
			$this -> load -> model('auth/empresas');

			if ($this -> form_validation -> run()) {
				if ($this -> roles_frr -> role_name_disponible_edicion($this -> input -> post('nombre'), $role_id)) {
					if ($this -> auth_frr -> es_admin())
						$empresa_id = $this -> input -> post('empresa_id');
					else
						$empresa_id = $this -> auth_frr -> get_empresa_id();

					$empresa = $this -> empresas -> get_empresa_by_id($empresa_id);

					$data = array('nombre' => $this -> input -> post('nombre'), 'descripcion' => $this -> input -> post('descripcion'), 'empresa_id' => $empresa_id, 'tipo_empresa_id' => $empresa -> tipo_empresa_id);

					if ($this -> roles_frr -> modificar_role($role_id, $data)) {

						$permisos = ($this -> auth_frr -> es_admin()) ? $this -> roles_frr -> get_all_permisos() : $data['permisos'] = $this -> roles_frr -> get_all_permisos_no_admin();
						$role = $this -> roles_frr -> get_role_by_name($this -> input -> post('nombre'));
						$role_id = $role -> role_id;

						if (count($permisos) > 0) {
							foreach ($permisos as $permiso) {
								$permiso = $permiso['permiso'];
								if ($this -> input -> post($permiso))
									$permi[] = array('role_id' => $role_id, 'permiso_id' => $this -> input -> post($permiso));

							}

							// Actualizo los permisos al role
							if (isset($permi))
								$this -> roles_model -> actualiza_permisos_role($role_id, $permi);
							else
								$this -> roles_model -> actualiza_permisos_role($role_id, array());
						}

						//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
						if ($this -> input -> is_ajax_request()) {

							$resultados['message'] = "El role se ha modificado correctamente!";

							//Devolvemos los resultados en JSON
							echo json_encode($resultados);
							//Ya no tenemos nada que hacer en esta funcion
							return;
						} else {
							$message = "El role se ha modificado correctamente!";
							//$this->session->set_flashdata('message', $message);
							redirect('adm/seguridad/main');
						}
					} else {
						//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
						if ($this -> input -> is_ajax_request()) {
							$resultados['error'] = true;
							$resultados['message'] = "Se ha producido un error!";

							//Devolvemos los resultados en JSON
							echo json_encode($resultados);
							//Ya no tenemos nada que hacer en esta funcion
							return;
						} else {
							$errors = $this -> roles_frr -> get_error_message();
						}
					}
				} else {
					//Si entramos aca es porque el usuario no esta disponible
					//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
					if ($this -> input -> is_ajax_request()) {
						$resultados['error'] = true;
						$resultados['message'] = "El nombre de role ingresado ya existe!";

						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						$errors = $this -> roles_frr -> get_error_message();
					}
				}

			}// Fin validacion formulario

			//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
			if ($this -> input -> is_ajax_request()) {
				$resultados['error'] = true;
				$resultados['message'] = "El nombre de usuario y su descripcion son campos requeridos!";

				//Devolvemos los resultados en JSON
				echo json_encode($resultados);
				//Ya no tenemos nada que hacer en esta funcion
				return;
			} else {

				$data = $this -> roles_frr -> get_error_message();

				//Cargamos en data los permisos del role
				$data['permisosRole'] = $this -> roles_frr -> get_permisos_role($role_id);
				//Cargamos en data los permisos del sistema
				$data['permisos'] = ($this -> auth_frr -> es_admin()) ? $this -> roles_frr -> get_all_permisos() : $data['permisos'] = $this -> roles_frr -> get_all_permisos_no_admin();
				//Cargamos en data la info cargada en el role
				$data['roleRow'] = $this -> roles_frr -> get_role_by_id($role_id);
				if ($this -> auth_frr -> es_admin())
					$data['empresas'] = $this -> auth_frr -> get_empresas();
				$this -> template -> set_content('seguridad/modificar_role_form', $data);

				$this -> template -> build();
			}
		}
	}

	/**
	 * Guarda los cambios realizados al role (if any)
	 * @param type $role_id
	 */
	function save_modificacion_role($role_id) {
		$this -> form_validation -> set_rules('nombre', 'Nombre de Role', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('descripcion', 'Descripcion', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('empresa_id', 'Empresa', 'trim|required|xss_clean');
		$this -> load -> model('auth/empresas');

		if ($this -> form_validation -> run()) {
			if ($this -> roles_frr -> role_name_disponible_edicion($this -> input -> post('nombre'), $role_id)) {
				if ($this -> auth_frr -> es_admin())
					$empresa_id = $this -> input -> post('empresa_id');
				else
					$empresa_id = $this -> auth_frr -> get_empresa_id();

				$empresa = $this -> empresas -> get_empresa_by_id($empresa_id);

				$data = array('nombre' => $this -> input -> post('nombre'), 'descripcion' => $this -> input -> post('descripcion'), 'empresa_id' => $empresa_id, 'tipo_empresa_id' => $empresa -> tipo_empresa_id);

				if ($this -> roles_frr -> modificar_role($role_id, $data)) {

					$permisos = $this -> roles_frr -> get_all_permisos();
					$role = $this -> roles_frr -> get_role_by_name($this -> input -> post('nombre'));
					$role_id = $role -> role_id;

					if (count($permisos) > 0) {
						foreach ($permisos as $permiso) {
							$permiso = $permiso['permiso'];
							if ($this -> input -> post($permiso))
								$permi[] = array('role_id' => $role_id, 'permiso_id' => $this -> input -> post($permiso));

						}

						// Actualizo los permisos al role
						if (isset($permi))
							$this -> roles_model -> actualiza_permisos_role($role_id, $permi);
						else
							$this -> roles_model -> actualiza_permisos_role($role_id, array());
					}

					//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
					if ($this -> input -> is_ajax_request()) {

						$resultados['message'] = "El role se ha modificado correctamente!";

						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						$message = "El role se ha modificado correctamente!";
						//$this->session->set_flashdata('message', $message);
						redirect('adm/seguridad/main');
					}
				} else {
					//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
					if ($this -> input -> is_ajax_request()) {
						$resultados['error'] = true;
						$resultados['message'] = "Se ha producido un error!";

						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						$errors = $this -> roles_frr -> get_error_message();
					}
				}
			} else {
				//Si entramos aca es porque el usuario no esta disponible
				//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
				if ($this -> input -> is_ajax_request()) {
					$resultados['error'] = true;
					$resultados['message'] = "El nombre de role ingresado ya existe!";

					//Devolvemos los resultados en JSON
					echo json_encode($resultados);
					//Ya no tenemos nada que hacer en esta funcion
					return;
				} else {
					$errors = $this -> roles_frr -> get_error_message();
				}
			}

		}// Fin validacion formulario

		//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
		if ($this -> input -> is_ajax_request()) {
			$resultados['error'] = true;
			$resultados['message'] = "El nombre de usuario y su descripcion son campos requeridos!";

			//Devolvemos los resultados en JSON
			echo json_encode($resultados);
			//Ya no tenemos nada que hacer en esta funcion
			return;
		} else {

			$data = $this -> roles_frr -> get_error_message();

			//Cargamos en data los permisos del role
			$data['permisosRole'] = $this -> roles_frr -> get_permisos_role($role_id);
			//Cargamos en data los permisos del sistema
			$data['permisos'] = $this -> roles_frr -> get_all_permisos();
			//Cargamos en data la info cargada en el role
			$data['roleRow'] = $this -> roles_frr -> get_role_by_id($role_id);
			if ($this -> auth_frr -> es_admin())
				$data['empresas'] = $this -> auth_frr -> get_empresas();
			$this -> template -> set_content('seguridad/modificar_role_form', $data);

			$this -> template -> build();
		}
	}

	function eliminar_role($role_id = NULL) {

		if ($role_id) {
			$data['roleRow'] = $this -> roles_frr -> get_role_by_id($role_id);
			if ($this -> roles_frr -> eliminar_role($role_id)) {
				$message = "El role se ha eliminado correctamente!";
				$this -> session -> set_flashdata('message', $message);
			} else {
				$errormsg = "No se ha podido eliminar el role!";
				$this -> session -> set_flashdata('errormsg', $errormsg);
			}
		}
	}

	/**
	 * Funcion para afectuar el registro de un nuevo usuario
	 */

	function registro() {
		$use_username = $this -> config -> item('use_username', 'auth_frr');

		//Si el nombre de usuario es requerido, se le imponen las reglas de validacion
		if ($use_username) {
			$this -> form_validation -> set_rules('username', 'Username', 'trim|required|xss_clean|min_length[' . $this -> config -> item('username_min_length', 'auth_frr') . ']|max_length[' . $this -> config -> item('username_max_length', 'auth_frr') . ']|alpha_dash');
		}

		$this -> form_validation -> set_error_delimiters('<p><i class="icon-exclamation-sign"></i> ', '</p>');
		//Reglas de validacion para los campos email, password y confirm_password
		$this -> form_validation -> set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this -> form_validation -> set_rules('password', 'Password', 'trim|required|xss_clean|min_length[' . $this -> config -> item('password_min_length', 'auth_frr') . ']|max_length[' . $this -> config -> item('password_max_length', 'auth_frr') . ']|alpha_dash');
		$this -> form_validation -> set_rules('confirm_password', 'Confirmar Password', 'trim|required|xss_clean|matches[password]');

		$data['errors'] = array();

		$email_activation = $this -> config -> item('email_activation', 'auth_frr');

		if ($this -> form_validation -> run()) {
			// Si ingresamos aca es porque la validacion de los campos fue exitosa
			// Tratamos de crear el nuevo usuario a traves de la libreria auth_frr.
			// Si la creacion fue exitosa devuelve un array con user y password para
			// enviarselo al usuario via email de bienvenida al sistema

			/* Para obtener la empresa en base al id */
			$this -> load -> model("auth/empresas");
			if ($this -> auth_frr -> es_admin())
				$empresa_id = $this -> input -> post('empresa_id');
			else
				$empresa_id = $this -> auth_frr -> get_empresa_id();
			$role_id = $this -> input -> post('role_id');

			if (!is_null($data = $this -> auth_frr -> create_user($use_username ? $this -> form_validation -> set_value('username') : '', $this -> form_validation -> set_value('email'), $this -> form_validation -> set_value('password'), $email_activation, $empresa_id, $role_id))) {

				$data['site_name'] = $this -> config -> item('website_name', 'auth_frr');

				//Si para activar la cuenta se requiere confirmar la direccion de email, ingresamos aca
				if ($email_activation) {
					// Enviamos el mail de activacion
					$data['activation_period'] = $this -> config -> item('email_activation_expire', 'auth_frr') / 3600;

					$this -> _send_email('activate', $data['email'], $data);

					unset($data['password']);
					// Limpia el password

					$this -> _show_message($this -> lang -> line('auth_message_registration_completed_1'));

				} else {
					if ($this -> config -> item('email_account_details', 'auth_frr')) {
						// Se envia el mail de bienvenida
						$this -> _send_email('welcome', $data['email'], $data);
					}
					unset($data['password']);
					// Limpia el password

					//$this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));
					$message = "El usuario se ha creado correctamente!";
					$this -> session -> set_flashdata('message', $message);
					redirect('adm/seguridad/gestionar_usuarios');
				}
			}
			// No se pudo crear el usuario, ya sea porque el usuario o mail existia, o algun otro problema
			else {
				$errors = $this -> auth_frr -> get_error_message();
				foreach ($errors as $k => $v)
					$data['errors'][$k] = $this -> lang -> line($v);
			}
		}

		$data['use_username'] = $use_username;
		//Si es admin le mostramos la lista de empresas
		if ($this -> auth_frr -> es_admin())
			$data['empresas'] = $this -> auth_frr -> get_empresas();
		$data['roles'] = $this -> roles_frr -> get_roles();

		$this -> template -> set_content('auth/register_form', $data);
		$this -> template -> build();
	}

	/**
	 * Modifica una cuenta registro registrada en el sistema
	 * NOTA: Solo disponible para admins
	 */
	function modificar_cuenta_registro() {
		//Chequeamos que el usuario logueado sea admin
		if ($this -> auth_frr -> es_admin()) {
			$this -> form_validation -> set_error_delimiters('<p><i class="icon-exclamation-sign"></i> ', '</p>');

			$this -> form_validation -> set_rules('nombre', 'Nombre de la empresa', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('codigo', 'Codigo', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('tipo_cuentaregistro_id', 'Tipo Cuenta Registro', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('empresa_id', 'Empresa', 'trim|required|xss_clean');

			$data['errors'] = array();

			//Chequeamos que los datos enviados por formulario sean correctos
			if ($this -> form_validation -> run()) {
				if (!is_null($data = $this -> empresas_frr -> modificar_cuenta_registro($this -> form_validation -> set_value('nombre'), $this -> form_validation -> set_value('codigo'), $this -> form_validation -> set_value('tipo_cuentaregistro_id'), $this -> form_validation -> set_value('empresa_id'), $this -> uri -> segment(4)))) {
					//Nos fijamos si la petición se hizo via AJAX
					if ($this -> input -> is_ajax_request()) {
						$resultados['message'] = "Se modifico la cuenta correctamente!";
						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						//La empresa se creo correctamente
						$message = "La cuenta se ha modificado correctamente!";
						$this -> session -> set_flashdata('message', $message);
						redirect('adm/seguridad/gestionar_cuentas_registro');
					}

				} else {
					//Chequeamos si la peticion se hizo via ajax
					if ($this -> input -> is_ajax_request()) {
						$resultados['message'] = $this -> empresas_frr -> get_error_message();
						$resultados['error'] = true;
						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						$data['errors'] = $this -> empresas_frr -> get_error_message();
					}
				}
			}

			//Si la peticion se hizo via AJAX
			if ($this -> input -> is_ajax_request()) {
				$resultados['error'] = true;
				//Chequeamos que alguno de los campos requeridos este vacio
				//Si esta vacio mostramos un mensaje general
				if (!$this -> input -> post('nombre') || !$this -> input -> post('codigo')) {
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
					$data['row_empresa'] = $this -> empresas_frr -> get_cuenta_registro_by_id($this -> uri -> segment(4));
				}

				$data['empresas'] = $this -> empresas_frr -> get_empresas();
				$data['tipos_cuenta_registro'] = $this -> empresas_frr -> get_tipos_cuentas_registro();

				//Asignamos un texto al boton submit del formulario
				$data['tb'] = "Modificar Cuenta Registro";
				//Asignamos un titulo para el encabezado del formulario
				$data['tf'] = "Modificar Cuenta Registro";

				$this -> template -> set_content('seguridad/agregar_cuenta_registro_form', $data);
				$this -> template -> build();
			} else {
				redirect('adm/ew');
			}
		}
	}

	/**
	 *  Muestra la pantalla con todos los usuarios del sistema
	 */
	function gestionar_usuarios() {
		$this -> breadcrumb -> append_crumb('Home', site_url('adm/home'));
		$this -> breadcrumb -> append_crumb('Seguridad', site_url() . "/adm/seguridad/");
		$this -> breadcrumb -> append_crumb('Gestionar Usuarios', site_url() . "/adm/admin/gestionar_usuarios");

		//Cargamos el archivo que contiene la info con la que se contruye el menu
		$this -> config -> load('menu_permisos', TRUE);

		//Obtenemos los permisos del usuario logueado asociados a la controladora seguridad y grupo gestionar_usuarios
		$data['permisos'] = $this -> roles_frr -> permisos_role_controladora_grupo($this -> uri -> segment(2), $this -> uri -> segment(3));

		//Procesamos los permisos obtenidos
		if (count($data['permisos']) > 0) {
			foreach ($data['permisos'] as $key => $row) {
				$data['data_menu'][$row['permiso']] = $this -> config -> item($row['permiso'], 'menu_permisos');
			}
		}

		$empid = $this -> auth_frr -> get_empresa_id();
		if ($this -> auth_frr -> es_admin())
			$data['usuarios'] = $this -> auth_frr -> get_users();
		else
			$data['usuarios'] = $this -> auth_frr -> get_users_empresa($empid);

		//Obtenemos el id del usuario logueado
		$data['id_usuario_logueado'] = $this -> auth_frr -> get_user_id();

		//print_r($data['usuarios']);
		foreach ($data['usuarios'] as $key => $value) {
			//echo $value['user_id'];
			$role = $this -> roles_frr -> role_usuario($value['user_id']);
			if ($role) {
				$data['nombre_role'][$value['user_id']] = $role -> nombre;
			} else {
				$data['nombre_role'][$value['user_id']] = "Sin role";
			}
		}

		if ($message = $this -> session -> flashdata('message')) {
			$data['message'] = $message;
		}

		if ($errormsg = $this -> session -> flashdata('errormsg')) {
			$data['errormsg'] = $errormsg;
		}

		//$this->template->set_content('seguridad/gestionar_usuarios', $data);
		$this -> template -> set_content('seguridad/gestionar_usuarios', $data);
		$this -> template -> build();
	}

	function eliminar_user($user_id) {

		//Obtenemos el id del usuario logueado
		$id_usuario_logueado = $this -> auth_frr -> get_user_id();

		//Chequeamos que el usuario no pueda eliminarse a si mismo
		if ($user_id != $id_usuario_logueado) {
			if ($this -> auth_frr -> delete_user_admin($user_id)) {
				$message = "Se ha eliminado al usuario correctamente!";
				$this -> session -> set_flashdata('message', $message);
			} else {
				$errormsg = "No se pudo eliminar el usuario usuario!";
				$this -> session -> set_flashdata('errormsg', $errormsg);
			}
		}

	}

	/**
	 * Controladora para la operacion de cambiar passwords
	 */

	function cambiar_password($user_id = NULL) {
		//$this->form_validation->set_rules('usuarioid', 'ID Usuario', 'required');
		$this -> form_validation -> set_rules('password', 'Password', 'trim|required|xss_clean|min_length[' . $this -> config -> item('password_min_length', 'auth_frr') . ']|max_length[' . $this -> config -> item('password_max_length', 'auth_frr') . ']|alpha_dash');

		if ($user_id) {
			$user = $this -> users -> get_user_by_id($user_id, true);

			$data = array("username" => $user -> username, "user_id" => $user_id);

			/*$this->template->set_content('auth/change_pass', $data);
			 $this->template->build();*/
			if ($this -> form_validation -> run()) {

				if ($this -> auth_frr -> cambiar_password_admin($user_id, $this -> input -> post('password'))) {

					//Si el cambio de password se peticiono por medio de ajax devolvemos el resultado via JSON
					if ($this -> input -> is_ajax_request()) {

						$resultados['message'] = "Se cambio el password correctamente!";
						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						$message = "Se cambio el password correctamente!";
						$this -> session -> set_flashdata('message', $message);
						redirect('adm/seguridad/gestionar_usuarios');
					}
				}
			} else {
				$user = $this -> users -> get_user_by_id($user_id, true);

				//Si el cambio de email se peticiono por medio de ajax devolvemos el resultado via JSON
				if ($this -> input -> is_ajax_request()) {
					$resultados['error'] = true;
					$resultados['message'] = "La contraseña no puede estar vacia y debe tener entre 4 y 20 caracteres";
					//Devolvemos los resultados en JSON
					echo json_encode($resultados);
					//Ya no tenemos nada que hacer en esta funcion
					return;
				}

				$data = array("username" => $user -> username, "user_id" => $user_id);

				$this -> template -> set_content('auth/change_pass', $data);
				$this -> template -> build();
			}

		} else {
			$errormsg = "Debes seleccionar un usuario!";
			$this -> session -> set_flashdata('errormsg', $errormsg);
			redirect('adm/seguridad/gestionar_usuarios');
		}
	}

	function cambiar_email($user_id = NULL) {
		$this -> form_validation -> set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

		$data['errors'] = array();

		if ($this -> form_validation -> run()) {
			//Si entramos es porque se cambio correctamente
			if (!is_null($data = $this -> auth_frr -> cambiar_email_admin($user_id, $this -> input -> post('email')))) {

				$data['site_name'] = $this -> config -> item('website_name', 'auth_frr');

				// Se manda el email con la key para que se active
				$this -> _send_email('change_email', $data['new_email'], $data);

				//Si el cambio de email se peticiono por medio de ajax devolvemos el resultado via JSON
				if ($this -> input -> is_ajax_request()) {
					$resultados['message'] = "Se ha enviado al usuario un mail con los pasos a seguir!";
					$resultados['email_nuevo'] = $this -> input -> post('email');
					//Devolvemos los resultados en JSON
					echo json_encode($resultados);
					//Ya no tenemos nada que hacer en esta funcion
					return;
				} else {
					$message = "Se ha enviado al usuario un mail con los pasos a seguir!";
					$this -> session -> set_flashdata('message', $message);
					redirect('adm/seguridad/gestionar_usuarios');
				}

			} else {
				//No se valido el mail correctamente

				//Chequeamos si la peticion se hizo via ajax
				if ($this -> input -> is_ajax_request()) {
					$resultados['message'] = "El mail ingresado ya esta en uso";
					$resultados['error'] = true;
					//Devolvemos los resultados en JSON
					echo json_encode($resultados);
					//Ya no tenemos nada que hacer en esta funcion
					return;
				} else {
					$errors = $this -> auth_frr -> get_error_message();
				}
			}
		}

		if (isset($errors)) {
			$data['errors'] = $errors;
		}

		//Chequeamos si la peticion se hizo via ajax
		//Si entramos aca es porque hubo un error de validacion
		if ($this -> input -> is_ajax_request()) {

			//Chequeamos los dos tipos de errores posibles en este caso
			//O bien  esta vacio
			//o bien el mail ingresado no es valido
			if (!$this -> input -> post('email')) {
				$resultados['message'] = "El mail no puede estar vacio";
			} else {
				$resultados['message'] = "Debe ingresar un mail valido";
			}

			$resultados['error'] = true;
			//Devolvemos los resultados en JSON
			echo json_encode($resultados);
			//Ya no tenemos nada que hacer en esta funcion
			return;
		}

		$user = $this -> users -> get_user_by_id($user_id, true);

		$data['username'] = $user -> username;
		$data['user_id'] = $user_id;

		$this -> template -> set_content('auth/cambiar_email', $data);
		$this -> template -> build();
	}

	/**
	 * Reemplaza el email viejo del usuario por el nuevo
	 * Se verifica al usuario por el ID y la Key enviada por email
	 *
	 * @return void
	 */
	function reset_email() {
		$user_id = $this -> uri -> segment(4);
		$new_email_key = $this -> uri -> segment(5);

		// Tratamos de restear el email
		if ($this -> auth_frr -> activate_new_email($user_id, $new_email_key)) {
			$this -> auth_frr -> logout();
			$this -> _show_message($this -> lang -> line('auth_message_new_email_activated') . ' ' . anchor('/ew/login/', 'Login'));

		} else {// fail
			$this -> _show_message($this -> lang -> line('auth_message_new_email_failed'));
		}
	}

	/*
	 *  Metodo para mostrar la opcion de editar un usuario
	 */
	function editar_usuario($user_id = NULL) {
		if ($user_id) {
			$this -> load -> model('auth/users');
			$this -> form_validation -> set_rules('username', 'Username', 'trim|required|xss_clean');

			if ($this -> form_validation -> run()) {
				if ($this -> auth_frr -> es_admin())
					$empresa_id = $this -> input -> post('empresa_id');
				else
					$empresa_id = $this -> auth_frr -> get_empresa_id();
				if ($this -> auth_frr -> guardar_cambios_user($user_id, $this -> input -> post('username'), $empresa_id, $this -> input -> post('role_id'))) {

					//Verificamos si la peticion se hizo via ajax para darle forma a los mensajes de salida
					if ($this -> input -> is_ajax_request()) {
						$message = "El usuario se ha modificado correctamente!";
						$resultados['message'] = $message;
						//Actualizamos los datos de la sesion

						$datosSession = array('username' => $this -> input -> post('username'), 'empresa_id' => $empresa_id, 'role_id' => $this -> input -> post('role_id'));

						if ($this -> auth_frr -> update_session_data($datosSession, $user_id)) {
							//Si usuario logueado actualizo sus datos modificamos el nombre de usuario
							//para que refleje los cambios realizados
							$resultados['mismo_usuario'] = true;
						} else {
							$resultados['mismo_usuario'] = false;
						}

						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						$message = "El usuario se ha modificado correctamente!";
						$this -> session -> set_flashdata('message', $message);
						redirect('adm/seguridad/main');
					}
				}
				//Errores
				else {
					//Verificamos si la peticion se hizo via ajax para darle forma a los mensajes de salida
					if ($this -> input -> is_ajax_request()) {
						$resultados['message'] = "El usuario ya existe";
						$resultados['error'] = true;
						//Devolvemos los resultados en JSON
						echo json_encode($resultados);
						//Ya no tenemos nada que hacer en esta funcion
						return;
					} else {
						$data['usuario_existente'] = "El usuario ya existe";
						$data['usuario'] = $this -> users -> get_user_by_id($user_id, true);
						if ($this -> auth_frr -> es_admin())
							$data['empresas'] = $this -> auth_frr -> get_empresas();
						$data['roles'] = $this -> roles_frr -> get_roles();

						$this -> template -> set_content('seguridad/editar_usuarios', $data);
					}
				}

				$this -> template -> build();
			} else {
				//Verificamos si la peticion se hizo via ajax para darle forma a los mensajes de salida
				if ($this -> input -> is_ajax_request()) {
					$resultados['message'] = "El usuario no puede estar vacio";
					$resultados['error'] = true;
					//Devolvemos los resultados en JSON
					echo json_encode($resultados);
					//Ya no tenemos nada que hacer en esta funcion
					return;
				} else {
					$data['usuario'] = $this -> users -> get_user_by_id($user_id, true);

					//print_r($data['usuarios']->username);
					//die();
					if ($this -> auth_frr -> es_admin()) {
						$data['empresas'] = $this -> auth_frr -> get_empresas();
						$data['es_admin'] = true;
					}
					$data['roles'] = $this -> roles_frr -> get_roles();

					$this -> template -> set_content('seguridad/editar_usuarios', $data);
					$this -> template -> build();
				}
			}
		}
	}

	function guardar_cambios_usuario($user_id = NULL) {
		if ($user_id) {
			if ($this -> auth_frr -> guardar_cambios_user($user_id, $this -> input -> post('username'), $this -> input -> post('empresa_id'), $this -> input -> post('role_id'))) {
				$message = "El usuario se ha modificado correctamente!";
				$this -> session -> set_flashdata('message', $message);
				redirect('adm/seguridad/main');
			} else {
				$errors['usuario_existente'] = "El usuario ya existe";
				$this -> template -> set_content('seguridad/editar_usuario/' . $user_id, $errors);
			}

			$this -> template -> build();
		}
	}

	/**
	 * Método general para mostrar Errores
	 */
	function error() {
		//Cargamos el archivo que contiene la info con la que se contruye el menu
		$this -> config -> load('menu_permisos', TRUE);

		$item = $this -> uri -> segment(4) . "-" . $this -> uri -> segment(5);
		$data = $this -> config -> item($item, 'menu_permisos');

		$this -> template -> set_content('general/mensaje', $data);
		$this -> template -> build();
	}

	/**
	 * Muestra mensaje con flashdata
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message) {
		$this -> session -> set_flashdata('message', $message);
		redirect('adm/ew');
	}

	/**
	 * Funciona para mandar emails (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	function _send_email($type, $email, &$data) {
		$this -> load -> library('email');

		$this -> email -> initialize(array('protocol' => 'smtp', 'smtp_host' => 'smtp.sendgrid.net', 'mailtype' => 'html', 'smtp_user' => 'framini', 'smtp_pass' => 'montfran', 'bcc_batch_mode' => true, 'bcc_batch_size' => 3, 'smtp_port' => 587, 'crlf' => "\r\n", 'newline' => "\r\n"));

		$this -> email -> from($this -> config -> item('webmaster_email', 'auth_frr'), $this -> config -> item('webmaster_email', 'auth_frr'));
		$this -> email -> reply_to($this -> config -> item('webmaster_email', 'auth_frr'), $this -> config -> item('webmaster_email', 'auth_frr'));
		$this -> email -> to($email);
		$this -> email -> subject(sprintf($this -> lang -> line('auth_subject_' . $type), $this -> config -> item('website_name', 'auth_frr')));
		$this -> email -> message($this -> load -> view('email/' . $type . '-html', $data, TRUE));
		$this -> email -> set_alt_message($this -> load -> view('email/' . $type . '-txt', $data, TRUE));
		$this -> email -> send();
	}

}
