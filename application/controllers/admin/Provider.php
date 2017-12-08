<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Provider extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isLogin') || ($this->session->userdata('type') != "admin")) {
            redirect('login');
        }

        //$this->load->database();
        $this->load->model('model_product');
        $this->load->model('model_meal');
        $this->load->model('model_group');
        $this->load->model('model_provider');

    }

    public function index()
    {
        /*$data['meals'] = $this->model_meal->getAll();
        $data['groups'] = $this->model_group->getAll();
        $this->parser->parse('admin/provider/view_providers', $data);*/

        if (!$this->input->post('addProvider')) {
            $data['message'] = '';
            $data['providers'] = $this->model_provider->getAll();
            $data['products'] = $this->model_provider->getAllProducts();
            $data['params'] = $this->getParams();
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

        try {
            if (!$this->input->post('title')) {
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
                if ($_FILES['image']['name']) {
                    $image = $_FILES['image']['name'];
                    $file_name = $this->uploadFile();
                } else {
                    $image = "profile-default-male.png";
                }
                if ($_FILES['image']['name']) {
                    $image = $file_name;
                } else {
                    $image = "profile-default-male.png";
                }
                $provider = array('title' => $title, 'name' => $name, 'prenom' => $prenom, 'address' => $address, 'phone' => $phone, 'mail' => $mail, 'image' => $image);
                $this->model_provider->add($provider);
                $this->output
                    ->set_content_type("application/json")
                    ->set_output(json_encode(array('status' => 'success')));

            }
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }

    }

    public function apiAddProducts()
    {
        $productsList = $this->input->post('productsList');
        $quotation = '';
        if ($this->input->post('quotation')) {
            $quotation = $this->input->post('quotation');
            if ($quotation['id'] === "") {
                $quotation = $this->input->post('quotation');
                $quotation['id'] = $this->model_provider->addQuotation($quotation);
                $this->model_provider->addProducts($productsList, $quotation);
            } else {
                $this->model_provider->updateProducts($productsList, $quotation);
            }
        } else {
            $this->model_provider->addProducts($productsList);
        }
        //$this->session->set_flashdata('message', 'Le devis a été bien enregistré');
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true)));
    }

    public function show()
    {
        $id = $this->uri->segment(4);
        $data['provider'] = $this->model_provider->get($id);
        $data['products'] = $this->model_provider->getProducts($id);
        $data['productsToOrder'] = $this->model_product->getToOrderFromProvider($id);
        $data['quotations'] = $this->model_provider->getQuotations($id);
        $data['orders'] = $this->model_provider->getOrders($id);
        $data['statistics'] = $this->model_provider->getStatistics($id);
        $this->load->view('admin/provider/show', $data);
    }

    //get quotation by its id
    public function apiGetQuotation()
    {
        $this->load->model('model_quotation');
        $id = $this->input->post('id');
        $quotation = $this->model_quotation->get($id, 'EAGER');
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'quotation' => $quotation)));
    }

    //get Order by Id
    public function apiGetOrder()
    {
        $this->load->model('model_order');
        $id = $this->input->post('id');
        $order = $this->model_order->get($id, 'EAGER');
        $orderStatus = "En attente";
        if ($order['status'] === "canceled") {
            $orderStatus = "Annulée";
        } else if ($order['status'] === "received") {
            $orderStatus = "Reçue";
        }
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'order' => $order, 'orderStatus' => $orderStatus)));
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
        return $new_file_name;

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

        $this->load->model('model_order');
        $order = $this->input->post('order');
        $this->model_order->add($order);
        $data['order'] = $order;
        $e_params['file_path'] = base_url('uploads/pdf/itemreport2017_10_31_21_47_56_.pdf');
        $e_params['to'] = $order['provider']['mail'];
        $emailStatus = '';

        $output = $this->createPDF($data);

        $e_params['attach']=$output;
        $e_params['content']= $order['email']['content'];
        try {
            if($order['email']['send']==="true"){
                $emailStatus = $this->sendEmail($e_params);
            }
        } catch (Exception $e) {
            $emailStatus = $e->getMessage();
        }
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => true, 'filepath' => $output, 'emailStatus' => $emailStatus)));
    }

    private function sendEmail($e_params)
    {

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'manager.contact8@gmail.com',
            'smtp_pass' => 'boujida2030',
            'mailtype' => 'html',
            'newline' => "\r\n",
            'charset' => 'utf-8'
        );

        $this->load->library('email', $config);
        $this->email->from('manager.contact8@gmail.com', 'Contact');
        //$this->email->to($e_params['to']);
        $this->email->to('khalid.essalhi8@gmail.com');
        $this->email->attach(base_url($e_params['attach']), 'attachment', 'commande.pdf');
        $this->email->subject('Bon de commande');
        $this->email->message(mb_convert_encoding($e_params['content'], "UTF-8"));
        //
        //return $this->email->send();
        if ($this->email->send()) {
            return 'Your email was sent';
        } else {
            return $this->email->print_debugger();
        }
        /*try {

       } catch (Exception $e) {

       }*/
    }

    function apiEditOrder()
    {

        try {
            $this->load->model('model_order');
            $order = $this->input->post('order');

            if (strtolower($order['status']) === "en attente") {
                $order['status'] = 'pending';
                $this->model_order->update($order);
                if ($order['oldStatus'] === "received") {
                    $this->model_product->updateQuantities($order['productsList']);
                }
            } else if (strtolower($order['status']) === "annulée") {
                $order['status'] = 'canceled';
                $this->model_order->update($order);
                $this->model_product->updateQuantities($order['productsList']);
            } else {
                $order['status'] = 'received';
                $this->model_order->update($order);
                if ($order['oldStatus'] === "pending") {
                    $this->model_product->updateQuantities($order['productsList'], 'up');
                }
            }
            /* $data['order']=$order;
             $output = $this->createPDF($data);*/
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => true, 'orderStatus' => $order['status'])));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => false)));
        }
    }

    function createPDF($data)
    {

        $this->load->library('pdf');
        $data['params'] = $this->getParams();
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


    /* public function edit($cid)
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
     }*/


    public function apiUpdate()
    {
        try {
            $provider = $this->input->post('provider');
            $this->model_provider->update($provider);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function apiDeleteProvider()
    {
        try {
            $provider_id = $this->input->post('provider_id');
            $this->model_provider->deleteProvider($provider_id);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }

    public function apiDeleteOrder()
    {
        try {
            $this->load->model('model_order');
            $order_id = $this->input->post('order_id');
            $this->model_order->delete($order_id);
            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'success')));
        } catch (Exception $e) {

            $this->output
                ->set_content_type("application/json")
                ->set_output(json_encode(array('status' => 'error')));
        }
    }


}

