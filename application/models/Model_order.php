<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_order extends CI_Model {

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

	public function add($order)
	{

        $data = array(
            'provider' => $order['provider']['id'],
            'tva' => $order['tva'],
            'ttc' => $order['underTotal']* $order['tva'],
        );

        $this->db->insert('order', $data);
        $orderId = $this->db->insert_id();
        foreach ($order['productsList'] as $product) {
            $data = array(
                'product' => $product['id'],
                'order_id' => $orderId,
                'quantity' => $product['quantity'],
            );
            $this->db->insert('orderdetails', $data);
        }
	}

	public function update($order)
	{

        $data = array(
            'status' => $order['status']
        );

        $this->db->where("id",$order['id']);
        $this->db->update("order",$data);
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
            $this->db->where('id', $id);
            $result = $this->db->get('order');
            return $result->row_array();
        } else {

            $this->db->select('*,o.id as o_id,o.status as o_status');
            $this->db->from('order o');
            $this->db->where('o.id', $id);
            $order = $this->db->get()->row_array();

            $this->db->select('od.*, p.*,od.quantity as od_quatity');
            $this->db->from('order o');
            $this->db->join('orderdetails od', 'od.order_id = o.id');
            $this->db->join('product p', 'p.id = od.product');
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



	public function delete($u_id)
	{
		$this->db->where('id', $u_id);
		$this->db->where("(su != 1)");
		$this->db->delete('users'); 
	}
}