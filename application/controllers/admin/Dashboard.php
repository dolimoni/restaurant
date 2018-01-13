<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends BaseController {

	public function __construct()
	{
		parent::__construct();
        if ( ! $this->session->userdata('isLogin')) { 
            redirect('login');
        }
        $this->load->model('model_group');
        $this->load->model('model_product');

	}

	public function index()
	{
	    //get alertes
        $this->log_begin();
        $this->load->model('model_budget');
        $data['alertes']=$this->model_budget->getActiveAlerts();
        $data['groups'] = $this->model_group->getAll();
        $data['productsToOrder'] = $this->model_product->getToOrder();
        $data['params']=$this->getParams();
        $this->parser->parse('admin/meal/view_group', $data);
        $this->log_end($data);
	}

	public function logout()
	{
           $this->log_begin();
	       $this->session->sess_destroy();
           $this->log_end(null);
	       redirect('login');
	}
}
