<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

##################################################
# Controladora para la administracion de contenido
# Descripcion:
# Controladora utilizada para la creacion, baja y 
# modificacion de formularios, grupos de campos y 
# campos.
# NOTA: Solo disponible para administradores
#################################################

class Admin extends MY_Controller {
                  
        public function __construct() {
             parent::__construct();

             $this->lang->load('auth_frr');
        }
		 
        /**
        * Main controla la pagina cuando ingresan a Admin
       */    
        public function index() {
		}
		
		/**
		 * Método utilizado para mostrar un formulario basado en la URI
		 */
		function form() {
			if($id_form = $this->uri->segment(3)) {
				//Obtenemos el registro del form en base a la URI
				$form = $this->administracion_frr->get_form_by_id($id_form);
				//Obtenemos los datos del grupo de fields asociados al formulario
				$data['datos_fields'] = $this->administracion_frr->get_fields_grupo_fields($form->grupos_fields_id);
				//Preparamos la informacion para que luego pueda ser generada dinamicamente en la vista
				$data['datos_parseados'] = $this->administracion_frr->parser_field_type($data['datos_fields']);
				
				//Chequeamos que el formulario tenga fields
				if(!empty($data)) {
					$data['t'] = "Crear Formulario";
					$data['tb'] = "Crear Formulario";
					
					$this->template->set_content('admin/mostrar_form', $data);
					$this->template->build();
				}
			}
		}
		
		/**
		 * Lista todos los forms del sistema
		 */
		function forms() {
			//Obtenemos los permisos para poder construir el contenido de la seccion en base a ellos
			$data['permisos'] = $this->roles_frr->permisos_role_controladora_grupo($this->uri->segment(1), $this->uri->segment(2));
			$data['data_menu'] = $this->roles_frr->procesa_permisos_view($data['permisos']);

			$data['forms'] = $this->administracion_frr->get_forms();
			
			$this->template->set_content("admin/listar_forms", $data);
			$this->template->build();
		}
		
		/**
		 * Lista todos los grupos de fields del sistema
		 */
		function grupos_fields() {
			//Obtenemos los permisos para poder construir el contenido de la seccion en base a ellos
			$data['permisos'] = $this->roles_frr->permisos_role_controladora_grupo($this->uri->segment(1), $this->uri->segment(2));
			$data['data_menu'] = $this->roles_frr->procesa_permisos_view($data['permisos']);

			$data['grupos_fields'] = $this->administracion_frr->get_grupos_fields();
			
			$this->template->set_content("admin/listar_grupos_fields", $data);
			$this->template->build();
		}
		
		/**
		 * Lista todos los fields que pertenecen a un grupo del sistema
		 */
		function fields() {
			//Solo hacemos algo si existe el registro del grupo que pasamos en la URI
			if(!is_null($gf = $this->administracion_frr->get_grupo_field_by_id($this->uri->segment(3)))) {
				//Obtenemos los permisos para poder construir el contenido de la seccion en base a ellos
				$data['permisos'] = $this->roles_frr->permisos_role_controladora_grupo($this->uri->segment(1), $this->uri->segment(2));
				$data['data_menu'] = $this->roles_frr->procesa_permisos_view($data['permisos']);
				
				$data['fields'] = $this->administracion_frr->get_fields_grupo_fields($this->uri->segment(3));
				
				$this->template->set_content("admin/listar_fields", $data);
				$this->template->build();
			}
		}
		
		/**
		 * Método utilizado para mostrar el formulario para crear un formulario
		 * Método utilizado para crear un formulario
		 */
		function alta_formulario() {
			
			$this->form_validation->set_rules('forms_nombre', 'Nombre del Form', 'trim|required|xss_clean');
			$this->form_validation->set_rules('forms_nombre_action', 'Nombre del Action', 'trim|required|xss_clean');
			$this->form_validation->set_rules('grupos_fields_id', 'Nombre del Grupo de Fields', 'trim|required|xss_clean');
			$this->form_validation->set_rules('forms_descripcion', 'Descripcion del Form', 'trim|xss_clean');
			$this->form_validation->set_rules('forms_titulo', 'Titulo del Form', 'trim|xss_clean');
			$this->form_validation->set_rules('forms_texto_boton_enviar', 'Texto del Boton Enviar', 'trim|xss_clean');
			
			//Si ingresamos acà es porque se hizo el envío del formulario
			if($this->form_validation->run()) {

				if($this->administracion_frr->create_form(
						$this->form_validation->set_value('forms_nombre'),
						$this->form_validation->set_value('forms_nombre_action'),
						$this->form_validation->set_value('grupos_fields_id'),
						$this->form_validation->set_value('forms_descripcion'),
						$this->form_validation->set_value('forms_titulo'),
						$this->form_validation->set_value('forms_texto_boton_enviar')
						)) {
					$message = "El Form se ha creado correctamente!";
                    $this->session->set_flashdata('message', $message);
					redirect('seguridad');
				} else {
					//Si no se pudo crear el grupo buscamos que paso
					$data['errors'] = $this->administracion_frr->get_error_message();
				}
			}
			
			$data['grupos_fields'] = $this->administracion_frr->get_grupos_fields();
			$data['t'] = "Crear Formulario";
			$data['tb'] = "Crear Formulario";
			
			$this->template->set_content('admin/forms_form', $data);
			$this->template->build();
		}

