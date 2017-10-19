<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CI_Controller {


    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_room');
        $this->load->model('model_booking');
    }

	public function index()
	{
	    $data['rooms']=$this->model_room->getAll();
		$this->load->view('room/view_list.php',$data);
	}
	public function view()
	{
	    $id= $this->uri->segment(3);

	    //données de la chambre
	    $data['room']=$this->model_room->get($id);
	    $data['booking']=$this->model_booking->getByRoom($id);
	    $data['roomNumber']= $id;
		$this->load->view('room/view_room.php',$data);
	}

    public function book()
    {
        $id = $this->uri->segment(3);
        $data['room'] = $this->model_room->get($id);
        $data['roomNumber'] =$id;
        $this->load->view('room/view_book.php', $data);
    }
    public function apiBook()
    {
        $book = $this->input->post('book');
        $data['booking'] = $this->model_booking->book($book);
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode(array('status' => 'success','redirect'=>base_url(''))));
    }

}
?>