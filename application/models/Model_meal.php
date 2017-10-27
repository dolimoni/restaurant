<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_meal extends CI_Model {



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
        $this->updateConsumptionRate($meal_id);
        return $meal_id;
	}

	public function edit($meal)
	{
		$data = array(
			   'name' => $meal['name'],
			   'group' => $meal['group'],
			   'cost' => $meal['cost'],
			   'sellPrice' => $meal['sellPrice'],
			   'profit' => $meal['profit'],
			   'products_count' => count($meal['productsList']),
            );
		$this->db->where('id', $meal['id']);
		$this->db->update('meal', $data);
        $this->addProductsForMeal($meal['id'],$meal['productsList'],'current');
        return $meal['id'];
	}

	public function addMeals($mealsList)
	{
        $res=array();
        $res['status']="success";
        $mealsExist=array();

	    foreach ($mealsList as $mealItem){
	        $meal = $this->getByExternalCode($mealItem['code']);
	        if(!$meal){
                $data = array(
                    'name' => $mealItem['name'],
                    'group' => $mealItem['group'],
                    'externalCode' => $mealItem['code'],
                    'sellPrice' => $mealItem['sellPrice'],
                    'products_count' => 0,
                );
                $this->db->insert('meal', $data);
            }else{
	            $mealsExist[]=$meal;
                $res['status']= 'warning';
            }
        }

        $res['mealsExist'] = $mealsExist;

        return $res;

	}
	public function updateMeals($mealsList,$selector='externalCode')
	{
        $res=array();
        $res['status']="success";
        try{
            foreach ($mealsList as $mealItem) {
                $meal = $this->getByExternalCode($mealItem['code']);
                if ($selector === 'id') {

                }
                if ($meal) {
                    $data = array(
                        'name' => $mealItem['name'],
                        'group' => $mealItem['group'],
                        'sellPrice' => $mealItem['sellPrice'],
                        'products_count' => 0,
                    );
                    $this->db->where('externalCode', $mealItem['code']);
                    $this->db->update('meal', $data);
                } else {
                    $res['status'] = 'error';
                    $res['message'] = 'une erreur s\'est produite';
                }
            }

        }catch (Exception $e){
            $res['status'] = 'error';
            $res['message'] = 'une erreur s\'est produite!';
        }
        return $res;

	}

	public function deleteProductForMeal($meal_id,$product_id)
	{
        $res=array();
        $res['status']="success";
        try{
            $data = array(
                'status' =>'deleted'
            );
            $this->db->where('meal', $meal_id);
            $this->db->where('product', $product_id);
            $this->db->update('meal_product', $data);
            $this->updateProductsCount($meal_id,1,'down');
            $this->updateMealPrice($meal_id);
            $this->updateConsumptionRate($meal_id);

        }catch (Exception $e){
            $res['status'] = 'error';
            $res['message'] = 'une erreur s\'est produite!';
        }
        return $res;

	}

	//$status :  current or old, apres la modification on change le status du current a old, et on crée les nouveaux produits
	public function addProductsForMeal($meal_id,$productsList,$status='old'){

        $this->db->select('product');
        $this->db->from('meal_product');
        $this->db->where('meal', $meal_id);
        $mps = $this->db->get()->result_array();
        $count_mps=count($mps);

        $removedProductsIds=array();

        if (count($productsList) != $count_mps) ;
        {
            $productsList_ids = array_column($productsList, 'id');
            $mps_ids = array();
            foreach ($mps as $mp){
                $mps_ids[]=$mp['product'];
            }
            $removedProductsIds = array_diff($mps_ids, $productsList_ids);
        }
	    foreach ($productsList as $product){


	        // donnée du produit
            $dataCreate = array(
                'product' => $product['id'],
                'quantity' => $product['quantity'],
                'meal' => $meal_id,
                'status'=>'current'
            );

            /************************** Equivalent a la suppression dans le cas de edit ***********************/

            // récupérer le un produit qui compose l'article pour le modifier
            $this->db->where('product', $product['id']);
            $this->db->where('meal', $meal_id);


            // si status est old ça veut dire qu'on va faire une insert
            // si status est current ça veut dire qu'on va faire un update
            $this->db->where('status', $status);


            $dataUpdate = array('status' => 'old');

            // update
            $q = $this->db->update('meal_product', $dataUpdate);

            /*************************************************************************************************/

            //Créer le produit et lui donner le status current
            $this->db->insert('meal_product', $dataCreate);

            //supprimer le id du produit de la liste des id des produits qu'on va supprimer
            if(in_array($product['id'], $removedProductsIds)){
                array_diff($removedProductsIds, $product['id']);
            }
        }

        // Supprimer les produits qui existent déjà et qui n'ont été pas envoyé
        foreach ($removedProductsIds as $removedProductsId){
            $this->db->where('product', $removedProductsId);
            $this->db->where('meal', $meal_id);
            $dataUpdate = array('status' => 'old');
            // update
            $q = $this->db->update('meal_product', $dataUpdate);
        }

        $this->updateMealPrice($meal_id);
        $this->updateConsumptionRate($meal_id);

    }

    public function getProducts($id){
        $this->db->select('*,q.id as q_id,mp.id as id,mp.quantity as mp_quantity');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product = p.id');
        $this->db->join('quantity q', 'q.product = p.id');
        $this->db->where('mp.meal', $id);
        $this->db->where('q.status', 'active');
        $this->db->where('mp.status', 'current');

        $products = $this->db->get()->result_array();
        return $products;
	}

    public function getByExternalCode($externalCode)
    {
        $this->db->where('externalCode', $externalCode);
        $result = $this->db->get('meal');
        return $result->row_array();
    }

    public function consumption($mealList){
        $this->load->model('model_product');
        $response = array();
        $response['status'] = "success";
        $productsErrorList=array();

        foreach ($mealList as $meal) {
            $data = array(
                'meal' => $meal['id'],
                'amount' => $meal['amount'],
                'quantity' => $meal['quantity'],
            );

            $this->db->insert('consumption', $data);
            $consumption_id = $this->db->insert_id();
            $this->db->select('*,mp.quantity as mp_quantity,p.id as p_id');
            $this->db->from('meal_product mp');
            $this->db->join('product p', 'mp.product = p.id');
            $this->db->join('quantity q', 'q.product = p.id');
            $this->db->where('q.status', 'active');
            $this->db->where('mp.status', 'current');
            $this->db->where('mp.meal', $meal['id']);

            //list of products that make up a meal
            $m_products = $this->db->get()->result_array();

            foreach ($m_products as $m_product){

                //$m_products['product'] : produit's id
                //$m_products['quantity'] : the amount of the product in the meal
                //$meal['quantity'] : quantity of the meal

                // update reduce the amount of a product's stock after consumption the meal
                if($m_product['totalQuantity']> $m_product['mp_quantity'] * $meal['quantity'] ){
                    if($response['status'] === "success"){
                        $consumption_product=array(
                          'consumption'=> $consumption_id,
                          'meal'=> $meal['id'],
                          'product'=> $m_product['p_id'],
                          'quantity'=> $m_product['mp_quantity'] * $meal['quantity'],
                          'unit_price'=> $m_product['unit_price'],
                        );
                        $this->db->insert('consumption_product', $consumption_product);
                        $this->model_product->updateQuantity($m_product['product'], $m_product['mp_quantity'] * $meal['quantity']);
                        $this->model_product->updateLocalQuantity($m_product['product'], $m_product['mp_quantity'] * $meal['quantity']);
                    }
                }else{
                    $response['status']="error";
                    $productsErrorList[]= $m_product;
                }
                $response['productsList'] = $productsErrorList;
            }

        }

        return $response;
    }


	public function getAll()
	{
        $this->db->select('*,meal.id as meal_id, meal.name as meal_name, g.name as g_name');
        $this->db->from('meal');
        $this->db->join('group g', 'g.id = meal.group');
        $this->db->order_by('meal_id', 'asc');
        $meals = $this->db->get()->result_array();
		//$products = $this->db->get('meal_product')->result_array();

        $this->db->select('*,mp.quantity as mp_quantity');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product = p.id');
        $this->db->join('quantity q', 'q.product = p.id');
        $this->db->where('q.status', 'active');
        $this->db->where('mp.status', 'current');

        $products = $this->db->get()->result_array();

		foreach ($meals as $key => $meal){
            $productsList = array();
            foreach ($products as $product) {
                if($meal['meal_id']===  $product['meal']){
                    array_push($productsList, $product);
                }
            }
            $meals[$key]['productsList'] = $productsList;
        }
        unset($meal);
		return $meals;
	}

	public function get($u_id)
	{
		$this->db->where('id', $u_id);
		$result = $this->db->get('meal');
		return $result->row_array();
	}

    public function getByGroup($id)
    {
        $this->db->select('*,meal.name as meal_name, g.name as g_name');
        $this->db->from('meal');
        $this->db->join('group g', 'g.id = meal.group');
        $this->db->where('meal.group',$id);
        $meals = $this->db->get()->result_array();
        //$products = $this->db->get('meal_product')->result_array();

        $this->db->select('*,mp.quantity as mp_quantity');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product = p.id');
        $this->db->where('mp.status', 'current');

        $products = $this->db->get()->result_array();
        foreach ($meals as $key => $meal) {
            $meal['productsList'] = array();
            foreach ($products as $product) {
                if ($meal['id'] === $product['meal']) {
                    array_push($meal['productsList'], $product);
                }
            }
            $meals[$key]['productsList'] = $meal['productsList'];
        }
        unset($meal);
        return $meals;
    }


    public function update($f_name,$l_name,$u_bday,$u_position,$u_type,$u_pass,$u_mobile,$u_gender,$u_address,$u_id)
	{
		$data = array(
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

		$this->db->where('id', $u_id);
		$this->db->where("(su != 1)");
		$this->db->update('users', $data); 
	}

	public function updateProductsCount($meal_id,$n,$direction='up'){

        $this->db->where('id', $meal_id);
        $products_count = $this->db->get('meal')->row()->products_count;

        $data = array(
            'products_count' => $products_count + $n
        );

        if($direction!=='up'){
            $data = array(
                'products_count' => $products_count - $n
            );
        }

        $this->db->where('id', $meal_id);
        $this->db->update('meal', $data);
    }

    public function updateMealPrice($meal_id){

	    $products=$this->getProducts($meal_id);

        $this->db->where('id', $meal_id);
        $meal = $this->db->get('meal')->row_array();

	    $cost=0;
	    foreach ($products as $product){
            $cost+=$product['mp_quantity']*$product['unit_price'];
        }
        $profit= $meal['sellPrice']-$cost;


        $data = array(
            'cost' => $cost,
            'profit' => $profit
        );

        $this->db->where('id', $meal_id);
        $this->db->update('meal', $data);
    }

    // update consumption rate for each product
    public function updateConsumptionRate($meal_id){

        //getting all products
	    $products=$this->getProducts($meal_id);

        $this->db->where('id', $meal_id);
        $meal = $this->db->get('meal')->row_array();

        // getting meal cost
        $cost=$meal['cost'];

	    foreach ($products as $product){
            $productCostRate=$product['mp_quantity']*$product['unit_price']/$cost;

            $data = array(
                'consumptionRate' => $productCostRate
            );

            $this->db->where('meal', $meal_id);
            $this->db->where('product', $product['id']);
            $this->db->update('meal_product', $data);
        }
    }


	public function delete($u_id)
	{
		$this->db->where('id', $u_id);
		$this->db->where("(su != 1)");
		$this->db->delete('users'); 
	}
}