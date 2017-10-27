<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isLogin') || ($this->session->userdata('type') != "admin")) {
            redirect('login');
        }

        $this->load->model('model_product');
        $this->load->model('model_meal');
        $this->load->model('model_report');


    }

    public function index()
    {
        $data['articles']=$this->model_report->report();
        $this->load->view('admin/report/article', $data);
    }
    public function apiReport()
    {
        $params=$this->input->post('params');
        $articles=$this->model_report->report($params);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'articles' => $articles)));
    }
    public function apiRange()
    {
        $startDate=$this->input->post('startDate');
        $endDate=$this->input->post('endDate');
        $articles=$this->model_report->reportRange($startDate,$endDate);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true,'articles'=>$articles)));
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

