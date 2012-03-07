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

if ( ! function_exists('field_name_parser'))
{
	function field_name_parser($uri = NULL)
	{
		$CI =& get_instance();
		if($uri) {
			//Reemplazamos los guiones bajos por un espacio en blanco
			//Pasamos a lower case
			//Y por ultimo pone la primer letra en uppercase
			$uri = strtolower(str_replace("field_id_", "", $uri));
		}
		return $uri;
	}
}

if ( ! function_exists('in_object'))
{
	function in_object($value,$object) {
	    if (is_object($object)) {
	      foreach($object as $key => $item) {
	        if ($key==$value) {
	        	 return $key;
			} else if($item==$value) {
				return $item;
			}
	      }
	    }
	    return false;
	  }
}