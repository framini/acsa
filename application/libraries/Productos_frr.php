<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Productos_frr {

	private $error = array();

	public function __construct() {
		$this -> ci = &get_instance();

		$this -> ci -> load -> model('auth/users');
		$this -> ci -> load -> model('roles/roles_model');
		$this -> ci -> load -> model('productos/productos_model');
	}

	function get_productos() {
		$productos = $this -> ci -> productos_model -> get_productos();
		
		if( !is_null($productos) ) {
			foreach ($productos->result() as $row) {
				$data[] = array('producto_id' => $row -> producto_id, 'nombre' => $row -> nombre, 'precio' => $row -> precio, 'calidad' => $this->get_descripcion_producto_tipo_by_id( $row -> calidad ), 'aforo' => $row -> aforo);
			}
		} else {
			$data = NULL;
		}

		return $data;
	}

	function get_tipos_producto() {
		$tipos_producto = $this -> ci -> productos_model -> get_tipos_producto();

		foreach ($tipos_producto->result() as $row) {
			$data[] = array('tipo_producto_id' => $row -> tipo_producto_id, 'descripcion' => $row -> descripcion, );
		}

		return $data;
	}
	
	function get_descripcion_producto_tipo_by_id($id) {
		if (!is_null($id)) {
			//Obtenemos la empresa en base al id enviado como parametro
			$tipo_producto = $this -> ci -> productos_model -> get_descripcion_producto_tipo_by_id($id);

			if (!is_null($tipo_producto)) {

				return $tipo_producto->descripcion;
			}

			return NULL;
		}
	}

	/**
	 * Crea un nueva producto en el sistema
	 */
	function create_producto($nombre, $precio, $calidad, $aforo) {

		$data = array('nombre' => $nombre, 'precio' => $precio, 'calidad' => $calidad, 'aforo' => $aforo);
		if (!is_null($res = $this -> ci -> productos_model -> create_producto($data))) {
			$data['producto_id'] = $res['producto_id'];
			return $data;
		}

		return NULL;
	}

	/**
	 * Crea un nueva producto en el sistema
	 */
	function create_comision($data) {

		if (!is_null($res = $this -> ci -> productos_model -> create_comisiones($data))) {
			$data['comision_id'] = $res['comision_id'];
			return $data;
		}

		return NULL;
	}

	/**
	 * Modifica un producto del sistema
	 */
	function modificar_producto($producto_id, $nombre, $precio, $calidad, $aforo) {

		$data['nombre'] = $nombre;
		$data['precio'] = $precio;
		$data['calidad'] = $calidad;
		$data['aforo'] = $aforo;

		return $this -> editar_producto($producto_id, $data);
	}

	function modificar_comision($data) {
		if ($this -> ci -> productos_model -> modificar_comision($data)) {
			return true;
		} else {
			return NULL;
		}
	}

	/**
	 * Eliminar una empresa del sistema
	 */
	function eliminar_producto($producto_id) {
		if ($this -> ci -> productos_model -> eliminar_producto($producto_id))
			return true;
		else
			return false;
	}

	/**
	 * Permite la modificacion de una determinada Empresa
	 */
	function editar_producto($producto_id, $data) {
		if ($this -> ci -> productos_model -> modificar_producto($producto_id, $data)) {
			return true;
		} else {
			return NULL;
		}
	}

	function get_producto_by_id($prod_id = NULL) {
		if (!is_null($prod_id)) {
			//Obtenemos la empresa en base al id enviado como parametro
			$producto = $this -> ci -> productos_model -> get_producto_by_id($prod_id);

			if (!is_null($producto)) {

				$data[] = array('producto_id' => $producto -> producto_id, 'nombre' => $producto -> nombre, 'precio' => $producto -> precio, 'calidad' => $producto -> calidad, 'aforo' => $producto -> aforo, );
			}

			return $data;
		}

	}

	function get_datos_producto_empresa_comision($prod_id) {
		if (!is_null($prod_id)) {
			$emp_id = $this->ci->auth_frr->get_empresa_id();

			//Obtenemos la empresa en base al id enviado como parametro
			$relacion = $this -> ci -> productos_model -> get_comision_by_empresa($prod_id, $emp_id);

			return $relacion;
		}
	}

	/**
	 * Devuelve el mensaje de error.
	 * Puede ser usada tras cualquier operacion fallida, como de login o registro.
	 *
	 * @return	string
	 */
	function get_error_message() {
		return $this -> error;
	}

}
