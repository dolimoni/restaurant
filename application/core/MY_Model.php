<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 8/27/18
 * Time: 7:57 PM
 */

class MY_Model extends  CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function setGlobalDb(){
        $this->db = $this->load->database('stockitmain', TRUE);
    }

    public function setLocalDb(){
        $this->db = $this->load->database('default', TRUE);
    }

}