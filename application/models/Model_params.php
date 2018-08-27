<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_params extends CI_Model {

    public function getConfigParams(){
        $params=$this->db->get("config")->row_array();
        $response=array();
        $response["orderReception"]=($params["orderReception"] === "true")? "checked":"";
        $response["orderPayment"]=($params["orderPayment"] === "true")? "checked":"";
        $response["editOrderDate"]=($params["editOrderDate"] === "true")? "checked":"";
        $response["editConsumptionDate"]=($params["editConsumptionDate"] === "true")? "checked":"";
        $response["addStockAfterOrder"]=($params["addStockAfterOrder"] === "true")? "checked":"";
        $response["disableConsumptionProducts"]=($params["disableConsumptionProducts"] === "true")? "checked":"";
        return $response;
    }
	public function config()
	{
        $result = $this->db->get('config')->row_array();
        $this->db->select("photo");
        $this->db->from("users");
        $this->db->where("type","admin");
        $result["photo"]=$this->db->get()->row("photo");
        return $result;
	}

	public function update($data)
	{
	    $response=array("status"=>"success");
        $this->db->update('config',$data);
        return $response;
	}

	public function acl($controller, $action, $user_id){
	    $this->db->where("controller", $controller);
	    $this->db->where("action", $action);
	    $this->db->where("user", $user_id);
	    $this->db->where("status", "enabled");
	    return $this->db->get("acl")->row_array();
    }

    public function enabledPages($user_id){
	    $this->db->where("user", $user_id);
	    $this->db->where("status", "enabled");
	    $this->db->where("visibility", "shown");
	    $actions = $this->db->get("acl")->result_array();


        $controllers = $actions;

        $l_controller=array();
        foreach ($controllers as $controller) {
            $l_controller[$controller["controller"]][$controller["action"]] = $controller;
        }

	    /*$acl["Agency"] = array_filter($actions, function ($e) {
            return $e["controller"] == "Agency";
        });$acl["Budget"] = array_filter($actions, function ($e) {
            return $e["controller"] == "Budget";
        });$acl["Department"] = array_filter($actions, function ($e) {
            return $e["controller"] == "Department";
        });$acl["Employee"] = array_filter($actions, function ($e) {
            return $e["controller"] == "Employee";
        });$acl["Meal"] = array_filter($actions, function ($e) {
            return $e["controller"] == "Meal";
        });$acl["Product"] = array_filter($actions, function ($e) {
            return $e["controller"] == "Product";
        });$acl["Provider"] = array_filter($actions, function ($e) {
            return $e["controller"] == "Provider";
        });$acl["Report"] = array_filter($actions, function ($e) {
            return $e["controller"] == "Report";
        });*/

        $acl= $l_controller;
	    return $acl;

    }


}
		
