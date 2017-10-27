<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	    if ( ! $this->session->userdata('isLogin') || ($this->session->userdata('type') != "admin" )) {
	        redirect('login');
	    }

		//$this->load->database();
		$this->load->model('model_employee');
		$this->load->model('model_product');
		$this->load->model('model_provider');

	}
	public function index()
	{
        $data['products'] = $this->model_product->getAll();
        $data['providers'] = $this->model_provider->getAll();
        $this->parser->parse('admin/product/view_products', $data);
    }
    public function toOrder()
	{
        $data['products'] = $this->model_product->getToOrder();
        $this->parser->parse('admin/product/view_productsToOrder', $data);
    }

    public function add()
    {
        if (!$this->input->post('productsList')) {
            $data['products'] = $this->model_product->getAll();
            $data['providers'] = $this->model_provider->getAll();
            $this->load->view('admin/product/add', $data);
        } else {
            $productsList = $this->input->post('productsList');
            $this->model_product->addProducts($productsList);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success', 'redirect' => base_url('admin/product/index'))));
        }
    }


    public function edit()
	{
        $id = $this->uri->segment(4);
        $data['providers'] = $this->model_provider->getAll();
		$data['product'] = $this->model_product->getById($id);
		$data['quantities'] = $this->model_product->getQuantities($id);
		$this->load->view('admin/product/edit',$data);
	}
	public function apiEdit()
	{
        try {
            $product = $this->input->post('product');
            $db_product = $this->model_product->getById($product['id']);
            $data = array();

            if ($db_product['unit_price'] !== $product['unit_price']) {
                $this->model_product->edit($product,true);
            } else {
                $data['product'] = $this->model_product->edit($product);
            }
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->load->view('admin/product/edit', $data);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
	}

	public function apiDelete()
	{
        $id = $this->input->post('id');
        $this->model_product->delete($id);

        try {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
	}


}

