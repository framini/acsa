<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ewarrants extends MY_Controller {
                  
                 public function __construct() 
                 {
                     parent::__construct();
                     
                     $this->lang->load('auth_frr');
					 
					 //Chequeamos que el usuario que esta tratando de dar gestionar ewarrants
					 //sea de tipo warrantera o bien Argentina Clearing 
                     if((!$this->auth_frr->is_warrantera()  && !$this->auth_frr->is_argclearing())) {
                         redirect('');
                         die();
                     }

                     $this->load->helper(array('form', 'url'));
                     $this->load->model('ewarrants/ewarrants_model');
                 }
                 
                 function index() {
                 		  //Cargamos el archivo que contiene la info con la que se contruye el menu
                 		  $this->config->load('menu_permisos', TRUE);
						  
						  $data['permisos'] = $this->roles_frr->permisos_role_controladora($this->uri->segment(1));
						  
						  //Obtenemos la info necesaria para construir el menu de cada uno de los permisos
						  //Los datos estan de la forma $data['data_menu']['nombre_permiso']
						  if(count($data['permisos']) > 0) {
						  	foreach ($data['permisos'] as $key => $row) {
							 $data['data_menu'][$row['permiso']] = $this->config->item($row['permiso'], 'menu_permisos');
						 	}
						  } else {
						  	$data['error_sin_permiso'] = $this->config->item('error_sin_permiso', 'menu_permisos');
						  }
						 
						 
						  
                          if ($message = $this->session->flashdata('message')) {
						  		$data['message'] = $message;
						  }
						  $this->template->set_content('ewarrants/main_ewarrants',$data);
                          $this->template->build();
                 }
                 
                 function listar() {
						 $empresa_id = $this->auth_frr->get_empresa_id();
                         
                   		 if($this->auth_frr->es_admin()) 
                             $data['ewarrants'] = $this->ewarrants_frr->get_warrants_habilitados();
                         else
                            $data['ewarrants'] = $this->ewarrants_frr->get_warrants_empresa($empresa_id);
                         
                         if($data['ewarrants'] != null) {

                             if ($message = $this->session->flashdata('message')) {
                                    $data['message'] = $message;
                             }
                             $this->template->set_content('ewarrants/listar_ewarrants', $data);
                             $this->template->build();
                         } else {
                             $this->template->set_content('ewarrants/sin_permiso', array('msg' => 'Tu empresa no tiene eWarrants emitidos'));
                             $this->template->build();
                         }
                 }
                 
                 function ver_pendientes($ewid = null) {
                 		$empresa_id = $this->auth_frr->get_empresa_id();

						if ($this->auth_frr->es_admin()) {
							$data['ewarrants'] = $this->ewarrants_frr
									->get_warrants_habilitados_pendientes();
						} else {
							$data['ewarrants'] = $this->ewarrants_frr
									->get_warrants_empresa_pendientes($empresa_id);
						}
				
						if ($data['ewarrants'] != null) {
				
							if ($message = $this->session->flashdata('message')) {
								$data['message'] = $message;
							}
				
							//Si entramos aca es porque se esta tratando de firmar un ewarrant
							if ($ewid) {
								if ($this->uri->segment(3)) {
									//Cargamos el archivo que contiene la info con la que se contruye el menu
									$this->config->load('menu_permisos', TRUE);
				
									//Chequeamos que el warrant no este pendiente
									if ($this->ewarrants_frr->esta_pendiente($ewid)) {
										//Chequeamos que el usuario que esta tratando de habilitar pueda hacerlo
										if ($this->ewarrants_frr->can_habilitar($ewid)) {
											
											redirect('ewarrants/emitir/'.$ewid);
											
											die();
										}
										//No tiene los permisos suficientes para firmar el eWarrant
				 						else {
											//Cargamos el item que contiene la info del mensaje
											$datos_mensaje = $this->config
													->item('ewarrant_error_not_owner',
															'menu_permisos');
				
											//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
											if ($this->input->is_ajax_request()) {
				
												$resultados['error'] = true;
												$resultados['message'] = $datos_mensaje['texto'];
												$resultados['icono'] = $datos_mensaje['icono'];
				
												//Devolvemos los resultados en JSON
												echo json_encode($resultados);
												//Ya no tenemos nada que hacer en esta funcion
												return;
											} else {
												$this->template
														->set_content('ewarrants/sin_permiso',
																array(
																		'msg' => $datos_mensaje['texto']));
												$this->template->build();
											}
										}
									}
									
									//El eWarrant esta pendiente
				 					else {
				 						//Nos fijamos si el usuario logueado tiene role de aseguradora
				 						if($this->auth_frr->has_role_aseguradora()) {
				 							redirect('ewarrants/emitir/'.$this->uri->segment(3));
				 						}
				 						
										//Cargamos el item que contiene la info del mensaje
										$datos_mensaje = $this->config
												->item('ewarrant_error_firmado',
														'menu_permisos');
										//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
										if ($this->input->is_ajax_request()) {
											$resultados['error'] = true;
											$resultados['message'] = $datos_mensaje['texto'];
											$resultados['icono'] = $datos_mensaje['icono'];
				
											//Devolvemos los resultados en JSON
											echo json_encode($resultados);
											//Ya no tenemos nada que hacer en esta funcion
											return;
										} else {
											$this->template
													->set_content('ewarrants/sin_permiso',
															array(
																	'msg' => $datos_mensaje['texto']));
											$this->template->build();
										}
									}
								}
							}
				
							#Entramos aca cuando el usuario entra en la seccion
							#####################################################
							//Cargamos el archivo que contiene la info con la que se contruye el menu
							$this->config->load('menu_permisos', TRUE);
				
							//Obtenemos los permisos del usuario logueado asociados a la controladora seguridad y grupo gestionar_roles
							$data['permisos'] = $this->roles_frr
									->permisos_role_controladora_grupo($this->uri->segment(1));
				
							//Procesamos los permisos obtenidos
							if (count($data['permisos']) > 0) {
								foreach ($data['permisos'] as $key => $row) {
									$data['data_menu'][$row['permiso']] = $this->config
											->item($row['permiso'], 'menu_permisos');
								}
							}
				
							$this->template->set_content('ewarrants/listar_ewarrants', $data);
							$this->template->build();
						} else {
							$this->template
									->set_content('ewarrants/sin_permiso',
											array(
													'msg' => 'Tu empresa no tiene eWarrants emitidos'));
							$this->template->build();
						}
                 }
                 
                 function firma($ewid = null) {
                         $empresa_id = $this->auth_frr->get_empresa_id();
						 
                         if($this->auth_frr->es_admin())  {
                             $data['ewarrants'] = $this->ewarrants_frr->get_warrants_habilitados_sin_firmar();
                         }
                         else {
                            $data['ewarrants'] = $this->ewarrants_frr->get_warrants_empresa_habilitados_sin_firmar($empresa_id);
                         }
                         
                         if($data['ewarrants'] != null) {

                             if ($message = $this->session->flashdata('message')) {
                                    $data['message'] = $message;
                             }
							 
							 //Si entramos aca es porque se esta tratando de firmar un ewarrant
							 if($ewid) {
							 	if($this->uri->segment(3)) {
							 		//Cargamos el archivo que contiene la info con la que se contruye el menu
		                 	  		$this->config->load('menu_permisos', TRUE);
									
							 		//Chequeamos que el warrant no este firmado
                             		if(!$this->ewarrants_frr->esta_firmado($ewid)) {
                             			//Chequeamos que el usuario que esta tratando de firmar este habilitado para hacerlo
                                 		if($this->ewarrants_frr->can_firmar($ewid)) { 
									 		//Si entramos aca estamos confirmando la firma del ewarrant
									 		if($this->ewarrants_frr->confirmar_firma($ewid)) {
									 			//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
									 			
									 			//Cargamos el item que contiene la info del mensaje
			                                    $datos_mensaje = $this->config->item('ewarrant_confirmacion_firma', 'menu_permisos');
			                                    if($this->input->is_ajax_request()) {
			                                        $resultados['ewid'] = $ewid;
			                                        $resultados['message'] = $datos_mensaje['texto'];
													$resultados['icono'] = $datos_mensaje['icono'];
													
			                                        //Devolvemos los resultados en JSON
			                                        echo json_encode($resultados);
			                                        //Ya no tenemos nada que hacer en esta funcion
			                                        return;
			                                    } else { 
			                                        $message = $datos_mensaje['texto'];
					                             	$this->session->set_flashdata('message', $message);
					                             	redirect('ewarrants/');
												}
					                         }
					                     }
										 //No tiene los permisos suficientes para firmar el eWarrant
										 else {
										 		//Cargamos el item que contiene la info del mensaje
			                                    $datos_mensaje = $this->config->item('ewarrant_error_not_owner', 'menu_permisos');
												
										 		//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
			                                    if($this->input->is_ajax_request()) {
			                                    	
			                                    	$resultados['error'] = true;
			                                        $resultados['message'] = $datos_mensaje['texto'];
													$resultados['icono'] = $datos_mensaje['icono'];
													
			                                        //Devolvemos los resultados en JSON
			                                        echo json_encode($resultados);
			                                        //Ya no tenemos nada que hacer en esta funcion
			                                        return;
			                                    } else { 
													$this->template->set_content('ewarrants/sin_permiso', array('msg' => $datos_mensaje['texto']));
		                                     		$this->template->build();
												}
										 }
				                    }
									//El eWarrant ya esta firmado
									else {
											//Cargamos el item que contiene la info del mensaje
			                                $datos_mensaje = $this->config->item('ewarrant_error_firmado', 'menu_permisos');
											//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
		                                    if($this->input->is_ajax_request()) {
		                                        $resultados['error'] = true;
		                                        $resultados['message'] = $datos_mensaje['texto'];
												$resultados['icono'] = $datos_mensaje['icono'];
												
		                                        //Devolvemos los resultados en JSON
		                                        echo json_encode($resultados);
		                                        //Ya no tenemos nada que hacer en esta funcion
		                                        return;
		                                    } else { 
												$this->template->set_content('ewarrants/sin_permiso', array('msg' => $datos_mensaje['texto']));
		                                 		$this->template->build();
											}
									}
							 	}
							 }

							 #Entramos aca cuando el usuario entra en la seccion
							 #####################################################
							 //Cargamos el archivo que contiene la info con la que se contruye el menu
		                 	  $this->config->load('menu_permisos', TRUE);
							  
		                  	  //Obtenemos los permisos del usuario logueado asociados a la controladora seguridad y grupo gestionar_roles
		                  	  $data['permisos'] = $this->roles_frr->permisos_role_controladora_grupo($this->uri->segment(1));

							  //Procesamos los permisos obtenidos
							  if(count($data['permisos']) > 0) {
							  	foreach ($data['permisos'] as $key => $row) {
								  $data['data_menu'][$row['permiso']] = $this->config->item($row['permiso'], 'menu_permisos');
							  	}
							  }
							 
                             $this->template->set_content('ewarrants/listar_ewarrants', $data);
                             $this->template->build();
                         } else {
                             $this->template->set_content('ewarrants/sin_permiso', array('msg' => 'Tu empresa no tiene eWarrants emitidos'));
                             $this->template->build();
                         }
                 }

				 function anular($ewid = null) {
						 //Obtenemos el listado de eWarrants
                         if($this->auth_frr->es_admin()) {
                             $data['ewarrants'] = $this->ewarrants_frr->get_warrants_habilitados();
						 }
                         else {
                         	 $empresa_id = $this->auth_frr->get_empresa_id();
                             $data['ewarrants'] = $this->ewarrants_frr->get_warrants_empresa_habilitados($empresa_id);
                         }

						 //Controlamos si el usuario tiene eWarrants para ser anular
                         if($data['ewarrants'] != null) {
                         	  if ($message = $this->session->flashdata('message')) {
                                    $data['message'] = $message;
                              }
							  
							  //Si entramos aca es porque se esta tratando de firmar un ewarrant
							  if($ewid) {
							 	 if($this->uri->segment(3)) {
							 		//Cargamos el archivo que contiene la info con la que se contruye el menu
		                 	  		$this->config->load('menu_permisos', TRUE);
									
							 		//Chequeamos que el warrant no este anulado
		                             if(!$this->ewarrants_frr->esta_anulado($ewid)) {
		                                 //Chequeamos que el usuario que esta tratando de anular este habilitado para hacerlo
		                                 if($this->ewarrants_frr->can_anular($ewid)) {
		                                 	 //Si entramos aca estamos confirmando la anulacion del eWarrant
		                                 	 if($this->ewarrants_frr->confirmar_anulacion($ewid)) {
		                                 	 	 //Cargamos el item que contiene la info del mensaje
			                                     $datos_mensaje = $this->config->item('ewarrant_confirmacion_anulacion', 'menu_permisos');
												
		                                 	 	 //Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
			                                     if($this->input->is_ajax_request()) {
			                                     	$resultados['ewid'] = $ewid;
			                                        $resultados['message'] = $datos_mensaje['texto'];
													$resultados['icono'] = $datos_mensaje['icono'];
													
			                                        //Devolvemos los resultados en JSON
			                                        echo json_encode($resultados);
			                                        //Ya no tenemos nada que hacer en esta funcion
			                                        return;
			                                     } else {
			                                     	$message = $datos_mensaje['texto'];
					                                $this->session->set_flashdata('message', $message);
					                                redirect('ewarrants/'); 
												 }
				                                 
				                             }                         
		                                 }
										 //El usuario no puede anular el eWarrant y devolvemos un mensaje explicando la situacion
										 //El tipo de retorno del mensaje dependera si la peticion se hizo via Ajax o no 
		                                 else {
		                                 	 //Cargamos el item que contiene la info del mensaje
			                                 $datos_mensaje = $this->config->item('ewarrant_error_no_puede_firmar', 'menu_permisos');
											 
											 //Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
		                                     if($this->input->is_ajax_request()) {
		                                        $resultados['error'] = true;
		                                        $resultados['message'] = $datos_mensaje['texto'];
												$resultados['icono'] = $datos_mensaje['icono'];
												
		                                        //Devolvemos los resultados en JSON
		                                        echo json_encode($resultados);
		                                        //Ya no tenemos nada que hacer en esta funcion
		                                        return;
		                                     } else { 
			                                     $this->template->set_content('ewarrants/sin_permiso', array('msg' => $datos_mensaje['texto']));
			                                     $this->template->build();
											 }
		                                 }
		                             } 
		                             //El eWarrant ya esta anulado =(
		                             else {
		                             	 //Cargamos el item que contiene la info del mensaje
			                             $datos_mensaje = $this->config->item('ewarrant_error_ya_anulado', 'menu_permisos');
										 
		                             	 //Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
	                                     if($this->input->is_ajax_request()) {
	                                        $resultados['error'] = true;
	                                        $resultados['message'] = $datos_mensaje['texto'];
											$resultados['icono'] = $datos_mensaje['icono'];
											
	                                        //Devolvemos los resultados en JSON
	                                        echo json_encode($resultados);
	                                        //Ya no tenemos nada que hacer en esta funcion
	                                        return;
	                                     } else { 
			                                 $this->template->set_content('ewarrants/sin_permiso', array('msg' => $datos_mensaje['texto']));
			                                 $this->template->build();
										 }
		                             }
							 	 }
							  }

                              #Entramos aca cuando el usuario entra en la seccion
							  #####################################################
							  //Cargamos el archivo que contiene la info con la que se contruye el menu
		                 	  $this->config->load('menu_permisos', TRUE);
							  
		                  	  //Obtenemos los permisos del usuario logueado asociados a la controladora seguridad y grupo gestionar_roles
		                  	  $data['permisos'] = $this->roles_frr->permisos_role_controladora_grupo($this->uri->segment(1));

							  //Procesamos los permisos obtenidos
							  if(count($data['permisos']) > 0) {
							  	foreach ($data['permisos'] as $key => $row) {
								  $data['data_menu'][$row['permiso']] = $this->config->item($row['permiso'], 'menu_permisos');
							  	}
							  }
							  
                              $this->template->set_content('ewarrants/listar_ewarrants', $data);
                              $this->template->build();
                         }
						 //El usuario no tiene eWarrants para anular 
                         else {
                             $this->template->set_content('ewarrants/sin_permiso', array('msg' => 'Tu empresa no tiene eWarrants para anular'));
                             $this->template->build();
                         }
                 }
                 
                 function emitir() {
                 	 
				 	 $this->form_validation->set_rules('codigo', 'Codigo', 'trim|required|xss_clean');
                     $this->form_validation->set_rules('kilos', 'Kilos', 'trim|required|xss_clean');
                     $this->form_validation->set_rules('observaciones', 'Observaciones', 'trim|required|xss_clean');
                     
                     if( $this->uri->segment(3) ) {
                     	$this->form_validation->set_rules('estado', 'Estado', 'required|xss_clean');
                     	//En caso que sea una warrantera estos datos van a ser requeridos
                     	if( $es_warrantera = $this->auth_frr->has_role_warrantera()  ) {
	                     	$this->form_validation->set_rules('poliza_nombre', 'Nombre de poliza', 'trim|required|xss_clean');
	                     	$this->form_validation->set_rules('poliza_descripcion', 'Descripcion de poliza', 'trim|required|xss_clean');
	                     	$this->form_validation->set_rules('poliza_comision', 'Comision de pliza', 'trim|required|xss_clean');
                     	}
                     }
                     
                     if($this->auth_frr->es_admin()) {
                         $this->form_validation->set_rules('cuentaregistro_id', 'Cuentas de registro', 'required');
                     }

                     //Info del usuario/empresa
                     $user_id = $this->session->userdata('user_id');
                     //Clona el objeto empresa cargado con los datos de la empresa
                     //a la que pertenece el usuario logueado
                     $datosEmpresa =  $this->session->deserializar('empresa');
                     
                     $empresa_id = $datosEmpresa->getId();

                     if($this->form_validation->run()) {
                     	
                     	if( $this->uri->segment(3) ) {
                     			$resultado_operacion = false;
	                     		//Si entramos aca estamos confirmando la habilitacion del ewarrant
	                     		if( $es_warrantera ) {
	                     			$resultado_operacion = $this->ewarrants_frr->confirmar_operacion($this->uri->segment(3),
	                     					$this->input->post('aseguradora_id'),
	                     					$this->input->post('estado'),
	                     					$this->input->post('poliza_nombre'),
	                     					$this->input->post('poliza_descripcion'),
	                     					$this->input->post('poliza_comision')
	                     			);
	                     		} else {
	                     			$resultado_operacion = $this->ewarrants_frr->confirmar_operacion($this->uri->segment(3),
	                     					$this->input->post('aseguradora_id'),
	                     					$this->input->post('estado')
	                     			);
	                     		}
	                     		
	                     		if( $resultado_operacion ) {
	                     			//Si la peticionon se hizo por medio de ajax devolvemos el resultado via JSON
	                     			 
	                     			//Cargamos el item que contiene la info del mensaje
	                     			$datos_mensaje = $this->config
	                     			->item('ewarrant_confirmacion_firma',
	                     					'menu_permisos');
	                     			if ($this->input->is_ajax_request()) {
	                     				$resultados['ewid'] = $ewid;
	                     				$resultados['message'] = $datos_mensaje['texto'];
	                     				$resultados['icono'] = $datos_mensaje['icono'];
	                     				 
	                     				//Devolvemos los resultados en JSON
	                     				echo json_encode($resultados);
	                     				//Ya no tenemos nada que hacer en esta funcion
	                     				return;
	                     			} else {
	                     				$message = $datos_mensaje['texto'];
	                     				$this->session
	                     				->set_flashdata('message', $message);
	                     				redirect('ewarrants/');
	                     			}
	                     		} else {
	                     			//Se produjo un error y no se pudo actualizar
	                     			$message = "Ocurrio un error al tratar de actualizar el warrant";
	                     			$this->session->set_flashdata('errormsg', $message);
	                     			redirect('ewarrants/');
	                     		}
                     			
                     	}
                     	
                     	else {
                     		//Si el usuario que esta dando de alta es un admin
                     		//empresa_id puede variar porque los admins pueden
                     		//dar de alta warrants para cualquier empresa
                     		if($this->auth_frr->es_admin())
                     			$empresa_id = $this->input->post('empresa_id');
                     		 
                     		//Obtenemos el tipo del producto del form
                     		$producto_id = $this->input->post('producto');
                     		//Obtenemos el registro del producto
                     		$producto = $this->productos_model->get_producto_by_id($producto_id);
                     		//print_r($producto->calidad);
                     		// die();
                     		 
                     		$precio_ponderado = 0;
                     		if($producto) {
                     			$tipo = $producto->calidad;
                     			$info['kilos'] = $this->input->post('kilos');
                     			$info['precio'] = $producto->precio;
                     			$info['aforo'] =  $producto->aforo;
                     			 
                     			//Aplicamos Factory Method para crear instancias del tipo de producto
                     			//y obtener el precio_ponderada para el eWarrant
                     			$obj = new ProductosCreator();
                     			//Obtenemos la instancia del Producto
                     			$prod = new Producto();
                     			$prod = $this->productoscreator->factory($tipo, $info);
                     			$precio_ponderado = $prod->get_precio_ponderado();
                     		}//fin if producto != null
                     		 
                     		$data = array(
                     				'codigo' => $this->form_validation->set_value('codigo'),
                     				'cuentaregistro_depositante_id' => $this->input->post('cuentaregistro_id'),
                     				'cuentaregistro_id' => $this->input->post('cuentaregistro_id'),
                     				'producto' => $producto->nombre,
                     				'kilos' => $this->form_validation->set_value('kilos'),
                     				'observaciones' => $this->form_validation->set_value('observaciones'),
                     				'estado'        => 1,
                     				'emitido_por' => $user_id,
                     				'firmado'     => 0,
                     				'empresa_id'  => $empresa_id,
                     				'empresa_nombre'  => $datosEmpresa->getNombre(),
                     				'empresa_cuit' => $datosEmpresa->getCuit(),
                     				'precio_ponderado' => $precio_ponderado
                     		);
                     		if($this->ewarrants_frr->emitir($data)) {
                     			$message = "El eWarrant se ha emitido correctamente!";
                     			$this->session->set_flashdata('message', $message);
                     			redirect('ewarrants/');
                     		} else {
                     			$message = "No se pudo crear!";
                     			$this->session->set_flashdata('errormsg', $message);
                     			redirect('ewarrants/');
                     		}
                     	}
                         
                     }
                     
                     if( $this->uri->segment(3) ) {
                     	//Solamente hacemos algo acá en caso que se trate de una warrantera o una aseguradora
                     	if( $this->auth_frr->has_role_warrantera() || $this->auth_frr->has_role_aseguradora() ) {
	                     	$data['cuentasregistro'] = $this->auth_frr->get_cuentas_registro_depositante($empresa_id);
	                     	
	                     	$ew = $this->ewarrants_frr->get_warrant_by_id($this->uri->segment(3));
	                     	$data['aseguradoras'] = $this->empresas_frr->get_aseguradoras();
	                     	
	                     	$data['codigo_id'] = $ew->codigo;
	                     	$data['empresa_id'] = $ew->empresa_id;
	                     	$data['cuentaregistro_id'] = $ew->cuentaregistro_id;
	                     	$data['producto_id'] = $ew->producto;
	                     	$data['kilos_id'] = $ew->kilos;
	                     	$data['observaciones_id'] = $ew->observaciones;    
	                     	$data['estado'] = $ew->estado;
	                     	
	                     	$role_user = $this->roles_frr->role_usuario_logueado();
	                     	$data['tipo_empresa_id'] = $this->empresas_frr->get_tipo_empresa_usario_logueado();
	                     	
	                     	//Para el caso concreto de una aseguradora, tenemos que cargar los datos de la poliza
	                     	if( $this->auth_frr->has_role_aseguradora() ) {
	                     		$poliza = $this->ewarrants_frr->get_poliza_by_id($ew->poliza_id);
	                     		if( $poliza ) {
	                     			$data['poliza_id'] = $poliza[0]['poliza_id'];
	                     			$data['poliza_nombre'] = $poliza[0]['poliza_nombre'];
	                     			$data['poliza_descripcion'] = $poliza[0]['poliza_descripcion'];
	                     			$data['poliza_comision'] = $poliza[0]['poliza_comision'];
	                     		}
	                     	}
	                     	
                     	} else {
                     		$this->template->set_content('ewarrants/sin_permiso', array('msg' => 'No puedes acceder a esta seccion'));
                     		$this->template->build();
                     	}
                     }

                     $empresa = $this->empresas->get_empresa_by_id($empresa_id);
                     
                     //Cargamos las cuentas de registro asociadas a Argentina Clearing
                     $data['cuentasregistro'] = $this->auth_frr->get_cuentas_registro_depositante($empresa_id);
                     
                    /// print_r( $data['cuentasregistro']) ;
                     //die();
                     
                     if ($message = $this->session->flashdata('message')) {
                         $data['message'] = $message;

                     }
                     if($this->auth_frr->es_admin())
                        $data['empresas'] = $this->auth_frr->get_empresas();
                     $data['productos'] = $this->ewarrants_frr->get_productos();
                     $this->template->set_content('ewarrants/emitir', $data);
                     $this->template->build();
                 }
                 
                 function get_cuentas_registro($emp_id) {
                     $data['cuentasregistro'] = $this->auth_frr->get_cuentas_registro_depositante($emp_id);
                     //$this->template->set_content('ewarrants/cuentas_registro', $data);
                     //$this->template->build();
                     $this->load->view('ewarrants/cuentas_registro', $data);
                     
                 }
                 
                 
                 
                 function anulacion() {
                         $ewid = $this->input->post('ewid');
                         $data['id'] = $ewid;
                         
                         //Chequeamos que se haya pasado un id de eWarrant
                         if($ewid != null) {
                             //Chequeamos que el warrant no este anulado
                             if(!$this->ewarrants_frr->esta_anulado($ewid)) {
                                 //Chequeamos que el usuario que esta tratando de anular este habilitado para hacerlo
                                 if($this->ewarrants_frr->can_anular($ewid)) {                              
                                     $this->template->set_content('ewarrants/confirma_anulacion', $data);
                                     $this->template->build();
                                 } else {
                                     $this->template->set_content('ewarrants/sin_permiso', array('msg' => 'No puedes anular el eWarrant porque no fuiste tu quien lo dio de alta'));
                                     $this->template->build();
                                 }
                             } else {
                                 $this->template->set_content('ewarrants/sin_permiso', array('msg' => 'El eWarrant ya esta anulado!'));
                                 $this->template->build();
                             }
                         } else {
                             $this->template->set_content('ewarrants/sin_permiso', array('msg' => 'Debes seleccionar un eWarrant para poder anularlo!'));
                             $this->template->build();
                         }
                 }
                 
                 function confirma_anulacion() {
                     $ewid = $this->input->post('ewid');
                     
                     if($ewid != null) {
                         //Preguntamos si tiene permisos para anular
                         if($this->ewarrants_frr->can_anular($ewid)) {
                             if($this->ewarrants_frr->confirmar_anulacion($ewid)) {
                                 $message = "El eWarrant se ha anulado correctamente!";
                                 $this->session->set_flashdata('message', $message);
                                 redirect('ewarrants/');
                             }
                         } else {
                             $this->template->set_content('ewarrants/sin_permiso', array('msg' => 'No tienes permisos para anular este eWarrant, porque no fuiste el que lo emitio!'));
                             $this->template->build();
                         }
                     }
                 }
}