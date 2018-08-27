<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_customer extends CI_Model
{

    public function getAll(){
        return $this->db->get('customer')->result_array();
    }

}