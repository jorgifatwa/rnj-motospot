<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Motor_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("motor.*")->from("motor"); 
        $this->db->where($where);  
        $this->db->where("motor.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getAllById($where = array()){
        $this->db->select("motor.*, cabang.nama as cabang_name, merk.nama as merk_name, jenis.nama as jenis_name")->from("motor");  
		$this->db->join("cabang", "cabang.id = motor.cabang_id");
		$this->db->join("merk", "merk.id = motor.merk_id");
		$this->db->join("jenis", "jenis.id = motor.jenis_id");
        $this->db->where($where);  
        $this->db->where("motor.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("motor", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("motor", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("motor"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir, $where = array())
    {
        $this->db->select("motor.*, cabang.nama as cabang_name, merk.nama as merk_name, jenis.nama as jenis_name")->from("motor");  
		$this->db->join("cabang", "cabang.id = motor.cabang_id");
		$this->db->join("merk", "merk.id = motor.merk_id");
		$this->db->join("jenis", "jenis.id = motor.jenis_id");
        $this->db->where($where);  
        $this->db->where("motor.is_deleted",0);  
        $this->db->limit($limit,$start)->order_by($col,$dir);
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();
        } 
  
        $result = $this->db->get();
        if($result->num_rows()>0)
        {
            return $result->result();  
        }
        else
        {
            return null;
        }
    }

    function getCountAllBy($limit,$start,$search,$order,$dir, $where = array())
    { 
        $this->db->select("motor.*, cabang.nama as cabang_name, merk.nama as merk_name, jenis.nama as jenis_name")->from("motor");  
		$this->db->join("cabang", "cabang.id = motor.cabang_id");
		$this->db->join("merk", "merk.id = motor.merk_id");
		$this->db->join("jenis", "jenis.id = motor.jenis_id");
        $this->db->where($where);  
        $this->db->where("motor.is_deleted",0);  
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();
        } 
 
        $result = $this->db->get();
    
        return $result->num_rows();
    }

    public function record_count() {
        return $this->db->count_all("motor");
    }

    public function fetch_motor($limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->where("motor.is_deleted",0);  
        $query = $this->db->get("motor");

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function search_motor($keyword) {
        $this->db->like('nama', $keyword);
        $this->db->where("motor.is_deleted",0);  
        $this->db->or_like('keterangan', $keyword);
        return $this->db->get('motor')->result();
    }

    public function fetch_motor_search($limit, $start, $keyword) {
        $this->db->where("motor.is_deleted", 0); // Pertama, atur kondisi untuk is_deleted
        $this->db->group_start(); // Mulai klausa grup agar klausa like() dan or_like() digabungkan dengan benar
        $this->db->like('nama', $keyword);
        $this->db->or_like('keterangan', $keyword);
        $this->db->group_end(); // Akhiri klausa grup
        $this->db->limit($limit, $start);
        $query = $this->db->get('motor');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }    

    public function record_count_search($keyword) {
        $this->db->like('nama', $keyword);
        $this->db->or_like('keterangan', $keyword);
        $this->db->where("motor.is_deleted",0);  
        return $this->db->count_all_results("motor");
    }    
}
