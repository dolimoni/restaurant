<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department extends BaseController {

	public function __construct()
	{
        parent::__construct();
        if (!$this->session->userdata('isLogin')) {
            redirect('login');
        }

        $this->load->model('department/model_department');
        $this->load->model('model_meal');
        $this->load->model('model_product');

	}

	public function index()
	{
        $data['departments'] = $this->model_department->getAll();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/department/view_departments', $data);
	}

	public function show()
	{
        $id = $this->uri->segment(4);
        $department = $this->session->userdata('department');
        if($department>0){
            $id= $department;
        }
        $data['department'] = $this->model_department->getDepartment($id);
        $data['magazins'] = $this->model_department->getMagazinsWithMeals($id);
        $data['meals'] = $this->model_meal->getAll();
        $data['products'] = $this->model_department->getProducts($id);
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/department/view_department', $data);
	}

    public function showDepartmentStock()
    {
        $id= $this->session->userdata('department');
        $data['products'] = $this->model_department->getProducts($id);
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/department/view_showDepartmentProducts', $data);
    }
    public function meals()
    {
        $data['meals'] = $this->model_meal->getAll();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/department/view_meals', $data);
    }

	public function stockMeal()
	{
        $department = $this->uri->segment(4);
        $data['meals'] = $this->model_meal->getAllMeals();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/department/view_stockMeal', $data);
	}

	public function showProducts()
	{
        $data['departments'] = $this->model_department->getAll();
        $data['products'] = $this->model_product->getAll();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/department/view_showProducts', $data);
	}
	public function historyProducts()
	{
	    $this->load->model('department/model_stock');
        $data['products'] = $this->model_stock->getProductsHistory();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/department/view_historyProducts', $data);
	}

	public function addProducts()
	{
        $data['departments'] = $this->model_department->getAll();
        $data['products'] = $this->model_product->getAll();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/department/view_addProducts', $data);
	}

	public function apiAddStock()
	{

        try {
            $stock = $this->input->post('stock');
            $this->model_department->addStock($stock);

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
	}

	public function editMagazin()
	{
        $department = $this->uri->segment(4);
        $magazin = $this->uri->segment(5);
        $data['magazin'] = $this->model_department->getMagazinWithMeals($department,$magazin);
        $data['meals'] = $this->model_meal->getAllMeals($department,$magazin);
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/department/view_editMagazin', $data);
	}


	public function apiEditMagazin()
	{
        try {
            $magazin = $this->input->post('magazin');
            $this->model_department->updateMagazin($magazin);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success','redirect'=>base_url('admin/department/show/'. $magazin['department']))));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
	}


    public function apiAddDepartment()
    {

        $name = $this->input->post('name');
        $image = "restaurant.jpg";
        if ($_FILES['image']['name']) {
            $image = $_FILES['image']['name'];
            $this->uploadFile();
        }
        $department = array('name' => $name,'image' => $image);
        $this->model_department->addDepartment($department);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => 'success')));

    }

    public function apiEditDepartment()
    {
        try {
            $name = $this->input->post('departmentNameEdit');
            $id = $this->input->post('id');
            $image = $_FILES['image']['name'];
            $department = array('name' => $name);
            if ($image !== "") {
                $department['image'] = $image;
                $this->uploadFile();
            }
            $this->model_department->editDepartment($id, $department);

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }

    }


    public function apiDeleteDepartment()
    {
        try {
            $department_id = $this->input->post('department_id');
            $this->model_department->deleteDepartment($department_id);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error','code'=> $e->getCode())));
        }

    }

    public function apiDeleteMealFromMagazin(){
        try {
            $id = $this->input->post('meal_id');
            $this->model_department->deleteMealFromMagazin($id);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }

    }

    public function apiAddMagazin()
    {

        $name = $this->input->post('name');
        $department = $this->input->post('department');

        $magazin = array('name' => $name,'department'=>$department);
        $this->model_department->addMagazin($magazin);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => 'success')));

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