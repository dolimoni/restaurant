<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_ACL extends CI_Model {

    private $defaultPages=array();


    /**
     * model_cron constructor.
     */
    public function __construct()
    {
    }

    public function createDefaultPages(){
        $this->getDefaultPages();
        foreach ($this->defaultPages as $name=>$controllers){
            foreach ($controllers as $action) {
                $acl = $this->acl($name, $action, 1); // user 1 : by defautl
                if(!$acl){
                    $dataAcl=array(
                        "controller"=> $name,
                        "action"=> $action,
                        "user"=> 1,
                        "role"=> "default",
                    );
                    $this->db->insert("acl", $dataAcl);
                }
            }
        }
    }

    public function createDefaultAclForUser($user_id,$role="user")
    {
        $this->getDefaultPages();
        foreach ($this->defaultPages as $name => $controllers) {
            foreach ($controllers as $action) {
                $acl = $this->acl($name, $action, 1); // user 1 : by defautl
                if ($acl) {
                    $acl["user"]= $user_id;
                    $acl["role"]= $role;
                    unset($acl["id"]);
                    $this->db->insert("acl", $acl);
                }
            }
        }
    }

    public function updateUserAcl($user_id,$actions,$role){

        $dataAcl = array(
            "status" => "disabled"
        );
        $this->db->where("user", $user_id);
        $this->db->where("status", "enabled");
        $this->db->where("visibility", "shown");
        $this->db->update("acl", $dataAcl);


        $this->db->where("id", $user_id);
        $db_user=$this->db->get("users")->row_array();


        if($db_user["type"]==="user"){
            foreach ($actions as $action) {
                $dataAcl = array(
                    "status" => "enabled"
                );
                $this->db->where("user", $user_id);
                $this->db->where("controller", $action["controller"]);
                $this->db->where("action", $action["action"]);
                $this->db->update("acl", $dataAcl);
            }
        }else if($db_user["type"] !== "admin"){
            $dataAcl = array(
                "status" => "enabled"
            );
            $this->db->where("user", $user_id);
            $this->db->where("controller", "Department");
            $this->db->update("acl", $dataAcl);
        }
    }

    public function acl($controller, $action, $user_id)
    {
        $this->db->where("controller", $controller);
        $this->db->where("action", $action);
        $this->db->where("user", $user_id);
        $this->db->where("status", "enabled");
        return $this->db->get("acl")->row_array();
    }

    public function getDefaultControllers($user_id, $department = "false",$role="default"){
        $this->db->select("controller");
        $this->db->select("controller_label");
        $this->db->where("user", $user_id);
        $this->db->where("visibility", "shown");
        $this->db->where("controller_label !=", "Catégorie");
        $this->db->where("action_label !=", "page");
        $this->db->group_by("controller");
        $this->db->order_by("controller", "asc");
        $controllers = $this->db->get("acl")->result_array();

        foreach ($controllers as $key=> $controller) {
            $this->db->select("*,action_label as text");
            $this->db->select("CASE status when 'disabled' then 'false' when 'enabled' then 'true' END as checked");
            $this->db->where("user", $user_id);
            $this->db->where("role", $role);
            $this->db->where("controller_label !=", "Catégorie");
            $this->db->where("action_label !=", "page");
            $this->db->where("visibility", "shown");
            $this->db->where("controller", $controller["controller"]);
            $actions = $this->db->get("acl")->result_array();
            $controllers[$key]["actions"] = $actions;
            if($controller["controller"]==="Department" and $department === "false"){
                unset($controllers[$key]);
            }
        }
        return $controllers;
    }

    /**
     * @return array
     */
    public function getDefaultPages()
    {
        $this->load->library('controllerList');
        $pages= $this->controllerlist->getControllers();
        foreach ($pages as $key=> $page){
            if($key!=="Login" and $key!=="Pages" and $key!=="ACL" and $key!=="Cron" and $key !== "api"){
                $input = preg_quote('api', '~'); // don't forget to quote input string!
                $data = array_splice($page, 0, -8);//remove common methods

                $result = preg_grep('~^((?!'. $input.').)*$~', $data);
                $this->defaultPages[$key] = $result;
            }
        }
        return $this->defaultPages;
    }

    /**
     * @param array $defaultPages
     */
    public function setDefaultPages($defaultPages)
    {
        $this->defaultPages = $defaultPages;
    }



}