<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo para autologin
 *
 * Representa la data de usuario para autologin. Puede ser usado
 * para verificacion de usuario cuando un usuario solicite hacer un autologin
 *
 */
class User_Autologin extends CI_Model
{
	private $table_name		= 'user_autologin';
	private $users_table_name	= 'users';

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->table_name		= $ci->config->item('db_table_prefix', 'auth').$this->table_name;
		$this->users_table_name	= $ci->config->item('db_table_prefix', 'auth').$this->users_table_name;
	}

	/**
	 * Toma la data del usuario auto-logueado
	 * Devuelve NULL si la key o el ID del usuario es no valida
	 *
	 * @param	int
	 * @param	string
	 * @return	object
	 */
	function get($user_id, $key)
	{
		$this->db->select($this->users_table_name.'.user_id');
		$this->db->select($this->users_table_name.'.username');
		$this->db->from($this->users_table_name);
		$this->db->join($this->table_name, $this->table_name.'.user_id = '.$this->users_table_name.'.id');
		$this->db->where($this->table_name.'.user_id', $user_id);
		$this->db->where($this->table_name.'.key_id', $key);
		$query = $this->db->get();
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	/**
	 * Guarda la data para el autologueo del usuario
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function set($user_id, $key)
	{
		return $this->db->insert($this->table_name, array(
			'user_id' 		=> $user_id,
			'key_id'	 	=> $key,
			'user_agent' 	=> substr($this->input->user_agent(), 0, 149),
			'last_ip' 		=> $this->input->ip_address(),
		));
	}

	/**
	 * Borra la data de autologueo del usuario
	 *
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	function delete($user_id, $key)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('key_id', $key);
		$this->db->delete($this->table_name);
	}

	/**
	 * Borra toda la data de autologueo para un determinado usuario
	 *
	 * @param	int
	 * @return	void
	 */
	function clear($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete($this->table_name);
	}

	/**
	 * Limpia la data de autologueo para un determinado usuario y condiciones de logueo
	 *
	 * @param	int
	 * @return	void
	 */
	function purge($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('user_agent', substr($this->input->user_agent(), 0, 149));
		$this->db->where('last_ip', $this->input->ip_address());
		$this->db->delete($this->table_name);
	}
}