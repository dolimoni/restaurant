<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends BaseController {

	public function __construct()
	{
		parent::__construct();
	    if ( ! $this->session->userdata('isLogin') || ($this->session->userdata('type') != "admin" )) {
	        redirect('login');
	    }

		//$this->load->database();
		$this->load->model('model_product');
		$this->load->model('model_provider');

	}
	public function index()
	{
        $data['products'] = $this->model_product->getAll(true);//true: get Meals
        $data['providers'] = $this->model_provider->getAll();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/product/view_products', $data);
    }
    public function toOrder()
	{
        $data['products'] = $this->model_product->getToOrder();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/product/view_productsToOrder', $data);
    }

    public function add()
    {
       try {
           if (!$this->input->post('productsList')) {
               $data['products'] = $this->model_product->getAll();
               $data['providers'] = $this->model_provider->getAll();
               $data['params'] = $this->getParams();
               $this->load->view('admin/product/add', $data);
           } else {
               $productsList = $this->input->post('productsList');
               $this->model_product->addProducts($productsList);
               $this->output
                   ->set_content_type("application/json")
                   ->set_output(json_encode(array('status' => 'success', 'redirect' => base_url('admin/product/index'))));
           }
       } catch (Exception $e) {
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'error', 'redirect' => base_url('admin/product/index'))));
       }
    }

    public function apiGetByProvider(){
        try {
                $product_id = $this->input->post('product');
                $provider = $this->input->post('provider');
                $prodcut = $this->model_product->getByProvider($product_id,$provider);
                $this->output
                    ->set_content_type("application/json")
                    ->set_output(json_encode(array('status' => 'success','product'=> $prodcut)));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error', 'redirect' => base_url('admin/product/index'))));
        }
    }

    public function edit()
	{
        $id = $this->uri->segment(4);
        $data['providers'] = $this->model_provider->getAll();
		$data['product'] = $this->model_product->getById($id);
		$data['quantities'] = $this->model_product->getQuantitiesToShow($id);
		$data['departments'] = $this->model_product->getQuantitiesByDepartement($id);
        $data['params'] = $this->getParams();
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
                ->set_output(json_encode(array('status' => 'success', 'redirect' => base_url('admin/product/index'))));
        } catch (Exception $e) {
            $this->load->view('admin/product/edit', $data);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
	}

	public function apiEditForProvider()
	{
        try {
            $product = $this->input->post('product');
            $db_product = $this->model_product->getById($product['id']);
            $data = array();

            if ($db_product['unit_price'] !== $product['unit_price']) {
                $this->model_product->apiEditForProvider($product,true);
            } else {
                $data['product'] = $this->model_product->apiEditForProvider($product);
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

	public function apiActivateQuantity()
	{
        try {

            //id of quantity to be activated
            $quantity_id = $this->input->post('quantity_id');

            //getting quantity from db
            $quantity = $this->model_product->getQuantity($quantity_id);

            //searching actual active quantity by product
            $activeQuantity= $this->model_product->getActiveQuantityByProduct($quantity['product']);

            $data = array(
                'status'=>'stock'
            );
            if($activeQuantity['quantity']<=0){
                $data['status']="sold_out";
            }


            // update actual active quantity to be a stock quantity
            $this->model_product->updateActiveQuantity($activeQuantity['id'],$data);

            $data = array(
                'status' => 'active'
            );

            // activate new quantity
            $this->model_product->updateActiveQuantity($quantity_id,$data);


            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
	}

	public function apiDelete()
	{

        try {
            $status="success";
            $message="success";
            $id = $this->input->post('id');
            if($this->model_product->canBeDeleted($id)){
                $this->model_product->delete($id);
            }else{
                $status = "warning";
                $message= "Ce produit est utilisé dans certain articles";
            }
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => $status,'message'=>$message)));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
	}


}

