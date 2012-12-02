<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Clase Financiero
 *
 */
class Financiero extends Producto {
	private $aforo;
	private $caso_percent;

	function __construct() {
		parent::__construct();

		$ci = &get_instance();
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

}
