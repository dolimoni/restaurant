<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_room');
    }

	public function index()
	{
        $data['rooms'] = $this->model_room->getAll();
        $this->load->view('room/view_list.php', $data);
	}


}
?>