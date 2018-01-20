<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_stock extends CI_Model {

    public function getProductById($product){
        $this->db->where('product',$product['id']);
        $this->db->where('department',$product['department']);
        $result = $this->db->get('stock_product');
        return $result->row_array();
    }

    public function addStock($stock){
        $this->load->model('model_product');
        foreach ($stock['productsList'] as $product) {
            $product['department']= $stock['department'];
            $db_product = $this->getProductById($product);

            if($db_product){
                $data = array(
                    'quantity' => $product['quantity'] + $db_product['quantity'],
                );
                $this->db->where('product', $product['id']);
                $this->db->where('department', $product['department']);
                $this->db->update('stock_product', $data);
                $this->model_product->updateQuantity($product['id'], $product['quantity']);
            }else{

                $data = array(
                    'product' => $product['id'],
                    'quantity' => $product['quantity'],
                    'department' => $stock['department'],
                );
                $this->db->insert('stock_product', $data);
                $this->model_product->updateQuantity($product['id'], $product['quantity']);
            }

        }
        $this->addStockHistory($stock['productsList'],'out', $stock['department']);
    }

    public function addStockHistory($productsList,$type,$department=null){
        foreach ($productsList as $product) {

            $data = array(
                'product' => $product['id'],
                'quantity' => $product['quantity'],
                'department' => $department,
                'type' => $type,
            );
            $this->db->insert('stock_history', $data);
        }
    }
    public function updateQuantity($product, $quantity, $direction = "down")
    {

        $l_product = $this->getProductById($product);


        $l_quantity = $l_product['quantity'] - $quantity;

        if ($direction === "up") {
            $l_quantity = $l_product['quantity'] + $quantity;
        }

        if($l_quantity<0){
            $l_quantity=0;
        }

        $data = array(
            'quantity' => $l_quantity,
        );

        $this->db->where('product', $product['product']);
        $this->db->where('department', $product['department']);
        $this->db->update('stock_product', $data);
    }

    public function getProductsHistory(){
        $this->db->select('sh.id,p.name,d.name as d_name,p.name as p_name,sh.type,sh.quantity,p.min_quantity,p.totalQuantity,Date(sh.created_at) as date');
        $this->db->from('stock_history sh');
        $this->db->join('product p','p.id=sh.product');
        $this->db->join('department d','d.id=sh.department','left');
        $result = $this->db->get();
        return $result->result_array();
    }

}