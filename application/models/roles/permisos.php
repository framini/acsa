<?php

class  permisos extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Devuelve el conjunto de permisos asociados al role_id del usuario logueado
	 * @param type $role_id
	 * @return row
	 */

	function get_permisos($role_id) {
		/*$roles = $this->db->select('roles.role_id, permisos.permiso')
		 ->where('roles.role_id', $role_id)
		 ->join('permisos', 'permisos.role_id = roles.role_id')
		 ->get('roles');

		 return ($roles->num_rows() > 0) ? $roles->row() : false;*/
		$this -> load -> helper('array');
		$permisos = $this -> db -> select('permisos.permiso') -> where('roles_permisos.role_id', $role_id) -> join('permisos', 'permisos.permiso_id = roles_permisos.permiso_id') -> get('roles_permisos');
		if ($permisos -> num_rows() > 0) {
			foreach ($permisos->result() as $row) {
				$data[] = $row -> permiso;
			}

			return $data;
		}

		return false;
	}
	
	/**
     * Devuelve el conjunto de permisos asociados al role_id del usuario logueado y relacionados a una seccion
     * @param type $role_id
     * @return row 
     */
    
    function get_permisos_controladora($role_id, $controladora)
    {
       $this->load->helper('array');
	   
       $permisos = $this->db->select('permisos.permiso, permisos.grupo')
                                           ->where('roles_permisos.role_id', $role_id)
										   ->where('permisos.controladora', $controladora)
                                           ->join('permisos', 'permisos.permiso_id = roles_permisos.permiso_id')
                                           ->get('roles_permisos');
       if($permisos->num_rows() > 0) 
       {
           foreach ($permisos->result() as $key => $row)
           {
               $data[$key]['permiso'] = $row->permiso;
			   $data[$key]['grupo'] = $row->grupo;
           }
           
           return $data;
       }
       
        
        return null;
    }
	
	/**
     * Devuelve el conjunto de permisos asociados al admin logueado
     * @param type $role_id
     * @return row 
     */
    function get_permisos_controladora_admin($role_id, $controladora)
    {
       $this->load->helper('array');
	   
       $permisos = $this->db->select('permisos.permiso, permisos.grupo')
										   ->where('permisos.controladora', $controladora)
                                           ->get('permisos');
       if($permisos->num_rows() > 0) 
       {
           foreach ($permisos->result() as $key => $row)
           {
               $data[$key]['permiso'] = $row->permiso;
			   $data[$key]['grupo'] = $row->grupo;
           }
           
           return $data;
       }
       
        
        return null;
    }
	
	/**
	 * Devuelve el conjunto de permisos asociados al role_id del usuario logueado y relacionados a una seccion
	 * y un determinado grupo
	 */
	function get_permisos_controladora_grupo($role_id, $controladora, $grupo)
    {
       $this->load->helper('array');
	   
       $permisos = $this->db->select('permisos.permiso, permisos.grupo')
                                           ->where('roles_permisos.role_id', $role_id)
										   ->where('permisos.controladora', $controladora)
										   ->where('permisos.grupo', $grupo)
                                           ->join('permisos', 'permisos.permiso_id = roles_permisos.permiso_id')
                                           ->get('roles_permisos');
       if($permisos->num_rows() > 0) 
       {
           foreach ($permisos->result() as $key => $row)
           {
               $data[$key]['permiso'] = $row->permiso;
			   $data[$key]['grupo'] = $row->grupo;
           }
           
           return $data;
       }

        return null;
    }
	
	/**
	 * Devuelve el conjunto de permisos asociados al Admin logueado y relacionados a una seccion
	 * y un determinado grupo
	 */
	function get_permisos_controladora_grupo_admin($controladora, $grupo)
    {
       $this->load->helper('array');
	   
       $permisos = $this->db->select('permisos.permiso, permisos.grupo')
										   ->where('permisos.controladora', $controladora)
										   ->where('permisos.grupo', $grupo)
                                           ->get('permisos');
       if($permisos->num_rows() > 0) 
       {
           foreach ($permisos->result() as $key => $row)
           {
               $data[$key]['permiso'] = $row->permiso;
			   $data[$key]['grupo'] = $row->grupo;
           }
           return $data;
       }

        return null;
    }
	
	function get_permiso_id($permiso) {
        $this->db->select('permiso_id');
        $this->db->where('permiso', $permiso);
        $this->db->from('permisos');
        
        $query = $this->db->get();
        
        if($query->num_rows() == 1) {
            return $query->row();
        } else {
            return NULL;;
        }
    }
	
	/**
     * Devuelve todos los permisos del sistema
     * @return type 
     */
    function get_all_permisos()
    {
        $permisos = $this->db->select('*')
                                            ->from('permisos')
                                            ->get();
        
        if($permisos->num_rows > 0)
        {
            foreach ($permisos->result() as $row)
           {
               $data[] = array('id' => $row->permiso_id, 'permiso' => $row->permiso);
           }
           
           return $data;
           // return $permisos->result();
        }
        else
            return NULL;
    }
	
	/**
     * Devuelve todos los permisos del sistema que no sean del tipo solo para admins
     * @return type 
     */
    function get_all_permisos_no_admin()
    {	
		//Nos fijamos si el usuario logueado no pertenece a una warrantera o si no es un admin, y en caso de no serlo
		//sacamos los permisos que son solo para warranteras
		if( !$this -> auth_frr -> is_warrantera() && !$this -> auth_frr -> es_admin() ) {
			$this->db->where('warrantera_only', 0);
		}
		$this->db->where('admin_only', 0);
        $permisos = $this->db->get('permisos');


        if($permisos->num_rows > 0)
        {
            foreach ($permisos->result() as $row)
           {
               $data[] = array('id' => $row->permiso_id, 'permiso' => $row->permiso);
           }
           
           return $data;
           // return $permisos->result();
        }
        else
            return NULL;
    }

}
