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

    public function addMagazin($magazin)
    {

        $this->db->insert('magazin', $magazin);
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
        $this->db->select('');
        $this->db->from('magazin');
        $this->db->where('department', $department);
        $this->db->where('id', $magazin);
        $magazinData = $this->db->get()->row_array();


        $this->db->select('*,sm.id as sm_id');
        $this->db->from('stock_meal sm');
        $this->db->join('meal m','m.id=sm.meal');
        $this->db->where('department', $department);
        $this->db->where('magazin', $magazin);
        $this->db->where('type', 'magazin');

        $mealsInMagazin = $this->db->get()->result_array();

        $magazinData['mealsList']= $mealsInMagazin;

        return $magazinData;
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
            $sm = $this->db->get('stock_meal');

            // metrre a jour l'article s'il existe déjà dans le magazin
            if ($sm->num_rows() > 0) {
                $meal = $sm->row_array();
                $quantityInMagazin = '';
                $quantityToSale = '';

                // si new qunaity
                if ($mealItem['magazinQuantityType']=="true") {
                    $quantityInMagazin = $mealItem['quantityInMagazin'];
                } else {
                    $quantityInMagazin = $meal['quantityInMagazin'] + $mealItem['quantityInMagazin'];
                }

                if ($mealItem['saleQuantityType']=="true") {
                    $quantityToSale = $mealItem['quantityToSale'];
                } else {
                    $quantityToSale = $meal['quantityToSale'] + $mealItem['quantityToSale'];
                }

                unset($mealItem['magazinQuantityType']);
                unset($mealItem['saleQuantityType']);
                $quantityStep1= $mealItem['quantityInMagazin'];
                $quantityStep2= $mealItem['quantityToSale'];
                $mealItem['quantityInMagazin']= $quantityInMagazin;
                $mealItem['quantityToSale']= $quantityToSale;

                $this->db->where('meal', $mealItem['id']);
                $this->db->where('magazin', $magazin['id']);
                $mealItem2= $mealItem;
                unset($mealItem['id']);
                $this->db->update('stock_meal', $mealItem);

                //Update stock only
                $this->consumption($mealItem2, $quantityStep1 + $quantityStep2,$magazin['department']);

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

                            if (!isset($todayConsumption)) {
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

        return $response;
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