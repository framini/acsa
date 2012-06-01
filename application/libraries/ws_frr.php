<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Libreria de Autenticacion para CodeIgniter.
 */
class Ws_frr
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();
	}
	
	/**
	 * Metodo utilizado para obtener los ultimos X tweets de la cuenta pasada como parametro via el WS REST de Twitter
	 */
	function get_tweets($de = NULL, $cantidad = 7) {
		if(!is_null($de)) {
			$this->ci->load->spark('restclient/2.1.0');
			$this->ci->load->library('rest'); 
			$this->ci->rest->set_server('http://api.twitter.com/');
			
			$tweets = $this->ci->rest->get('statuses/user_timeline.json', array('include_entities' => true, 
																			'include_rts' => true,
																			'screen_name' => $de,
																			'count' => $cantidad ));
			
			return $tweets;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Metodo utilizado para consumir el WS de google para la cotizacion de monedas
	 * @param recibe un array de los tipos de monedas a cotizar
	 * @return devuelve un array de JSON con la cotizacion
	 */
	function obtener_cotizacion($conversiones = array()) {
		if(!empty($conversiones)) {
			$cantidad = 1;
			$cotizaciones = array();
			
			foreach ($conversiones as $key => $value) {
				$moneda_origen = "USD"; $moneda_destino = $value;
		
			    $cantidad = urlencode($cantidad);
			    $moneda_origen = urlencode($moneda_origen);
			    $moneda_destino = urlencode($moneda_destino);

				$url = "http://www.google.com/ig/calculator?hl=en&q=$cantidad$moneda_origen=?$moneda_destino";
				
			    $ch = curl_init();
			    $timeout = 0;
			    curl_setopt ($ch, CURLOPT_URL, $url);
			    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
			    curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			    $rawdata = curl_exec($ch);
			    curl_close($ch);
				
				//Fix para el JSON devuelvo por el WS. Las propiedades no vienen entre comillas dobles y no se pueden usar directamente en json_decode
			    $phpJson = preg_replace("/((\"?[^\"]+\"?)[ ]*:[ ]*([^,\"]+|\"[^\"]*\")(,?))/i", '"\\2": \\3\\4', str_replace(array('{', '}'), array('',''), $rawdata));
				
				$cotizaciones[$value] = '{'.$phpJson.'}';
				//return ('{'.$phpJson.'}');
			}

			return $cotizaciones;
		}
	}
}
