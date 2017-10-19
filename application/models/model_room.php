<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_room extends CI_Model {




    public function getAll(){
        $result = $this->db->get('room');
        return $result->result_array();
    }








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

    public function getByExternalCode($externalCode)
    {
        $this->db->where('externalCode', $externalCode);
        $result = $this->db->get('meal');
        return $result->row_array();
    }

    public function consumption($mealList)
    {
        $this->load->model('model_product');
        foreach ($mealList as $meal) {
            $data = array(
                'meal' => $meal['externalCode'],
                'amount' => $meal['amount'],
                'quantity' => $meal['quantity'],
            );
            $this->db->insert('consumption', $data);

            $this->db->select('*,mp.quantity as mp_quantity');
            $this->db->from('meal_product mp');
            $this->db->join('product p', 'mp.product = p.id');
            $this->db->where('mp.meal', $meal['id']);

            //list of products that make up a meal
            $m_products = $this->db->get()->result_array();

            foreach ($m_products as $m_product){

                //$m_products['product'] : produit's id
                //$m_products['quantity'] : the amount of the product in the meal
                //$meal['quantity'] : quantity of the meal

                // update reduce the amount of a product's stock after consumption the meal
                $this->model_product->updateQuantity($m_product['product'], $m_product['mp_quantity']*$meal['quantity']/1000);
            }

        }
    }


	public function getAll1()
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

	public function get($u_id)
	{
		$this->db->where('id', $u_id);
		$result = $this->db->get('room');
		return $result->row_array();
	}
	
	public function updateStatus($id,$status)
	{
		$data = array(
			'status' => $status,
        );

		$this->db->where('id', $id);
		$this->db->update('room', $data);
	}


	public function delete($u_id)
	{
		$this->db->where('id', $u_id);
		$this->db->where("(su != 1)");
		$this->db->delete('users'); 
	}
}