		/**
		 * Método utilizado para mostrar el formulario para crear un grupo de fields
		 * Método utilizado para crear un grupo de fields
		 */
		function alta_grupos_fields() {
			
			$this->form_validation->set_rules('grupos_fields_nombre', 'Nombre del Grupo de Fields', 'trim|required|xss_clean');
			
			//Si ingresamos acà es porque se hizo el envío del formulario
			if($this->form_validation->run()) {

				if($this->administracion_frr->create_grupos_fields($this->form_validation->set_value('grupos_fields_nombre'))) {
					$message = "El grupo de fields se ha creado correctamente!";
                    $this->session->set_flashdata('message', $message);
					redirect('seguridad');
				} else {
					//Si no se pudo crear el grupo buscamos que paso
					$data['errors'] = $this->administracion_frr->get_error_message();
				}
			}

			$data['t'] = "Crear Grupo de Fields";
			$data['tb'] = "Crear Grupo";
			
			$this->template->set_content('admin/grupos_fields_form', $data);
			$this->template->build();
		}

		/**
		 * Método utilizado para mostrar el formulario para crear nuevos fields
		 * Método utilizado para crear fields y asignarlos a un grupo
		 */
		function alta_fields() {
			
			$this->form_validation->set_rules('fields_nombre', 'Nombre del Fields', 'trim|required|xss_clean');
			$this->form_validation->set_rules('fields_label', 'Nombre del Fields', 'trim|required|xss_clean');
			$this->form_validation->set_rules('fields_instrucciones', 'Instrucciones del Fields', 'trim|required|xss_clean');
			$this->form_validation->set_rules('fields_posicion', 'Posicion del Fields', 'trim|required|xss_clean');
			
			$this->form_validation->set_rules('fields_value_defecto', '', 'trim|xss_clean');
			$this->form_validation->set_rules('fields_requerido', '', 'trim|xss_clean');
			$this->form_validation->set_rules('fields_hidden', '', 'trim|xss_clean');
			$this->form_validation->set_rules('grupos_fields_id', '', 'trim|xss_clean');
			$this->form_validation->set_rules('fields_type_id', '', 'trim|xss_clean');
			$this->form_validation->set_rules('fields_option_items', '', 'trim|xss_clean');

			//Si ingresamos acà es porque se hizo el envío del formulario
			if($this->form_validation->run()) {

				if($this->administracion_frr->create_fields(
						$this->form_validation->set_value('fields_nombre'),
						$this->form_validation->set_value('fields_label'),
						$this->form_validation->set_value('fields_instrucciones'),
						$this->form_validation->set_value('fields_value_defecto'),
						$this->form_validation->set_value('fields_requerido'),
						$this->form_validation->set_value('fields_hidden'),
						$this->form_validation->set_value('fields_posicion'),
						$this->form_validation->set_value('grupos_fields_id'),
						$this->form_validation->set_value('fields_type_id'),
						$this->form_validation->set_value('fields_option_items')
						)) {
					$message = "El field se ha creado correctamente!";
                    $this->session->set_flashdata('message', $message);
					redirect('seguridad');
				} else {
					//Si no se pudo crear el grupo buscamos que paso
					$data['errors'] = $this->administracion_frr->get_error_message();
				}
			}
			
			//Si no especificamos por URI el id del grupo_field al cual asociaremos
			//el field, cargamos todos los grupos de fields del sistema
			if(!$this->uri->segment(3)) {		
				$data['grupos_fields'] = $this->administracion_frr->get_grupos_fields();
			} else {
				//Obtenemos el orden del field que deberia tener por default
				//Por defecto serìa de ùltimo
				$data['ordenSiguiente'] = $this->administracion_frr->get_orden_siguiente_field($this->uri->segment(3));
			}

			$data['t'] = "Crear Field";
			$data['tb'] = "Crear Field";
			//Obtenemos los fields types soportados por el sistema
			$data['fields_types'] = $this->administracion_frr->get_fields_types();
			
			$this->template->set_content('admin/fields_form', $data);
			$this->template->build();
		}
		
