<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_budget extends CI_Model {


    public function addReparation($reparation)
    {
        $this->db->insert('reparation', $reparation);
    }
    public function addPurchase($purchase)
    {

        $this->db->insert('purchase', $purchase);
    }

    public function addRegularCost($regularCost)
    {
        $this->db->insert('regularcost', $regularCost);
    }

	public function getReparations()
	{
		$result = $this->db->get('reparation');
		return $result->result_array();
	}
	public function getPurchases()
	{
		$result = $this->db->get('purchase');
		return $result->result_array();
	}
	public function getRegularCosts()
	{
		$result = $this->db->get('regularcost');
		return $result->result_array();
	}

	//get active alertes
	public function getActiveAlerts()
	{
        $this->db->where('status =', 'active');
		$result = $this->db->get('regularcost');
		return $result->result_array();
	}

    // change passive alerte to active aletes
    // alete = regular cost
	public function activeAlerts(){
        $today=Date('Y-m-d');
        $data=array(
            'status'=>'active'
        );
        $this->db->where('reminderDate <=',$today);
        $this->db->where('status !=','done');
        $this->db->update('regularcost',$data);
    }

    public function updateAlertDates($id,$data){
        $this->db->where('id',$id);
        //$this->db->where('status','active');
        $this->db->update('regularcost', $data);
    }

    public function update($id,$data){
        $this->db->where('id',$id);
        $this->db->update('regularcost', $data);
    }
    public function updatePurchase($id,$data){
        $this->db->where('id', $id);
        $db_purchase=$this->db->get("purchase")->row_array();
        if($db_purchase["paid"]==="false" and $data["paid"]==="true"){
            $data["paymentDate"]=date("Y-m-d H-i-s");
        }
        $this->db->where('id',$id);
        $this->db->update('purchase', $data);
    }
    public function updateReparation($id,$data){
        $this->db->where('id',$id);
        $this->db->update('reparation', $data);
    }
    public function deleteAlert($id){
            $this->db->where('id',$id);
            $this->db->delete('regularcost');
    }
    public function deletePurchase($id){
            $this->db->where('id',$id);
            $this->db->delete('purchase');
    }
    public function deleteReparation($id){
            $this->db->where('id',$id);
            $this->db->delete('reparation');
    }

    public function purchase_history($startDate=null,$endDate=null){
        $response = array();
        $this->db->select('sum(p.price) as price');
        $this->db->select('date(p.created_at) as created_at');
        $this->db->from('purchase p');
        if ($startDate) {
            $this->db->where('date(p.created_at)>=', $startDate);
            $this->db->where('date(p.created_at)<=', $endDate);
        }
        $this->db->group_by("date(p.created_at)");
        $purchase_history = $this->db->get()->result_array();

        return $purchase_history;
    }

}