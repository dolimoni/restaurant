<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_provider extends CI_Model {

    private $current_db = 0;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_quotation');
    }

	public function add($provider,$master_id=0,$database="local")
	{
		$data = array(
			   'title' => $provider['title'],
               'name' => $provider['name'],
               'prenom' => $provider['prenom'],
               'address' => $provider['address'],
               'phone' => $provider['phone'],
               'mail' => $provider['mail'],
               'tva' => $provider['tva'],
               'image' => $provider['image'],
            );
		if($database === "remote"){
            $data["id_master"]= $master_id;
        }
		$this->db->insert('provider', $data);
		return $this->db->insert_id();
	}
    public function addProducts($productsList, $quotation=null)
	{
	    foreach ($productsList as $product){
            $data = array(
                'name' => $product['name'],
                'provider' => $product['provider'],
                'quotation' => $quotation['id'],
                'status' => $product['status']
            );
            $this->db->insert('product', $data);

            $insert_id = $this->db->insert_id();

            $data = array(
                'product' => $insert_id,
                'unit_price' => $product['price'],
                'status' => $product['status']
            );
            $this->db->insert('quantity', $data);

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
	    $this->db->select("p.*,pg.title,pg.id as pg_id");
	    $this->db->from("provider p");
	    $this->db->join("providergroups pg","pg.id=p.title","left");
		$result = $this->db->get();
		return $result->result_array();
	}

	public function getByGroup($id_group)
	{
	    $this->db->select("p.*,pg.title,pg.id as pg_id");
	    $this->db->from("provider p");
	    $this->db->join("providergroups pg","pg.id=p.title","left");
	    $this->db->where("pg.id", $id_group);
		$result = $this->db->get();
		return $result->result_array();
	}

    public function getProviderByMasterId($id)
    {
        $this->db->where("id_master", $id);
        $result= $this->db->get("provider")->row_array();
        return $result;
    }

	public function getGroups()
	{
		$result = $this->db->get('providergroups');
		return $result->result_array();
	}

	public function addGroup($group)
	{
		$this->db->insert('providergroups', $group);
	}
    public function editGroup($id,$group)
    {
        $this->db->where('id',$id);
        $this->db->update('providergroups', $group);
    }

	public function getAllProducts()
	{
	    $this->db->select('p.name,pv.name as provider,q.unit_price');
	    $this->db->from('product p');
	    $this->db->join('quantity q','p.id=q.product');
	    $this->db->join('provider pv','pv.id=q.provider');
	    $this->db->where('q.status','active');
	    $this->db->where('p.status','active');
	    $this->db->where('provider>0');
	    $this->db->order_by('name');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function getBestProductsPrice()
	{

        $query="SELECT p.name,pv.name as provider,unit_price
                from (
                   select q.id,min(unit_price) as min_unit_price,p.name
                   from quantity q inner join product p  on p.id=q.product where q.status='active' and provider>0 and p.status='active' group by p.name
                ) as temp 
                inner join quantity q 
                inner join product p on p.id=q.product and p.name = temp.name and temp.min_unit_price=unit_price 
                inner join provider pv on pv.id=q.provider
                where q.status='active' and provider>0 and p.status='active'";

        $dbResult = $this->db->query($query);
        return $dbResult->result_array();
	}
	public function getAllActive()
	{
        $this->db->where('status', "active");
		$result = $this->db->get('provider');
		return $result->result_array();
	}

	public function get($id)
	{
        $this->db->select("p.*,pg.title,pg.id as pg_id");
        $this->db->from("provider p");
        $this->db->join("providergroups pg", "pg.id=p.title", "left");
        $this->db->where("p.id",$id);
        $result = $this->db->get();
        return $result->row_array();
	}

	public function getOrders($id)
	{
        $this->db->select('*');
        $this->db->from('order o');
        //$this->db->join('orderdetails od', 'o.id = od.order_id');
        $this->db->where('provider',$id);
        $this->db->order_by('id',"asc");
		$result = $this->db->get();
		return $result->result_array();
	}

	public function getAllOrders()
	{
        $this->db->select('o.id,pv.name as pv_name,o.ttc as amount,o.paid,o.status,o.created_at');
        $this->db->from('order o');
        $this->db->join('provider pv',"pv.id=o.provider");
		$result = $this->db->get();
		return $result->result_array();
	}

	public function getProducts($id,$status="active",$visibility="shown")
	{
        $this->db->select('*,p.id as id, q.id as q_id');
        $this->db->from('product p');
        $this->db->join('quantity q','q.product=p.id and (q.status="active" or q.status="stock")','left');
        //$this->db->where('q.status','active');
		$this->db->where('q.provider', $id);
		$this->db->where('p.status', "active");
		$this->db->where('q.visibility', $visibility);
		$this->db->order_by("p.name","asc");
		$result = $this->db->get();
		return $result->result_array();
	}
	public function getQuotations($id)
	{
		$this->db->where('provider', $id);
		$result = $this->db->get('quotation');
		return $result->result_array();
	}
	
	public function update($id,$provider)
	{
		$this->db->where('id', $id);
		$this->db->update('provider', $provider);
	}



    public function getStatistics($id){
        // od : order details : liste des produits par commande
        $this->db->select('*');
        $this->db->select('sum(od.quantity) as s_od_quantity');
        $this->db->select('sum(od.quantity)*q.unit_price as s_od_totalPrice');// somme du montant dépensé sur l'achat d'un produit
        $this->db->from('orderdetails od');
        $this->db->join('order o', 'o.id=od.order_id');
        $this->db->join('product p', 'p.id= od.product');
        $this->db->join('quantity q', 'p.id= q.product');
        $this->db->where('q.status', 'active');
        $this->db->where('o.provider', $id);
        $this->db->where('o.status', "received");
        $this->db->group_by('od.product');
        $this->db->order_by('s_od_quantity',"desc");
        $this->db->limit(10);
        $result = $this->db->get()->result_array();
        $s_od_totalPrices = array_column($result, 's_od_totalPrice');
        $result['totalBuy']=array_sum($s_od_totalPrices);// total des achats chez un fournisseur
        return $result;
    }

    public function getProductMultipleProviders(){
        $this->db->select('p.name,pv.name as provider,q.unit_price');
        $this->db->select('count(q.product) count');
        $this->db->from('product p');
        $this->db->join('quantity q', 'p.id=q.product');
        $this->db->join('provider pv', 'pv.id=q.provider');
        //$this->db->where('q.status', 'active');
        $this->db->where('p.status', 'active');
       // $this->db->where('provider>0');
        $this->db->group_by('q.product');
        $this->db->order_by('count',"desc");
        $result = $this->db->get();
        return $result->row_array();
    }
    public function deleteProvider($provider_id)
    {
        $this->db->where('id', $provider_id);
        $this->db->delete('provider');
    }

    public function payOrder($id)
    {
        $this->db->where('id', $id);

        $db_order=$this->db->get('order')->row_array();
        $paymentDate= strtotime(date("Y-m-d H:i:s"));
        $paid="false";
        if($db_order["paid"]==="true"){
            $this->db->where('id', $id);
            $this->db->update('order', array("paid" => "false", "paymentDate" => null));
        }else{
            $this->db->where('id', $id);
            $this->db->update('order', array("paid" => "true", "paymentDate" => date("Y-m-d H:i:s")));
            $paymentDate = strtotime(date("Y-m-d H:i:s"));
            $paid = "true";
        }
        $order=array(
            "paid"=> $paid,
            "paymentDate"=> date("d-m-Y", $paymentDate),
        );
        return $order;
    }

    public function getImpaidProviders($startDate=null,$endDate=null){
        $this->db->select("sum(o.ttc) as amount");
        $this->db->select("o.id,date(created_at) as date,p.name,p.id as p_id");
        $this->db->from("order o");
        $this->db->join("provider p","p.id=o.provider");
        $this->db->where("paid","false");
        if ($startDate) {
            $this->db->where('date(o.created_at)>=', $startDate);
            $this->db->where('date(o.created_at)<=', $endDate);
        }
        $this->db->group_by("o.provider");
        $this->db->order_by("o.created_at");
        return $this->db->get()->result_array();
    }

    public function deleteProduct($product_id, $quantity_id)
    {
        $this->db->where('id', $quantity_id);
        $this->db->where('product', $product_id);
        $this->db->update('quantity',array("visibility"=>"hidden"));
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
        if ($this->current_db === 0) {
            $this->db = $this->load->database('default', TRUE);
        } else {
            $this->db = $this->load->database('remote_' . $current_db, TRUE);
        }
    }
}