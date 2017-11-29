<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends BaseController {

	public function __construct()
	{
		parent::__construct();
	    if ( ! $this->session->userdata('isLogin') || ($this->session->userdata('type') != "admin" )) { 
	        redirect('login');
	    }

		//$this->load->database();
		$this->load->model('model_customer');
        $this->load->model('model_product');
        $this->load->model('model_provider');
                
	}
	public function index()
	{	
        $data['customers'] = $this->model_customer->getAll();
        $data['params'] = $this->getParams();

        $this->parser->parse('admin/customer/list', $data);
    }

	public function add()
    {

        //$this->model_employee->automaticSalary();

        if (!$this->input->post('addEmployee')) {
            $data['products'] = $this->model_product->getAll();
            $data['params'] = $this->getParams();
            $this->parser->parse('admin/customer/view_addcustomer', $data);
        } else {
            $name = $this->input->post('name');
            $prenom = $this->input->post('prenom');
            $cin = $this->input->post('cin');
            $address = $this->input->post('address');
            $phone = $this->input->post('phone');
            $salary = $this->input->post('salary');
            $workType = $this->input->post('workType');
            $image = "profile-default-male.png";
            if ($_FILES['image']['name']) {
                $image = $_FILES['image']['name'];
            }
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

    public function show()
    {
        $id = $this->uri->segment(4);
        $data['employee'] = $this->model_employee->get($id);
        $data['events'] = $this->model_employee->getEvents($id);
        $data['salaries'] = $this->model_employee->getSalaries($id);
        $this->load->view('admin/employee/show', $data);
    }

    public function apiUpdateEvent()
    {
        try {
            $event = $this->input->post('updateEvent');
            $this->model_employee->updateEvent($event);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function apiCreateEvent()
    {
        try {
            $event = $this->input->post('createEvent');
            $this->model_employee->createEvent($event);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function apiDeleteEvent()
    {
        try {
            $event = $this->input->post('deleteEvent');
            $this->model_employee->deleteEvent($event);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

	public function delete($cid)
	{	
        $this->model_employee->delete($cid);
        $this->session->set_flashdata('message','Employee Successfully deleted.');
        redirect(base_url('admin/employee'));
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

}

