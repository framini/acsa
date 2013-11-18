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

    /**
     * Modifica un producto del sistema
     */
    function modificar_indicador($current_id, $id, $descripcion, $tipo, $numerador, $relative, $denominador, $RelacionObjetivo, $Drilldown) {

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

        if( $current_id == $id ) {
            if ($this -> ci -> tablero_model -> modificar_indicador($id, $data)) {
                return true;
            } else {
                return NULL;
            }
        } else {
            if($this->is_id_indicador_available($id)) {

                if ($this -> ci -> tablero_model -> modificar_indicador($id, $data)) {
                    return true;
                } else {
                    return NULL;
                }

            } else {
                return NULL;
            }
        }
        
    }

    function is_id_indicador_available($id)  {
        $this->ci->load->model('tablero/tablero_model');
        if( !$this -> ci -> tablero_model -> check_indicador($id) ) {
            return true;
        } else {
            return false;
        }
    }

    function get_indicador_by_id($id = NULL) {
        if (!is_null($id)) {
            //Obtenemos la empresa en base al id enviado como parametro
            $indicador = $this -> ci -> tablero_model -> get_indicador_by_id($id);

            if (!is_null($indicador)) {
                $data[] = array(
                    'idIndicador' => $indicador->idIndicador, 
                    'Descripcion' => $indicador->Descripcion, 
                    'Tipo' => $indicador->Tipo, 
                    'CalculoNumerador' => $indicador->CalculoNumerador,
                    'Relative' => $indicador->Relative,
                    'CalculoDenominador' => $indicador->CalculoDenominador,
                    'RelacionObjetivo' => $indicador->RelacionObjetivo,
                    'Drilldown' => $indicador->DrillDown,
                    'Activo' => $indicador->Activo,
                    'user' => $indicador->user
                );
            } else {
                $data = NULL;
            }

            return $data;
        }

    }

    function get_reporte($id = NULL) {

        $reporte = $this -> ci -> tablero_model -> get_reporte($id);
        $count = 0;
        if($reporte->num_rows() > 0) {
            foreach ($reporte->result() as $row)
            {
               $data[] = array(
                    $row->meses
                );

               $count++;
            }
        } else {
            return NULL;
        }

        return $data;

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

    function get_resultados_tablero($id = NULL, $mes = NULL, $anio = NULL) {
        //Si especificamos un ID es porque estamos buscando resultados de real_drilldown
       
        if( !is_null($id) ) {

            $data = array();

            $query = $this->ci->db->query("SELECT 
                                            real_drilldown.idReal_Drilldown, real_drilldown.Campo, real_drilldown.valor
                                            FROM real_drilldown
                                            WHERE real_drilldown.idIndicador = '$id'
                                            AND real_drilldown.Mes = '$mes'
                                            AND real_drilldown.Anio = '$anio'
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
            // $query = $this->ci->db->query("Select 
            //                                  indicador.idIndicador,
            //                                  indicador.Descripcion,
            //                                  indicador.Tipo,
            //                                  `real`.Mes,
            //                                  `real`.Anio,
            //                                  objetivo.valor as Objetivo,
            //                                  real.valor,
            //                                  CASE  
            //                                   when `real`.valor > objetivo.valor THEN 1
            //                                   when `real`.valor = objetivo.valor THEN 0
            //                                   when `real`.valor < objetivo.valor THEN -1
            //                                  END AS Indicador,
            //                                 ( select GROUP_CONCAT(CASE  
            //                                   when r2.valor > objetivo.valor THEN 1
            //                                   when r2.valor = objetivo.valor THEN 0
            //                                   when r2.valor < objetivo.valor THEN -1

            //                                  END) from `real` as r2 where r2.idindicador = `real`.idindicador LIMIT 10) AS Historico
            //                                 from indicador
            //                                  inner join `real` ON real.idIndicador = indicador.idIndicador
            //                                  inner join objetivo ON objetivo.idIndicador = real.idIndicador and objetivo.anio and objetivo.mes");
            
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
(
select GROUP_CONCAT(
CASE  
when r2.valor > o2.valor THEN 1
when r2.valor = o2.valor THEN 0
when r2.valor < o2.valor THEN -1
END
) 
from `real` as r2 
INNER join objetivo as o2 on r2.idindicador = o2.idindicador and r2.mes = o2.mes and r2.anio = o2.anio
where r2.idindicador = `real`.idindicador 
and r2.date_computed > date_add(`real`.date_computed, INTERVAL -300 DAY) and r2.date_computed <= `real`.date_computed  
ORDER BY r2.date_computed) 
AS Historico, 

date_computed
from indicador
inner join `real` ON real.idIndicador = indicador.idIndicador
inner join objetivo ON objetivo.idIndicador = real.idIndicador and objetivo.anio = real.anio  and objetivo.mes = real.mes
order by date_computed desc");

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