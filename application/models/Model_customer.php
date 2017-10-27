<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_customer extends CI_Model
{
    public function insert($customer){
        $datac = array(
            'vehicle_id' => $customer['vehicle_id'],
            'cf_name' => $customer['nom'],
            'nationalitee' => $customer['nationalitee'],
            'adresse' => $customer['adresse'],
            'mobile' => $customer['mobile'],
            'adresseEtranger' => $customer['adresseEtranger'],
            'permisNumber' => $customer['permisNumber'],
            'permisDelivrance' => $customer['permisDelivrance'],
            'permisOwner' => $customer['permisOwner'],
            'cin' => $customer['cin'],
            'cinDelivrance' => $customer['cinDelivrance'],
            'cinOwner' => $customer['cinOwner'],
            'c_email' => '',
            'c_mobile' => '',
            'w_start' => '2016-11-30',
            'w_end' => '2016-11-30',
            'payment_type' => 'Cash',
            'c_pass' => '1234'
        );
        $this->db->insert('customer', $datac);
        $id = $this->db->insert_id();

        return $id;
    }

}