<<<<<<< HEAD
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo de datos para users
 *
 */
class Ewarrants_model extends CI_Model
{
	private $table_name = 'users';
	private $profile_table_name	= 'user_profiles';

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
	}
        
        function emitir($data) {
            $data['created'] = date('Y-m-d H:i:s');
            if ($this->db->insert('ewarrant', $data)) {
                return true;
            } else {
                return false;
            }
        }
        
        function modificar($ewid, $data) {
            $this->db->where('id', $ewid);
            if($this->db->update('ewarrant', $data))
                   return true;
            else
                  return false;
        }
        
        function get_warrants_habilitados() {
            $query = $this->db->select()
                               ->from('ewarrant')
                               ->where('estado', 1)
                               ->get();
        
            if($query->num_rows() > 0)
            {
                return $query;
            } else
                return NULL;
        }
        
        function get_warrants_habilitados_pendientes() {
        	$query = $this->db->select()
        	->from('ewarrant')
        	->where('estado', 1)
        	->get();
        
        	if($query->num_rows() > 0)
        	{
        		return $query;
        	} else
        		return NULL;
        }
        
		function get_warrants_empresa_pendientes($empresa_id, $estado = NULL) {
			$est = isset($estado) ? $estado : 1;
            $query = $this->db->select()
                               ->from('ewarrant')
                               ->where('empresa_id', $empresa_id)
                               ->where('estado', $est)
                               ->get();
        
            if($query->num_rows() > 0)
            {
                return $query;
            } else
                return NULL;
        }
        
         function get_warrants_habilitados_sin_firmar() {
            $query = $this->db->select()
                               ->from('ewarrant')
                               ->where('estado', 1)
                               ->where('firmado', 0)
                               ->get();
        
            if($query->num_rows() > 0)
            {
                return $query;
            } else
                return NULL;
        }
        
        function get_warrants_empresa($empresa_id) {
            $query = $this->db->select()
                               ->from('ewarrant')
                               ->where('empresa_id', $empresa_id)
                               ->get();
        
            if($query->num_rows() > 0)
            {
                return $query;
            } else
                return NULL;
        }
        
        function get_warrants_empresa_habilitados($empresa_id) {
            $query = $this->db->select()
                               ->from('ewarrant')
                               ->where('empresa_id', $empresa_id)
                               ->where('firmado', 1)
                               ->where('estado', 1)
                               ->get();
        
            if($query->num_rows() > 0)
            {
                return $query;
            } else
                return NULL;
        }
        
        function get_warrants_empresa_habilitados_sin_firmar($empresa_id) {
            $query = $this->db->select()
                               ->from('ewarrant')
                               ->where('empresa_id', $empresa_id)
                               ->where('firmado', 0)
                               ->where('estado', 1)
                               ->get();
        
            if($query->num_rows() > 0)
            {
                return $query;
            } else
                return NULL;
        }
        
        function get_warrant_by_id($ew_id) {
            $ew = $this->db->select('')
                ->where('ewarrant.id', $ew_id)
                ->get('ewarrant');
        
            return ($ew->num_rows() > 0) ? $ew->row() : false;
        }
        
        function get_cuenta_registro_by_id($crid) {
            $cr = $this->db->select('')
                ->where('cuentas_registro.cuentaregistro_id', $crid)
                ->get('cuentas_registro');
        
            return ($cr->num_rows() > 0) ? $cr->row() : false;
        }
}
=======
<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Modelo de datos para users
 *
 */
class Ewarrants_model extends CI_Model {
	private $table_name = 'users';
	private $profile_table_name = 'user_profiles';

	function __construct() {
		parent::__construct();

		$ci = &get_instance();
	}

	function emitir($data) {
		$data['created'] = date('Y-m-d H:i:s');
		if ($this -> db -> insert('ewarrant', $data)) {
			return true;
		} else {
			return false;
		}
	}

	function modificar($ewid, $data) {
		$this -> db -> where('id', $ewid);
		if ($this -> db -> update('ewarrant', $data))
			return true;
		else
			return false;
	}

	function get_warrants_habilitados() {
		$query = $this -> db -> select() -> from('ewarrant') -> where('estado', 1) -> get();

		if ($query -> num_rows() > 0) {
			return $query;
		} else
			return NULL;
	}

	function get_warrants_habilitados_sin_firmar() {
		$query = $this -> db -> select() -> from('ewarrant') -> where('estado', 1) -> where('firmado', 0) -> get();

		if ($query -> num_rows() > 0) {
			return $query;
		} else
			return NULL;
	}

	function get_warrants_empresa($empresa_id) {
		$query = $this -> db -> select() -> from('ewarrant') -> where('empresa_id', $empresa_id) -> get();

		if ($query -> num_rows() > 0) {
			return $query;
		} else
			return NULL;
	}

	function get_warrants_empresa_habilitados($empresa_id) {
		$query = $this -> db -> select() -> from('ewarrant') -> where('empresa_id', $empresa_id) -> where('firmado', 1) -> where('estado', 1) -> get();

		if ($query -> num_rows() > 0) {
			return $query;
		} else
			return NULL;
	}

	function get_warrants_empresa_habilitados_sin_firmar($empresa_id) {
		$query = $this -> db -> select() -> from('ewarrant') -> where('empresa_id', $empresa_id) -> where('firmado', 0) -> where('estado', 1) -> get();

		if ($query -> num_rows() > 0) {
			return $query;
		} else
			return NULL;
	}

	function get_warrant_by_id($ew_id) {
		$ew = $this -> db -> select('') -> where('ewarrant.id', $ew_id) -> get('ewarrant');

		return ($ew -> num_rows() > 0) ? $ew -> row() : false;
	}

	function get_cuenta_registro_by_id($crid) {
		$cr = $this -> db -> select('') -> where('cuentas_registro.cuentaregistro_id', $crid) -> get('cuentas_registro');

		return ($cr -> num_rows() > 0) ? $cr -> row() : false;
	}

}
>>>>>>> ee9529292c19df5a8db1d810419df49552c5a69d
