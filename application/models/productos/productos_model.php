<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo de datos para Productos
 *
 */
class Productos_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
                  
                  /**
                   * Devuelve la lista con todos los productos cargados en el sistema
                   */
                  function get_productos() {
		$this->db->select();
                                    $this->db->from("productos");
                                    $query = $this->db->get();

                                    if ($query->num_rows() > 0) return $query;
                                    return NULL;
                  }
                  
                  /**
                   * Devuelve un registro de producto en base al id del parametro
                   */
                  function get_producto_by_id($id) {
                        $this->db->where('producto_id', $id);
                        $this->db->from('productos');
                        $query = $this->db->get();
                        if ($query->num_rows() == 1) return $query->row();
                                        return NULL;
                  }
}