		/**
		 * Modificacion de un grupo de fields
		 */
		function modificar_grupo_field() {
			
			//Si existe algun grupo field con el ID pasado como parametro
			if(!is_null($gf = $this->administracion_frr->get_grupo_field_by_id($this->uri->segment(3)))) {
				//print_r($grupo_field);
				//die();
				$this->form_validation->set_rules('grupos_fields_nombre', 'Nombre del Grupo de Fields', 'trim|required|xss_clean');
				
				if($this->form_validation->run()) {
					//Si pasamos la validacion del form intentamos modificar el form
					if($this->administracion_frr->modificar_grupos_fields($this->uri->segment(3), $this->form_validation->set_value('grupos_fields_nombre'))) {
						$message = "El grupo de fields se ha modificado correctamente!";
	                    $this->session->set_flashdata('message', $message);
						redirect('admin/grupos_fields');
					} else {
						//Si no se pudo modificar el grupo buscamos que paso
						$data['errors'] = $this->administracion_frr->get_error_message();
					}
				}
				
				//Solamente cargamos los datos cuando no exista una request POST
				//Para no pisar los datos enviados por el usuarios
				if(!$this->input->post()) {
					//Obtenemos los datos
					$data['form_data'] = $gf;
				}
				
				$data['t'] = "Modificar Grupo de Fields";
				$data['tb'] = "Modificar Grupo";
				//Action del form
				$data['fa'] = site_url() . "/"  . $this->uri->segment(1) . "/"  . $this->uri->segment(2) . "/" . $this->uri->segment(3);
				
				$this->template->set_content('admin/grupos_fields_form', $data);
				$this->template->build();
			}
		}
		
		/**
		 * Modificacion de un field en base a la URI
		 */
		function modificar_field() {
			
			//Si existe un field con el ID pasado como parametro
			if(!is_null($f = $this->administracion_frr->get_field_by_id($this->uri->segment(3)))) {
				
				$this->form_validation->set_rules('fields_nombre', 'Nombre del Fields', 'trim|required|xss_clean');
				$this->form_validation->set_rules('fields_label', 'Nombre del Fields', 'trim|required|xss_clean');
				$this->form_validation->set_rules('fields_instrucciones', 'Instrucciones del Fields', 'trim|required|xss_clean');
				$this->form_validation->set_rules('fields_posicion', 'Posicion del Fields', 'trim|required|xss_clean');
				
				$this->form_validation->set_rules('fields_value_defecto', '', 'trim|xss_clean');
				$this->form_validation->set_rules('fields_requerido', '', 'trim|xss_clean');
				$this->form_validation->set_rules('fields_hidden', '', 'trim|xss_clean');
				$this->form_validation->set_rules('grupos_fields_id', '', 'trim|xss_clean');
				$this->form_validation->set_rules('fields_type_id', '', 'trim|xss_clean');
				$this->form_validation->set_rules('fields_option_items', '', 'trim|xss_clean');
	
				//Si ingresamos acà es porque se hizo el envío del formulario
				if($this->form_validation->run()) {
					$data = array(
						'fields_nombre' => $this->form_validation->set_value('fields_nombre'),
						'fields_label' => $this->form_validation->set_value('fields_label'),
						'fields_instrucciones' => $this->form_validation->set_value('fields_instrucciones'),
						'fields_value_defecto' => $this->form_validation->set_value('fields_value_defecto'),
						'fields_requerido' => $this->form_validation->set_value('fields_requerido'),
						'fields_hidden' => $this->form_validation->set_value('fields_hidden'),
						'fields_posicion' => $this->form_validation->set_value('fields_posicion'),
						'fields_type_id' => $this->form_validation->set_value('fields_type_id'),
						'fields_option_items' => $this->form_validation->set_value('fields_option_items')
					);
					if($this->administracion_frr->modificar_field($this->uri->segment(3), $data)) {
						$message = "El field se ha modificado correctamente!";
	                    $this->session->set_flashdata('message', $message);
						redirect('admin/grupos_fields/');
					} else {
						//Si no se pudo crear el grupo buscamos que paso
						$data['errors'] = $this->administracion_frr->get_error_message();
					}
				}//fin validacion built-in form
				
				//Solamente cargamos los datos cuando no exista una request POST
				//Para no pisar los datos enviados por el usuarios
				if(!$this->input->post()) {
					//Obtenemos los datos
					$data['row'] = $f;
				}
				$data['t'] = "Modificar Field";
				$data['tb'] = "Modificar Field";
				//Obtenemos los fields types soportados por el sistema
				$data['fields_types'] = $this->administracion_frr->get_fields_types();
				
				$this->template->set_content('admin/fields_form', $data);
				$this->template->build();
				
			}//Fin if
		}
}