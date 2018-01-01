<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * NOTICE :
 *
 * Verifier la quantité inséré pour dans la table consumption_prodct : faut il multiplié par le quantité de meal aussi ou non
 * Vérifier ça en cas d'erreur $todayConsumption=$this->model_report->reportMealDate($meal['id'], $meal['date'][0]);
 *
 */


class model_meal extends CI_Model {



	public function add($meal)
	{
		$data = array(
			   'name' => $meal['name'],
			   'group' => $meal['group'],
			   'cost' => $meal['cost'],
			   'sellPrice' => $meal['sellPrice'],
			   'profit' => $meal['profit'],
			   'products_count' => count($meal['productsList']),
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
        $this->updateConsumptionRate($meal['id']);
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
                'unit'=> $product['unit'],
                'unitConvert'=> $product['unitConvert'],
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
        $this->db->select('*,q.id as q_id,mp.id as id,mp.quantity as mp_quantity,mp.unit as mp_unit');
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

    public function consumption($mealList,$lost=false){
        $this->load->model('model_product');
        $this->load->model('model_report');
        $response = array();
        $response['status'] = "success";
        $productsErrorList=array();
        $response['productsList']="";

        foreach ($mealList as $meal) {

            // vente d'un article par date
            $todayConsumption=$this->model_report->reportMealDate($meal['id'], $meal['date'][0]);
            $consumption_type="sale";
            if($lost){
                $consumption_type = "lost";
            }
            $data = array(
                'meal' => $meal['id'],
                'amount' => $meal['amount']/$meal['quantity'],
                'quantity' => $meal['quantity'],
                'total'=> $meal['amount'],
                'report_date'=>$meal['date'][0],
                'type'=> $consumption_type,
            );
            $consumption_id=0;
            $quantityStep = $meal['quantity'];

            // si la vente de date existe
            if($todayConsumption){
                //$meal['quantity'] : quantité envoyé par le rapport de vente,
                // la quantité de vente augement a chaque interval de temps
                //$todayConsumption['quantity'] : quantité de la base de donnée

                //$quantityStep va être utilisé pour reduire la quantité des produits du stock
                $quantityStep = abs($meal['quantity'] - $todayConsumption['quantity']);
                $this->db->where('id', $todayConsumption['id']);
                $this->db->update('consumption', $data);
            // si la vente du jour n'existe pas on va la créer simplement
            }else{
                $this->db->insert('consumption', $data);
                $consumption_id = $this->db->insert_id();
            }


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
                //$m_product['unitConvert']: conversion du Kg vers gr ou mg ..

                // update reduce the amount of a product's stock after consumption the meal
                if($m_product['totalQuantity']> $m_product['mp_quantity']* $m_product['unitConvert'] * $meal['quantity'] or true ){
                    if($response['status'] === "success"){
                        if($consumption_id===0){
                            $consumption_id=$todayConsumption['id'];
                        }
                        $consumption_type = "sale";
                        if ($lost) {
                            $consumption_type = "lost";
                        }

                        $l_reponse='';
                        if($meal['quantity'] >= $todayConsumption['quantity']){
                            $this->model_product->updateQuantity($m_product['product'], $m_product['mp_quantity'] * $m_product['unitConvert'] * $quantityStep);
                            $l_reponse=$this->model_product->updateLocalQuantity($m_product['product'], $m_product['mp_quantity'] * $m_product['unitConvert'] * $quantityStep);
                        }else{
                            $this->model_product->updateQuantity($m_product['product'], $m_product['mp_quantity'] * $m_product['unitConvert'] * $quantityStep,'up');
                            $l_reponse=$this->model_product->updateLocalQuantity($m_product['product'], $m_product['mp_quantity'] * $m_product['unitConvert'] * $quantityStep,'up');
                        }

                        // consommation des produits selon la quantité de la fiche technique et leurs prix selon le stock
                        foreach ($l_reponse['quantities'] as $quantity) {
                            // il faut modifier ces donnée pour prendre en considération l'utilisation de plusieurs quantités
                            // l'ajout de consommation des produits doit etre fait apres la reduction de quantités produits
                            // on renvoie la liste des  produit utilisé et on les insère dans la table consomation produit
                            $consumption_product = array(
                                'consumption' => $consumption_id,
                                'meal' => $meal['id'],
                                'product' => $m_product['p_id'],
                                'quantity' => abs($quantity['quantity']),
                                'unit_price' => $quantity['unit_price'],
                                'total' => abs($quantity['quantity'])*$quantity['unit_price'],
                                'type' => $consumption_type
                            );

                            if (!isset($todayConsumption)) {
                                $this->db->insert('consumption_product', $consumption_product);
                            }
                        }
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

        $this->db->select('*,mp.quantity as mp_quantity,mp.unit as mp_unit');
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
        $this->db->select('*,meal.name as meal_name, g.name as g_name,g.id as g_id,meal.id as m_id');
        $this->db->from('meal');
        $this->db->join('group g', 'g.id = meal.group');
        $this->db->where('meal.group',$id);
        $meals = $this->db->get()->result_array();
        //$products = $this->db->get('meal_product')->result_array();

        $this->db->select('*,mp.quantity as mp_quantity,mp.unit as mp_unit');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product = p.id');
        $this->db->join('quantity q', 'q.product = p.id');
        $this->db->where('mp.status', 'current');
        $this->db->where('q.status', 'active');

        $products = $this->db->get()->result_array();
        foreach ($meals as $key => $meal) {
            $meal['productsList'] = array();
            foreach ($products as $product) {
                if ($meal['m_id'] === $product['meal']) {
                    array_push($meal['productsList'], $product);
                }
            }
            $meals[$key]['productsList'] = $meal['productsList'];
        }
        unset($meal);
        return $meals;
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
            $cost+=$product['mp_quantity']*$product['unitConvert']*$product['unit_price'];
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
            $productCostRate=$product['mp_quantity']*$product['unitConvert']*$product['unit_price']/$cost;

            $data = array(
                'consumptionRate' => $productCostRate
            );

            $this->db->where('meal', $meal_id);
            $this->db->where('product', $product['product']);
            $this->db->update('meal_product', $data);
        }
    }


	public function deleteMeal($meal_id)
	{
		$this->db->where('id', $meal_id);
		$this->db->delete('meal');
	}

    public function getByName($productName)
    {
        $this->db->where('name', $productName);
        return $this->db->get("meal")->result_array();
    }
}