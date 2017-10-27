<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicles extends CI_Controller {

	public function __construct()
	{

		parent::__construct();
        if ( ! $this->session->userdata('isLogin')) { 
            redirect('login');
        }
		
		$this->load->model('model_vehicle');
        $this->load->model('model_manufacturer');
        $this->load->model('model_car_model');
        $this->load->model('model_customer');

	}

	public function index()
	{
        $manufacturer = $this->input->get('vehicule');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $manufacturer = $this->input->get('manufacturer');
        }
        $data['udata']=$this->session->userdata;
        $data['vehicles'] = $this->model_vehicle->getByManufacturer($manufacturer);
        $data['manufacturers'] = $this->model_manufacturer->getAllManufacturers();
        $data['models'] = $this->model_car_model->getAllModels();
        
        //$this->load->view('view_vehicle', $data); 
        $this->parser->parse('admin/view_vehicle', $data);   
    }

    public function newCar()
    {
        $data['udata'] = $this->session->userdata;
        $data['vehicles'] = $this->model_vehicle->getAll();
        $data['manufacturers'] = $this->model_manufacturer->getAllManufacturers();
        $data['models'] = $this->model_car_model->getAllModels();

        //$this->load->view('view_vehicle', $data);
        $this->parser->parse('admin/new_vehicle', $data);
    }

    public function show()
    {

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $id = $this->input->post('vehicle_id');

            $data['udata'] = $this->session->userdata;
            $data['vehicle'] = $this->model_vehicle->getById($id)[0];
            $data['manufacturers'] = $this->model_manufacturer->getAllManufacturers();
            $data['models'] = $this->model_car_model->getAllModels();

            $this->parser->parse('admin/vehicule/show', $data);

        } else {
            redirect(base_url('admin/vehicles'));
        }
    }


	public function location()
	{
        if ($this->input->server('REQUEST_METHOD') == 'POST'){	
            $cid = $this->input->post('vehicle_id');
            $cdata['cid'] = $cid;
            $data['vehicule'] = $this->model_vehicle->getById($cid)[0];
            if(!$this->input->post('buttonSubmits'))
    		{
    			$data['message'] = '';
                $this->load->view('admin/vehicule/location', $data);
    		}
            else{
                $this->form_validation->set_rules('marque', 'Marque', 'required');
                $this->form_validation->set_rules('immat', 'Immatricule', 'required');
                $this->form_validation->set_rules('mileage', 'Kilométrage de départ', 'required');
                $this->form_validation->set_rules('duree', 'Durée de location', 'required');
                $this->form_validation->set_rules('nom', 'Nom', 'required');
                $this->form_validation->set_rules('mobile', 'Téléphone', 'required|trim');


                if ($this->form_validation->run() == FALSE && false) {
                    $data['vRow'] = $this->model_vehicle->get($cid);
                    $this->load->view('admin/vehicule/location', $data);
                }
                else {
                    $vehicule=array();
                    $customer=array();
                    $location=array();
                    $date_lieu_livraison = explode(' ', $this->input->post('dl_livraison'));
                    $date_livraison= $date_lieu_livraison[0];
                    $lieu_livraison= count($date_lieu_livraison)===2 ? $date_lieu_livraison[1]:'';

                    $date_lieu_reprise = explode(' ', $this->input->post('dl_reprise'));
                    $date_reprise= $date_lieu_reprise[0];
                    $lieu_reprise= count($date_lieu_reprise)===2? $date_lieu_reprise[1]:'';

                    $location['marque'] = $this->input->post('marque');
                    $location['immat'] = $this->input->post('immat');
                    $location['mileage'] = $this->input->post('mileage');

                    $vehicule['date_livraison'] = $date_livraison;
                    $vehicule['lieu_livraison'] = $lieu_livraison;
                    $vehicule['date_reprise'] = $date_reprise;
                    $vehicule['lieu_reprise'] = $lieu_reprise;
                    $vehicule['prolonger'] = $this->input->post('prolonger');
                    $vehicule['avance'] = $this->input->post('avance');
                    $vehicule['reste'] = $this->input->post('reste');
                    $vehicule['ttc'] = $this->input->post('ttc');
                    $vehicule['vehicle_id'] = $this->input->post('vehicle_id');

                    $customer['nom'] = $this->input->post('nom');
                    $customer['nationalitee'] = $this->input->post('nationalitee');
                    $customer['naissance'] = $this->input->post('naissance');
                    $customer['adresse'] = $this->input->post('adresse');
                    $customer['mobile'] = $this->input->post('mobile');
                    $customer['adresseEtranger'] = $this->input->post('adresseEtranger');
                    $customer['permisNumber'] = $this->input->post('permisNumber');
                    $customer['permisDelivrance'] = $this->input->post('permisDelivrance');
                    $customer['permisOwner'] = $this->input->post('permisOwner');
                    $customer['cin'] = $this->input->post('cin');
                    $customer['cinDelivrance'] = $this->input->post('cinDelivrance');
                    $customer['cinOwner'] = $this->input->post('cinOwner');
                    $customer['vehicle_id'] = $this->input->post('vehicle_id');

                    $customer_id=$this->model_customer->insert($customer);
                    $vehicule['customer_id'] = $customer_id;
                    $this->model_vehicle->location($vehicule,$location);
                    redirect(base_url('admin/vehicles'));
                }
            }
        }
        else {
            redirect(base_url('admin/vehicles'));
        }
	}

	public function add()
	{	
		if($this->input->post('buttonSubmit')) {
			$data['message'] = '';
		
				$this->form_validation->set_rules('manufacturer_id', 'Manufacturer', 'required');
				$this->form_validation->set_rules('model_id', 'Model', 'required');
				/*$this->form_validation->set_rules('category', 'Category ', 'required');*/
				$this->form_validation->set_rules('b_price', 'Buying Price ', 'required');
				$this->form_validation->set_rules('mileage', 'Mileage', 'required');
				$this->form_validation->set_rules('add_date', 'Adding Date', 'required');
				$this->form_validation->set_rules('registration_year', 'Registration Year Date', 'required');
				$this->form_validation->set_rules('insurance_id', 'Insurance ID', 'required');
				$this->form_validation->set_rules('gear', 'Gear', 'required');
				/*$this->form_validation->set_rules('doors', 'Number of Doors', 'required');*/
				$this->form_validation->set_rules('seats', 'Number of Seats', 'required');
				$this->form_validation->set_rules('tank', 'Tank capacity', 'required');
				$this->form_validation->set_rules('e_no', 'Engine No', 'required');
				/*$this->form_validation->set_rules('c_no', 'Chasis No', 'required');*/
				$this->form_validation->set_rules('v_color', 'Color', 'required');		
				
				if($this->form_validation->run() == FALSE)
				{
					//$data['vRow'] = $this->model_vehicle->get($cid);
                    $this->load->view('admin/view_vehicle');
				}
				else{
					
		
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_width']    = '2048';
            $config['max_height']   = '2048';
            $this->load->library('upload', $config);
            
            
            $manufacturer_name = $this->input->post('manufacturer_id');
		    $model_name = $this->input->post('model_id');
            $category = $this->input->post('category');
            $b_price = $this->input->post('b_price');
        
            $mileage = $this->input->post('mileage');
            $add_date = $this->input->post('add_date');
            $status = "available";
            $registration_year = $this->input->post('registration_year');
            $insurance_id = $this->input->post('insurance_id');
            $gear = $this->input->post('gear');
            $doors = $this->input->post('doors');
            $seats = $this->input->post('seats');
            $tank = $this->input->post('tank');
            $e_no = $this->input->post('e_no');
            $c_no = $this->input->post('c_no');
            $u_id = $this->session->userdata('id');
            $v_color = $this->input->post('v_color');
            $featured = $this->input->post('featured');
            
            $this->upload->do_upload('image');
            $data = $this->upload->data('image');
            $image= $data['file_name']; 
			
            $this->model_vehicle->insert($featured,$image,$manufacturer_name,$model_name,$category,$b_price,$mileage,$add_date,$status,$registration_year,$insurance_id,$gear,$doors,$seats,$tank,$e_no,$c_no,$u_id,$v_color);
			$this->session->set_flashdata('message','Vehicle Successfully Created.');
			redirect(base_url('admin/vehicles'));
		
			}
		}
		else{
		redirect(base_url('admin/vehicles'));
		}
	}



	public function DeleteVehicle()
	{
        if ($this->input->server('REQUEST_METHOD') == 'POST'){	
             
            $id = $this->input->post('vehicle_id');
            $this->model_vehicle->delete($id);
			$this->session->set_flashdata('message','Vehicle Successfully Deleted.');
            redirect(base_url('admin/vehicles'));
        }
        else {
            redirect(base_url('admin/vehicles'));
	    }
    }
        
    public function DeleteCustomer()
	{	
        if ($this->input->server('REQUEST_METHOD') == 'POST'){	
            $v_id= $this->input->post('v_id');
            $c_id= $this->input->post('c_id');
               
            $this->model_vehicle->deletecustomer($c_id,$v_id);
			$this->session->set_flashdata('message','Customer Successfully Created.');
            redirect(base_url('admin/vehicles/soldlist'));
        }
        else{
            redirect(base_url('admin/vehicles/soldlist'));
        }
	}

    public function soldList()
    {   
        $data['cus'] = $this->model_vehicle->customerList();
        $this->load->view('admin/view_sold', $data);     
    }
}

