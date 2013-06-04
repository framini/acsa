<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

//require(APPPATH . 'clases/Producto.php');

/**
 * Clase Agro
 *
 */
class AgroProductoImpl extends Producto {
	
	private $caso_percent;

	function __construct() {
	}

	function test() {
		return "DESDE FINANCIERO";
	}

	function setCasoPercent() {
		switch($this->getCalidad()) {
			case "Fabrica" :
				$this -> caso_percent = 0.85;
				break;
			case "Camara" :
				$this -> caso_percent = 0.95;
				break;
			default :
				break;
		}
	}

	function calcular_precio_ponderado($valor_nominal) {
		$this -> setCasoPercent();

		$valorNominal = $valor_nominal * $this -> caso_percent * $this -> getPrecio();

		return $valorNominal;
	}

	function calcular_valor_nominal() {
		//Regla de negocio
		//DDA = Cantidad * 30
		return $this -> getCantidad() * 30;
	}

}
