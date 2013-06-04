<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Modelo de datos para Productos
 *
 */
class Productos_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	/**
	 * Devuelve la lista con todos los productos cargados en el sistema
	 */
	function get_productos() {
		$this -> db -> select();
		$this -> db -> from("productos");
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0)
			return $query;
		return NULL;
	}

	/**
	 * Devuelve la lista con todos los tipos de productos cargados en el sistema
	 */
	function get_tipos_producto() {
		$this -> db -> select();
		$this -> db -> from("tipo_producto");
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0)
			return $query;
		return NULL;
	}

	/**
	 * Devuelve un registro de producto en base al id del parametro
	 */
	function get_producto_by_id($id) {
		$this -> db -> where('producto_id', $id);
		$this -> db -> from('productos');
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1)
			return $query -> row();
		return NULL;
	}
	
	function get_descripcion_producto_tipo_by_id($id) {
		$this -> db -> where('tipo_producto_id', $id);
		$this -> db -> from('tipo_producto');
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1)
			return $query -> row();
		return NULL;
	}

	function create_producto($data) {

		if ($this -> db -> insert('productos', $data)) {
			$producto_id = $this -> db -> insert_id();
			return array('producto_id' => $producto_id);
		}
		return NULL;

	}

	/**
	 * Modifica los datos de una empresa
	 */
	function modificar_producto($producto_id, $data) {
		$this -> db -> where('producto_id', $producto_id);
		if ($this -> db -> update('productos', $data))
			return true;
		else
			return false;
	}

	/**
	 * Eliminamos la empresa con id = $empresa_id
	 * Y todos los usuarios que pertenecen a esa empresa
	 * NOTA: Borrado Logico
	 */
	function eliminar_producto($producto_id) {
		$this -> db -> where('producto_id', $producto_id);

		if ($this -> db -> delete('productos')) {
			return true;
		} else
			return false;
	}

}
