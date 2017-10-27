<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_quotation extends CI_Model {

	public function insert($u_email,$f_name,$l_name,$u_bday,$u_position,$u_type,$u_pass,$u_mobile,$u_gender,$u_address)
	{
		$data = array(
			   'email' => $u_email,
               'first_name' => $f_name,
               'last_name' => $l_name,
               'birthday' => $u_bday,
			   'position' => $u_position,
			   'type' => $u_type,
			   'password' => $u_pass,
			   'mobile' => $u_mobile,
			   'gender' => $u_gender,
			   'address' => $u_address
            );
		$this->db->insert('users', $data); 
	}

	public function add($meal)
	{
		$data = array(
			   'name' => $meal['name'],
			   'group' => $meal['group'],
			   'cost' => $meal['cost'],
			   'sellPrice' => $meal['sellPrice'],
			   'profit' => $meal['profit'],
			   'products_count' => 2,
            );
		$this->db->insert('meal', $data);
        $meal_id = $this->db->insert_id();
        $this->addProductsForMeal($meal_id,$meal['productsList']);
        return $meal_id;
	}

	public function addProductsForMeal($meal_id,$productsList){

	    foreach ($productsList as $product){
            $data = array(
                'product' => $product['id'],
                'quantity' => $product['quantity'],
                'meal' => $meal_id,
            );
            $this->db->insert('meal_product', $data);
        }
    }

    public function getProducts($id){
        $this->db->select('*');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product = p.id');
        $this->db->where('mp.meal', $id);

        $products = $this->db->get()->result_array();
        return $products;
	}


	public function getAll()
	{
		$meals = $this->db->get('meal')->result_array();
		//$products = $this->db->get('meal_product')->result_array();

        $this->db->select('*');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product = p.id');

        $products = $this->db->get()->result_array();
		foreach ($meals as $key => $meal){
            $meal['productsList'] = array();
            foreach ($products as $product) {
                if($meal['id']===  $product['meal']){
                    array_push($meal['productsList'], $product);
                }
            }
            $meals[$key]['productsList'] = $meal['productsList'];
        }
        unset($meal);
		return $meals;
	}

	public function get($id,$fetch='LAZY')
	{
	    if($fetch==="LAZY"){
            $this->db->where('id', $id);
            $result = $this->db->get('quotation');
            return $result->row_array();
        }else{
            $this->db->select('*,q.id as quotation_id');
            $this->db->from('quotation q');
            $this->db->join('product p', 'p.quotation = q.id');
            $this->db->where('q.id', $id);
            $result = $this->db->get();
            return $result->result_array();
        }


	}
	
	public function update($quotation)
	{
		$data = array(
			'number' => $quotation['number'],
			'reception_date' => date("Y-m-d", strtotime($quotation['reception_date'])) ,
        );

		$this->db->where('id', $quotation['id']);
		$this->db->update('quotation', $data);
	}


	public function delete($u_id)
	{
		$this->db->where('id', $u_id);
		$this->db->where("(su != 1)");
		$this->db->delete('users'); 
	}
}