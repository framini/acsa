<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(APPPATH . 'clases/Creator.php');
require_once(APPPATH . 'clases/AgroProductoImpl.php');

/**
 *  Clase base para Productos
 */

class AgroCreatorImpl extends Creator {
   
   /**
    * Metodo para implementar el factory
    * @param type $tipo 
    */
   function factory($tipo, $datos) {
        $oagro = new AgroProductoImpl();

        //Seteamos el objeto Agro
        $oagro->setCalidad($tipo);
        $oagro->setCantidad($datos['kilos']);
        $oagro->setPrecio($datos['precio']);
 
        return $oagro;

   }
}