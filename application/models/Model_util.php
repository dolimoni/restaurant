<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_util extends CI_Model {

    public function getUser($id){
        $this->db->where("id",$id);
        return $this->db->get("users")->row_array();
    }

    public function allUsers(){
        $this->db->order_by("id","asc");
        $this->db->where("status", "enabled");
        return $this->db->get("users")->result_array();
    }

    public function createUser($data,$actions){
        $this->load->model('model_ACL');
        $this->db->insert("users",$data);
        $user_id = $this->db->insert_id();
        $this->model_ACL->createDefaultAclForUser($user_id, $data["type"]);
        $this->model_ACL->updateUserAcl($user_id,$actions, $data["type"]);

    }
    public function editUser($user_id,$data,$actions){
        $this->load->model('model_ACL');
        $this->db->where("id", $user_id);

        $this->db->update("users",$data);
        $this->model_ACL->updateUserAcl($user_id, $actions, "user");
    }

    public function deleteUser($user_id)
    {
        $this->db->where('user', $user_id);
        $this->db->delete('acl');

        $this->db->where('id', $user_id);
        $this->db->delete('users');
    }
    public function isLastDayInMonth($day){
        $date = new DateTime('now');
        $date = $date->format('Y-m-d');

        $lastDay = $this->getLastDayInMonth();

        if($date === $lastDay){
            return true;
        }
        return false;
    }

    public function getLastDayInMonth($day){
        $date1 = new DateTime($day);
        $date1->modify('last day of this month');
        return $date1->format('Y-m-d');
    }

    public function clean(){
        $this->db->where('name','');
        $this->db->where('num !=',1);
        $this->db->delete('group');
    }

    public function query($query){

        $dbResult = $this->db->query($query);
        return $dbResult;
    }

    public function clear()
    {
        $this->load->model('model_db');
        $this->load->model('model_group');

        $this->model_db->troncate('consumption');
        $this->model_db->troncate('consumption_product');
        $this->model_db->troncate('meal');
        $this->model_db->troncate('meal_product');
        $this->model_db->troncate('product');
        $this->model_db->troncate('product_composition');
        $this->model_db->troncate('provider');
        $this->model_db->troncate('purchase');
        $this->model_db->troncate('quotation');
        $this->model_db->troncate('regularcost');
        $this->model_db->troncate('reparation');
        $this->model_db->troncate('report');
        $this->model_db->troncate('salary');
        $this->model_db->troncate('quantity');
        $this->model_db->troncate('employee');
        $this->model_db->troncate('employee_event');
        $this->model_db->troncate('orderdetails');
        $this->model_db->troncate('stock_history');
        $this->model_db->troncate('stock_meal');
        $this->model_db->troncate('stock_product');
        $this->model_db->troncate('magazin');
        $this->model_db->troncate('order');


        $sql="SET FOREIGN_KEY_CHECKS = 0;";
        $this->db->where("id >=", 1);
        $this->db->delete("meal");
        $this->db->where("id >=", 1);
        $this->db->delete("meal_product");


        $sql = "SET FOREIGN_KEY_CHECKS = 0;";
        $this->query($sql);
        $this->model_db->troncate('group');
        $this->model_db->troncate('department');

        $sql = "SET FOREIGN_KEY_CHECKS = 1;";
        $this->query($sql);
    }

    public function customClear($tables)
    {
        $this->load->model('model_db');
        $this->load->model('model_group');

        foreach ($tables as $table) {
            if($table==="group"){
                $sql = "SET FOREIGN_KEY_CHECKS = 0;";
                $this->query($sql);

                $this->model_db->troncate('group');

                $sql = "SET FOREIGN_KEY_CHECKS = 1;";
                $this->query($sql);
            }else if ($table==="consumption"){
                $this->db->where("id >=", 1);
                $this->db->delete("consumption");
                $this->db->where("id >=", 1);
                $this->db->delete("consumption_product");
            }else if ($table==="employee"){
                $this->db->where("id >=", 1);
                $this->db->delete("employee");
                $this->db->where("id >=", 1);
                $this->db->delete("employee_event");
                $this->db->where("id >=", 1);
                $this->db->delete("salary");
            }else if ($table==="meal"){
                $this->db->where("id >=", 1);
                $this->db->delete("meal");
                $this->db->where("id >=", 1);
                $this->db->delete("meal_product");
            }else if ($table==="product"){
                $this->db->where("id >=", 1);
                $this->db->delete("product");
                $this->db->where("id >=", 1);
                $this->db->delete("product_composition");
                $this->db->where("id >=", 1);
                $this->db->delete("quantity");
                $this->db->where("id >=", 1);
                $this->db->delete("product_autoconsum");
            }else if ($table==="provider"){
                $this->db->where("id >=",1);
                $this->db->delete("provider");
                $this->db->where("id >=",1);
                $this->db->delete("order");
                $this->db->where("id >=",1);
                $this->db->delete("orderdetails");
                $this->db->where("id >=",1);
                $this->db->delete("quotation");
                $this->db->update("quantity",array("provider"=>0));
            }else if ($table==="order"){
                $this->db->where("id >=", 1);
                $this->db->delete("order");
                $this->db->where("id >=", 1);
                $this->db->delete("orderdetails");
            }else if($table === "charges"){
                $this->db->where("id >=", 1);
                $this->db->delete("purchase");

                $this->db->where("id >=", 1);
                $this->db->delete("regularcost");

                $this->db->where("id >=", 1);
                $this->db->delete("reparation");

               // $this->model_db->troncate('reparation');
            }else if($table === "history"){
                $this->db->where("id >=", 1);
                $this->db->delete("stock_history");
            }
        }

    }

    
    public function populate(){
        $sql = "SET FOREIGN_KEY_CHECKS = 0;";
        $this->query($sql);

        $this->load->library('database');
        $queries = $this->database->getQueries();
        foreach ($queries as $query) {
            $this->db->query($query);
        }

        $sql = "SET FOREIGN_KEY_CHECKS = 1;";
        $this->query($sql);
    }

    public function diffDate($start, $end){
        // Date d'aujourd'hui
        $endDateTime = new DateTime($end);

        $startDateTime = new DateTime($start);


        $interval = date_diff($startDateTime, $endDateTime);
        $diffJours = $interval->format('%R%a');

        return $diffJours;
    }

    function date_fct($a, $b)
    {
        return strtotime($a) - strtotime($b);
    }

    public function sortDate($data, $columnName)
    {
        $columnArray = array_column($data, $columnName);


        usort($columnArray, array($this, "date_fct"));

        $response = array();

        foreach ($columnArray as $columnElement) {
            foreach ($data as $dataElement) {
                if ($columnElement === $dataElement[$columnName]) {
                    $response[] = $dataElement;
                }
            }
        }

        return $response;
    }

    public function sortDateBreak($data, $columnName)
    {
        $columnArray = array_column($data, $columnName);


        usort($columnArray, array($this, "date_fct"));

        $response = array();

        foreach ($columnArray as $key0=> $columnElement) {
            foreach ($data as $key => $dataElement) {
                if ($columnElement === $dataElement[$columnName]) {
                    $element= $data[$key];
                    $response[] = $element;
                    break;
                }
            }
        }

        return $response;
    }

    public function mergeDateArray($a1,$a2){
        $sums = array();
        $sums= $a1;
        foreach ($a2 as $key2 => $item2) {
            $date_exists = false;
            foreach ($a1 as $key1 => $item1) {
                if($item1["paymentDate"]=== $item2["paymentDate"]){
                    $sums[$key1]["price"] += $item2["price"];
                    $date_exists = true;
                    break;
                }
            }
            if (!$date_exists) {
                $sums[]= $item2;
            }
        }
        return $sums;
    }


}