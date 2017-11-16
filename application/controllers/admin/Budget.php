<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Budget extends CI_Controller {

	public function __construct()
	{

		parent::__construct();
        if ( ! $this->session->userdata('isLogin')) { 
            redirect('login');
        }

        $this->load->model('model_budget');

	}

	public function index()
	{

    }

    public function regular()
    {
        $data['regularCosts'] = $this->model_budget->getRegularCosts();
        $this->load->view('admin/budget/regular', $data);
    }
    public function reparation()
    {
        $data['reparations']= $this->model_budget->getReparations();
        $this->load->view('admin/budget/reparation',$data);
    }
    public function purchase()
    {
        $data['purchases']= $this->model_budget->getPurchases();
        $this->load->view('admin/budget/purchase',$data);
    }

    public function apiAddRepartion(){
       try {
           $article = $this->input->post('article');
           $price = $this->input->post('price');
           $problem = $this->input->post('problem');
           $repairer = $this->input->post('repairer');

           $reparation = array(
               'article' => $article,
               'price' => $price,
               'problem' => $problem,
               'repairer' => $repairer,
           );
           $this->model_budget->addReparation($reparation);
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'success')));
       } catch (Exception $e) {
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'error')));
       }
    }

    public function apiAddPurchase(){
       try {
           $article = $this->input->post('article');
           $price = $this->input->post('price');

           $purchase = array(
               'article' => $article,
               'price' => $price,
           );
           $this->model_budget->addPurchase($purchase);
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'success')));
       } catch (Exception $e) {
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'error')));
       }
    }

    public function apiAddRegularCostForm(){
       try {
           $article = $this->input->post('article');
           $price = $this->input->post('price');
           $periodicity = $this->input->post('periodicity');
           $reminderDate = $this->input->post('reminderDate');

           $regularCost = array(
               'article' => $article,
               'price' => $price,
               'periodicity' => $periodicity,
               'reminderDate' => $reminderDate
           );
           $this->model_budget->addRegularCost($regularCost);
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

