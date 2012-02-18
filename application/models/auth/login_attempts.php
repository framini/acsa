<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Login_attempts
 *
 * Este modelo se utiliza para controlar todos los intentos de logueo en el sitio
 *
 */
class Login_attempts extends CI_Model
{
	private $table_name = 'login_attempts';

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->table_name = $ci->config->item('db_table_prefix', 'auth').$this->table_name;
	}

	/**
	 * Devuelve el numero de intentos de logueo realizado desde una determinada ip o login (username o mail)
	 *
	 * @param	string
	 * @param	string
	 * @return	int
	 */
	function get_attempts_num($ip_address, $login)
	{
                                    //Funciona como el COUNT(*)
		$this->db->select('1', FALSE);
		$this->db->where('ip_address', $ip_address);
		if (strlen($login) > 0) $this->db->or_where('login', $login);

		$qres = $this->db->get($this->table_name);
		return $qres->num_rows();
	}

	/**
	 * Aumenta el numero de intentos fallidos para una determinada IP y login (Nombre de usuario)
	 *
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	function increase_attempt($ip_address, $login)
	{
		$this->db->insert($this->table_name, array('ip_address' => $ip_address, 'login' => $login));
	}

	/**
	 * Limpia todos los registros de intentos de ingreso fallido para una determinada IP y login (Nombre de usuario)
	 * Tambien limpia todos los registros que ya son obsoletos (Aquellos que ya superaron el tiempo de login_attempt_expire)
	 *
	 * @param	string
	 * @param	string
	 * @param	int
	 * @return	void
	 */
	function clear_attempts($ip_address, $login, $expire_period = 86400)
	{
		$this->db->where(array('ip_address' => $ip_address, 'login' => $login));

		// Purge obsolete login attempts
		$this->db->or_where('UNIX_TIMESTAMP(time) <', time() - $expire_period);

		$this->db->delete($this->table_name);
	}
}