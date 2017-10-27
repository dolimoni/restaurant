<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        if ( ! $this->session->userdata('isLogin')) { 
            redirect('login');
        }
        $this->load->model('model_group');
		
	}

	public function index()
	{
        $data['groups'] = $this->model_group->getAll();
        $this->parser->parse('admin/meal/view_group', $data);
	}

	public function logout()
	{

	       $this->session->sess_destroy();
	       redirect('login');
	}
}
