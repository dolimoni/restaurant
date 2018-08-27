<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class BaseController extends CI_Controller
{

    private $params;

    private $acl;




    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_params');
        $this->load->model('model_budget');
        $controller = $this->router->fetch_class();
        $action = $this->router->fetch_method();
        $user_id = $this->session->userdata('id');
        $user_role = $this->session->userdata('type');
        $this->acl = $this->pageControlle($controller, $action, $user_id);

        // ne pas vérifier l appel au web service
        /*if(strpos($action, 'api') === false and  strpos($action, 'logout') === false and strpos($action, 'order') === false and strpos($action, 'add') === false ){
            if (!$this->acl and $user_role !== "admin") {
                redirect('/admin/employee/main');
            }
        }*/
        $this->params = $this->model_params->config(); // getting user configuration
        $this->params['alertes'] = $this->model_budget->getActiveAlerts();//gestion des alertes
        $this->params["acl"]= $this->model_params->enabledPages($user_id);// gestion des droits d accèss global
        $this->params["acl_page"]= $this->acl;// gestion des droits d accèss d une page


        // load language file
        $this->lang->load('common', $this->getParams()["language"]);
        $this->lang->load(strtolower($controller), $this->params["language"]);

        //$db = $this->session->userdata('db');
        //$this->setCurrentDb($db);
    }

    public function pageControlle($controller,$action,$user_id){
        $this->acl = $this->model_params->acl($controller, $action,$user_id);
        return $this->acl;
    }

    /**
     * @return mixed
     */
    public function getAcl()
    {
        return $this->acl;
    }

    /**
     * @param mixed $acl
     */
    public function setAcl($acl)
    {
        $this->acl = $acl;
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
        $data= print_r($this->input->post(NULL, TRUE), TRUE);
        log_message('info', ($data));
    }

    public function log_middle($data)
    {
        log_message('info', "dolimoni=>Log_middle: " . json_encode($data));
    }

    public function log_end($data)
    {
        log_message('info', "dolimoni=>Log_end: " . json_encode($data));
    }

    public function setCurrentDb($current_db)
    {
        $this->current_db = $current_db;
        if ($this->current_db === 0) {
            $this->db = $this->load->database('default', TRUE);
        } else {
            $this->db = $this->load->database('remote_' . $current_db, TRUE);
        }
    }




}

?>