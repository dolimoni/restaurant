<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * NOTICE :
 *
 * Verifier la quantité inséré pour dans la table consumption_prodct : faut il multiplié par le quantité de meal aussi ou non
 *
 */


class model_meal extends CI_Model {

    private $params;


    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_params');
        $this->params = $this->model_params->config(); // getting user configuration
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



	public function add($meal)
	{

	    $response=array(
	        "status"=>true,
        );

	    $db_meal=$this->getByExternalCode($meal["externalCode"]);
	    if($db_meal and $meal["externalCode"]!="000000000000000000"){
            $response["status"]="warning";
            $response["msg"]="Le code caisse existe déjà";
            return $response;
        }else{
	        if($meal["externalCode"] === "000000000000000000"){
                $meal["externalCode"]=null;
            }
            $data = array(
                'name' => $meal['name'],
                'group' => $meal['group'],
                'cost' => $meal['cost'],
                'sellPrice' => $meal['sellPrice'],
                'profit' => $meal['profit'],
                'quantity' => $meal['quantity'],
                'externalCode' => $meal['externalCode'],
                'products_count' => count($meal['productsList']),
            );
            $this->db->insert('meal', $data);
            $meal_id = $this->db->insert_id();
            $this->addProductsForMeal($meal_id, $meal['productsList']);
            $this->updateConsumptionRate($meal_id);
            $response['redirect']=base_url('admin/meal/view/' . $meal_id);
            return $response;
        }
	}

	public function addSimpleMeal($meal){
        $db_meal = $this->getByExternalCode($meal['code']);
        if (!$db_meal) {
            $data = array(
                'name' => $meal['name'],
                'group' => $meal['group'],
                'externalCode' => $meal['code'],
                'sellPrice' => $meal['sellPrice'],
                'products_count' => 0,
            );
            $this->db->insert('meal', $data);
            $id= $this->db->insert_id();
            return $id;
        }
    }

