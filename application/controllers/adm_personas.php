<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm_Personas extends MY_Controller {
                  
         public function __construct() {
             parent::__construct();
             $this->lang->load('auth_frr');
         }
		 
		 #########################################
		 # EMPRESAS
		 #########################################
		 /**
       	 * Main controla la pagina cuando ingresan a Personas
       	 */    
         public function index() {
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
			  
			  $data['titulo_gestion'] = "Menu de Personas";
			  $this->template->set_content('seguridad/main', $data);
              $this->template->build();            
         }
		 
		  /**
           *  Método que muestra la gestión de empresas
           */
          function gestionar_empresas() {
          	  $this->breadcrumb->append_crumb('Home', site_url('adm/home'));
			  $this->breadcrumb->append_crumb('Personas', site_url() . "/adm/personas/");
			  $this->breadcrumb->append_crumb('Gestionar Empresas', site_url() . "/adm/admin/gestionar_empresas");
			  
          	  //Cargamos el archivo que contiene la info con la que se contruye el menu
         	  $this->config->load('menu_permisos', TRUE);
			  
          	  //Obtenemos los permisos del usuario logueado asociados a la controladora personas y grupo gestionar_roles
          	  $data['permisos'] = $this->roles_frr->permisos_role_controladora_grupo($this->uri->segment(2), $this->uri->segment(3));
          	  
			  
			  //Procesamos los permisos obtenidos
			  if(count($data['permisos']) > 0) {
			  	foreach ($data['permisos'] as $key => $row) {
				  $data['data_menu'][$row['permiso']] = $this->config->item($row['permiso'], 'menu_permisos');
			  	}
			  }
			  
			  //Obtenemos todas las empresas cargadas en el sistema
              $data['empresas'] = $this->empresas_frr->get_empresas();
			  			  		  
               
              if ($message = $this->session->flashdata('message')) {
                              $data['message'] = $message;
              }
              
              if ($errormsg = $this->session->flashdata('errormsg')) {
                              $data['errormsg'] = $errormsg;
              }
              
			  $this->template->set_content('personas/gestionar_empresas', $data);
              $this->template->build();
          }

		  	/**
			 * Da de alta una empresa en el sistema
			 * NOTA: Solo disponible para admins
			 */
			function registro_empresa() {
	                
					//Solamente los admins se argentina clearing pueden crear empresas, asi que lo primero que chequeamos
					//es que el usuario sea admin
					if($this->auth_frr->es_admin()){
						$this->form_validation->set_error_delimiters('<p><i class="icon-exclamation-sign"></i> ', '</p>');
					
	                    $this->form_validation->set_rules('nombre', 'Nombre de la empresa', 'trim|required|xss_clean');
	                    $this->form_validation->set_rules('cuit', 'Cuit', 'trim|required|xss_clean');
						$this->form_validation->set_rules('tipo_empresa_id', 'Tipo Empresa', 'trim|required|xss_clean');
	
	                    $data['errors'] = array();
						
						//Chequeamos que los datos enviados por formulario sean correctos
	                    if ($this->form_validation->run()) {
	                    	if (!is_null($data = $this->empresas_frr->create_empresa(
	                                    $this->form_validation->set_value('nombre'),
	                                    $this->form_validation->set_value('cuit'),
	                                    $this->form_validation->set_value('tipo_empresa_id')))) 
	                        {
	                        	
								//Nos fijamos si la petición se hizo via AJAX
	                    		if($this->input->is_ajax_request()) {
									$resultados['message'] = "La empresa se ha creado correctamente!";
	                                //Devolvemos los resultados en JSON
	                                echo json_encode($resultados);
	                                //Ya no tenemos nada que hacer en esta funcion
	                                return;
								} else {
									//La empresa se creo correctamente
	                                $message = "La empresa se ha creado correctamente!";
	                                $this->session->set_flashdata('message', $message);
	                                redirect('adm/personas');
								}
	                        			
							}
						} else {
							//Si la peticion se hizo via AJAX
							if($this->input->is_ajax_request()) {
								$resultados['error'] = true;
								//Chequeamos que alguno de los campos requeridos este vacio
								//Si esta vacio mostramos un mensaje general
	                            if(!$this->input->post('nombre') || !$this->input->post('cuit') || !$this->input->post('tipo_empresa_id') ) {
	                            	$resultados['message'] = "Los campos requeridos no pueden estar vacios";
	                            }
	                            //Devolvemos los resultados en JSON
	                            echo json_encode($resultados);
	                            //Ya no tenemos nada que hacer en esta funcion
	                            return;
	                        }
						}
						
	                    $data['tipos_empresas'] = $this->empresas_frr->get_tipos_empresas();
	                    
	                    $this->template->set_content('personas/agregar_empresa_form', $data);
	                    $this->template->build();
						
					}
		    }


			/**
			 * Modifica una empresa registrada en el sistema
			 * NOTA: Solo disponible para admins
			 */
			function modificar_empresa() {
				//Solamente los admins se argentina clearing pueden crear empresas, asi que lo primero que chequeamos
				//es que el usuario sea admin
				if($this->auth_frr->es_admin()){
					$this->form_validation->set_error_delimiters('<p><i class="icon-exclamation-sign"></i> ', '</p>');
				
                    $this->form_validation->set_rules('nombre', 'Nombre de la empresa', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('cuit', 'Cuit', 'trim|required|xss_clean');
					$this->form_validation->set_rules('tipo_empresa_id', 'Tipo Empresa', 'trim|required|xss_clean');

                    $data['errors'] = array();
					
					//Chequeamos que los datos enviados por formulario sean correctos
                    if ($this->form_validation->run()) {
                    	if (!is_null($data = $this->empresas_frr->modificar_empresa(
                                    $this->form_validation->set_value('nombre'),
                                    $this->form_validation->set_value('cuit'),
                                    $this->form_validation->set_value('tipo_empresa_id'),
                                    $this->uri->segment(4)
									))) 
                        {
                        		//Nos fijamos si la petición se hizo via AJAX
                        		if($this->input->is_ajax_request()) {
									$resultados['message'] = "Se modifico la empresa correctamente!";
                                    //Devolvemos los resultados en JSON
                                    echo json_encode($resultados);
                                    //Ya no tenemos nada que hacer en esta funcion
                                    return;
								} else {
									//La empresa se creo correctamente
                                    $message = "La empresa se ha modificado correctamente!";
                                    $this->session->set_flashdata('message', $message);
                                    redirect('adm/personas');
								}
                        			
						} else {
							//Chequeamos si la peticion se hizo via ajax
                            if($this->input->is_ajax_request()) {
                                $resultados['message'] = $this->empresas_frr->get_error_message();
                                $resultados['error'] = true;
                                //Devolvemos los resultados en JSON
                                echo json_encode($resultados);
                                //Ya no tenemos nada que hacer en esta funcion
                                return;
                            } else {
								$data['errors'] = $this->empresas_frr->get_error_message();
							}
						}
					}
					
					//Si la peticion se hizo via AJAX
					if($this->input->is_ajax_request()) {
						$resultados['error'] = true;
						//Chequeamos que alguno de los campos requeridos este vacio
						//Si esta vacio mostramos un mensaje general
                        if(!$this->input->post('nombre') || !$this->input->post('cuit') ) {
                        	$resultados['message'] = "Los campos requeridos no pueden estar vacios";
                        }
                        //Devolvemos los resultados en JSON
                        echo json_encode($resultados);
                        //Ya no tenemos nada que hacer en esta funcion
                        return;
                    }
					//Solamente hacemos algo si está presente el id de la empresa en la URI
					if($this->uri->segment(4)) {
						//Solamente cargamos los datos cuando no exista una request POST
						//Para no pisar los datos enviados por el usuarios
						if(!$this->input->post()) {
							//Obtenemos la empresa
							$data['row_empresa'] = $this->empresas_frr->get_empresa_by_id($this->uri->segment(4));
						}
						
						//Obtenemos los tipos de empresa disponibles
                        $data['tipos_empresas'] = $this->empresas_frr->get_tipos_empresas();
						//Asignamos un texto al boton submit del formulario
						$data['tb'] = "Modificar Empresa";
						//Asignamos un titulo para el encabezado del formulario
						$data['tf'] = "Modificar Empresa";

                        $this->template->set_content('personas/agregar_empresa_form', $data);
                        $this->template->build();
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
			  function eliminar_empresa($empresa_id = NULL) {
              	    //Chequeamos que exista la confirmacion en la URI
                    if($this->uri->segment(5) == "si")
                    {
                        if($this->empresas_frr->eliminar_empresa($empresa_id))
                        {
                            $message = "La empresa se ha eliminado correctamente!";
                            $this->session->set_flashdata('message', $message);
							redirect('adm/personas');
                        } else {
                            $errormsg = "No se ha podido eliminar la empresa!";
                            $this->session->set_flashdata('errormsg', $errormsg);
                        }
                    }
                    //Mostramos el template solo en el caso que exista un id de empresa
					if($empresa_id) {
						$this->template->set_content('general/confirma_operacion');
						$this->template->build();
					}
              }
			  
			  
			  /**
			   * Método para mostrar el formulario de activacion de empresa
			   * Cuando viene con parametros POST funciona efectua la activacion
			   * NOTA: Solo disponible para admins
			   */
			  function activar_empresa($empresa_id = NULL) {
			  		//Chequeamos que exista la confirmacion en la URI
                    if($this->uri->segment(5) == "si")
                    {
						//Solamente intentamos activar la empresa en caso que la misma se encuentra desactivada
						if(!$this->empresas_frr->is_empresa_activada($empresa_id)) {
							if($this->empresas_frr->activar_empresa($empresa_id))
	                        {
                                $message = "La empresa se ha activado correctamente!";
                                $this->session->set_flashdata('message', $message);
								redirect('adm/personas');
	                        } else {
	                            $errormsg = "No se ha podido activar la empresa!";
	                            $this->session->set_flashdata('errormsg', $errormsg);
	                        }
						} else {
							redirect('adm/personas/error/3/1');
						}  
                    }
                    //Mostramos el template solo en el caso que exista un id de empresa
                    //y que la empresa no este activada
					if($empresa_id && !$this->empresas_frr->is_empresa_activada($empresa_id)) {
						$this->template->set_content('general/confirma_operacion');
						$this->template->build();
					} else {
						redirect('adm/personas/error/3/1');
					}
			  }

			  
			  
			 #########################################
			 # CUENTAS REGISTRO
			 #########################################
			  
			  /**
               *  Método que muestra la gestión de empresas
               */
              function gestionar_cuentas_registro() {
              	  $this->breadcrumb->append_crumb('Home', site_url('adm/home'));
				  $this->breadcrumb->append_crumb('Personas', site_url() . "/adm/personas/");
				  $this->breadcrumb->append_crumb('Gestionar Cuentas Registro', site_url() . "/adm/personas/gestionar_cuentas_registro");
				  
              	  //Cargamos el archivo que contiene la info con la que se contruye el menu
             	  $this->config->load('menu_permisos', TRUE);
				  
              	  //Obtenemos los permisos del usuario logueado asociados a la controladora personas y grupo gestionar_roles
              	  $data['permisos'] = $this->roles_frr->permisos_role_controladora_grupo($this->uri->segment(2), $this->uri->segment(3));
              	  
				  
				  //Procesamos los permisos obtenidos
				  if(count($data['permisos']) > 0) {
				  	foreach ($data['permisos'] as $key => $row) {
					  $data['data_menu'][$row['permiso']] = $this->config->item($row['permiso'], 'menu_permisos');
				  	}
				  }
				  
				  //Obtenemos todas las empresas cargadas en el sistema
                  $data['empresas'] = $this->empresas_frr->get_cuentas_registro();
				  			  		  
                   
                  if ($message = $this->session->flashdata('message')) {
                                  $data['message'] = $message;
                  }
                  
                  if ($errormsg = $this->session->flashdata('errormsg')) {
                                  $data['errormsg'] = $errormsg;
                  }
                  
				  $this->template->set_content('personas/gestionar_cuentas_registro', $data);
                  $this->template->build();
              }


				/**
				 * Da de alta una cuenta registro en el sistema
				 * NOTA: Solo disponible para admins
				 */
				function registro_cuenta_registro() {
                        
						//Chequeamos que el usuario logueado sea un admin
						if($this->auth_frr->es_admin()){
							$this->form_validation->set_error_delimiters('<p><i class="icon-exclamation-sign"></i> ', '</p>');
						
	                        $this->form_validation->set_rules('nombre', 'Nombre de la empresa', 'trim|required|xss_clean');
	                        $this->form_validation->set_rules('codigo', 'Codigo', 'trim|required|xss_clean');
							$this->form_validation->set_rules('tipo_cuentaregistro_id', 'Tipo Cuenta de Registro', 'trim|required|xss_clean');
							$this->form_validation->set_rules('empresa_id', 'Empresa', 'trim|required|xss_clean');
	
	                        $data['errors'] = array();
							
							//Chequeamos que los datos enviados por formulario sean correctos
	                        if ($this->form_validation->run()) {
	                        	
	                        	if (!is_null($data = $this->empresas_frr->create_cuenta_registro(
                                            $this->form_validation->set_value('nombre'),
                                            $this->form_validation->set_value('codigo'),
                                            $this->form_validation->set_value('tipo_cuentaregistro_id'),
                                            $this->form_validation->set_value('empresa_id')
											))) 
                                {
                                	
									//Nos fijamos si la petición se hizo via AJAX
                            		if($this->input->is_ajax_request()) {
										$resultados['message'] = "La cuenta registro se ha creado correctamente!";
                                        //Devolvemos los resultados en JSON
                                        echo json_encode($resultados);
                                        //Ya no tenemos nada que hacer en esta funcion
                                        return;
									} else {
										//La cuenta de registro se creo correctamente
                                        $message = "La cuenta registro se ha creado correctamente!";
                                        $this->session->set_flashdata('message', $message);
                                        redirect('adm/personas');
									}
                                			
								}
							} else {
								//Si la peticion se hizo via AJAX
								if($this->input->is_ajax_request()) {
									$resultados['error'] = true;
									//Chequeamos que alguno de los campos requeridos este vacio
									//Si esta vacio mostramos un mensaje general
	                                if(!$this->input->post('nombre') || !$this->input->post('codigo') ) {
	                                	$resultados['message'] = "Los campos requeridos (*) no pueden estar vacios";
	                                }
	                                //Devolvemos los resultados en JSON
	                                echo json_encode($resultados);
	                                //Ya no tenemos nada que hacer en esta funcion
	                                return;
	                            }
							}

							
							
	                        $data['empresas'] = $this->empresas_frr->get_empresas();
							$data['tipos_cuenta_registro'] = $this->empresas_frr->get_tipos_cuentas_registro();
	                        
	                        $this->template->set_content('personas/agregar_cuenta_registro_form', $data);
	                        $this->template->build();
							
						}
			    }


				/**
				 * Modifica una cuenta registro registrada en el sistema
				 * NOTA: Solo disponible para admins
				 */
				function modificar_cuenta_registro() {
					//Chequeamos que el usuario logueado sea admin
					if($this->auth_frr->es_admin()){
						$this->form_validation->set_error_delimiters('<p><i class="icon-exclamation-sign"></i> ', '</p>');
					
                        $this->form_validation->set_rules('nombre', 'Nombre de la empresa', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('codigo', 'Codigo', 'trim|required|xss_clean');
						$this->form_validation->set_rules('tipo_cuentaregistro_id', 'Tipo Cuenta Registro', 'trim|required|xss_clean');
						$this->form_validation->set_rules('empresa_id', 'Empresa', 'trim|required|xss_clean');

                        $data['errors'] = array();
						
						//Chequeamos que los datos enviados por formulario sean correctos
                        if ($this->form_validation->run()) {
                        	if (!is_null($data = $this->empresas_frr->modificar_cuenta_registro(
                                        $this->form_validation->set_value('nombre'),
                                        $this->form_validation->set_value('codigo'),
                                        $this->form_validation->set_value('tipo_cuentaregistro_id'),
                                        $this->form_validation->set_value('empresa_id'),
                                        $this->uri->segment(4)
										))) 
                            {
                            		//Nos fijamos si la petición se hizo via AJAX
                            		if($this->input->is_ajax_request()) {
										$resultados['message'] = "Se modifico la cuenta correctamente!";
                                        //Devolvemos los resultados en JSON
                                        echo json_encode($resultados);
                                        //Ya no tenemos nada que hacer en esta funcion
                                        return;
									} else {
										//La empresa se creo correctamente
                                        $message = "La cuenta se ha modificado correctamente!";
                                        $this->session->set_flashdata('message', $message);
                                        redirect('adm/personas/gestionar_cuentas_registro');
									}
                            			
							} else {
								//Chequeamos si la peticion se hizo via ajax
                                if($this->input->is_ajax_request()) {
                                    $resultados['message'] = $this->empresas_frr->get_error_message();
                                    $resultados['error'] = true;
                                    //Devolvemos los resultados en JSON
                                    echo json_encode($resultados);
                                    //Ya no tenemos nada que hacer en esta funcion
                                    return;
                                } else {
									$data['errors'] = $this->empresas_frr->get_error_message();
								}
							}
						}
						
						//Si la peticion se hizo via AJAX
						if($this->input->is_ajax_request()) {
							$resultados['error'] = true;
							//Chequeamos que alguno de los campos requeridos este vacio
							//Si esta vacio mostramos un mensaje general
                            if(!$this->input->post('nombre') || !$this->input->post('codigo') ) {
                            	$resultados['message'] = "Los campos requeridos no pueden estar vacios";
                            }
                            //Devolvemos los resultados en JSON
                            echo json_encode($resultados);
                            //Ya no tenemos nada que hacer en esta funcion
                            return;
                        }
						//Solamente hacemos algo si está presente el id de la empresa en la URI
						if($this->uri->segment(4)) {
							//Solamente cargamos los datos cuando no exista una request POST
							//Para no pisar los datos enviados por el usuarios
							if(!$this->input->post()) {
								//Obtenemos la empresa
								$data['row_empresa'] = $this->empresas_frr->get_cuenta_registro_by_id($this->uri->segment(4));
							}
							
							$data['empresas'] = $this->empresas_frr->get_empresas();
							$data['tipos_cuenta_registro'] = $this->empresas_frr->get_tipos_cuentas_registro();
							
							//Asignamos un texto al boton submit del formulario
							$data['tb'] = "Modificar Cuenta Registro";
							//Asignamos un titulo para el encabezado del formulario
							$data['tf'] = "Modificar Cuenta Registro";

	                        $this->template->set_content('personas/agregar_cuenta_registro_form', $data);
	                        $this->template->build();
						} else {
							redirect('adm/ew');
						}
					}
				}

				
			  function eliminar_cuenta_registro($empresa_id = NULL) {
              	    //Chequeamos que exista la confirmacion en la URI
                    if($this->uri->segment(5) == "si")
                    {
                        if($this->empresas_frr->eliminar_cuenta_registro($empresa_id))
                        {
                            $message = "La cuenta se ha eliminado correctamente!";
                            $this->session->set_flashdata('message', $message);
							redirect('adm/personas/gestionar_cuentas_registro');
                        } else {
                            $errormsg = "No se ha podido eliminar la cuenta!";
                            $this->session->set_flashdata('errormsg', $errormsg);
                        }
                    }
                    //Mostramos el template solo en el caso que exista un id de empresa
					if($empresa_id) {
						$this->template->set_content('general/confirma_operacion');
						$this->template->build();
					}
              }
			  
			  
			  function activar_cuenta_registro($empresa_id = NULL) {
			  		//Chequeamos que exista la confirmacion en la URI
                    if($this->uri->segment(5) == "si")
                    {
						//Solamente intentamos activar la empresa en caso que la misma se encuentra desactivada
						if(!$this->empresas_frr->is_cuenta_registro_activada($empresa_id)) {
							if($this->empresas_frr->activar_cuenta_registro($empresa_id))
	                        {
                                $message = "La cuenta se ha activado correctamente!";
                                $this->session->set_flashdata('message', $message);
								redirect('adm/personas');
	                        } else {
	                            $errormsg = "No se ha podido activar la cuenta!";
	                            $this->session->set_flashdata('errormsg', $errormsg);
	                        }
						} else {
							redirect('adm/personas/error/3/1');
						}  
                    }
                    //Mostramos el template solo en el caso que exista un id de empresa
                    //y que la empresa no este activada
					if($empresa_id && !$this->empresas_frr->is_cuenta_registro_activada($empresa_id)) {
						$this->template->set_content('general/confirma_operacion');
						$this->template->build();
					} else {
						redirect('adm/personas/error/3/1');
					}
			  }
				
				
			  /**
			   * Método general para mostrar Errores
			   */	
			  function error() {
			  		//Cargamos el archivo que contiene la info con la que se contruye el menu
	         	  	$this->config->load('menu_permisos', TRUE);
					
					$item = $this->uri->segment(4) . "-" . $this->uri->segment(5);
					$data = $this->config->item($item, 'menu_permisos');
	
					$this->template->set_content('general/mensaje', $data);
					$this->template->build();
			  }
}