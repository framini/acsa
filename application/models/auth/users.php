<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo de datos para users
 *
 */
class Users extends CI_Model
{
	private $table_name = 'users';
	private $profile_table_name	= 'user_profiles';

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->table_name = $ci->config->item('db_table_prefix', 'auth').$this->table_name;
		$this->profile_table_name = $ci->config->item('db_table_prefix', 'auth').$this->profile_table_name;
	}

	/**
	 * Devuelve el record de usuario en base al ID
	 * @param	int
	 * @param	bool
	 * @return	object
	 */
	function get_user_by_id($user_id, $activated)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('activated', $activated ? 1 : 0);

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}
	
	/**
	 * Devuelve true en caso que el usuario exista, false caso contrario
	 */
	 
	 function user_exists($user_id) {
	 	$this->db->where('user_id', $user_id);
		$query = $this->db->get('users');
		if ($query->num_rows() == 1) return TRUE;
		return NULL;
	 }

	/**
	 * Devuelve el record de usuario por login (username o email)
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_login($login)
	{
		//Buscamos que el usuario este activado antes de loguearlo
		$this->db->where('activated', 1);
		$this->db->where('LOWER(username)=', strtolower($login));
		$this->db->or_where('LOWER(email)=', strtolower($login));
		

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) {
			//print_r($query->row()->activated);
			return $query->row();
		}
		return NULL;
	}
                  
                  /**
               * Indica si el usuario cumplio o no con el tiempo establecido de ban tras alcanzar el num maximo de intentos
               * fallidos de logueo
               * Tiempo default 45 minutos
               * @param type $ip_address
               * @param type $login
               * @param type $tiempo_ban
               * @return type 
               */
                  function ban_time_cumplido($ip_address, $login, $tiempo_ban = 2700)
	{
                                    $this->db->select('1', FALSE);
		$this->db->where(array('last_ip' => $ip_address, 'username' => $login));
		$this->db->where('UNIX_TIMESTAMP(modified) <', time() - $tiempo_ban);
                                    
                                    $qres = $this->db->get($this->table_name);
                                    
                                    if($qres->num_rows() > 0)
                                           return true;
                                    else
                                           return false;
	}

	/**
	 * Devuelve el record de usuario por username
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_username($username)
	{
		$this->db->where('LOWER(username)=', strtolower($username));
		$this->db->where('activated', '1');

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	/**
	 * Devuelve el record de usuario por email
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_email($email)
	{
		$this->db->where('LOWER(email)=', strtolower($email));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}
        
       /**
       * Devuelve una lista con todos los usuarios en el sistema
       * @return type 
       */
        function get_users()
        {
            $query = $this->db->select()
                                   ->from('users')
                                   ->get();

            if($query->num_rows() > 0)
            {
                return $query;
            }
        }
        
        /**
       * Devuelve una lista con todos los usuarios de la empresa
       * @return type 
       */
        function get_users_empresa($empid)
        {
            $query = $this->db->select()
                                   ->from('users')
                                   ->where('empresa_id', $empid)
                                   ->get();

            if($query->num_rows() > 0)
            {
                return $query;
            }
        }
		
		function get_empresa_by_user_id($user_id) {
			$this->db->select('empresa_id');
			$this->db->where('user_id', $user_id);
	
			$query = $this->db->get($this->table_name);
			if ($query->num_rows() == 1) return $query->row();
			return NULL;
		}

	/**
	 * Chequea si el username esta disponible para registro
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_username_available($username)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(username)=', strtolower($username));

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}
        
       function guardar_cambios($user_id, $username) {
           $this->db->where('username', $username);
           $u = array('user_id !=' => $user_id);
           $this->db->where($u);
           $this->db->select();
           $this->db->from('users');
           $query = $this->db->get();
           
           if($query->num_rows() == 0) {
               return true;
           } else {
               return false;
           }
       }

	/**
	 * Chequea que el email esta disponible para registro
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_email_available($email)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(email)=', strtolower($email));
		$this->db->or_where('LOWER(new_email)=', strtolower($email));

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}

	/**
	 * Crea un nuevo record de usuario
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */
	function create_user($data, $activated = TRUE)
	{
		$data['created'] = date('Y-m-d H:i:s');
		$data['activated'] = $activated ? 1 : 0;

		if ($this->db->insert($this->table_name, $data)) {
			$user_id = $this->db->insert_id();
			if ($activated)	$this->create_profile($user_id);
			return array('user_id' => $user_id);
		}
		return NULL;
	}
        
                    function modificar_user($user_id, $data) {
                        $this->db->where('user_id', $user_id);
                           if($this->db->update('users', $data))
                                   return true;
                           else
                                  return NULL;
                    }

	/**
	 * Activa al usuario si la key de activacion es valida.
	 * Solamente puede ser llamada para usuarios no activados solamente.
	 *
	 * @param	int
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function activate_user($user_id, $activation_key, $activate_by_email)
	{
                                    //Hace una especie de COUNT(*) con activerecords
		$this->db->select('1', FALSE);
		$this->db->where('user_id', $user_id);
		if ($activate_by_email) {
			$this->db->where('new_email_key', $activation_key);
		} else {
			$this->db->where('new_password_key', $activation_key);
		}
		$this->db->where('activated', 0);
		$query = $this->db->get($this->table_name);

		if ($query->num_rows() == 1) {

			$this->db->set('activated', 1);
			$this->db->set('new_email_key', NULL);
			$this->db->where('user_id', $user_id);
			$this->db->update($this->table_name);

			$this->create_profile($user_id);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Limpia la tabla de usuarios no activados 
	 *
	 * @param	int
	 * @return	void
	 */
	function purge_na($expire_period = 172800)
	{
		$this->db->where('activated', 0);
		$this->db->where('UNIX_TIMESTAMP(created) <', time() - $expire_period);
		$this->db->delete($this->table_name);
	}

	/**
	 * Elimina el usuario
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete($this->table_name);
		if ($this->db->affected_rows() > 0) 
                                    {
			$this->delete_profile($user_id);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Setea un password key para el usuario
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function set_password_key($user_id, $new_pass_key)
	{
		$this->db->set('new_password_key', $new_pass_key);
		$this->db->set('new_password_requested', date('Y-m-d H:i:s'));
		$this->db->where('user_id', $user_id);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Chequea que la password key sea valida y el usuario este autenticado
	 *
	 * @param	int
	 * @param	string
	 * @param	int
	 * @return	void
	 */
	function can_reset_password($user_id, $new_pass_key, $expire_period = 900)
	{
        //Funciona como el COUNT(*) pero con activerecords
		$this->db->select('1', FALSE);
		$this->db->where('user_id', $user_id);
		$this->db->where('new_password_key', $new_pass_key);
		//$this->db->where('UNIX_TIMESTAMP(new_password_requested) >', time() - $expire_period);

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 1;
	}

	/**
	 * Cambia el password del usuario si el password key es valido y el usuario autenticado
	 *
	 * @param	int
	 * @param	string
	 * @param	string
	 * @param	int
	 * @return	bool
	 */
	function reset_password($user_id, $new_pass, $new_pass_key, $expire_period = 900)
	{
		$this->db->set('password', $new_pass);
		$this->db->set('new_password_key', NULL);
		$this->db->set('new_password_requested', NULL);
		$this->db->where('user_id', $user_id);
		$this->db->where('new_password_key', $new_pass_key);
		//$this->db->where('UNIX_TIMESTAMP(new_password_requested) <', time() - $expire_period);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Cambia el password del usuario
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function change_password($user_id, $new_pass)
	{
		$this->db->set('password', $new_pass);
		$this->db->where('user_id', $user_id);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Setea new email para un usuario (puede estar activado o no).
	 * El nuevo email no puede ser usado para login o para notificaciones antes de ser actvado
	 *
	 * @param	int
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function set_new_email($user_id, $new_email, $new_email_key, $activated)
	{
		$this->db->set($activated ? 'new_email' : 'email', $new_email);
		$this->db->set('new_email_key', $new_email_key);
		$this->db->where('user_id', $user_id);
		$this->db->where('activated', $activated ? 1 : 0);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 *
	 * Activa un nuevo email (reemplaza el anterior con el neuvo) si la key de activacion es valida
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function activate_new_email($user_id, $new_email_key)
	{
		$this->db->set('email', 'new_email', FALSE);
		$this->db->set('new_email', NULL);
		$this->db->set('new_email_key', NULL);
		$this->db->where('user_id', $user_id);
		$this->db->where('new_email_key', $new_email_key);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Actualiza la info del usuario, como ultima IP y tiempo de logueo.
	 * Limpia tambien los password generados que no hayan sido activados.
	 *
	 * @param	int
	 * @param	bool
	 * @param	bool
	 * @return	void
	 */
	function update_login_info($user_id, $record_ip, $record_time)
	{
		$this->db->set('new_password_key', NULL);
		$this->db->set('new_password_requested', NULL);

		if ($record_ip)		$this->db->set('last_ip', $this->input->ip_address());
		if ($record_time)	$this->db->set('last_login', date('Y-m-d H:i:s'));

		$this->db->where('user_id', $user_id);
		$this->db->update($this->table_name);
	}

	/**
	 * Banea usuario
	 *
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	function ban_user($user_id, $reason = NULL)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update($this->table_name, array(
			'banned'		=> 1,
			'ban_reason'	=> $reason,
		));
	}

	/**
	 * Desbanea usuario
	 *
	 * @param	int
	 * @return	void
	 */
	function unban_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update($this->table_name, array(
			'banned'		=> 0,
			'ban_reason'	=> NULL,
		));
	}

	/**
	 * Crea un profile vacio para un nuevo usuario
	 *
	 * @param	int
	 * @return	bool
	 */
	private function create_profile($user_id)
	{
		$this->db->set('user_id', $user_id);
		return $this->db->insert($this->profile_table_name);
	}

	/**
	 * Borra profile de usuario
	 *
	 * @param	int
	 * @return	void
	 */
	private function delete_profile($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete($this->profile_table_name);
	}
}