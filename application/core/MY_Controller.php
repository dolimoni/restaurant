<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class BaseController extends CI_Controller
{

    private $params;


    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_params');
        $this->params = $this->model_params->config(); // getting user configuration

    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }




}

?>