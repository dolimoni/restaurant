<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_product extends CI_Model {

    private $current_db=0;

	public function addQuantity($quantity)
	{

        $this->db->insert('quantity', $quantity);
       /* $this->db->where("id", $quantity_id);
		$this->db->get('quantity')->row_array();*/
	}

	public function updateActiveQuantity($quantity_id,$data)
	{
        $this->db->where("id", $quantity_id);
		$this->db->update('quantity',$data);

	}


	// renvoyer un produit dans une agence par l id du produit principal
    public function getProductByMasterId($id)
    {
        $this->db->where("id_master", $id);
        return $this->db->get("product")->row_array();
    }
	public function getQuantity($quantity_id)
	{
        $this->db->where("id", $quantity_id);
		return $this->db->get('quantity')->row_array();
	}
	public function getActiveQuantityByProduct($product)
	{
        $this->db->where("product",$product);
        $this->db->where("status", 'active');
		return $this->db->get('quantity')->row_array();
	}

	public function getQuantitiesByDepartement($id)
	{
	    $this->db->select('sp.quantity, d.name');
	    $this->db->from('stock_product sp');
	    $this->db->join('department d','d.id=sp.department');
        $this->db->where("product",$id);
        $this->db->where("quantity>",0);
        $this->db->order_by("sp.id","DESC");
		$department =  $this->db->get()->result_array();

		return $department;
	}
	public function add($product)
	{
		$data = array(
			   'name' => $product['name'],
               'quantity' => $product['quantity'],
               'unit' => $product['unit'],
               'unit_price' => $product['unit_price']
            );
		$this->db->insert('product', $data);
	}

	public function addComposition($compostion,$newQuantity=false)
	{
	    // update product if exist
        $newProduct=false;
        if(isset($compostion['id'])){
            $newProduct=true;
        }
	    if($newProduct){
            $dataProduct = array(
                'name' => $compostion['name'],
                'unit' => $compostion['unit'],
            );
            $this->db->where('id', $compostion['id']);
            $this->db->update('product', $dataProduct);

            // if this is a new quantity => price1!=price2 or provider1!=provicer2
            if ($newQuantity) {
                $dataQuantity = array(
                    'product' => $compostion['id'],
                    'quantity' => $compostion['quantity'],
                    'unit_price' => $compostion['unit_price'],
                    "provider"=>0
                );
                $this->accumulateQuantity($dataQuantity);
            }
        }


	    // if update !
	    if($newProduct){

	        // delete existing product and they will be changed by new products
	        $this->db->where('owner', $compostion['id']);
	        $this->db->delete('product_composition');
        }else{
	        // if this new a new create product
            $data = array(
                'name' => $compostion['name'],
                'totalQuantity' => $compostion['quantity'],
                'unit' => $compostion['unit'],
                'type' => 'composition'
            );

            $this->db->insert('product', $data);

            $product_id = $this->db->insert_id();
            $compostion['id'] = $product_id;
            $dataQuantity = array(
                'product' => $compostion['id'],
                'quantity' => $compostion['quantity'],
                'unit_price' => $compostion['cost'],
                'status' => 'active'
            );
            $this->addQuantity($dataQuantity);
        }


        // create and update products quantity
        foreach ($compostion['productsList'] as $product) {

            $dataCreate = array(
                'product' => $product['id'],
                'quantity' => $product['quantity'],
                'unit' => $product['unit'],
                'unitConvert' => $product['unitConvert'],
                'owner' => $compostion['id'],
                'status' => 'current'
            );

            $this->db->insert('product_composition', $dataCreate);

            $this->updateLocalQuantity($product['id'], $product['quantity']* $product['unitConvert']* $compostion['quantity']);
            $this->updateQuantity($product['id'], $product['quantity']* $product['unitConvert']* $compostion['quantity']);

        }

        if($newProduct){
            if (!$newQuantity ){
                $this->updateLocalQuantity($compostion['id'], $compostion['quantity'], 'up');
            }
             $this->updateQuantity($compostion['id'], $compostion['quantity'], 'up');
        }


	}
    public function edit($product,$newQuantity=false)
    {
        $dataProduct = array(
            'name' => $product['name'],
            'unit' => $product['unit'],
            'weightByUnit' => $product['weightByUnit'],
            'status' => $product['status'],
            'min_quantity' => $product['min_quantity'],
            'daily_quantity' => $product['daily_quantity']
        );
        $this->db->where('id', $product['id']);
        $this->db->update('product', $dataProduct);

        $stock = $this->getActiveStock($product['id']);

        // si changement simple de fournisseur sans donner la quantité
       /* if($product['quantity']==="" && $stock["provider"]!== $product['provider']){
            $this->db->where('provider', $product['provider']);
            $l_quantity=$this->db->get('quantity')->row_array();

            $this->db->where('id', $stock['id']);
            $this->db->update('quantity', array("status" => "stock"));

            $this->db->where('id', $l_quantity['id']);
            $this->db->update('quantity', array("status" => "active"));
        }*/

        if ($newQuantity && $product['newUserQuantity'] == "true") {
            $dataQuantity = array(
                'product' => $product['id'],
                'quantity' => $product['quantity'],
                'unit_price' => $product['unit_price'],
                'provider' => $product['provider']
            );
           /* if ($stock['quantity'] <= 0) {
                $dataQuantity['status'] = 'active';
                $this->updateActiveQuantity($stock['id'], array('status' => 'sold_out'));
            }*/
            $this->accumulateQuantity($dataQuantity);

            /* $this->updateQuantity($product['id'], $product['quantity'],'up');*/

        }else{
                $dataQuantity = array(
                    'unit_price' => $product['unit_price'],
                    'provider' => $product['provider']
                );
                if ($product['newUserQuantity'] == "false") {
                    $this->db->where("product", $product['id']);
                    $this->db->where("status", "active");
                    $this->db->update("quantity", $dataQuantity);
                }
               /* $this->updateLocalQuantity($product['id'], $product['quantity'], 'up');//product table
                $this->updateQuantity($product['id'], $product['quantity'], 'up');//quantity table*/
        }

        if($product['quantity']>0){
            $productHistory = array(
                'id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['unit_price'],
                'unit' => $product['unit'],
                'provider' => $product['provider'],
            );
            $this->addStockHistory($productHistory, 'in');
        }
        if ($product['lostQuantity'] > 0) {
            $this->updateLocalQuantity($product['id'], $product['lostQuantity']);//product table
            $this->updateQuantity($product['id'], $product['lostQuantity']);// quantity table
        }

        $this->updateMealsCostByProduct($product['id']);

    }

    public function updateMealsCostByProduct($product_id){
        $this->load->model('model_meal');
        $meals = $this->getMealsByProduct($product_id);
        foreach ($meals as $meal) {
            $this->model_meal->recalculate($meal["meal"]);
        }
    }
    public function apiEditForProvider($product,$newQuantity=false)
    {
        $dataProduct = array(
            'name' => $product['name'],
        );
        $this->db->where('id', $product['id']);
        $this->db->update('product', $dataProduct);

        if($newQuantity){
            $dataQuantity = array(
                'product' => $product['id'],
                'quantity' => 0,
                'unit_price' => $product['unit_price']
            );
            $this->db->insert('quantity', $dataQuantity);
        }
    }
    public function getActiveStock($id){
        $this->db->where('product', $id);
        $this->db->where('status', 'active');
        return $this->db->get('quantity')->row_array();
    }
    public function addProducts($productsList, $inserted_products_data=null,$database="local")
    {
        $inserted_products=array();
        foreach ($productsList as $key => $product) {
            $data = array(
                'name' => $product['name'],
                'totalQuantity' => $product['quantity'],
                'unit' => $product['unit'],
                'weightByUnit' => $product['weightByUnit'],
                'status' => $product['status'],
                'min_quantity' => $product['min_quantity'],
                'daily_quantity' => $product['daily_quantity'],
            );
            if($database==="remote"){
                $data["id_master"]= $inserted_products_data[$key];
                $this->load->model('model_provider');
                $slaveProvider = $this->model_provider->getProviderByMasterId($product["provider"]);
                if ($slaveProvider == NULL) {
                    $product['provider'] = 0;
                }else{
                    $product['provider']= $slaveProvider["id"];
                }
            }
            $this->db->insert('product', $data);
            $productItem= $insert_id = $this->db->insert_id();
            $inserted_products[]= $productItem;
            $dataQuantity=array(
                'unit_price' => $product['unit_price'],
                'quantity' => $product['quantity'],
                'product'=>$productItem,
                "provider"=> $product['provider'],
                'status'=>'active',
            );
            $this->addQuantity($dataQuantity);

            $productHistory=array(
                'id'=> $productItem,
                'quantity'=> $product['quantity'],
                'price'=> $product['unit_price'],
                'unit'=> $product['unit'],
                'provider'=> $product['provider'],
            );
            if($productHistory["quantity"]>0){
                $this->addStockHistory($productHistory, 'in');
            }
        }
        return $inserted_products;
    }

    public function addInventory($productsList)
    {
        foreach ($productsList as $product) {
            $this->db->where("product",$product["product"]);
            $this->db->where("inventory_date",date("Y-m-d"));
            $inventory=$this->db->get("inventory")->row_array();
            $quantity=$this->getActiveQuantityByProduct($product["product"]);
            $delta= $product["delta"];

            if($inventory){
                $this->db->where("product", $product["product"]);
                $this->db->where("inventory_date", date("Y-m-d"));
                $delta= $product["final_stock"] - $inventory["initial_stock"];
                $dataInventory=array(
                    "final_stock"=> $product["final_stock"],
                    "delta"=> $delta,
                );
                $this->db->update("inventory", $dataInventory);
                // la nouvelle quantity de stock est le stock courant + delta
                $dataQuantity = array(
                    "quantity" => $inventory["activeStockQuantity"] + $delta
                );
                $this->db->where("id", $quantity["id"]);
                $this->db->update("quantity", $dataQuantity);

                $this->db->where("id", $product["product"]);
                $this->db->update("product", array("totalQuantity" => $product["final_stock"]));

            }else{
                $product["quantity"]= $quantity["id"];
                $product["activeStockQuantity"]= $quantity["quantity"];
                $this->db->insert("inventory",$product);

                $dataQuantity = array(
                    "quantity" => $quantity["quantity"] + $delta
                );
                $this->db->where("id", $quantity["id"]);
                $this->db->update("quantity", $dataQuantity);

                $this->db->where("id", $product["product"]);
                $this->db->update("product", array("totalQuantity" => $product["final_stock"]));

            }

        }

    }

	public function updateQuantity($product,$quantity,$direction="down")
	{

        $l_product = $this->getById($product);


        $l_quantity = $l_product['totalQuantity'] - $quantity;

        if ($direction === "up") {
            $l_quantity = $l_product['totalQuantity'] + $quantity;
        }


        $data = array(
            'totalQuantity' => $l_quantity,
        );

        $this->db->where('id', $product);
        $this->db->update('product', $data);
    }

    //$product : id
    public function updateLocalQuantity($product,$quantity,$direction="down", $used_stock="principal",$meal=null)
	{
        $response = array();
        $response['status']="success";
        $response['quantities']=array();

        if($used_stock==="principal"){
            //produit local de la base de donnée
            $l_product = $this->getById($product);

            //liste des quantités du produits

            $sql = "SELECT * FROM quantity
               WHERE product = ? AND status!='sold_out'
               ORDER BY FIELD(status,'active','stock') ASC";
            $dbResult = $this->db->query($sql, $product);
            $quantities = $dbResult->result_array();

            $l_quantity = 0;

            foreach ($quantities as $quantityItem) {
                //quantité restante de la quantité en cours, la quantité en cours est le premier element du tableau $quantities
                $l_quantity = $quantityItem['quantity'] - $quantity;

                if ($direction === "up") {
                    $l_quantity = $quantityItem['quantity'] + $quantity;
                }

                //Si la quantité courante est suffisante on se contente de la mettre a jour et on arrête la boucle
                //Si on arrive a la 2eme eteration, on change le status de la quantité depuis stock à active


                if ($l_quantity > 0) {
                    $data = array(
                        'quantity' => $l_quantity,
                        'status' => 'active',
                    );
                    $this->db->where('product', $quantityItem['product']);
                    $this->db->where('id', $quantityItem['id']);
                    $this->db->update('quantity', $data);

                    $usedQuantity['id'] = $quantityItem['id'];
                    $usedQuantity['quantity'] = $quantity;
                    $usedQuantity['unit_price'] = $quantityItem['unit_price'];
                    $usedQuantity['provider'] = $quantityItem['provider'];
                    $usedQuantity['total'] = $quantity * $quantityItem['unit_price'];

                    $response['quantities'][] = $usedQuantity;
                    break;
                } else {
                    // Si la quantité en cours n'est pas suffisante, on la met a 0 et on change son status.
                    $data = array();
                    // seul la dernière quantité qui peut toujours avoir le status active et la quantité peut
                    // etre < 0
                    if ($direction === "down" and $quantityItem === end($quantities)) {
                        $data['status'] = 'active';
                        $data['quantity'] = $l_quantity;
                        $usedQuantity['quantity'] = $quantity;
                    } else if ($direction === "down" and $quantityItem !== end($quantities)) {
                        $data['status'] = 'stock';
                        $data['quantity'] = 0;
                        $usedQuantity['quantity'] = $quantityItem['quantity'];
                    } else if ($direction === "up") {
                        $data['status'] = 'active';
                        $data['quantity'] = $l_quantity;
                        $usedQuantity['quantity'] = $quantity;
                    }

                    $usedQuantity['unit_price'] = $quantityItem['unit_price'];
                    $usedQuantity['total'] = $l_quantity * $quantityItem['unit_price'];
                    $usedQuantity['provider'] = $quantityItem['provider'];
                    $usedQuantity['id'] = $quantityItem['id'];
                    $response['quantities'][] = $usedQuantity;

                    $quantity -= $quantityItem['quantity']; // IMPORTANT
                    $this->db->where('product', $quantityItem['product']);
                    $this->db->where('id', $quantityItem['id']);
                    $this->db->update('quantity', $data);
                }
            }
        }else{
            //produit local de la base de donnée
            $l_product = $this->getById($product);
            $this->db->where("id",$meal["group"]);
            $department=$this->db->get("group")->row("department");
            //liste des quantités du produits

            $sql = "SELECT sum(quantity) as quantity FROM stock_product
               WHERE product = ? AND department = ? AND quantity>0";
            $dbResult = $this->db->query($sql, array($product,$department));
            $totalStockQuantity = $dbResult->row(1);


            if($quantity>$totalStockQuantity->quantity){
                $needed_quanity= $quantity- $totalStockQuantity->quantity;
                $this->load->model('model_agency');
                $l_response = $this->updateLocalQuantity($product, $needed_quanity);
                $this->model_agency->addLocalStockProduct($l_response["quantities"], $product, $department,"automatic");
            }
            $sql = "SELECT * FROM stock_product
               WHERE product = ? AND department = ? AND quantity>0
               ORDER BY id ASC";
            $dbResult = $this->db->query($sql, array($product, $department));
            $quantities = $dbResult->result_array();

            $l_quantity = 0;

            foreach ($quantities as $quantityItem) {
                //quantité restante de la quantité en cours, la quantité en cours est le premier element du tableau $quantities
                $l_quantity = $quantityItem['quantity'] - $quantity;

                if ($direction === "up") {
                    $l_quantity = $quantityItem['quantity'] + $quantity;
                }

                //Si la quantité courante est suffisante on se contente de la mettre a jour et on arrête la boucle
                //Si on arrive a la 2eme eteration, on change le status de la quantité depuis stock à active


                if ($l_quantity > 0) {
                    $data = array(
                        'quantity' => $l_quantity,
                    );
                    $this->db->where('id', $quantityItem['id']);
                    $this->db->update('stock_product', $data);

                    $usedQuantity['quantity'] = $quantity;
                    $usedQuantity['unit_price'] = $quantityItem['unit_price'];
                    $usedQuantity['provider'] = $quantityItem['provider'];
                    $usedQuantity['id'] = $quantityItem['id'];
                    $usedQuantity['total'] = $quantity * $quantityItem['unit_price'];

                    $response['quantities'][] = $usedQuantity;
                    break;
                } else {
                    $data = array();

                    $data['quantity'] = 0;
                    $usedQuantity['quantity'] = $quantityItem['quantity'];

                    $usedQuantity['unit_price'] = $quantityItem['unit_price'];
                    $usedQuantity['total'] = $l_quantity * $quantityItem['unit_price'];
                    $usedQuantity['provider'] = $quantityItem['provider'];
                    $usedQuantity['id'] = $quantityItem['id'];
                    $response['quantities'][] = $usedQuantity;

                    $quantity -= $quantityItem['quantity']; // IMPORTANT
                    $this->db->where('id', $quantityItem['id']);
                    $this->db->update('stock_product', $data);
                }
            }
        }
        return $response;
    }

    //$oder_id: id de la commande
	public function updateQuantities($productsList, $direction="down", $provider_id,$order_id=null){
        foreach ($productsList as $product) {
            $this->updateQuantity($product['id'], $product['quantity'], $direction);

            if($direction==="up"){
                $db_product = $this->getById($product['id']);
                $productHistory = array(
                    'id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['unit_price'],
                    'unit' => $product['unit'],
                    'provider' => $provider_id,
                    'order_id' => $order_id,
                );
                $this->addStockHistory($productHistory, 'in');
                $this->newQuantity($product['id'], $product['quantity'], $provider_id,$product["idQuantity"]);
            }

        }


    }

    public function newQuantity($id,$quantity,$provider_id,$idQuantity){
	    $this->db->select('*');
	    $this->db->from('quantity');
	    $this->db->where("id", $idQuantity);
	    $result = $this->db->get()->row_array();

	    $l_quantity=$result["quantity"]+$quantity;
	    $this->db->where("id", $idQuantity);
	    $this->db->update("quantity",array("quantity"=>$l_quantity));

    }

	public function getAll($meals=false,$composition=false)
	{

	    $products = $this->db->get("product")->result_array();
        foreach ($products as $product) {
            $quantities = $this->model_product->getAllQuantities($product['id']);
            $totalQuantity = array_sum(array_column($quantities, 'quantity'));
            $data = array(
                'totalQuantity' => $totalQuantity
            );
            $sittingMoney=0;
            foreach ($quantities as $quantity) {
                $sittingMoney+= $quantity["unit_price"]*$quantity["quantity"];
            }
            $data["sitting_money"]= $sittingMoney;
            $this->model_product->update($product['id'], $data);
        }
	    $this->db->select('*,q.id as q_id,p.id as id');
	    $this->db->select('sum(q.quantity)');
	    $this->db->from('product p');
	    $this->db->join('quantity q','q.product=p.id');
	    $this->db->where("q.status","active");
	    $this->db->where("p.status","active");
        if ($composition === false) {
            $this->db->where("p.type", "product");
        }
        $this->db->order_by("p.id");
        $this->db->group_by("p.id");
		$result = $this->db->get()->result_array();

		if($meals){
            foreach ($result as $key => $item) {
                $result[$key]['meals']= $this->getMealsByProduct($item['id']);
		    }
        }
        return $result;
	}

    public function getSittingMoney()
    {
        $this->db->select("sum(sitting_money) as sitting_money");
        return $this->db->get("product")->row("sitting_money");
    }

	public function getMealsByProduct($id){
        $this->db->select('mp.*,m.name,mp.unit as mp_unit');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product=p.id');
        $this->db->join('meal m', 'mp.meal=m.id');
        $this->db->where("p.id", $id);
        $this->db->where("mp.status", 'current');
        $this->db->group_by("mp.meal");
        $meals = $this->db->get()->result_array();
        return $meals;
    }

	public function getCompositions($meals=false)
	{
	    $this->db->select('p.id,p.min_quantity,p.totalQuantity,q.product,p.name,p.unit,q.quantity,q.unit_price');
	    $this->db->select('sum(pc.quantity*pc.unitConvert*q.unit_price) as price');
	    $this->db->from('product p');
        $this->db->join('product_composition pc', 'pc.owner=p.id', 'left');
        $this->db->join('quantity q', 'p.id=q.product', 'left');
	    $this->db->where("q.status","active");
	    $this->db->where("p.status","active");
	    $this->db->where("type","composition");
	    $this->db->group_by("p.id");
		$result = $this->db->get()->result_array();

		if($meals){
            foreach ($result as $key => $item) {
                $this->db->select('mp.*,m.name,mp.unit as mp_unit');
                $this->db->from('meal_product mp');
                $this->db->join('product p', 'mp.product=p.id');
                $this->db->join('meal m', 'mp.meal=m.id');
                $this->db->where("mp.product", $item['id']);
                $this->db->where("mp.status",'current');
                $this->db->group_by("mp.meal");
                $meals = $this->db->get()->result_array();
                $result[$key]['meals']= $meals;
		    }
        }
        return $result;
	}

	public function getComposition($id)
	{
	    $this->db->select('p.id,p.name,p.unit,q.quantity,q.unit_price');
	    $this->db->from('product p');
	    $this->db->join('quantity q','q.product=p.id');
	    $this->db->where("p.status","active");
	    $this->db->where("q.status","active");
	    $this->db->where("type","composition");
	    $this->db->where("p.id",$id);
		$result['composition'] = $this->db->get()->row_array();

		$this->db->select('p.id,pc.owner,pc.product,pc.quantity,pc.unitConvert,pc.unit unitConvertName,p.name,p.unit');
	    $this->db->from('product_composition pc');
        $this->db->join('product p', 'pc.product=p.id');
        $this->db->join('quantity q', 'pc.owner=q.product');
	    $this->db->where("p.status","active");
	    $this->db->where("q.status","active");
	    //$this->db->where("p.type","composition");
	    $this->db->where("pc.owner",$id);
		$result['products'] = $this->db->get()->result_array();

        return $result;
	}

	public function getAllQuantities($product)
	{
	    $this->db->where("product",$product);
		$result = $this->db->get('quantity');
		return $result->result_array();
	}
	public function getQuantities($product)
	{
	    $this->db->where("product",$product);
	    $this->db->where("status = 'stock' or status = 'active'");
	    $this->db->order_by("status,id","ASC");
		return $result->result_array();
	}

	public function getQuantitiesToShow($product)
	{
	    $sql= "SELECT quantity.*,pv.name as pv_name,pv.id as pv_id FROM quantity left join provider pv on pv.id=quantity.provider 
               WHERE 
               product = ?
               order by FIELD(status,'active','stock','sold_out') ASC";
        $dbResult = $this->db->query($sql, $product);

		return $dbResult->result_array();
	}

	public function getToOrder()
	{
        $this->db->select('*,q.id as q_id,p.id as id');
        $this->db->from('product p');
        $this->db->join('quantity q', 'p.id=q.product');
        $this->db->where('q.status', 'active');
        $this->db->where('p.status', 'active');
        $this->db->where('p.min_quantity > p.totalQuantity');
		$result = $this->db->get();
		return $result->result_array();
	}
	public function getToOrderFromProvider($id)
	{
        $this->db->select('*,q.id as q_id,p.id as id');
        $this->db->from('product p');
        $this->db->join('quantity q', 'p.id=q.product');
        $this->db->where('q.status', 'active');
        $this->db->where('p.status', 'active');
        $this->db->where('min_quantity > p.totalQuantity');
        $this->db->where('provider',$id);
		$result = $this->db->get();
		return $result->result_array();
	}

    public function getById($id)
    {
        $this->db->select('*,q.id as q_id,p.id as id');
        $this->db->from('product p');
        $this->db->join('quantity q' ,'p.id=q.product');
        $this->db->where('q.status' ,'active');
        $this->db->where('p.status' ,'active');
        $this->db->where('p.id', $id);
        $result = $this->db->get();
        return $result->row_array();
    }

	public function get($id)
	{
		$this->db->where('externalCode', $id);
		$result = $this->db->get('product');
		return $result->row_array();
	}
	public function getByProvider($product, $provider)
	{
		$this->db->select('*');
		$this->db->from('product p');
        $this->db->join('quantity q', 'p.id=q.product');
        $this->db->where('q.status', 'active');
		$this->db->where('p.id', $product);
		$this->db->where('provider', $provider);
		$result = $this->db->get();
		return $result->row_array();
	}

	public function getProductInventory($id, $startDate=null, $endDate=null){
        $this->db->select('*');
        $this->db->from('inventory');
        $this->db->where('product', $id);
        if ($startDate) {
            $this->db->where('inventory_date >=', $startDate);
            $this->db->where('inventory_date <=', $endDate);
        }
        $this->db->order_by("inventory_date","asc");
        $this->db->limit(30);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function getInventory($startDate = null, $endDate = null){
        $this->db->select('i.*,p.name,p.totalQuantity');
        $this->db->from('inventory i');
        $this->db->join('product p',"p.id=i.product");
        if ($startDate) {
            $this->db->where('inventory_date >=', $startDate);
            $this->db->where('inventory_date <=', $endDate);
        }
        $this->db->order_by("inventory_date", "desc");
        $result = $this->db->get();
        return $result->result_array();
    }


	public function canBeDeleted($id)
	{

		$this->db->where('product', $id);
		$this->db->where('status', 'current');
		$result = $this->db->get('meal_product')->result_array();
		return count($result)===0;
	}

    public function delete($id)
    {
        $data = array(
            'status' => "deleted",
        );
        $this->db->where('id', $id);
        $this->db->update('product',$data);
    }

    public function update($id,$data)
    {

        $this->db->where('id', $id);
        $this->db->update('product',$data);
    }

    public function getProviders($productName){
        $this->db->distinct();
	    $this->db->select('pv.name');
	    $this->db->from('provider pv');
	    $this->db->join('quantity q','q.provider=pv.id');
	    $this->db->join('product p','q.product=p.id');
	    $this->db->where('p.name',$productName);
	    //$this->db->where('q.status',"active");
	    return $this->db->get()->result_array();
    }

	public function defaultProduct(){
	    $product=array('name'=>'produit1');
	    return $product;
    }
    public function nullProduct(){
	    $product=array(
	        'name'=>'NULL', 'id' => 'NULL'
        );
	    return $product;
    }

    public function addStockHistory($product, $type, $department = null)
    {
        if(!isset($product['order_id'])){
            $product['order_id']=0;
        }
        $data = array(
            'product' => $product['id'],
            'quantity' => $product['quantity'],
            'unit' => $product['unit'],
            'type' => $type,
            'unit_price' => $product['price'],
            'total' => $product['price']*$product['quantity'],
            'provider' => $product['provider'],
            'order_id' => $product['order_id'],
        );
        $this->db->insert('stock_history', $data);
    }

    public function getInStockHistory()
    {
        $this->db->select('sh.id as sh_id,p.id as p_id, p.name,sh.quantity,sh.total,sh.unit,pv.name as pv_name,sh.created_at');
        $this->db->from('stock_history sh');
        $this->db->join('product p','p.id=sh.product','lef');
        $this->db->join('provider pv','pv.id=sh.provider','left');
        $this->db->where('sh.type','in');
        $this->db->order_by('sh.created_at',"DESC");
        $stockHistory= $this->db->get()->result_array();
        return $stockHistory;
    }

    public function controlQuantity(){
        $this->db->where('quantity<',0);
        $this->db->update('quantity', array("status"=>"sold_out"));
    }

    public function accumulateQuantity($quantityData){

        $this->db->where('product', $quantityData['product']);
        $this->db->where('unit_price', $quantityData['unit_price']);
        $this->db->where('provider', $quantityData['provider']);
        $db_quantity = $this->db->get('quantity')->row_array();
        if($db_quantity){
            $quantityData['quantity']+= $db_quantity['quantity'];
            if($quantityData['quantity']>0 && $db_quantity['status']!=="active"){
                $quantityData["status"]="stock";
            }
            $this->db->where('product', $quantityData['product']);
            $this->db->where('unit_price', $quantityData['unit_price']);
            $this->db->where('provider', $quantityData['provider']);
            $this->db->update('quantity', $quantityData);
        }else{
            $this->db->insert('quantity', $quantityData);
        }
    }

    public function autoConsum(){
        $this->db->where("daily_quantity>",0);
        $products=$this->db->get("product")->result_array();
        foreach ($products as $product) {
            $this->updateQuantity($product["id"],$product["daily_quantity"]);
            $this->updateLocalQuantity($product["id"], $product["daily_quantity"]);
            $dataAutoconsum=array(
                "product"=> $product["id"],
                "quantity"=> $product["daily_quantity"],
            );
            $this->db->insert("product_autoconsum", $dataAutoconsum);
        }

    }

    /**
     * @return int
     */
    public function getCurrentDb()
    {
        return $this->current_db;
    }

    /**
     * @param int $current_db
     */
    public function setCurrentDb($current_db)
    {
        $this->current_db = $current_db;
        if($this->current_db===0){
            $this->db=$this->load->database('default', TRUE);
        }else{
            $this->db = $this->load->database('remote_' . $current_db, TRUE);
        }
    }




}