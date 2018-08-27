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
        $this->load->model('model_params');
        $params=$this->model_params->config();
        foreach ($stock['productsList'] as $product) {
            $product['department']= $stock['department'];
            $db_stock_product = $this->getProductById($product);
            $db_product = $this->model_product->getById($product['id']);

            $thriftyUpdateRealStock=false;
            if($params['thriftyUpdateRealStock']==='true'){
                $thriftyUpdateRealStock=true;
            }
            $response=$this->model_product->updateLocalQuantity($product['id'], $product['quantity'],"down","principal",null,$thriftyUpdateRealStock);
            $this->addStockProductsPrice($product['id'],$response,$stock['department']);


        }
    }

    public function addStockProductsPrice($product_id,$response,$department){

        $db_product=$this->model_product->getById($product_id);
        foreach ($response["quantities"] as $quantityItem) {
            $quantityData = array(
                "quantity" => $quantityItem["quantity"],
                "init_quantity" => $quantityItem["quantity"],
                "unit_price" => $quantityItem["unit_price"],
                "unit" => $db_product["unit"],
                "product" => $product_id,
                "provider" => $quantityItem['provider'],
                "department" => $department,
            );
            $this->db->insert('stock_product', $quantityData);
            $quantityData["type"] = "out";
            unset($quantityData["init_quantity"]);
            $this->db->insert('stock_history', $quantityData);
        }
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

    public function getProductsHistory($destination='department'){
        $this->db->select('sh.id,p.name,d.name as d_name,p.name as p_name,sh.type,sh.quantity,sh.unit,p.min_quantity,p.totalQuantity,Date(sh.created_at) as date,sh.created_at');
        $this->db->from('stock_history sh');
        $this->db->join('product p','p.id=sh.product');
        $this->db->join('department d','d.id=sh.department','left');
        $this->db->order_by('created_at','desc');
        $this->db->where('destination',$destination);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function editStockHistory($stock_history){
        $responseData=array(
            "status"=>"success",
            "msg"=>"success"
        );
        $this->load->model('model_provider');
        $this->db->where("id", $stock_history['id']);
        $db_stock_history=$this->db->get("stock_history")->row_array();//getting stock
        $delta=$db_stock_history["quantity"]-$stock_history['quantity'];

        if($delta<0){// add quantity
            $this->db->select('sum(quantity) as quantity');
            $this->db->where("product", $db_stock_history["product"]);
            $this->db->where("unit_price", $db_stock_history["unit_price"]);
            $this->db->where("provider", $db_stock_history["provider"]);
            $quantity=$this->db->get("quantity")->row("quantity");
            if(abs($delta)> $quantity){
                $responseData = array(
                    "status" => "warning",
                    "msg" => "Quantité insuffisante",
                );
            }else{

                // inverse : quantity negatif
                $this->model_product->updateQuantity($db_stock_history['product'], abs($delta));

                $quantityData = array(
                    "quantity" => $delta,
                    "unit_price" => $db_stock_history["unit_price"],
                    "product" => $db_stock_history['product'],
                    "provider" => $db_stock_history["provider"],
                );

                $this->model_product->accumulateQuantity($quantityData);

                $this->updateStockProductsPrice($delta, $db_stock_history['product'], $db_stock_history);
            }

        }else{

            $quantityData = array(
                "quantity" => abs($delta),
                "unit_price" => $db_stock_history["unit_price"],
                "product" => $db_stock_history['product'],
                "provider" => $db_stock_history["provider"],
            );
            $this->model_product->accumulateQuantity($quantityData);

            $this->updateStockProductsPrice($delta, $db_stock_history['product'], $db_stock_history);
        }

        return $responseData;
    }


    public function deleteStockHistory($stock_history_id){
        $this->db->where("id", $stock_history_id);

        $stock_history=array(
            'id'=>$stock_history_id,
            'quantity'=>0
        );

        $response=$this->editStockHistory($stock_history);
        $this->db->where('id',$stock_history_id);
        $this->db->delete('stock_history');
        return $response;
    }

    public function updateStockProductsPrice($delta,$product_id,$stock_history)
    {

        $totalQuantity = $stock_history["quantity"] - $delta;

        $quantityData = array(
            "quantity" => $totalQuantity,
        );
        if ($delta < 0) {
            $this->db->where("id", $stock_history["id"]);
            $this->db->update('stock_history', $quantityData);

            $this->db->where("product", $stock_history["product"]);
            $this->db->where("unit_price", $stock_history["unit_price"]);
            $this->db->where("provider", $stock_history["provider"]);
            $this->db->where("quantity", $stock_history["quantity"]);
            $this->db->limit(1);
            $this->db->update('stock_product', $quantityData);
        } else {
            $this->db->where("id", $stock_history["id"]);
            $this->db->update('stock_history', $quantityData);

            $this->db->where("product", $stock_history["product"]);
            $this->db->where("unit_price", $stock_history["unit_price"]);
            $this->db->where("provider", $stock_history["provider"]);
            $this->db->where("quantity", $stock_history["quantity"]);
            $this->db->limit(1);
            $this->db->update('stock_product', $quantityData);
        }
    }
    public function accumulateQuantity($quantityData)
    {

        $this->db->where('product', $quantityData['product']);
        $this->db->where('unit_price', $quantityData['unit_price']);
        $db_quantity = $this->db->get('stock_product_price')->row_array();
        if ($db_quantity) {
            $quantityData['quantity'] += $db_quantity['quantity'];
            $this->db->where('product', $quantityData['product']);
            $this->db->where('unit_price', $quantityData['unit_price']);
            $this->db->update('price_stock_product', $quantityData);
        } else {
            $this->db->insert('stock_product_price', $quantityData);
        }
    }

}