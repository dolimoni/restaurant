<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_db');
        $this->load->model('model_group');


    }


}

