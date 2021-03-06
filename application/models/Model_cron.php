<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_cron extends CI_Model {

	public function updateProductsQuantity(){

        $this->load->model('model_product');
        $productsList = $this->model_product->getAll();
        foreach ($productsList as $product) {
            $newQuantity= $product['quantity'] - $product['daily_quantity'];
            if($newQuantity<0){
                $newQuantity=0;
            }
            $data = array(
                'quantity' => $newQuantity,
            );

            /*$this->db->where('p.id', $product['id']);
            $this->db->update('product p join quantity q on q.product = p.id', $data);*/

            $sql = "UPDATE product p join quantity q on q.product = p.id SET q.quantity= ?  WHERE p.id = ? ";
            $this->db->query($sql, array($newQuantity, $product['id']));

        }

    }

	public function add($group)
	{
		$data = array(
			   'name' => $group['name'],
			   'image' => $group['image']
        );
		$this->db->insert('group', $data);
	}


	//load groups from external file
	public function loadGroups($groupsList)
	{


        $res = array();
        $res['status'] = "success";
        $groupsExist = array();

        foreach ($groupsList as $groupItem) {
            $group = $this->getByNum($groupItem['num']);
            if (!$group) {
                $data = array(
                    'name' => $groupItem['name'],
                    'num' => $groupItem['num'],
                    'image' => 'restaurant.jpg',
                );
                $this->db->insert('group', $data);
            } else {
                $groupsExist[] = $group;
                $res['status'] = 'warning';
            }
        }

        $res['groupsExist'] = $groupsExist;

        return $res;
	}

    public function updateGroups($groupsList, $selector = 'num')
    {
        $res = array();
        $res['status'] = "success";
        try {
            foreach ($groupsList as $groupItem) {
                $group = $this->getByNum($groupItem['num']);
                if ($selector === 'id') {

                }
                if ($group) {
                    $data = array(
                        'name' => $groupItem['name'],
                        'num' => $groupItem['num'],
                        'image' => 'restaurant.jpg',
                    );
                    $this->db->where('num', $groupItem['num']);
                    $this->db->update('group', $data);
                } else {
                    $res['status'] = 'error';
                    $res['message'] = 'une erreur s\'est produite';
                }
            }

        } catch (Exception $e) {
            $res['status'] = 'error';
            $res['message'] = 'une erreur s\'est produite!';
        }
        return $res;

    }


    public function addProductsForMeal($meal_id,$productsList){

	    foreach ($productsList as $product){
            $data = array(
                'product' => $product['id'],
                'meal' => $meal_id,
            );
            $this->db->insert('meal_product', $data);
        }
    }

	public function getAll()
	{
        $this->db->select('*,g.id as g_id,g.name as g_name, count(m.group) as groupCount, avg(sellPrice) as avg_price');
        $this->db->from('group g');
        $this->db->join('meal m', 'g.id = m.group');
        $this->db->group_by('m.group');
		$groups = $this->db->get()->result_array();
		return $groups;
	}


	public function get($u_id)
	{
		$this->db->where('id', $u_id);
		$result = $this->db->get('users');
		return $result->row_array();
	}

	public function getByNum($num)
	{
		$this->db->where('num', $num);
		$result = $this->db->get('group');
		return $result->row_array();
	}
	
	public function update($f_name,$l_name,$u_bday,$u_position,$u_type,$u_pass,$u_mobile,$u_gender,$u_address,$u_id)
	{
		$data = array(
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

		$this->db->where('id', $u_id);
		$this->db->where("(su != 1)");
		$this->db->update('users', $data); 
	}


	public function delete($u_id)
	{
		$this->db->where('id', $u_id);
		$this->db->where("(su != 1)");
		$this->db->delete('users'); 
	}
}