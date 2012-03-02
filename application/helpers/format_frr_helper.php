<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('format_texto'))
{
	function format_texto($uri = NULL)
	{
		$CI =& get_instance();
		if($uri) {
			//Reemplazamos los guiones bajos por un espacio en blanco
			//Pasamos a lower case
			//Y por ultimo pone la primer letra en uppercase
			$uri = ucfirst(strtolower(str_replace("_", " ", $uri)));
		}
		return $uri;
	}
}