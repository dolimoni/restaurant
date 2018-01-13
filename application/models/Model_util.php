<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_util extends CI_Model {

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
        $this->model_db->troncate('order');


        $sql="SET FOREIGN_KEY_CHECKS = 0;";
        $this->db->where("id >=", 1);
        $this->db->delete("meal");
        $this->db->where("id >=", 1);
        $this->db->delete("meal_product");


        $sql = "SET FOREIGN_KEY_CHECKS = 0;";
        $this->query($sql);
        $this->model_db->troncate('group');

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


}