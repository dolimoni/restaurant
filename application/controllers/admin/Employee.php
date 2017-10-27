<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	    if ( ! $this->session->userdata('isLogin') || ($this->session->userdata('type') != "admin" )) { 
	        redirect('login');
	    }

		//$this->load->database();
		$this->load->model('model_employee');
        $this->load->model('model_provider');
                
	}
	public function index()
	{	
        $data['emp'] = $this->model_employee->getAll();

        $this->parser->parse('admin/employee/list', $data);
    }

	public function add()
    {

        if (!$this->input->post('addProvider')) {
            $data['message'] = '';
            $data['providers'] = $this->model_provider->getAll();
            $this->parser->parse('admin/employee/add', $data);
        } else {
            $name = $this->input->post('name');
            $prenom = $this->input->post('prenom');
            $cin = $this->input->post('cin');
            $address = $this->input->post('address');
            $phone = $this->input->post('phone');
            $salary = $this->input->post('salary');
            $workType = $this->input->post('workType');
            $image = $_FILES['image']['name'];
            $this->uploadFile();
            $worker = array('name' => $name, 'prenom' => $prenom, 'cin' => $cin, 'address' => $address, 'phone' => $phone, 'salary' => $salary, 'workType' => $workType, 'image' => $image);
            $this->model_employee->add($worker);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => true)));

        }

    }

    public function edit($cid)
	{	
		if(!$this->input->post('buttonSubmit'))
		{
			$data['message'] = '';
			$userRow = $this->model_employee->get($cid);
			$data['userRow'] = $userRow;
			$this->load->view('admin/view_editemployee', $data);
		}
		else
		{
			if($this->form_validation->run('editemp'))
			{
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
				$this->model_employee->update($f_name,$l_name,$u_bday,$u_position,$u_type,$u_pass,$u_mobile,$u_gender,$u_address,$u_id);
				redirect(base_url('admin/employee'));
			}
			else
			{
				$data['message'] = validation_errors();  //data ta message name er lebel er kase pathay
				$this->load->view('view_employee', $data);
			}
		}
	}

    public
    function show()
    {
        $id = $this->uri->segment(4);
        $data['provider'] = $this->model_employee->get(1)[0];
        $this->load->view('admin/employee/show', $data);
    }

	public function delete($cid)
	{	
        $this->model_employee->delete($cid);
        $this->session->set_flashdata('message','Employee Successfully deleted.');
        redirect(base_url('admin/employee'));
	}
}

