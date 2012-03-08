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
         	  //Cargamos el archivo que contiene la info con la que se contruye el menu
	 		  $this->config->load('menu_permisos', TRUE);
			  
			  $data['permisos'] = $this->roles_frr->permisos_role_controladora($this->uri->segment(1));
			  
			  //Obtenemos la info necesaria para construir el menu de cada uno de los permisos
			  //Los datos estan de la forma $data['data_menu']['nombre_permiso']
			  if(count($data['permisos']) > 0) {
			  	foreach ($data['permisos'] as $key => $row) {
				 $data['data_menu'][$row['permiso']] = $this->config->item($row['permiso'] . '_gestion_' . $row['grupo'], 'menu_permisos');
			 	}
			  } else {
			  	$data['error_sin_permiso'] = $this->config->item('error_sin_permiso', 'menu_permisos');
			  }
			 
			 
			  
	          if ($message = $this->session->flashdata('message')) {
			  		$data['message'] = $message;
			  }
			  $this->template->set_content('admin/gestion_admin',$data);
	          $this->template->build();
		}
		
		/**
		 * Método utilizado para mostrar un formulario, crear contenido y editar contenido basado en la URI
		 */
		function form() {

			if(!is_null($form = $this->administracion_frr->get_form_by_id($this->uri->segment(3)))) {
				//Chequeamos si existen elementos en $_POST y si hay los procesamos
				if($this->input->post()) {
					//Pareamos los datos del $_POST, los validamos y si son correctos obtenemos el conjuto de datos a insertar
					if(!is_null($datos = $this->administracion_frr->parser_post($this->input->post()))) {
						$datos['forms_id'] = $this->uri->segment(3);
						//Si hay un entry_id especificado en la URI, es porque estamos tratando de editar una entrada
						
						if($this->uri->segment(4) && !is_null($entry = $this->administracion_frr->get_entry_by_id($this->uri->segment(4)))) {
							$this->breadcrumb->append_crumb('Home', site_url());
							$this->breadcrumb->append_crumb('Publicar', site_url() . "/admin/publicar_contenido");
							$this->breadcrumb->append_crumb('Editar entrada', site_url() . "/admin/editar_contenido");
							
							//Intentamos actualizar la entrada con los nuevos datos ingresados
							if($this->administracion_frr->actualizar_datos_form($this->uri->segment(3), $datos, $this->uri->segment(4))) {
								$message = "El contenido se ha actualizado correctamente!";
			                    $this->session->set_flashdata('message', $message);
								redirect('admin/editar_contenido');
							}
						} else {
							$this->breadcrumb->append_crumb('Home', site_url());
							$this->breadcrumb->append_crumb('Publicar', site_url() . "/admin/publicar_contenido");
							$this->breadcrumb->append_crumb('Nueva Entrada', site_url() . "/");
							
							//Si no se especifico un entry_id en la URI, es porque se esta tratando de crear contenido
							if($this->administracion_frr->persistir_datos_form($this->uri->segment(3), $datos)) {
								$message = "El contenido se ha creado correctamente!";
			                    $this->session->set_flashdata('message', $message);
								redirect('admin/editar_contenido');
							}
						}
					}
				} else {
					//Si hay un entry_id especificado en la URI, es porque estamos tratando de editar una entrada
					if($this->uri->segment(4) && !is_null($entry = $this->administracion_frr->get_entry_by_id($this->uri->segment(4)))) {
						$this->breadcrumb->append_crumb('Home', site_url());
						$this->breadcrumb->append_crumb('Publicar', site_url() . "/admin/publicar_contenido");
						$this->breadcrumb->append_crumb('Editar entrada', site_url() . "/admin/editar_contenido");
						//Datos extras
						$data['datos_extras'] = $this->administracion_frr->get_datos_extras_entradas($entry);
						//Cargamos los datos almancenados en la base de datos para luego mostrarlos en los campos del form
						$data['valores_campos'] = $this->administracion_frr->get_entry_datos_fields($entry);
					} else {
						$this->breadcrumb->append_crumb('Home', site_url());
						$this->breadcrumb->append_crumb('Publicar', site_url() . "/admin/publicar_contenido");
						$this->breadcrumb->append_crumb('Nueva Entrada', site_url() . "/");
					}
				}

				//Obtenemos los datos del grupo de fields asociados al formulario
				$data['datos_fields'] = $this->administracion_frr->get_fields_grupo_fields($form->grupos_fields_id);
				//Preparamos la informacion para que luego pueda ser generada dinamicamente en la vista
				$data['datos_parseados'] = $this->administracion_frr->parser_field_type($data['datos_fields']);
				
				//Chequeamos que el formulario tenga fields
				if(!empty($data)) {
					$data['t'] = isset($form->forms_titulo ) ? $form->forms_titulo  : "Formulario";
					$data['tb'] = isset($form->forms_texto_boton_enviar ) ? $form->forms_texto_boton_enviar  : "Enviar!";
					
					$this->template->set_content('admin/mostrar_form', $data);
					$this->template->build();
				}
			}
		}
		
		/**
		 * Eliminacion de un entry en base a un ID provisto en la URI
		 */
		function eliminar_entry() {
			//Antes de intentar eliminar la entrada chequeamos que exista
			if($this->uri->segment(3) && !is_null($entry = $this->administracion_frr->entry_exist($this->uri->segment(3)))) {
				//Nos fijamos si esta confirmada la eliminacion
				if($this->uri->segment(4) == "si") {
					if($this->administracion_frr->eliminar_entry($this->uri->segment(3))) {
					$message = "El contenido se ha eliminado correctamente!";
                    $this->session->set_flashdata('message', $message);
					redirect('admin/editar_contenido');
					} else {
						//Especificar error en caso de que no se haya podido eliminar la entrada
					}
				}
				
				$this->template->set_content('general/confirma_operacion');
				$this->template->build();
				
			} else {
				//Especificar un error en caso de que no exista un entry con el ID pasado
			}
		}
		
		/**
		 * Lista los forms disponibles para publicar contenido
		 */
		function publicar_contenido() {
			$this->breadcrumb->append_crumb('Home', site_url());
			$this->breadcrumb->append_crumb('Publicar', site_url() . "/admin/publicar_contenido");
			
			$data['forms'] = $this->administracion_frr->get_forms();
			
			if ($message = $this->session->flashdata('message')) {
		  		$data['message'] = $message;
		    }
			$this->template->set_content('admin/publicar_contenido', $data);
			$this->template->build();
		}
		
		/**
		 * Lista las entries del sistema
		 */
		function editar_contenido() {
			$this->breadcrumb->append_crumb('Home', site_url());
			$this->breadcrumb->append_crumb('Editar', site_url() . "/admin/editar_contenido");
			$data['entries'] = $this->administracion_frr->get_entries();
			if(!is_null($data['entries'])) {
				if ($message = $this->session->flashdata('message')) {
			  		$data['message'] = $message;
			    }
				$this->template->set_content('admin/listar_entradas', $data);
				$this->template->build();
			}
		}
		
		/**
		 * Lista todos los forms del sistema
		 */
		function forms() {
			$this->breadcrumb->append_crumb('Home', site_url());
			$this->breadcrumb->append_crumb('Admin', site_url() . "/admin");
			$this->breadcrumb->append_crumb('Forms', site_url() . "/admin/forms");
			//Obtenemos los permisos para poder construir el contenido de la seccion en base a ellos
			$data['permisos'] = $this->roles_frr->permisos_role_controladora_grupo($this->uri->segment(1), $this->uri->segment(2));
			$data['data_menu'] = $this->roles_frr->procesa_permisos_view($data['permisos']);
			if ($message = $this->session->flashdata('message')) {
		  		$data['message'] = $message;
		    }
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
			
			$this->breadcrumb->append_crumb('Home', site_url());
			$this->breadcrumb->append_crumb('Admin', site_url() . "/admin");
			$this->breadcrumb->append_crumb('Forms', site_url() . "/admin/forms");
			$this->breadcrumb->append_crumb('Grupos Fields', site_url() . "/admin/grupos_fields");
			
			//Si se especifico un ID de grupo en la URI filtramos los grupos de fields para que solo muestre el correspondiente al ID
			if($this->uri->segment(3)) {
				$grupo_field_nombre = $this->administracion_frr->get_grupo_field_by_id($this->uri->segment(3));
				$this->breadcrumb->append_crumb($grupo_field_nombre, site_url() . "/admin/forms");
				
				$data['grupos_fields'] = $this->administracion_frr->get_grupo_field_by_id_row($this->uri->segment(3));
			} else {
				//Sino cargamos todos
				$data['grupos_fields'] = $this->administracion_frr->get_grupos_fields();
			}
			
			if ($message = $this->session->flashdata('message')) {
			  	$data['message'] = $message;
			}
			
			$this->template->set_content("admin/listar_grupos_fields", $data);
			$this->template->build();
		}
		
		/**
		 * Lista todos los fields que pertenecen a un grupo del sistema
		 */
		function fields() {
			//Solo hacemos algo si existe el registro del grupo que pasamos en la URI
			if(!is_null($gf = $this->administracion_frr->get_grupo_field_by_id_row($this->uri->segment(3)))) {
				$this->breadcrumb->append_crumb('Home', site_url());
				$this->breadcrumb->append_crumb('Admin', site_url() . "/admin");
				$this->breadcrumb->append_crumb('Forms', site_url() . "/admin/forms");
				$this->breadcrumb->append_crumb('Grupos Fields', site_url() . "/admin/grupos_fields");
				$grupo_field_nombre = $this->administracion_frr->get_grupo_field_by_id($this->uri->segment(3));
				$this->breadcrumb->append_crumb($grupo_field_nombre, site_url() . "/admin/grupos_fields/" . $gf[0]['grupos_fields_id']);	
				$this->breadcrumb->append_crumb('Fields', site_url() . "/admin/fields");
				
				//Obtenemos los permisos para poder construir el contenido de la seccion en base a ellos
				$data['permisos'] = $this->roles_frr->permisos_role_controladora_grupo($this->uri->segment(1), $this->uri->segment(2));
				$data['data_menu'] = $this->roles_frr->procesa_permisos_view($data['permisos']);
				
				$data['fields'] = $this->administracion_frr->get_fields_grupo_fields($this->uri->segment(3));
				
				$data['grupo_field_id'] = $gf[0]['grupos_fields_id'];
				if ($message = $this->session->flashdata('message')) {
				  	$data['message'] = $message;
				}
				
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
			$this->form_validation->set_rules('forms_nombre_action', 'Nombre del Action', 'trim|xss_clean');
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
					redirect('admin/forms');
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
					redirect('admin/grupos_fields');
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
					redirect('admin/fields/' . $this->uri->segment(3) );
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
				
				$this->breadcrumb->append_crumb('Home', site_url());
				$this->breadcrumb->append_crumb('Admin', site_url() . "/admin");
				$this->breadcrumb->append_crumb('Forms', site_url() . "/admin/forms");
				$this->breadcrumb->append_crumb('Grupos Fields', site_url() . "/admin/grupos_fields");
				$this->breadcrumb->append_crumb('Modificar Grupo Fields', site_url() . "/");
				
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
				$this->breadcrumb->append_crumb('Home', site_url());
				$this->breadcrumb->append_crumb('Admin', site_url() . "/admin");
				$this->breadcrumb->append_crumb('Forms', site_url() . "/admin/forms");
				$this->breadcrumb->append_crumb('Grupos Fields', site_url() . "/admin/grupos_fields");
				if($this->uri->segment(4)) {
					$grupo_field_nombre = $this->administracion_frr->get_grupo_field_by_id($this->uri->segment(4));
					$this->breadcrumb->append_crumb($grupo_field_nombre, site_url() . "/admin/forms");
				}
				$this->breadcrumb->append_crumb('Modificar Fields', site_url() . "/");
				
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
						'fields_option_items' => $this->form_validation->set_value('fields_option_items'),
						'grupos_fields_id'  => $this->administracion_frr->get_field_group_id($this->uri->segment(3))
					);
					if($this->administracion_frr->modificar_field($this->uri->segment(3), $data)) {
						$message = "El field se ha modificado correctamente!";
	                    $this->session->set_flashdata('message', $message);
						redirect('admin/fields/' . $data['grupos_fields_id']);
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

		function modificar_form() {
			if(!is_null($f = $this->administracion_frr->get_form_by_id($this->uri->segment(3)))) {
				$this->breadcrumb->append_crumb('Home', site_url());
				$this->breadcrumb->append_crumb('Admin', site_url() . "/admin");
				$this->breadcrumb->append_crumb('Forms', site_url() . "/admin/forms");
				$this->breadcrumb->append_crumb('Modificar Formulario', "/");			
				
				$this->form_validation->set_rules('forms_nombre', 'Nombre del Form', 'trim|required|xss_clean');
				$this->form_validation->set_rules('forms_nombre_action', 'Nombre del Action', 'trim|required|xss_clean');
				$this->form_validation->set_rules('grupos_fields_id', 'Nombre del Grupo de Fields', 'trim|required|xss_clean');
				$this->form_validation->set_rules('forms_descripcion', 'Descripcion del Form', 'trim|xss_clean');
				$this->form_validation->set_rules('forms_titulo', 'Titulo del Form', 'trim|xss_clean');
				$this->form_validation->set_rules('forms_texto_boton_enviar', 'Texto del Boton Enviar', 'trim|xss_clean');
				
				//Si ingresamos acà es porque se hizo el envío del formulario
				if($this->form_validation->run()) {
					
					$data = array(
						'forms_nombre' => $this->form_validation->set_value('forms_nombre'), 
						'forms_nombre_action' => $this->form_validation->set_value('forms_nombre_action'), 
						'grupos_fields_id' => $this->form_validation->set_value('grupos_fields_id'),
						'forms_descripcion' => $this->form_validation->set_value('forms_descripcion'),
						'forms_titulo' => $this->form_validation->set_value('forms_titulo'),
						'forms_texto_boton_enviar' => $this->form_validation->set_value('forms_texto_boton_enviar')
					);
	
					if($this->administracion_frr->modificar_form($this->uri->segment(3), $data)) {
						$message = "El Form se ha modificado correctamente!";
	                    $this->session->set_flashdata('message', $message);
						redirect('admin/forms');
					} else {
						//Si no se pudo crear el grupo buscamos que paso
						$data['errors'] = $this->administracion_frr->get_error_message();
					}
				}
				
				//Solamente cargamos los datos cuando no exista una request POST
				//Para no pisar los datos enviados por el usuarios
				if(!$this->input->post()) {
					//Obtenemos los datos
					$data['row'] = $f;
				}

				$data['grupos_fields'] = $this->administracion_frr->get_grupos_fields();
				$data['t'] = "Modificar Formulario";
				$data['tb'] = "Modificar Formulario";
				
				$this->template->set_content('admin/forms_form', $data);
				$this->template->build();
			}
		}

		function baja_field() {
			//Si existe un field con el ID pasado como parametro
			if(!is_null($f = $this->administracion_frr->get_field_by_id($this->uri->segment(3)))) {
				if($this->uri->segment(4) == "si") {
					if($this->administracion_frr->eliminar_field($this->uri->segment(3))) {
						$message = "El field se ha eliminado correctamente!";
	                    $this->session->set_flashdata('message', $message);
						redirect('admin/grupos_fields/');
					}
				}
				
				$this->template->set_content('general/confirma_operacion');
				$this->template->build();
			}
		}
		
		function baja_grupo_fields() {
			//Si existe un grupo de fields con el ID pasado como parametro
			if(!is_null($gf = $this->administracion_frr->get_grupo_field_by_id($this->uri->segment(3)))) {
				if($this->uri->segment(4) == "si") {
					if($this->administracion_frr->eliminar_grupo_fields($this->uri->segment(3))) {
						$message = "El grupo de fields se ha eliminado correctamente!";
	                    $this->session->set_flashdata('message', $message);
						redirect('admin/grupos_fields/');
					}
				}
				
				$this->template->set_content('general/confirma_operacion');
				$this->template->build();
			}
		}
		
		function baja_formulario() {
			//Si existe un field con el ID pasado como parametro
			if(!is_null($f = $this->administracion_frr->get_form_by_id($this->uri->segment(3)))) {
				if($this->uri->segment(4) == "si") {
					if($this->administracion_frr->eliminar_form($this->uri->segment(3))) {
						$message = "El form se ha eliminado correctamente!";
	                    $this->session->set_flashdata('message', $message);
						$this->template->add_message("succes", $message);
						redirect('admin/forms/');
					}
				}
				
				$this->template->set_content('general/confirma_operacion');
				$this->template->build();
			}
		}
}