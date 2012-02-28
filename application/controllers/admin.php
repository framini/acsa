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
		 * Método utilizado para mostrar el formulario para crear un formulario
		 * Método utilizado para crear un formulario
		 */
		function alta_formulario() {

			$this->form_validation->set_rules('forms_nombre', 'Nombre del Form', 'trim|required|xss_clean');
			$this->form_validation->set_rules('forms_nombre_action', 'Nombre del Action', 'trim|required|xss_clean');
			$this->form_validation->set_rules('grupos_fields_id', 'Nombre del Grupo de Fields', 'trim|required|xss_clean');
			
			//Si ingresamos acà es porque se hizo el envío del formulario
			if($this->form_validation->run()) {

				if($this->administracion_frr->create_form(
						$this->form_validation->set_value('forms_nombre'),
						$this->form_validation->set_value('forms_nombre_action'),
						$this->form_validation->set_value('grupos_fields_id')
						
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
						$this->form_validation->set_value('grupos_fields_id')
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
			
			$this->template->set_content('admin/fields_form', $data);
			$this->template->build();
		}
}