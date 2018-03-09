<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_employee extends CI_Model {

    private $remote_db="";
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isLogin')) {
            redirect('login');
        }


    }
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
        //$this->remote_db->insert('employee', $data);
        $id = $this->db->insert_id();
        $this->addSalary($id);
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

	public function updateEmployee($id, $employee)
	{
		$this->db->where('id', $id);
		$this->db->update('employee', $employee);
	}

	public function createEvent($event)
	{
        $this->load->model('model_util');
        $lastDay = $this->model_util->getLastDayInMonth(date("Y-m-d"));
		$data = array(
			'day' => $event['day'],
			'remarque' => $event['remarque'],
			'employee' => $event['employee'],
			'paymentDate' => $lastDay
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
           $paid='false';
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
	public function automaticSalaryForAll(){
        $this->load->model('model_util');
        $lastDay = $this->model_util->getLastDayInMonth(date("Y-m-d"));
        $paid = 'true';
        $employees=$this->getAll();
        foreach ($employees as $employee) {

            $absencesData = $this->getAbsences($employee['id'], $lastDay);
            $delaysData = $this->getDelays($employee['id'], $lastDay);

            $absences = count($absencesData);
            $delays = count($delaysData);

            $salary = $this->calculateSalary($employee, $lastDay);
            $advance = $this->getAdvance($employee, $lastDay);
            $substraction = $employee['salary'] - $salary;
            $data = array(
                'salary' => $employee['salary'],
                'advance' => $advance,
                'remain' => $salary - $advance,
                'delay' => $delays,
                'paymentDate' => $lastDay,
                'substraction' => $substraction,
                'absence' => $absences,
                'paid' => $paid
            );

            $this->db->where('paymentDate', $lastDay);
            $this->db->where('employee', $employee['id']);
            $salaryMonth = count($this->db->get('salary')->result_array());
            if ($salaryMonth > 0) {
                $this->db->where('paymentDate', $lastDay);
                $this->db->where('employee', $employee['id']);
                $this->db->update('salary', $data);
            } else {
                $data["employee"]= $employee['id'];
                $this->db->insert('salary', $data);
            }
        }

    }

    // get all salaries for all employees in this month
    public function getMonthSalaries($date=null){
	    if(!$date){
            $date=date("Y-m-d");
        }
        $this->load->model('model_util');
        $lastDay = $this->model_util->getLastDayInMonth($date);

        $this->db->select("s.salary,s.advance,s.remain,s.paymentDate,s.absence,s.substraction,e.name,e.prenom,e.id,s.paid");
        $this->db->from("salary s");
        $this->db->join("employee e","e.id=s.employee");
        $this->db->where('paymentDate', $lastDay);
        $salaries=$this->db->get()->result_array();
        return $salaries;

    }

    public function updatePaymentSalary($id){
        $this->db->where('id', $id);
        $db_salary = $this->db->get('salary')->row_array();
        $paymentDate = strtotime(date("Y-m-d H:i:s"));
        $paid = "false";
        if ($db_salary["paid"] === "true") {
            $this->db->where('id', $id);
            $this->db->update('salary', array("paid" => "false", "reelPaymentDate" => null));
        } else {
            $this->db->where('id', $id);
            $this->db->update('salary', array("paid" => "true", "reelPaymentDate" => date("Y-m-d H:i:s")));
            $paymentDate = strtotime(date("Y-m-d H:i:s"));
            $paid = "true";
        }
        $salary = array(
            "paid" => $paid,
            "paymentDate" => date("d-m-Y", $paymentDate),
        );
        return $salary;
    }

    public function addSalary($id){
        $this->load->model('model_util');
        $lastDay = $this->model_util->getLastDayInMonth(date("Y-m-d"));
        $employee = $this->get($id);
        $data = array(
            'salary' => $employee['salary'],
            'advance' => 0,
            'remain' => $employee['salary'],
            'delay' => 0,
            'paymentDate' => $lastDay,
            'substraction' => 0,
            'absence' => 0,
            'paid' => "false"
        );
        $data["employee"] = $employee['id'];
        $this->db->insert('salary', $data);
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

    public function getAdvances($employee_id=null,$endDate,$startDate=null){
        $orderdateArray = explode('-', $endDate);
        $year = $orderdateArray[0];
        $month = $orderdateArray[1];
        $day = $orderdateArray[2];

        if(!$startDate){
            $startDate = "$year-$month-01";
        }

        if($employee_id){
            $this->db->where('employee', $employee_id);
        }
        $this->db->where('day>=', $startDate);
        $this->db->where('day<=', $endDate);
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

    public function getReport($startDate=null,$endDate=null){
        //Sales history

        $response=array(
            "status"=>"success"
        );
        $this->load->model('model_util');

        $this->db->select('g.department as department,d.name');
        $this->db->select('sum(c.total) as s_amount');
        $this->db->from('consumption c');
        $this->db->join('meal m',"m.id=c.meal");
        $this->db->join('group g',"g.id=m.group");
        $this->db->join('department d',"d.id=g.department");
        $this->db->where('c.type', 'sale');
        if ($startDate) {
            $this->db->where('c.report_date>=', $startDate);
            $this->db->where('c.report_date<=', $endDate);
        }
        $this->db->group_by('g.department');
        $this->db->order_by('report_date', "desc");
        $sales_history = $this->db->get()->result_array();//Sales history
        $sales_history = array_reverse($sales_history);

        $this->db->select("sum(salary) as sum_salary");
        $this->db->select("count(id) as count_employee");
        $this->db->select("department");
        $this->db->from("employee");
        $this->db->group_by("department");
        $employees_department = $this->db->get()->result_array();//Sales history

        $days=$this->model_util->diffDate($startDate,$endDate);
        if($days==0){
            $days=1;
        }
        foreach ($employees_department as $key => $employee_department) {
            $employees_department[$key]["salary_avg"]= number_format($employee_department["sum_salary"] / $days,2);
            foreach ($sales_history as $key => $sale_history) {
                if($sale_history["department"] === $employee_department["department"]){
                    $employees_department[$key]["s_amount"]=number_format($sale_history["s_amount"],2);
                    $employees_department[$key]["sale_avg"]=number_format($sale_history["s_amount"] / $days,2);
                    $employees_department[$key]["name"]=$sale_history["name"];
                }
            }
        }

        $response["report"]= $employees_department;
        return $response;
    }

    public function getSalaries($employee_id){
        $this->db->where('employee',$employee_id);
        $this->db->order_by('paymentDate','desc');
        return $this->db->get('salary')->result_array();
    }
    public function getAdvance($employee, $endDate,$startDate=null)
    {
        $daySalary=1;
        $salary=$employee['salary'];
        $avancesAmount = 0;
        $advancesData = $this->getAdvances($employee['id'], $endDate, $startDate = null);
        foreach ($advancesData as $advance) {
            $avanceAmount = explode(' ', $advance['remarque']);
            $avancesAmount += $avanceAmount[1];
        }

        return $avancesAmount;

    }

}