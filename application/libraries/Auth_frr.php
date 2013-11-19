<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('phpass-0.1/PasswordHash.php');
require_once('clases/Empresa.php');

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

/**
 * Libreria de Autenticacion para CodeIgniter.
 */
class Auth_frr
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->config('auth_frr', TRUE);

		$this->ci->load->library('session');
		$this->ci->load->database();
		$this->ci->load->model('auth/users');
                                    $this->ci->load->model('auth/empresas');

		// Intenta el autologin
		$this->autologin();
	}

	/**
	 * Loguea al usuario en el sistema. Devuelve TRUE si es loguin se hace correctamente
	 * (usuario existente y activado, password correcto), cualquier otra combinacion FALSE
	 * @param	string	(username o email o ambos dependiento de las opciones seleccionadas en el archivo de config.)
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function login($login, $password, $remember, $login_by_username, $login_by_email)
	{
		if ((strlen($login) > 0) AND (strlen($password) > 0)) 
                                    {

            // Determina que funcion usar para el login segun el archivo de configuracion  
			if ($login_by_username AND $login_by_email) 
                                                      {
				$get_user_func = 'get_user_by_login';
			} 
            else if ($login_by_username) 
            {
				$get_user_func = 'get_user_by_username';
			} 
            else 
            {
				$get_user_func = 'get_user_by_email';
			}

			if (!is_null($user = $this->ci->users->$get_user_func($login))) 
                                                      {

                // Se hace un hash al password ingresado y se lo compara con
                // el password almacenado en la base de datos
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'auth_frr'),
						$this->ci->config->item('phpass_hash_portable', 'auth_frr'));
				if ($hasher->CheckPassword($password, $user->password)) 
                                                                        {
                                                                                          
                      // El usuario puede estar baneado, asi que comprueba el estado y se almacena
                     // el motivo del ban para luego mostrarselo al usuario
					if ($user->banned == 1) 
                    { 
                            //Chequeamos si el usuario fue baneado por exceso de intentos
                            //y si ya cumplio con el tiempo establecido de espera
                            //[NOTA] PASAR EL BAN_REASON A LA CONFIG
                            if($this->tiempo_ban_cumplido($user) && $user->ban_reason == "Limite de intentos excedido")
                            {
                                //Si entramos aca quiere decir que el usuario se logueo correctamente
                                //y ya cumplio con el tiempo de ban especificado en la config
                                
                                //Primer paso es sacarle el ban al user y despues seguir con el logueo habitual
                                $this->ci->users->unban_user($user->user_id);
                                
                                $configuracion['user_id'] = $user->user_id;
                                $configuracion['username'] = $user->username;
                                $configuracion['empresa_id'] = $user->empresa_id;
                                $configuracion['status'] = ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED;
                                $configuracion['es_admin'] = $user->es_admin;
								$configuracion['role_id'] = $user->role_id;


                                $this->ci->session->set_userdata($configuracion);

                                if ($user->activated == 0) 
                                {	
                                        // FAIL - no activado
                                        $this->error = array('not_activated' => '');
                                } 
                                else 
                                {	
                                        // Si el usuario tildo el box de remember
                                        // se crea la cookie extra
                                        if ($remember) 
                                        {
                                                    $this->create_autologin($user->user_id);
                                        }

                                        $this->clear_login_attempts($login);

                                        $this->ci->users->update_login_info(
                                                        $user->user_id,
                                                        $this->ci->config->item('login_record_ip', 'auth_frr'),
                                                        $this->ci->config->item('login_record_time', 'auth_frr'));
                                        return TRUE;
                                }
                            }
                            else
                            {
                                // FAIL y le muestra el error
                                $this->error = array('banned' => $user->ban_reason);
                            }
					} 
                    else  {
                                $configuracion['user_id'] = $user->user_id;
                                $configuracion['username'] = $user->username;
                                $configuracion['empresa_id'] = $user->empresa_id;
                                $configuracion['status'] = ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED;
                                $configuracion['es_admin'] = $user->es_admin;
								
								//Implementacion del Pattern Prototype
                                //Cargamos en la session el objeto con la info de la empresa a ser clonado para
                                //ser utilizado cuando se da de alta un nuevo warrant

                                //Obtenemos la empresa
                                $emp = $this->ci->empresas_frr->get_empresa_by_id($user->empresa_id);
                                /*SOLUCION CON JSON
                                //Creamos el array con la info a ser guardada en la sesion
                                $empresaJSON['nombre'] = $emp->nombre;
                                $empresaJSON['cuit'] = $emp->cuit;
                                $empresaJSON['id'] = $emp->empresa_id;
                                //Creamos un objeto JSON en base al array $empresa
                                //y lo almacenamos en la variable 'empresa' dentro de la 
                                //session del usuario
                                $configuracion['empresa'] = json_encode($empresaJSON);
                                 * FIN SOLUCION JSON
                                 */
                                if( !is_null($emp) ) {
                                	$empresa = new Empresa();
	                                $empresa->setCuit($emp[0]['cuit']);
	                                $empresa->setId($emp[0]['empresa_id']);
	                                $empresa->setNombre($emp[0]['nombre']);
	                                $configuracion['empresa'] = serialize($empresa);
	
	                                //Guardamos la info del usuario logueado en la session
	                                $this->ci->session->set_userdata($configuracion);
                                }
                                

						if ($user->activated == 0) 
                        {	
                                // FAIL - no activado
                                $this->error = array('not_activated' => '');
						} 
                        else 
                        {	
                        // SUCCESS
						if ($remember) 
                        {
                            $this->create_autologin($user->user_id);
						}

							$this->clear_login_attempts($login);

							$this->ci->users->update_login_info(
									$user->user_id,
									$this->ci->config->item('login_record_ip', 'auth_frr'),
									$this->ci->config->item('login_record_time', 'auth_frr'));
							return TRUE;
						}
					}
				} 
                    else 
                    {	
                    // FAIL - password incorrecto
					$this->increase_login_attempt($login);
					$this->error = array('password' => 'auth_incorrect_password');
				}
			} 
                                                     else 
                                                     {
                                                                        // FAIL - login incorrecto
				$this->increase_login_attempt($login);
				$this->error = array('login' => 'auth_incorrect_login');
			}
		}
		return FALSE;
	}

	/**
	 * Logout
	 *
	 * @return	void
	 */
	function logout()
	{
		$this->delete_autologin();

        //Explicitamente se borra la informacion de la sesion del usuario para que no haya problemas con is_logged_in
        $configuracion['user_id'] = '';
        $configuracion['username'] = '';
        $configuracion['empresa_id'] = '';
        $configuracion['status'] = '';
        $configuracion['es_admin'] = '';
		$configuracion['role_id'] = '';

        $this->ci->session->set_userdata($configuracion);

		$this->ci->session->sess_destroy();
	}

	/**
	 * Chequea si usuario esta logueado en el sistema (y si esta activado o no)
	 *
	 * @param	bool
	 * @return	bool
	 */
	function is_logged_in($activado = TRUE)
	{
		return $this->ci->session->userdata('status') === ($activado ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED);
	}

  function get_useremail_by_id($user_id) {
       //$user = $this->ci->users->get_user_by_id($user_id, TRUE) ;
     
     if(!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {
        return $user->email;
     } else {
      return null;
     }
       
   }
	
	/**
	 * Chequea que el usuario logueado todavia exista en la base de datos
	 * -> Cuando elimina su usuario => no puede seguir navegando
	 */
	 
	 function user_exists() {
	 	return $this->ci->users->user_exists( $this->get_user_id() );
	 }
        
        function is_warrantera() {
            $empresa_id = $this->get_empresa_id();
            
            $this->ci->load->model('auth/empresas');
			
            $empresa = $this->ci->empresas->get_empresa_by_id($empresa_id);
            
            //Preguntamos si el id es warrantera
            // NOTA: Ver forma de implementar distinta esta comprobacion
            if(isset($empresa->tipo_empresa_id) && $empresa->tipo_empresa_id == 2) {
                return true;
            } else {
                return false;
            }
        }
        
        function has_role_warrantera() {
        	//$role = $this->ci->roles_frr->role_usuario_logueado();
        	//var_dump($role); die();
        	//TODO: Ver de que forma chequear mejor esto
        	
        	/*if( $this->es_admin() ) {
        		return true;
        	}*/
        	
        	$user_id = $this -> get_user_id();
        	
        	$this->ci->load->model('roles/roles_model');
        	$role = $this -> ci -> roles_model -> get_role($user_id);
        	
        	if( $role->nombre == "Warrantera" ) {
        		return TRUE;
        	} else {
        		return FALSE;
        	}
        }
        
        function has_role_cliente() {
        	//$role = $this->ci->roles_frr->role_usuario_logueado();
        	//var_dump($role); die();
        	//TODO: Ver de que forma chequear mejor esto
        	 
        	/*if( $this->es_admin() ) {
        	 return true;
        	}*/
        	 
        	$user_id = $this -> get_user_id();
        	 
        	$this->ci->load->model('roles/roles_model');
        	$role = $this -> ci -> roles_model -> get_role($user_id);
        	 
        	if( $role->nombre == "Cliente" ) {
        		return TRUE;
        	} else {
        		return FALSE;
        	}
        }
        
        function has_role_aseguradora() {
        	//$role = $this->ci->roles_frr->role_usuario_logueado();
        	//var_dump($role); die();
        	//TODO: Ver de que forma chequear mejor esto
        	 
        	/*if( $this->es_admin() ) {
        		return true;
        	}*/
        	
        	$user_id = $this -> get_user_id();
        	$this->ci->load->model('roles/roles_model');
        	$role = $this -> ci -> roles_model -> get_role($user_id);
        	if( $role->nombre == "Aseguradora" ) {
        		return TRUE;
        	} else {
        		return FALSE;
        	}
        }
        
        function is_argclearing() {
            
            $empresa_id = $this->get_empresa_id();
            
            $this->ci->load->model('auth/empresas');
            $empresa = $this->ci->empresas->get_empresa_by_id($empresa_id);
            
            //Preguntamos si el id es Argentina Clearing
            // NOTA: Ver forma de implementar distinta esta comprobacion
            if($empresa->tipo_empresa_id == 1) {
                return true;
            } else {
                return false;
            }
        }
        
        /**
         * Devuelve todos los usuarios del sistema
         * @return type 
         */
          function get_users()
          {
                $usuarios = $this->ci->users->get_users();

                foreach ($usuarios->result() as $row)
                {
                   $empresa = $this->ci->empresas->get_empresa_by_id($row->empresa_id);

                   $data[] = array(
                                    'username'    => $row->username,
                                    'email'            => $row->email,
                                    'user_id'        => $row->user_id,
                                    'es_admin'    => $row->es_admin,
                                    'empresa'      => (!is_null($empresa)) ? $empresa->nombre : ""
                           );
                }

                return $data;
          }
          
          /**
         * Devuelve todos los usuarios de la empresa
         * @return type 
         */
          function get_users_empresa($empid)
          {
                $usuarios = $this->ci->users->get_users_empresa($empid);

                if( !is_null($usuarios)) {
                  foreach ($usuarios->result() as $row)
                  {
                     $empresa = $this->ci->empresas->get_empresa_by_id($row->empresa_id);

                     $data[] = array(
                                      'username'    => $row->username,
                                      'email'            => $row->email,
                                      'user_id'        => $row->user_id,
                                      'es_admin'    => $row->es_admin,
                                      'empresa'      => $empresa->nombre
                             );
                  }

                  return $data;
                } else {
                  return null;
                }
                
          }
          
          /**
           * Devuelve todas las empresas cargadas en el sistema
           * @return type 
           */
          function get_empresas($filtrar_aseguradoras = false) {
              
              $empresas = $this->ci->empresas->get_all_empresas($filtrar_aseguradoras);
              
              foreach ($empresas->result() as $row){
                  
                   $data[] = array(
                                    'nombre'          => $row->nombre,
                                    'tipo_empresa_id' => $row->tipo_empresa_id,
                                    'empresa_id'      => $row->empresa_id,
                           );
              }

              return $data;
          }
          
          /**
           * Devuelve todas las cuentas de registro de una determinada empresa
           * @param type $empresa_id
           * @return type 
           */
          function get_cuentas_registro($empresa_id) {
              $cuentas_registro = $this->ci->empresas->get_cuentas_registro($empresa_id);
              
              foreach ($cuentas_registro->result() as $row){
                  
                   $data[] = array(
                                    'nombre'                 => $row->nombre,
                                    'tipo_cuentaregistro_id' => $row->tipo_cuentaregistro_id,
                                    'empresa_id'             => $row->empresa_id,
                           );
              }

              return $data;
          }
          
          function get_cuentas_registro_depositante($empresa_id) {
              $cuentas_registro = $this->ci->empresas->get_cuentas_registro_depositante($empresa_id);
              
              if(count($cuentas_registro) != 0) {
                  foreach ($cuentas_registro->result() as $row){

                       $data[] = array(
                                        'cuentaregistro_id'      => $row->cuentaregistro_id,
                                        'nombre'                 => $row->nombre,
                                        'tipo_cuentaregistro_id' => $row->tipo_cuentaregistro_id,
                                        'empresa_id'             => $row->empresa_id,
                               );
                  }

                  return $data;
              } else {
                  return NULL;
              }
          }
          
          function es_admin() {
              if($this->ci->session->userdata('es_admin') == 1) 
                    return true;
              else
                    return false;
          }
		  
		  function get_role_id() {
              return $this->ci->session->userdata('role_id');
          }

	/**
	 * Devuelve el user_id del usuario logueado
	 *
	 * @return	string
	 */
	function get_user_id()
	{
		return $this->ci->session->userdata('user_id');
	}
	
	function update_session_data($datos, $uid) {
		//Si el usuario logueado cambio sus datos
		//actualizamos los datos de sesion
		$userid = $this->get_user_id(); //Obtenemos el id del usuario logueado

		if($userid == $uid) {
			$this->ci->session->set_userdata($datos);
			return true;
		}
		
		return false;
	}
        
        /**
	 * Devuelve empresa_id
	 *
	 * @return	string
	 */
	function get_empresa_id()
	{
		return $this->ci->session->userdata('empresa_id');
	}
	
	function get_empresa_by_user_id( $uid ) {
		if( !is_null( $emp = $this->ci->users->get_empresa_by_user_id( $uid ) ) ) {
			return $emp->empresa_id;
		} else {
			return NULL;
		}
	}

	/**
	 * Devuelve el username
	 *
	 * @return	string
	 */
	function get_username()
	{
		return $this->ci->session->userdata('username');
	}
        
    function get_username_by_id($user_id) {
       //$user = $this->ci->users->get_user_by_id($user_id, TRUE) ;
	   
	   if(!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {
	   		return $user->username;
	   } else {
	   	return null;
	   }
       
   }
                  /**
               * Banea al usuario una vez que este alcanzo el limite maximo de logins fallidos
               * @param type $user_id
               * @param type $reason 
               */ 
                  function ban_user_failed_login($user_id, $reason)
                  {
                          $this->ci->users->ban_user($user_id, $reason);
                  }
                  /**
               * Muestra si usuario cumplio con el tiempo de BAN establecido tras alcanzar el intento de logins fallidos
               * @param type $user_id 
               */
                  function tiempo_ban_cumplido($user)
                  {
                          $ip = $user->last_ip;
                          $username = $user->username;
                          $tiempo_de_ban = $this->ci->config->item('login_ban_time','auth_frr');
                          
                          if($this->ci->users->ban_time_cumplido($ip, $username, $tiempo_de_ban))
                              return true;
                          else
                              return false;
                  }

	/**
	 * Crea un nuevo usuario en el sistema
	 * Devuelve user_id, username, password, email, new_email_key (si existe).
	 *
	 * @param	string
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	array
	 */
	function create_user($username, $email, $password, $email_activation, $empresa_id, $role_id)
	{
        //Se chequea que el username no sea vacio y que no este disponible en el sistema
		if ((strlen($username) > 0) AND !$this->ci->users->is_username_available($username)) {
			//$this->error = array('username' => 'auth_username_in_use');
            $this->error['username'] = 'auth_username_in_use';

		} 
        //Se chequea que el email este disponible
        if (!$this->ci->users->is_email_available($email)) 
        {
			//$this->error = array('email' => 'auth_email_in_use');
            $this->error['email'] = 'auth_email_in_use';

		} 
        //Si no hay errores creamos la cuenta
        if(empty($this->error)) 
        {
			// Se hashea el password usando phpass
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'auth_frr'),
					$this->ci->config->item('phpass_hash_portable', 'auth_frr'));
			$hashed_password = $hasher->HashPassword($password);

			$data = array(
                                                                        'empresa_id' => $empresa_id,
				'username'	 => $username,
				'password'	 => $hashed_password,
				'email'	 => $email,
                                                                        'role_id'       => $role_id,
				'last_ip'	 => $this->ci->input->ip_address(),
			);

			if ($email_activation) 
                                                      {
				$data['new_email_key'] = md5(rand().microtime());
			}
			if (!is_null($res = $this->ci->users->create_user($data, !$email_activation))) 
                                                      {
				$data['user_id'] = $res['user_id'];
				$data['password'] = $password;
				unset($data['last_ip']);
				return $data;
			}
		}
		return NULL;
	}
        
      function guardar_cambios_user($user_id, $username, $empresa_id, $role_id) {
           if($this->ci->users->guardar_cambios($user_id, $username)) {
               $data = array(
                   'username' => $username,
                   'empresa_id' => $empresa_id,
                   'role_id' => $role_id
               );
               
               if($this->ci->users->modificar_user($user_id, $data)) {
                   return true;
               } else {
                   return false;
               }
           }
		   return false;
     }

	/**
	 * Chequea que el usuario este disponible para el registro.
	 * Puede ser usada para validacion de form.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_username_available($username)
	{
		return ((strlen($username) > 0) AND $this->ci->users->is_username_available($username));
	}

	/**
	 * Chequea si el email esta disponible para el registro.
	 * Puede ser usada para validacion de form.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_email_available($email)
	{
		return ((strlen($email) > 0) AND $this->ci->users->is_email_available($email));
	}

	/**
	 * Cambia la direccion de mail para activacion y devuelve algunos datos sobre el usuario:
	 * user_id, username, email, new_email_key.
	 * Puede ser llamada para usuarios no activados solamente
	 *
	 * @param	string
	 * @return	array
	 */
	function change_email($email)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, FALSE))) 
                                    {

			$data = array(
				'user_id'	=> $user_id,
				'username'	=> $user->username,
				'email'		=> $email,
			);
			if (strtolower($user->email) == strtolower($email)) 
                                                      {
                                                                        // Si el mail es el mismo, se deja la key como esta
				$data['new_email_key'] = $user->new_email_key;
				return $data;

			} 
                                                      elseif ($this->ci->users->is_email_available($email)) 
                                                      {
				$data['new_email_key'] = md5(rand().microtime());
				$this->ci->users->set_new_email($user_id, $email, $data['new_email_key'], FALSE);
				return $data;

			} 
                                                      else 
                                                      {
				$this->error = array('email' => 'auth_email_in_use');
			}
		}
		return NULL;
	}

	/**
	 * Activa un usuario usando una determinada key
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function activate_user($user_id, $activation_key, $activate_by_email = TRUE)
	{
		$this->ci->users->purge_na($this->ci->config->item('email_activation_expire', 'auth_frr'));

		if ((strlen($user_id) > 0) AND (strlen($activation_key) > 0)) 
                                    {
			return $this->ci->users->activate_user($user_id, $activation_key, $activate_by_email);
		}
		return FALSE;
	}

	/**
	 * Setea un nuevo password key para el usuario y devueve data sobre el:
	 * user_id, username, email, new_pass_key.
	 * El password key puede ser usada para verificar un usuario cuando se resetea su password.
	 *
	 * @param	string
	 * @return	array
	 */
	function forgot_password($login)
	{
		if (strlen($login) > 0) 
                                    {
			if (!is_null($user = $this->ci->users->get_user_by_login($login))) 
                                                      {

				$data = array(
					'user_id'		=> $user->user_id,
					'username'		=> $user->username,
					'email'		=> $user->email,
					'new_pass_key'	=> md5(rand().microtime()),
				);

				$this->ci->users->set_password_key($user->user_id, $data['new_pass_key']);
				return $data;

			} 
                                                      else 
                                                      {
				$this->error = array('login' => 'auth_incorrect_email_or_username');
			}
		}
		return NULL;
	}

	/**
	 * Chequea si el password key es valido y el usuario autenticado
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function can_reset_password($user_id, $new_pass_key)
	{
		if ((strlen($user_id) > 0) AND (strlen($new_pass_key) > 0)) {
			return $this->ci->users->can_reset_password(
				$user_id,
				$new_pass_key,
				$this->ci->config->item('forgot_password_expire', 'auth_frr'));
		}
		return FALSE;
	}

	/**
	 * Reemplaza el password de usuario (olvidado) por uno nuevo (seteado por el usuario)
	 * y devuelve data sobre el user: user_id, username, new_password, email.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function reset_password($user_id, $new_pass_key, $new_password)
	{
		if ((strlen($user_id) > 0) AND (strlen($new_pass_key) > 0) AND (strlen($new_password) > 0)) 
                                    {

			if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) 
                                                      {

				// Se hashea el password usando phpass
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'auth_frr'),
						$this->ci->config->item('phpass_hash_portable', 'auth_frr'));
				$hashed_password = $hasher->HashPassword($new_password);

				if ($this->ci->users->reset_password(
						$user_id,
						$hashed_password,
						$new_pass_key,
						$this->ci->config->item('forgot_password_expire', 'auth_frr'))) {	
                                                                                          // Se pudo resetear correctamente

					// Borramos toda la data de autologueo del usuario
					$this->ci->load->model('auth/user_autologin');
					$this->ci->user_autologin->clear($user->user_id);

					return array(
						'user_id'		=> $user_id,
						'username'		=> $user->username,
						'email'		=> $user->email,
						'new_password'	=> $new_password,
					);
				}
			}
		}
		return NULL;
	}

	/**
	 * Cambia password de usuario (solo cuando el usuario esta logueado)
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function change_password($old_pass, $new_pass)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) 
                                    {

			// Chequea que el password viejo sea el correcto
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'auth_frr'),
					$this->ci->config->item('phpass_hash_portable', 'auth_frr'));
			if ($hasher->CheckPassword($old_pass, $user->password)) 
                                                      {			

				// Hashea el nuevo password usando phpass
				$hashed_password = $hasher->HashPassword($new_pass);

				// Reemplazamos el password viejo con el nuevo
				$this->ci->users->change_password($user_id, $hashed_password);
				return TRUE;

			} 
                                                      else 
                                                      {
                                                                        // fail. El password viejo es incorrecto y mostramos el error.
				$this->error = array('old_password' => 'auth_incorrect_password');
			}
		}
		return FALSE;
	}
                  
       function cambiar_password_admin($user_id, $new_pass) {
           
           $hasher = new PasswordHash( $this->ci->config->item('phpass_hash_strength', 'auth_frr'),
                                                             $this->ci->config->item('phpass_hash_portable', 'auth_frr'));
           
           // Hashea el nuevo password usando phpass
            $hashed_password = $hasher->HashPassword($new_pass);

            // Reemplazamos el password viejo con el nuevo
            if($this->ci->users->change_password($user_id, $hashed_password))
                return true;
            else
                return false;
       }
                  

	/**
	 * Cambia el mail (solo cuando el usuario este logueado) y devuelve data sobre el usuario:
	 * user_id, username, new_email, new_email_key.
	 * El nuevo email no puede ser usado para logueo o notificaciones hasta que este activado.
	 *
	 * @param	string
	 * @param	string
	 * @return	array
	 */
	function set_new_email($new_email, $password)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) 
                                    {

                                                      // Como solicitamos el password del usuario para poder efectuar el cambio de mail
			// Chequeamos que el password sea correcto
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'auth_frr'),
					$this->ci->config->item('phpass_hash_portable', 'auth_frr'));
			if ($hasher->CheckPassword($password, $user->password)) 
                                                      {
				$data = array(
					'user_id'	=> $user_id,
					'username'	=> $user->username,
					'new_email' => $new_email,
				);

                                                                        // Si el mail ingresado es el mismo que tiene ahora, mostramos el error.
				if ($user->email == $new_email) 
                                                                        {
					$this->error = array('email' => 'auth_current_email');

				}
                                                                        // Si vuelve a poner el mismo mail (ya complete este form antes) dejamos la key tal y como esta
                                                                        elseif ($user->new_email == $new_email) 
                                                                        {   
					$data['new_email_key'] = $user->new_email_key;
					return $data;

				} 
                                                                        //Si el mail ingresado esta disponible, mandamos por mail la key para activarlo
                                                                        elseif ($this->ci->users->is_email_available($new_email)) 
                                                                        {
					$data['new_email_key'] = md5(rand().microtime());
					$this->ci->users->set_new_email($user_id, $new_email, $data['new_email_key'], TRUE);
					return $data;

				}
                                                                        // Sino el mail esta siendo usado y mostramos el error
                                                                        else 
                                                                        {
					$this->error = array('email' => 'auth_email_in_use');
				}
			} 
                                                      else 
                                                      {															// fail
				$this->error = array('password' => 'auth_incorrect_password');
			}
		}
		return NULL;
	}
        
                  function cambiar_email_admin($user_id, $new_email) {
                      $data = array(
                                'user_id'	=> $user_id,
                                'new_email' => $new_email,
                        );
                       //Si el mail ingresado esta disponible, mandamos por mail la key para activarlo
                      if ($this->ci->users->is_email_available($new_email))  {
                            $data['new_email_key'] = md5(rand().microtime());
                            $this->ci->users->set_new_email($user_id, $new_email, $data['new_email_key'], TRUE);
                            return $data;

                     } else  {
                            // Sino el mail esta siendo usado y mostramos el error
                            //$this->error = array('email' => 'auth_email_in_use');
                            $this->error = array('email_en_uso' => 'El email ingresado ya esta siendo utilizado');
                            return NULL;
                    }
                  }

	/**
	 * Activa un nuevo email si la direccion de correo es valida.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function activate_new_email($user_id, $new_email_key)
	{
		if ((strlen($user_id) > 0) AND (strlen($new_email_key) > 0)) 
                                    {
			return $this->ci->users->activate_new_email(
					$user_id,
					$new_email_key);
		}
		return FALSE;
	}

	/**
	 * Un usuario puede darse de baja del sistema (solamente cuando este logueado)
	 *
	 * @param	string
	 * @return	bool
	 */
	function delete_user($password)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) 
                                    {

			// Chequeamos que el password ingresado sea el correcto
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'auth_frr'),
					$this->ci->config->item('phpass_hash_portable', 'auth_frr'));
			if ($hasher->CheckPassword($password, $user->password))
                                                      {
				$this->ci->users->delete_user($user_id);
				$this->logout();
				return TRUE;

			} 
                                                      else 
                                                      {															// fail
				$this->error = array('password' => 'auth_incorrect_password');
			}
		}
		return FALSE;
	}
        
        function delete_user_admin($user_id = NULL) {
            if($user_id) {
                if($this->ci->users->delete_user($user_id)) {
                    return true;
                }
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

	/**
	 * Guarda la data para el autologueo del usuario
	 *
	 * @param	int
	 * @return	bool
	 */
	private function create_autologin($user_id)
	{
		$this->ci->load->helper('cookie');
		$key = substr(md5(uniqid(rand().get_cookie($this->ci->config->item('sess_cookie_name')))), 0, 16);

		$this->ci->load->model('auth/user_autologin');
		$this->ci->user_autologin->purge($user_id);

		if ($this->ci->user_autologin->set($user_id, md5($key))) 
                                    {
			set_cookie(array(
					'name' 	=> $this->ci->config->item('autologin_cookie_name', 'auth_frr'),
					'value'	=> serialize(array('user_id' => $user_id, 'key' => $key)),
					'expire'	=> $this->ci->config->item('autologin_cookie_life', 'auth_frr'),
			));
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Borra la data de autologueo del usuario
	 *
	 * @return	void
	 */
	private function delete_autologin()
	{
		$this->ci->load->helper('cookie');
		if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'auth_frr'), TRUE)) 
                                    {

			$data = unserialize($cookie);

			$this->ci->load->model('auth/user_autologin');
			$this->ci->user_autologin->delete($data['user_id'], md5($data['key']));

			delete_cookie($this->ci->config->item('autologin_cookie_name', 'auth_frr'));
		}
	}

	/**
	 * Loguea al usuario automaticamente si presenta datos de autologueo correctos.
	 *
	 * @return	void
	 */
	private function autologin()
	{
		if (!$this->is_logged_in() AND !$this->is_logged_in(FALSE)) 
                                    {			
                        		// not logged in (as any user)

			$this->ci->load->helper('cookie');
			if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'auth_frr'), TRUE)) 
                                                      {

				$data = unserialize($cookie);

				if (isset($data['key']) AND isset($data['user_id'])) 
                                                                        {

					$this->ci->load->model('auth/user_autologin');
					if (!is_null($user = $this->ci->user_autologin->get($data['user_id'], md5($data['key'])))) 
                                                                                          {

						// Logueamos al usuario
                                                $configuracion['user_id'] = $user->user_id;
                                                $configuracion['username'] = $user->username;
                                                $configuracion['empresa_id'] = $user->empresa_id;
                                                $configuracion['status'] = ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED;
                                                $configuracion['es_admin'] = $user->es_admin;
												$configuracion['role_id'] = $user->role_id;

                                                $this->ci->session->set_userdata($configuracion);

                                                // Renovamos la cookie del usuario para prevenir que expire
						set_cookie(array(
								'name' 		=> $this->ci->config->item('autologin_cookie_name', 'auth_frr'),
								'value'		=> $cookie,
								'expire'	=> $this->ci->config->item('autologin_cookie_life', 'auth_frr'),
						));

						$this->ci->users->update_login_info(
								$user->user_id,
								$this->ci->config->item('login_record_ip', 'auth_frr'),
								$this->ci->config->item('login_record_time', 'auth_frr'));
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}

	/**
	 * Chequea si los intentos de login exceden el maximo permitido (especificado en la config)
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_max_login_attempts_exceeded($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'auth_frr')) 
                                    {
			$this->ci->load->model('auth/login_attempts');
			return $this->ci->login_attempts->get_attempts_num($this->ci->input->ip_address(), $login)
					>= $this->ci->config->item('login_max_attempts', 'auth_frr');
		}
		return FALSE;
	}
                  
                  /**
                * Avisa al usuario que solo le resta un intento antes de que se bloquee la cuenta
                * @param type $login
                * @return type 
                */
                  function is_last_attempt($login)
                  {
                      $this->ci->load->model('auth/login_attempts');
                      if(($this->ci->config->item('login_max_attempts', 'auth_frr') - $this->ci->login_attempts->get_attempts_num($this->ci->input->ip_address(), $login)) == 2)
                      {
                          return TRUE;
                      }
                      
                      return FALSE;
                  }

	/**
	 * Aumenta el numero de intentos fallidos para una determinada IP y login
	 * (En el caso de que se registren el numero de intentos fallidos)
	 *
	 * @param	string
	 * @return	void
	 */
	private function increase_login_attempt($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'auth_frr')) {
			if (!$this->is_max_login_attempts_exceeded($login)) {
				$this->ci->load->model('auth/login_attempts');
				$this->ci->login_attempts->increase_attempt($this->ci->input->ip_address(), $login);
			}
		}
	}

	/**
	 * Elimina los registros de intentos de ingreso fallido para una determinada IP y login
	 * (En el caso de que se registren el numero de intentos fallidos)
	 *
	 * @param	string
	 * @return	void
	 */
	private function clear_login_attempts($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'auth_frr')) {
			$this->ci->load->model('auth/login_attempts');
			$this->ci->login_attempts->clear_attempts(
					$this->ci->input->ip_address(),
					$login,
					$this->ci->config->item('login_attempt_expire', 'auth_frr'));
		}
	}
}
