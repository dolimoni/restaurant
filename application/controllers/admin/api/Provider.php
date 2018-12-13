<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 8/22/18
 * Time: 3:00 AM
 */

class Provider extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_provider');

    }

    public function getOrders(){

        try {
            $provider=$this->input->post('id');
            $orders=$this->model_provider->getOrders($provider);
            $response=array('orders'=>$orders);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode($response));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "error")));
        }
    }

    public function getAllOrders(){

        try {
            $startDate=$this->input->post('startDate');
            $endDate=$this->input->post('endDate');
            $orders = $this->model_provider->getAllOrders($startDate,$endDate);
            $response=array('orders'=>$orders,'status'=>'success');
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode($response));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "error")));
        }
    }


    //get Order by Id
    public function getOrder()
    {
        $this->load->model('model_order');
        $id = $this->input->post('id');
        $order = $this->model_order->get($id, 'EAGER');
        $response=array('order_product'=>$order['productsList']);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($response));
    }
}