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
        $this->load->model('model_product');

	}

	public function index()
	{
	    //get alertes
        $this->load->model('model_budget');
        $data['alertes']=$this->model_budget->getActiveAlerts();
        $data['groups'] = $this->model_group->getAll();
        $data['productsToOrder'] = $this->model_product->getToOrder();

        $this->parser->parse('admin/meal/view_group', $data);
	}

	public function logout()
	{

	       $this->session->sess_destroy();
	       redirect('login');
	}
}
