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
        $this->log_begin();
        $data['products'] = $this->model_product->getAll(true,false);//param1: get Meals,param2:get compositions
        $data['productsComposition'] = $this->model_product->getCompositions(true);//true: get Meals
        $data['providers'] = $this->model_provider->getAll();
       /* $this->control();*/
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/product/view_products', $data);
        $this->log_end($data);
    }
    public function toOrder()
	{
        $this->log_begin();
        $data['products'] = $this->model_product->getToOrder();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/product/view_productsToOrder', $data);
        $this->log_end($data);
    }

    public function add()
    {
       $this->log_begin();
       try {
           if (!$this->input->post('productsList')) {
               $data['products'] = $this->model_product->getAll();
               $data['providers'] = $this->model_provider->getAll();
               $data['params'] = $this->getParams();
               $this->load->view('admin/product/add', $data);
               $this->log_end($data);
           } else {
               $productsList = $this->input->post('productsList');
               $this->log_middle($productsList);
               $this->model_product->addProducts($productsList);
               $this->output
                   ->set_content_type("application/json")
                   ->set_output(json_encode(array('status' => 'success', 'redirect' => base_url('admin/product/index'))));
               $this->log_end(array('status' => 'success', 'redirect' => base_url('admin/product/index')));
           }
       } catch (Exception $e) {
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'error', 'redirect' => base_url('admin/product/index'))));
       }
    }


    public function addComposition()
    {
        $this->log_begin();
       try {
           if (!$this->input->post('composition')) {
               $data['products'] = $this->model_product->getAll(false,true);
               $data['params'] = $this->getParams();
               $this->load->view('admin/product/view_addComposition', $data);
               $this->log_end($data);
           } else {
               $composition = $this->input->post('composition');
               $this->log_middle($composition);
               $this->model_product->addComposition($composition);
               $this->output
                   ->set_content_type("application/json")
                   ->set_output(json_encode(array('status' => 'success', 'redirect' => base_url('admin/product/index'))));
               $this->log_end(array('status' => 'success', 'redirect' => base_url('admin/product/index')));

           }
       } catch (Exception $e) {
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'error', 'redirect' => base_url('admin/product/index'))));
       }
    }


    public function editComposition()
    {
       try {
           $this->log_begin();

           $id = $this->uri->segment(4);
           $data['composition'] = $this->model_product->getComposition($id);
           $data['quantities'] = $this->model_product->getQuantitiesToShow($id);
           $data['products'] = $this->model_product->getAll(false,true);
           $data['params'] = $this->getParams();
           $this->load->view('admin/product/view_editComposition', $data);
           $this->log_end($data);

       } catch (Exception $e) {
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'error', 'redirect' => base_url('admin/product/index'))));
       }
    }

    public function apiEditComposition(){
        try {
            $this->log_begin();
            $composition = $this->input->post('composition');
            $db_product = $this->model_product->getById($composition['id']);
            $data = array();

            $this->log_middle($db_product);
            if ($db_product['unit_price'] !== $composition['cost'] and $composition['quantity']>0) {
                $this->model_product->addComposition($composition,true);
            } else {
                $this->model_product->addComposition($composition);
            }



            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success', 'redirect' => base_url('admin/product/index'))));
            $this->log_end(array('status' => 'success', 'redirect' => base_url('admin/product/index')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function apiGetByProvider(){
        try {
            $this->log_begin();
                $product_id = $this->input->post('product');
                $provider = $this->input->post('provider');
                $prodcut = $this->model_product->getByProvider($product_id,$provider);
                $this->output
                    ->set_content_type("application/json")
                    ->set_output(json_encode(array('status' => 'success','product'=> $prodcut)));
            $this->log_end(array('status' => 'success', 'product' => $prodcut));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error', 'redirect' => base_url('admin/product/index'))));
        }
    }

    public function edit()
	{
        $this->log_begin();
        $id = $this->uri->segment(4);
        $data['providers'] = $this->model_provider->getAll();
		$data['product'] = $this->model_product->getById($id);
		$data['quantities'] = $this->model_product->getQuantitiesToShow($id);
        $data['params'] = $this->getParams();
		$this->load->view('admin/product/edit',$data);
        $this->log_end($data);
	}
	public function apiEdit()
	{
        try {
            $this->log_begin();
            $product = $this->input->post('product');
            $db_product = $this->model_product->getById($product['id']);
            $data = array();

            $this->log_middle($db_product);
            if ($db_product['unit_price'] !== $product['unit_price'] or $db_product['provider'] !== $product['provider']) {
                $this->model_product->edit($product,true);
            } else {
                $data['product'] = $this->model_product->edit($product);
            }
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success', 'redirect' => base_url('admin/product/index'))));
            $this->log_end(array('status' => 'success', 'redirect' => base_url('admin/product/index')));

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
            $this->log_begin();
            $product = $this->input->post('product');
            $db_product = $this->model_product->getById($product['id']);
            $data = array();

            $this->log_middle($db_product);
            if ($db_product['unit_price'] !== $product['unit_price']) {
                $this->model_product->apiEditForProvider($product,true);
            } else {
                $data['product'] = $this->model_product->apiEditForProvider($product);
            }
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
            $this->log_end(array('status' => 'success'));
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
            $this->log_begin();

            //id of quantity to be activated
            $quantity_id = $this->input->post('quantity_id');

            //getting quantity from db
            $quantity = $this->model_product->getQuantity($quantity_id);
            $this->log_middle($quantity);

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

            $this->log_end(array('status' => 'success'));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
	}

	public function apiDelete()
	{

        try {
            $this->log_begin();
            $status="success";
            $message="success";
            $id = $this->input->post('id');
            if($this->model_product->canBeDeleted($id)){
                $this->model_product->delete($id);
                $this->log_middle("deleted");
            }else{
                $status = "warning";
                $message= "Ce produit est utilisé dans certain articles";
            }
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => $status,'message'=>$message)));
            $this->log_end(array('status' => $status, 'message' => $message));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
	}

    private function control()
    {

        // quantité de la table product doit être toujours egal a la somme des quantités de la table quantity
        $this->load->model('model_product');
        $products = $this->model_product->getAll(false);
        foreach ($products as $product) {
            $quantities = $this->model_product->getAllQuantities($product['id']);
            $totalQuantity = array_sum(array_column($quantities, 'quantity'));
            $data = array(
                'totalQuantity' => $totalQuantity
            );

            $this->model_product->update($product['id'], $data);
        }
        $products = $this->model_product->controlQuantity();
    }


}

