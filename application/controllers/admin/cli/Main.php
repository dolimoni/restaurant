<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Before uploade :
 *
 * change readSalesCSV destination in -f ftp
 *
 */

class Main extends BaseController
{


    public function __construct()
    {

        parent::__construct();

        if (!$this->input->is_cli_request()) {
            echo "Forbidden access";
        }


        $this->load->model('model_product');
        $this->load->model('model_meal');
        $this->load->model('model_sale');


    }


    private function readSalesCSV($file_name){
        $this->log_begin();
        $row = 1;
        $index = 0;
        $rows = array();
        $dateTime='';
        if (($handle = fopen($file_name, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                //echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $data[$c] . "<br />\n";
                }
                if (isset($data[1]) and $data[1] !== "ALL TOTAL" and $row > 7) {

                    //delete 0000 from left
                    $id = ltrim($data[0], '0');
                    $product = $this->model_meal->getByExternalCode($data[0]);

                    if (!isset($product['name'])) {
                        $product = $this->model_product->nullProduct();
                    }

                    $data['product'] = $product;
                    $rows[] = $data;
                }
                if (isset($data[1]) and $data[1] === "ALL TOTAL" and $row > 7) {
                    break;
                }
                if($row===5){
                    if(isset($data[2])){
                        $dateTime = $data[2];
                    }else{
                        $dateTime=date('Y-m-d').'T10';
                    }
                }
                $index++;
            }
            fclose($handle);
        }
        $destination= FCPATH . 'uploads/ftp/old/z-' . date("Y-m-d-H-i-s") . '.csv';
        rename($file_name, $destination);
        echo "destination".$destination."destination";
        $data['rows'] = $rows;
        $data['dateTime'] = $dateTime;
        $this->log_end($data);
        return $data;
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

