<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isLogin')) {
            redirect('login');
        }

        $this->load->model('model_group');
        $this->load->model('model_product');


        $this->load->model('model_product');
        $this->load->model('model_meal');
        $this->load->model('model_report');


    }

    public function index()
    {
        $this->log_begin();
        $startDate = date('Y-m-d', strtotime('-12 month'));
        $endDate = date('Y-m-d');
        $this->session->set_userdata('startDate', $startDate);
        $this->session->set_userdata('endDate', $endDate);
        $data['articles']=$this->model_report->report(null,$startDate,$endDate);
        $data['params'] = $this->getParams();
        $this->load->view('admin/report/article', $data);
        $this->log_end($data);
    }
    public function statistic()
    {
        $this->log_begin();
        $data['articles']=$this->model_report->report();
        $start = date('Y-m-d', strtotime('-1é month'));
        $end = date('Y-m-d');
        $data['report'] = $this->model_report->global_report($start,$end);
        $this->load->model('model_budget');
        $data['alertes'] = $this->model_budget->getActiveAlerts();
        $data['params'] = $this->getParams();
        $this->load->view('admin/report/view_statistic', $data);
        $this->log_end($data);
    }

    public function apiStatistic()
    {
       $this->log_begin();
        $this->load->model('model_provider');
       try {
           $startDate = $this->input->post('startDate');
           $endDate = $this->input->post('endDate');
           $report = $this->model_report->global_report($startDate, $endDate);
           $report['orders']=$this->model_report->providerReport($startDate,$endDate);
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
        $this->load->model('model_provider');
        $params=$this->input->post('params');
        $start = date('Y-m-d', strtotime('-12 month'));
        $end = date('Y-m-d');
        $articles=$this->model_report->report($params,$start,$end);
        $report=$this->model_report->providerReport($start,$end);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'articles' => $articles,'report'=>$report)));
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

    public function apiPrintSpendingReport(){
        $this->log_begin();
        try {
            $startDate = $this->input->post('startDate');
            $endDate = $this->input->post('endDate');
            $report = $this->model_report->global_report_detail($startDate, $endDate);
            $report["startDate"]= date('d-m-Y', strtotime($startDate));
            $report["endDate"]= date('d-m-Y', strtotime($endDate));
            //var_dump($report);die();
            $output = $this->createPDF($report,"order");
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "success", 'filepath' => $output)));
            $this->log_end($report);
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "success", 'report' => $report)));
        }
    }
    public function apiPrintGlobalReport(){
        $this->log_begin();
        try {
            $startDate = $this->input->post('startDate');
            $endDate = $this->input->post('endDate');
            $report = $this->model_report->global_report_detail($startDate, $endDate,false);
            $report["startDate"]= date('d-m-Y', strtotime($startDate));
            $report["endDate"]= date('d-m-Y', strtotime($endDate));
            $output = $this->createPDF($report,"global");
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "success", 'filepath' => $output)));
            $this->log_end($report);
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "success", 'report' => $report)));
        }
    }

    public function apiPrintSalesReport(){
        $this->log_begin();
        try {
            $startDate = $this->input->post('startDate');
            $endDate = $this->input->post('endDate');
            $report = $this->model_report->global_report_detail($startDate, $endDate);
            $report["startDate"]= date('d-m-Y', strtotime($startDate));
            $report["endDate"]= date('d-m-Y', strtotime($endDate));
            //var_dump($report);die();
            $output = $this->createPDF($report,"sale");
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "success", 'filepath' => $output)));
            $this->log_end($report);
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => "success", 'report' => $report)));
        }
    }


    private function createPDF($data,$type="order")
    {

        $this->load->library('pdf');
        $data['params'] = $this->getParams();
        $pdf = $this->pdf->load();
        $html="";
        if($type === "order"){
            $html = $this->load->view('admin/report/pdf/order', $data, true);
        }else if($type === "sale"){
            $html = $this->load->view('admin/report/pdf/sale', $data, true);
        }else if($type === "global"){
            $html = $this->load->view('admin/report/pdf/global', $data, true);
        }
        $pdf->WriteHTML($html);
        $output="";
        if($type === "order"){
            $output = 'uploads/pdf/order' . date('Y_m_d_H_i_s') . '_.pdf';
        }else if($type === "sale"){
            $output = 'uploads/pdf/sale' . date('Y_m_d_H_i_s') . '_.pdf';
        }else if($type === "global"){
            $output = 'uploads/pdf/global' . date('Y_m_d_H_i_s') . '_.pdf';
        }
        $pdf->Output(FCPATH . "$output", 'F');
        return $output;

    }

    function reportTest()
    {
        $data['params'] = $this->getParams();
        //$order = $this->input->post('order');
        $data["report"] = $this->model_report->global_report_detail("2017-01-01", "2019-01-01");
        $this->load->view('admin/report/pdf/report', $data);

    }

}

