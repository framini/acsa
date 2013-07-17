<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Ewarrants_frr {
	
    private $error = array();

    public function __construct() {
        $this->ci = & get_instance();

        $this->ci->load->library('auth_frr');
        $this->ci->load->model('auth/users');
        $this->ci->load->model('auth/empresas');
        $this->ci->load->model('roles/roles_model');
        $this->ci->load->model('ewarrants/ewarrants_model');
        $this->ci->load->model('productos/productos_model');
        $this->ci->load->model('polizas/polizas_model');
    }

    /**
     * Se persisten en base el ewarrant
     * @param type $data
     * @return type 
     */
    function emitir($data) {
        if($this->ci->ewarrants_model->emitir($data))
            return true;
        else
            return false;
    }
    
    /**
     * Se confirma la firma de un eWarrant
     * @param type $ewid
     * @return type 
     */
    function confirmar_firma($ewid) {
        $ew = $this->ci->ewarrants_model->get_warrant_by_id($ewid);
        $data = array(
           'codigo' => $ew->codigo,
           'cuentaregistro_depositante_id' => $ew->cuentaregistro_depositante_id,
           'cuentaregistro_id' => $ew->cuentaregistro_id,
           'producto' => $ew->producto,
           'kilos' => $ew->kilos,
           'observaciones' => $ew->observaciones,
           'estado'        => $ew->estado,
           'emitido_por' => $ew->emitido_por,
           'firmado'     => 1,
           'usuario_ultima_accion' => $this -> ci -> auth_frr -> get_username()
        );
        if($this->ci->ewarrants_model->modificar($ewid, $data))
            return true;
        else
            return false;
    }
    
    /**
     * Se confirma la firma de un eWarrant
     * @param type $ewid
     * @return type
     */
    function confirmar_operacion($ewid, $aseguradora_id, $estado, $poliza_id = NULL) {
    	
    	$ew = $this->ci->ewarrants_model->get_warrant_by_id($ewid);
    	$data = array(
    			'codigo' => $ew->codigo,
    			'cuentaregistro_depositante_id' => $ew->cuentaregistro_depositante_id,
    			'cuentaregistro_id' => $ew->cuentaregistro_id,
    			'producto' => $ew->producto,
    			'kilos' => $ew->kilos,
    			'observaciones' => $ew->observaciones,
    			'estado'        => $estado,
    			'emitido_por' => $ew->emitido_por,
    			'firmado'     => 0
    	);
    	
    	if($aseguradora_id) {
    		$data['aseguradora_id'] = $aseguradora_id;
    	}
    	
    	if( isset($poliza_id) ) {
            $comision_aseguradora = $this->get_poliza_by_id($poliza_id);
    		$data['poliza_id'] = $poliza_id;
            $data['comision_aseguradora'] = $comision_aseguradora[0]['poliza_comision'];
    	}
    	
    	if($this->ci->ewarrants_model->modificar($ewid, $data)) {
            //En caso que la aseguradora acepte la poliza se realizan los movimientos economicos
            if( $this-> ci -> auth_frr -> has_role_aseguradora() && $estado == 5  ) {
                if( $this-> ci -> empresas_frr -> realizar_movimiento_cuenta_corriente(
                    $ew->empresa_id,
                    $ew->emitido_por,
                    $this->ci->auth_frr->get_empresa_id(),
                    $ew->precio_ponderado,
                    $ew->comision_warrantera,
                    $ew->comision_aseguradora
                )) {
                    return true;
                } else {
                    return false;
                }
            }

    		return true;
        }
    	else {
    		return false;
        }
    }
    
    function can_anular($ewid) {
        $user_id = $this->ci->auth_frr->get_user_id();
        $ew = $this->ci->ewarrants_model->get_warrant_by_id($ewid);
        if($this->ci->auth_frr->es_admin() || $ew->emitido_por == $user_id)
            return true;
        else
            return false;
    }
    
    function get_poliza_by_id($p_id = NULL) {
    	if($p_id) {
    		
    		$poliza = $this->ci->polizas_model->get_poliza_by_id($p_id);
    
    		if($poliza) {
    
    			$data[] = array(
    					'poliza_id'    						=> $poliza->poliza_id,
    					'poliza_nombre'       				=> $poliza->nombre,
    					'poliza_descripcion'       			=> $poliza->descripcion,
    					'poliza_comision'       			=> $poliza->comision
    			);
    		}
    
    		return $data;
    	}	
    }
    
    function confirmar_anulacion($ewid) {
        $ew = $this->ci->ewarrants_model->get_warrant_by_id($ewid);
        $data = array(
           'codigo' => $ew->codigo,
           'cuentaregistro_depositante_id' => $ew->cuentaregistro_depositante_id,
           'cuentaregistro_id' => $ew->cuentaregistro_id,
           'producto' => $ew->producto,
           'kilos' => $ew->kilos,
           'observaciones' => $ew->observaciones,
           'estado'        => 0,
           'emitido_por' => $ew->emitido_por,
           'firmado'     => $ew->firmado,
           'usuario_ultima_accion' => $this -> ci -> auth_frr -> get_username()
        );
        if($this->ci->ewarrants_model->modificar($ewid, $data))
            return true;
        else
            return false;
    }
    
    /**
     * Devuelve un booleando para determinar si el eWarrant esta firmado o no
     * @param type $ewid
     * @return type 
     */
    function esta_firmado($ewid) {
        $ew = $this->ci->ewarrants_model->get_warrant_by_id($ewid);
        if($ew->estado != 0) {
            if($ew->firmado == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * Devuelve un booleando para determinar si el eWarrant esta pendiente
     * @param type $ewid
     * @return type
     */
    function esta_pendiente($ewid) {
    	$ew = $this->ci->ewarrants_model->get_warrant_by_id($ewid);
    	if($ew->estado == 1) {
    		
    		return true;
    	} else {
    		
    		return false;
    	}
    }
    
    function esta_habilitado($ewid) {
    	$ew = $this->ci->ewarrants_model->get_warrant_by_id($ewid);
    	if($ew->estado == 2) {
    
    		return true;
    	} else {
    
    		return false;
    	}
    }
    
    /**
     * Devuelve un booleando para determinar si el eWarrant esta firmado o no
     * @param type $ewid
     * @return type 
     */
    function esta_anulado($ewid) {
        $ew = $this->ci->ewarrants_model->get_warrant_by_id($ewid);
        if($ew->estado == 0) {
            return true;
        } else {
            return false;
        }
    }


    function get_warrants() {
        $ew = $this -> ci -> ewarrants_model -> get_warrants();
        if ($ew != NULL) {
            foreach ($ew->result() as $row) {
                $crd = $this -> get_cuenta_registro_by_id($row -> cuentaregistro_depositante_id);

                $cr_nombre_dep = $crd -> nombre;
                $cr = $this -> get_cuenta_registro_by_id($row -> cuentaregistro_id);
                $cr_nombre = $cr -> nombre;
                
                $data[] = array(
                    'id' => $row -> id, 
                    'codigo' => $row -> codigo, 
                    'cuentaregistro_depositante_id' => $row -> cuentaregistro_depositante_id, 
                    'cuentaregistro_id' => $row -> cuentaregistro_id, 
                    'nombre_cuenta_registro_depositante' => $cr_nombre_dep, 
                    'nombre_cuenta_registro' => $cr_nombre, 
                    'producto' => $row -> producto, 
                    'kilos' => $row -> kilos, 
                    'observaciones' => $row -> observaciones, 
                    'created' => $row -> created, 
                    'estado' => $row -> estado, 
                    'emitido_por' => $this->ci->auth_frr->get_username_by_id($row -> emitido_por), 
                    'firmado' => $row -> firmado
                );

            }

            return $data;
        } else {
            return NULL;
        }
    }

    function control_stock_warrants() {
        $query = "SELECT * FROM ewarrant WHERE vencimiento < DATE_SUB(NOW(), INTERVAL 30 DAY)";

        $ewarrants_por_vencer = $this->ci->db->query($query);
        
        if( count( $ewarrants_por_vencer->result_array() ) > 0 ) {

            foreach ($ewarrants_por_vencer->result_array() as $key => $value) {
                $user_id = $value['emitido_por'];
                $emp_id = $value['empresa_id'];

                if( !$this->ci->session->userdata('chequeo_stock') ) {
                    $this->_send_email("", "framini@gmail.com");
                }
                
            }

            $newdata = array(
                   'chequeo_stock' => TRUE
            );
            $this->ci->session->set_userdata($newdata);
        }
    }

    function _send_email($type, $email) {
        $this ->ci -> load -> library('email');

        $this ->ci -> email -> initialize(array('protocol' => 'smtp', 'smtp_host' => 'smtp.sendgrid.net', 'mailtype' => 'html', 'smtp_user' => 'framini', 'smtp_pass' => 'montfran', 'bcc_batch_mode' => true, 'bcc_batch_size' => 3, 'smtp_port' => 587, 'crlf' => "\r\n", 'newline' => "\r\n"));
        $this ->ci -> email -> from($this-> ci -> config -> item('webmaster_email', 'auth_frr'), $this -> ci -> config -> item('webmaster_email', 'auth_frr'));
        $this ->ci -> email -> reply_to($this -> ci -> config -> item('webmaster_email', 'auth_frr'), $this -> ci -> config -> item('webmaster_email', 'auth_frr'));
        $this ->ci -> email -> to($email);
        //$this ->ci -> email -> subject(sprintf($this -> lang -> line('auth_subject_' . $type), $this -> config -> item('website_name', 'auth_frr')));
        $this ->ci -> email -> subject("El warrant esta por vencer");
        $this ->ci -> email -> message("Tiene warrants que estan por vencer");
        $this ->ci -> email -> send();
    }
    
    /**
     * Devuelve todos los eWarrants emitidos por una determinada empresa
     * @param type $empresa_id
     * @return type 
     */
    	function get_warrants_habilitados() {
		$ew = $this -> ci -> ewarrants_model -> get_warrants_habilitados();
		if ($ew != NULL) {
			foreach ($ew->result() as $row) {
				$crd = $this -> get_cuenta_registro_by_id($row -> cuentaregistro_depositante_id);

				$cr_nombre_dep = $crd -> nombre;
				$cr = $this -> get_cuenta_registro_by_id($row -> cuentaregistro_id);
				$cr_nombre = $cr -> nombre;
				
				$data[] = array(
					'id' => $row -> id, 
					'codigo' => $row -> codigo, 
					'cuentaregistro_depositante_id' => $row -> cuentaregistro_depositante_id, 
					'cuentaregistro_id' => $row -> cuentaregistro_id, 
					'nombre_cuenta_registro_depositante' => $cr_nombre_dep, 
					'nombre_cuenta_registro' => $cr_nombre, 
					'producto' => $row -> producto, 
					'kilos' => $row -> kilos, 
					'observaciones' => $row -> observaciones, 
					'created' => $row -> created, 
					'estado' => $row -> estado, 
					'emitido_por' => $row -> emitido_por, 
					'firmado' => $row -> firmado
				);

			}

			return $data;
		} else {
			return NULL;
		}
	}

    
    /**
     * Devuelve todos los eWarrants emitidos por una determinada empresa
     * @param type $empresa_id
     * @return type
     */
    function get_warrants_habilitados_pendientes() {
    	$ew = $this->ci->ewarrants_model->get_warrants_habilitados();
    	if($ew != NULL) {
    		foreach ($ew->result() as $row)
    		{
    			$crd = $this->get_cuenta_registro_by_id($row->cuentaregistro_depositante_id);
    			$cr_nombre_dep = $crd->nombre;
    			$cr = $this->get_cuenta_registro_by_id($row->cuentaregistro_id);
    			$cr_nombre = $cr->nombre;
    			$username = $this->ci->auth_frr->get_username_by_id($row->emitido_por);
    			$data[] = array(
    					'id'       => $row->id,
    					'codigo'       => $row->codigo,
    					'cuentaregistro_depositante_id' => $row->cuentaregistro_depositante_id,
    					'cuentaregistro_id'        => $row->cuentaregistro_id,
    					'nombre_cuenta_registro_depositante'   => $cr_nombre_dep,
    					'nombre_cuenta_registro'   => $cr_nombre,
    					'producto'     => $row->producto,
    					'kilos'        => $row->kilos,
    					'observaciones' => $row->observaciones,
    					'created' => $row->created,
    					'estado'  => $row->estado,
    					'emitido_por' => $username,
    					'firmado'     => $row->firmado
    			);
    
    		}
    
    		return $data;
    	}  else {
    		return NULL;
    	}
    }
    
    /**
     * Devuelve todos los eWarrants pendientes por confirmar
     * @param type $empresa_id
     * @return type
     */
    function get_warrants_por_confirmar($empresa_id, $estado) {
    	
    	$ew = $this->ci->ewarrants_model->get_warrants_empresa_pendientes($empresa_id, $estado);
    	
        if($ew != NULL) {
            foreach ($ew->result() as $row)
            {
               $crd = $this->get_cuenta_registro_by_id($row->cuentaregistro_depositante_id);
               $cr_nombre_dep = $crd->nombre;
               $cr = $this->get_cuenta_registro_by_id($row->cuentaregistro_id);
               $cr_nombre = $cr->nombre;
               $username = $this->ci->auth_frr->get_username_by_id($row->emitido_por);
               $data[] = array(
                                'id'       => $row->id,
                                'codigo'       => $row->codigo,
                                'cuentaregistro_depositante_id' => $row->cuentaregistro_depositante_id,
                                'cuentaregistro_id'        => $row->cuentaregistro_id,
                                'nombre_cuenta_registro_depositante'   => $cr_nombre_dep,
                                'nombre_cuenta_registro'   => $cr_nombre,
                                'producto'     => $row->producto,
                                'kilos'        => $row->kilos,
                                'observaciones' => $row->observaciones,
                                'created' => $row->created,
                                'estado'  => $row->estado,
                                'emitido_por' => $username,
                                'firmado'     => $row->firmado,
                                'empresa_nombre' => $row->empresa_nombre,
                                'empresa_cuit' => $row->empresa_cuit,
                                'valor_ponderado' => $row->precio_ponderado
               );

            }
            
            return $data;
        }  else {
            return NULL;
        }
    }
    
    /**
     * Devuelve todos los eWarrants emitidos por una determinada empresa con estado pendiente
     * @param type $empresa_id
     * @return type
     */
	function get_warrants_empresa_pendientes($empresa_id, $estado = NULL ) {
        $ew = $this->ci->ewarrants_model->get_warrants_empresa_pendientes($empresa_id, $estado);
        if($ew != NULL) {
            foreach ($ew->result() as $row)
            {
               $crd = $this->get_cuenta_registro_by_id($row->cuentaregistro_depositante_id);
               $cr_nombre_dep = $crd->nombre;
               $cr = $this->get_cuenta_registro_by_id($row->cuentaregistro_id);
               $cr_nombre = $cr->nombre;
               $username = $this->ci->auth_frr->get_username_by_id($row->emitido_por);
               $data[] = array(
                                'id'       => $row->id,
                                'codigo'       => $row->codigo,
                                'cuentaregistro_depositante_id' => $row->cuentaregistro_depositante_id,
                                'cuentaregistro_id'        => $row->cuentaregistro_id,
                                'nombre_cuenta_registro_depositante'   => $cr_nombre_dep,
                                'nombre_cuenta_registro'   => $cr_nombre,
                                'producto'     => $row->producto,
                                'kilos'        => $row->kilos,
                                'observaciones' => $row->observaciones,
                                'created' => $row->created,
                                'estado'  => $row->estado,
                                'emitido_por' => $username,
                                'firmado'     => $row->firmado,
                                'empresa_nombre' => $row->empresa_nombre,
                                'empresa_cuit' => $row->empresa_cuit,
                                'valor_ponderado' => $row->precio_ponderado
               );

            }
            
            return $data;
        }  else {
            return NULL;
        }
    }
    
    function get_warrants_empresa_pendientes_aseguradora($empresa_id, $estado = NULL ) {
    	$ew = $this->ci->ewarrants_model->get_warrants_empresa_pendientes_aseguradora($empresa_id, $estado);
    	if($ew != NULL) {
    		foreach ($ew->result() as $row)
    		{
    			$crd = $this->get_cuenta_registro_by_id($row->cuentaregistro_depositante_id);
    			$cr_nombre_dep = $crd->nombre;
    			$cr = $this->get_cuenta_registro_by_id($row->cuentaregistro_id);
    			$cr_nombre = $cr->nombre;
    			$username = $this->ci->auth_frr->get_username_by_id($row->emitido_por);
    			$data[] = array(
    					'id'       => $row->id,
    					'codigo'       => $row->codigo,
    					'cuentaregistro_depositante_id' => $row->cuentaregistro_depositante_id,
    					'cuentaregistro_id'        => $row->cuentaregistro_id,
    					'nombre_cuenta_registro_depositante'   => $cr_nombre_dep,
    					'nombre_cuenta_registro'   => $cr_nombre,
    					'producto'     => $row->producto,
    					'kilos'        => $row->kilos,
    					'observaciones' => $row->observaciones,
    					'created' => $row->created,
    					'estado'  => $row->estado,
    					'emitido_por' => $username,
    					'firmado'     => $row->firmado,
    					'empresa_nombre' => $row->empresa_nombre,
    					'empresa_cuit' => $row->empresa_cuit,
    					'valor_ponderado' => $row->precio_ponderado
    			);
    
    		}
    
    		return $data;
    	}  else {
    		return NULL;
    	}
    }
    
     function get_warrants_habilitados_sin_firmar() {
        $ew = $this->ci->ewarrants_model->get_warrants_habilitados_sin_firmar();
        if($ew != NULL) {
            foreach ($ew->result() as $row)
            {
               $crd = $this->get_cuenta_registro_by_id($row->cuentaregistro_depositante_id);
               $cr_nombre_dep = $crd->nombre;
               $cr = $this->get_cuenta_registro_by_id($row->cuentaregistro_id);
               $cr_nombre = $cr->nombre;
               $username = $this->ci->auth_frr->get_username_by_id($row->emitido_por);
               $data[] = array(
                                'id'       => $row->id,
                                'codigo'       => $row->codigo,
                                'cuentaregistro_depositante_id' => $row->cuentaregistro_depositante_id,
                                'cuentaregistro_id'        => $row->cuentaregistro_id,
                                'nombre_cuenta_registro_depositante'   => $cr_nombre_dep,
                                'nombre_cuenta_registro'   => $cr_nombre,
                                'producto'     => $row->producto,
                                'kilos'        => $row->kilos,
                                'observaciones' => $row->observaciones,
                                'created' => $row->created,
                                'estado'  => $row->estado,
                                'emitido_por' => $row -> emitido_por,
                                'firmado'     => $row->firmado
               );

            }
            
            return $data;
        }  else {
            return NULL;
        }
    }
    
    function get_warrants_empresa_habilitados($empresa_id) {
        $ew = $this->ci->ewarrants_model->get_warrants_empresa_habilitados($empresa_id);
        if($ew != NULL) {
            foreach ($ew->result() as $row)
            {
               $crd = $this->get_cuenta_registro_by_id($row->cuentaregistro_depositante_id);
               $cr_nombre_dep = $crd->nombre;
               $cr = $this->get_cuenta_registro_by_id($row->cuentaregistro_id);
               $cr_nombre = $cr->nombre;
               $username = $this->ci->auth_frr->get_username_by_id($row->emitido_por);
               $data[] = array(
                                'id'       => $row->id,
                                'codigo'       => $row->codigo,
                                'cuentaregistro_depositante_id' => $row->cuentaregistro_depositante_id,
                                'cuentaregistro_id'        => $row->cuentaregistro_id,
                                'nombre_cuenta_registro_depositante'   => $cr_nombre_dep,
                                'nombre_cuenta_registro'   => $cr_nombre,
                                'producto'     => $row->producto,
                                'kilos'        => $row->kilos,
                                'observaciones' => $row->observaciones,
                                'created' => $row->created,
                                'estado'  => $row->estado,
                                'emitido_por' => $row->emitido_por,
                                'firmado'     => $row->firmado,
                                'empresa_nombre' => $row->empresa_nombre,
                                'empresa_cuit' => $row->empresa_cuit,
                                'valor_ponderado' => $row->precio_ponderado
               );

            }
            
            return $data;
        }  else {
            return NULL;
        }
    }
    
    function get_warrants_empresa_habilitados_sin_firmar($empresa_id) {
        $ew = $this->ci->ewarrants_model->get_warrants_empresa_habilitados_sin_firmar($empresa_id);
        if($ew != NULL) {
            foreach ($ew->result() as $row)
            {
               $crd = $this->get_cuenta_registro_by_id($row->cuentaregistro_depositante_id);
               $cr_nombre_dep = $crd->nombre;
               $cr = $this->get_cuenta_registro_by_id($row->cuentaregistro_id);
               $cr_nombre = $cr->nombre;

               $username = $this->ci->auth_frr->get_username_by_id($row->emitido_por);
			   
               $data[] = array(
                                'id'       => $row->id,
                                'codigo'       => $row->codigo,
                                'cuentaregistro_depositante_id' => $row->cuentaregistro_depositante_id,
                                'cuentaregistro_id'        => $row->cuentaregistro_id,
                                'nombre_cuenta_registro_depositante'   => $cr_nombre_dep,
                                'nombre_cuenta_registro'   => $cr_nombre,
                                'producto'     => $row->producto,
                                'kilos'        => $row->kilos,
                                'observaciones' => $row->observaciones,
                                'created' => $row->created,
                                'estado'  => $row->estado,
                                'emitido_por' => $row->emitido_por,
                                'firmado'     => $row->firmado,
                                'empresa_nombre' => $row->empresa_nombre,
                                'empresa_cuit' => $row->empresa_cuit,
                                'valor_ponderado' => $row->precio_ponderado
               );

            }
            
            return $data;
        }  else {
            return NULL;
        }
    }
    
    /**
     * Devuelve todos los eWarrants emitidos por una determinada empresa
     * @param type $empresa_id
     * @return type 
     */
    function get_warrants_empresa($empresa_id) {
        $ew = $this->ci->ewarrants_model->get_warrants_empresa($empresa_id);
        if($ew != NULL) {
            foreach ($ew->result() as $row)
            {
               $crd = $this->get_cuenta_registro_by_id($row->cuentaregistro_depositante_id);
               $cr_nombre_dep = $crd->nombre;
               $cr = $this->get_cuenta_registro_by_id($row->cuentaregistro_id);
               $cr_nombre = $cr->nombre;
               $username = $this->ci->auth_frr->get_username_by_id($row->emitido_por);
               $data[] = array(
                                'id'       => $row->id,
                                'codigo'       => $row->codigo,
                                'cuentaregistro_depositante_id' => $row->cuentaregistro_depositante_id,
                                'cuentaregistro_id'        => $row->cuentaregistro_id,
                                'nombre_cuenta_registro_depositante'   => $cr_nombre_dep,
                                'nombre_cuenta_registro'   => $cr_nombre,
                                'producto'     => $row->producto,
                                'kilos'        => $row->kilos,
                                'observaciones' => $row->observaciones,
                                'created' => $row->created,
                                'estado'  => $row->estado,
                                'emitido_por' => $row->emitido_por,
                                'firmado'     => $row->firmado,
                                'empresa_nombre' => $row->empresa_nombre,
                                'empresa_cuit' => $row->empresa_cuit,
                                'valor_ponderado' => $row->precio_ponderado
               );

            }
            
            return $data;
        }  else {
            return NULL;
        }
    }
    
    /**
     * Devuelve una cuenta de registro en base a su ID
     * @param type $crid
     * @return type 
     */
    function get_cuenta_registro_by_id($crid) {
        $cr = $this->ci->ewarrants_model->get_cuenta_registro_by_id($crid);
        
        return $cr;
    }
    
    function can_firmar($ew_id) {
        $ewarrant = $this->ci->ewarrants_model->get_warrant_by_id($ew_id);
        $user_id = $this->ci->auth_frr->get_user_id();
        //Como el usuario que dio de alta el ewarrant no puede firmarlo
        //comprobamos que quien lo este tratando de firmar no sea el mismo usuario
        //que lo dio de alta
        if($ewarrant) {
            if($ewarrant->emitido_por == $user_id)
                return false;
            else
                return true;
        } else {
            return false;
        }
    }
    
    function get_warrant_by_id($ewid) {
    	return $this->ci->ewarrants_model->get_warrant_by_id($ewid);
    }
    
    /**
     * Devuelve un booleando que indica si el usuario que esta tratando de habilitar tiene los permisos suficientes
     * @param unknown_type $ew_id
     * @return boolean
     */
    function can_habilitar($ew_id, $aseg_id = NULL) {
    	
		
    	if( $this->ci->auth_frr->has_role_warrantera() ) {
    		$ewarrant = $this->ci->ewarrants_model->get_warrant_by_id($ew_id);
    		$user_id = $this->ci->auth_frr->get_user_id();
    		
    		if($ewarrant) {
    			return TRUE;
    		} else {
    			return false;
    		}
    		
    	} elseif( $this->ci->auth_frr->has_role_aseguradora() ) {
    		return TRUE;
    	} 
    	else {
    		return FALSE;
    	}
    
    }
    
    function get_producto_by_id($producto_id) {
        if(!is_null($producto = $this->productos_model->get_producto_by_id($producto_id))) {
                return $producto;
        } else {
            return NULL;
        }
    }
    function get_productos() {
        $productos = $this->ci->productos_model->get_productos();
        if(!is_null($productos)) {
              foreach ($productos->result() as $row){
                  
                   $data[] = array(
                                    'producto_id'    => $row->producto_id,
                                    'nombre'          => $row->nombre,
                                    'precio'            => $row->precio,
                                    'calidad'          => $row->calidad,
                                    'aforo'             => $row->aforo
                           );
              }

              return $data;
        } else 
            return false;
    }

    function get_polizas_by_empresa($emp_id) {
        $polizas = $this->ci->ewarrants_model->get_polizas_by_empresa($emp_id);
        if(!is_null($polizas)) {
              foreach ($polizas->result() as $row){
                  
                   $data[] = array(
                                    'poliza_id'         => $row->poliza_id,
                                    'nombre'            => $row->nombre,
                                    'comision'          => $row->comision,
                                    'empresa_id'        => $row->empresa_id,
                                    'descripcion'       => $row->descripcion,
                                    'created'           => $row->created
                           );
              }

              return $data;
        } else 
            return false;
    }

    function create_poliza($data) {
        if (!is_null($res = $this -> ci -> ewarrants_model -> create_poliza($data))) {
            $data['poliza_id'] = $res['poliza_id'];
            return $data;
        }

        return NULL;
    }

    function modificar_poliza($poliza_id, $data) {
        if ($this -> ci -> ewarrants_model -> modificar_poliza($poliza_id, $data)) {
            return true;
        } else {
            return NULL;
        }
    }

}

