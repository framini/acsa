<?php
/**
 * @name subootmpl
 * @author Chris Duell
 * @author_url http://www.subooa.com.au
 * @version 2.0
 * @license GPL
 *
 */
class Template
{
	var $CI;

	var $css_raw = '';
	var $css_load = '';
	var $js_raw = '';
	var $js_load = '';
	var $messages = array('success' => array(), 'notice' => array(), 'warning' => array());
	
	var $template;
	var $final_template;
	var $nombre_file;
	
	var $param;
	var $tags_custom;
	

	public function __construct($config = array())
	{
                                    
		$this->CI =& get_instance();
		$this->CI ->load->library('auth_frr');
                
		if (count($config) > 0) {
			$this->initialize($config);
		} else {
			$this->_load_config_file();
		}
		
		$this->data['user'] = $this->CI->auth_frr->get_username();
        $this->CI->load->library('auth_frr');
        if($this->CI->auth_frr->is_logged_in()) {
            //Agregamos info al  array data sobre el tipo de empresa del usuario logueado
            $this->data['warrantera'] = $this->CI->auth_frr->is_warrantera() ? true : null;
            $this->data['argclearing'] = $this->CI->auth_frr->is_argclearing() ? true : null;
		}
		
		//Cargamos contenido default para admins	
		if($this->CI->auth_frr->es_admin()) {	
			$this->data['admin'] = true;			
		}
		
		//Usado para filtrar contenido solo para admins en el template index.php
		$this->CI->load->library('administracion_frr');	
		$this->data['forms'] = $this->CI->administracion_frr->get_forms();
	}


