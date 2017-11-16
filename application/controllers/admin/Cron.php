<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('model_cron');
        //$this->model_cron->updateProductsQuantity();
        // this controller can only be called from the command line
        if (!$this->input->is_cli_request()) show_error('Direct access is not allowed');

        $this->model_cron->updateProductsQuantity();

	}


	public function index()
	{
       // $this->model_cron->updateProductsQuantity();

        $this->load->model('model_employee');
        $this->load->model('model_product');
        $this->load->model('model_provider');

        $data['products'] = $this->model_product->getAll();
        $data['providers'] = $this->model_provider->getAll();
        $this->parser->parse('admin/product/view_products', $data);
	}

}