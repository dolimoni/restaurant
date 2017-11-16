<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_group extends CI_Model {

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
        $this->db->join('meal m', 'g.id = m.group','left');
        $this->db->group_by('g.id');
		$groups = $this->db->get()->result_array();
		return $groups;
	}


	public function get($group_id)
	{
		$this->db->where('id', $group_id);
		$result = $this->db->get('group');
		return $result->row_array();
	}

	public function getByNum($num)
	{
		$this->db->where('num', $num);
		$result = $this->db->get('group');
		return $result->row_array();
	}
	
	public function edit($id,$group)
	{
		$this->db->where('id', $id);
		$this->db->update('group', $group);
	}


	public function createGroupsIfNotExists($groups)
	{
        foreach ($groups as $group) {
            $l_group = $this->getByNum($group['num']);
            if(!$l_group){
                $data = array(
                    'num' => $group['num'],
                    'name' => $group['name'],
                    'image' => 'restaurant.jpg',
                );

                $this->db->insert('group', $data);
            }
        }
	}

	public function switchProductsGroup($from,$to)
	{
	    $data=array(
	        'group'=> $to
        );
        $this->db->where('group', $from);
        $this->db->update('meal', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('group');
	}
}