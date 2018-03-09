<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends BaseController {

	public function __construct()
	{
		parent::__construct();
        if (!$this->session->userdata('isLogin')) {
            redirect('login');
        }

		//$this->load->database();
		$this->load->model('model_employee');

	}
	public function index()
	{
        $this->log_begin();
        $data['emp'] = $this->model_employee->getAll();
        $this->parser->parse('admin/employee/list', $data);
        $this->log_end($data);
    }
    public function statistic()
    {
        $this->log_begin();
        $data['params'] = $this->getParams();
        $start = date('Y-m-d', strtotime('-1 month'));
        $end = date('Y-m-d');
        $data["report"]=$this->model_employee->getReport($start,$end)["report"];
        $this->parser->parse('admin/employee/view_statistic', $data);
        $this->log_end(null);
    }

    public function apiStatistic()
    {
        $this->log_begin();
        $data['params'] = $this->getParams();
        $start = $this->input->post('startDate');
        $end = $this->input->post('endDate');
        $report=$this->model_employee->getReport($start,$end);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($report));
        $this->log_end($report);
    }

	public function add()
    {

        //$this->model_employee->automaticSalary();

        $this->log_begin();

        if (!$this->input->post('name')) {
            $data['message'] = '';
            $data['employees'] = $this->model_employee->getAll();
            $data['params'] = $this->getParams();
            $this->parser->parse('admin/employee/add', $data);
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
                $imageName = $this->uploadFile();
                $image = $imageName;
            }
            $worker = array('name' => $name, 'prenom' => $prenom, 'cin' => $cin, 'address' => $address, 'phone' => $phone, 'salary' => $salary, 'workType' => $workType, 'image' => $image);
            $this->model_employee->add($worker);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => true,'worker'=> $worker)));
            $this->log_end($worker);

        }

    }

    public function edit($cid)
	{
        $this->log_begin();
		if(!$this->input->post('buttonSubmit'))
		{
			$data['message'] = '';
			$userRow = $this->model_employee->get($cid);
			$data['userRow'] = $userRow;
			$this->load->view('admin/view_editemployee', $data);
		}
		else{
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
                $this->log_end(array('status' => 'success'));
				redirect(base_url('admin/employee'));
			}
			else
			{
				$data['message'] = validation_errors();  //data ta message name er lebel er kase pathay
				$this->load->view('view_employee', $data);
			}
		}
	}

	public function all(){
        $this->log_begin();
        $id = $this->uri->segment(4);
        $data['salaries'] = $this->model_employee->getMonthSalaries();
        $data['params'] = $this->getParams();
        $this->load->view('admin/employee/all_view', $data);
        $this->log_end($data);
    }

    public function apiAll()
    {
        $this->log_begin();
        try {
            $startDate = $this->input->post('startDate');
            $salaries = $this->model_employee->getMonthSalaries($startDate);
            $this->log_middle($salaries);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success',"salaries"=> $salaries)));
            $this->log_end(array('status' => 'success'));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function apiPayment(){
        $this->log_begin();
        try {
            $paid = $this->input->post('paid');
            $id = $this->input->post('id');
            $this->model_employee->updatePaymentSalary($id);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
            $this->log_end(array('status' => 'success'));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function apiEditMainEmployee()
    {
        $this->log_begin();
        try {
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $prenom = $this->input->post('prenom');
            $cin = $this->input->post('cin');
            $address = $this->input->post('address');
            $phone = $this->input->post('phone');
            $salary = $this->input->post('salary');
            $workType = $this->input->post('workType');
            $image = $_FILES['image']['name'];
            $employee = array('name' => $name, "prenom" => $prenom,"cin"=>$cin, "address" => $address, "phone" => $phone, "salary" => $salary, "workType" => $workType);
            if ($image !== "") {
                $imageName = $this->uploadFile();
                $employee['image'] = $imageName;
            }

            $this->model_employee->updateEmployee($id, $employee);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
            $this->log_end($employee);
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function main()
    {
        $this->load->model('model_util');
        $this->log_begin();
        $data["user"] = $this->model_util->getUser($this->session->userdata('id'));
        $data['params'] = $this->getParams();
        $this->load->view('admin/config/main', $data);
    }

    public function show()
    {
        $this->log_begin();
        $id = $this->uri->segment(4);
        $data['employee'] = $this->model_employee->get($id);
        $data['events'] = $this->model_employee->getEvents($id);
        $data['salaries'] = $this->model_employee->getSalaries($id);
        $data['params'] = $this->getParams();
        $this->load->view('admin/employee/show', $data);
        $this->log_end($data);
    }

    public function apiUpdateEmployee()
    {
        $this->log_begin();
        try {
            $employee = $this->input->post('employee');
            $id = $this->input->post('id');
            $this->log_middle($employee);
            $this->model_employee->updateEmployee($id,$employee);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
            $this->log_end(array('status' => 'success'));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function apiUpdateEvent()
    {
        $this->log_begin();
        try {
            $event = $this->input->post('updateEvent');
            $this->log_middle($event);
            $this->model_employee->updateEvent($event);
            $this->log_end(array('status' => 'success'));
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
            $this->log_begin();
            $event = $this->input->post('createEvent');
            $this->log_middle($event);
            $this->model_employee->createEvent($event);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
            $this->log_end(array('status' => 'success'));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function apiDeleteEvent()
    {
        try {
            $this->log_begin();
            $event = $this->input->post('deleteEvent');
            $this->log_middle($event);
            $this->model_employee->deleteEvent($event);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
            $this->log_end(array('status' => 'success'));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }


    public function apiDeleteEmployee()
    {
        $this->log_begin();
        try {
            $employee_id = $this->input->post('employee_id');
            $this->model_employee->deleteEmployee($employee_id);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
            $this->log_end(array('status' => 'success'));
        } catch (Exception $e) {

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
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
                $path = $_FILES['image']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                //now is the time to modify the future file name and validate the file
                $new_file_name = strtolower(bin2hex(openssl_random_pseudo_bytes(16))); //rename file
                $new_file_name .= '.' . $ext;
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
        $this->log_end($file_path);
        return $new_file_name;

    }

}

