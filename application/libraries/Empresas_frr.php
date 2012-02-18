<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empresas_frr {
    
    private $error = array();

    public function __construct() {
        $this->ci = & get_instance();

        $this->ci->load->model('auth/users');
        $this->ci->load->model('auth/empresas');
        $this->ci->load->model('roles/roles_model');
        $this->ci->load->model('ewarrants/ewarrants_model');
        $this->ci->load->model('productos/productos_model');
    }
	
	/**
	 * Chequea que la empresa este disponible para el registro.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_nombre_empresa_available($nombre)
	{
		return ((strlen($nombre) > 0) AND $this->ci->empresas->is_nombre_empresa_available($nombre));
	}
	
	/**
	 * Crea una nueva empresa en el sistema
	 */
	function create_empresa($nombre, $cuit, $tipo_empresa_id) {
		if($this->is_nombre_empresa_available($nombre)) {
			$data = array('nombre' => $nombre, 'cuit' => $cuit, 'tipo_empresa_id' => $tipo_empresa_id);
			if (!is_null($res = $this->ci->empresas->create_empresa($data))) {
				$data['empresa_id'] = $res['empresa_id'];
				return $data;
			}
		} else {
			$this->error['nombre'] = 'nombre_empresa_en_uso';
		}
		
		return NULL;
	}
	
	function get_tipos_empresas() {
		$tipos_empresas = $this->ci->empresas->get_tipos_empresas();

        foreach ($tipos_empresas->result() as $row)
        {
           $data[] = array(
                            'tipo_empresa_id'    => $row->tipo_empresa_id,
                            'tipo_empresa'       => $row->tipo_empresa,
                            'descripcion'        => $row->descripcion
                   );
        }

        return $data;
	}
}