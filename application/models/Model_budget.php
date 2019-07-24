<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_budget extends CI_Model {

    private $response=array();

    /**
     * model_budget constructor.
     */
    public function __construct()
    {
        $this->response['status']='success';
    }


    public function addReparation($reparation)
    {
        $this->db->insert('reparation', $reparation);
    }
    public function addPurchase($purchase)
    {
        $this->db->insert('purchase', $purchase);
    }

    public function addFixedCharge($fixedCharge){
        $this->db->insert('fixed_charge', $fixedCharge);
        return $this->response;
    }
    public function editFixedCharge($id,$fixedCharge){
        $this->db->where("id",$id);
        $this->db->update('fixed_charge', $fixedCharge);
        return $this->response;
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
	    $this->db->select('*');
	    $this->db->select('date(paymentDate) paymentDate');
	    $this->db->select('date(created_at) created_at');
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
            $data["paymentDate"]=$data['paymentDate'];
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

    public function deleteFixedCharge($id){
            $this->db->where('id',$id);
            $this->db->delete('fixed_charge');
            return $this->response;
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

    public function getFixedCharge($startDate=null,$endDate=null){
        $this->load->model('model_util');
        $endDate=$this->model_util->getLastDayInMonth($startDate);
        if($startDate){
            $this->db->where("charge_date>=",$startDate);
            $this->db->where("charge_date<=",$endDate);
        }
        $fixed_charges=$this->db->get('fixed_charge')->result_array();
        $this->response['breakEven']=$this->getBreakEven($startDate);
        $this->response['fixed_charges']=$fixed_charges;
        return $this->response;
    }

    public function getBreakEven($startDate=null,$endDate=null){
        $this->load->model('model_util');

        if($startDate){
            $endDate=$this->model_util->getLastDayInMonth($startDate);
        }else{
            $startDate=$this->model_util->getFirstDayInMonth(date('Y-m-d'));
            $endDate=$this->model_util->getLastDayInMonth($startDate);
        }
        $this->db->select_sum('amount');
        $this->db->from('fixed_charge');
        $this->db->where("charge_date>=",$startDate);
        $this->db->where("charge_date<=",$endDate);
        $breakEven=$this->db->get()->row('amount');
        return $breakEven;
    }

}