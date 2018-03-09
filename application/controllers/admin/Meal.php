<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meal extends BaseController {

	public function __construct()
	{
		parent::__construct();
	    if ( ! $this->session->userdata('isLogin')) {
	        redirect('login');
	    }

		//$this->load->database();
		$this->load->model('model_product');
		$this->load->model('model_meal');
		$this->load->model('model_group');
        $this->load->model('model_report');

	}
	public function index()
	{
        $this->log_begin();
        $data['meals'] = $this->model_meal->getAll();
        $data['hasAtLeasOneProduct'] = $this->model_meal->hasAtLeasOneProduct();
        $data['groups'] = $this->model_group->getAll();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/meal/view_meals', $data);
        $this->log_end("end success");
    }
    public function view()
	{
        $this->log_begin();
        $meal_id = $this->uri->segment(4);
        $data['meal'] = $this->model_meal->get($meal_id);
        $data['products'] = $this->model_meal->getProducts($meal_id);
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/meal/view_meal', $data);
        $this->log_end($data);
    }
    public function report()
	{
        $this->log_begin();
        $meal_id = $this->uri->segment(4);
        $data['meal'] = $this->model_meal->get($meal_id);
        $data['products'] = $this->model_meal->getProducts($meal_id);
        $data['report'] = $this->model_report->reportById($meal_id);
        $start = date('Y-m-d', strtotime('-1 month'));
        $end = date('Y-m-d');
        $evolution = $this->model_report->evolutionRange($meal_id, $start, $end);
        if($this->session->userdata('startDate')){
            $startDate= $this->session->userdata('startDate');
            $endDate= $this->session->userdata('endDate');
            $data['report'] = $this->model_report->reportById($meal_id, $startDate, $endDate);
            $evolution = $this->model_report->evolutionRange($meal_id, $startDate, $endDate);
        }
        $data['report']['rds']=count($this->rds($evolution));
        $data['params'] = $this->getParams();
        $this->load->view('admin/meal/report',$data);
        $this->log_end($data);
    }

    public function apiEvolution(){
        $this->log_begin();
        $meal_id = $this->input->post('id');


        $evolution = $this->model_report->evolution($meal_id);

        if ($this->session->userdata('startDate')) {
            $startDate = $this->session->userdata('startDate');
            $endDate = $this->session->userdata('endDate');
            $evolution = $this->model_report->evolutionRange($meal_id, $startDate, $endDate);
            $this->session->unset_userdata('startDate');
            $this->session->unset_userdata('endDate');
        }

        $rds = array_column($evolution, 'rd');

        function date_sort2($a, $b)
        {
            return strtotime($a) - strtotime($b);
        }

        usort($rds, "date_sort2");

        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'evolution' => $evolution,'rds'=> $rds)));

        $this->log_end(array('status' => true, 'evolution' => $evolution, 'rds' => $rds));
    }
    public function apiEvolutionRange(){

        $this->log_begin();
        $meal_id = $this->input->post('id');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $evolution = $this->model_report->evolutionRange($meal_id, $startDate,$endDate);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'evolution' => $evolution,'rds'=>$this->rds($evolution))));
        $this->log_end(array('status' => true, 'evolution' => $evolution));
    }

    // sort attribut createdAt
    private function rds($evolution){
        $rds = array_column($evolution, 'report_date');

        function date_sortRds($a, $b)
        {
            return strtotime($a) - strtotime($b);
        }

        usort($rds, "date_sortRds");

        return $rds;
    }
    private function sortListByName($data){
        function cmpList($a, $b)
        {
            if ($a == $b)
                return 0;
            return ($a['name'] < $b['name']) ? -1 : 1;
        }

        usort($data, "cmpList");
        return $data;

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
        $this->log_begin();
        $id=$this->input->post('id');
        //$id=1;

        $data['meal'] = $this->model_meal->get($id);
        $data['products'] = $this->model_meal->getProducts($id);
        $data['params'] = $this->getParams();

        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $html = $this->load->view('admin/meal/pdf/view_meal',$data,true);
        $pdf->WriteHTML($html);
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
    }

	public function add()
	{

        $this->log_begin();
        if (!$this->input->post('meal')) {
            $data['message'] = '';
            $group= $this->uri->segment(4);
            if($group){
                $data['defaultGroup'] = $group;
            }else{
                $data['defaultGroup'] = 0;
            }
            $data['products'] = $this->model_product->getAll(false,true);
            $data['products'] = $this->sortListByName($data['products']);
            $data['compositions'] = $this->model_product->getCompositions();
            $data['groups'] = $this->model_group->getAll();
            $data['params'] = $this->getParams();
            $this->parser->parse('admin/meal/view_addmeal', $data);
            $this->log_end($data);
        }else{
            $meal = $this->input->post('meal');
            $response = $this->model_meal->add($meal);
            $this->log_end($response);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode($response));


        }

	}
	public function edit()
	{
        $this->log_begin();
        $meal_id = $this->uri->segment(4);
        $data['meal'] = $this->model_meal->get($meal_id);
        $data['productsComposition'] = $this->model_meal->getProducts($meal_id);
        $data['message'] = '';
        $data['products'] = $this->model_product->getAll(false,true);
        $data['products'] = $this->sortListByName($data['products']);
        $data['groups'] = $this->model_group->getAll();
        $data['params'] = $this->getParams();
        $this->parser->parse('admin/meal/view_editmeal', $data);
        $this->log_end($data);
	}
	public function apiEdit()
	{
        $this->log_begin();
        $meal = $this->input->post('meal');
        $id = $this->model_meal->edit($meal);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => 'success', 'redirect' => base_url('admin/meal/view/' . $id))));
        $this->log_end(array('status' => 'success', 'redirect' => base_url('admin/meal/view/' . $id)));
	}
	public function group()
	{

        $this->log_begin();

        if (!$this->input->post('groupName')) {
            $this->load->model('department/model_department');
            $data['message'] = '';
            $data['groups'] = $this->model_group->getAll();
            $data['productsToOrder'] = $this->model_product->getToOrder();
            $data['departments'] = $this->model_department->getAll();
            $this->load->model('model_budget');
            $data['alertes'] = $this->model_budget->getActiveAlerts();
            $data['params'] = $this->getParams();
            $this->parser->parse('admin/meal/view_group', $data);
            $this->log_end($data);
        }else{

            $name = $this->input->post('groupName');
            $department = $this->input->post('department');
            $image = $_FILES['image']['name'];
            $group=array('name'=>$name,'image'=>$image,'department'=> $department);
            $this->log_middle($group);
            $this->uploadFile();
            $this->model_group->add($group);

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
            $this->log_end(array('status' => 'success'));

        }

	}

	public function apiGroupEdit()
	{
        try {
            $this->log_begin();
            $name = $this->input->post('groupNameEdit');
            $id = $this->input->post('id');
            $department = $this->input->post('department');
            $image = $_FILES['image']['name'];
            $group = array('name' => $name,'department'=>$department);
            if($image!==""){
                $group['image']=$image;
                $this->uploadFile();
            }
            $this->log_middle($group);
            $this->model_group->edit($id,$group);

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
	public function apiDeleteGroup()
	{
        try {

            $this->log_begin();
            $group_id = $this->input->post('group_id');

            $this->model_group->switchProductsGroup($group_id,1);
            $this->model_group->delete($group_id);

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

	public function groupMeals()
	{
        $this->log_begin();

        $group_id = $this->uri->segment(4);
        $data['meals']=$this->model_meal->getByGroup($group_id);
        $data['group']=$this->model_group->get($group_id);
        $data['params'] = $this->getParams();
        $this->load->view('admin/meal/view_group_meals',$data);

        $this->log_end($data);

	}

	private function uploadFile($destination= 'assets/images/'){
        $valid_file = true;
        $message='';
        $file_path='empty';
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
                    $file_path = $destination . $new_file_name;
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
        return $file_path;
    }



	public function apiDeleteProductForMeal(){
        $this->log_begin();
        $meal_id = $this->input->post('meal_id');
        $product_id = $this->input->post('product_id');
        $this->model_meal->deleteProductForMeal($meal_id, $product_id);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => 'success')));
        $this->log_end(array('status' => 'success'));
    }
    public function apiDeleteMeal(){
       try {
           $this->log_begin();
           $meal_id = $this->input->post('meal_id');
           $this->model_meal->deleteMeal($meal_id);
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

    public function apiConsumption()
    {
       try {
           $this->log_begin();
           $response=array(
               "status"=>"success",
               "productsList"=>array(),
           );
           $mealsList = $this->input->post('mealsList');
           $params = $this->input->post('params');
           if($params["deleteSales"]==="true"){
               $this->model_meal->deleteConsumption($params);
           }
           if($mealsList){
               $response = $this->model_meal->consumption($mealsList);
           }
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => $response['status'],'productsList'=>$response['productsList'])));
           $this->log_end(array('status' => $response['status'], 'productsList' => $response['productsList']));
       } catch (Exception $e) {
           $this->output
               ->set_content_type("application/json")
               ->set_output(json_encode(array('status' => 'error')));
       }
    }

    public function apiAddLostQuantity()
    {
       try {
           $this->log_begin();
           $mealsList = $this->input->post('mealsList');
           $response = $this->model_meal->consumption($mealsList,true);
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

    public function loadFile()
    {
        //$data['meals'] = $this->Parse('uploads/a.prg');
        $data['params'] = $this->getParams();
        $this->load->view('admin/meal/load',$data);
    }
    public function apiLoadFile()
    {
        try {
            $this->log_begin();
            $destination="uploads/articlePrg/";
            $aa=$this->uploadFile($destination);

            $zip = new ZipArchive;
            $res = $zip->open($aa);
            $file_name='';
            if ($res === TRUE) {
                $zip->extractTo($destination);
                $file_name= $zip->getNameIndex(0);
                $zip->close();
            } else {
            }

            $file=$destination.'/'. $file_name;
            $data['meals'] = $this->Parse($file);
            $data['groups'] = array();
            $groups= $this->ParseGroup($file);
            $this->model_group->createGroupsIfNotExists($groups);
            $this->log_middle($groups);
            foreach ($groups as $group) {
                $data['groups'][]=$this->model_group->getByNum($group['num']);
            }
            $this->clean();
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success', 'response' => $data)));
            $this->log_end($data);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->output
                ->set_content_type("application/json")
                    ->set_output(json_encode(array('status' => 'error', 'response' => $data)));
        }
    }
    public function loadFileGroup()
    {
        $data['meals'] = $this->ParseGroup('uploads/a.prg');
        $data['params'] = $this->getParams();
        $this->load->view('admin/meal/loadGroup',$data);
    }
    public function apiLoadFileGroup()
    {
        try {
            $file_path = $this->uploadFile();
            $data['groups'] = $this->ParseGroup($file_path);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success', 'response' => $data)));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error', 'response' => $data)));
        }
    }
    public function apiFileGroup()
    {
        $data['meals'] = $this->ParseGroup('uploads/a.prg');
        $this->load->view('admin/meal/loadGroup', $data);
    }
    public function apiLoadMeals()
    {
        $this->log_begin();
        $type='';
        try {
            $mealsList      = $this->input->post('mealsList');
            $type           = $this->input->post('type');

            if ($type === "save") {
                $response = $this->model_meal->addMeals($mealsList);
                $this->output
                    ->set_content_type("application/json")
                    ->set_output(json_encode(array('flag' => 'ok', 'status' => $response['status'], 'redirect' => base_url('admin/meal/index'), 'mealsExist' => $response['mealsExist'])));


                $this->log_end(array('flag' => 'ok', 'status' => $response['status'], 'redirect' => base_url('admin/meal/index'), 'mealsExist' => $response['mealsExist']));
            } else if ($type === "update") {
                $response = $this->model_meal->updateMeals($mealsList);
                $this->output
                    ->set_content_type("application/json")
                    ->set_output(json_encode(array('status' => $response['status'], 'redirect' => base_url('admin/meal/index'), 'res' => $response)));
                $this->log_end(array('status' => $response['status'], 'redirect' => base_url('admin/meal/index'), 'res' => $response));
            }else{
                $this->output
                    ->set_content_type("application/json")
                    ->set_output(json_encode(array('status' => 'error')));
                $this->log_end(json_encode(array('status' => 'error')));

            }
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
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

        $this->log_middle($url);
        $xml = simplexml_load_file($url) or die("Error: Cannot create csv");
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

        $this->log_end($meals);


        return $meals;
    }
    public function clean(){
        $this->load->model('model_util');
        $this->model_util->clean();
    }
    private function ParseGroup($url)
    {

        $xml = simplexml_load_file($url) or die("Error: Cannot create object");
        $groups = array();
        if(isset($xml->group_list->grp)){
            foreach ($xml->group_list->grp as $grp) {
                $name = (array)$grp['name'];
                $num = (array)$grp['num'];
                $group = array('name' => $name[0], 'num' => $num[0]);
                if (strpos($name['0'], 'GROUP') === false)
                    $groups[] = $group;
            }
        }
        return $groups;
    }
}

