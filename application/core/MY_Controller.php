<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class BaseController extends CI_Controller
{

    private $params;


    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_params');
        $this->load->model('model_budget');
        $this->params = $this->model_params->config(); // getting user configuration
        $this->params['alertes'] = $this->model_budget->getActiveAlerts();
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


    public function log_begin()
    {
        log_message('info', "dolimoni=>Log_begin: " . $this->router->fetch_class() . " " . $this->router->fetch_method());
        log_message('info', print_r($this->input->post(NULL, TRUE), TRUE));
    }

    public function log_middle($data)
    {
        log_message('info', "dolimoni=>Log_middle: " . print_r($data, TRUE));
    }

    public function log_end($data)
    {
        log_message('info', "dolimoni=>Log_end: " . print_r($data, TRUE));
    }




}

?>