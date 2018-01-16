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
        if (!$this->session->userdata('isLogin') || ($this->session->userdata('type') != "admin")) {
            if(!$this->input->is_cli_request()){
                redirect('login');
            }
        }

        $this->load->model('model_product');
        $this->load->model('model_meal');


    }

    /**
     *
     */
    public function index()
    {

        //$data = $this->readSalesCSV('uploads/XAFUL.CSV');

        $data['params'] = $this->getParams();

        $this->load->view('admin/uniwell/index',$data);
    }
    public function index2()
    {

        //$data = $this->readSalesCSV('uploads/XAFUL.CSV');

        $data['params'] = $this->getParams();
        $this->load->model('model_report');
        $this->load->model('model_meal');
        $meals= $this->model_meal->getMealsOnly();
        $data['mealsName']=array_column($meals,"name");
        $data['meals']= $meals;
        $data['mealsList'] = $this->model_meal->getAll();
        $data["sales"]=$this->model_report->reportRange(Date("Y-m-d"), Date("Y-m-d"));
        $this->load->view('admin/uniwell/index2',$data);
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
        $data['rows'] = $rows;
        $data['dateTime'] = $dateTime;
        $this->log_end($data);
        return $data;
    }
    public function apiLoadFile()
    {
        try {
            $this->log_begin();
            $file_path = $this->uploadFile();
            $data['sales'] = $this->readSalesCSV($file_path);

            foreach ($data['sales']['rows'] as $key => $sale) {
                $meal = $this->model_meal->getByExternalCode($sale['0']);
                $quantity = $sale[2] / 1000;
                $priceCSV= $sale['3'] / 100 / $quantity;
                if($meal['name']=== $sale['1'] /*and $priceCSV == $meal['sellPrice']*/){
                    $data['sales']['rows'][$key]['status']='valid';
                }else{
                    $data['sales']['rows'][$key]['status'] = 'Invalid';
                    //$data['sales']['rows'][$key]['meal'] = $meal;
                }
            }
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success', 'response' => $data)));
            $this->log_end($data);
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }


    public function ftp()
    {
        try {
            $this->log_begin();
            //$data['sales'] = $this->readSalesCSV(base_url('uploads/ftp/x-plu_1_0001001.csv'));
            $data['sales'] = $this->readSalesCSV('/var/www/html/fiori/uploads/ftp/x-plu_1_0001001.csv');
            $mealsList=array();
            $this->log_middle($data['sales']);
            foreach ($data['sales']['rows'] as $key => $sale) {
                $meal = $this->model_meal->getByExternalCode($sale['0']);
                $quantity = $sale[2] / 1000;
                $priceCSV= $sale['3'] / 100 / $quantity;
                $date=explode('T', $data['sales']['dateTime'])[0];
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
                }else{
                    $data['sales']['rows'][$key]['status'] = 'Invalid';

                }
            }
            $this->log_middle($mealsList);
            $this->clean();
            $this->model_meal->consumption($mealsList);
            $this->log_end(array('status' => 'error'));

        } catch (Exception $e) {

        }
    }


    private function uploadFile()
    {
        $valid_file = true;
        $message = '';
        //if they DID upload a file...
        if ($_FILES['image']['name']) {
            //if no errors...
            if (!$_FILES['image']['error']) {
                //now is the time to modify the future file name and validate the file
                $new_file_name = strtolower($_FILES['image']['name']); //rename file
                if ($_FILES['image']['size'] > (20024000)) //can't be larger than 20 MB
                {
                    $valid_file = false;
                    $message = 'Oops!  Your file\'s size is to large.';
                }

                //if the file has passed the test
                if ($valid_file) {
                    $file_path = 'assets/images/' . $new_file_name;
                    move_uploaded_file($_FILES['image']['tmp_name'], FCPATH . $file_path);
                    $message = 'Congratulations!  Your file was accepted.';
                }
            } //if there is an error...
            else {
                //set that to be the returned message
                $message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['image']['error'];
            }
        }
        $save_path = base_url() . $file_path;
        $this->log_end(array('file_upload_status' => 'success'));
        return $file_path;
    }

    public function searchMeal()
    {
        $this->log_begin();
        try {
            $mealName = $this->input->post("mealName");
            $meal=$this->model_meal->getByName($mealName);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success', 'meal' => $meal)));
            $this->log_end($meal);
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
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



}

