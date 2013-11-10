<?php

class  Roles_model extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Devuelve el role del usuario logueado
     * @param type $user_id
     * @return int 
     */
    
    function get_role($user_id)
    {
        $roles = $this->db->select('roles.role_id, users.username, roles.nombre, roles.descripcion, roles.empresa_id')
                ->where('users.user_id', $user_id)
                ->join('roles', 'roles.role_id = users.role_id')
                ->get('users');
        
        return ($roles->num_rows() > 0) ? $roles->row() : false;
    }
	
	
	/**
	 * Devolvemos todas las gestiones disponibles
	 * NOTA: Usada para el caso que el usuario logueado sea Admin
	 */
	function get_gestiones($controladora = NULL) {
		$this->db->distinct('grupos');
		( $controladora ) ? $this->db->where( 'controladora', $controladora ) : $this->db->where('controladora !=', 'admin');
		$gestiones = $this->db->get('permisos');
							 
							  
		if($gestiones->num_rows() > 0) 
	    {
	           foreach ($gestiones->result() as $key => $row)
	           {
	               $data[]= $row->grupo;
	           }

	           return array_unique($data);
	    }
		return null;
	 }

	
    
    function agrega_permisos_role($permisos)
    {
        $query = "INSERT INTO roles_permisos (role_id, permiso_id) VALUES ";
        
        $numItems = count($permisos);
        $i = 1;
        foreach($permisos as $permiso)
        {
            $query .= '(' . $permiso['role_id'] . ',' . $permiso['permiso_id'] . ')' ;
            if($i < $numItems) {
                $query .= ',';
              }
              $i++;
        }
        
        $query .= ';';
        
        $q = $this->db->query($query);
    }
    
    function actualiza_permisos_role($role_id, $permisos) {
        
        if(count($permisos) > 0) {
            $this->db->where('role_id', $role_id);
            $this->db->delete('roles_permisos');

            $this->agrega_permisos_role($permisos);
        } else {
            $this->db->where('role_id', $role_id);
            $this->db->delete('roles_permisos');
        }
        
        
        return true;
    }
  
    
    /**
     * Devuelve el role_id asociado al user_id
     * @param type $user_id
     * @return int 
     */
    function get_role_id($user_id)
    {
        /*$role_id = $this->db->select('role_id')
                                ->where('role_id', $user_id)
                                ->from('roles')
                                ->get();*/
        $role_id = $this->db->select('role_id')
                                        ->where('user_id', $user_id)
                                        ->from('users')
                                        ->get();
        
        return ($role_id->num_rows() > 0) ? $role_id->row() : false;
    }
    
    /**
     * Muestra si el nombre del role existe o no en la base de datos
     * @param type $role
     * @return type 
     */
    function role_name_disponible($role)
    {
        
        //$nombreCol = strlower('nombre');
        
        $num = $this->db
                            ->where('nombre', strtolower($role))
                            ->count_all_results('roles');
        
        return $num == 0;
    }
    
        /**
     * Determina si un nombre de role es correcto para cuando se efectua una modificacion
     * controla que el nombre no este siendo usado por otro role (salvo por el mismo)
     * @param type $role
     * @return type 
     */
    function role_name_disponible_edicion($role, $role_id)
    {
        $num = $this->db
                            ->where('nombre', strtolower($role))
                            ->where('role_id', $role_id)
                            ->count_all_results('roles');
        
        return $num == 1;
    }
    
    /**
     * Agrega un role a la base de datos
     * @param type $data
     * @return type 
     */
    function add_role($data)
    {
        //Audit field
        $data['user'] = $this->auth_frr->is_logged_in();
        if ($this->db->insert('roles', $data)) 
        {
                return true;
        }
        return NULL;
    }
    
    /**
     * Modifica un role en base al id suministrado
     * @param type $role_id
     * @param type $data
     * @return type 
     */
    function modificar_role($role_id, $data)
    {
        //Audit field
        $data['user'] = $this->auth_frr->is_logged_in();
        $this->db->where('role_id', $role_id);
        if($this->db->update('roles', $data))
                return true;
        else
                return false;
    }
    
    function eliminar_role($role_id)
    {
        $this->db->where('role_id', $role_id);
        if($this->db->delete('roles'))
        {
                //Eliminamos el role de la tabla roles_permisos
                $this->db->where('role_id', $role_id);
                if($this->db->delete('roles_permisos'))
                    return true;
                else
                    return false;
        }
        else
                return false;
    }
    
    /**
     * Devuelve una lista con todos los roles en el sistema
     * @return type 
     */
    function get_roles($empid = null)
    {
    	//Si no se especifica un empid significa que fue invocada por un admin
    	if($empid) {
    		$query = $this->db->select()
                               ->from('roles')
							   ->where('empresa_id', $empid)
                               ->get();
        
	        if($query->num_rows() > 0)
	        {
	            return $query;
	        } else {
	        	return null;
	        }
    	} else {
    		$query = $this->db->select()
                               ->from('roles')
                               ->get();
        
	        if($query->num_rows() > 0)
	        {
	            return $query;
	        } else {
	        	return null;
	        }
    	}
    }
    
    /**
     * Devuelve una lista con todos los roles de la empresa
     * @return type 
     */
    function get_roles_empresa($empid)
    {
        $query = $this->db->select()
                               ->from('roles')
                               ->where('empresa_id', $empid)
                               ->get();
        
        if($query->num_rows() > 0)
        {
            return $query;
        } else {
            return null;
        }
    }
    
    function get_role_by_id($role_id)
    {
        $query = $this->db->select()
                               ->from('roles')
                                ->where('role_id', $role_id)
                               ->get();
        
        if($query->num_rows() > 0) 
                return $query->row();
        else 
                return NULL;
    }
    
    function get_role_by_name($role)
    {
        $query = $this->db->select()
                               ->from('roles')
                                ->where('nombre', strtolower($role))
                               ->get();
        
        if($query->num_rows() > 0) 
                return $query->row();
        else 
                return NULL;
    }
    
    function get_permisos_role($role_id)
    {
        $query = $this->db->select('permiso_id')
                               ->where('role_id', $role_id)
                               ->from('roles_permisos')
                               ->get();
        if($query->num_rows() > 0)
                return $query->result();
        else
                return NULL;
    }
}
