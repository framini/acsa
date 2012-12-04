<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
/**
 *  Clase base para Productos
 */

abstract class Producto {

	private $cantidad;
	private $calidad;
	private $precio;

	function setCalidad($valor) {
		$this -> calidad = $valor;
	}

	function setCantidad($valor) {
		$this -> cantidad = $valor;
	}

	function setPrecio($valor) {
		$this -> precio = $valor;
	}

	function getCalidad() {
		return $this -> calidad;
	}

	function getCantidad() {
		return $this -> cantidad;
	}

	function getPrecio() {
		return $this -> precio;
	}

	function get_precio_ponderado() {

		$valor_nominal = $this -> calcular_valor_nominal();
		$precio_ponderado = $this -> calcular_precio_ponderado($valor_nominal);

		return $precio_ponderado;
	}

	function calcular_precio_ponderado($valor_nominal) {

	}

	function calcular_valor_nominal() {

	}

	function setCasoPercent() {
	}

}
