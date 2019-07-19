<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 7/7/18
 * Time: 4:03 PM
 */

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        

        $this->load->model('model_test');

    }

    public function index()
    {
        $articles=$this->model_test->getSales();

        echo "<pre>";
        print_r($articles);
        echo "</pre>";
    }


}