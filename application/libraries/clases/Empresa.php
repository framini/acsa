<?php

/**
 * Description of Empresa
 *
 * @author francisco.ramini
 */
class Empresa {
    var $nombre;
    var $cuit;
    var $id;
    
    function Empresa() {
        
    }
    
    function setNombre($valor) {
        $this->nombre = $valor;
    }
    function setCuit($valor) {
        $this->cuit = $valor;
    }
    function setId($valor) {
        $this->id = $valor;
    }
    
    function getNombre() {
        return $this->nombre;
    }
    function getCuit() {
        return $this->cuit;
    }
    function getId() {
        return $this->id;
    }
}

