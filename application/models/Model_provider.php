<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_provider extends CI_Model {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_quotation');
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

	public function add($provider)
	{
		$data = array(
			   'title' => $provider['name'],
               'name' => $provider['name'],
               'prenom' => $provider['prenom'],
               'address' => $provider['address'],
               'phone' => $provider['phone'],
               'mail' => $provider['mail'],
               'image' => $provider['image'],
            );
		$this->db->insert('provider', $data);
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

	public function get($id)
	{
		$this->db->where('id', $id);
		$result = $this->db->get('provider');
		return $result->row_array();
	}

	public function getOrders($id)
	{
        $this->db->select('*');
        $this->db->from('order o');
        //$this->db->join('orderdetails od', 'o.id = od.order_id');
        $this->db->where('provider',$id);
		$result = $this->db->get();
		return $result->result_array();
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
	
	public function update($provider)
	{
		$data = array(
			'title' => $provider['title'],
			'name' => $provider['name'],
			'prenom' => $provider['prenom'],
			'address' => $provider['address'],
			'mail' => $provider['mail'],
			'phone' => $provider['phone']
        );

		$this->db->where('id', $provider['id']);
		$this->db->update('provider', $data);
	}


	public function delete($u_id)
	{
		$this->db->where('id', $u_id);
		$this->db->where("(su != 1)");
		$this->db->delete('users'); 
	}

    public function getStatistics($id){
        // od : order details : liste des produits par commande
        $this->db->select('*');
        $this->db->select('sum(od.quantity) as s_od_quantity');
        $this->db->select('sum(od.quantity)*unit_price as s_od_totalPrice');// somme du montant dépensé sur l'achat d'un produit
        $this->db->from('orderdetails od');
        $this->db->join('order o', 'o.id=od.order_id');
        $this->db->join('product p', 'p.id= od.product');
        $this->db->where('o.provider', $id);
        $this->db->where('o.status', "received");
        $this->db->group_by('od.product');
        $result = $this->db->get()->result_array();
        $s_od_totalPrices = array_column($result, 's_od_totalPrice');
        $result['totalBuy']=array_sum($s_od_totalPrices);// total des achats chez un fournisseur
        return $result;
    }
}