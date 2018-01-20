<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_params extends CI_Model {

	public function config()
	{
        $result = $this->db->get('config')->row_array();
        $this->db->select("photo");
        $this->db->from("users");
        $this->db->where("type","admin");
        $result["photo"]=$this->db->get()->row("photo");
        return $result;
	}

	public function update($data)
	{
        $this->db->update('config',$data);
	}


}
		
