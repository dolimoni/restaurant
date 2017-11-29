<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_params extends CI_Model {

	public function config()
	{
        $result = $this->db->get('config');
        return $result->row_array();
	}

	public function update($data)
	{
        $this->db->update('config',$data);
	}


}
		
