<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Agency extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isLogin')) {
            redirect('login');
        }

        $this->load->model('model_product');
        $this->load->model('model_meal');
        $this->load->model('model_report');


    }

    public function index()
    {
        $this->log_begin();
        $data['articles']=$this->model_report->report();
        $data['params'] = $this->getParams();
        $this->load->view('admin/agency/article', $data);
        $this->log_end($data);
    }
    public function statistic()
    {
        $this->log_begin();
        $data['articles']=$this->model_report->report();
        $data['report'] = $this->model_report->global_report();
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
}

