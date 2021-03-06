<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Modelo de datos para empresas
 *
 */
class Empresas extends CI_Model {

	function __construct() {
		parent::__construct();

		$ci = &get_instance();
	}

	/**
	 * Devuelve el record de la empresa en base al ID
	 *
	 * @param	int
	 * @param	bool
	 * @return	object
	 */
	function get_empresa_by_id($empresa_id) {
		$this -> db -> where('empresa_id', $empresa_id);
		$this -> db -> from('empresas');
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1)
			return $query -> row();
		return NULL;
	}

	function get_saldos_by_user_id($user_id) {
		$this -> db -> where('owner', $user_id);
		$this -> db -> from('cuentas_corrientes');
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1)
			return $query -> row();
		return NULL;
	}

	function get_cuenta_registro_by_id($empresa_id) {
		$this -> db -> where('cuentaregistro_id', $empresa_id);
		$this -> db -> from('cuentas_registro');
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1)
			return $query -> row();
		return NULL;
	}

	function get_tipo_cuenta_registro_by_id($tipo_cuenta_id) {
		$this -> db -> where('tipo_cuentaregistro_id', $tipo_cuenta_id);
		$this -> db -> from('tipo_cuenta_registro');
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1)
			return $query -> row();
		return NULL;
	}

	/**
	 * Chequea si el cuit esta disponible
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_cuit_empresa_available($cuit) {
		$this -> db -> select('1', FALSE);
		$this -> db -> where('LOWER(cuit)=', strtolower($cuit));

		$query = $this -> db -> get('empresas');
		return $query -> num_rows() == 0;
	}

	/**
	 * Eliminamos la empresa con id = $empresa_id
	 * Y todos los usuarios que pertenecen a esa empresa
	 * NOTA: Borrado Logico
	 */
	function eliminar_empresa($empresa_id) {
		$this -> db -> where('empresa_id', $empresa_id);
		//La empresa owner no se puede eliminar
		$this -> db -> where('owner', 0);
		$data['activated'] = 0;

		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();

		if ($this -> db -> update('empresas', $data)) {
			//Eliminamos los usuarios que hayan pertenecido a esa empresa
			$this -> db -> where('empresa_id', $empresa_id);
			if ($this -> db -> update('users', $data))
				return true;
			else
				return false;
		} else
			return false;
	}

	function eliminar_cuenta_registro($empresa_id) {
		$this -> db -> where('cuentaregistro_id', $empresa_id);
		$data['activated'] = 0;
		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();

		if ($this -> db -> update('cuentas_registro', $data)) {
			return true;
		} else
			return false;
	}

	/**
	 * Activamos la empresa con id = $empresa_id
	 * Y todos los usuarios que pertenecen a esa empresa
	 * NOTA: Activación Lógica
	 */
	function activar_empresa($empresa_id) {
		$this -> db -> where('empresa_id', $empresa_id);
		$data['activated'] = 1;
		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();

		if ($this -> db -> update('empresas', $data)) {
			//Eliminamos los usuarios que hayan pertenecido a esa empresa
			$this -> db -> where('empresa_id', $empresa_id);
			if ($this -> db -> update('users', $data))
				return true;
			else
				return false;
		} else
			return false;
	}

	function activar_cuenta_registro($empresa_id) {
		$this -> db -> where('cuentaregistro_id', $empresa_id);
		$data['activated'] = 1;
		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();

		if ($this -> db -> update('cuentas_registro', $data)) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Crea un nuevo record de empresa
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */
	function create_empresa($data) {
		$data['fecha_alta'] = date('Y-m-d H:i:s');
		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();

		if ($this -> db -> insert('empresas', $data)) {
			$empresa_id = $this -> db -> insert_id();
			return array('empresa_id' => $empresa_id);
		}
	}
		
		/**
		 * Devuelve todas las empresas cargadas en el sistema
		 */
        function get_all_empresas($filtrar_aseguradoras = TRUE) {
            $this->db->select();
            $this->db->from("empresas");
            if( $filtrar_aseguradoras ) {
            	$this->db->where('tipo_empresa_id !=', 4); //SE FILTRAN LAS ASEGURADORAS
        	}
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) return $query;
            return NULL;
        }
		
		/**
		 * Devuelve las cuentas registro asociadas a una empresa
		 */
        function get_cuentas_registro_all() {
            $this->db->select();
            $this->db->from("cuentas_registro");
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) return $query;
            return NULL;
        }
        
        /**
         * Devuelve las empresas aseguradoras
         */
        function get_aseguradoras() {
        	$aseguradoras = $this->db->select('empresas.empresa_id, empresas.nombre, tp.tipo_empresa_id, tp.tipo_empresa, tp.descripcion')
                                           ->where('tp.tipo_empresa_id', 4) //ASEGURADORAS TIENE ID 4
                                           ->join('tipo_empresa AS tp', 'tp.tipo_empresa_id = empresas.tipo_empresa_id')
                                           ->get('empresas');
	       if($aseguradoras->num_rows() > 0) 
	       {
	          	return $aseguradoras;
	       }
	       
	        
	        return false;
        }
        
		/**
		 * Devuelve las cuentas registro asociadas a una empresa
		 */
        function get_cuentas_registro($empresa_id) {
            $this->db->select();
            $this->db->from("cuentas_registro");
            $this->db->where('empresa_id', $empresa_id);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) return $query;
            return NULL;
        }
		
		/**
		 * Devuelve los tipos de las cuentas registro
		 */
        function get_tipos_cuentas_registro() {
            $this->db->select();
            $this->db->from("tipo_cuenta_registro");
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) return $query;
            return NULL;
        }
        
		/**
		 * Devuelve las cuentas depositante asociadas a una empresa
		 */
        function get_cuentas_registro_depositante($empresa_id) {
            $this->db->select();
            $this->db->from("cuentas_registro");
            $this->db->where('empresa_id', $empresa_id);
            $this->db->join("tipo_cuenta_registro", "tipo_cuenta_registro.tipo_cuentaregistro_id = cuentas_registro.tipo_cuentaregistro_id");
            $this->db->having("tipo_cuenta_registro.tipo_cuentaregistro_id = 1");
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) return $query;
            return NULL;
        }
		
		/**
		 * Chequea si el nomnbre de la empresa esta disponible
		 *
		 * @param	string
		 * @return	bool
		 */
		function is_nombre_empresa_available($nombre, $tabla)
		{
			$this->db->select('1', FALSE);
			$this->db->where('LOWER(nombre)=', strtolower($nombre));
			if( !is_null($tabla) ) {
				$query = $this->db->get( $tabla );
			} else {
				$query = $this->db->get('empresas');
			}
			
			return $query->num_rows() == 0;

		return NULL;
	}

	/**
	 * Crea una nueva cuenta registro
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */
	function create_cuenta_registro($data) {
		$data['fecha_alta'] = date('Y-m-d H:i:s');
		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();

		if ($this -> db -> insert('cuentas_registro', $data)) {
			$cr_id = $this -> db -> insert_id();
			return array('cuentaregistro_id' => $cr_id);
		}
		return NULL;
	}

	/**
	 * Modifica los datos de una empresa
	 */
	function modificar_empresa($empresa_id, $data, $tabla = NULL) {

		if (is_null($tabla)) {
			$c = 'empresa_id';
			$t = 'empresas';
		} else {
			$c = 'cuentaregistro_id';
			$t = $tabla;
		}

		//Audit field
		$data['user'] = $this->auth_frr->is_logged_in();

		$this -> db -> where($c, $empresa_id);

		if ($this -> db -> update($t, $data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Devuelve una lista con todos los tipos de empresa en el sistema
	 * @return type
	 */
	function get_tipos_empresas() {
		$query = $this -> db -> select() -> from('tipo_empresa') -> get();
		if ($query -> num_rows() > 0) {
			return $query;
		}
	}

	/**
	 * Devuelve una lista con todas las empresas en el sistema
	 * @return type
	 */
	function get_empresas() {
		$query = $this -> db -> select() -> from('empresas') -> get();

		if ($query -> num_rows() > 0) {
			return $query;
		}
	}

	/**
	 * Devuelve el record de la empresa en base al ID
	 *
	 */
	function get_tipo_empresa_by_id($tipo_empresa_id) {
		$this -> db -> select();
		$this -> db -> where('tipo_empresa_id', $tipo_empresa_id);

		$query = $this -> db -> get('tipo_empresa');
		if ($query -> num_rows() == 1)
			return $query -> row();
		return NULL;
	}

	function create_cuenta_corriente($data) {

		if ($this -> db -> insert('cuentas_corrientes', $data)) {
			$cc_id = $this -> db -> insert_id();
			return array('cuenta_corriente_id' => $cc_id);
		}
		return NULL;
	}

	function get_cuentas_corrientes() {
		$this -> db -> select();
		$this -> db -> from("cuentas_corrientes");
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0)
			return $query;
		return NULL;
	}

	function modificar_cuenta_corriente($cuenta_corriente_id, $data) {
		$this -> db -> where('cuenta_corriente_id', $cuenta_corriente_id);
		if ($this -> db -> update('cuentas_corrientes', $data))
			return true;
		else
			return false;
	}

	/**
	 * Devuelve un registro de producto en base al id del parametro
	 */
	function get_cuenta_corriente_by_id($id) {
		$this -> db -> where('cuenta_corriente_id', $id);
		$this -> db -> from('cuentas_corrientes');
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1)
			return $query -> row();
		return NULL;
	}

}
