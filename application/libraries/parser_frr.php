<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parser_frr {
	
	protected $campos;
	
	public function __construct() {
        $this->CI = & get_instance();
		$this->_load_config_file();
		
		$this->CI->load->model('admin/templates');
    }

	function parse_custom_tags($template) {
		$forms_sistema = $this->CI->administracion_frr->get_forms();
		
		//Solo seguimos procesando en el caso que exista al menos un form en el sistema
		if(!empty($forms_sistema)) {
			//Buscamos el tag que define el contenido del template
			/**
			 * TAG FORM
			 */
			//El tag sera de la forma {$form propiedad="valor" $}
			$tag_form = '/(?<nombre>\{\$form\s?.+\s?\$\})/';
			if(preg_match($tag_form, $template, $tag)) {
				//Si se encontro el tag vamos en busca de los parametros
				
				//Recorremos los parametros disponibles para este tag
				//NOTA: Definidos en la config de esta librerias
				foreach ($this->param_form as $p) {
					$regex = '/\s?' . $p . '\s*=(?:\"|\')\s?(?<valor>[\w]+)\s?(?:\"|\')/';
					preg_match($regex, $tag['nombre'], $parametros[$p]);
				}
				
				//Recorremos la lista de parametros utilizados en el tag
				foreach ($parametros as $param => $valor) {
					if(!empty($valor)) {
						$this->$param = $valor['valor'];
					}
				}
				//Solo parseamos si se especifico un valor en el parametro forms_nombre en el tag Forms
				if($this->forms_nombre) {
					$form_id = $this->CI->administracion_frr->get_form_id_by_nombre($this->forms_nombre);
					$fields_grupo_fields = $this->CI->administracion_frr->get_fields_grupo_fields_by_form_name($this->forms_nombre);
					
					//En caso que no se haya especificado un entry_id
					//obtenemos todo el contenido del form especificado
					if(!isset($this->entry_id)) {
						$contenido = $this->CI->templates->get_contenido_by_form($fields_grupo_fields, $form_id);
					}
					//Si se especifico un entry_id buscamos una entrada unica
					else {
						$contenido = $this->CI->templates->get_contenido_by_form_y_entry_id($fields_grupo_fields, $form_id, $this->entry_id);
					}

					foreach($contenido->result() as $k => $entrada) {	
						//Este proceso solo hacemos una vez ya que los campos van a ser los mismos para todos
						//Se hace de esta manera para facilitar la forma del parseo
						foreach($entrada as $nombre_field => $valor) {						
							//Obtenemos el nombre de cada una de las columnas encontradas con la forma field_id_NUM
							if(preg_match('/field_id_[\d]+/', $nombre_field)) {
								//Limpiamos el nombre para que solo quede el ID del field
								$id_field = preg_replace('/field_id_/', '', $nombre_field);
								//Obtenemos el nombre real del field
								$nombre_real_field = $this->CI->administracion_frr->get_nombre_field_by_id($id_field);
								$this->campos[$entrada->entry_id][$nombre_real_field] = $valor;
							} else {
								//Campos comunes a todas las entradas
								$this->campos[$entrada->entry_id][$nombre_field] = $valor;
							}
						}
					}
					
				}
				
				//Una vez terminado el procesamiento quitamos el tag
				$template = preg_replace($tag_form, "", $template);
				/**
				 * FIN TAG FORM
				 */
			}
		}
		return $template;
	}

	private function _load_config_file()
	{
		if ( ! @include(APPPATH.'config/template'.EXT))
		{
			return FALSE;
		}
		foreach($parametros_tags_form as $p) 
		{
			$this->param_form[] = $p;
		}
		
		foreach ($tags_custom_disponibles as $t) {
			$this->tags_custom[] = $t;
		}

		return true;
	}
	
	function get_campos() {
		return $this->campos;
	}
}