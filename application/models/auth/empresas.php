<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo de datos para empresas
 *
 */
class Empresas extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
	}
        
       /**
     * Devuelve el record de la empresa en base al ID
     *
     * @param	int
     * @param	bool
     * @return	object
     */
        function get_empresa_by_id($empresa_id) {
			$this->db->where('empresa_id', $empresa_id);
            $this->db->from('empresas');
			$query = $this->db->get();
			if ($query->num_rows() == 1) return $query->row();
                        return NULL;
		}
		
		/**
		 * Devuelve todas las empresas cargadas en el sistema
		 */
        function get_all_empresas() {
            $this->db->select();
            $this->db->from("empresas");
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) return $query;
            return NULL;
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
		function is_nombre_empresa_available($nombre)
		{
			$this->db->select('1', FALSE);
			$this->db->where('LOWER(nombre)=', strtolower($nombre));
	
			$query = $this->db->get('empresas');
			return $query->num_rows() == 0;
		}
		
		/**
		 * Chequea si el cuit esta disponible
		 *
		 * @param	string
		 * @return	bool
		 */
		function is_cuit_empresa_available($cuit)
		{
			$this->db->select('1', FALSE);
			$this->db->where('LOWER(cuit)=', strtolower($cuit));
	
			$query = $this->db->get('empresas');
			return $query->num_rows() == 0;
		}
		
		/**
		 * Eliminamos la empresa con id = $empresa_id
		 * Y todos los usuarios que pertenecen a esa empresa
		 * NOTA: Borrado Logico
		 */
		function eliminar_empresa($empresa_id)
	    {
	        $this->db->where('empresa_id', $empresa_id);
			$data['activated'] = 0;
			
	        if($this->db->update('empresas', $data))
	        {
	                //Eliminamos los usuarios que hayan pertenecido a esa empresa
	                $this->db->where('empresa_id', $empresa_id);
	                if($this->db->update('users', $data))
	                    return true;
	                else
	                    return false;
	        }
	        else
	                return false;
	    }
		
		/**
		 * Activamos la empresa con id = $empresa_id
		 * Y todos los usuarios que pertenecen a esa empresa
		 * NOTA: Activación Lógica
		 */
		function activar_empresa($empresa_id)
	    {
	        $this->db->where('empresa_id', $empresa_id);
			$data['activated'] = 1;
			
	        if($this->db->update('empresas', $data))
	        {
	                //Eliminamos los usuarios que hayan pertenecido a esa empresa
	                $this->db->where('empresa_id', $empresa_id);
	                if($this->db->update('users', $data))
	                    return true;
	                else
	                    return false;
	        }
	        else
	                return false;
	    }
    
		
		/**
		 * Crea un nuevo record de usuario
		 *
		 * @param	array
		 * @param	bool
		 * @return	array
		 */
		function create_empresa($data)
		{
			$data['fecha_alta'] = date('Y-m-d H:i:s');
		
			if ($this->db->insert('empresas', $data)) {
				$empresa_id = $this->db->insert_id();
				return array('empresa_id' => $empresa_id);
			}
			return NULL;
		}
		
		/**
		 * Modifica los datos de una empresa
		 */
		function modificar_empresa($empresa_id, $data) {
            $this->db->where('empresa_id', $empresa_id);
               if($this->db->update('empresas', $data))
                       return true;
               else
                      return false;
        }
		
		/**
       * Devuelve una lista con todos los tipos de empresa en el sistema
       * @return type 
       */
        function get_tipos_empresas()
        {
            $query = $this->db->select()
                                   ->from('tipo_empresa')
                                   ->get();
            if($query->num_rows() > 0)
            {
                return $query;
            }
        }
}