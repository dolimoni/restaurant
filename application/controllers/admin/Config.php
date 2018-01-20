<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends BaseController {

	public function __construct()
	{
        parent::__construct();

        $this->load->model('model_util');
	}


	public function index()
	{
        $this->log_begin();
        $data["user"]=$this->model_util->getUser(6);
        $data['params'] = $this->getParams();
        $this->load->view('admin/config/index',$data);
	}

	public function editUser()
	{
        $this->log_begin();
        $data["user"]=$this->model_util->getUser(6);
        $data['params'] = $this->getParams();
        $this->load->view('admin/config/editUser',$data);
	}

    public function editUserForm()
    {
        $id = $this->input->post("id");
        $last_name = $this->input->post("last_name");
        $first_name = $this->input->post("first_name");
        $email = $this->input->post("email");
        $mobile = $this->input->post("mobile");
        $address = $this->input->post("address");
        $password = $this->input->post("password");

        $user=array(
            "last_name"=> $last_name,
            "first_name"=> $first_name,
            "email"=> $email,
            "mobile"=> $mobile,
            "address"=> $address,
        );
        if($password!=""){
            $user["password"]=md5($password);
        }
        $this->model_util->editUser($id,$user);
        redirect('/admin/config/');
    }

	public function delete()
	{
        $this->log_begin();
        $data['params'] = $this->getParams();
        $this->load->view('admin/config/delete',$data);
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