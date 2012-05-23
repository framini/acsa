<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Router extends CI_Router {
	
	var $db;
	
	 function __construct()
    {
        parent::__construct();
    }
	
	
	//Metodo que reemplaza a uno core del framework para diferenciar  los controladores del PANEL y del sitio en general
	function _validate_request($segments)
	{
		if (count($segments) == 0)
		{
			return $segments;
		}

		// Nos fijamos si el controller solicitado existe en el root
		if (file_exists(APPPATH.'controllers/'.$segments[0].'.php'))
		{
			return $segments;
		}

		// Nos fijamos si el controller es un sub-folder
		if (is_dir(APPPATH.'controllers/'.$segments[0]))
		{
			// Set the directory and remove it from the segment array
			$this->set_directory($segments[0]);
			$segments = array_slice($segments, 1);

			if (count($segments) > 0)
			{
				// Nos fijamos si el controller existe dentro del subfolder
				if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$segments[0].'.php'))
				{
					if ( ! empty($this->routes['404_override']))
					{
						$x = explode('/', $this->routes['404_override']);

						$this->set_directory('');
						$this->set_class($x[0]);
						$this->set_method(isset($x[1]) ? $x[1] : 'index');

						return $x;
					}
					else
					{
						show_404($this->fetch_directory().$segments[0]);
					}
				}
			}
			else
			{
				// Chequeamos si el metodo esta especificado en la ruta
				if (strpos($this->default_controller, '/') !== FALSE)
				{
					$x = explode('/', $this->default_controller);

					$this->set_class($x[0]);
					$this->set_method($x[1]);
				}
				else
				{
					$this->set_class($this->default_controller);
					$this->set_method('index');
				}

				// Nos fijamos si existe un controlador default en el subfolder
				if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.'.php'))
				{
					$this->directory = '';
					return array();
				}

			}

			return $segments;
		}
		
		//-----------------------------------------------------------------------
		//Chequeamos que el primer segmento corresponda con algun template group
		//-----------------------------------------------------------------------
		//Importamos la clase para comunicarnos con la base de datos
		require_once(BASEPATH.'database/DB.php');
		
		//Instanciamos el objeto para la conexion a la BDD
		$this->db =& DB('');
		$query = "SELECT nombre AS cont FROM templates_groups WHERE nombre ='" . $segments[0] . "'";

		//Si obtenemos una coincidencia devolvemos
		if($res = $this->db->query($query)->num_rows()) {
			$clase = "sitio";
			$metodo = "index";

			$segments[0] = $clase;
			$segments[1] = $metodo;

			return $segments;
		}
		
		//-----------------------------------------------------------------------
		//Fin agregado
		//-----------------------------------------------------------------------

		//Si llegamos hasta aca significa que la URI no se correlaciona con ningun controlador
		if ( ! empty($this->routes['404_override']))
		{
			$x = explode('/', $this->routes['404_override']);

			$this->set_class($x[0]);
			$this->set_method(isset($x[1]) ? $x[1] : 'index');

			return $x;
		}
		
		// Si llegamos hasta aca lo unico que hay por hacer es mostrar el error 404
		show_404($segments[0]);
	}

	function _set_request($segments = array())
	{
		$segments = $this->_validate_request($segments);

		if (count($segments) == 0)
		{
			return $this->_set_default_controller();
		}

		$this->set_class($segments[0]);

		if (isset($segments[1]))
		{
			$this->set_method($segments[1]);
		}
		else
		{
			// Esto permite a los segmentos "ruteados" identificar que el metodo
			// index por default esta siendo utilizado
			$segments[1] = 'index';
		}

		$this->uri->rsegments = $segments;
	}

}