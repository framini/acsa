<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('auth_frr');
		$this->lang->load('auth_frr');
	}

	function index()
	{
		if ($message = $this->session->flashdata('message')) {
			$this->load->view('auth/general_message', array('message' => $message));
		} 
                                    else
                                    {
			redirect('/auth/login/');
		}
	}

	/**
	 * Loguea al usuario en el sitio
	 *
	 * @return void
	 */
	function login()
	{
            
                                    $this->load->library('roles_frr');
                        
		if ($this->auth_frr->is_logged_in()) 
                                    {
                                                      // El usuario esta logueado asi que se lo redirecciona al index
			redirect('ew');

		} 
                                    elseif ($this->auth_frr->is_logged_in(FALSE)) 
                                    {						
                                                      //Logueado, pero no esta activado
			redirect('/auth/send_again/');

		} 
                                    else 
                                    {
			$data['login_by_username'] = ($this->config->item('login_by_username', 'auth_frr') AND
                                                                                                       $this->config->item('use_username', 'auth_frr'));
                        
			$data['login_by_email'] = $this->config->item('login_by_email', 'auth_frr');

			$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');

                                                      // Para controlar el numero de attemps de login
			if ($this->config->item('login_count_attempts', 'auth_frr') AND ($login = $this->input->post('login'))) 
                                                      {
				$login = $this->security->xss_clean($login);
			} 
                                                     else 
                                                      {
				$login = '';
			}
			$data['errors'] = array();

			if ($this->form_validation->run()) 
                                                      {								
                            			// validacion ok
				if ($this->auth_frr->login(
						$this->form_validation->set_value('login'),
						$this->form_validation->set_value('password'),
						$this->form_validation->set_value('remember'),
						$data['login_by_username'],
						$data['login_by_email'])) 
                                                                        {							
                                                                                          //// EXITOOO
                                                                                          $user_id = $this->auth_frr->get_user_id();
                                                                                          $role_id = $this->roles_frr->get_role_id($user_id);
                                                                                          //Prueba para redireccion en base al rol de usuario
                                                                                          //La diferenciacion de usuarios se haria aca
                                                                                          if($role_id == 1)
                                                                                          {
                                                                                              redirect('restrict');
                                                                                          }
                                                                                          else
                                                                                          {
                                                                                              redirect('ew');
                                                                                          }
					

				} 
                                                                        else 
                                                                        {
					$errors = $this->auth_frr->get_error_message();
					if (isset($errors['banned'])) 
                                                                                          {	
                                                                                                            // usuario baneado
						$this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);

					} 
                                                                                          elseif (isset($errors['not_activated'])) 
                                                                                          {				
                                                                                                            //usuario no activado
						redirect('/auth/send_again/');

					} 
                                                                                          else 
                                                                                          {													// fail
						foreach ($errors as $k => $v)	
                                                                                                                $data['errors'][$k] = $this->lang->line($v);
					}
				}
			}
			if ($this->auth_frr->is_max_login_attempts_exceeded($login)) 
                                                      {
                                                                        $this->load->model('users');
                                                                        $user = $this->users->get_user_by_login($login);
                                                                        //print_r($user->user_id);
                                                                        if(isset ($user->user_id))
                                                                            $this->auth_frr->ban_user_failed_login($user->user_id, "Limite de intentos excedido");
                                                                        
			}

			$this->load->view('auth/login_form', $data);
		}
	}

	/**
	 * Desloguea al usuario
	 *
	 * @return void
	 */
	function logout()
	{
		$this->auth_frr->logout();

		$this->_show_message($this->lang->line('auth_message_logged_out'));
	}

	/**
	 * Registra un usuario en el sitio
	 *
	 * @return void
	 */
	function register()
	{
		if ($this->auth_frr->is_logged_in())
                                    {
                                                      //logged in
                                                      // Si esta logueado lo redirecciona al root del sitio
			redirect('ew');

		} 
                                    elseif ($this->auth_frr->is_logged_in(FALSE)) 
                                    {
                                                       //// Logueado, pero la cuenta no esta activada
			redirect('/auth/send_again/');

		} 
                                    elseif (!$this->config->item('allow_registration', 'auth_frr')) 
                                    {	
                                                      //// El registro esta desactivado
			$this->_show_message($this->lang->line('auth_message_registration_disabled'));

		} 
                                    else 
                                    {
			$use_username = $this->config->item('use_username', 'auth_frr');
                                                      //Si el nombre de usuario es requerido, se le imponen las reglas de validacion
			if ($use_username) 
                                                      {
				$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'auth_frr').']|max_length['.$this->config->item('username_max_length', 'auth_frr').']|alpha_dash');
			}
                                                      //Reglas de validacion para los campos email, password y confirm_password
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'auth_frr').']|max_length['.$this->config->item('password_max_length', 'auth_frr').']|alpha_dash');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');

			$data['errors'] = array();

			$email_activation = $this->config->item('email_activation', 'auth_frr');

			if ($this->form_validation->run()) 
                                                      {	
                                                                         // Si ingresamos aca es porque la validacion de los campos fue exitosa
                                                                        // Tratamos de crear el nuevo usuario a traves de la libreria auth_frr.
                                                                        // Si la creacion fue exitosa devuelve un array con user y password para
                                                                        // enviarselo al usuario via email de bienvenida al sistema
				if (!is_null($data = $this->auth_frr->create_user(
						$use_username ? $this->form_validation->set_value('username') : '',
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password'),
						$email_activation))) {									// success

					$data['site_name'] = $this->config->item('website_name', 'auth_frr');
                                                                                          
                                                                                          //Si para activar la cuenta se requiere confirmar la direccion de email, ingresamos aca
					if ($email_activation) 
                                                                                          {									
                                                                                                            // Enviamos el mail de activacion
						$data['activation_period'] = $this->config->item('email_activation_expire', 'auth_frr') / 3600;

						$this->_send_email('activate', $data['email'], $data);

						unset($data['password']); // Limpia el password

						$this->_show_message($this->lang->line('auth_message_registration_completed_1'));

					} 
                                                                                         else 
                                                                                         {
						if ($this->config->item('email_account_details', 'auth_frr')) 
                                                                                                            {	
                                                                                                                            // Se envia el mail de bienvenida

							$this->_send_email('welcome', $data['email'], $data);
						}
						unset($data['password']); // Limpia el password

						$this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));
					}
				} 
                                                                        // No se pudo crear el usuario, ya sea porque el usuario o mail existia, o algun otro problema
                                                                        else
                                                                        {
					$errors = $this->auth_frr->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			
			$data['use_username'] = $use_username;
			$this->load->view('auth/register_form', $data);
		}
	}

	/**
	 * Send activation email again, to the same or new email address
	 *
	 * @return void
	 */
	function send_again()
	{
		if (!$this->auth_frr->is_logged_in(FALSE)) {							// not logged in or activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->auth_frr->change_email(
						$this->form_validation->set_value('email')))) {			// success

					$data['site_name']	= $this->config->item('website_name', 'auth_frr');
					$data['activation_period'] = $this->config->item('email_activation_expire', 'auth_frr') / 3600;

					$this->_send_email('activate', $data['email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));

				} else {
					$errors = $this->auth_frr->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/send_again_form', $data);
		}
	}
	/**
	 * Activate user account.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function activate()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Activate user
		if ($this->auth_frr->activate_user($user_id, $new_email_key)) {		// success
			$this->auth_frr->logout();
			$this->_show_message($this->lang->line('auth_message_activation_completed').' '.anchor('/auth/login/', 'Login'));

		} else {																// fail
			$this->_show_message($this->lang->line('auth_message_activation_failed'));
		}
	}

	/**
	 * Genera un codigo de reseteo (para cambiar el password) y lo envia via email al usuario
	 *
	 * @return void
	 */
	function forgot_password()
	{
		if ($this->auth_frr->is_logged_in()) 
                                    {
                                        // logged in
                                        redirect('ew');
		} 
                                    elseif ($this->auth_frr->is_logged_in(FALSE)) 
                                    {						
                                            // logged in, no activado
                                            redirect('/auth/send_again/');

		} 
                                    else 
                                    {
			$this->form_validation->set_rules('login', 'Email or login', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) 
                                                      {								
                                                                        // validation ok
				if (!is_null($data = $this->auth_frr->forgot_password($this->form_validation->set_value('login')))) 
                                                                        {

					$data['site_name'] = $this->config->item('website_name', 'auth_frr');

                                                                                         // Envia el email con el link de activacion
					$this->_send_email('forgot_password', $data['email'], $data);

					$this->_show_message($this->lang->line('auth_message_new_password_sent'));

				} 
                                                                        else 
                                                                        {
					$errors = $this->auth_frr->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/forgot_password_form', $data);
		}
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user).
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_password()
	{
		$user_id		= $this->uri->segment(3);
		$new_pass_key	= $this->uri->segment(4);

		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'auth_frr').']|max_length['.$this->config->item('password_max_length', 'auth_frr').']|alpha_dash');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

		$data['errors'] = array();

		if ($this->form_validation->run()) {								// validation ok
			if (!is_null($data = $this->auth_frr->reset_password(
					$user_id, $new_pass_key,
					$this->form_validation->set_value('new_password')))) {	// success

				$data['site_name'] = $this->config->item('website_name', 'auth_frr');

				// Send email with new password
				$this->_send_email('reset_password', $data['email'], $data);

				$this->_show_message($this->lang->line('auth_message_new_password_activated').' '.anchor('/auth/login/', 'Login'));

			} else {														// fail
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		} else {
			// Try to activate user by password key (if not activated yet)
			if ($this->config->item('email_activation', 'auth_frr')) {
				$this->auth_frr->activate_user($user_id, $new_pass_key, FALSE);
			}

			if (!$this->auth_frr->can_reset_password($user_id, $new_pass_key)) {
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		}
		$this->load->view('auth/reset_password_form', $data);
	}

	/**
	 * Change user password
	 *
	 * @return void
	 */
	function change_password()
	{
		if (!$this->auth_frr->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'auth_frr').']|max_length['.$this->config->item('password_max_length', 'auth_frr').']|alpha_dash');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->auth_frr->change_password(
						$this->form_validation->set_value('old_password'),
						$this->form_validation->set_value('new_password'))) {	// success
					$this->_show_message($this->lang->line('auth_message_password_changed'));

				} else {														// fail
					$errors = $this->auth_frr->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/change_password_form', $data);
		}
	}

	/**
	 * Change user email
	 *
	 * @return void
	 */
	function change_email()
	{
		if (!$this->auth_frr->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->auth_frr->set_new_email(
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password')))) {			// success

					$data['site_name'] = $this->config->item('website_name', 'auth_frr');

					// Send email with new email address and its activation link
					$this->_send_email('change_email', $data['new_email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_new_email_sent'), $data['new_email']));

				} else {
					$errors = $this->auth_frr->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/change_email_form', $data);
		}
	}

	/**
	 * Replace user email with a new one.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_email()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Reset email
		if ($this->auth_frr->activate_new_email($user_id, $new_email_key)) {	// success
			$this->auth_frr->logout();
			$this->_show_message($this->lang->line('auth_message_new_email_activated').' '.anchor('/auth/login/', 'Login'));

		} else {																// fail
			$this->_show_message($this->lang->line('auth_message_new_email_failed'));
		}
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 * Un usuario puede darse de baja del sistema (solamente cuando este logueado)
	 *
	 * @return void
	 */
	function unregister()
	{
		if (!$this->auth_frr->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->auth_frr->delete_user(
						$this->form_validation->set_value('password'))) {		// success
					$this->_show_message($this->lang->line('auth_message_unregistered'));

				} else {														// fail
					$errors = $this->auth_frr->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/unregister_form', $data);
		}
	}

	/**
	 * Show info message
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('/auth/');
	}

	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	function _send_email($type, $email, &$data)
	{
		$this->load->library('email');
                                    $this->email->initialize(array(
                                      'protocol' => 'smtp',
                                      'smtp_host' => 'smtp.sendgrid.net',
                                      'mailtype'  => 'html',
                                      'smtp_user' => 'framini',
                                      'smtp_pass' => 'montfran',
                                      'bcc_batch_mode' => true,
                                      'bcc_batch_size' => 3,
                                      'smtp_port' => 587,
                                      'crlf' => "\r\n",
                                      'newline' => "\r\n"
                                    ));
                                    
		$this->email->from($this->config->item('webmaster_email', 'auth_frr'), $this->config->item('website_name', 'auth_frr'));
		$this->email->reply_to($this->config->item('webmaster_email', 'auth_frr'), $this->config->item('website_name', 'auth_frr'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'auth_frr')));
		$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
		$this->email->send();
	}

	/**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */
	function _create_captcha()
	{
		$this->load->helper('captcha');

		$cap = create_captcha(array(
			'img_path'		=> './'.$this->config->item('captcha_path', 'auth_frr'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'auth_frr'),
			'font_path'		=> './'.$this->config->item('captcha_fonts_path', 'auth_frr'),
			'font_size'		=> $this->config->item('captcha_font_size', 'auth_frr'),
			'img_width'		=> $this->config->item('captcha_width', 'auth_frr'),
			'img_height'	=> $this->config->item('captcha_height', 'auth_frr'),
			'show_grid'		=> $this->config->item('captcha_grid', 'auth_frr'),
			'expiration'	=> $this->config->item('captcha_expire', 'auth_frr'),
		));

		// Save captcha params in session
		$this->session->set_flashdata(array(
				'captcha_word' => $cap['word'],
				'captcha_time' => $cap['time'],
		));

		return $cap['image'];
	}

	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
	function _check_captcha($code)
	{
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->config->item('captcha_expire', 'auth_frr')) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;

		} elseif (($this->config->item('captcha_case_sensitive', 'auth_frr') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
	function _create_recaptcha()
	{
		$this->load->helper('recaptcha');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'auth_frr'));

		return $options.$html;
	}

	/**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
	function _check_recaptcha()
	{
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'auth_frr'),
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']);

		if (!$resp->is_valid) {
			$this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

}