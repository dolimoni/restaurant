<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_order extends CI_Model {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_quotation');
    }

	public function add($order)
	{

        $data = array(
            'provider' => $order['provider']['id'],
            'tva' => $order['tva'],
            'ttc' => $order['underTotal']*(1+$order['tva']/100),
        );

        $this->db->insert('order', $data);
        $orderId = $this->db->insert_id();
        foreach ($order['productsList'] as $product) {
            $data = array(
                'product' => $product['id'],
                'order_id' => $orderId,
                'quantity' => $product['quantity'],
                'od_price' => $product['unit_price'],
                'quantity_id' => $product['idQuantity'],
            );
            $this->db->insert('orderdetails', $data);
        }
	}

	public function update($order)
	{

        $data = array(
            'status' => $order['status'],
            'tva' => $order['tva'],
            'ttc' => $order['underTotal'] * (1 + $order['tva']/100),
        );

        $this->db->where("id",$order['id']);
        $this->db->update("order",$data);
        if(isset($order['productsList'])){
            foreach ($order['productsList'] as $product) {
                $this->db->where('order_id', $order['id']);
                $this->db->where('product', $product['id']);
                $this->db->where('quantity_id', $product['idQuantity']);
                $r = $this->db->get('orderdetails');

                if ($r->num_rows() > 0) {
                    $data = array(
                        'quantity' => $product['quantity'],
                        'od_price' => $product['unit_price'],
                    );
                    $this->db->where('order_id', $order['id']);
                    $this->db->where('product', $product['id']);
                    $this->db->where('quantity_id', $product['idQuantity']);
                    $this->db->update('orderdetails', $data);

                } else {
                    $data = array(
                        'quantity' => $product['quantity'],
                        'od_price' => $product['unit_price'],
                        'product' => $product['id'],
                        'quantity_id' => $product['idQuantity'],
                        'order_id' => $order['id']
                    );
                    $this->db->insert('orderdetails', $data);
                }
            }
            $data = array(
                'quantity' => 0,
            );

            // mettre la quantité a 0 pour tous les produits deja commandé et non envoyé dans la modification
            $ids = array_column($order['productsList'],'id');
            $this->db->where_not_in('product', $ids);
            $this->db->where('order_id', $order['id']);
            $this->db->update('orderdetails', $data);
        // Si toute les quantité envoyé = 0 => $order['productsList'] cette variable n'existe pas
        // On met a 0 alors toutes les quantitées de la commande.
        }else{
            $data = array(
                'quantity' => 0,
            );
            $this->db->where('order_id', $order['id']);
            $this->db->update('orderdetails', $data);
        }

        return $this->db->affected_rows();
	}
    public function addProducts($productsList, $quotation=null)
	{
	    foreach ($productsList as $product){
            $data = array(
                'name' => $product['name'],
                'unit_price' => $product['price'],
                'provider' => $product['provider'],
                'quotation' => $quotation['id'],
                'status' => $product['status']
            );
            $this->db->insert('product', $data);
        }

	}
	public function addProduct($product, $quotation=null)
	{
        $data = array(
            'name' => $product['name'],
            'unit_price' => $product['price'],
            'provider' => $product['provider'],
            'quotation' => $quotation['id'],
            'status' => $product['status']
        );
        $this->db->insert('product', $data);

	}

    public function updateProducts($productsList, $quotation = null)
    {
        foreach ($productsList as $product) {
            if(!$product['id']){
                $this->addProduct($product, $quotation);
            }else{
                $data = array(
                    'name' => $product['name'],
                    'unit_price' => $product['price'],
                    'provider' => $product['provider'],
                    'quotation' => $quotation['id'],
                    'status' => $product['status']
                );
                $this->db->where('id', $product['id']);
                $this->db->update('product', $data);
            }
        }
        if($quotation){
            $this->model_quotation->update($quotation);
        }

    }
	public function addQuotation($quotation)
	{
        $data = array(
            'provider' => $quotation['provider'],
            'number' => $quotation['number'],
            'reception_date' => $quotation['reception_date'],
        );

        $this->db->insert('quotation', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;

	}

	public function getAll()
	{
		$result = $this->db->get('provider');
		return $result->result_array();
	}
	public function getAllActive()
	{
        $this->db->where('status', "active");
		$result = $this->db->get('provider');
		return $result->result_array();
	}

    public function get($id, $fetch = 'LAZY')
    {
        if ($fetch === "LAZY") {
            $this->db->select('o.*');
            $this->db->from('order o');
            $this->db->join('quantity q',"q.id=o.quantity_id");
            $this->db->where('id', $id);
            return $result->row_array();
        } else {

            $this->db->select('*,o.id as o_id,o.status as o_status');
            $this->db->from('order o');
            $this->db->where('o.id', $id);
            $order = $this->db->get()->row_array();

            $this->db->select('od.*, p.*,od.quantity as od_quatity,q.id as idQuantity');
            $this->db->from('order o');
            $this->db->join('orderdetails od', 'od.order_id = o.id');
            $this->db->join('product p', 'p.id = od.product');
            $this->db->join('quantity q', "q.id=od.quantity_id");
            $this->db->where('o.id', $id);
            $order['productsList'] = $this->db->get()->result_array();
            return $order;
        }


    }

	public function getProducts($id,$status="active")
	{
		$this->db->where('provider', $id);
		$this->db->where('status', $status);
		$result = $this->db->get('product');
		return $result->result_array();
	}
	public function getQuotations($id)
	{
		$this->db->where('provider', $id);
		$result = $this->db->get('quotation');
		return $result->result_array();
	}



	public function delete($order_id)
	{
	    $this->db->select("q.id as q_id,p.id as p_id,q.quantity,od.quantity as od_quantity,totalQuantity");
	    $this->db->from("order o");
	    $this->db->join("orderdetails od","od.order_id=o.id");
	    $this->db->join("product p","p.id=od.product");
	    $this->db->join("quantity q","p.id=q.product");
	    $this->db->where("o.id",$order_id);
        $this->db->where("od.od_price=q.unit_price");
	    $products=$this->db->get()->result_array();


        foreach ($products as $product) {
            $data=array(
                "quantity"=> $product["quantity"]-$product["od_quantity"]
            );
            $this->db->where("id",$product["q_id"]);
            $this->db->update("quantity", $data);

            $data=array(
                "totalQuantity"=> $product["totalQuantity"]-$product["od_quantity"]
            );
            $this->db->where("id",$product["p_id"]);
            $this->db->update("product", $data);

	    }
	    $this->db->where('id', $order_id);
		$this->db->delete('order');


        $this->db->where('order_id', $order_id);
        $this->db->delete('orderdetails');

        $this->db->where('order_id', $order_id);
        $this->db->delete('stock_history');

	}
}