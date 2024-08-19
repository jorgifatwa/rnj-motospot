<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Galeri_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("galeri.*")->from("galeri"); 
        $this->db->where($where);  
        $this->db->where("galeri.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
 
    public function getAllById($where = array()){
        $this->db->select("galeri.*")->from("galeri");  
        $this->db->where($where);  
        $this->db->where("galeri.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data) {
        $columns = implode(", ", array_keys($data));
        $values  = implode(", ", array_map([$this->db, 'escape'], array_values($data)));
        
        $sql = "INSERT INTO galeri ($columns) VALUES ($values)";
        
        $this->db->query($sql);
        
        return $this->db->insert_id();
    }
    

    public function update($data,$where){
        $this->db->update("galeri", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("galeri"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("galeri.*")->from("galeri");   
        $this->db->where("galeri.is_deleted",0);  
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

    function getCountAllBy($limit,$start,$search,$order,$dir)
    { 
        $this->db->select("galeri.*")->from("galeri");
        $this->db->where("galeri.is_deleted",0);  
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
}
