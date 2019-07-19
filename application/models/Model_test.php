<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_test extends CI_Model {

    private $remote_db = "";
    private $current_db = 0;

    public function __construct()
    {


    }

    public function getSales(){
        return $this->db->get('corres_des')->result_array();

    }

    /**
     * @return int
     */
    public function getCurrentDb()
    {
        return $this->current_db;
    }

    /**
     * @param int $current_db
     */
    public function setCurrentDb($current_db)
    {
        $this->current_db = $current_db;
        if ($this->current_db === 0) {
            $this->db = $this->load->database('default', TRUE);
        } else {
            $this->db = $this->load->database('remote_' . $current_db, TRUE);
        }
    }

}