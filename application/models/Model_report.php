<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_report extends CI_Model
{

    public function report($params = null)
    {
        //regular report: used in table in admin/report/index
        if (!$params) {

            /*
             *
             * SELECT c.meal, (c.quantity*c.amount) as apres,(c.quantity*SUM(cp.unit_price*cp.quantity)) as avant FROM consumption c INNER JOIN consumption_product cp ON c.id = cp.consumption GROUP BY c.meal
             */

           /* $this->db->select('c.meal');
            $this->db->select('c.quantity*c.amount as apres');
            $this->db->select('c.quantity*SUM(cp.unit_price*cp.quantity) as avant');
            $this->db->from('consumption c');
            $this->db->join('consumption_product cp', 'c.id = cp.consumption');
            $this->db->group_by('c.meal');*/

           //meal consumption
            $this->db->select('*');
            $this->db->select('sum(c.quantity) as s_quantity');
            $this->db->select('sum(c.quantity)*c.amount as s_amount');
            $this->db->select('sum(c.quantity)*profit as s_profit');
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
                    if($val2['s_cost']==''){
                        $val2['s_cost']='0';
                    }
                }
                $meals[$key]['s_cost'] = $val2['s_cost'];
            }
            return $meals;
        } else {//customr report


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

    public function global_report(){
        $global=array();


        //all sales amount
        $this->db->select('*');
        $this->db->select('sum(c.quantity) as s_quantity');
        $this->db->select('sum(c.amount) as s_amount');
        $this->db->select('sum(c.amount)*sum(c.quantity) as turnover');
        $this->db->from('consumption c');
        $this->db->where('c.type','sale');
        $consumption = $this->db->get()->row_array();

        //costs
        $this->db->select('*');
        $this->db->select('sum(cp.unit_price) as s_price');
        $this->db->select('sum(cp.quantity) as s_quantity');
        $this->db->select('sum(cp.quantity)*sum(cp.unit_price) as s_cost');
        $this->db->from('consumption_product cp');
        $this->db->where('cp.type', 'sale');
        $consumption_product = $this->db->get()->row_array();

        //Sales history
        $this->db->select('report_date');
        $this->db->select('sum(c.total) as s_amount');
        $this->db->from('consumption c');
        $this->db->where('c.type', 'sale');
        $this->db->group_by('report_date');
        $this->db->limit(20);
        $sales_history = $this->db->get()->result_array();


        //Sales history by month
        $this->db->select('report_date');
        $this->db->select('sum(c.total) as s_amount');
        $this->db->from('consumption c');
        $this->db->where('c.type', 'sale');
        $this->db->group_by('MONTH(report_date)');
        $this->db->order_by('report_date', 'DESC');
        $this->db->limit(10);
        $sales_history_month = $this->db->get()->result_array();

        //products costs
        $this->db->select('p.name');
        $this->db->select('sum(total) as s_cost');
        $this->db->select('count(cp.product) as s_meal');
        $this->db->from('consumption_product cp');
        $this->db->where('cp.type', 'sale');
        $this->db->join('product p','p.id=cp.product');
        $this->db->group_by('product');
        $this->db->order_by('s_cost','DESC');
        $this->db->limit(5);
        $products_cost = $this->db->get()->result_array();


        $global['consumption']= $consumption;
        $global['cp']= $consumption_product;
        $global['sales_history']= $sales_history;
        $global['products_cost']= $products_cost;
        $global['sales_history_month']= $sales_history_month;


        return $global;
    }

    public function reportById($meal_id)
    {
        $this->db->select('*');
        $this->db->select('sum(c.quantity) as s_quantity');
        $this->db->select('COUNT(DISTINCT DATE_FORMAT(c.createdAt, \'%Y-%m-%d\')) as days');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->where('m.id', $meal_id);
        $this->db->where('c.type', 'sale');
        $this->db->group_by('c.meal');
        $report = $this->db->get()->row_array();

        //Total cost by meal
        $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
        $this->db->from('consumption c');
        $this->db->join('consumption_product cp', 'c.id = cp.consumption', 'left');
        $this->db->where('c.meal', $meal_id);
        $this->db->where('cp.type', 'sale');
        $s_cost = $this->db->get()->row()->s_cost;

        $report['s_cost']=$s_cost;




        $report['mealConsumptionRate'] = $this->mealConsumptionRate($meal_id);
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

        $evolution['s_cost'] = $s_cost;
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

    public function reportRange($startDate, $endDate)
    {

        $this->db->select('*');
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
                if ($val2['s_cost'] == '') {
                    $val2['s_cost'] = '0';
                }
            }
            $meals[$key]['s_cost'] = $val2['s_cost'];
        }
        return $meals;
    }

    public function mealConsumptionRate($meal_id)
    {
        $this->db->select('*,avg(cp.unit_price) as avg_unit_price,sum(cp.quantity) as sum_quantity');
        $this->db->from('consumption_product cp');
        $this->db->join('product p', 'p.id=cp.product');
        $this->db->group_by('cp.product');
        $this->db->group_by('cp.meal');
        $this->db->where('cp.meal', $meal_id);
        $this->db->where('cp.type', 'sale');
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

}