<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_storage extends CI_Model {


    public function __construct()
    {
        parent::__construct();

    }



    public function getAll(){

        return $this->db->get("storage_area")->result_array();
    }

    public function getAllProducts(){

        // Il faut créer une table ou on va mettre les quantités reçu et envoyé à la zone
        $this->db->select('orderdetails o');
        $this->db->join('order o','o.id=od.order_id and o.status="received"',"left");
        return $this->db->get("storage_area")->result_array();
    }


}