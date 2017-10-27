<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	    if ( ! $this->session->userdata('isLogin') || ($this->session->userdata('type') != "admin" )) { 
	        redirect('login');
	    }

		//$this->load->database();
		$this->load->model('model_employee');
		$this->load->model('model_product');
		$this->load->model('model_meal');
		$this->load->model('model_group');
        $this->load->model('model_report');

	}
	public function index()
	{	
        $data['meals'] = $this->model_meal->getAll();
        $data['groups'] = $this->model_group->getAll();
        $this->parser->parse('admin/meal/view_meals', $data);
    }
    public function view()
	{
        $meal_id = $this->uri->segment(4);
        $data['meal'] = $this->model_meal->get($meal_id);
        $data['products'] = $this->model_meal->getProducts($meal_id);

        $this->parser->parse('admin/meal/view_meal', $data);
    }
    public function report()
	{
        $meal_id = $this->uri->segment(4);
        $data['meal'] = $this->model_meal->get($meal_id);
        $data['products'] = $this->model_meal->getProducts($meal_id);
        $data['report'] = $this->model_report->reportById($meal_id);

        $this->load->view('admin/meal/report',$data);
    }

    public function apiEvolution(){
        $meal_id = $this->input->post('id');

        $evolution = $this->model_report->evolution($meal_id);

        $cas = array_column($evolution, 'ca');

        function date_sort($a, $b)
        {
            return strtotime($a) - strtotime($b);
        }

        usort($cas, "date_sort");


        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'evolution' => $evolution,'cas'=>$cas)));
    }
    public function apiEvolutionRange(){

        $meal_id = $this->input->post('id');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $evolution = $this->model_report->evolutionRange($meal_id, $startDate,$endDate);

        $cas = array_column($evolution, 'ca');

        function date_sort($a, $b)
        {
            return strtotime($a) - strtotime($b);
        }

        usort($cas, "date_sort");


        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'evolution' => $evolution,'cas'=>$cas)));
    }
    public function mypdfTest()
    {
        $meal_id = $this->uri->segment(4);
        $data['meal'] = $this->model_meal->get($meal_id);
        $data['products'] = $this->model_meal->getProducts($meal_id);

        $this->parser->parse('admin/meal/pdf/view_meal', $data);
    }

    function mypdf()
    {
        $id=$this->input->post('id');
        //$id=1;

        $data['meal'] = $this->model_meal->get($id);
        $data['products'] = $this->model_meal->getProducts($id);

        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $html = $this->load->view('admin/meal/pdf/view_meal',$data,true);
        $pdf->WriteHTML($html);
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
    }

	public function add()
	{

        if (!$this->input->post('meal')) {
            $data['message'] = '';
            $data['products'] = $this->model_product->getAll();
            $data['groups'] = $this->model_group->getAll();
            $this->parser->parse('admin/meal/view_addmeal', $data);
        }else{
            $meal = $this->input->post('meal');
            $id = $this->model_meal->add($meal);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => true, 'redirect' => base_url('admin/meal/view/'.$id))));

        }

	}
	public function edit()
	{
        $meal_id = $this->uri->segment(4);
        $data['meal'] = $this->model_meal->get($meal_id);
        $data['productsComposition'] = $this->model_meal->getProducts($meal_id);
        $data['message'] = '';
        $data['products'] = $this->model_product->getAll();
        $data['groups'] = $this->model_group->getAll();
        $this->parser->parse('admin/meal/view_editmeal', $data);
	}
	public function editApi()
	{
        $meal = $this->input->post('meal');
        $id = $this->model_meal->edit($meal);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => 'success', 'redirect' => base_url('admin/meal/view/' . $id))));
	}
	public function group()
	{

        if (!$this->input->post('addGroup')) {
            $data['message'] = '';
            $data['groups'] = $this->model_group->getAll();
            $this->parser->parse('admin/meal/view_group', $data);
        }else{

            $name = $this->input->post('groupName');
            $image = $_FILES['image']['name'];
            $group=array('name'=>$name,'image'=>$image);
            $this->uploadFile();
            $this->model_group->add($group);

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => true)));

        }

	}

	public function groupMeals()
	{

        $group_id = $this->uri->segment(4);
        $data['meals']=$this->model_meal->getByGroup($group_id);
        $this->load->view('admin/meal/view_group_meals',$data);

	}

	private function uploadFile(){
        $valid_file = true;
        $message='';
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


	public function delete($cid)
	{	
        $this->model_employee->delete($cid);
        $this->session->set_flashdata('message','Employee Successfully deleted.');
        redirect(base_url('admin/employee'));
	}

	public function apiDeleteProductForMeal(){
        $meal_id = $this->input->post('meal_id');
        $product_id = $this->input->post('product_id');
        $this->model_meal->deleteProductForMeal($meal_id, $product_id);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => 'success')));
    }

    public function apiConsumption()
    {
       try {
           $productsList = $this->input->post('mealsList');
           $response = $this->model_meal->consumption($productsList);
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => $response['status'],'productsList'=>$response['productsList'])));
       } catch (Exception $e) {
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'error')));
       }
    }

    public function loadFile()
    {
        $data['meals'] = $this->Parse('uploads/a.prg');
        $this->load->view('admin/meal/load', $data);
    }
    public function loadFileGroup()
    {
        $data['meals'] = $this->ParseGroup('uploads/a.prg');
        $this->load->view('admin/meal/loadGroup', $data);
    }
    public function apiFileGroup()
    {
        $data['meals'] = $this->ParseGroup('uploads/a.prg');
        $this->load->view('admin/meal/loadGroup', $data);
    }
    public function apiLoadMeals()
    {
        $mealsList=$this->input->post('mealsList');
        $type = $this->input->post('type');
        if ($type === "save") {
            $response = $this->model_meal->addMeals($mealsList);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => $response['status'], 'mealsExist' => $response['mealsExist'])));

        } else if ($type === "update") {
            $response = $this->model_meal->updateMeals($mealsList);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => $response['status'],'redirect'=>base_url('admin/meal/index'),'res'=>$response)));
        }

    }

    public function apiLoadGroups()
    {
        $groupsList = $this->input->post('groupsList');
        $type = $this->input->post('type');
        if ($type === "save") {
            $response = $this->model_group->loadGroups($groupsList);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => $response['status'], 'groupsExist' => $response['groupsExist'])));

        } else if ($type === "update") {
            $response = $this->model_group->updateGroups($groupsList);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => $response['status'], 'redirect' => base_url('admin/meal/group'), 'res' => $response)));
        }

    }

    private function Parse($url)
    {
        /*$fileContents = file_get_contents(base_url($url));
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents);
        $json = json_encode($simpleXml);*/

        $xml = simplexml_load_file($url) or die("Error: Cannot create object");
        $meals = array();
        foreach ($xml->plu_list->plu as $plu) {
            $name = (array) $plu['name'];
            $code = (array)$plu['code'];
            $price = (array)$plu->price;
            $group = (array)$plu->group;
            $meal = array('name' => $name[0], 'code' => $code[0], 'price' => $price[0], 'group' => $group[0]);
            if($name[0]!=="")
                $meals[] = $meal;
        }


        return $meals;
    }
    private function ParseGroup($url)
    {

        $xml = simplexml_load_file($url) or die("Error: Cannot create object");
        $groups = array();
        foreach ($xml->group_list->grp as $grp) {
            $name = (array)$grp['name'];
            $num = (array)$grp['num'];
            $group = array('name' => $name[0], 'num' => $num[0]);
            if(strpos($name['0'], 'GROUP') === false)
                $groups[] = $grp;
        }
        return $groups;
    }
}
