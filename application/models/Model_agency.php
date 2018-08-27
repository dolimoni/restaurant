<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_agency extends CI_Model {

    private $remote_db = "";
    private $current_db = 0;

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isLogin')) {
            redirect('login');
        }

    }

    public function getAll($get_master=false){
        if(!$get_master){
            $this->db->where("status", "enabled");
        }else{
            $this->db->where("status", "enabled");
            //$this->db->where("status='enabled' and type!='master'");
            $this->db->or_where("type", "master");
        }
       return $this->db->get("agency")->result_array();
    }

    public function getAgency($id){
        $this->db->where("status", "enabled");
        $this->db->where("id", $id);
        return $this->db->get("agency")->row_array();
    }

    public function getSlaves(){
        $this->db->where("type", "slave");
        $this->db->where("status", "enabled");
        return $this->db->get("agency")->result_array();
    }

    public function editAgency($id,$agency){
        $this->db->where("id",$id);
        $this->db->update("agency",$agency);
    }

    public function editStockHistory($stock_history_id,$quantity){
        $responseData=array(
            "status"=>"success",
            "msg"=>"success"
        );
        $this->load->model('model_provider');
        $this->db->where("id", $stock_history_id);
        $stock_history=$this->db->get("stock_history")->row_array();//getting stock
        $delta=$stock_history["quantity"]-$quantity;
        $agency=$this->getAgency($stock_history["department"]);

        if($delta<0){// add quantity
            $this->db->select('sum(quantity) as quantity');
            $this->db->where("product", $stock_history["product"]);
            $this->db->where("unit_price", $stock_history["unit_price"]);
            $this->db->where("provider", $stock_history["provider"]);
            $quantity=$this->db->get("quantity")->row("quantity");
            if(abs($delta)> $quantity){
                $responseData = array(
                    "status" => "warning",
                    "msg" => "Quantité insuffisante",
                );
            }else{

                // inverse : quantity negatif
                $this->model_product->updateQuantity($stock_history['product'], abs($delta));

                $quantityData = array(
                    "quantity" => $delta,
                    "unit_price" => $stock_history["unit_price"],
                    "product" => $stock_history['product'],
                    "provider" => $stock_history["provider"],
                );

                $this->model_product->accumulateQuantity($quantityData);

                $this->updateStockProductsPrice($delta,$agency, $stock_history['product'], null, $stock_history);
            }

        }else{
            $this->model_product->updateQuantity($stock_history['product'], abs($delta),"up");

            $quantityData = array(
                "quantity" => abs($delta),
                "unit_price" => $stock_history["unit_price"],
                "product" => $stock_history['product'],
                "provider" => $stock_history["provider"],
            );
            $this->model_product->accumulateQuantity($quantityData);

            $this->updateStockProductsPrice($delta, $agency, $stock_history['product'], null, $stock_history);
        }

        return $responseData;
    }

    public function deleteStockHistory($stock_history_id){
        $responseData=array(
            "status"=>"success",
            "msg"=>"success"
        );
        $this->load->model('model_provider');
        $this->db->where("id", $stock_history_id);
        $stock_history=$this->db->get("stock_history")->row_array();
        $delta=$stock_history["quantity"];
        $agency=$this->getAgency($stock_history["department"]);

        // same as editstockhistory
        $this->model_product->updateQuantity($stock_history['product'], abs($delta), "up");

        $quantityData = array(
            "quantity" => abs($delta),
            "unit_price" => $stock_history["unit_price"],
            "product" => $stock_history['product'],
            "provider" => $stock_history["provider"],
        );
        $this->model_product->accumulateQuantity($quantityData);

        $this->updateStockProductsPrice($delta, $agency, $stock_history['product'], null, $stock_history);

        return $responseData;
    }

    //getting product in stock
    public function getProducts($department)
    {

        $this->db->select('*,sp.quantity as qte,p.id as p_id');
        $this->db->select('sum(sp.quantity) as quantity');
        $this->db->from('stock_product sp');
        $this->db->join('product p', 'sp.product=p.id');
        $this->db->where('department', $department);
        $this->db->group_by('sp.product');
        $products = $this->db->get()->result_array();

        return $products;
    }

    public function getProductById($product)
    {
        $this->db->where('product', $product['id']);
        $this->db->where('department', $product['department']);
        $result = $this->db->get('stock_product');
        return $result->row_array();
    }

    public function addStock($stock)
    {
        $this->load->model('model_product');
        $this->load->model('model_provider');
        $this->load->model('department/model_stock');
        $agencies=$this->getSlaves();
        foreach ($stock['productsList'] as $product) {
            $product['department'] = $stock['department'];

            $agency = $this->getAgency($product['department']);

            $this->model_product->updateQuantity($product['id'], $product['quantity']);

            $response = $this->model_product->updateLocalQuantity($product['id'], $product['quantity']);

            $this->addStockProductsPrice($agency, $product["id"], $response, $product['quantity']);

        }
    }

    public function addStockProductsPrice($agency,$product_id,$response,$quantity){


        // response : liste quantities used in consumption product
        if ($agency["type"] === "master") {
            $db_product=$this->model_product->getById($product_id);
            foreach ($response["quantities"] as $quantityItem) {
                $quantityData = array(
                    "quantity" => $quantityItem["quantity"],
                    "init_quantity" => $quantityItem["quantity"],
                    "unit_price" => $quantityItem["unit_price"],
                    "unit" => $db_product['unit'],
                    "product" => $product_id,
                    "provider" => $quantityItem['provider'],
                    "department"=> $agency["id"]
                );
                $this->db->insert('stock_product', $quantityData);
                $quantityData["type"] = "out";
                unset($quantityData["init_quantity"]);
                $quantityData['destination']='agency';
                $this->db->insert('stock_history', $quantityData);

            }
        } else {

            // send products to remote db
            $this->model_product->setCurrentDb($agency["id"]);
            $this->model_provider->setCurrentDb($agency["id"]);
            $slaveProduct = $this->model_product->getProductByMasterId($product_id);
            $this->model_product->updateQuantity($slaveProduct['id'], $quantity, "up");
            foreach ($response["quantities"] as $quantityItem) {
                $slaveProvider=$this->model_provider->getProviderByMasterId($quantityItem["provider"]);
                if($slaveProvider==NULL){
                    $slaveProvider["id"]=0;
                }
                $quantityData = array(
                    "quantity" => $quantityItem["quantity"],
                    "unit_price" => $quantityItem["unit_price"],
                    "product" => $slaveProduct['id'],
                    "provider"=> $slaveProvider["id"],
                );
                $this->model_product->accumulateQuantity($quantityData);
            }
            $this->model_product->setCurrentDb(0);
            $this->model_provider->setCurrentDb(0);

            // add product to stock_history in local db
            foreach ($response["quantities"] as $quantityItem) {
                $quantityData = array(
                    "quantity" => $quantityItem["quantity"],
                    "unit_price" => $quantityItem["unit_price"],
                    "product" => $product_id,
                    "unit" => $slaveProduct['unit'],
                    "provider" => $quantityItem["provider"],
                    "department" => $agency["id"],
                    "type" => "out",
                    'destination'=>'agency'
                );
                $this->db->insert('stock_history', $quantityData);
            }
        }
    }

    public function addLocalStockProduct($quantities,$product_id,$agency_id,$removal="manuel"){
        foreach ($quantities as $quantityItem) {
            $quantityData = array(
                "quantity" => number_format($quantityItem["quantity"],2),
                "id_quantity" => number_format($quantityItem["id"],2),
                "init_quantity" => number_format($quantityItem["quantity"],2),
                "unit_price" => $quantityItem["unit_price"],
                "product" => $product_id,
                "provider" => $quantityItem['provider'],
                "department" => $agency_id,
                "removal"=> $removal
            );
            $this->db->insert('stock_product', $quantityData);
            $quantityData["type"] = "out";
            unset($quantityData["init_quantity"]);
            $this->db->insert('stock_history', $quantityData);
        }
    }

    public function updateStockProductsPrice($delta,$agency,$product_id,$response,$stock_history){

            $totalQuantity=$stock_history["quantity"] - $delta;
            // response : liste quantities used in consumption product
            if ($agency["type"] === "master") {
                $quantityData = array(
                    "quantity" => $totalQuantity,
                );
                if($delta<0){
                    $this->db->where("id", $stock_history["id"]);
                    $this->db->update('stock_history', $quantityData);

                    $this->db->where("product", $stock_history["product"]);
                    $this->db->where("unit_price", $stock_history["unit_price"]);
                    $this->db->where("provider", $stock_history["provider"]);
                    $this->db->where("quantity", $stock_history["quantity"]);
                    $this->db->limit(1);
                    $this->db->update('stock_product', $quantityData);
                }else{
                    $this->db->where("id", $stock_history["id"]);
                    $this->db->update('stock_history', $quantityData);

                    $this->db->where("product", $stock_history["product"]);
                    $this->db->where("unit_price", $stock_history["unit_price"]);
                    $this->db->where("provider", $stock_history["provider"]);
                    $this->db->where("quantity", $stock_history["quantity"]);
                    $this->db->limit(1);
                    $this->db->update('stock_product', $quantityData);
                }
                //remote
            } else {
                $this->model_product->setCurrentDb($agency["id"]);
                $this->model_provider->setCurrentDb($agency["id"]);
                $slaveProduct = $this->model_product->getProductByMasterId($product_id);
                if ($delta < 0) {
                    //$this->model_product->updateQuantity($slaveProduct['id'], $delta, "up");
                    $slaveProvider = $this->model_provider->getProviderByMasterId($stock_history["provider"]);
                    if ($slaveProvider == NULL) {
                        $slaveProvider["id"] = 0;
                    }
                    $quantityData = array(
                        "quantity" => abs($delta),
                        "unit_price" => $stock_history["unit_price"],
                        "product" => $slaveProduct['id'],
                        "provider" => $slaveProvider["id"],
                    );
                    $this->model_product->accumulateQuantity($quantityData);
                    // add product to stock_history in local db
                    $quantityData = array(
                        "quantity" => $totalQuantity,
                    );
                    $this->db->where("id", $stock_history["id"]);
                    $this->db->update('stock_history', $quantityData);
                }else{
                    $this->setCurrentDb($agency["id"]);
                    $slaveProvider = $this->model_provider->getProviderByMasterId($stock_history["provider"]);
                    $this->model_product->updateQuantity($slaveProduct['id'], $delta);
                    $this->db->where("unit_price", $stock_history["unit_price"]);
                    $this->db->where("product", $slaveProduct["id"]);
                    $this->db->where("provider", $slaveProvider["id"]);
                    $this->db->limit(1);
                    $slaveQuantity=$this->db->get("quantity")->row_array();
                    $quantityData=array(
                        "quantity"=> $slaveQuantity["quantity"]-$delta
                    );
                    $this->db->where("unit_price", $stock_history["unit_price"]);
                    $this->db->where("product", $slaveProduct["id"]);
                    $this->db->where("provider", $slaveProvider["id"]);
                    $this->db->limit(1);
                    $this->db->update("quantity", $quantityData);

                    $this->setCurrentDb(0);
                    $this->db->where("id", $stock_history["id"]);
                    $this->db->update('stock_history', array("quantity"=> $totalQuantity));
                    $this->setCurrentDb($agency["id"]);
                }
                $this->model_product->setCurrentDb(0);
                $this->model_provider->setCurrentDb(0);

            }
    }


    public function addStockHistory($productsList, $type, $department = null)
    {
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

    public function getProductsHistory()
    {
        $this->db->select('sh.id as sh_id,p.id as p_id,p.name,a.name as a_name,p.name as p_name,sh.type,sh.quantity,sh.unit,sh.removal,p.min_quantity,p.totalQuantity,Date(sh.created_at) as date');
        $this->db->from('stock_history sh');
        $this->db->join('product p', 'p.id=sh.product');
        $this->db->join('agency a', 'a.id=sh.department', 'left');
        $this->db->where("sh.type","out");
        $this->db->where("sh.quantity>",0);
        $this->db->where("sh.destination","agency");
        $this->db->order_by("sh.created_at","desc");
        $result = $this->db->get();
        return $result->result_array();
    }

    public function setCurrentAgency($id){

        if($id==="1"){
            $id=0;
        }
        $this->setCurrentDb($id);
        $this->session->set_userdata('db',$id);
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