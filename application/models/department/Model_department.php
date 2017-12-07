<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_department extends CI_Model {

    public function getAll()
    {
        $result = $this->db->get('department');
        return $result->result_array();
    }
    public function getDepartment($id)
    {
        $this->db->where('id',$id);
        $result = $this->db->get('department');
        return $result->row_array();
    }




    public function addDepartment($department)
    {

        $this->db->insert('department', $department);
    } 
    
    public function addStock($stock)
    {
        foreach ($stock['productsList'] as $product) {
            $data=array(
                'product'=> $product['id'],
                'quantity'=> $product['quantity'],
                'department'=> $stock['department'],
            );
            $this->db->insert('stock_product', $data);

        }
    }

    public function addMagazin($magazin)
    {

        $this->db->insert('magazin', $magazin);
    }


    public function getMagazinsWithMeals($department){
        $this->db->select('');
        $this->db->from('magazin');
        $this->db->where('department', $department);
        $magazins = $this->db->get()->result_array();


        $this->db->select('*,sm.id as sm_id');
        $this->db->from('stock_meal sm');
        $this->db->join('meal m','m.id=sm.meal');
        $this->db->where('department', $department);
        $this->db->where('type', 'magazin');

        $mealsInMagazin = $this->db->get()->result_array();

        foreach ($magazins as $key => $magazin) {
            $mealsList = array();
            foreach ($mealsInMagazin as $mealInMagazin) {
                if ($magazin['id'] === $mealInMagazin['magazin']) {
                    array_push($mealsList, $mealInMagazin);
                }
            }
            $magazins[$key]['mealsList'] = $mealsList;
        }

        return $magazins;
    }


    //getting meal in stock for spécific magazin
    public function getMagazinWithMeals($department,$magazin){
        $this->db->select('');
        $this->db->from('magazin');
        $this->db->where('department', $department);
        $this->db->where('id', $magazin);
        $magazinData = $this->db->get()->row_array();


        $this->db->select('*,sm.id as sm_id');
        $this->db->from('stock_meal sm');
        $this->db->join('meal m','m.id=sm.meal');
        $this->db->where('department', $department);
        $this->db->where('magazin', $magazin);
        $this->db->where('type', 'magazin');

        $mealsInMagazin = $this->db->get()->result_array();

        $magazinData['mealsList']= $mealsInMagazin;

        return $magazinData;
    }


    //getting product in stock
    public function getProducts($department){

        $this->db->select('*');
        $this->db->select('sum(sp.quantity) as s_quantity');
        $this->db->from('stock_product sp');
        $this->db->join('product p','sp.product=p.id');
        $this->db->where('department', $department);
        $this->db->group_by('sp.product');
        $products = $this->db->get()->result_array();

        return $products;
    }

    public function updateMagazin($magazin){

        $dataMagazin=array(
            'name'=> $magazin['name']
        );

        $this->db->where('id', $magazin['id']);
        $this->db->update('magazin', $dataMagazin);

        foreach ($magazin['mealsList'] as $meal) {
            $this->db->where('meal', $meal['id']);
            $sm = $this->db->get('stock_meal');

            if ($sm->num_rows() > 0) {
                $this->db->where('meal', $meal['id']);
                $this->db->where('magazin', $magazin['id']);
                unset($meal['id']);
                $this->db->update('stock_meal', $meal);
            } else {
                $dataMeal=array(
                  'meal'=> $meal['id'],
                  'magazin'=> $magazin['id'],
                  'department'=> $magazin['department'],
                  'quantityInMagazin'=> $meal['quantityInMagazin'],
                  'quantityInTotal'=> $meal['quantityInTotal'],
                );
                $this->db->insert('stock_meal', $dataMeal);
            }
        }

    }

}