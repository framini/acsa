<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Roles_frr {
    
    private $error = array();

    public function __construct() {
        $this->ci = & get_instance();

        $this->ci->load->library('auth_frr');
        $this->ci->load->model('auth/users');
        $this->ci->load->model('auth/empresas');
        $this->ci->load->model('roles/roles_model');
    }
    
    function agregar_role($role, $descripcion, $empresa_id, $tipo_empresa_id)
    {
        //Se chequea que el username no sea vacio y que este disponible en el sistema
        //Es decir, que no exista un role con el mismo nombre
        if (!$this->ci->roles_model->role_name_disponible($role)) 
        {
	$this->error = array('nombre_role' => 'Este nombre ya está siendo utilizado por otro role');
                  return false;
        }
        else
        {
            $data = array(
                    'nombre'            => strtolower($role),
                    'descripcion'	=> $descripcion,
                    'empresa_id'	=> $empresa_id,
                    'tipo_empresa_id'	=> $tipo_empresa_id,
            );
            
            if($this->ci->roles_model->add_role($data))
            {
                //echo "OH YEAHHHH";
                return true;
            }
            return false;
        }
    }
    
    /**
     * Permite la modificacion de un determinado Role
     * @param type $role_id
     * @param type $data
     * @return type 
     */
    function modificar_role($role_id, $data)
    {
             if($this->ci->roles_model->modificar_role($role_id, $data))
                return true;
             else
                 return false;
    }
    
    function eliminar_role($role_id)
    {
            if($this->ci->roles_model->eliminar_role($role_id))
                return true;
             else
                 return false;
    }
    
    
    
    /**
     * Determina si un nombre de role esta siendo usado
     * @param type $role
     * @return type 
     */
    function role_name_disponible($role)
    {
         if (!$this->ci->roles_model->role_name_disponible($role)) 
        {
	$this->error = array('nombre_role' => 'Este nombre ya está siendo utilizado por otro role');
                  return false;
        }
        else
        {
                return true;
        }
    }
    
     /**
     * Determina si un nombre de role es correcto para cuando se efectua una modificacion
      * controla que el nombre no este siendo usado por otro role (salvo por el mismo)
     * @param type $role
     * @return type 
     */
    function role_name_disponible_edicion($role, $role_id)
    {
        //$role = $this->ci->roles_model->get_role_by_name($role);
       //print_r($role_id);
       //echo $role->role_id;
        if (!$this->ci->roles_model->role_name_disponible_edicion($role, $role_id)) 
        {
                  if($this->role_name_disponible($role))
                  {
                      return true;
                  }
                  else
                  {
                          $this->error = array('nombre_role' => 'Este nombre ya está siendo utilizado por otro role');
                          return false;
                  }
        }
        else
        {
                return true;
        }
    }

    /**
     * Acceder al role del usuario logueado
     */
    function role_usuario_logueado() {
        if ($this->ci->auth_frr->is_logged_in()) {
            $user_id = $this->ci->auth_frr->get_user_id();

            $role = $this->ci->roles_model->get_role($user_id);
			
			return $role;
        }
    }
	
	/**
     * Acceder al role del usuario pasado como parametro
     */
    function role_usuario($userid) {

            $role = $this->ci->roles_model->get_role($userid);
			
			return $role;
    }

    /**
     * Acceder a los permisos del usuario logueado
     * @return Un array con todos los permisos asignados al role del usuario 
     */
    function permisos_role() {
        if ($this->ci->auth_frr->is_logged_in()) {
            
           $user_id = $this->ci->auth_frr->get_user_id();

           $role_id = $this->get_role_id($user_id);
           $permisos = $this->ci->roles_model->get_permisos($role_id);
            
           return $permisos;
        }
    }

	
	/**
     * Acceder a los permisos del usuario logueado relacionados a una determinada controladora
     * @return Un array con todos los permisos asignados al role del usuario 
     */
    function permisos_role_controladora($controladora) {
        if ($this->ci->auth_frr->is_logged_in()) {
            
           $user_id = $this->ci->auth_frr->get_user_id();

           $role_id = $this->get_role_id($user_id);
		   //Si el usuario es un admin, devolvemos todos los permisos asociados a la controladora en cuestion
			if($this->ci->auth_frr->es_admin()) {
			   $permisos =  $this->ci->roles_model->get_permisos_controladora_admin($role_id, $controladora);
			} else {
           		$permisos = $this->ci->roles_model->get_permisos_controladora($role_id, $controladora);
			}
           return $permisos;
        }
    }
	
	/**
     * Acceder a los permisos del usuario logueado relacionados a una determinada controladora y un determinado grupo
     * @return Un array con todos los permisos asignados al role del usuario 
     */
    function permisos_role_controladora_grupo($controladora, $grupo = null) {
        if ($this->ci->auth_frr->is_logged_in()) {
        	
        	//Si el usuario es un admin, devolvemos todos los permisos asociados a la controladora en cuestion
			if($this->ci->auth_frr->es_admin()) {
			   return $this->ci->roles_model->get_permisos_controladora_grupo_admin($controladora, $grupo);
			} else {
				
			   $user_id = $this->ci->auth_frr->get_user_id();
	           $role_id = $this->get_role_id($user_id);
	           $permisos = $this->ci->roles_model->get_permisos_controladora_grupo($role_id, $controladora, $grupo);
	            
	           return $permisos;
			}
            
           
        }
    }
	
	/**
	 * Indica si el usuario tiene o no permiso para acceder a una determinada seccion
	 */
	function tiene_permisos($permiso, $controladora, $grupo = null) {
			//Si el usuario es Admin tiene permisos
			if($this->ci->auth_frr->es_admin()) {
				return true;
			}
		 	//Si no tiene permisos relacionados a esta controladora, redireccionamos
		 	if(is_null($permisos = $this->permisos_role_controladora($controladora))) {
             	return false;
         	} else {
				//Si el usuario no posee el permiso necesario para la accion que desea realizar redireccionamos
				$retorno = false;
				foreach ($permisos as $key => $value) {
					if($permiso == $value['permiso']) {
						return true;
					} 
					//Si el permiso pertenece al grupo que estamos intentando acceder
					else if($grupo && $grupo == $value['grupo']) {
						return true;
					}
				}
				return $retorno;
         	}
			
			return true;
	}
	
	/**
	 * Indica las gestiones que tiene disponible un usuario.
	 * Se determina en base al grupo asignado a cada permiso y basta que al menos un permiso de un grupo
	 * este habilitado para que la gestion (grupo) que contiene dicho permiso quede habilitado
	 */
	function gestiones_disponibles($controladora) {
		//Si es un admin devolvemos todas las secciones
		if($this->ci->auth_frr->es_admin()) {
				return $this->ci->roles_model->get_gestiones();
		}
		
		//Si el usuario no tiene permisos asociados a la controladora que esta accediendo
		if(is_null($permisos = $this->permisos_role_controladora($controladora))) {
			return null;
		} else {
			//Recorremos el array de permisos en busca de los grupos a los que pertecenen
			foreach ($permisos as $key => $value) {
				if($value['grupo']) {
					//Almacenamos todos los grupos que esten definidos
					$grupos[] = $value['grupo'];
				}
			}
			//Devolvemos solamente los distintos
			if(isset($grupos)) {
				return array_unique($grupos);
			} else {
				return null;
			}
			
		}
	}
    
    /**
     * Devuelve todos los permisos del sistema
     * @return type 
     */
    function get_all_permisos()
    {
        $permisos = $this->ci->roles_model->get_all_permisos();
        
       return $permisos;
    }
    
	
    function get_permisos_role($role_id)
    {
        $permisos = $this->ci->roles_model->get_permisos_role($role_id);
        
        return $permisos;
    }

    /**
     * Devuelve el id del role del usuario logueado
     * @param type $user_id
     * @return int 
     */
    function get_role_id($user_id) {
        $role = $this->ci->roles_model->get_role_id($user_id);

        return $role->role_id;
    }
    
    /**
     * Devuelve los roles del sistema
     * @return type 
     */
    function get_roles()
    {
    	//Si es invocada por un admin devolvemos todos los roles disponibles
    	if($this->ci->auth_frr->es_admin()) {
    		$roles = $this->ci->roles_model->get_roles();

	        foreach ($roles->result() as $row)
	        {
	           $empresa = $this->ci->empresas->get_empresa_by_id($row->empresa_id);
	           $data[] = array(
	                            'nombre'       => $row->nombre,
	                            'descripcion' => $row->descripcion,
	                            'role_id'        => $row->role_id,
	                            'empresa'     => $empresa->nombre
	                   );
	        }

	        return $data;
    	} else {
    		$roles = $this->ci->roles_model->get_roles($this->ci->auth_frr->get_empresa_id());
			if($roles) {
				foreach ($roles->result() as $row)
		        {
		           $empresa = $this->ci->empresas->get_empresa_by_id($row->empresa_id);
		           $data[] = array(
		                            'nombre'       => $row->nombre,
		                            'descripcion' => $row->descripcion,
		                            'role_id'        => $row->role_id,
		                            'empresa'     => $empresa->nombre
		                   );
		        }
			}

	        return $data;
    	}
        
    }
    
    /**
     * Devuelve los roles de la empresa
     * @param type $empid
     * @return type 
     */
    function get_roles_empresa($empid) {
        $roles = $this->ci->roles_model->get_roles_empresa($empid);
        if(isset($roles)) {
            foreach ($roles->result() as $row)
            {
               $empresa = $this->ci->empresas->get_empresa_by_id($row->empresa_id);
               $data[] = array(
                                'nombre'       => $row->nombre,
                                'descripcion' => $row->descripcion,
                                'role_id'        => $row->role_id,
                                'empresa'     => $empresa->nombre
                       );
            }

            //print_r($data[1]);
            return $data;
        } else {
            return null;
        }
        
    }
    
    /**
     * Devuelve el role en base a su id
     * @param type $role_id
     * @return type 
     */
    function get_role_by_id($role_id)
    {
        $role = $this->ci->roles_model->get_role_by_id($role_id);
        
        if($role)
            return $role;
    }
    
    /**
     * Devuelve el role en base a su nombre
     * @param type $role
     * @return type 
     */
    function get_role_by_name($role)
    {
        $role = $this->ci->roles_model->get_role_by_name($role);
        
        if($role)
            return $role;
    }
	
	/**
	 * Este metodo es utilizado para formatear un array con los datos definidos en el archivo de configuracion de permisos
	 * y asi construir un array que luego pueda ser mostrado en una view
	 */
	function procesa_permisos_view($permisos) {
		//Cargamos el archivo que contiene la info con la que se contruye el menu
        $this->ci->config->load('menu_permisos', TRUE);
		//Procesamos los permisos obtenidos
		if(count($permisos) > 0) {
		  	foreach ($permisos as $key => $row) {
			  $data[$row['permiso']] = $this->ci->config->item($row['permiso'], 'menu_permisos');
		  	}
			return $data;
		} else {
			return NULL;
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
