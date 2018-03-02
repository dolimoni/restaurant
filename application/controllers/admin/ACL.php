<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ACL extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isLogin') /*|| ($this->session->userdata('type') != "admin" and $this->session->userdata('type') != "manager")*/) {
            redirect('login');
        }
        $this->load->model('model_ACL');
    }

    public function index()
    {
        $this->log_begin();

        //$this->log_end($data);
    }

    public function apiCreateDefaultPages(){
        $pages = $this->model_acl->createDefaultPages();
        echo "<pre>";
        print_r($pages);
        echo "</pre>";
    }

}

