<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Budget extends BaseController {

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
        $this->load->model('model_params');
        $data['regularCosts'] = $this->model_budget->getRegularCosts();
        $data['params'] = $this->model_params->config();
        $data['params'] = $this->getParams();
        $this->load->view('admin/budget/view_regular', $data);
    }
    public function reparation()
    {
        $data['reparations']= $this->model_budget->getReparations();
        $data['params'] = $this->getParams();
        $this->load->view('admin/budget/reparation',$data);
    }
    public function purchase()
    {
        $data['purchases']= $this->model_budget->getPurchases();
        $data['params'] = $this->getParams();
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
           $description = $this->input->post('description');
           $paiementDate = $this->input->post('paiementDate');

           $regularCost = array(
               'article' => $article,
               'price' => $price,
               'periodicity' => $periodicity,
               'reminderDate' => $reminderDate,
               'description' => $description,
               'paiementDate' => $paiementDate,
           );
           $this->model_budget->addRegularCost($regularCost);

           $this->model_budget->activeAlerts();
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'success')));
       } catch (Exception $e) {
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'error')));
       }
    }

    public function apiReportAlert(){
        try {
            $alert = $this->input->post('alert');
            if($alert['reminderDate']<date('Y-m-d')){
                $alert['reminderDate']= date('Y-m-d');
            }
            $reminderDate = date('Y-m-d', strtotime($alert['reminderDate'] . ' +1 '. $alert['delay']));


            $data=array(
              'reminderDate'=> $reminderDate,
               'status'=>'passive'
            );
            if(isset($alert['paiementDate']) and $alert['updatePaiementDate']){
                $data['paiementDate']= date('Y-m-d', strtotime($alert['paiementDate'] . ' +1 ' . $alert['delay']));
            }
            $this->model_budget->updateAlertDates($alert['id'],$data);


            $this->model_budget->activeAlerts(); // change passive alerte to active aletes
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }

    }


    public function apiEditAlert(){
        try {
            $alert = $this->input->post('alert');
            $id = $this->input->post('id');
            $this->model_budget->update($id, $alert);

            $this->model_budget->activeAlerts(); // change passive alerte to active aletes
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }

    }

    public function apiDeleteAlert(){
        try {
            $alert_id = $this->input->post('alert_id');
            $this->model_budget->deleteAlert($alert_id);

            $this->model_budget->activeAlerts(); // change passive alerte to active aletes
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

