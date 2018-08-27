<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_db extends CI_Model {

    public function troncate($table){
        $this->db->truncate($table);
    }
}