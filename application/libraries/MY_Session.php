<?php

class MY_Session extends CI_Session {
    
       /**
       * Clona el objeto pasado como parametro almacenado en la session
       * @param	String	(Nombre del objeto a ser clonado)
        *@return      JSON 
       */
        function clonar($objeto) 
        {
                return  json_decode( $this->userdata('empresa'), true);
        }
        
        function deserializar($objeto) {
            return unserialize($this->userdata($objeto));
        }
}
