<?php

class My_Custom_model extends grocery_CRUD_Model  {

    function get_list() {
        $query=$this->db->query($this->query_str);
 
        $results_array=$query->result();
        return $results_array;      
    }
 
    public function set_query_str($query_str) {
        $this->query_str = $query_str;
    }
 
}