	/**
	 * Initialize the template base preferences
	 *
	 * Accepts an associative array as input, containing display preferences
	 *
	 * @access	public
	 * @param	array	config preferences
	 * @return	void
	 */
	function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			$this->$key = $val;
		}
	}
	
	
	/**
	 * Load template specific config items 
	 * from config/subooatmpl.php
	 *
	 * including loading up default css, js and head tags
	 */
	private function _load_config_file()
	{
		if ( ! @include(APPPATH.'config/template'.EXT))
		{
			return FALSE;
		}

		foreach($template_conf as $citem => $cval)
		{
			$this->data[$citem] = $cval;
		}
		unset($tempalte_conf);
		
		foreach($template_file_config as $citem => $cval)
		{
			$this->data[$citem] = $cval;
		}
		unset($template_file_config);
		
		
		// display the profiler if in dev mode
		if($this->data['devmode']){
			$this->CI->output->enable_profiler(TRUE);
		}


		foreach($template_css as $css)
		{
			$this->add_css($css);
		}
		unset($tempalte_css);


		foreach($template_js as $js)
		{
			$this->add_js($js);
		}
		unset($tempalte_js);


		foreach($template_head as $head)
		{
			$this->add_head($head);
		}
		unset($tempalte_head);
		
		foreach($parametros_tags_form as $p) 
		{
			$this->param[] = $p;
		}
		
		foreach ($tags_custom_disponibles as $t) {
			$this->tags_custom[] = $t;
		}

		return true;
	}
		
		
	
	/**
	 * Load the content for the main area of the page, and store
	 * in the data array to be later sent to the template
	 */
	function set_content($view, $data = array()){
		
		//TODO: Ver alguna forma de crear el menu de forma dinamica asi no se cargan datos innecesarios
		//Dejamos los permisos asociados al usuario
		$this->data['permisos'] = $this->CI->roles_frr->permisos_role();
		$this->data['forms'] = $this->CI->administracion_frr->get_forms();
		$data['gestiones_disponibles'] = $this->CI->roles_frr->gestiones_disponibles('seguridad');
		
		$this->data['content'] = $this->CI->load->view($view, $data, true);
        
	}
	
	
	/**
	 * Clears all CSS. Raw and scripts
	 */
	function clear_css(){
		
		$this->css_raw = '';
		$this->css_scripts = '';
		
	}
	
	
	/**
	 * Add CSS
	 * 
	 * By default, the CSS will be loaded using the normal <link> method
	 * Optionally, you can choose to have the contents of the file dumped 
	 * straight to screen to reduce the number of resources the browser
	 * needs to load at run time
	 */
	function add_css($css, $load = true){
		
		if($load){
			
			$this->css_load .= '<link href="'.$this->CI->config->item('base_url') . $this->data['assets_dir'] . 'css/' . $css . '.css?'
				.filemtime($this->data['assets_dir'] . 'css/' . $css . '.css')
				.'" media="screen" rel="stylesheet" type="text/css" />';
		
		} else {

			$css_contents = @implode(file($this->CI->config->item('base_url') . $this->data['assets_dir'] . 'css/' . $css . '.css', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
		
			$this->css_raw .= $css_contents;

		}
		
	}
	
	
	/**
	 * Clears all JS. Raw and scripts
	 */
	function clear_js(){
		
		$this->data['js'] = '';
		
	}
	
	
	/**
	 * Add CSS
	 * 
	 * By default, the CSS will be loaded using the normal <link> method
	 * Optionally, you can choose to have the contents of the file dumped 
	 * straight to screen to reduce the number of resources the browser
	 * needs to load at run time
	 */
	function add_js($js, $load = true){
		
		if($load){
		
			$this->js_load .= '<script src="'.$this->CI->config->item('base_url') . $this->data['assets_dir'] . 'js/' . $js . '.js?'
				.filemtime($this->data['assets_dir'] . 'js/' . $js . '.js')
				.'" type="text/javascript"></script>';

		} else {
		
			$js_contents = @implode(file($this->CI->config->item('base_url') . $this->data['assets_dir'] . 'js/' . $js . '.js', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

			$this->js_raw = $js_contents;
		
		}
		
	}
	
	
	/**
	 * Clear all data in the head
	 */
	function clear_head(){
		
		$this->data['head'] = '';
		
	}
	
	
	/**
	 * Add tag to head
	 */
	function add_head($head){
		
		$this->data['head'] .= $head;
		
	}
	
	
	/**
	 * Adds a message to the current page stack
	 * Available types are success, notice and warning
	 */
	function add_message($type, $message){
	
		$this->messages[$type][] = $message;
	
	}
	
	
	/**
	 * Serves purely as a wrapper for the CI flashdata
	 * Just to keep syntax organised
	 */
	function set_flashdata($type, $message){
	
		$this->CI->session->set_flashdata($type, $message);
		
	}
	
	
	/**
	 * Formats the messages added to the stack, 
	 * and any success, notice or warning messages 
	 * that were added via session->flashdata
	 */
	function prepare_messages(){
		
		foreach($this->messages as $type => $messages){
			
			// add flash data for this type to the stack
			$flash = $this->CI->session->flashdata($type);
			if($flash != ''){
				$messages[] = $flash;
			}
			
			// if there's messages of this type, prepare for printing
			if(sizeof($messages)){
				$this->data['messages'] .= '<ul class="messages '.$type.'">';
			
				foreach($messages as $message){
					$this->data['messages'] .= '<li>'.$message.'</li>';
				}
			
				$this->data['messages'] .= '</ul>';
			}
			
		}
	
	}
	
	
	
	/**
	 * Combine and organise the raw and loaded
	 * javascript and css files
	 */
	function prepare_jcss(){

		// combine the raw and loaded css
		if(strlen($this->css_raw)){
			$this->data['css'] .= '<style type="text/css">' . $this->css_raw . '</style>';
		}
		if(strlen($this->css_load)){
			$this->data['css'] .= $this->css_load;
		}
	
		// combine the raw and loaded css
		if(strlen($this->js_raw)){
			$this->data['js'] .= '<script lang="text/javascript">' . $this->js_raw . '</script>';
		}
		if(strlen($this->js_load)){
			$this->data['js'] .= $this->js_load;
		}
			
	}
	
	
	
	/**
	 * Construimos la vista en base al template definido
	 */
	function build(){
	
		$this->prepare_jcss();
		$this->prepare_messages();
	
		$this->CI->load->view('templates/'.$this->data['template'].'/index.php', $this->data);
		
	}
	
	function run_template_engine($template_group, $template, $template_extension) {

		$this->obtener_y_parsear($template_group, $template, $template_extension);
		
		//Paginacion
		
		// load pagination class
	    $this->CI->load->library('pagination');
		//die(base_url() . $template_group . '/' . $template);
	    /*$config['base_url'] = base_url() . $template_group . '/' . $template;
	    $config['total_rows'] = $this->CI->db->count_all('christian_books');
	    $config['per_page'] = '5';
	    $config['full_tag_open'] = '<p>';
	    $config['full_tag_close'] = '</p>';*/
		
		//Tratamiento extras
		//.....
		
		$this->final_template = $this->template;
		
		//Cargamos la libreria Twig
		$this->CI->load->library('twig');
		
		//Variables globales para usar dentro de los templates
		$data['title'] = "Testing Twig!!";
		
		/*$data['navigation'] = array('menu1' => array(
													'href' => "http://www.google.com",
													'caption' => "texto fruta",
													'titulo' => "MENU 1",
													'width' => "DASDSADSADSADSADSAD"
 													),
 									'menu2' => array(
													'href' => "http://www.google.com",
													'caption' => "texto fruta",
													'titulo' => "MENU 2",
													'width' => "DASDSADSADSADSADSAD"
 													),
 									'menu3' => array(
													'href' => "http://www.google.com",
													'caption' => "texto fruta",
													'titulo' => "MENU 3",
													'width' => "DASDSADSADSADSADSAD"
 													),
 									'menu4' => array(
													'href' => "http://www.google.com",
													'caption' => "texto fruta",
													'titulo' => "MENU 4",
													'width' => "DASDSADSADSADSADSAD"
 													),
		);*/
		
		/**
		 * Una vez parseados los tags y obtenida la informacion procedemos a definir las
		 * variables que permitiran mostrar el contenido de los tags via variables-tag
		 */
		if(!is_null($contenido_tags = $this->CI->parser_frr->get_campos()) && !is_null($nombres_contenido = $this->CI->parser_frr->get_nombre_contenido())) {
			//Primero obtenemos el array de campos-valor via get_campos()
			//Despues obtenemos el valor asignado al atributo contenido que nos permitira
			//definir la variable que almacenara el contenido de la entrada.
			//El parametro contenido permite que convivan varios tags dentro de una misma pagina
			foreach ($contenido_tags as $key => $arreglo) {
				foreach ($arreglo as $entry_id => $entrada) {
					foreach($entrada as $nombre_field => $valor) {
						$var_nombre_contenido = $nombres_contenido[$key];
						//Definimos la variable a usar en el template
						//Accedemos a ella de la forma entrada.nombre_field
						$data[$var_nombre_contenido][$entry_id][$nombre_field] = $valor;
						if($nombre_field == 'autor_id' ) {
							$data[$var_nombre_contenido][$entry_id]['autor'] = $this->CI->auth_frr->get_username_by_id($valor);
						}
					}
				}
				
			}
		}

		//Mostramos el template
		$this->CI->twig->display("frr_temp/" . $this->nombre_file, $data);
	}
	
	function obtener_y_parsear($template_group, $template, $extension = NULL, $actualizando = NULL) {
		
		//Primero obtenemos el template
		$this->template = $this->obtener_template($template_group, $template);
		
		$this->CI->load->library('parser_frr');
		
		//TODO: Poder seleccionar si el parseo del PHP se hace en el input o el output.
		//Asi como esta -> input
		if( $extension == "css") {
			$this->template = '<?php header("Content-type: text/css"); ?>' . $this->template;
			$this->template = $this->CI->parser_frr->parsear_php_input( $this->template );
		}
		
		//Parseamos los tags custom que nos dicen de donde hay que sacar el contenido
		$this->template = $this->CI->parser_frr->parse_custom_tags($this->template);

		//Creamos el arreglo de propiedas que seran usadas para crear el file	
		$tdata = array(
			'template_group'	 => $template_group ,
			'template_name'		 => $template,
			'template_data'		 => $this->template,
			'template_extension' => $extension
		);

		//Creamos el file que luego sera parseado		
		$this->nombre_file = $this->update_template_file($tdata, $actualizando, $extension);
	}
	
	function obtener_template($template_group, $template) {
		$this->CI->load->model('admin/templates');
		return $this->CI->templates->obtener_template($template_group, $template);
	}
	
	function obtener_ruta_template($grupo_template, $template, $extension) {
		
		$basepath = $this->data['ruta_default'];
		
		if(!@file_exists($basepath . "/" . $grupo_template . "/" . $template . "." . $extension)) {
			
			//En caso de no existir el file del template pasado como parametro, nos fijamos si existe tanto el grupo como el template
			if( !is_null( $template_group_id = $this->CI->administracion_frr->grupo_template_exists_by_name($grupo_template) ) ) {
				if ( $this->CI->administracion_frr->template_exists_by_name($template, $template_group_id) ) {
					//Si llegamos hasta este punto quiere decir que tenemos que crear el file correspondiente al template
					$this->obtener_y_parsear($grupo_template, $template, $extension);
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
		}
		
		//Si llegamos hasta este punto devolvemos la ruta para acceder al file correspondiente al template pasado como parametro
		return $grupo_template . "/" . $template;

	}
	
	function obtener_ruta_fisica_template($grupo_template, $template, $extension = NULL) {
		
		$basepath = $this->data['ruta_default_short'];
		
		//Si existe un template, creamos/actualizamos el file fisico que lo representa y devolvemos la ruta 
		if ( !is_null( $template_group_id = $this->CI->administracion_frr->grupo_template_exists_by_name($grupo_template)) ) {
			if ( $this->CI->administracion_frr->template_exists_by_name($template, $template_group_id) ) {
				
				$template_extension = $this->CI->administracion_frr->get_extension_template($template, $template_group_id);
				
				//Si llegamos hasta este punto quiere decir que tenemos que actualizar el file correspondiente al template
				$this->obtener_y_parsear($grupo_template, $template, $template_extension, TRUE);
				
				return $basepath . $grupo_template . "/" . $template . "." . $template_extension;
			}
			
		}
		
	}
	
	/**
	 * Metodo utilizado para borrar el template fisico
	 */
	function borrar_fis_template($data) {
		$basepath = $this->data['ruta_default'];
		$filename = $data['template_name'] . "." .  $data['template_extension'];
		
		if(@file_exists($basepath . "/" . $data['template_group'] . "/" . $filename)) {
			unlink($basepath . "/" . $data['template_group'] . "/" . $filename);
			
			return true;
		} else {
			return NULL;
		}
	}
	
	function borrar_fis_grupo_template($data) {
		$basepath = $this->data['ruta_default'];
		
		if(@file_exists($basepath . "/" . $data['template_group'])) {
			$this->rrmdir($basepath . "/" . $data['template_group']);
			return true;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Helper para borrar un folder cuando no esta vacio
	 */
	function rrmdir($dir) {
	   if (is_dir($dir)) {
	     $objects = scandir($dir);
	     foreach ($objects as $object) {
	       if ($object != "." && $object != "..") {
	         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
	       }
	     }
	     reset($objects);
	     rmdir($dir);
	   }
	 }
	
	
	/**
	 * Metodo utilizado para crear un file en base al template que pasamos
	 * Solo se usa para poder ser parseado usando la libreria Twig
	 */
	function update_template_file($data, $actualizando = NULL, $extension = NULL)
	{
		$basepath = $this->data['ruta_default'];
		
		
		//Chequeamos que el directorio temporal exista
		if(@file_exists($basepath)) {
			//Chequeamos que el directorio sea writeable
			if ( ! @is_dir($basepath) OR ! is_really_writable($basepath))
			{
				return FALSE;
			} else {
				//Chequeamos que el directorio del grupo de templates exista
				if(@file_exists($basepath . "/" . $data['template_group'])) {
					//Chequeamos que el folder del grupo de templates sea realmente un folder y se writeable
					if ( ! @is_dir($this->data['ruta_default'] . "/" . $data['template_group']) OR ! is_really_writable($this->data['ruta_default'] . "/" . $data['template_group']))
					{
						return FALSE;
					}
				} else {
					mkdir($basepath . "/" . $data['template_group']);
				}
			}
			
		} else {
			//Si no existe lo creamos con permisos chmod 0777
			mkdir($basepath);
			//Lo mismo para el directorio del grupo de templates
			mkdir($basepath . "/" . $data['template_group']);
		}
		
		//print_r($data); die();
		
		//Establecemos la ruta default en base al nombre del grupo de templates usado
		$basepath .=  "/" . $data['template_group'];
		
		if(isset($data['template_extension'])) {
			$filename = $data['template_name'] . "." .  $data['template_extension'];
		} else {
			//Le damos la extension fijada en la config template al archivo a crear/buscar
			$filename = $data['template_name'] . "." .  $this->data['extension_file'];
		}
		
		//Chequeamos si existe o no el file. En caso de existir no hay sentido volver a crearlo
		//a menos que lo estemos actualizando
		/*if(file_exists($basepath . "/" . $filename) && !(isset($actualizando) && $actualizando)) {
			return $data['template_group'] . "/" . $filename;
		}*/
		
		if ( ! $fp = @fopen($basepath.'/'.$filename, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
			return FALSE;
		} else {
			flock($fp, LOCK_EX);
			fwrite($fp, $data['template_data']);
			flock($fp, LOCK_UN);
			fclose($fp);
			
			@chmod($basepath.'/'.$filename, FILE_WRITE_MODE); 
		}

		return $data['template_group'] . "/" . $filename;
	}
           
}