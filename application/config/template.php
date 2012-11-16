<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$template_conf = array(
	'template' => 'ewarrants',
	'site_name' => 'eWarrants',
	'site_title' => '',
	'devmode' => false,
	'content' => '',
	'css' => '',
	'js' => '',
	'head' => '',
	'messages' => '',
	'assets_dir' => 'assets/',
);

$template_css = array('base');

$template_js = array();

$template_head = array(
	'jquery' => '<script type="text/javascript" src="http://www.google.com/jsapi"></script>
					<script type="text/javascript">
					google.load("jquery", "1.5.0");
					</script>'
);

$template_file_config = array(
	'ruta_default' => APPPATH.'views/frr_temp',
	'ruta_default_short' => 'frr_temp/',
	'extension_file' => 'html',
	
);

//Tags Custom disponibles
$tags_custom_disponibles = array(
	'form',
	'css'
);

//Paramtros validos para el tag {$form $}
$parametros_tags_form = array(
	'forms_nombre',
	'entry_id',
	'contenido'
);

//Paramtros validos para el tag {$css $}
$parametros_tags_css = array(
	'url',
);

//Paramtros validos para el tag {$js $}
$parametros_tags_js = array(
	'url',
);
