<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends BaseController {

	public function __construct()
	{
        parent::__construct();
        if (!$this->session->userdata('isLogin') || ($this->session->userdata('type') != "admin")) {
            redirect('login');
        }
        $this->load->model('model_util');
	}


	public function index()
	{
        $this->log_begin();
        $this->load->view('admin/config/index');
	}

	public function delete()
	{
        $this->log_begin();
        $this->load->view('admin/config/delete');
	}

	public function apiDelete()
	{

        try {

            $this->log_begin();
            $tables=$this->input->post("deletes");
            $this->model_util->customClear($tables);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
            $this->log_end(array('status' => 'success'));
            redirect('admin/config/delete', 'refresh');
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }

	}



}