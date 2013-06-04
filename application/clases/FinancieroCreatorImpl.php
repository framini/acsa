<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once (APPPATH . 'clases/Creator.php');
require_once (APPPATH . 'clases/FinancieroProductoImpl.php');

/**
 *  Clase base para Productos
 */

class FinancieroCreatorImpl extends Creator {

	/**
	 * Metodo para implementar el factory
	 * @param type $tipo
	 */
	function factory($tipo, $datos) {
		$ofinanciero = new Financiero();

		//Seteamos el objeto Financiero
		$ofinanciero -> setCalidad($tipo);
		$ofinanciero -> setCantidad($datos['kilos']);
		$ofinanciero -> setPrecio($datos['precio']);
		$ofinanciero -> setAforo($datos['aforo']);

		return $ofinanciero;

	}

}
