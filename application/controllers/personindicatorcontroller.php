<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class personindicatorcontroller extends CI_Controller {

	function index()
	{ }

	function personindicator()
	{
	
		//$data['rs']=$this->db->get("person_indicator")->result_array();
		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/personindicator',$data);
	}
	
	public function add()
	{
		$ar=array(
			"number"=>$this->input->post("number"),
			"name"=>$this->input->post("name"),
			"weight"=>$this->input->post("weight")
		);
		$this->db->insert("person_indicator",$ar);
		echo "ok";
	}
	
	public function edit()
	{
		$ar=array(
			"number"=>$this->input->post("number"),
			"name"=>$this->input->post("name"),
			"weight"=>$this->input->post("weight")
		);
		
		//ยังไม่เสร็จรอแก้ไข
		$this->db->where("name",$ar[name]);
		$this->db->update("person_indicator",$ar);

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/personindicator',$data);
	}
}

?>