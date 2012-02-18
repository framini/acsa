<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *  Clase base para Productos
 */

class ProductosCreator extends CI_Model {
    private $ci;
    
    function __construct()
   {
            parent::__construct();
            $this->ci = & get_instance();
   }
   
   /**
    * Metodo para implementar el factory
    * @param type $tipo 
    */
   function factory($tipo, $datos) {
       if($tipo == "Fabrica" || $tipo == "Camara") {
           
            //Creamos la instancia del objeto agro
            $this->ci->load->model("productos/agro");
            $oagro = new Agro();

            //Seteamos el objeto Agro
            $oagro->setCalidad($tipo);
            $oagro->setCantidad($datos['kilos']);
            $oagro->setPrecio($datos['precio']);
     
            return $oagro;

        } else if($tipo == "Publico" || $tipo == "Privado" || $tipo == "Exterior") {
            //Creamos la instancia del objeto agro
            $this->ci->load->model("productos/financiero");
            $ofinanciero = new Financiero();

            //Seteamos el objeto Financiero
            $ofinanciero->setCalidad($tipo);
            $ofinanciero->setCantidad($datos['kilos']);
            $ofinanciero->setPrecio($datos['precio']);
            $ofinanciero->setAforo($datos['aforo']);
     
            return $ofinanciero;
        } else {
            return NULL;
        }
   }
}