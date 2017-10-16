<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Controller {

	public function index()
	{
		$this->load->view('header.php');
		$this->load->view('sidebar.php');
		$this->load->view('topnav.php');
		$this->load->view('content.php');
		$this->load->view('footer.php');
	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */