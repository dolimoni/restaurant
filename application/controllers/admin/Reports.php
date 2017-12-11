<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends BaseController {


    public function __construct(){
        parent::__construct();
        if ( ! $this->session->userdata('isLogin') || ($this->session->userdata('type') != "admin" )) { 
            redirect('login');
        }

        //$this->load->database();
        $this->load->model('model_report');

    }

    public function index() {
        $data['reports']    = $this->model_report->getAllReports();
        $data['params']     = $this->getParams();
        $this->load->view('admin/daily_report/index', $data);
    }

    public function create() {
        $this->form_validation->set_rules('emails', 'Email', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if($this->form_validation->run() === TRUE){
            $this->model_report->addReport();

            // Set message
            $this->session->set_flashdata('report_created', 'Votre rapport a été bien ajouté');

            redirect('admin/reports');
        }else{
            $data['params'] = $this->getParams();
            $this->load->view('admin/daily_report/create',$data);
        }
    }

    public function viewReport($id) {
        $data['report'] = $this->model_report->getReport($id);
        $data['params'] = $this->getParams();
        $this->load->view('admin/daily_report/viewReport', $data);
    }

    public function editReport($id) {
        // $this->form_validation->set_rules('emails', 'Email', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        $data['params']     = $this->getParams();

        if($this->form_validation->run() === TRUE){
            $this->model_report->editReport();

            // Set message
            $this->session->set_flashdata('report_created', 'Votre rapport a été bien ajouté');

            redirect('admin/reports');
        }else{
            $data['report'] = $this->model_report->getReport($id);
            $this->load->view('admin/daily_report/editReport', $data);
        }
    }

    public function getReportByName() {
        $data = $this->model_report->getUsersSearch($this->input->post('q'));

        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($data));
    }

    public function send($id) {
        $data['report'] = $this->model_report->getReport($id);
        // $this->load->library('Provider');
        // $pro = new Provider();
        // print_r($data['report']);
        if($this->sendEmail($data['report'])){
            $this->model_report->updateSentMail($id);
            redirect('admin/reports');
        }
    }

    public function delete() {
        $data['report'] = $this->model_report->deleteReport($this->input->post('id'));
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($data));
    }

    public function sendEmail($e_params) {

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'manager.contact8@gmail.com',
            'smtp_pass' => 'boujida2030',
            'mailtype' => 'html',
            'newline' => "\r\n",
            'charset' => 'utf-8'
        );
        $send_to = "";
        $this->load->library('email', $config);
        $this->email->from('manager.contact8@gmail.com', 'Contact');
        //$this->email->to($e_params['to']);        
        $emails = explode(";", $e_params['send_to']);
        foreach ($emails as $value) {
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $send_to .= $value.",";
            }
        }

        $this->email->to(rtrim($send_to,", "));
        //$this->email->attach(base_url($e_params['attach']), 'attachment', 'commande.pdf');
        $this->email->subject($e_params['title']." - ".date("d/m/Y"));
        $this->email->message(mb_convert_encoding($e_params['message'], "UTF-8"));
        //
        //return $this->email->send();
        if ($this->email->send()) {
            return 1;
        } else {
            return 0;
        }
        /*try {

       } catch (Exception $e) {

       }*/
    }
}