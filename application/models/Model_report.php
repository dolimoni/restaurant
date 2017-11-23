<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_report extends CI_Model
{

    public function report($params = null)
    {
        //regular report: used in table in admin/report/index
        if (!$params) {
            $this->db->select('*');
            $this->db->select('sum(c.quantity) as s_quantity');
            $this->db->select('sum(c.quantity)*c.amount as s_amount');
            $this->db->select('sum(c.quantity)*profit as s_profit');
            $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
            $this->db->from('meal m');
            $this->db->join('consumption c', 'm.id = c.meal');
            $this->db->join('consumption_product cp', 'c.id = cp.consumption');
            $this->db->group_by('c.meal');
            return $this->db->get()->result_array();
        } else {//customr report
            $this->db->select('*');
            $this->db->select('sum(c.quantity) as s_quantity');
            $this->db->select('sum(c.quantity)*c.amount as s_amount');
            $this->db->select('sum(c.quantity)*profit as s_profit');
            $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
            $this->db->from('meal m');
            $this->db->join('consumption c', 'm.id = c.meal');
            $this->db->join('consumption_product cp', 'c.id = cp.consumption');
            if ($params['sort']) {
                $this->db->order_by($params['sort_by'], 'DESC');
            }
            if ($params['max']) {
                $this->db->limit($params['max'], 0);
            }

            $this->db->group_by('c.meal');

            $report = $this->db->get()->result_array();
            //$report['mealConsumptionRate']= $this->mealConsumptionRate();
            return $report;
        }
    }

    public function reportById($meal_id)
    {
        $this->db->select('*');
        $this->db->select('c.quantity as c_quantity');
        //$this->db->select('sum(c.quantity) as s_amount');
        //$this->db->select('sum(c.quantity)*profit as s_profit');
        $this->db->select('sum(cp.quantity*cp.unit_price) as s_cost');
        $this->db->select('COUNT(DISTINCT DATE_FORMAT(c.createdAt, \'%Y-%m-%d\')) as days');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->join('consumption_product cp', 'c.id = cp.consumption and m.id=cp.meal');
        $this->db->where('m.id', $meal_id);
        $this->db->group_by('c.meal, cp.consumption');
        $report = $this->db->get()->row_array();

        $report['mealConsumptionRate'] = $this->mealConsumptionRate($meal_id);
        $report['totalPrice'] = $report['mealConsumptionRate']['totalPrice'];
        $report['totalConsumptionQuantity'] = $report['mealConsumptionRate']['totalQuantity'];
        unset($report['mealConsumptionRate']['totalPrice']);
        unset($report['mealConsumptionRate']['totalQuantity']);

        $s_quantity = 0;
        if (!empty($report)) {
            $s_quantity = array_sum(array_column($report, 'c_quantity'));
        }
        $report['s_quantity'] = $s_quantity;
        return $report;
    }

    public function evolution($meal_id)
    {
        $this->db->select('*,Date(c.createdAt) as ca');
        $this->db->select('sum(quantity) as s_quantity');
        $this->db->select('sum(quantity)*amount as s_amount');
        $this->db->select('COUNT(DISTINCT DATE_FORMAT(c.createdAt, \'%Y-%m-%d\')) as days');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->where('m.id', $meal_id);
        $this->db->order_by('c.createdAt', 'ASC');
        $this->db->group_by('ca');
        return $this->db->get()->result_array();
    }

    public function evolutionRange($meal_id, $startDate, $endDate)
    {
        $this->db->select('*,Date(c.createdAt) as ca');
        $this->db->select('sum(quantity) as s_quantity');
        $this->db->select('sum(quantity)*amount as s_amount');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->where('m.id', $meal_id);
        $this->db->where('DATE(c.createdAt) >=', $startDate);
        $this->db->where('DATE(c.createdAt) <=', $endDate);
        $this->db->order_by('c.createdAt', 'ASC');
        $this->db->group_by('ca');
        return $this->db->get()->result_array();
    }

    public function reportMealDate($meal_id, $date)
    {
        $this->db->select('*');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->where('m.id', $meal_id);
        $this->db->where('report_date =', $date);
        return $this->db->get()->row_array();
    }

    public function reportRange($startDate, $endDate)
    {
        $this->db->select('*');
        $this->db->select('sum(quantity) as s_quantity');
        $this->db->select('sum(quantity)*amount as s_amount');
        $this->db->from('meal m');
        $this->db->join('consumption c', 'm.id = c.meal');
        $this->db->where('c.createdAt >=', $startDate);
        $this->db->where('c.createdAt <=', $endDate);
        $this->db->group_by('meal');
        return $this->db->get()->result_array();
    }

    public function mealConsumptionRate($meal_id)
    {
        $this->db->select('*,avg(cp.unit_price) as avg_unit_price,sum(cp.quantity) as sum_quantity');
        $this->db->from('consumption_product cp');
        $this->db->join('product p', 'p.id=cp.product');
        $this->db->group_by('cp.product');
        $this->db->group_by('cp.meal');
        $this->db->where('cp.meal', $meal_id);
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