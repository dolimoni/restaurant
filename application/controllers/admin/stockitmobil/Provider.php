<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 9/6/18
 * Time: 5:44 PM
 */

class Provider extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_provider');
        $this->load->model('model_order');
    }


    public function getOrders(){


        try {

            $stockitmain_provider=$this->input->post('provider_id');
            $status=$this->input->post('status');


            $provider=$this->model_order->changeStatus('provider','stockitmain',$stockitmain_provider);

            $response= $this->model_provider->getOrders($provider[0]['id']);

            $data['orders']=$response;

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode($data));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "error")));
        }
    }

    public function getOrder(){


        try {

            $order_id=$this->input->post('order_id');

            $response= $this->model_order->get($order_id,'EAGER');

            $data['order']=$response['productsList'];

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode($data));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "error")));
        }
    }
}