<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_mark extends CI_Model {

    private $response=array();

    public function __construct()
    {
        $this->response['status']='success';
    }

    public function add($mark){
        if(!$this->restoreDeletedMark($mark)){
            $mark['m_unit_convert']=$this->getUnitConvert($mark);
            $this->db->insert('mark', $mark);
        }
        return $this->response;
    }

    public function getUnitConvert($mark){
        $this->db->where('id',$mark['product']);
        $product=$this->db->get('product')->row_array();
        $unit_convert=1;
        if($product['unit']==="pcs"
            and $product['weightByUnit']>0
            and $mark['m_unit']==="pcs"){
            $unit_convert=$mark['m_weightByUnit']/$product['weightByUnit'];
        }else if($product['unit']==="pcs"
            and $product['weightByUnit']>0
            and ($mark['m_unit']==="kg" or $mark['m_unit']==="L")){
            $unit_convert=1/$product['weightByUnit']*1000;
        }else if( ($product['unit']==="kg" or $product['unit']==="L")
            and $mark['m_unit']==="pcs"){
            $unit_convert=$mark['m_weightByUnit']/1000;
        }
        return $unit_convert;
    }

    public function updateUnitConvert($product){

        $this->db->where('product',$product['id']);
        $marks=$this->db->get('mark')->result_array();
        foreach ($marks as $mark){
            $unit_convert=1;
            if($product['unit']==="pcs"
                and $product['weightByUnit']>0
                and $mark['m_unit']==="pcs"){
                $unit_convert=$mark['m_weightByUnit']/$product['weightByUnit'];
            }else if($product['unit']==="pcs"
                and $product['weightByUnit']>0
                and ($mark['m_unit']==="kg" or $mark['m_unit']==="L")){
                $unit_convert=1/$product['weightByUnit']*1000;
            }else if( ($product['unit']==="kg" or $product['unit']==="L")
                and $mark['m_unit']==="pcs"){
                $unit_convert=$mark['m_weightByUnit']/1000;
            }
            $this->db->where('id',$mark['id']);
            $this->db->update('mark',array('m_unit_convert'=>$unit_convert));
        }
    }

    public function getAll(){
        $this->db->where('deleted','false');
        $marks=$this->db->get('mark')->result_array();
        return $marks;
    }
    public function getByProduct($id){
        $this->db->where('deleted','false');
        $this->db->where('product',$id);
        $marks=$this->db->get('mark')->result_array();
        return $marks;
    }

    public function delete($mark){

        $data=array(
            'deleted'=>'true'
        );
        $this->db->where('id',$mark['id']);
        $this->db->update('mark',$data);
        return $this->response;
    }

    public function update($mark){

       if(!$this->restoreDeletedMark($mark)){
            $data=array(
                'name'=>$mark['name'],
                'm_unit'=>$mark['m_unit'],
                'm_unit_price'=>$mark['m_unit_price'],
                'm_weightByUnit'=>$mark['m_weightByUnit'],
            );
            $data['m_unit_convert']=$this->getUnitConvert($mark);
            $this->db->where('id',$mark['mark_id']);
            $this->db->update('mark',$data);
        }else{
           $mark['id']=$mark['mark_id'];
           $this->delete($mark);
       }
        return $this->response;
    }

    public function updateMarkOrder($orderdetails,$product){
        $this->db->where('id',$product['mark']);
        $mark=$this->db->get('mark')->row_array();
        $data=array(
            'mark'=>$product['mark'],
            'm_name'=>$mark['name'],
            'm_unit'=>$mark['m_unit'],
            'm_unit_price'=>$mark['m_unit_price'],
            'm_weightByUnit'=>$mark['m_weightByUnit'],
            'm_unit_convert'=>$mark['m_unit_convert'],
        );
        $this->db->where('orderdetails',$orderdetails['id']);
        $this->db->update('order_mark',$data);
    }

    private function removeDeletedMark($mark){
        $data=array(
            'deleted'=>'false'
        );
        $this->db->where('id',$mark['id']);
        $this->db->update('mark',$data);
    }

    private function restoreDeletedMark($mark){
        $restored=false;
        $this->db->where('name',$mark['name']);
        $this->db->where('product',$mark['product']);
        $this->db->where('deleted','true');
        $db_mark=$this->db->get('mark')->row_array();
        if($db_mark){
            $this->removeDeletedMark($db_mark);
            $restored=true;
        }
        return $restored;
    }

}