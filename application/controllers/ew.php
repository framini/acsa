<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ew extends CI_Controller {
                  
                  function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('auth_frr');
		$this->lang->load('auth_frr');
	}
                    
	public function index()
	{
		redirect('/ew/login/');
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
			redirect('home');

		} 
        elseif ($this->auth_frr->is_logged_in(FALSE)) 
        {						
            //Logueado, pero no esta activado
			redirect('/auth/send_again/');

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
                              //Logueo exitoso
                              $user_id = $this->auth_frr->get_user_id();
                              $role_id = $this->roles_frr->get_role_id($user_id);
                              //Prueba para redireccion en base al rol de usuario
                              //La diferenciacion de usuarios se haria aca
                              //if($role_id == 1)
                              //{
                                  //redirect('restrict');
                              //}
                              //else
                              //{
                                  redirect('');
                              //}
					

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
                    {	// fAllamooo
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
	 * Muestra mensaje con flashdata
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('/ew/');
	}
}