<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_order extends CI_Model {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_quotation');
    }

	public function add($order)
	{

        $this->load->model("model_product");
	    $db_params=$this->db->get("config")->row_array();
        $data = array(
            'provider' => $order['provider']['id'],
            'tva' => $order['tva'],
            'discount' => $order['discount'],
            'reference' => $order['reference'],
            'orderDate' => $order['orderDate'],
            'paymentDate' => $order['paymentDate'],
            'paymentType' => $order['paymentType'],
            'ttc' => $order['underTotal']*(1+$order['tva']/100)-$order['discount'],
        );
        $order_id=0;
        if($db_params["orderReception"]==="true"){
            $data["status"]="received";
            $this->db->insert('order', $data);
            $order_id = $this->db->insert_id();
            $this->model_product->updateQuantities($order['productsList'], 'up', $order['provider']['id'], $order_id);
        }else{
            $this->db->insert('order', $data);
            $order_id = $this->db->insert_id();
        }

        $negociation_id=$this->addNegociation($data,$order_id);

        $data_order=$data;
        if ($db_params["orderPayment"] === "true") {
            $this->payOrder($order_id);
        }

        foreach ($order['productsList'] as $product) {
            $db_product=$this->model_product->getById($product['id']);
            $piecesByPack=1;
            if($product['pack']==='true'){
                $piecesByPack=$product['piecesByPack'];
            }
            $data = array(
                'product' => $product['id'],
                'product_name' => $db_product["name"],
                'order_id' => $order_id,
                'quantity' => $product['quantity'],
                'od_price' => $product['unit_price'],
                'mark' => $product['mark'],
                'pack' => $product['pack'],
                'unit' => $db_product['unit'],
                'piecesByPack' => $piecesByPack,
                'storage_area' => $order['storage_area'],
                'quantity_id' => 0,
            );
            $this->db->insert('orderdetails', $data);
            $orderdetails_id= $this->db->insert_id();
            $this->db->where('id',$product['mark']);
            $mark=$this->db->get('mark')->row_array();
            if(!is_null($mark)){
                $mark['orderdetails']=$orderdetails_id;
                $mark['m_name']=$mark['name'];
                $mark['mark']=$mark['id'];
                unset($mark['product']);
                unset($mark['deleted']);
                unset($mark['name']);
                unset($mark['id']);
                $this->db->insert('order_mark',$mark);
            }
            $this->addNegociationProducts($data_order,$data,$negociation_id);

        }

        $this->addAdvances($order,$order_id);



	}

	public function addNegociation($data,$order_id){
        $this->db->where('id',$data['provider']);
        $provider=$this->db->get('provider')->row_array();
        $data['order_id']=$order_id;
        $negociation_id=0;
        if($provider['stockitmain']!=='0'){
            $negociation_id = $this->db->insert('negociation',$data);
        }

        return $negociation_id;
    }
    public function addNegociationProducts($order,$product,$negociation_id){
        $this->db->where('id',$order['provider']);
        $provider=$this->db->get('provider')->row_array();
        $data['negociation']=$negociation_id;
        if($provider['stockitmain']!=='0'){
            $this->db->insert('negociation_product',$product);
        }
    }

	public function addAdvances($order,$order_id){
        $advancesAmount=0;
        $advances=array();
        if(isset($order['advances'])){
            $advances=$order['advances'];
        }
        foreach ($advances as $advance) {
            $data = array(
                'order_id' => $order_id,
                'amount' => $advance['amount'],
                'paymentDate' => $advance['date'],
            );
            $advancesAmount+=$advance['amount'];
            $this->db->insert('order_advances', $data);
        }
        if($advancesAmount>0){
            $this->db->where('id',$order_id);
            $this->db->update('order',array('advance'=>$advancesAmount));
        }
    }

	public function update($order)
	{

	    $this->load->model('model_mark');
        $data = array(
            'status' => $order['status'],
            'tva' => $order['tva'],
            'discount' => $order['discount'],
            'reference' => $order['reference'],
            'orderDate' => $order['orderDate'],
            'paymentDate' => $order['paymentDate'],
            'paymentType' => $order['paymentType'],
            'ttc' => $order['underTotal'] * (1 + $order['tva']/100)-$order['discount'],
        );

        $this->db->where("id",$order['id']);
        $this->db->update("order",$data);
        $data['provider']=$order['provider']['id'];
        $this->addNegociation($data,$order['id']);
        $data_order=$data;
        $this->updateAdvances($order);
        if(isset($order['productsList'])){
            foreach ($order['productsList'] as $product) {

                $this->db->where('product',$product['id']);
                $this->db->where('unit_price',number_format($product['unit_price']/$product['piecesByPack'],"4"));
                $quntity_id=$this->db->get('quantity')->row('id');

                $this->db->where('order_id', $order['id']);
                $this->db->where('product', $product['id']);
                //$this->db->where('quantity_id', $quntity_id);
                $r = $this->db->get('orderdetails');

                if ($r->num_rows() > 0) {
                    $orderdetails=$r->row_array();
                    $data = array(
                        'quantity' => $product['quantity'],
                        'mark' => $product['mark'],
                        'od_price' => $product['unit_price'],
                        'quantity_id' => $quntity_id,
                    );
                    $this->db->where('order_id', $order['id']);
                    $this->db->where('product', $product['id']);
                    //$this->db->where('quantity_id', $quntity_id);
                    $this->db->update('orderdetails', $data);
                    $this->model_mark->updateMarkOrder($orderdetails,$product);

                } else {
                    $data = array(
                        'quantity' => $product['quantity'],
                        'od_price' => $product['unit_price'],
                        'mark' => $product['mark'],
                        'product' => $product['id'],
                        'quantity_id' => $quntity_id,
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

	private function updateAdvances($order){
        $deletedAdvances=array();
        $advancesAmount=0;
        $advances=array();
        if(isset($order['deletedAdvances'])){
            $deletedAdvances=$order['deletedAdvances'];
        }
        if(isset($order['advances'])){
            $advances=$order['advances'];
        }
        foreach ($advances as $advance){
            $advancesAmount+=$advance['amount'];
            $data = array(
                'paymentDate' => $advance['date'],
                'amount' => $advance['amount'],
                'order_id' => $order['id'],
            );
            if($advance['id']>0){
                $this->db->where('id', $advance['id']);
                $this->db->update('order_advances', $data);
            }else{
                $this->db->insert('order_advances', $data);
            }
        }
        foreach ($deletedAdvances as $deletedAdvance){
            $this->db->where('id', $deletedAdvance['id']);
            $this->db->delete('order_advances');
        }
        $this->db->where('order_id',$order['id']);
        $this->db->where('type','final');
        $final_advance=$this->db->get('order_advances')->row_array();
        if($final_advance){
            $data=array('paymentDate'=>$order['paymentDate']);
            $this->db->where('id',$final_advance['id']);
            $this->db->update('order_advances',$data);
        }
        $ttc=$order['underTotal'] * (1 + $order['tva']/100)-$order['discount'];
        $data=array('advance'=>$advancesAmount);
        if($advancesAmount>=$ttc){
            $data['paid']='true';
        }
        $this->db->where('id',$order['id']);
        $this->db->update('order',$data);

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

	public function getOne($id){
        $this->db->where('id', $id);
        $result=$this->db->get('order');
        return $result->row_array();
    }

    public function get($id, $fetch = 'LAZY')
    {
        if ($fetch === "LAZY") {
            $this->db->select('o.*');
            $this->db->from('order o');
            $this->db->join('quantity q',"q.id=o.quantity_id");
            $result=$this->db->where('id', $id);
            return $result->row_array();
        } else {

            $this->db->select('*,o.id as o_id,o.status as o_status');
            $this->db->from('order o');
            $this->db->where('o.id', $id);
            $order = $this->db->get()->row_array();

            $this->db->select('od.*, p.*,od.quantity as od_quatity,od.piecesBypack od_piecesBypack,od.pack od_pack');
            $this->db->from('order o');
            $this->db->join('orderdetails od', 'od.order_id = o.id');
            $this->db->join('product p', 'p.id = od.product');
            //$this->db->join('quantity q', "q.id=od.quantity_id");
            $this->db->where('o.id', $id);
            $order['productsList'] = $this->db->get()->result_array();

            $this->db->where('order_id',$id);
            $this->db->where('type','advance');
            $order['advances']=$this->db->get('order_advances')->result_array();

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
	    $this->db->select("q.id as q_id,p.id as p_id,q.quantity,od.piecesByPack as od_piecesByPack,od.quantity as od_quantity,totalQuantity,p.inventoryCredit");
	    $this->db->from("order o");
	    $this->db->join("orderdetails od","od.order_id=o.id");
	    $this->db->join("product p","p.id=od.product");
	    $this->db->join("quantity q","p.id=q.product");
	    $this->db->where("o.id",$order_id);
        $this->db->where("od.quantity_id=q.id");
	    $products=$this->db->get()->result_array();


        foreach ($products as $product) {
            $data=array(
                "quantity"=> $product["quantity"]-$product["od_quantity"]*$product["od_piecesByPack"]
            );
            $this->db->where("id",$product["q_id"]);
            $this->db->where("deleted",'false');
            $this->db->update("quantity", $data);

            $inventoryCredit= $product["inventoryCredit"]-$product["od_quantity"];
            if($inventoryCredit<0){
                $inventoryCredit=0;
            }

            $data=array(
                "totalQuantity"=> $product["totalQuantity"]-$product["od_quantity"],
                "inventoryCredit"=> $inventoryCredit
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

        $this->db->where('order_id', $order_id);
        $this->db->delete('order_advances');

	}

    public function payOrder($id)
    {
        $this->db->where('id', $id);

        $db_order = $this->db->get('order')->row_array();
        $paymentDate = strtotime(date("Y-m-d H:i:s"));
        $paid = "false";
        if ($db_order["paid"] === "true") {
            $this->db->where('id', $id);
            $this->db->update('order', array("paid" => "false", "paymentDate" => null));
        } else {
            $this->db->where('id', $id);
            $this->db->update('order', array("paid" => "true", "paymentDate" => date("Y-m-d H:i:s")));
            $paymentDate = strtotime(date("Y-m-d H:i:s"));
            $paid = "true";
        }
        $order = array(
            "paid" => $paid,
            "paymentDate" => date("d-m-Y", $paymentDate),
        );
        return $order;
    }

    public function config(){
        $this->db->where('id', 1);
        $config=$this->db->get('order_config')->row_array();
        return $config;
    }

    public function changeStatus($order_id,$status){
        $response=array('status'=>'success');
        $data=array();
        if($status==='accepted'){
            $data['status']='shipping';
        }
        $this->db->where('id', $order_id);
        $this->db->update('order',$data);
        return $response;
    }
}