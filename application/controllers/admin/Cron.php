<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends BaseController {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('model_cron');
        //$this->model_cron->updateProductsQuantity();
        // this controller can only be called from the command line
        //if (!$this->input->is_cli_request()) show_error('Direct access is not allowed');

        //$this->model_cron->updateProductsQuantity();

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

    public function productAutoConsum()
    {
        $this->load->model('model_product');
        $this->model_product->autoConsum();
    }
	public function alerte(){
        $this->load->model('model_budget');
        $this->model_budget->activeAlerts(); // change passive alerte to active aletes
    }

    public function alerteSMS(){
        $this->log_begin();
        $this->load->model('model_budget');// contains alertes
        $this->load->model('model_product');// contains alertes
        $this->load->model('model_params');// contains alertes

        $alertes = $this->model_budget->getActiveAlerts();
        $alertes_count= count($alertes);

        $products = $this->model_product->getToOrder();
        $products_count= count($products);

        $config = $this->model_params->config(); // getting user configuration

        $time = date('H:i:s');
        $isTime=false;
        if($config['sms_time'] <= $time && $config["toDayCount"]==3){
            $isTime = true;
        }else if ($config['sms_time2'] <= $time && $config["toDayCount"] == 2) {
            $isTime = true;
        }else if ($config['sms_time3'] <= $time && $config["toDayCount"] == 1) {
            $isTime = true;
        }

        $this->log_middle($config);
        $this->log_middle($products);
        $this->log_middle($alertes);
        $this->log_middle($time);



        /*
         * Conditions for sending sms :
         *
         * $config['sms_status'] : valeur active si quota est >0
         * $config['sms_AlerteStatus_today'] : passive si on a envoyé les alertes d'aujourd'hui
         * $alertes_count doit être > 0 pour envoyer un message d'alerte
         */
        if($config['sms_status']==="active" and $config['sms_AlerteStatus_today']==="active" and ($alertes_count>0 or $products_count>0) and $isTime){
            // send sms
            $this->load->library('Clickatell');
            $sms_content="";
            if($alertes_count > 0){
                $sms_content .= 'Besystem: Vous avez ' . $alertes_count  . ' alertes aujourd\'hui.';
            }if($products_count > 0){
                $sms_content .= 'Besystem: Vous avez ' . $products_count . ' produits à commander';
            }
            $this->clickatell->send_message("+212656011827", $sms_content);

            //configuration
            $sms_available = $config['sms_available']-1;
            $toDayCount = $config['toDayCount']-1;
            $data = array(
                'sms_available'=>$sms_available,
                "toDayCount"=>$toDayCount
            );
            if($sms_available===0){
                $data['sms_status']='passive';
            };
            if($toDayCount===0){
                $data['sms_AlerteStatus_today']='passive';
            };

            $this->model_params->update($data);

            $this->log_middle($data);
            $this->log_ok("end alerte sms");
        }
    }

    public function dayInitConfig(){
        // Sms Configuration
        $this->load->model('model_params');// contains alertes

        $data = array(
            'sms_AlerteStatus_today' => 'active',
        );
        $this->model_params->update($data);

    }

    public function monthInitConfig(){
        // Sms Configuration
        $this->load->model('model_params');// contains alertes
        $config = $this->model_params->config(); // getting user configuration

        $data = array(
            'sms_available' => $config['quota'],
            'sms_status' => 'active',
            'sms_AlerteStatus_today' => 'active',
        );
        $this->model_params->update($data);

    }

    public function control()
    {

        // quantité de la table product doit être toujours egal a la somme des quantités de la table quantity
        $this->load->model('model_product');
        $products = $this->model_product->getAll(false);
        foreach ($products as $product) {
            $quantities = $this->model_product->getAllQuantities($product['id']);
            $totalQuantity = array_sum(array_column($quantities, 'quantity'));
            $data=array(
                'totalQuantity'=> $totalQuantity
            );

            $this->model_product->update($product['id'],$data);
        }
        //$products = $this->model_product->controlQuantity();
    }

    public function automaticSalaryForAll()
    {
        $this->load->model('model_employee');
        $this->model_employee->automaticSalaryForAll();
    }

}