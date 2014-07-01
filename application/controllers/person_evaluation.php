<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class person_evaluation extends CI_Controller {
		
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('personindicator', '',TRUE);
	   //$this->load->model('user_manage', '',TRUE);
	   $this->load->helper('url');
	}
	
	function index()
	{

	}
	
	
	function divManagePersonIndicator() {
		//Verify if this account is an executive of division
		if(!$this->session->userdata('sessexecdiv')) {
			echo "ERROR: NO PERMISSION";
			die();
		} else {
			$divID = $this->session->userdata('sessdiv');
			$userID = $this->session->userdata('sessid');
			//$data['users'] = $this->user->listUserInDivWithIndicator($userID, $divID);
		}
	}
	
	
	function managePersonIndicator() {
		$userID = $this->session->userdata('sessid');
		$year = $this->session->userdata('sessyear');
		
		$data['title'] = "MFA - View Indicator ";	
		$data['indicators'] = $this->personindicator->listIndicator($userID, $year);	
		$data['year'] = $year;
		$piStatus = $this->personindicator->getIndicatorStatus($userID, $year);
		if($piStatus == 0) {
			$this->load->view('evaluate/managePersonIndicator.php', $data);
		} else {
			switch($piStatus) {
				case 1 : $data['status_msg'] = '<span class="label label-success">รอผู้บังคับบัญชาพิจารณา</span>'; break;
				default :$data['status_msg'] = 'undefined status'; break;
			}
			$this->load->view('evaluate/displayPersonIndicator.php', $data);
		}	
	}
	
		
	function submitIndicatorForm() {
		$userID = $this->session->userdata('sessid');
		$year = $this->session->userdata('sessyear');
		
		$orders = $this->input->post("orders");
		$indicatorNames = $this->input->post("indicatorNames");
		$weights = $this->input->post("weights");		
		$option = $this->input->post("option");
		
		$this->personindicator->deleteandAddIndicator($userID, $year, $orders, $indicatorNames, $weights);		
	
		if($option == "record") {
			$this->session->set_flashdata('success', 'บันทึกข้อมูลตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');	
		} else if($option == "prove") {
			$this->personindicator->setIndicatorStatus($userID, $year, 1);		
			$this->session->set_flashdata('success', 'ส่งข้อมูลข้อมูลตัวชี้วัดรายบุคคลให้ผู้บังคับบัญชาพิจารณาเรียบร้อยแล้ว');				
		}
		
		redirect('person_evaluation/managePersonIndicator', 'location');
	}
	
	function evaluation()
	{
		//
		//waiting data from models
		//
		//$this->load->view('indicator/evaluation',$data);
		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/evaluation',$data);
	}
}

?>