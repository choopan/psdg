<?php
Class Department extends CI_Model
{

 
 function getName()
 {
	$this->db->select("pwsection, pwname");
	$this->db->order_by("pwname", "asc");
	$this->db->from('pwsection');
	$query = $this->db->get();		
	return $query->result();
 }

 function getDepName()
 {
	$this->db->select("id, name");
	$this->db->order_by("name", "asc");
	$this->db->from('department');
	$this->db->where("name != ''");
	$query = $this->db->get();		
	return $query->result();
 }

 function getGom()
 {
	$this->db->select("id, name");
	$this->db->order_by("name", "asc");
	$this->db->from('department');
    $this->db->where('enabled',1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getOneGom($id=NULL)
 {
	$this->db->select("id, name");
	$this->db->from('department');
	$this->db->where("id", $id);
    $this->db->where("enabled", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getKongFromOneGom($id=NULL)
 {
    $result = $this->db->select('id, name')
                       ->order_by('name','asc')
                       ->from('division')
                       ->where('enabled',1)
                       ->where('dep_id',$id)
                       ->get()->result();
    return $result;
 }

 function getOneKong($id=null)
 {
	$this->db->select("name, dep_id");
	$this->db->order_by("name", "asc");
	$this->db->from('division');
	$this->db->where('enabled',1);
    $this->db->where('id',$id);
	$query = $this->db->get();		
	return $query->result();
 }
    
}
?>

