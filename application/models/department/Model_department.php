<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_department extends CI_Model {

    public function getAll()
    {
        $result = $this->db->get('department');
        return $result->result_array();
    }
    public function getDepartment($id)
    {
        $this->db->where('id',$id);
        $result = $this->db->get('department');
        return $result->row_array();
    }




    public function addDepartment($department)
    {

        $this->db->insert('department', $department);
    } 
    
    public function addStock($stock)
    {

        //Faut enlever ce code
        $this->load->model('department/model_stock');
        $this->model_stock->addStock($stock);

    }

    // les articles prêts a etre vendu
    public function getReadyMeals($department){
        $this->db->select('c.quantity as consumption_quantity');
        $this->db->select('sm.id,sm.meal,m.name');
        $this->db->select('sum(quantityToSale) as quantityToSale');
        $this->db->select('sum(quantityInMagazin) as quantityInMagazin');
        $this->db->select('sum(sm.prepared_quantity) as prepared_quantity');
        $this->db->select('sum(sm.lost_quantity) as lost_quantity');
        $this->db->from('stock_meal sm');
        $this->db->join('meal m','sm.meal=m.id');
        $this->db->join('consumption c','c.meal=m.id and c.type="sale"',"left");
        $this->db->where('department',$department);
        $this->db->where('c.report_date', date('Y-m-d'));
        $this->db->where('Date(sm.created_at)',date('Y-m-d'));
        $this->db->group_by('sm.meal');
        return $this->db->get()->result_array();
    }
    public function backToStock($stock){
        $this->db->where('id', $stock["id"]);
        $db_stock= $this->db->get("stock_meal")->row_array();
        $data=array(
            "quantityToSale"=> 0,
            "quantityInMagazin"=> $db_stock["quantityInMagazin"]+$stock["quantity"],
        );

        $this->db->where('id', $stock["id"]);
        $this->db->update("stock_meal",$data);

    }
    public function getMealsHistory($department){
        $this->db->select('sm.meal,m.name, Date(sm.created_at) as date');
        $this->db->select('c.quantity as consumption_quantity');
        $this->db->select('sm.id,sm.meal,m.name');
        $this->db->select('sum(quantityToSale) as quantityToSale');
        $this->db->select('sum(quantityInMagazin) as quantityInMagazin');
        $this->db->select('sum(sm.prepared_quantity) as prepared_quantity');
        $this->db->select('sum(sm.lost_quantity) as lost_quantity');
        $this->db->from('stock_meal sm');
        $this->db->join('meal m', 'sm.meal=m.id');
        $this->db->join('consumption c', 'c.meal=m.id and c.type="sale"', "left");
        //$this->db->where('c.report_date', "Date(sm.created_at)");
        $this->db->where('department', $department);
        $this->db->group_by('Date(sm.created_at),meal');
        return $this->db->get()->result_array();
    }


    public function mealsPrepared($mealsList,$department)
    {
        // creation du magzin par default si le magazin par default n existe pas
        $defaultMagazin = $this->createDefaultMagazin($department);

        foreach ($mealsList as $key=> $meal) {
            // Si l utilisateur n as pas choisi un magazin, on met notre magazin par default
            if (!isset($meal['magazin'])) {
                $meal['magazin'] = $defaultMagazin;
            }
            $this->db->where('meal', $meal['meal']);
            $this->db->where('department', $department);
            $this->db->where('magazin', $meal['magazin']);
            $this->db->where('Date(created_at)', date('Y-m-d'));
            $db_meal = $this->db->get('stock_meal')->row_array();


            // update stock quantity
            if ($db_meal) {
                $dataMeal = array(
                    'quantityInMagazin' => $db_meal['quantityInMagazin']+$meal['quantityInMagazin'],
                    'quantityToSale' => $db_meal['quantityToSale']+ $meal['quantityToSale']
                );
                $dataMeal["prepared_quantity"]= $dataMeal["quantityInMagazin"]+$dataMeal['quantityToSale'];
                $this->db->where('meal', $meal['meal']);
                $this->db->where('department', $department);
                $this->db->where('magazin', $meal['magazin']);
                $this->db->update('stock_meal', $dataMeal);
            }else{
                $dataMeal=array(
                    'meal'=> $meal['meal'],
                    'department'=> $department,
                    'magazin'=> $meal['magazin'],
                    'quantityInMagazin'=> $meal['quantityInMagazin'],
                    'quantityToSale'=> $meal['quantityToSale'],
                    'prepared_quantity'=> $meal['quantityToSale']+ $meal['quantityInMagazin']
                );
                $this->db->insert('stock_meal', $dataMeal);
            }
            //Update stock only
            $meal['id'] = $meal['meal'];
            $mealsList[$key]['id'] = $meal['meal'];
            if(false){
              // consommer les produits du département courant
                $this->consumption($meal, $meal['quantityInMagazin'] + $meal['quantityToSale'], $department);
            }
        }

        if(true){
            //Normal procedure
            // consommation de l article=> update prepared quantity
            $this->consumptionMeal($mealsList);
        }
    }
    public function createDefaultMagazin($department){
        $this->db->where('name','default');
        $this->db->where('department', $department);
        $result=$this->db->get('magazin');
        $id=0;
        if ($result->num_rows() == 0) {
            $magazinData=array(
                'name'=>'default',
                'department'=> $department
            );
            $id = $this->db->insert('magazin', $magazinData);
        }else{
            $id=$result->result_array()[0]["id"];
        }
        return $id;

    }

    public function addMagazin($magazin)
    {
        $this->db->insert('magazin', $magazin);
    }

    public function getMagazinByDepartment($department)
    {
        $this->db->select('');
        $this->db->from('magazin');
        if($department!=="0")
        $this->db->where('department', $department);
        $this->db->where('name != "default" ');
        $magazins = $this->db->get()->result_array();

        return $magazins;
    }


    public function getMagazinsWithMeals($department){
        $this->db->select('');
        $this->db->from('magazin');
        $this->db->where('department', $department);
        $magazins = $this->db->get()->result_array();


        $this->db->select('*,sm.id as sm_id');
        $this->db->from('stock_meal sm');
        $this->db->join('meal m','m.id=sm.meal');
        $this->db->where('department', $department);
        $this->db->where('type', 'magazin');
        $this->db->where('quantityInMagazin>',0 );
        $this->db->where('Date(sm.created_at)', Date('Y-m-d'));

        $mealsInMagazin = $this->db->get()->result_array();

        foreach ($magazins as $key => $magazin) {
            $mealsList = array();
            foreach ($mealsInMagazin as $mealInMagazin) {
                if ($magazin['id'] === $mealInMagazin['magazin']) {
                    array_push($mealsList, $mealInMagazin);
                }
            }
            $magazins[$key]['mealsList'] = $mealsList;
        }

        return $magazins;
    }


    //getting meal in stock for spécific magazin
    public function getMagazinWithMeals($department,$magazin){

        $this->updateLastStockQuantity($department, $magazin);
        $this->db->select('');
        $this->db->from('magazin');
        $this->db->where('department', $department);
        $this->db->where('id', $magazin);
        $magazinData = $this->db->get()->row_array();


        $this->db->select('*,sm.id as sm_id,c.quantity as c_quantity,sm.prepared_quantity as sm_prepared_quantity');
        $this->db->from('stock_meal sm');
        $this->db->join('meal m','m.id=sm.meal');
        $this->db->join('consumption c','m.id=c.meal');
        $this->db->where('department', $department);
        $this->db->where('magazin', $magazin);
        $this->db->where('sm.type', 'magazin');
        $this->db->where('quantityInMagazin>', 0);
        $this->db->where('Date(sm.created_at)', Date('Y-m-d'));

        $mealsInMagazin = $this->db->get()->result_array();

        $magazinData['mealsList']= $mealsInMagazin;

        return $magazinData;
    }

    public function updateLastStockQuantity($department, $magazin){
        $this->db->select('*');
        $this->db->select('quantityInMagazin');
        $this->db->from('stock_meal');
        $this->db->where('department', $department);
        $this->db->where('magazin', $magazin);
        $this->db->where('Date(created_at)<', Date('Y-m-d'));
        $this->db->where('status', "current");
        $this->db->group_by('meal');
        $stocks=$this->db->get()->result_array();

        $this->db->select('id');
        $this->db->from('stock_meal');
        $this->db->where('department', $department);
        $this->db->where('magazin', $magazin);
        $this->db->where('Date(created_at)', Date('Y-m-d'));
        $todayStock = $this->db->get()->result_array();
        if(!$todayStock){
            foreach ($stocks as $stock) {
                $data = array(
                    'meal' => $stock['meal'],
                    'department' => $department,
                    'magazin' => $magazin,
                    'quantityInMagazin' => $stock['quantityInMagazin'],
                    'quantityToSale' => 0,
                    'lastStockQuantity' => $stock['quantityInMagazin'],
                );
                if($stock['meal']){
                    $this->db->insert('stock_meal', $data);
                }
                $this->db->where('Date(created_at)<', Date('Y-m-d'));
                $this->db->update("stock_meal",array("status"=>"old"));
            }

        }
    }


    //getting product in stock
    public function getProducts($department){

        $this->db->select('*');
        $this->db->select('sum(sp.quantity) as s_quantity');
        $this->db->from('stock_product sp');
        $this->db->join('product p','sp.product=p.id');
        $this->db->where('department', $department);
        $this->db->group_by('sp.product');
        $products = $this->db->get()->result_array();

        return $products;
    }

    public function updateMagazin($magazin){

        // modifier les informations de base d'un magazin
        $dataMagazin=array(
            'name'=> $magazin['name']
        );
        $this->db->where('id', $magazin['id']);
        $this->db->update('magazin', $dataMagazin);

        // modifier les articles d'un magazin
        foreach ($magazin['mealsList'] as $mealItem) {

            $this->db->where('meal', $mealItem['id']);
            $this->db->where('magazin', $magazin['id']);
            $this->db->where('date(created_at)', date("Y-m-d"));
            $sm = $this->db->get('stock_meal');

            // metrre a jour l'article s'il existe déjà dans le magazin
            if ($sm->num_rows() > 0) {
                $meal = $sm->row_array();
                $quantityInMagazin = '';
                $quantityToSale = '';

                // si new quantity
                /*if ($mealItem['magazinQuantityType']=="true") {
                    $quantityInMagazin = $mealItem['quantityInMagazin'];
                } else {
                    $quantityInMagazin = $meal['quantityInMagazin'] + $mealItem['quantityInMagazin'];
                }

                if ($mealItem['saleQuantityType']=="true") {
                    $quantityToSale = $mealItem['quantityToSale'];
                } else {
                    $quantityToSale = $meal['quantityToSale'] + $mealItem['quantityToSale'];
                }*/

                /*******************New conception***************************/
                //if($meal['quantityInMagazin']>0) : l'article est affiché dans le magzin
                // la quantité mise en vente sera retranché de la quantité en stock

                // if not: l'article n'est pas affiché ds le magazin, c'est comme si on va créer un article ds le magazin
                // on va recevoir la quantité de stock, et la quantité mise pour la vente
                if($mealItem['quantityToSale']<0){
                    $mealItem['quantityToSale']=0;
                }
                if($meal['quantityInMagazin']>0){
                    $quantityInMagazin = $meal['quantityInMagazin'] - $mealItem['quantityToSale'];
                    $quantityToSale = $meal['quantityToSale'] + $mealItem['quantityToSale'];
                }else{
                    $quantityInMagazin = $mealItem['quantityInMagazin'];
                    $quantityToSale = $meal['quantityToSale'] + $mealItem['quantityToSale'];
                }
                /************************************************************/

                unset($mealItem['magazinQuantityType']);
                unset($mealItem['saleQuantityType']);
                $quantityStep1= $mealItem['quantityInMagazin'];
                $quantityStep2= $mealItem['quantityToSale'];
                $mealItem['quantityInMagazin']= $quantityInMagazin;
                $mealItem['quantityToSale']= $quantityToSale;
                //$mealItem['prepared_quantity']= $quantityToSale+$quantityInMagazin;

                $this->db->where('meal', $mealItem['id']);
                $this->db->where('magazin', $magazin['id']);
                $mealItem2= $mealItem;
                unset($mealItem['id']);
                // delete meal from magazin if quantity is 0
                if ($quantityInMagazin > 0) {
                   /* $this->db->where('Date(created_at)', Date('Y-m-d'));
                    $this->db->update('stock_meal', $mealItem);*/
                } else {
                    /*$this->db->where('meal', $mealItem2['id']);
                    $this->db->where('department', $magazin['department']);
                    $this->db->where('magazin', $magazin['id']);
                    $this->db->delete('stock_meal');*/
                }
                $this->db->where('Date(created_at)', Date('Y-m-d'));
                $this->db->update('stock_meal', $mealItem);

            } else {

                $dataMeal=array(
                  'meal'=> $mealItem['id'],
                  'magazin'=> $magazin['id'],
                  'department'=> $magazin['department'],
                  'quantityInMagazin'=> $mealItem['quantityInMagazin'],
                  'quantityToSale'=> $mealItem['quantityToSale'],
                );

                $this->db->insert('stock_meal', $dataMeal);

                //Update stock only
                $this->consumption($mealItem, $mealItem['quantityInMagazin'] + $mealItem['quantityToSale'], $magazin['department']);
            }
        }


        //Normal procedure
        $this->consumptionMeal($magazin['mealsList']);

    }

    public function consumption($meal,$quantity,$department){
        $this->load->model('department/model_stock');

        $this->db->select('*,mp.quantity as mp_quantity,p.id as p_id');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product = p.id');
        $this->db->join('quantity q', 'q.product = p.id');
        $this->db->where('q.status', 'active');
        $this->db->where('mp.status', 'current');
        $this->db->where('mp.meal', $meal['id']);

        //list of products that make up a meal
        $m_products = $this->db->get()->result_array();

        foreach ($m_products as $m_product) {
            $m_product['department']= $department;
            $this->model_stock->updateQuantity($m_product, $m_product['mp_quantity'] * $m_product['unitConvert'] * $quantity);
        }

    }


    public function consumptionMeal($mealList, $lost = false)
    {
        $this->load->model('model_product');
        $this->load->model('model_report');
        $this->load->model('model_meal');
        //consomation des produits
        $consumptionProducts=false;
        $response = array();
        $response['status'] = "success";
        $productsErrorList = array();
        $response['productsList'] = "";

        foreach ($mealList as $meal) {

            $meal['date'][0]= date('Y-m-d');
            $meal['quantity']=$meal['quantityInMagazin']+ $meal['quantityToSale'];
            // vente d'un article par date
            $todayConsumption = $this->model_report->reportMealDate($meal['id'], $meal['date'][0]);
            $db_meal=$this->model_meal->get($meal['id']);

            /******************A revoir******************/
            $consumption_type = "sale";
            if ($lost) {
                $consumption_type = "lost";
            }
            //$consumption_type="prepared";
            /*********************************************/
            $data = array(
                'meal' => $meal['id'],
                'prepared_quantity' => $meal['quantity'],
                'report_date' => $meal['date'][0],
                'type' => $consumption_type,
            );
            $consumption_id = 0;
            $quantityStep = $meal['quantity'];

            // si la vente de date existe
            if ($todayConsumption) {
                //$meal['quantity'] : quantité envoyé par le rapport de vente,
                // la quantité de vente augement a chaque interval de temps
                //$todayConsumption['quantity'] : quantité de la base de donnée

                $data['prepared_quantity']= abs($meal['quantity'] + $todayConsumption['prepared_quantity']);
                $this->db->where('id', $todayConsumption['id']);
                $this->db->update('consumption', $data);
                // si la vente du jour n'existe pas on va la créer simplement
            } else {
                $this->db->insert('consumption', $data);
                $consumption_id = $this->db->insert_id();
            }


            $this->db->select('*,mp.quantity as mp_quantity,p.id as p_id');
            $this->db->from('meal_product mp');
            $this->db->join('product p', 'mp.product = p.id');
            $this->db->join('quantity q', 'q.product = p.id');
            $this->db->where('q.status', 'active');
            $this->db->where('mp.status', 'current');
            $this->db->where('mp.meal', $meal['id']);

            //list of products that make up a meal
            $m_products = $this->db->get()->result_array();

            if($consumptionProducts){
                foreach ($m_products as $m_product) {

                    //$m_products['product'] : produit's id
                    //$m_products['quantity'] : the amount of the product in the meal
                    //$meal['quantity'] : quantity of the meal
                    //$m_product['unitConvert']: conversion du Kg vers gr ou mg ..

                    // update reduce the amount of a product's stock after consumption the meal
                    if ($m_product['totalQuantity'] > $m_product['mp_quantity'] * $m_product['unitConvert'] * $meal['quantity'] or true) {
                        if ($response['status'] === "success") {
                            if ($consumption_id === 0) {
                                $consumption_id = $todayConsumption['id'];
                            }
                            $consumption_type = "sale";
                            if ($lost) {
                                $consumption_type = "lost";
                            }


                            $l_reponse = $this->model_product->updateLocalQuantity($m_product['product'], $m_product['mp_quantity'] * $m_product['unitConvert'] * $quantityStep);
                            foreach ($l_reponse['quantities'] as $quantity) {
                                // il faut modifier ces donnée pour prendre en considération l'utilisation de plusieurs quantités
                                // l'ajout de consommation des produits doit etre fait apres la reduction de quantités produits
                                // on renvoie la liste des  produit utilisé et on les insère dans la table consomation produit
                                $consumption_product = array(
                                    'consumption' => $consumption_id,
                                    'meal' => $meal['id'],
                                    'product' => $m_product['p_id'],
                                    'quantity' => abs($quantity['quantity']),
                                    'unit_price' => $quantity['unit_price'],
                                    'total' => abs($quantity['quantity']) * $quantity['unit_price'],
                                    'type' => $consumption_type
                                );

                                $this->db->where('consumption', $consumption_id);
                                $this->db->where('meal', $meal['id']);
                                $this->db->where('product', $m_product['p_id']);
                                $this->db->where('type', "sale");
                                $this->db->where('unit_price', $quantity['unit_price']);
                                $this->db->where('quantity>', 0);
                                $q = $this->db->get("consumption_product");

                                if ($q->num_rows() > 0) {
                                    $my_quantity = $q->row_array();
                                    $consumption_product["quantity"] += $my_quantity["quantity"];
                                    $consumption_product["total"] += $my_quantity["quantity"];
                                    $this->db->where('consumption', $consumption_id);
                                    $this->db->where('meal', $meal['id']);
                                    $this->db->where('product', $m_product['p_id']);
                                    $this->db->where('type', "sale");
                                    $this->db->where('unit_price', $quantity['unit_price']);
                                    $this->db->update('consumption_product', $consumption_product);
                                } else {
                                    $this->db->insert('consumption_product', $consumption_product);
                                }
                            }
                        }
                    } else {
                        $response['status'] = "error";
                        $productsErrorList[] = $m_product;
                    }
                    $response['productsList'] = $productsErrorList;
                }
            }
        }

        return $response;
    }

    public function addLostQuantity($meal){
        $this->db->where("report_date",$meal["report_date"]);
        $this->db->where("type","lost");
        $this->db->where("meal",$meal["meal_id"]);
        $consumptionProducts=true;
        $consumption_type="lost";
        $consumption_id=0;
        $result=$this->db->get("consumption");
        if ($result->num_rows() == 0) {
            $lostData = array(
                'meal' => $meal["meal_id"],
                'quantity' => $meal["quantity"],
                'report_date' => $meal["report_date"],
                'amount' => 0,
                'total' => 0,
                'type' => "lost",
            );
            $this->db->insert('consumption', $lostData);
            $consumption_id = $this->db->insert_id();
        } else {
            $consumption_id= $result->result_array()[0]["id"];
            $lostData = array(
                'quantity' => $meal["quantity"],
            );
            $this->db->where("report_date", $meal["report_date"]);
            $this->db->where("type", "lost");
            $this->db->where("meal", $meal["meal_id"]);
            $this->db->update('consumption', $lostData);
        }

        $this->consumptionProducts($meal, $consumption_id, $consumption_type, $consumptionProducts);

        $this->db->where("Date(created_at)",$meal["report_date"]);
        $this->db->where("meal",$meal["meal_id"]);
        $this->db->update("stock_meal",array("quantityInMagazin"=>0,"quantityToSale"=>0,"lost_quantity"=> $meal["quantity"]));

    }

    public function consumptionProducts($meal, $consumption_id, $consumption_type="sale", $consumptionProducts=true){
        $this->db->select('*,mp.quantity as mp_quantity,p.id as p_id');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product = p.id');
        $this->db->join('quantity q', 'q.product = p.id');
        $this->db->where('q.status', 'active');
        $this->db->where('mp.status', 'current');
        $this->db->where('mp.meal', $meal['meal_id']);

        //list of products that make up a meal
        $m_products = $this->db->get()->result_array();

        if ($consumptionProducts) {
            foreach ($m_products as $m_product) {

                //$m_products['product'] : produit's id
                //$m_products['quantity'] : the amount of the product in the meal
                //$meal['quantity'] : quantity of the meal
                //$m_product['unitConvert']: conversion du Kg vers gr ou mg ..

                // update reduce the amount of a product's stock after consumption the meal
                if ($m_product['totalQuantity'] > $m_product['mp_quantity'] * $m_product['unitConvert'] * $meal['quantity'] or true) {
                    $this->model_product->updateQuantity($m_product['product'], $m_product['mp_quantity'] * $m_product['unitConvert'] * $meal['quantity']);
                    $l_reponse = $this->model_product->updateLocalQuantity($m_product['product'], $m_product['mp_quantity'] * $m_product['unitConvert'] * $meal['quantity']);
                    foreach ($l_reponse['quantities'] as $quantity) {
                        // il faut modifier ces donnée pour prendre en considération l'utilisation de plusieurs quantités
                        // l'ajout de consommation des produits doit etre fait apres la reduction de quantités produits
                        // on renvoie la liste des  produit utilisé et on les insère dans la table consomation produit
                        $consumption_product = array(
                            'consumption' => $consumption_id,
                            'meal' => $meal['meal_id'],
                            'product' => $m_product['p_id'],
                            'quantity' => abs($quantity['quantity']),
                            'unit_price' => $quantity['unit_price'],
                            'total' => abs($quantity['quantity']) * $quantity['unit_price'],
                            'type' => $consumption_type
                        );

                        $this->db->where('consumption', $consumption_id);
                        $this->db->where('meal', $meal['meal_id']);
                        $this->db->where('product', $m_product['p_id']);
                        $this->db->where('type', "lost");
                        $this->db->where('unit_price', $quantity['unit_price']);
                        $this->db->where('quantity>', 0);
                        $q = $this->db->get("consumption_product");

                        if ($q->num_rows() > 0) {
                            $my_quantity = $q->row_array();
                            $consumption_product["quantity"] += $my_quantity["quantity"];
                            $consumption_product["total"] += $my_quantity["quantity"];
                            $this->db->where('consumption', $consumption_id);
                            $this->db->where('meal', $meal['meal_id']);
                            $this->db->where('product', $m_product['p_id']);
                            $this->db->where('type', "lost");
                            $this->db->where('unit_price', $quantity['unit_price']);
                            $this->db->update('consumption_product', $consumption_product);
                        } else {
                            $this->db->insert('consumption_product', $consumption_product);
                        }
                    }
                }
            }
        }
    }
    public function editDepartment($id, $department){
        $this->db->where('id',$id);
        $this->db->update('department', $department);
    }

    public function deleteMealFromMagazin($id){
        $this->db->where('id',$id);
        $this->db->delete('stock_meal');
    }

    public function deleteDepartment($provider_id)
    {
        $this->db->where('id', $department_id);
        $this->db->delete('department');
    }

}