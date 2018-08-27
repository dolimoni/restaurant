<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_mark extends CI_Model {

    private $response=array();

    public function __construct()
    {
        $this->response['status']='success';
    }

    public function add($mark){
        if(!$this->restoreDeletedMark($mark)){
            $this->db->insert('mark', $mark);
        }
        return $this->response;
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
            );
            $this->db->where('id',$mark['mark_id']);
            $this->db->update('mark',$data);
        }else{
           $mark['id']=$mark['mark_id'];
           $this->delete($mark);
       }
        return $this->response;
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