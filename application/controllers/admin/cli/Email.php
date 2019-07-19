<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Before uploade :
 *
 * change readSalesCSV destination in -f ftp
 *
 */

class Email extends BaseController
{


    public function __construct()
    {

        parent::__construct();



    }


    public function sendEmail()
    {


        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'dolimoni.kei@gmail.com',
            'smtp_pass' => 'Kei@110692',
            'mailtype' => 'html',
            'newline' => "\r\n",
            'charset' => 'utf-8'
        );

        $this->load->library('email', $config);
        $this->email->from('manager.contact8@gmail.com', 'Contact');
        //$this->email->to($e_params['to']);
        $this->email->to('khalid.essalhi8@gmail.com');
        $this->email->subject('Bon de commande');
        $this->email->message(mb_convert_encoding("Test", "UTF-8"));
        //
        //return $this->email->send();
        if ($this->email->send()) {
            var_dump('Your email was sent')  ;
        } else {
            $error= $this->email->print_debugger();

            var_dump($error) ;
        }
        /*try {

       } catch (Exception $e) {

       }*/
    }

    public function ftp()
    {
        $params=$this->getParams();
        if($params['app_sales']==='sioges'){
            $this->siogesFTP();
        }else if($params['app_sales']==='uniwell'){
            $this->uniwellFTP();
        }
    }


    public function siogesFTP(){
        try {
            $file = FCPATH.'uploads/ftp/rapport.xls';
            $data['sales'] = $this->model_sale->readSiogesSales($file);
            $mealsList=$this->model_sale->getSiogesMeals($data);
            $this->clean();
            $this->model_meal->consumption($mealsList,false,true);

        } catch (Exception $e) {

        }
    }

    public function uniwellFTP(){
        try {
            $this->log_begin();
            $data['sales'] = $this->readSalesCSV(FCPATH.'uploads/ftp/z-plu_1_0001001.csv');
            $mealsList=array();
            $this->log_middle($data['sales']);
            foreach ($data['sales']['rows'] as $key => $sale) {
                $meal = $this->model_meal->getByExternalCode($sale['0']);
                $quantity = $sale[2] / 1000;
                $priceCSV= $sale['3'] / 100 / $quantity;
                $date=explode('T', $data['sales']['dateTime']);
                $mealItem=array(
                    'id'=>$meal['id'],
                    'externalCode'=>$sale['0'],
                    'quantity'=> $sale[2] / 1000,
                    'amount'=>$sale['3'] / 100,
                    'date'=> $date
                );
                if($meal['name']=== $sale['1'] /*and $priceCSV == $meal['sellPrice']*/){
                    $data['sales']['rows'][$key]['status']='valid';
                    $mealsList[]=$mealItem;
                }else if(!$meal){
                    $undefinedMeal = $this->model_meal->createUndefined($sale['0'], $sale['1']);
                    $meal_id = $this->model_meal->addSimpleMeal($undefinedMeal);
                    $mealItem["id"] = $meal_id;
                    $data['sales']['rows'][$key]['status'] = 'valid';
                    $mealsList[] = $mealItem;
                }else{
                    $data['sales']['rows'][$key]['status'] = 'valid';
                    $mealsList[] = $mealItem;
                }
            }
            $this->log_middle($mealsList);
            $this->clean();
            $this->model_meal->consumption($mealsList,false,true);
            //$this->model_meal->consumptionPart();
            $this->log_end(array('status' => 'success'));

            echo "ftp done";
            echo FCPATH;

        } catch (Exception $e) {

        }
    }


    public function clean()
    {
        $this->load->model('model_util');
        $this->model_util->clean();
    }

    public function clear()
    {
        $this->load->model('model_util');
        $this->model_util->clear();
    }

    public function populate()
    {
        $this->load->model('model_util');
        $this->model_util->populate();
    }


    public function log_begin()
    {
        log_message('info', "dolimoni=>Log_begin: " . $this->router->fetch_class() . " " . $this->router->fetch_method());
        $data = print_r($this->input->post(NULL, TRUE), TRUE);
        log_message('info', ($data));
    }

    public function log_middle($data)
    {
        log_message('info', "dolimoni=>Log_middle: " . json_encode($data));
    }

    public function log_end($data)
    {
        log_message('info', "dolimoni=>Log_end: " . json_encode($data));
    }


}

