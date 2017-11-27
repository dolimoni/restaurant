<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_employee extends CI_Model {

	public function deleteEmployee($employee_id){
        $this->db->where('id', $employee_id);
        $this->db->delete('employee');
    }
    public function add($worker)
    {
        $data = array(
            'name' => $worker['name'],
            'prenom' => $worker['prenom'],
            'cin' => $worker['cin'],
            'address' => $worker['address'],
            'phone' => $worker['phone'],
            'salary' => $worker['salary'],
            'workType' => $worker['workType'],
            'image' => $worker['image'],
        );
        $this->db->insert('employee', $data);
    }

	public function getAll()
	{
		$result = $this->db->get('employee');
		return $result->result_array();
	}

	public function get($u_id)
	{
		$this->db->where('id', $u_id);
		$result = $this->db->get('employee');
		return $result->row_array();
	}

	public function getEvents($u_id)
	{
        $this->db->select('*,e.id as e_id');
        $this->db->from('employee e');
        $this->db->join('employee_event ee', 'e.id=ee.employee');
        $this->db->where('e.id', $u_id);
        $result = $this->db->get();
        return $result->result_array();
	}
	
	public function updateEvent($event)
	{
		$data = array(
			'day' => $event['day'],
			'remarque' => $event['remarque'],
            'employee' =>$event['employee']
        );

		$this->db->where('id', $event['id']);
		$this->db->update('employee_event', $data);
        $this->automaticSalary($event);
	}

	public function createEvent($event)
	{
		$data = array(
			'day' => $event['day'],
			'remarque' => $event['remarque'],
			'employee' => $event['employee']
        );

		$this->db->insert('employee_event', $data);

        $this->automaticSalary($event);
	}


	public function deleteEvent($event)
	{
		$this->db->where('id', $event['id']);
		$this->db->delete('employee_event');
        $this->automaticSalary($event);

	}

	public function automaticSalary($event){
        $this->load->model('model_util');
        $employee=$this->get($event['employee']);
        $paid='false';
        if($this->model_util->isLastDayInMonth($event['day'])){
           $paid='true';
        }

        $lastDay = $this->model_util->getLastDayInMonth($event['day']);

        $absencesData = $this->getAbsences($employee['id'], $lastDay);//event['day'] renvoie une date
        $delaysData = $this->getDelays($employee['id'], $lastDay);//event['day'] renvoie une date

        $absences = count($absencesData);
        $delays = count($delaysData);

        $salary = $this->calculateSalary($employee, $lastDay);
        $advance = $this->getAdvance($employee, $lastDay);
        $substraction= $employee['salary']-$salary;
        $data = array(
            'salary' => $employee['salary'],
            'advance'=> $advance,
            'remain' => $salary - $advance,
            'delay' => $delays,
            'employee' => $employee['id'],
            'paymentDate'=> $lastDay,
            'substraction'=>$substraction,
            'absence' => $absences,
            'paid'=> $paid
        );

        $this->db->where('paymentDate', $lastDay);
        $this->db->where('employee', $employee['id']);
        $salaryMonth = count($this->db->get('salary')->result_array());
        if($salaryMonth>0){
            $this->db->where('paymentDate', $lastDay);
            $this->db->where('employee', $employee['id']);
            $this->db->update('salary', $data);
        }else{
            $this->db->insert('salary', $data);
        }

    }

    public function addSalary($id){

    }
	public function updateSalary($event){
        if (strpos($event['remarque'], 'paiement') !== false) {

            $absencesData = $this->getAbsences($event['employee'], $event['day']);//event['day'] renvoie une date
            $delaysData = $this->getDelays($event['employee'], $event['day']);//event['day'] renvoie une date

            $absences=count($absencesData);
            $delays=count($delaysData);
           //ajouter un nouveau paiement

            $data = array(
                'employee' => $event['employee'],
                'remain' => 3500,
                'paymentDate' => $event['day'],
                'delay'=> $delays,
            );

            $this->db->insert('salary', $data);
        }else if (strpos($event['remarque'], 'avance') !== false) {

        }
    }

    public function getAbsences($employee_id,$date){
        $orderdateArray = explode('-', $date);
        $year = $orderdateArray[0];
        $month = $orderdateArray[1];
        $day = $orderdateArray[2];

        $startDate="$year-$month-01";


        $this->db->where('employee',$employee_id);
        $this->db->where('day>=', $startDate);
        $this->db->where('day<=', $date);
        $this->db->like('remarque','absence');
        return $this->db->get('employee_event')->result_array();

    }

    public function getDelays($employee_id,$date){
        $orderdateArray = explode('-', $date);
        $year = $orderdateArray[0];
        $month = $orderdateArray[1];
        $day = $orderdateArray[2];

        $startDate="$year-$month-01";


        $this->db->where('employee',$employee_id);
        $this->db->where('day>=', $startDate);
        $this->db->where('day<=', $date);
        $this->db->like('remarque','retard');
        return $this->db->get('employee_event')->result_array();

    }

    public function getAdvances($employee_id,$date){
        $orderdateArray = explode('-', $date);
        $year = $orderdateArray[0];
        $month = $orderdateArray[1];
        $day = $orderdateArray[2];

        $startDate="$year-$month-01";


        $this->db->where('employee',$employee_id);
        $this->db->where('day>=', $startDate);
        $this->db->where('day<=', $date);
        $this->db->like('remarque','avance');
        return $this->db->get('employee_event')->result_array();

    }

    private function calculateSalary($employee, $date)
    {
        $daySalary=1;
        $salary= $employee['salary'];

        $absencesAmount=0;

        $delaysData= $this->getDelays($employee['id'], $date);
        $absencesData= $this->getAbsences($employee['id'], $date);

        foreach ($absencesData as $absence) {
            $absenceAmount = explode(' ', $absence['remarque']);
            $absencesAmount+= $absenceAmount[1];
        }

        $salary-=$absencesAmount*$daySalary;

        return $salary;

    }

    public function getSalaries($employee_id){
        $this->db->where('employee',$employee_id);
        $this->db->order_by('id','desc');
        return $this->db->get('salary')->result_array();
    }
    private function getAdvance($employee, $date)
    {
        $daySalary=1;
        $salary=$employee['salary'];
        $avancesAmount = 0;
        $advancesData = $this->getAdvances($employee['id'], $date);
        foreach ($advancesData as $advance) {
            $avanceAmount = explode(' ', $advance['remarque']);
            $avancesAmount += $avanceAmount[1];
        }

        return $avancesAmount;

    }

}