<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Tablero_frr {
	
    private $error = array();

    public function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * Alta de un nuevo indicador en el sistema
     */
    function alta_indicador($id, $descripcion, $tipo, $numerador, $relative, $denominador, $RelacionObjetivo, $Drilldown) {

        $this->ci->load->model('tablero/tablero_model');

        $data = array(
            'idIndicador' => $id, 
            'Descripcion' => $descripcion, 
            'Tipo' => $tipo, 
            'CalculoNumerador' => $numerador,
            'Relative' => $relative,
            'CalculoDenominador' => $denominador,
            'RelacionObjetivo' => $RelacionObjetivo,
            'Drilldown' => $Drilldown,
            'Activo' => 1,
            'user' => $this->ci->auth_frr->get_username()
        );

        if (!is_null($res = $this -> ci -> tablero_model -> alta_indicador($data))) {
            $data['idIndicador'] = $res['idIndicador'];
            return $data;
        }

        return NULL;
    }

    function get_indicadores() {
        $this->ci->load->model('tablero/tablero_model');

        $indicadores = $this -> ci -> tablero_model -> get_indicadores();
        
        if( !is_null($indicadores) ) {
            foreach ($indicadores->result() as $row) {
                
                $data[] = array(
                    'id' => $row -> idIndicador, 
                    'descripcion' => $row -> Descripcion, 
                    'tipo' => $row -> Tipo, 
                    'numerador' => $row -> CalculoNumerador, 
                    'relative' => ($row -> Relative) ? 1 : 0,
                    'denominador' => $row -> CalculoDenominador,
                    'relacionobjetivo' => ($row -> RelacionObjetivo) ? 1 : 0,
                    'drilldown' => $row -> DrillDown,
                    'activo' => $row -> Activo ? 1 : 0,
                    'user' => $row -> user,
                );
            }
        } else {
            $data = NULL;
        }

        return $data;
    }

    function get_resultados_tablero($id = NULL, $anio = NULL, $mes = NULL) {

        //Si especificamos un ID es porque estamos buscando resultados de real_drilldown
        if( !is_null($id) ) {

            $query = $this->ci->db->query("SELECT 
                                            real_drilldown.idReal_Drilldown, real_drilldown.Campo, real_drilldown.valor
                                            FROM real_drilldown
                                            WHERE real_drilldown.idIndicador = '$id'
                                            ");
            

            if ($query != NULL) {
                foreach ($query->result() as $row) {
                    $data[] = array(
                        'id' => $row -> idReal_Drilldown, 
                        'campo' => $row -> Campo, 
                        'valor' => $row -> valor
                    );

                }

                return $data;
            } else {
                return NULL;
            }

        } else {
            $query = $this->ci->db->query("Select 
                                             indicador.idIndicador,
                                             indicador.Descripcion,
                                             indicador.Tipo,
                                             `real`.Mes,
                                             `real`.Anio,
                                             objetivo.valor as Objetivo,
                                             real.valor,
                                             CASE  
                                              when `real`.valor > objetivo.valor THEN 1
                                              when `real`.valor = objetivo.valor THEN 0
                                              when `real`.valor < objetivo.valor THEN -1
                                             END AS Indicador,
                                            ( select GROUP_CONCAT(CASE  
                                              when r2.valor > objetivo.valor THEN 1
                                              when r2.valor = objetivo.valor THEN 0
                                              when r2.valor < objetivo.valor THEN -1

                                             END) from `real` as r2 where r2.idindicador = `real`.idindicador LIMIT 10) AS Historico
                                            from indicador
                                             inner join `real` ON real.idIndicador = indicador.idIndicador
                                             inner join objetivo ON objetivo.idIndicador = real.idIndicador and objetivo.anio and objetivo.mes");
            

            if ($query != NULL) {
                foreach ($query->result() as $row) {
                    $data[] = array(
                        'id' => $row -> idIndicador, 
                        'descripcion' => $row -> Descripcion, 
                        'tipo' => $row -> Tipo, 
                        'mes' => $row -> Mes, 
                        'anio' => $row -> Anio, 
                        'objetivo' => $row -> Objetivo, 
                        'valor' => $row -> valor,
                        'indicador' => $row -> Indicador,
                        'historico' => $row-> Historico
                    );

                }

                return $data;
            } else {
                return NULL;
            }
        }

    }
}