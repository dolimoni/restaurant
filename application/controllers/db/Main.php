<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_db');
        $this->load->model('model_group');


    }


    public function index()
    {
        $this->model_db->troncate('consumption');
        $this->model_db->troncate('consumption_product');
        $this->model_db->troncate('meal');
        $this->model_db->troncate('meal_product');
        $this->model_db->troncate('product');
        $this->model_db->troncate('quantity');
        $data['groups'] = $this->model_group->getAll();
        $this->parser->parse('admin/meal/view_group', $data);
    }

}

