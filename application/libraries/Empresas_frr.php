<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empresas_frr {
    
    private $error = array();

    public function __construct() {
        $this->ci = & get_instance();

        $this->ci->load->model('auth/users');
        $this->ci->load->model('auth/empresas');
        $this->ci->load->model('roles/roles_model');
        $this->ci->load->model('ewarrants/ewarrants_model');
        $this->ci->load->model('productos/productos_model');
    }
	
	/**
	 * Chequea que la empresa este disponible para el registro.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_nombre_empresa_available($nombre, $tabla = NULL) {
		return ((strlen($nombre) > 0) AND $this->ci->empresas->is_nombre_empresa_available($nombre, $tabla));
	}
	
	/**
	 * Chequea que la empresa este disponible para el registro.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_cuit_empresa_available($cuit) {
		return ((strlen($cuit) > 0) AND $this->ci->empresas->is_cuit_empresa_available($cuit));
	}
	
	/**
	 * Crea una nueva empresa en el sistema
	 */
	function create_cuenta_registro($nombre, $codigo, $tipo_cuentaregistro_id, $empresa_id) {
		if( $this->is_nombre_empresa_available($nombre, "cuentas_registro") ) {
			$data = array('nombre' => $nombre, 'codigo' => $codigo, 'tipo_cuentaregistro_id' => $tipo_cuentaregistro_id, 'empresa_id' => $empresa_id);
			if (!is_null($res = $this->ci->empresas->create_cuenta_registro($data))) {
				$data['cuentaregistro_id'] = $res['cuentaregistro_id'];
				return $data;
			}
		} else {
			$this->error['nombre'] = 'nombre_empresa_en_uso';
		}
		
		return NULL;
	}
	
	/**
	 * Crea una nueva empresa en el sistema
	 */
	function create_empresa($nombre, $cuit, $tipo_empresa_id) {
		if($this->is_nombre_empresa_available($nombre)) {
			$data = array('nombre' => $nombre, 'cuit' => $cuit, 'tipo_empresa_id' => $tipo_empresa_id);
			if (!is_null($res = $this->ci->empresas->create_empresa($data))) {
				$data['empresa_id'] = $res['empresa_id'];
				return $data;
			}
		} else {
			$this->error['nombre'] = 'nombre_empresa_en_uso';
		}
		
		return NULL;
	}
	
	/**
	 * Modifica una empresa del sistema
	 */
	function modificar_empresa($nombre, $cuit, $tipo_empresa_id, $empresa_id) {
			//Separamos esta validacion para poder tener control sobre el mensaje de error a mostrar
			$verif_nombre = $this->verificacion_nombre_empresa($nombre, $empresa_id);
			$verif_cuit = $this->verificacion_cuit_empresa($cuit, $empresa_id);
			if($verif_nombre && $verif_cuit) {
				$data['nombre'] = $nombre;
				$data['cuit'] = $cuit;
				$data['tipo_empresa_id'] = $tipo_empresa_id;
				
				return $this->editar_empresa($empresa_id, $data);
			} else {
				return NULL;
			}
	}
	
	/**
	 * Modifica una empresa del sistema
	 */
	function modificar_cuenta_registro($nombre, $codigo, $tipo_cuentaregistro_id, $empresa_id, $cuenta_registro_id) {
			//Separamos esta validacion para poder tener control sobre el mensaje de error a mostrar
			$verif_nombre = $this->verificacion_nombre_empresa($nombre , $cuenta_registro_id);

			if($verif_nombre) {
				$data['nombre'] = $nombre;
				$data['codigo'] = $codigo;
				$data['tipo_cuentaregistro_id'] = $tipo_cuentaregistro_id;
				$data['empresa_id'] = $empresa_id;
				
				return $this->editar_empresa($cuenta_registro_id, $data, 'cuentas_registro');
			} else {
				return NULL;
			}
	}
	
	function verificacion_nombre_empresa($nombre, $empresa_id, $tabla = NULL) {
		//Si el nombre esta disponible entramos
		//O sino chequeamos que se esten editando otros datos de una empresa que no sea su nombre
		if($this->is_nombre_empresa_available($nombre, $tabla) || $this->is_misma_empresa($nombre, $empresa_id, $tabla)) {
			return true;
		} else {
			$this->error['nombre'] = 'El nombre igresado ya está en uso';
			return NULL;
		}
	}
	
	function verificacion_cuit_empresa($cuit, $empresa_id) {
		//Primero verificamos si el cuit ingresado ya existe en la BD
		//Sino nos fijamos que esten editando otro datos de la misma empresa
		if($this->is_cuit_empresa_available($cuit) || $this->is_mismo_cuit($cuit, $empresa_id)) {
			return true;
		} else {
			$this->error['cuit'] = 'El cuit ingresado ya está en uso';
			return NULL;
		}
	}
	
	/**
	 * Funcion usada para verificacion a la hora de modificar una empresa
	 * Sirve para validar que se este modificando datos en la empresa correcta
	 * Chequea que en caso de que el nombre de empresa ya este en el sistema se lo compare
	 * con el nombre de la empresa con el ID de empresa a editar. En caso de ser el mismo
	 * es valido realizar la modificacion de datos
	 */
	function is_misma_empresa($nombre_empresa, $empresa_id, $tabla = NULL) {
		if( !is_null($tabla) ) {
			$emp_db = $this->get_cuenta_registro_by_id($empresa_id);
			if($emp_db[0]['nombre'] == $nombre_empresa) {
				return true;
			} else {
				return false;
			}
		} else {
			$emp_db = $this->get_empresa_by_id($empresa_id);
			if($emp_db[0]['nombre'] == $nombre_empresa) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	/**
	 * Funcion usada para verificacion a la hora de modificar una empresa
	 * Sirve para validar que se este modificando datos en la empresa correcta
	 * Chequea que en caso de que el cuit ya este en el sistema se lo compare
	 * con el cuit de la empresa con el ID de empresa a editar. En caso de ser el mismo
	 * es valido realizar la modificacion de datos
	 */
	function is_mismo_cuit($cuit, $empresa_id) {
		$emp_db = $this->get_empresa_by_id($empresa_id);
		if($emp_db[0]['cuit'] == $cuit) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
     * Permite la modificacion de una determinada Empresa
     * @param type $empresa_id
     * @param type $data
     * @return type 
     */
    function editar_empresa($empresa_id, $data, $tabla = NULL)
    {
             if($this->ci->empresas->modificar_empresa($empresa_id, $data, $tabla)) {
             	return true;
             }              
             else {
             	return NULL;
             }
    }
	
	/**
	 * Eliminar una empresa del sistema
	 */
	function eliminar_empresa($empresa_id)
    {
            if($this->ci->empresas->eliminar_empresa($empresa_id))
                return true;
             else
                 return false;
    }
	
	function eliminar_cuenta_registro($empresa_id)
    {
            if($this->ci->empresas->eliminar_cuenta_registro($empresa_id))
                return true;
             else
                 return false;
    }
	
	/**
	 * Eliminar una empresa del sistema
	 */
	function activar_empresa($empresa_id)
    {
            if($this->ci->empresas->activar_empresa($empresa_id))
                return true;
             else
                 return false;
    }
	
	function activar_cuenta_registro($empresa_id)
    {
            if($this->ci->empresas->activar_cuenta_registro($empresa_id))
                return true;
             else
                 return false;
    }
	
	/**
	 * Devuelve los tipos de cuenta de registro
	 */
	function get_cuentas_registro() {
		$cuentas_registro = $this->ci->empresas->get_cuentas_registro_all();

        foreach ($cuentas_registro->result() as $row)
        {
           $data[] = array(
                            'cuentaregistro_id'    		=> $row->cuentaregistro_id,
                            'nombre'       				=> $row->nombre,
                            'codigo'        			=> $row->codigo,
                            'empresa_id'        		=> $row->empresa_id,
                            'tipo_cuentaregistro_id'    => $row->tipo_cuentaregistro_id,
                            'tipo_cuentaregistro'       => $this->get_name_tipo_cuenta_registro_by_id( $row->tipo_cuentaregistro_id ),
                            'activated'        			=> $row->activated,
                            'empresa'                   => $this->get_empresa_name_by_id( $row->empresa_id )
                   );
        }

        return $data;
	}
	
	/**
	 * Devuelve los tipos de cuenta de registro
	 */
	function get_tipos_cuentas_registro() {
		$tipos_cuenta_registro = $this->ci->empresas->get_tipos_cuentas_registro();

        foreach ($tipos_cuenta_registro->result() as $row)
        {
           $data[] = array(
                            'tipo_cuentaregistro_id'    => $row->tipo_cuentaregistro_id,
                            'descripcion'       		=> $row->descripcion,
                            'es_depositante'        	=> $row->es_depositante
                   );
        }

        return $data;
	}
	
	/**
	 * Devuelve los tipos de empresas
	 */
	function get_tipos_empresas() {
		$tipos_empresas = $this->ci->empresas->get_tipos_empresas();

        foreach ($tipos_empresas->result() as $row)
        {
           $data[] = array(
                            'tipo_empresa_id'    => $row->tipo_empresa_id,
                            'tipo_empresa'       => $row->tipo_empresa,
                            'descripcion'        => $row->descripcion
                   );
        }

        return $data;
	}
	
	function get_name_tipo_cuenta_registro_by_id($tipo_id = NULL) {
		if($tipo_id) {
			//Obtenemos la empresa en base al id enviado como parametro
			$tipo = $this->ci->empresas->get_tipo_cuenta_registro_by_id( $tipo_id );

			if($tipo) {
		         return $tipo->descripcion;
			} else {
				return NULL;
			}
		}
			
	}
	
	function get_empresa_by_id($emp_id = NULL) {
		if($emp_id) {
			//Obtenemos la empresa en base al id enviado como parametro
			$empresa = $this->ci->empresas->get_empresa_by_id($emp_id);

			if($empresa) {

		           $data[] = array(
		                            'tipo_empresa_id'    => $empresa->tipo_empresa_id,
		                            'nombre'       => $empresa->nombre,
		                            'cuit'        => $empresa->cuit,
		                            'fecha_alta'  => $empresa->fecha_alta,
		                            'empresa_id'  => $empresa->empresa_id,
		                            'activated'   => $empresa->activated
		                   );
			}
	
	        return $data;
		}
			
	}
	
	
	function get_cuenta_registro_by_id($emp_id = NULL) {
		if($emp_id) {
			//Obtenemos la empresa en base al id enviado como parametro
			$empresa = $this->ci->empresas->get_cuenta_registro_by_id($emp_id);

			if($empresa) {

		           $data[] = array(
		                            'cuentaregistro_id'    => $empresa->cuentaregistro_id,
		                            'nombre'       => $empresa->nombre,
		                            'codigo'        => $empresa->codigo,
		                            'empresa_id'  => $empresa->empresa_id,
		                            'tipo_cuentaregistro_id'   => $empresa->tipo_cuentaregistro_id,
		                            'fecha_alta' => $empresa->fecha_alta,
		                            'activated'   => $empresa->activated
		                   );
			}
	
	        return $data;
		}
			
	}
	
	function get_empresa_name_by_id($emp_id = NULL) {
		if($emp_id) {
			//Obtenemos la empresa en base al id enviado como parametro
			$empresa = $this->ci->empresas->get_empresa_by_id($emp_id);

			if($empresa) {
				return $empresa->nombre;
			} else {
				return NULL;
			}
		}
			
	}
	
	function is_empresa_activada($empresa_id) {
		$empresa = $this->get_empresa_by_id($empresa_id);
		if($empresa[0]['activated'] == 1) {
			return true;
		} else {
			return false;
		}
	}
	
	function is_cuenta_registro_activada($empresa_id) {
		$empresa = $this->get_cuenta_registro_by_id($empresa_id);
		if($empresa[0]['activated'] == 1) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
     * Devuelve todos los usuarios del sistema
     * @return type 
     */
      function get_empresas()
      {
            $empresas = $this->ci->empresas->get_empresas();

            foreach ($empresas->result() as $row)
            {
               $data[] = array(
                                'empresa_id'    => $row->empresa_id,
                                'empresa_asoc_id'            => $row->empresa_asoc_id,
                                'tipo_empresa_id'        => $row->tipo_empresa_id,
                                'tipo_empresa'           => $this->get_tipo_empresa_by_id($row->tipo_empresa_id),
                                'nombre'    => $row->nombre,
                                'cuit'      => $row->cuit,
                                'fecha_alta'      => $row->fecha_alta,
                                'activated'      => $row->activated,
                       );
            }

            return $data;
      }
	  
	  /**
	   * Devuelve una empresa en base al ID pasado como parametro
	   */
	  function get_tipo_empresa_by_id($tipo_empresa_id) {
		   if(!is_null($tipo_empresa = $this->ci->empresas->get_tipo_empresa_by_id($tipo_empresa_id))) {
		   		return $tipo_empresa->tipo_empresa;
		   } else {
		   	return null;
		   }
	  }
	  
	
	/**
     * Devuelve el mensaje de error.
     * Puede ser usada tras cualquier operacion fallida, como de login o registro.
     *
     * @return	string
     */
    function get_error_message()
    {
            return $this->error;
    }
}