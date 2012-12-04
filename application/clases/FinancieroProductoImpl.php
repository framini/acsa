<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

//require (APPPATH . 'clases/Producto.php');

/**
 * Clase Financiero
 *
 */
class FinancieroProductoImpl extends Producto {

	private $aforo;
	private $caso_percent;

	function __construct() {
	}

	function test() {
		return "DESDE FINANCIERO";
	}

	function setAforo($valor) {
		$this -> aforo = $valor;
	}

	function setCasoPercent() {
		switch($this->getCalidad()) {
			case "Privado" :
				$this -> caso_percent = 0.8;
				break;
			case "Publico" :
				$this -> caso_percent = 0.85;
				break;
			case "Exterior" :
				$this -> caso_percent = 0.90;
				break;
			default :
				break;
		}
	}

	function calcular_precio_ponderado($valor_nominal) {
		$this -> setCasoPercent();

		$valorPonderado = $valor_nominal * $this -> caso_percent * $this -> aforo * $this -> getPrecio();

		return $valorPonderado;
	}

	function calcular_valor_nominal() {
		//Regla de negocio
		//DDF = Cantidad * 100
		return $this -> getCantidad() * 100;
	}

	function get_precio_ponderado() {
		$this -> setCasoPercent();
		$valor_nominal = $this -> calcular_valor_nominal();
		$precio_ponderado = $this -> calcular_precio_ponderado($valor_nominal);

		return $precio_ponderado;
	}

}
