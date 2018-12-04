<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 9/6/18
 * Time: 5:44 PM
 */

class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_provider');
        $this->load->model('model_order');
    }


    public function changeStatus(){

        try {
            $order_id=$this->input->post('order_id');
            $status=$this->input->post('status');
            $response= $this->model_order->changeStatus($order_id,$status);
            $data['order']=$response;

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