<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_report extends CI_Model
{

    public function report($params = null)
    {
        //regular report: used in table in admin/report/index
        if (!$params) {

           //meal consumption
            $this->db->select('*');
            $this->db->select('sum(c.quantity) as s_quantity');
            $this->db->select('sum(c.quantity)*c.amount as s_amount');
            $this->db->select('sum(c.quantity)*profit as s_profit');
            $this->db->select('sum(c.prepared_quantity) as prepared_quantity');
            $this->db->from('meal m');
            $this->db->where('c.type', 'sale');
            $this->db->join('consumption c', 'm.id = c.meal');
            $this->db->group_by('c.meal');
            $meals = $this->db->get()->result_array();

            //Total cost by meal
            $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
            $this->db->select('c.meal');
            $this->db->from('meal m');
            $this->db->join('consumption c', 'm.id = c.meal');
            $this->db->join('consumption_product cp', 'c.id = cp.consumption','left');
            $this->db->where('c.type', 'sale');
            $this->db->group_by('c.meal');
            $products = $this->db->get()->result_array();

            //add cost to meal consumption
            foreach ($meals as $key => $val) {
                $val2 = '0';

                if(isset($products[$key]) and $products[$key]['meal']===$val['meal']){
                    $val2= $products[$key];
                    if ($val["sellPrice"] === "0.00") {
                        $val2['s_cost']= $val2['s_cost']*$val['s_quantity'];
                    }
                    if($val2['s_cost']==''){
                        $val2['s_cost']='0';
                    }
                }
                $meals[$key]['s_cost'] = $val2['s_cost'];
            }
            return $meals;
        } else {//custom report


            $this->db->select('*');
            $this->db->select('sum(c.quantity) as s_quantity');
            $this->db->select('sum(c.quantity)*c.amount as s_amount');
            $this->db->select('sum(c.quantity)*profit as s_profit');
            $this->db->from('meal m');
            $this->db->join('consumption c', 'm.id = c.meal');
            $this->db->where('c.type', 'sale');
            if ($params['sort']) {

            }
            if ($params['max']) {
                $this->db->limit($params['max'], 0);
            }

            $this->db->group_by('c.meal');
            $meals = $this->db->get()->result_array();

            $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
            $this->db->select('c.meal');
            $this->db->from('meal m');
            $this->db->join('consumption c', 'm.id = c.meal');
            $this->db->join('consumption_product cp', 'c.id = cp.consumption', 'left');
            $this->db->where('c.type', 'sale');
            $this->db->group_by('c.meal');
            $products = $this->db->get()->result_array();
            if ($params['max']) {
                $this->db->limit($params['max'], 0);
            }

            foreach ($meals as $key => $val) {
                $val2 = '0';

                if (isset($products[$key]) and $products[$key]['meal'] === $val['meal']) {
                    $val2 = $products[$key];
                    if ($val["sellPrice"] === "0.00") {
                        $val2['s_cost'] = $val2['s_cost'] * $val['s_quantity'];
                    }
                    if ($val2['s_cost'] == '') {
                        $val2['s_cost'] = '0';
                    }
                }
                $meals[$key]['s_cost'] = $val2['s_cost'];
            }

            if ($params['sort']) {
                function cmp($a, $b)
                {
                    return $a['amount']-$b['amount'];
                }
                usort($meals, "cmp");
            }


            return $meals;
        }
    }

    public function global_report($startDate=null, $endDate=null){
        $global=array();


        //all sales amount
        $this->db->select('*');
        $this->db->select('sum(c.quantity) as s_quantity');
        $this->db->select('sum(c.amount) as s_amount');
        $this->db->select('sum(c.total) as turnover');
        $this->db->from('consumption c');
        $this->db->where('c.type','sale');
        if($startDate){
            $this->db->where('c.report_date>=', $startDate);
            $this->db->where('c.report_date<=', $endDate);
        }
        $consumption = $this->db->get()->row_array();

        //costs
        $this->db->select('cp.*');
        $this->db->select('sum(cp.unit_price) as s_price');
        $this->db->select('sum(cp.quantity) as s_quantity');
        $this->db->select('sum(cp.total) as s_cost');
        $this->db->from('consumption_product cp');
        $this->db->join('consumption c',"c.id=cp.consumption");
        $this->db->where('cp.type', 'sale');
        if ($startDate) {
            $this->db->where('c.report_date>=', $startDate);
            $this->db->where('c.report_date<=', $endDate);
        }
        $consumption_product = $this->db->get()->row_array();

        //Sales history
        $this->db->select('report_date');
        $this->db->select('sum(c.total) as s_amount');
        $this->db->from('consumption c');
        $this->db->where('c.type', 'sale');
        if ($startDate) {
            $this->db->where('c.report_date>=', $startDate);
            $this->db->where('c.report_date<=', $endDate);
        }
        $this->db->group_by('report_date');
        $this->db->order_by('report_date',"desc");
        $this->db->limit(20);
        $sales_history = $this->db->get()->result_array();//Sales history
        $sales_history= array_reverse($sales_history);

        $this->db->select('sum(sh.total) as price');
        $this->db->from('stock_history sh');
        $this->db->where('sh.type', 'in');
        if ($startDate) {
            $this->db->where('date(created_at)>=', $startDate);
            $this->db->where('date(created_at)<=', $endDate);
        }
        $stock_history = $this->db->get()->row_array();


        //Sales history by month
        $this->db->select('report_date');
        $this->db->select('sum(c.total) as s_amount');
        $this->db->from('consumption c');
        $this->db->where('c.type', 'sale');
        if ($startDate) {
            $this->db->where('c.report_date>=', $startDate);
            $this->db->where('c.report_date<=', $endDate);
        }
        $this->db->group_by('MONTH(report_date)');
        $this->db->order_by('report_date', 'DESC');
        $this->db->limit(10);
        $sales_history_month = $this->db->get()->result_array();

        //products costs
        $this->db->select('p.name');
        $this->db->select('sum(cp.total) as s_cost');
        $this->db->select('count(cp.product) as s_meal');
        $this->db->from('consumption_product cp');
        $this->db->join('consumption c',"c.id=cp.consumption");
        $this->db->where('cp.type', 'sale');
        if ($startDate) {
            $this->db->where('c.report_date>=', $startDate);
            $this->db->where('c.report_date<=', $endDate);
        }
        $this->db->join('product p','p.id=cp.product');
        $this->db->group_by('product');
        $this->db->order_by('s_cost','DESC');
        $this->db->limit(5);
        $products_cost = $this->db->get()->result_array();



        $this->db->select('sum(price) as price');
        if ($startDate) {
            $this->db->where('date(created_at)>=', $startDate);
            $this->db->where('date(created_at)<=', $endDate);
        }
        $purchase = $this->db->get('purchase')->row_array();

        $this->db->select('sum(price) as price');
        if ($startDate) {
            $this->db->where('date(created_at)>=', $startDate);
            $this->db->where('date(created_at)<=', $endDate);
        }
        $repair = $this->db->get('reparation')->row_array();

        $this->db->select('sum(salary) as salary');
        if ($startDate) {
            $this->db->where('date(paymentDate)>=', $startDate);
            $this->db->where('date(paymentDate)<=', $endDate);
        }
        $this->db->where('paid', "true");
        $salary = $this->db->get('salary')->row_array();


        $global['consumption']= $consumption;
        $global['cp']= $consumption_product;
        $global['sales_history']= $sales_history;
        $global['products_cost']= $products_cost;
        $global['sales_history_month']= $sales_history_month;
        $global['purchase']= $purchase;
        $global['repair']= $repair;
        $global['salary']= $salary;
        $global['stock_history']= $stock_history;
        $global["charges"]= $global['stock_history']['price'] + $global['purchase']['price'] + $global['repair']['price'] + $global['salary']['salary'];


        return $global;
    }

    public function reportById($meal_id,$startDate=null,$endDate=null)
    {
        $this->db->select('*');
        $this->db->select('sum(c.quantity) as s_quantity');
        $this->db->select('COUNT(DISTINCT DATE_FORMAT(c.createdAt, \'%Y-%m-%d\')) as days');
        $this->db->select('sum(c.prepared_quantity) as prepared_quantity');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->where('m.id', $meal_id);
        $this->db->where('c.type', 'sale');
        if($startDate){
            $this->db->where('DATE(c.report_date) >=', $startDate);
            $this->db->where('DATE(c.report_date) <=', $endDate);
        }
        $this->db->group_by('c.meal');
        $report = $this->db->get()->row_array();

        //Total cost by meal
        $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
        $this->db->from('consumption c');
        $this->db->join('consumption_product cp', 'c.id = cp.consumption', 'left');
        $this->db->where('c.meal', $meal_id);
        $this->db->where('cp.type', 'sale');
        if ($startDate) {
            $this->db->where('DATE(c.report_date) >=', $startDate);
            $this->db->where('DATE(c.report_date) <=', $endDate);
        }
        $s_cost = $this->db->get()->row()->s_cost;

        $report['s_cost']=$s_cost;


        $this->db->select('sum(c.quantity) as s_lost');
        $this->db->from('consumption c');
        $this->db->where('c.meal', $meal_id);
        $this->db->where('c.type', 'lost');
        if ($startDate) {
            $this->db->where('DATE(c.report_date) >=', $startDate);
            $this->db->where('DATE(c.report_date) <=', $endDate);
        }
        $s_lost = $this->db->get()->row()->s_lost;


        $report['s_lost'] = $s_lost;


        $report['mealConsumptionRate'] = $this->mealConsumptionRate($meal_id,$startDate,$endDate);
        $report['totalPrice'] = $report['mealConsumptionRate']['totalPrice'];
        $report['totalConsumptionQuantity'] = $report['mealConsumptionRate']['totalQuantity'];
        unset($report['mealConsumptionRate']['totalPrice']);
        unset($report['mealConsumptionRate']['totalQuantity']);

       /* $s_quantity = 0;
        if (!empty($report)) {
            $s_quantity = array_sum(array_column($report, 'c_quantity'));
        }
        $report['s_quantity'] = $s_quantity;*/
        return $report;
    }

    public function evolution($meal_id)
    {
        $this->db->select('*,Date(c.report_date) as rd');
        $this->db->select('sum(c.quantity) as s_quantity');
        $this->db->select('sum(c.quantity)*amount as s_amount');
        $this->db->select('COUNT(DISTINCT DATE_FORMAT(c.createdAt, \'%Y-%m-%d\')) as days');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->where('m.id', $meal_id);
        $this->db->where('c.type', 'sale');
        $this->db->order_by('c.report_date', 'ASC');
        $this->db->group_by('rd');
        $evolution =  $this->db->get()->result_array();


        // Set cost by day
        $products= $this->costByDay($meal_id);
        foreach ($evolution as $key => $val) {
            $val2 = '0';

            if (isset($products[$key]) and $products[$key]['meal'] === $val['meal']) {
                $val2 = $products[$key];
                if ($val["sellPrice"] === "0.00") {
                    $val2['s_cost'] = $val2['s_cost'] * $val['s_quantity'];
                }
                if ($val2['s_cost'] == '') {
                    $val2['s_cost'] = '0';
                }
            }
            $evolution[$key]['s_cost'] =
                $val2['s_cost'];
        }

        //Total cost by meal
        $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
        $this->db->from('consumption c');
        $this->db->join('consumption_product cp', 'c.id = cp.consumption', 'left');
        $this->db->where('c.meal', $meal_id);
        $this->db->where('cp.type', 'sale');
        $s_cost = $this->db->get()->row()->s_cost;
        $evolution['s_cost'] = $s_cost;


        return $evolution;
    }

    private function costByDay($meal_id){
        $this->db->select('Date(c.report_date) as rd');
        $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
        $this->db->select('c.meal');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->join('consumption_product cp', 'c.id = cp.consumption', 'left');
        $this->db->where('c.meal', $meal_id);
        $this->db->where('c.type', 'sale');
        $this->db->order_by('c.report_date', 'ASC');
        $this->db->group_by('rd');
        $products = $this->db->get()->result_array();
        return $products;
    }

    private function costRange($meal_id, $startDate, $endDate){
        $this->db->select('Date(c.report_date) as rd');
        $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
        $this->db->select('c.meal');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->join('consumption_product cp', 'c.id = cp.consumption', 'left');
        $this->db->where('c.meal', $meal_id);
        $this->db->where('c.type', 'sale');
        $this->db->where('DATE(c.report_date) >=', $startDate);
        $this->db->where('DATE(c.report_date) <=', $endDate);
        $this->db->order_by('c.report_date', 'ASC');
        $this->db->group_by('rd');
        $products = $this->db->get()->result_array();
        return $products;
    }

    public function evolutionRange($meal_id, $startDate, $endDate)
    {
        $this->db->select('*,Date(c.report_date) as rd,c.quantity as c_quantity');
        $this->db->select('sum(c.quantity) as s_quantity');
        $this->db->select('sum(c.quantity)*amount as s_amount');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->where('m.id', $meal_id);
        $this->db->where('c.type', 'sale');
        $this->db->where('DATE(c.report_date) >=', $startDate);
        $this->db->where('DATE(c.report_date) <=', $endDate);
        //$this->db->order_by('c.createdAt', 'ASC');
        $this->db->group_by('rd');

        $evolution = $this->db->get()->result_array();



        // Set cost by day
        $products = $this->costRange($meal_id, $startDate, $endDate);
        foreach ($evolution as $key => $val) {
            $val2 = '0';

            if (isset($products[$key]) and $products[$key]['meal'] === $val['meal']) {
                $val2 = $products[$key];
                if ($val["sellPrice"] === "0.00") {
                    $val2['s_cost'] = $val2['s_cost'] * $val['s_quantity'];
                }
                if ($val2['s_cost'] == '') {
                    $val2['s_cost'] = '0';
                }
            }
            $evolution[$key]['s_cost'] =
                $val2['s_cost'];
        }

        //Total cost by meal
        $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
        $this->db->from('consumption c');
        $this->db->join('consumption_product cp', 'c.id = cp.consumption', 'left');
        $this->db->where('c.meal', $meal_id);
        $this->db->where('c.type', 'sale');
        $s_cost = $this->db->get()->row()->s_cost;

        $evolution['s_cost'] = array_sum(array_column($evolution, "s_cost"));;
        $evolution['s_total'] = array_sum(array_column($evolution,"total"));
        $evolution['s_quantity'] = array_sum(array_column($evolution,"s_quantity"));
        //$evolution['s_cost'] = $s_cost;
        $evolution['mealConsumptionRateRange'] = $this->mealConsumptionRateRange($meal_id,$startDate,$endDate);

        return $evolution;
    }

    public function reportMealDate($meal_id, $date)
    {
        $this->db->select('*');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->where('m.id', $meal_id);
        $this->db->where('c.type', 'sale');
        $this->db->where('report_date =', $date);
        return $this->db->get()->row_array();
    }

    public function reportPreparedMealDate($meal_id, $date)
    {
        $this->db->select('*');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->where('m.id', $meal_id);
        $this->db->where('c.type', 'prepared');
        $this->db->where('report_date =', $date);
        return $this->db->get()->row_array();
    }

    public function reportRange($startDate, $endDate)
    {

        $this->db->select('*,m.id as m_id');
        $this->db->select('sum(c.quantity) as s_quantity');
        $this->db->select('sum(c.quantity)*c.amount as s_amount');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->where('c.report_date >=', $startDate);
        $this->db->where('c.report_date <=', $endDate);
        $this->db->where('c.type', 'sale');
        $this->db->group_by('c.meal');
        $meals = $this->db->get()->result_array();

        //Total cost by meal
        $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
        $this->db->select('c.meal');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->join('consumption_product cp', 'c.id = cp.consumption', 'left');
        $this->db->where('c.report_date >=', $startDate);
        $this->db->where('c.report_date <=', $endDate);
        $this->db->where('c.type', 'sale');
        $this->db->group_by('c.meal');
        $products = $this->db->get()->result_array();

        //add cost to meal consumption
        foreach ($meals as $key => $val) {
            $val2 = '0';

            if (isset($products[$key]) and $products[$key]['meal'] === $val['meal']) {
                $val2 = $products[$key];
                if ($val["sellPrice"] === "0.00") {
                    $val2['s_cost'] = $val2['s_cost'] * $val['s_quantity'];
                }
                if ($val2['s_cost'] == '') {
                    $val2['s_cost'] = '0';
                }
            }
            $meals[$key]['s_cost'] = $val2['s_cost'];
        }
        return $meals;
    }

    public function mealConsumptionRate($meal_id, $startDate, $endDate)
    {
        $this->db->select('*,avg(cp.unit_price) as avg_unit_price,sum(cp.quantity) as sum_quantity');
        $this->db->from('consumption_product cp');
        $this->db->join('product p', 'p.id=cp.product');
        $this->db->join('consumption c', 'c.id=cp.consumption');
        $this->db->group_by('cp.product');
        $this->db->group_by('cp.meal');
        $this->db->where('cp.meal', $meal_id);
        $this->db->where('cp.type', 'sale');
        if($startDate){
            $this->db->where('c.report_date >=', $startDate);
            $this->db->where('c.report_date <=', $endDate);
        }
        $mealConsumptionRate = $this->db->get()->result_array();
        $mealConsumptionTotal = 0; // total price
        $mealConsumptionTotalQuantity = 0; // total quantity
        if (!empty($mealConsumptionRate)) {
            $mealConsumptionTotal = array_sum(array_column($mealConsumptionRate, 'avg_unit_price')); // somme des prix moyen
            $quantitiesAvg = array_column($mealConsumptionRate, 'sum_quantity');// somme des quantitées
            $mealConsumptionTotalQuantity = array_sum($quantitiesAvg);
        }

        $mealConsumptionRate['totalPrice'] = $mealConsumptionTotal;
        $mealConsumptionRate['totalQuantity'] = $mealConsumptionTotalQuantity;
        return $mealConsumptionRate;
    }

    // a remplacer par la fonction ci-dessus
    public function mealConsumptionRateRange($meal_id, $startDate, $endDate)
    {
        $this->db->select('cp.*,p.*,avg(cp.unit_price) as avg_unit_price,sum(cp.quantity) as sum_quantity');
        $this->db->from('consumption_product cp');
        $this->db->join('product p', 'p.id=cp.product');
        $this->db->join('consumption c', 'c.id=cp.consumption');
        $this->db->group_by('cp.product');
        $this->db->group_by('cp.meal');
        $this->db->where('cp.meal', $meal_id);
        $this->db->where('c.report_date >=', $startDate);
        $this->db->where('c.report_date <=', $endDate);
        $this->db->where('c.type', 'sale');
        $mealConsumptionRate = $this->db->get()->result_array();
        $mealConsumptionTotal = 0;
        $mealConsumptionTotalQuantity = 0;
        if (!empty($mealConsumptionRate)) {
            $mealConsumptionTotal = array_sum(array_column($mealConsumptionRate, 'avg_unit_price'));
            $quantitiesAvg = array_column($mealConsumptionRate, 'sum_quantity');
            $mealConsumptionTotalQuantity = array_sum($quantitiesAvg);
        }

        $mealConsumptionRate['totalPrice'] = $mealConsumptionTotal;
        $mealConsumptionRate['totalQuantity'] = $mealConsumptionTotalQuantity;
        return $mealConsumptionRate;
    }

    public function add($meal)
    {
        $data = array(
            'name' => $meal['name'],
            'group' => $meal['group'],
            'cost' => $meal['cost'],
            'sellPrice' => $meal['sellPrice'],
            'profit' => $meal['profit'],
            'products_count' => 2,
        );
        $this->db->insert('meal', $data);
        $meal_id = $this->db->insert_id();
        $this->addProductsForMeal($meal_id, $meal['productsList']);
        return $meal_id;
    }

    public function addProductsForMeal($meal_id, $productsList)
    {

        foreach ($productsList as $product) {
            $data = array(
                'product' => $product['id'],
                'quantity' => $product['quantity'],
                'meal' => $meal_id,
            );
            $this->db->insert('meal_product', $data);
        }
    }

    public function getProducts($id)
    {
        $this->db->select('*');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product = p.id');
        $this->db->where('mp.meal', $id);

        $products = $this->db->get()->result_array();
        return $products;
    }

    public function getByExternalCode($externalCode)
    {
        $this->db->where('externalCode', $externalCode);
        $result = $this->db->get('meal');
        return $result->row_array();
    }

    public function consumption($mealList)
    {
        $this->load->model('model_product');
        foreach ($mealList as $meal) {
            $data = array(
                'meal' => $meal['externalCode'],
                'amount' => $meal['amount'],
                'quantity' => $meal['quantity'],
            );
            $this->db->insert('consumption', $data);

            $this->db->select('*,mp.quantity as mp_quantity');
            $this->db->from('meal_product mp');
            $this->db->join('product p', 'mp.product = p.id');
            $this->db->where('mp.meal', $meal['id']);

            //list of products that make up a meal
            $m_products = $this->db->get()->result_array();

            foreach ($m_products as $m_product) {

                //$m_products['product'] : produit's id
                //$m_products['quantity'] : the amount of the product in the meal
                //$meal['quantity'] : quantity of the meal

                // update reduce the amount of a product's stock after consumption the meal
                $this->model_product->updateQuantity($m_product['product'], $m_product['mp_quantity'] * $meal['quantity'] / 1000);
            }

        }
    }


    public function getAll()
    {
        $meals = $this->db->get('meal')->result_array();
        //$products = $this->db->get('meal_product')->result_array();

        $this->db->select('*');
        $this->db->from('meal_product mp');
        $this->db->join('product p', 'mp.product = p.id');

        $products = $this->db->get()->result_array();
        foreach ($meals as $key => $meal) {
            $meal['productsList'] = array();
            foreach ($products as $product) {
                if ($meal['id'] === $product['meal']) {
                    array_push($meal['productsList'], $product);
                }
            }
            $meals[$key]['productsList'] = $meal['productsList'];
        }
        unset($meal);
        return $meals;
    }

    public function getAllReports() {
        $reports = $this->db->get('report')->result_array();
        return $reports;
    }

    public function editReport() {
        $data = array(
            'title'     => $this->input->post('title'),
            'message'   => $this->input->post('message'),
            'send_to'   => $this->input->post('emails'),
            'user_id'   => $this->session->userdata('id')
        );

        $this->db->where('id', $this->input->post('id_report'));
        
        return $this->db->update('report', $data);
    }

    public function addReport() {
        $data = array(
            'title'     => $this->input->post('title'),
            'message'   => $this->input->post('message'),
            'send_to'   => $this->input->post('emails'),
            'user_id'   => $this->session->userdata('id')
        );

        return $this->db->insert('report', $data);
    }

    public function getReport($id) {
        $this->db->select('*, report.id as id_report, report.createdAt as createdAt_report');
        $this->db->join('users', 'report.user_id = users.id');
        $this->db->where('report.id', $id);
        $result = $this->db->get('report');
        return $result->row_array();
    }

    public function deleteReport($id) {
        $this->db->where('id', $id); 
        return $this->db->delete('report');
    }


    public function getUsersSearch($q) {
        $this->db->select('email');
        $this->db->from('users');
        $this->db->like('email', $q);
        $this->db->or_like('first_name', $q);
        $this->db->or_like('last_name', $q);
        $this->db->limit(10);

        $users = $this->db->get()->result_array();
        
        $userSearch = new ArrayObject();
        foreach ($users as $key => $user) {
           $userSearch->append($user['email']);
        }
        return $userSearch;
    }

    public function updateSentMail($id) {
        $data = array(
                       'sent' => 1
                    );

        $this->db->where('id', $id);
        return $this->db->update('report', $data);
    }

    public function pricesHistory($startDate, $endDate, $product){
        $this->db->select('avg(q.unit_price)price,pv.name,Date(q.created_at) date');
        $this->db->from('product p');
        $this->db->join('quantity q', 'q.product = p.id');
        $this->db->join('provider pv', 'pv.id = q.provider');
        $this->db->where('p.status', 'active');
        $this->db->where('p.name', $product);
        $this->db->where('DATE(q.created_at) >=', $startDate);
        $this->db->where('DATE(q.created_at) <=', $endDate);
        $this->db->group_by('date,pv.name');
        $this->db->order_by('date');
        $prices = $this->db->get()->result_array();
        $dates=array_column($prices,'date');
        $data=array();
        $lastPrice=array();
        foreach ($dates as $key=> $date) {
            $price=array(
                'period'=>$date
            );

            foreach ($prices as $priceItem) {
                if($priceItem['date']=== $date){
                    $price[$priceItem['name']]= $priceItem['price'];
                    $lastPrice[$priceItem['name']]=$priceItem['price'];
                }else{
                    if(isset($lastPrice[$priceItem['name']])){
                        $price[$priceItem['name']] = $lastPrice[$priceItem['name']];
                    }else{
                        $price[$priceItem['name']] = 0;
                    }
                }
            }
            $data[] = $price;
        }
        return $data;
    }
}