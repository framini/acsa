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
           'firmado'     => 1
        );
        if($this->ci->ewarrants_model->modificar($ewid, $data))
            return true;
        else
            return false;
    }
    
    function can_anular($ewid) {
        $user_id = $this->ci->auth_frr->get_user_id();
        $ew = $this->ci->ewarrants_model->get_warrant_by_id($ewid);
        if($this->ci->auth_frr->es_admin() || $ew->emitido_por == $user_id)
            return true;
        else
            return false;
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
           'firmado'     => $ew->firmado
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
    
    /**
     * Devuelve todos los eWarrants emitidos por una determinada empresa
     * @param type $empresa_id
     * @return type 
     */
    function get_warrants_habilitados() {
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
                                'emitido_por' => $username,
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
}