	public function edit($meal)
	{
		$data = array(
			   'name' => $meal['name'],
			   'group' => $meal['group'],
			   'cost' => $meal['cost'],
			   'sellPrice' => $meal['sellPrice'],
			   'profit' => $meal['profit'],
               'quantity' => $meal['quantity'],
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

    public function getByDepartment($department)
    {

        $this->db->select('*,meal.id as meal_id, meal.name as meal_name, g.name as g_name');
        $this->db->from('meal');
        $this->db->join('group g', 'g.id = meal.group');
        $this->db->where('g.department', $department);
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

        foreach ($meals as $key => $meal) {
            $productsList = array();
            foreach ($products as $product) {
                if ($meal['meal_id'] === $product['meal']) {
                    array_push($productsList, $product);
                }
            }
            $meals[$key]['productsList'] = $productsList;
        }
        unset($meal);
        return $meals;
    }

    public function deleteConsumption($params){
        $report_date=$params["report_date"];
        $this->load->model('model_params');
        $this->load->model('department/model_department');
        $db_params = $this->model_params->config();
        $this->db->where("report_date",$report_date);
        $consumptions=$this->db->get("consumption")->result_array();
        $updateProductsQuantities=true;
        if($updateProductsQuantities){
            foreach ($consumptions as $consumption) {
                $this->db->select('*');
                $this->db->from('consumption_product cp');
                $this->db->where('cp.consumption', $consumption['id']);
                $consumption_products=$this->db->get()->result_array();

                $meal=array('id'=>$consumption['meal']);
                $this->model_department->updateSMSealHistory($meal,$consumption['quantity'],false,$report_date);
                foreach ($consumption_products as $consumption_product) {
                    $this->db->where("id", $consumption_product["id"]);
                    $this->db->delete("consumption_product");

                    if ($db_params["used_stock"] === "principal") {
                        $this->db->where("id", $consumption_product["id_quantity"]);
                        $quantity_product = $this->db->get("quantity")->row_array();
                        $data = array("quantity" => $quantity_product["quantity"] + $consumption_product["quantity"]);
                        $this->db->where("id", $quantity_product["id"]);
                        $this->db->update("quantity", $data);
                    } else {
                        $this->db->where("id_quantity", $consumption_product["id_quantity"]);
                        $stock_product = $this->db->get("stock_product")->row_array();
                        $data = array("quantity" => $stock_product["quantity"] + $consumption_product["quantity"]);
                        $this->db->where("id", $stock_product["id"]);
                        $this->db->update("stock_product", $data);
                    }
                }
            }
        }

        $consumptionData = array(
            "quantity" => 0,
            "amount" => 0,
            "total" => 0,
        );
        $this->db->where("report_date", $report_date);
        $this->db->delete("consumption");

    }

    public function consumption($mealList,$lost=false,$ftp=false){
        $this->load->model('model_product');
        $this->load->model('model_report');
        $this->load->model('department/model_department');
        $this->load->model('model_params');
        $params = $this->model_params->config();
        $response = array();
        $response['status'] = "success";
        $response['productsList']="";
        $zReport=true;

        foreach ($mealList as $key => $meal) {

            //quantité positive ou négative
            $next=true;
            // vente d'un article par date
            $todayConsumption = $this->model_report->reportMealDate($meal['id'], $meal['date'][0],$lost);
            $report_date=$meal['date'][0];
            $db_meal=$this->get($meal['id']);
            $consumption_type = "sale";
            if ($lost) {
                $consumption_type = "lost";
            }
            $data = array(
                'meal' => $meal['id'],
                'quantity' => $meal['quantity'],
                'total' => $meal['amount'],
                'report_date' => $report_date,
                'type' => $consumption_type,
            );
            if($meal['quantity']>0){
                $data['amount']=$meal['amount'] / $meal['quantity'];
            }else{
                $data['amount']=0;
            }
            $consumption_id = 0;
            $quantityStep = $meal['quantity'];

            // si la vente de date existe
            if ($todayConsumption) {
                //$meal['quantity'] : quantité envoyé par le rapport de vente,
                // la quantité de vente augement a chaque interval de temps
                //$todayConsumption['quantity'] : quantité de la base de donnée

                //$quantityStep va être utilisé pour reduire la quantité des produits du stock
                if(!$ftp){
                    $quantityStep = abs($meal['quantity'] - $todayConsumption['quantity']);
                }else{
                    // if ftp then
                    $data["quantity"]= $todayConsumption['quantity']+ $meal['quantity'];
                    $data["total"]+= $todayConsumption["total"];
                    $data["amount"]= $data["total"]/$data["quantity"];
                }
                $this->db->where('id', $todayConsumption['id']);
                $this->db->update('consumption', $data);
                if($meal['quantity']<$todayConsumption['quantity']){
                    $next=false;
                }
                if (!$lost) {
                    $this->model_department->updateSMSealHistory($meal,$quantityStep,$next,$report_date);
                }
                // si la vente du jour n'existe pas on va la créer simplement
            } else {
                $this->db->insert('consumption', $data);
                $consumption_id = $this->db->insert_id();
                if(!$lost){
                    $this->model_department->updateSMSealHistory($meal,$quantityStep,$next,$report_date);
                }
            }


            if ($this->params['department'] === "false" or true) {
                $this->db->select('*,mp.quantity as mp_quantity,p.id as p_id');
                $this->db->from('meal_product mp');
                $this->db->join('product p', 'mp.product = p.id');
                $this->db->join('quantity q', 'q.product = p.id');
                $this->db->where('q.status', 'active');
                $this->db->where('mp.status', 'current');
                $this->db->where('mp.meal', $meal['id']);

                //list of products that make up a meal
                $m_products = $this->db->get()->result_array();

                if($params['disableConsumptionProducts']==='false'){
                    foreach ($m_products as $m_product) {
                        $response=$this->consumptionProducts($m_product,$meal,$quantityStep,$todayConsumption,$consumption_id,$lost,$ftp,$db_meal,$params,$response);
                    }
                }

            }

        }

        $this->consumptionPart($mealList[0]['date'][0]);
        return $response;
    }


    private function consumptionProducts($m_product,$meal,$quantityStep,$todayConsumption,$consumption_id,$lost,$ftp,$db_meal,$params,$response){

        $productsErrorList=array();
        //$m_products['product'] : produit's id
        //$m_products['quantity'] : the amount of the product in the meal
        //$meal['quantity'] : quantity of the meal
        //$m_product['unitConvert']: conversion du Kg vers gr ou mg ..

        // update reduce the amount of a product's stock after consumption the meal
        if ($m_product['totalQuantity'] > $m_product['mp_quantity'] * $m_product['unitConvert'] * $meal['quantity'] or true) {
            if ($response['status'] === "success") {
                if ($consumption_id === 0) {
                    $consumption_id = $todayConsumption['id'];
                }
                $consumption_type = "sale";
                if ($lost) {
                    $consumption_type = "lost";
                }
                $l_reponse = '';
                $needed_quantity = $m_product['mp_quantity'] * $m_product['unitConvert'] * $quantityStep;
                if($ftp){
                    $l_reponse = $this->model_product->updateLocalQuantity($m_product['product'], $needed_quantity,"down", $params["used_stock"]);
                    foreach ($l_reponse['quantities'] as $quantity) {
                        // il faut modifier ces donnée pour prendre en considération l'utilisation de plusieurs quantités
                        // l'ajout de consommation des produits doit etre fait apres la reduction de quantités produits
                        // on renvoie la liste des  produit utilisé et on les insère dans la table consomation produit
                        $consumption_product = array(
                            'quantity' => abs($quantity['quantity']),
                            'total' => abs($quantity['quantity']) * $quantity['unit_price'],
                        );

                        $this->db->where('consumption', $consumption_id);
                        $this->db->where('meal', $meal['id']);
                        $this->db->where('product', $m_product['p_id']);
                        $this->db->where('type', "sale");
                        $this->db->where('id_quantity', $quantity['id']);
                        $this->db->where('quantity>', 0);
                        $q = $this->db->get("consumption_product");

                        if ($q->num_rows() > 0) {
                            $my_quantity = $q->row_array();
                            $consumption_product["quantity"] += $my_quantity["quantity"];
                            $consumption_product["total"] += $my_quantity["total"];
                            $this->db->where('consumption', $consumption_id);
                            $this->db->where('meal', $meal['id']);
                            $this->db->where('product', $m_product['p_id']);
                            $this->db->where('type', "sale");
                            $this->db->where('id_quantity', $quantity['id']);
                            $this->db->update('consumption_product', $consumption_product);
                        } else {
                            $consumption_product["consumption"] = $consumption_id;
                            $consumption_product["meal"] = $meal['id'];
                            $consumption_product["product"] = $m_product['p_id'];
                            $consumption_product["unit_price"] = $quantity['unit_price'];
                            $consumption_product["provider"] = $quantity['provider'];
                            $consumption_product["id_quantity"] = $quantity['id'];
                            $consumption_product["type"] = $consumption_type;
                            $consumption_product["quantity"] = $consumption_product["quantity"];
                            $consumption_product["total"] = $consumption_product["total"];
                            $this->db->insert('consumption_product', $consumption_product);
                        }
                    }
                }else{

                    if ($meal['quantity'] >= $todayConsumption['quantity']) {
                        $l_reponse = $this->model_product->updateLocalQuantity($m_product['product'], $needed_quantity, "down", $params["used_stock"],$db_meal);
                        // consommation des produits selon la quantité de la fiche technique et leurs prix selon le stock
                        // l_response : liste des stock utilisé apres apdate du stock
                        foreach ($l_reponse['quantities'] as $quantity) {
                            // il faut modifier ces donnée pour prendre en considération l'utilisation de plusieurs quantités
                            // l'ajout de consommation des produits doit etre fait apres la reduction de quantités produits
                            // on renvoie la liste des  produit utilisé et on les insère dans la table consomation produit
                            $consumption_product = array(
                                'quantity' => abs($quantity['quantity']),
                                'total' => abs($quantity['quantity']) * $quantity['unit_price'],
                            );

                            $this->db->where('consumption', $consumption_id);
                            $this->db->where('meal', $meal['id']);
                            $this->db->where('product', $m_product['p_id']);
                            $this->db->where('type', "sale");
                            $this->db->where('unit_price', $quantity['unit_price']);
                            $this->db->where('quantity>', 0);
                            $q = $this->db->get("consumption_product");

                            if ($q->num_rows() > 0) {
                                $my_quantity = $q->row_array();
                                $consumption_product["quantity"] += $my_quantity["quantity"];
                                $consumption_product["total"] += $my_quantity["total"];
                                $this->db->where('consumption', $consumption_id);
                                $this->db->where('meal', $meal['id']);
                                $this->db->where('product', $m_product['p_id']);
                                $this->db->where('type', "sale");
                                $this->db->where('id_quantity', $quantity['id']);
                                $this->db->update('consumption_product', $consumption_product);
                            } else {
                                $consumption_product["consumption"]= $consumption_id;
                                $consumption_product["meal"]= $meal['id'];
                                $consumption_product["product"]= $m_product['p_id'];
                                $consumption_product["unit_price"]= $quantity['unit_price'];
                                $consumption_product["provider"]= $quantity['provider'];
                                $consumption_product["id_quantity"]= $quantity['id'];
                                $consumption_product["type"]= $consumption_type;
                                $consumption_product["quantity"]= $consumption_product["quantity"];
                                $consumption_product["total"]= $consumption_product["total"];
                                $this->db->insert('consumption_product', $consumption_product);
                            }
                        }
                    } else {

                        // retour des article ex:10artcile to 9 articles
                        $this->db->select("cp.*,cp.id as cp_id");
                        $this->db->from("consumption_product cp");
                        $this->db->join("consumption c","c.id=cp.consumption");
                        $this->db->where("c.id", $consumption_id);
                        $this->db->where("cp.product", $m_product["p_id"]);
                        $this->db->where("cp.quantity>", 0);
                        $this->db->order_by("cp.created_at", "desc");
                        $consumption_products=$this->db->get()->result_array();
                        foreach ($consumption_products as $consumption_product) {
                            if($consumption_product["quantity"]> $needed_quantity){
                                $correction = array(
                                    "quantity" => $consumption_product["quantity"] - $needed_quantity,
                                    "total" => ($consumption_product["quantity"] - $needed_quantity) * $consumption_product["unit_price"]
                                );
                                $this->db->where("id", $consumption_product["cp_id"]);
                                $this->db->update("consumption_product", $correction);


                                $this->db->where("id", $consumption_product["id_quantity"]);

                                if($params["used_stock"]==="principal"){
                                    $quantity_product = $this->db->get("quantity")->row_array();
                                    $this->db->where("id", $quantity_product["id"]);
                                    $this->db->update("quantity", array("quantity" => $quantity_product["quantity"] + $needed_quantity));
                                }else{
                                    $stock_product = $this->db->get("stock_product")->row_array();
                                    $this->db->where("id", $stock_product["id"]);
                                    $this->db->update("stock_product", array("quantity" => $stock_product["quantity"] + $needed_quantity));
                                }
                                break;
                            }else{
                                $needed_quantity-= $consumption_product["quantity"];
                                $this->db->where("id", $consumption_product["cp_id"]);
                                $this->db->update("consumption_product", array("quantity" => 0,"total"=>0));

                                if ($params["used_stock"] === "principal") {
                                    $this->db->where("id", $consumption_product["id_quantity"]);
                                    $quantity_product = $this->db->get("quantity")->row_array();
                                    $this->db->where("id", $quantity_product["id"]);
                                    $this->db->update("quantity", array("quantity" => $quantity_product["quantity"] + $consumption_product["quantity"]));
                                } else {
                                    $this->db->where("id_quantity", $consumption_product["id_quantity"]);
                                    $stock_product = $this->db->get("stock_product")->row_array();
                                    $this->db->where("id", $stock_product["id"]);
                                    $this->db->update("stock_product", array("quantity" => $stock_product["quantity"] + $consumption_product["quantity"]));
                                }
                            }
                        }
                    }
                }

            } else {
                $response['status'] = "error";
                $productsErrorList[] = $m_product;
            }
            $response['productsList'] = $productsErrorList;
        }
        return $response;
    }

    public function consumptionPart($report_date=null){
        $this->load->model('model_params');
        $params = $this->model_params->config();

        $time = date('H:i:s');
        if(!$report_date){
            $report_date = date('Y-m-d');
        }

        $this->db->select("c.*,sum(total) s_total");
        $this->db->select("c.*,sum(quantity) s_quantity");
        $this->db->from("consumption c");
        $this->db->where("report_date",$report_date);
        $todayConsumptionQuery=$this->db->get();
        $todayConsumption= $todayConsumptionQuery->row_array();
        //$todayConsumption["quantity"]>0 : pour éviter de mettre une quanité 0 dans lors de passage de cron
        if($todayConsumptionQuery->num_rows() and $todayConsumption["s_quantity"]>0){

            $this->db->where("report_date", $report_date);
            $consumption_historyQuery=$this->db->get("consumption_history");
            $consumption_history= $consumption_historyQuery->row_array();
            $dataConsumptionHistory = array(
                "quantity" => $todayConsumption["s_quantity"],
                "total" => $todayConsumption["s_total"],
            );
            $parts = number_format($params["parts"]);
            if($consumption_historyQuery->num_rows()){
                $rd_part=number_format($consumption_history["rd_part"],0);
                $nd_part=number_format($consumption_history["nd_part"],0);
                $st_part=number_format($consumption_history["st_part"],0);
                if ($rd_part === "0" and $time > $params["rd_part"] and $parts>2) {
                    $dataConsumptionHistory["rd_part"] = $todayConsumption["s_total"]- $nd_part;
                } else if ($nd_part === "0" and $time > $params["nd_part"]) {
                    $dataConsumptionHistory["nd_part"] = $todayConsumption["s_total"]- $st_part;
                } else if ($st_part === "0" and $time > $params["st_part"]) {
                    $dataConsumptionHistory["st_part"] = $todayConsumption["s_total"];
                }
                $this->db->where("report_date", $report_date);
                $this->db->update("consumption_history", $dataConsumptionHistory);
            }else{
                $dataConsumptionHistory["report_date"] = $report_date;
                if ($time > $params["rd_part"] and $parts > 2) {
                    $dataConsumptionHistory["rd_part"] = $todayConsumption["s_total"];
                } else if ($time > $params["nd_part"]) {
                    $dataConsumptionHistory["nd_part"] = $todayConsumption["s_total"];
                } else if ($time > $params["st_part"]) {
                    $dataConsumptionHistory["st_part"] = $todayConsumption["s_total"];
                }
                $this->db->insert("consumption_history", $dataConsumptionHistory);
            }
        }
    }

	public function getAll()
	{
        $this->db->select('*,meal.id as meal_id, meal.name as meal_name, g.name as g_name');
        $this->db->from('meal');
        $this->db->join('group g', 'g.id = meal.group');
        $this->db->order_by('meal_id', 'asc');
        $meals = $this->db->get()->result_array();

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

	public function recalculate($id){
        // recalculate cost and benefits only

        $this->db->where("id",$id);
        $meal=$this->db->get("meal")->row_array();

        $this->db->select('*,mp.quantity as mp_quantity,mp.unit as mp_unit');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product = p.id');
        $this->db->join('quantity q', 'q.product = p.id');
        $this->db->where('q.status', 'active');
        $this->db->where('mp.status', 'current');
        $this->db->where('mp.meal', $id);
        $products = $this->db->get()->result_array();


        $data=array(
            "cost"=>0,
        );
        foreach ($products as $product) {
            $data["cost"]+= $product["mp_quantity"]*$product["unitConvert"]*$product["unit_price"];
        }
        if(isset($meal) and $meal["sellPrice"]> $meal["cost"]){
            $data["profit"] = $meal["sellPrice"]-$data["cost"];
        }

        $this->db->where("id", $id);
        $this->db->update("meal", $data);

    }
	public function hasAtLeasOneProduct(){
        $this->db->select("*");
        $this->db->from("meal m");
        $this->db->join("meal_product mp","mp.meal=m.id");
        $this->db->where("mp.status","current");
        $this->db->group_by("m.id");
        return $this->db->get()->result_array();
    }

	//getting meals without products
	public function getAllMeals()
	{
        $meals = $this->db->get('meal')->result_array();
		return $meals;
	}
	public function getAllMealsByDepartment($department)
	{
	    $this->db->select('m.*');
	    $this->db->from('meal m');
	    $this->db->join('group g','g.id=m.group');
	    $this->db->where('g.department',$department);
        $meals = $this->db->get()->result_array();
		return $meals;
	}

	public function get($id)
	{
		$this->db->where('id', $id);
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

        // le profit d un commentaire est 0
        // le prix d un commentaire est 0
        if($profit<0 && $meal['sellPrice']==="0.00"){
            $profit=0;
        }

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

            $productCostRate=0;
            if($cost>0){
                $productCostRate = $product['mp_quantity'] * $product['unitConvert'] * $product['unit_price'] / $cost;
            }

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
    public function getMealsOnly()
    {
        return $this->db->get("meal")->result_array();
    }

    public function createUndefined($externalCode,$name="UNDEFINED"){
        $this->load->model("model_group");
        $id_group=$this->model_group->getUndefinedGroup();
        $meal= array(
            "name" => $name,
            "group" => $id_group,
            "code" => $externalCode,
            "sellPrice" => 0,
            "products_count" => 0,
        );
        return $meal;
    }
}