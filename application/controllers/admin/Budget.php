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
        $this->log_begin();
        $this->load->model('model_params');
        $data['regularCosts'] = $this->model_budget->getRegularCosts();
        $data['params'] = $this->model_params->config();
        $data['params'] = $this->getParams();
        $this->load->view('admin/budget/view_regular', $data);
        $this->log_end($data);
    }
    public function reparation()
    {
        $this->log_begin();
        $data['reparations']= $this->model_budget->getReparations();
        $data['params'] = $this->getParams();
        $this->load->view('admin/budget/reparation',$data);
        $this->log_end($data);
    }
    public function variousPurchase()
    {
        $this->log_begin();
        $data['purchases']= $this->model_budget->getPurchases();
        $data["report"]['purchase_history']= $this->model_budget->purchase_history();
        $data['params'] = $this->getParams();
        $this->load->view('admin/budget/purchase',$data);
        $this->log_end($data);
    }
    public function productPurchase()
    {
        $this->log_begin();
        $this->load->model('model_product');
        $data['products'] = $this->model_product->getInStockHistory();
        $data['params'] = $this->getParams();
        $this->load->view('admin/budget/view_product',$data);
        $this->log_end($data);
    }

    public function apiAddRepartion(){
       try {
           $this->log_begin();
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
           $this->log_middle($reparation);
           $this->model_budget->addReparation($reparation);
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

    public function apiAddPurchase(){
       try {
           $this->log_begin();
           $article = $this->input->post('article');
           $price = $this->input->post('price');
           $quantity = $this->input->post('quantity');
           $provider = $this->input->post('provider');
           $tel = $this->input->post('tel');
           $comment = $this->input->post('comment');
           $paid = $this->input->post('paid');
           $paymentDate=date("Y-m-d H-m-s");

           $purchase = array(
               'article' => $article,
               'price' => $price,
               'quantity' => $quantity,
               'provider' => $provider,
               'tel' => $tel,
               'comment' => $comment,
               'paid' => $paid,
               'paymentDate' => $paymentDate,
           );
           $this->log_middle($purchase);
           $this->model_budget->addPurchase($purchase);
           $this->log_middle($purchase);
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

    public function apiAddRegularCostForm(){
       try {
           $this->log_begin();
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
           $this->log_middle($regularCost);
           $this->model_budget->addRegularCost($regularCost);

           $this->model_budget->activeAlerts();
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

    public function apiReportAlert(){
        try {
            $this->log_begin();
            $alert = $this->input->post('alert');
            if($alert['delay']==="dai"){
                $alert['delay']="day";
            }
            $newReminderDate= $alert['reminderDate'];
            if($alert['reminderDate']<date('Y-m-d')){
                $newReminderDate= date('Y-m-d');
            }
            $reminderDate = date('Y-m-d', strtotime($newReminderDate . ' +1 '. $alert['delay']));


            $data=array(
              'reminderDate'=> $reminderDate,
               'status'=>'passive'
            );
            if($alert['delay'] === "no"){
                $data['status']="done";
            }
            if(isset($alert['paiementDate']) and $alert['updatePaiementDate']){
                $data['paiementDate']= date('Y-m-d', strtotime($alert['paiementDate'] . ' +1 ' . $alert['delay']));
                $data['reminderDate'] = date('Y-m-d', strtotime($alert['reminderDate'] . ' +1 ' . $alert['delay']));
            }

            $this->log_middle($data);
            $this->model_budget->updateAlertDates($alert['id'],$data);


            $this->model_budget->activeAlerts(); // change passive alerte to active aletes
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


    public function apiEditAlert(){
        try {
            $this->log_begin();
            $alert = $this->input->post('alert');
            $id = $this->input->post('id');
            $this->log_middle($alert);
            $this->model_budget->update($id, $alert);

            $this->model_budget->activeAlerts(); // change passive alerte to active aletes
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

    public function apiEditPurchase(){
        try {
            $this->log_begin();
            $purchase = $this->input->post('purchase');
            $id = $this->input->post('id');
            $this->log_middle($purchase);
            $this->model_budget->updatePurchase($id, $purchase);

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
    public function apiEditReparation(){
        try {
            $this->log_begin();
            $reparation = $this->input->post('reparation');
            $id = $this->input->post('id');
            $this->log_middle($reparation);
            $this->model_budget->updateReparation($id, $reparation);
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

    public function apiDeleteAlert(){
        try {
            $this->log_begin();
            $alert_id = $this->input->post('alert_id');
            $this->model_budget->deleteAlert($alert_id);
            $this->model_budget->activeAlerts(); // change passive alerte to active aletes
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

    public function apiDeletePurchase(){
        try {
            $this->log_begin();
            $purchase_id = $this->input->post('purchase_id');
            $this->model_budget->deletePurchase($purchase_id);
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

    public function apiDeleteReparation(){
        try {
            $this->log_begin();
            $reparation_id = $this->input->post('reparation_id');
            $this->model_budget->deleteReparation($reparation_id);
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
}

