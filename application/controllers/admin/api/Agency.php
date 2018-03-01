<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class Agency extends BaseController
{


    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_product');
        $this->load->model('model_meal');
        $this->load->model('model_report');



    }

    public function apiAllAgenciesStatistics(){

        $this->load->library("util");
        $this->log_begin();
        try {

            //init data

            //agencies
            $mainAgency=array(
                "id"=>1,
                "base_url"=> base_url(''),
                "link"=> "admin/api/report/apiStatistic",
            );
            $agency1=array(
                "id"=>2,
                "base_url"=> "https://fiori.ga",
                "link" => "/admin/api/report/apiStatistic",
            );
            $agencies=array();
            $agencies[]= $mainAgency;
            $agencies[]= $agency1;

            $curlData=array(
                "startDate" => $this->input->post('startDate'),
                "endDate"=> $this->input->post('endDate')
            );

            $responses=array();
            foreach ($agencies as $agency) {
                $url = $agency["base_url"] . $agency["link"];
                $server_output = $this->curl($url, $curlData);
                if($server_output===false){
                    $this->log_middle("curl false:");
                }else{
                    $responses[] = json_decode($server_output, true);
                }

            }
            $reportContent=$this->globalAgenciesReport($responses);
            $report["report"]= $reportContent;
            $report["status"]= "success";
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode($report));

            $this->log_end($report);
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "error", 'report' => $report)));
        }
    }

    private function globalAgenciesReport($responses){
        $report=array();
        $reportArray= array_column($responses,"report");
        $consumption = array_column($reportArray, "consumption");
        $cp = array_column($reportArray, "cp");
        $purchase = array_column($reportArray, "purchase");
        $repair = array_column($reportArray, "repair");
        $sales_history = array_column($reportArray, "sales_history");
        $stock_history = array_column($reportArray, "stock_history");


        $report["consumption"] = $this->util->array_merge_numeric_values($consumption);
        $report["cp"] = $this->util->array_merge_numeric_values($cp);
        $report["purchase"] = $this->util->array_merge_numeric_values($purchase);
        $report["repair"] = $this->util->array_merge_numeric_values($repair);
        $report["sales_history"] = $this->util->array_merge_numeric_values($sales_history);
        $report["stock_history"] = $this->util->array_merge_numeric_values($stock_history);
        return $report;
    }
    //$url : link
    //$data: params
    private function curl($url,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS,
            http_build_query($data));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        if($server_output===false){
            $error = curl_error($ch);
            $this->log_middle("curl false:" . $error);
        }
        curl_close($ch);

        return $server_output;

    }

    public function apiStatistic()
    {
        try{
       $this->log_begin();
           $this->load->model("model_agency");
           $startDate = $this->input->post('startDate');
           $endDate = $this->input->post('endDate');
           $agency_id = $this->input->post('agency_id');
            $report=array();
           if($agency_id==="1"){
               $agency_id=0;
           }
           if($agency_id==="all"){
               $this->load->model("model_agency");
               $agencies=$this->model_agency->getAll(true);
               foreach ($agencies as $agency) {
                   if($agency["id"]==="1"){
                       $this->model_report->setCurrentDb(0);
                   }else{
                       $this->model_report->setCurrentDb($agency["id"]);
                   }
                   $local_report = $this->model_report->global_report($startDate, $endDate);
                   $report=$this->merge($report, $local_report);
                   $this->model_report->setCurrentDb(0);
               }
           }else{
               $this->model_report->setCurrentDb($agency_id);
               $report = $this->model_report->global_report($startDate, $endDate);
               $this->model_report->setCurrentDb(0);
           }
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => "success", 'report' => $report)));
           $this->log_end($report);
       } catch (Exception $e) {
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => "success", 'report' => $report)));
       }
    }

    private function merge($array_one,$array_two){
        $array = array();
        foreach (array_keys($array_two) as $key) {
            switch ($key) {
                case "charges":
                    $charges1 = isset($array_one[$key]) ? $array_one[$key] : 0;
                    $charges2 = isset($array_two[$key]) ? $array_two[$key] : 0;
                    $array[$key] = $charges1+ $charges2;
                    break;

                case "stock_history":
                    $charges1 = isset($array_one[$key]) ? $array_one[$key] : 0;
                    $charges2 = isset($array_two[$key]) ? $array_two[$key] : 0;
                    $array[$key] = $charges1+ $charges2;
                    break;
                case "consumption":
                    $quantity1 = isset($array_one[$key]["turnover"]) ? $array_one[$key]["turnover"] : 0;
                    $quantity2 = isset($array_two[$key]["turnover"]) ? $array_two[$key]["turnover"] : 0;
                    $array[$key]["turnover"] = ($quantity1) + ($quantity2);
                    break;

                case "salary":
                    $salary1 = isset($array_one[$key]["salary"]) ? $array_one[$key]["salary"] : 0;
                    $salary2 = isset($array_two[$key]["salary"]) ? $array_two[$key]["salary"] : 0;
                    $array[$key]["salary"] = ($salary1) + ($salary2);
                    break;

                case "purchase":
                    $purchase1 = isset($array_one[$key]["price"]) ? (float)($array_one[$key]["price"]) : 0;
                    $purchase2 = isset($array_two[$key]["price"]) ? (float)($array_two[$key]["price"]) : 0;
                    $array[$key]["price"] = ($purchase1) + ($purchase2);
                    break;

                case "repair":
                    $repair1 = isset($array_one[$key]["price"]) ? (float)($array_one[$key]["price"]) : 0;
                    $repair2 = isset($array_two[$key]["price"]) ? (float)($array_two[$key]["price"]) : 0;
                    $array[$key]["price"] = ($repair1) + ($repair2);
                    break;

                case "consumption_history":
                    $st_part1 = isset($array_one[$key]["st_part1"]) ? $array_one[$key]["st_part1"] : 0;
                    $st_part2 = isset($array_two[$key]["st_part2"]) ? $array_two[$key]["st_part2"] : 0;
                    $array[$key]["st_part"] = ($st_part1) + ($st_part2);

                    $nd_part1 = isset($array_one[$key]["nd_part1"]) ? $array_one[$key]["nd_part1"] : 0;
                    $nd_part2 = isset($array_two[$key]["nd_part2"]) ? $array_two[$key]["nd_part2"] : 0;
                    $array[$key]["nd_part"] = ($nd_part1) + ($nd_part2);

                    $rd_part1 = isset($array_one[$key]["rd_part1"]) ? $array_one[$key]["rd_part1"] : 0;
                    $rd_part2 = isset($array_two[$key]["rd_part2"]) ? $array_two[$key]["rd_part2"] : 0;
                    $array[$key]["rd_part"] = ($rd_part1) + ($rd_part2);
                    break;

                case "sales_history":
                    $array[$key] = $array_two[$key];
                         if (isset($array_one[$key])) {
                             foreach ($array_one[$key] as $sub_key1 => $item1) {
                                 $date_exists=false;
                                 foreach ($array[$key] as $sub_key2 => $item2) {
                                     $aa= $item1["report_date"];
                                     $bb= $item2["report_date"];
                                     if ($aa === $bb) {
                                         $s_amount1 = $item1["s_amount"];
                                         $array[$key][$sub_key2]["s_amount"] += $s_amount1;
                                         $date_exists = true;
                                         break;
                                     }
                                 }
                                 if(!$date_exists){
                                     $data=array(
                                         "report_date"=> $item1["report_date"],
                                         "s_amount"=> $item1["s_amount"],
                                     );
                                     $array[$key][] = $data;
                                 }
                             }
                        }
                        $array[$key]=$this->sortDate($array[$key],"report_date");
                    break;

                    case "charges_history":
                    $array[$key] = $array_two[$key];
                         if (isset($array_one[$key])) {
                             foreach ($array_one[$key] as $sub_key1 => $item1) {
                                 $date_exists=false;
                                 foreach ($array[$key] as $sub_key2 => $item2) {
                                     $aa= $item1["paymentDate"];
                                     $bb= $item2["paymentDate"];
                                     if ($aa === $bb) {
                                         $s_amount1 = $item1["price"];
                                         $array[$key][$sub_key2]["price"] += $s_amount1;
                                         $date_exists = true;
                                         break;
                                     }
                                 }
                                 if(!$date_exists){
                                     $data=array(
                                         "paymentDate"=> $item1["paymentDate"],
                                         "price"=> $item1["price"],
                                     );
                                     $array[$key][] = $data;
                                 }
                             }
                        }
                        $array[$key]=$this->sortDate($array[$key],"paymentDate");
                    break;
            }
        }
        return $array;
    }

    function date_fct($a, $b)
    {
        return strtotime($a) - strtotime($b);
    }

    private function sortDate($data,$columnName)
    {
        $columnArray = array_column($data, $columnName);


        usort($columnArray, array($this,"date_fct"));

        $response=array();

            foreach ($columnArray as $columnElement) {
                foreach ($data as $dataElement) {
                    if ($columnElement === $dataElement[$columnName]) {
                        $response[] = $dataElement;
                    }
                }
            }

        return $response;
    }
    public function apiReport()
    {
        $this->log_begin();
        $params=$this->input->post('params');
        $articles=$this->model_report->report($params);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'articles' => $articles)));
        $this->log_end($articles);
    }
    public function apiRange()
    {
        $this->log_begin();
        $startDate=$this->input->post('startDate');
        $endDate=$this->input->post('endDate');
        $this->session->set_userdata('startDate', $startDate);
        $this->session->set_userdata('endDate', $endDate);
        $articles=$this->model_report->reportRange($startDate,$endDate);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true,'articles'=>$articles)));
        $this->log_end($articles);
    }

    public function apiPriceRange()
    {
        $this->log_begin();
        $startDate=$this->input->post('startDate');
        $endDate=$this->input->post('endDate');
        $product=$this->input->post('product');
        $prices=$this->model_report->pricesHistory($startDate,$endDate,$product);
        $providers=$this->model_product->getProviders($product);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => 'success','prices'=> $prices,'providers'=> $providers)));
        $this->log_end(array('status' => 'success', 'prices' => $prices, 'providers' => $providers));
    }

    public function view()
    {
        $this->log_begin();
        $meal_id = $this->uri->segment(4);
        $data['meal'] = $this->model_meal->get($meal_id);
        $data['products'] = $this->model_meal->getProducts($meal_id);

        $this->parser->parse('admin/meal/view_meal', $data);
        $this->log_end($data);
    }

    public function mypdfTest()
    {
        $meal_id = $this->uri->segment(4);
        $data['meal'] = $this->model_meal->get($meal_id);
        $data['products'] = $this->model_meal->getProducts($meal_id);

        $this->parser->parse('admin/meal/pdf/view_meal', $data);
    }

    function mypdf()
    {
        $id = $this->input->post('id');
        //$id=1;

        $data['meal'] = $this->model_meal->get($id);
        $data['products'] = $this->model_meal->getProducts($id);

        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $html = $this->load->view('admin/meal/pdf/view_meal', $data, true);
        $pdf->WriteHTML($html);
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
    }

    public function add()
    {

        $this->log_begin();
        if (!$this->input->post('addProvider')) {
            $data['message'] = '';
            $data['providers'] = $this->model_provider->getAll();
            $this->parser->parse('admin/provider/add', $data);
            $this->log_end($data);
        } else {
            $title = $this->input->post('title');
            $name = $this->input->post('name');
            $prenom = $this->input->post('prenom');
            $address = $this->input->post('address');
            $phone = $this->input->post('phone');
            $mail = $this->input->post('mail');
            $image = $_FILES['image']['name'];
            $this->uploadFile();
            $provider = array('title' => $title, 'name' => $name, 'prenom' => prenom, 'address' => $address, 'phone' => $phone, 'mail' => $mail, 'image' => $image);
            $this->log_middle($provider);
            $this->model_provider->add($provider);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => true)));
            $this->log_end(array('status' => true));

        }

    }

    public function apiAddProducts()
    {
        $this->log_begin();
        $productsList = $this->input->post('productsList');
        $this->model_provider->addProducts($productsList);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true)));
        $this->log_end(array('status' => true));
    }

    public function show()
    {
        $this->log_begin();
        $id = $this->uri->segment(4);
        $data['provider'] = $this->model_provider->get(1)[0];
        $data['products'] = $this->model_provider->getProducts(1);
        $this->load->view('admin/provider/show', $data);
        $this->log_end($data);
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
    }

    function apiPrintOrder()
    {
        $this->log_begin();
        $order = $this->input->post('order');
        $data['order'] = $order;
        $output = $this->createPDF($data);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'filepath' => $output)));
        $this->log_end(array('status' => true, 'filepath' => $output));
    }

    function order()
    {
        $this->log_begin();
        $order = $this->input->post('order');
        $data['order'] = $order;
        $output = $this->createPDF($data);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'filepath' => $output)));
        $this->log_end(array('status' => true, 'filepath' => $output));
    }

    function createPDF($data)
    {

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $html = $this->load->view('admin/provider/pdf/order', $data, true);
        $pdf->WriteHTML($html);
        $output = 'uploads/pdf/itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output(FCPATH . "$output", 'F');
        return $output;

    }

    function orderTest()
    {
        //$order = $this->input->post('order');
        $this->load->view('admin/provider/pdf/order', true);

    }


    public function edit($cid)
    {
        $this->log_begin();
        if (!$this->input->post('buttonSubmit')) {
            $data['message'] = '';
            $userRow = $this->model_employee->get($cid);
            $data['userRow'] = $userRow;
            $this->load->view('admin/view_editemployee', $data);
            $this->log_end($data);
        } else {
            if ($this->form_validation->run('editemp')) {
                $f_name = $this->input->post('f_name');
                $l_name = $this->input->post('l_name');
                $u_bday = $this->input->post('u_bday');
                $u_position = $this->input->post('u_position');
                $u_type = $this->input->post('u_type');
                $u_pass = md5($this->input->post('u_pass'));
                $u_mobile = $this->input->post('u_mobile');
                $u_gender = $this->input->post('u_gender');
                $u_address = $this->input->post('u_address');
                $u_id = $this->input->post('u_id');
                $this->model_employee->update($f_name, $l_name, $u_bday, $u_position, $u_type, $u_pass, $u_mobile, $u_gender, $u_address, $u_id);
                redirect(base_url('admin/employee'));
            } else {
                $data['message'] = validation_errors();  //data ta message name er lebel er kase pathay
                $this->load->view('view_employee', $data);
                $this->log_end($data);
            }
        }
    }

    public function delete($cid)
    {
        $this->log_begin();
        $this->model_employee->delete($cid);
        $this->session->set_flashdata('message', 'Employee Successfully deleted.');
        $this->log_end(array('status' => true));
        redirect(base_url('admin/employee'));
    }
}

