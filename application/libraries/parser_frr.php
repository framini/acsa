<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parser_frr {
	
	protected $campos;
	protected $num_tags;
	protected $n_contenido;
	
	public function __construct() {
        $this->CI = & get_instance();
		$this->_load_config_file();
		
		$this->CI->load->model('admin/templates');
    }

	function parse_custom_tags($template) {
		$forms_sistema = $this->CI->administracion_frr->get_forms();
		
		//Solo seguimos procesando en el caso que exista al menos un form en el sistema
		if(!empty($forms_sistema)) {
			
			/**
			 * Orden de parseo
			 * 1. Variables
			 * 2. tags
			 */
			
			/**
			 * Primero parseamos las variables
			 */
			 
			 #Variables de segmento de URI
			 #Forma {{ segmento_1 }}
			 $segmento_uri = '/\{\{\s?segmento_\d\s?\}\}/';
			 preg_match_all($segmento_uri, $template, $segmentos);
			 
			 foreach ($segmentos[0] as $key => $value) {
			 	//Obtenemos el numero del segmento
				 preg_match('/\d/', $value, $num);
				 $sg = '/\{\{\s?segmento_' . $num[0] . '\s?\}\}/';
				 //reemplazamos el tag del segmento por el valor puesto en la URI
				 $template = preg_replace($sg, $this->CI->uri->segment($num[0]), $template);
			 }
			 #fin variable segmentos
			 
			 /**
			  * Una vez parseadas las variables seguimos con los tags
			  */

			//Buscamos el tag que define el contenido del template
			/**
			 * TAG FORM
			 */
			//El tag sera de la forma {$form propiedad="valor" $}
			$tag_form = '/(?<nombre>\{\$form\s?.+\s?\$\})/';

			if($this->num_tags = preg_match_all($tag_form, $template, $tag)) {
				//print_r($tag['nombre']);die();
				//Si se encontro el tag vamos en busca de los parametros
				
				//Recorremos los parametros disponibles para este tag
				//NOTA: Definidos en la config de esta librerias
				foreach ($this->param_form as $p) {
					$regex = '/\s?' . $p . '\s*=(?:\"|\')\s?(?<valor>[\w]+)\s?(?:\"|\')/';
					$i = 0;
					foreach ($tag['nombre'] as $key => $t) {
						preg_match_all($regex, $tag['nombre'][$i], $parametros[$key][$p]);
						$i++;
					}
					
				}
				
				//print_r($parametros);die();
				
				//foreach ($tag['nombre'] as $key => $t) {
					//Recorremos la lista de parametros utilizados en el tag
					//y definimos las variables que se corresponden con los nombres de los tags
					$ind = 0;
					foreach ($parametros as $param => $valor) {
						foreach ($valor as $key => $value) {
							//echo $param;
							//echo $key;
							//print_r($value['valor'][0]); die();
							
							//Funca
							$variable = $key . "_" . $param;
							$this->$variable = $value['valor'][0];
							//
							
							//echo $this->$key[$param];
						}
						
						/*if(!empty($valor)) {
							$this->$param[$key] = $valor['valor'];
						}*/
						$ind++;
					}
					//die();
				//}
				//die();

				//echo $this->forms_nombre_0; die();
				
				
				$form_id = NULL;
				$fields_grupo_fields = NULL;
				$contenido = NULL;

				//Iteramos sobre los tags presentes en el documento
				for ($i=0; $i < $this->num_tags; $i++) {
					/*$fn = "forms_nombre_" . $i;
					echo $this->$fn;*/
					//Iteramos sobre los parametros de cada tag
					foreach ($parametros[$i] as $parametro => $valor) {
						//Creamos el string que va a representar el parametro
						//Ejemplo: $forms_nombre_0
						$p = $parametro . "_" . $i;
						
						//Si el parametro que estamos procesando es el que especifica el nombre del form
						if($parametro == "forms_nombre") {
							
							//Obtenemos su form_id
							$form_id = $this->CI->administracion_frr->get_form_id_by_nombre($this->$p);
							//Obtenemos su grupo de fields
							$fields_grupo_fields = $this->CI->administracion_frr->get_fields_grupo_fields_by_form_name($this->$p);

						} else if($parametro == "entry_id" && $form_id && $fields_grupo_fields) {
							//En caso que no se haya especificado un entry_id
							//obtenemos todo el contenido del form especificado
							if(!isset($this->$p)) {
								$contenido = $this->CI->templates->get_contenido_by_form($fields_grupo_fields, $form_id);
							}
							//Si se especifico un entry_id buscamos una entrada unica
							else {
								//echo $this->$p;
								$contenido = $this->CI->templates->get_contenido_by_form_y_entry_id($fields_grupo_fields, $form_id, $this->$p);
							}
						} else if($parametro == "contenido") {
							//Si se especifico el parametro contenido=""
							$this->n_contenido[$i] = $this->$p;
						}
					}//end for
					
					//print_r($contenido);
					
					if($contenido) {
						foreach($contenido->result() as $k => $entrada) {
							//print_r($entrada);	
							//Se hace de esta manera para facilitar la forma del parseo
							foreach($entrada as $nombre_field => $valor) {						
								//Obtenemos el nombre de cada una de las columnas encontradas con la forma field_id_NUM
								//echo $entrada->entry_id;
								if(preg_match('/field_id_[\d]+/', $nombre_field)) {
									//Limpiamos el nombre para que solo quede el ID del field
									$id_field = preg_replace('/field_id_/', '', $nombre_field);
									//Obtenemos el nombre real del field
									$nombre_real_field = $this->CI->administracion_frr->get_nombre_field_by_id($id_field);
									$this->campos[$i][$entrada->entry_id][$nombre_real_field] = $valor;
								} else {
									//Campos comunes a todas las entradas
									$this->campos[$i][$entrada->entry_id][$nombre_field] = $valor;
								}
							}
						}
					}
				}
				
				//Solo parseamos si se especifico un valor en el parametro forms_nombre en el tag Forms
				/*if($this->forms_nombre) {
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
					
					//Si se especifico el parametro contenido=""
					if(isset($this->contenido)) {
						$this->n_contenido = $this->contenido;
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
					
				}*/
				
				//Una vez terminado el procesamiento quitamos los tag
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
	
	function get_num_tags() {
		return $this->num_tags;
	}
	
	function get_nombre_contenido() {
		return $this->n_contenido;
	}
}