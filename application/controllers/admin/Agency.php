<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Agency extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isLogin')) {
            redirect('login');
        }

        $this->load->model('model_agency');
        $this->load->model('model_product');
        $this->load->model('model_meal');
        $this->load->model('model_report');
        $this->load->model('department/model_department');


    }

    public function index()
    {
        $this->log_begin();
        $aa=$this->model_agency->getCurrentDb();
        $data['agencies'] = $this->model_agency->getAll();
        $data['params'] = $this->getParams();
        $this->load->view('admin/agency/view_agencies', $data);
        $this->log_end($data);
    }

     public function addProducts(){
        $this->log_begin();
        $data['agencies']=$this->model_agency->getAll();
        $data['products'] = $this->model_product->getAll();
        $data['params'] = $this->getParams();
        $this->load->view('admin/agency/view_addProducts', $data);
        $this->log_end($data);
    }

    public function historyProducts()
    {
        $this->load->model('department/model_stock');
        $data['products'] = $this->model_agency->getProductsHistory();
        $data['productsList'] = $this->model_product->getAll(false, true);
        $data['productsList'] = $this->sortListByName($data['productsList']);
        $data['agencies'] = $this->model_agency->getAll();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/agency/view_historyProducts', $data);
    }
    public function apiFilterHistoryProducts()
    {
        $this->load->model('department/model_stock');
        $startDate=$this->input->post('startDate');
        $endDate=$this->input->post('endDate');
        $groupProducts=$this->input->post('groupProducts');
        $agency=$this->input->post('agency');
        try {
            $data['products'] = $this->model_agency->getProductsHistory($agency,$groupProducts,$startDate,$endDate);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success','response'=>$data)));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function show($id)
    {
        $data['params'] = $this->getParams();
        $agency= $this->model_agency->getAgency($id);
        $data["agency"]= $agency;
        // si on est dans le stock interne
        if($agency["type"]==="master"){
            //selectionner la liste des produits dans le departement principal de la production
            $data['products'] = $this->model_agency->getProducts($id);
        }else{
            //selectionner la liste des produits actuels dans une agence
            $this->model_product->setCurrentDb($id);
            $data['products'] = $this->model_product->getAll();
            $this->model_product->setCurrentDb(0);
        }
        $this->parser->parse('admin/agency/view_agency', $data);
    }

    public function apiAddStock(){

        try {
            $stock = $this->input->post('stock');
            $this->model_agency->addStock($stock);

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function apiEditAgency()
    {
        try {
            $name = $this->input->post('agencyNameEdit');
            $id = $this->input->post('id');
            $image = $_FILES['image']['name'];
            $agency = array('name' => $name);
            if ($image !== "") {
                $agency['image'] = $image;
                $this->uploadFile();
            }
            $this->model_agency->editAgency($id, $agency);

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }

    }

    public function apiEditStockHistory()
    {
        try {
            $stock_history = $this->input->post('stock_history');
            $response = $this->model_agency->editStockHistory($stock_history["id"], $stock_history["quantity"]);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode($response));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }

    }

    public function apiDeleteStock()
    {
        try {
            $stock_history_id = $this->input->post('stock_history_id');
            $response = $this->model_agency->deleteStockHistory($stock_history_id);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode($response));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }

    }


    public function statistic()
    {
        $this->log_begin();
        $data['articles']=$this->model_report->report();
        $data['agencies'] = $this->model_agency->getAll(true);
        $start = date('Y-m-d', strtotime('-1 month'));
        $end = date('Y-m-d');
        $data['report'] = $this->model_report->global_report($start,$end);
        $this->load->model('model_budget');
        $data['alertes'] = $this->model_budget->getActiveAlerts();
        $data['params'] = $this->getParams();
        $this->load->view('admin/agency/view_statistic', $data);
        $this->log_end($data);
    }

    public function apiStatistic()
    {
       $this->log_begin();
       try {
           $startDate = $this->input->post('startDate');
           $endDate = $this->input->post('endDate');
           $report = $this->model_report->global_report($startDate, $endDate);
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

    public function apiActivate(){
        $this->log_begin();
        try {
            $id = $this->input->post('id');
            $this->model_agency->setCurrentAgency($id);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "success")));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "success")));
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
    }

    private function sortListByName($data)
    {
        function cmpList($a, $b)
        {
            if ($a == $b)
                return 0;
            return ($a['name'] < $b['name']) ? -1 : 1;
        }

        usort($data, "cmpList");
        return $data;

    }
}

