<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_product extends CI_Model {


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
    public function edit($product,$newQuantity=false)
    {
        $dataProduct = array(
            'name' => $product['name'],
            'unit' => $product['unit'],
            'provider' => $product['provider'],
            'status' => $product['status'],
            'min_quantity' => $product['min_quantity'],
            'daily_quantity' => $product['daily_quantity']
        );
        $this->db->where('id', $product['id']);
        $this->db->update('product', $dataProduct);

        if($newQuantity){
            $dataQuantity = array(
                'product' => $product['id'],
                'quantity' => $product['quantity'],
                'unit_price' => $product['unit_price']
            );
            $this->db->insert('quantity', $dataQuantity);
            $this->updateQuantity($product['id'], $product['quantity'],'up');
        }else{

            $this->updateLocalQuantity($product['id'], $product['quantity'], 'up');//product table
            $this->updateQuantity($product['id'], $product['quantity'], 'up');//quantity table
        }
        if ($product['lostQuantity'] > 0) {
            $this->updateLocalQuantity($product['id'], $product['lostQuantity']);//product table
            $this->updateQuantity($product['id'], $product['lostQuantity']);// quantity table
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

    public function addProducts($productsList)
    {
        foreach ($productsList as $product) {
            $data = array(
                'name' => $product['name'],
                'provider' => $product['provider'],
                'totalQuantity' => $product['quantity'],
                'unit' => $product['unit'],
                'status' => $product['status'],
                'min_quantity' => $product['min_quantity'],
                'daily_quantity' => $product['daily_quantity']
            );
            $this->db->insert('product', $data);
            $productItem= $insert_id = $this->db->insert_id();
            $dataQuantity=array(
                'unit_price' => $product['unit_price'],
                'quantity' => $product['quantity'],
                'product'=>$productItem,
                'status'=>'active',
            );
            $this->addQuantity($dataQuantity);

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

    public function updateLocalQuantity($product,$quantity,$direction="down")
	{
        $response = array();
        $response['status']="success";

        //produit local de la base de donnée
        $l_product = $this->getById($product);

        //liste des quantités du produits
        $quantities = $this->getQuantities($product);
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
                break;
            } else {
                // Si la quantité en cours n'est pas suffisante, on la met a 0 et on change son status.
                $data = array(
                    'quantity' => 0,
                    'status' => 'sold_out'
                );
                $quantity -= $quantityItem['quantity'];
                $this->db->where('product', $quantityItem['product']);
                $this->db->where('id', $quantityItem['id']);
                $this->db->update('quantity', $data);
            }
        }

        return $response;
    }

	public function updateQuantities($productsList, $direction="down"){
        foreach ($productsList as $product) {
            $this->updateQuantity($product['id'], $product['quantity'], $direction);
            $this->updateLocalQuantity($product['id'], $product['quantity'], $direction);
        }
    }

	public function getAll()
	{
	    $this->db->select('*,q.id as q_id,p.id as id');
	    $this->db->from('product p');
	    $this->db->join('quantity q','q.product=p.id');
	    $this->db->where("q.status","active");
	    $this->db->where("p.status","active");
		$result = $this->db->get();
		return $result->result_array();
	}

	public function getQuantities($product)
	{
	    $this->db->where("product",$product);
	    $this->db->order_by("status","ASC");
		$result = $this->db->get('quantity');
		return $result->result_array();
	}
	public function getToOrder()
	{
        $this->db->select('*,q.id as q_id,p.id as id');
        $this->db->from('product p');
        $this->db->join('quantity q', 'p.id=q.product');
        $this->db->where('q.status', 'active');
        $this->db->where('p.status', 'active');
        $this->db->where('p.min_quantity > q.quantity');
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
        $this->db->where('min_quantity > q.quantity');
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


	public function delete($id)
	{
        $data = array(
            'status' => "deleted",
        );
		$this->db->where('id', $id);
		$this->db->update('product',$data);
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
}