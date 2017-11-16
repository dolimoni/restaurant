<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isLogin') || ($this->session->userdata('type') != "admin")) {
            redirect('login');
        }

        $this->load->model('model_product');
        $this->load->model('model_meal');


    }

    /**
     *
     */
    public function index()
    {

        $data = $this->readSalesCSV('uploads/XAFUL.CSV');

        $this->load->view('admin/uniwell/index', $data);
    }

    private function readSalesCSV($file_name){
        $row = 1;
        $index = 0;
        $rows = array();
        if (($handle = fopen($file_name, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                //echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $data[$c] . "<br />\n";
                }
                if (isset($data[1]) and $data[1] !== "ALL TOTAL" and $row > 7) {

                    //delete 0000 from left
                    $id = ltrim($data[0], '0');
                    $product = $this->model_meal->getByExternalCode($data[0]);

                    if (!isset($product['name'])) {
                        $product = $this->model_product->nullProduct();
                    }

                    $data['product'] = $product;
                    $rows[] = $data;
                }
                if (isset($data[1]) and $data[1] === "ALL TOTAL" and $row > 7) {
                    break;
                }
                $index++;
            }
            fclose($handle);
        }
        $data['rows'] = $rows;
        return $data;
    }
    public function apiLoadFile()
    {
        try {
            $file_path = $this->uploadFile();
            $data['sales'] = $this->readSalesCSV($file_path);

            foreach ($data['sales']['rows'] as $key => $sale) {
                $meal = $this->model_meal->getByExternalCode($sale['0']);
                $quantity = $sale[2] / 1000;
                $priceCSV= $sale['3'] / 100 / $quantity;
                if($meal['name']=== $sale['1'] and $priceCSV == $meal['sellPrice']){
                    $data['sales']['rows'][$key]['status']='valid';
                }else{
                    $data['sales']['rows'][$key]['status'] = 'Invalid';
                    //$data['sales']['rows'][$key]['meal'] = $meal;
                }
            }
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success', 'response' => $data)));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function view()
    {
        $meal_id = $this->uri->segment(4);
        $data['meal'] = $this->model_meal->get($meal_id);
        $data['products'] = $this->model_meal->getProducts($meal_id);

        $this->parser->parse('admin/meal/view_meal', $data);
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
        $id = $this->input->post('id');
        //$id=1;

        $data['meal'] = $this->model_meal->get($id);
        $data['products'] = $this->model_meal->getProducts($id);

        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $html = $this->load->view('admin/meal/pdf/view_meal', $data, true);
        $pdf->WriteHTML($html);
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
    }

    public function add()
    {

        if (!$this->input->post('addProvider')) {
            $data['message'] = '';
            $data['providers'] = $this->model_provider->getAll();
            $this->parser->parse('admin/provider/add', $data);
        } else {
            $title = $this->input->post('title');
            $name = $this->input->post('name');
            $prenom = $this->input->post('prenom');
            $address = $this->input->post('address');
            $phone = $this->input->post('phone');
            $mail = $this->input->post('mail');
            $image = $_FILES['image']['name'];
            $this->uploadFile();
            $provider = array('title' => $title, 'name' => $name, 'prenom' => prenom, 'address' => $address, 'phone' => $phone, 'mail' => $mail, 'image' => $image);
            $this->model_provider->add($provider);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => true)));

        }

    }

    public function apiAddProducts()
    {
        $productsList = $this->input->post('productsList');
        $this->model_provider->addProducts($productsList);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true)));
    }

    public function show()
    {
        $id = $this->uri->segment(4);
        $data['provider'] = $this->model_provider->get(1)[0];
        $data['products'] = $this->model_provider->getProducts(1);
        $this->load->view('admin/provider/show', $data);
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
        return $file_path;
    }

    function apiPrintOrder()
    {
        $order = $this->input->post('order');
        $data['order'] = $order;
        $output = $this->createPDF($data);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'filepath' => $output)));
    }

    function order()
    {
        $order = $this->input->post('order');
        $data['order'] = $order;
        $output = $this->createPDF($data);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'filepath' => $output)));
    }

    function createPDF($data)
    {

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $html = $this->load->view('admin/provider/pdf/order', $data, true);
        $pdf->WriteHTML($html);
        $output = 'uploads/pdf/itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output(FCPATH . "$output", 'F');
        return $output;

    }

    function orderTest()
    {
        //$order = $this->input->post('order');
        $this->load->view('admin/provider/pdf/order', true);

    }


    public function edit($cid)
    {
        if (!$this->input->post('buttonSubmit')) {
            $data['message'] = '';
            $userRow = $this->model_employee->get($cid);
            $data['userRow'] = $userRow;
            $this->load->view('admin/view_editemployee', $data);
        } else {
            if ($this->form_validation->run('editemp')) {
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
                $this->model_employee->update($f_name, $l_name, $u_bday, $u_position, $u_type, $u_pass, $u_mobile, $u_gender, $u_address, $u_id);
                redirect(base_url('admin/employee'));
            } else {
                $data['message'] = validation_errors();  //data ta message name er lebel er kase pathay
                $this->load->view('view_employee', $data);
            }
        }
    }

    public function delete($cid)
    {
        $this->model_employee->delete($cid);
        $this->session->set_flashdata('message', 'Employee Successfully deleted.');
        redirect(base_url('admin/employee'));
    }
}

