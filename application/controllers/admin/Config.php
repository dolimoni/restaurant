<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends BaseController {

	public function __construct()
	{
        parent::__construct();

        $this->load->model('model_util');
        $this->load->model('model_ACL');
        $this->load->model('department/model_department');
	}


	public function index()
	{
        $this->log_begin();
        $data["user"]=$this->model_util->getUser(6);
        $data["allUsers"] = $this->model_util->allUsers();
        $data['params'] = $this->getParams();
        $data['params']["config_params"] = $this->model_params->getConfigParams();
        $this->load->view('admin/config/index',$data);
	}

	public function createUser()
	{
        $this->log_begin();
        $data['params'] = $this->getParams();
        $data['departments'] = $this->model_department->getAll();
        $data["controllers"]=$this->model_ACL->getDefaultControllers(1, $data['params']["department"], "default");
        $this->load->view('admin/config/createUser',$data);
	}

    public function apiCreateUser()
    {
        try {
            $user = $this->input->post("user");
            $actions = $this->input->post("actions");
            $password = $this->input->post("password");
            $user["password"] = md5($password);
            $this->model_util->createUser($user, $actions);

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
            $this->log_end(array('status' => 'success'));
            redirect('/admin/config/', 'refresh');
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

	public function editUser($id)
	{
        $this->log_begin();
        $data['params'] = $this->getParams();
        $data['departments'] = $this->model_department->getAll();
        $data["user"]=$this->model_util->getUser($id);
        $data["controllers"]=$this->model_ACL->getDefaultControllers($id, $data['params']["department"], $data["user"]["type"]);
        $this->load->view('admin/config/editUser',$data);
	}

    public function apiEditUser()
    {

        try {
            $id = $this->input->post("id");
            $user = $this->input->post("user");
            $password = $this->input->post("password");
            $actions = $this->input->post("actions");
            if ($password != "") {
                $user["password"] = md5($password);
            }
            $this->model_util->editUser($id, $user, $actions);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
            $this->log_end(array('status' => 'success'));
            //redirect('/admin/config/', 'refresh');
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function apiDeleteUser()
    {
        $this->log_begin();
        try {
            $user_id = $this->input->post('user_id');
            $this->model_util->deleteUser($user_id);
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

	public function apiEditParameters(){
        try {

            $this->load->model("model_params");
            $this->log_begin();
            $parameters = $this->input->post("parameters");
            $response=$this->model_params->update($parameters);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode($response));
            $this->log_end(array('status' => 'success'));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

}