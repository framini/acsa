<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm_Ew extends CI_Controller {
                  
    function __construct() {
		parent::__construct();

		$this->lang->load('auth_frr');
	}
                    
	public function index()
	{
		redirect('adm/ew/login/');
	}
        
     /**
	 * Loguea al usuario en el sitio
	 *
	 * @return void
	 */
	function login() {
            
		if ($this->auth_frr->is_logged_in()) 
        {
            // El usuario esta logueado asi que se lo redirecciona al index
			redirect('adm/home');

		} 
        elseif ($this->auth_frr->is_logged_in(FALSE)) 
        {						
            //Logueado, pero no esta activado
			redirect('adm/error/m');

		} 
        else 
        {
			$data['login_by_username'] = ($this->config->item('login_by_username', 'auth_frr') AND $this->config->item('use_username', 'auth_frr'));
			$data['login_by_email'] = $this->config->item('login_by_email', 'auth_frr');

			$this->form_validation->set_rules('login', 'Nombre de usuario', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');

            // Para controlar el numero de attepms de login
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

                              redirect('adm/home');

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
						redirect('adm/error/m');

					} 
                    else 
                    {	// Fallo el login. 
						foreach ($errors as $k => $v)	
                        $data['errors'][$k] = $this->lang->line($v);
					}
				}
			}
			if ($this->auth_frr->is_max_login_attempts_exceeded($login)) 
            {
                $this->load->model('users');
                $user = $this->users->get_user_by_login($login);
                if(isset ($user->user_id))
                    $this->auth_frr->ban_user_failed_login($user->user_id, "Limite de intentos excedido");
                                                                        
			}

			if ($message = $this -> session -> flashdata('message')) {
				$data['message'] = $message;
			}

			$this->load->view('auth/login_form', $data);
		}
	}


	//metodo para recuperar contraseña
	function olvide_contrasena() {

		if ($this->auth_frr->is_logged_in()) {
			redirect('');

		} elseif ($this->auth_frr->is_logged_in(FALSE)) { //Esta logueado pero no activado
			redirect('/auth/send_again/');

		} else {
			$this->form_validation->set_rules('login', 'Email o login', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {
				if (!is_null($data = $this->auth_frr->forgot_password(
						$this->form_validation->set_value('login')))) {

					$data['site_name'] = $this->config->item('website_name', 'auth_frr');

					// Send email with password activation link
					$this->_send_email('forgot_password', $data['email'], $data);

					$this->_show_message($this->lang->line('auth_message_new_password_sent'));

				} else {
					$errors = $this->auth_frr->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/forgot_password_form', $data);
		}
	}


	function reset_password()
	{
		$user_id		= $this->uri->segment(4);
		$new_pass_key	= $this->uri->segment(5);

		$this->form_validation->set_rules('new_password', 'Nueva contraseña', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'auth_frr').']|max_length['.$this->config->item('password_max_length', 'auth_frr').']|alpha_dash');
		$this->form_validation->set_rules('confirm_new_password', 'Confirmar nueva contraseña', 'trim|required|xss_clean|matches[new_password]');

		$data['errors'] = array();

		if ($this->form_validation->run()) {
			if (!is_null($data = $this->auth_frr->reset_password(
					$user_id, $new_pass_key,
					$this->form_validation->set_value('new_password')))) {

				$data['site_name'] = $this->config->item('website_name', 'auth_frr');

				// Se envia un mail con la nueva contraseña
				$this->_send_email('reset_password', $data['email'], $data);

				$this->_show_message($this->lang->line('auth_message_new_password_activated').' '.anchor('/adm/ew/login', 'Login'));

			} else {
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		} else {
			// Se intenta activar el usuario con la nueva key
			if ($this->config->item('email_activation', 'auth_frr')) {
				$this->auth_frr->activate_user($user_id, $new_pass_key, FALSE);
			}

			if (!$this->auth_frr->can_reset_password($user_id, $new_pass_key)) {
				print_r("asdsad"); die();
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		}
		$this->load->view('auth/reset_password_form', $data);
	}


    /**
	 * Funciona para mandar emails (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	function _send_email($type, $email, &$data) {
		$this -> load -> library('email');

		$this -> email -> initialize(array('protocol' => 'smtp', 'smtp_host' => 'smtp.sendgrid.net', 'mailtype' => 'html', 'smtp_user' => 'framini', 'smtp_pass' => 'montfran', 'bcc_batch_mode' => true, 'bcc_batch_size' => 3, 'smtp_port' => 587, 'crlf' => "\r\n", 'newline' => "\r\n"));

		$this -> email -> from($this -> config -> item('webmaster_email', 'auth_frr'), $this -> config -> item('webmaster_email', 'auth_frr'));
		$this -> email -> reply_to($this -> config -> item('webmaster_email', 'auth_frr'), $this -> config -> item('webmaster_email', 'auth_frr'));
		$this -> email -> to($email);
		$this -> email -> subject(sprintf($this -> lang -> line('auth_subject_' . $type), $this -> config -> item('website_name', 'auth_frr')));
		$this -> email -> message($this -> load -> view('email/' . $type . '-html', $data, TRUE));
		$this -> email -> set_alt_message($this -> load -> view('email/' . $type . '-txt', $data, TRUE));
		$this -> email -> send();
	}    
        
     /**
	 * Desloguea al usuario
	 *
	 * @return void
	 */
	function logout()
	{
		$this->auth_frr->logout();
		$this->session->sess_create();
        $this->_show_message($this->lang->line('auth_message_logged_out'));
	}
	
	/**
	 * Reemplaza el email viejo del usuario por el nuevo
	 * Se verifica al usuario por el ID y la Key enviada por email
	 *
	 * @return void
	 */
	function reset_email() {
		$user_id = $this -> uri -> segment(4);
		$new_email_key = $this -> uri -> segment(5);

		// Tratamos de restear el email
		if ($this -> auth_frr -> activate_new_email($user_id, $new_email_key)) {
			$this -> auth_frr -> logout();
			$this -> _show_message($this -> lang -> line('auth_message_new_email_activated') . ' ' . anchor('/adm/ew/login/', 'Login'));

		} else {// fail
			$this -> _show_message($this -> lang -> line('auth_message_new_email_failed'));
		}
	}
        
        
                  /**
	 * Muestra mensaje con flashdata
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('adm/ew/login');
	}
}
