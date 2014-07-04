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
	
	
	function delEvalRound($id) {
		$this->personindicator->delEvalRound($id);
		$this->session->set_flashdata('success', 'ลบรอบการประเมินเรียบร้อยแล้ว');
		redirect('person_evaluation/manageEvalRound', 'location');					
	}
	
	function setEvalRound() {
		$id = $this->input->post('eval_round_id');
		$this->personindicator->setEvalRound($id);
		$this->session->set_flashdata('success', 'ตั้งค่ารอบการประเมินเรียบร้อยแล้ว');
		redirect('person_evaluation/manageEvalRound', 'location');			
	}
	
	function addEvalRound() {
		$year = $this->input->post('year');
		$round = $this->input->post('round');
		$this->personindicator->insertEvalRound($year, $round);
		$this->session->set_flashdata('success', 'บันทึกข้อมูลรอบการประเมินเรียบร้อยแล้ว');
		redirect('person_evaluation/manageEvalRound', 'location');			
	}
	
	function manageEvalRound() {
		$data['title'] = "MFA - Indicator Management";	
		$data['evalrounds'] = $this->personindicator->getAllEvalRound();
		$active_evalround = $this->personindicator->getActiveEvalRound();
		if(count($active_evalround) == 1) {
			$data['active_year'] = $active_evalround[0]['year'];
			$data['active_round']= $active_evalround[0]['round'];
		} else {
			$data['active_year'] = 0;
			$data['active_round']= 0;			
		}
		$this->load->view('evaluate/adminEvalRound.php', $data);
	}
	

	function divManagePersonIndicator() {
		//Verify if this account is an executive of division
		if(!$this->session->userdata('sessexecdiv') || !$this->session->userdata('sessexecdep')) {
			echo "ERROR: NO PERMISSION";
			die();
		} else {
			$divID = $this->session->userdata('sessdiv');
			$userID = $this->session->userdata('sessid');
			//$data['users'] = $this->user->listUserInDivWithIndicator($userID, $divID);
		}
	}
	
	function managePersonIndicator() {
		$data['title'] = "MFA - Personal Indicator Management";	

		$userID = $this->session->userdata('sessid');
		$divID  = $this->session->userdata('sessdiv');
		$depID  = $this->session->userdata('sessdep');
		//$year = $this->session->userdata('sessyear');
		
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			$data['indicators'] = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);	

			$piStatus = $this->personindicator->getIndicatorStatus($userID, $year, $round, $depID, $divID);

			if($piStatus == 0) {
				$this->load->view('evaluate/managePersonIndicator.php', $data);
			} else {
				switch($piStatus) {
					case 1 : $data['status_msg'] = '<span class="label label-success">รอผู้บังคับบัญชาพิจารณา</span>'; break;
					default :$data['status_msg'] = 'undefined status'; break;
				}
				$this->load->view('evaluate/displayPersonIndicator.php', $data);
			}	

		} else {			
			echo "No evaluate round selected";
			die();
		}
		
	}
	
		
	function submitIndicatorForm() {
		$userID = $this->session->userdata('sessid');
		$depID = $this->session->userdata('sessdep');
		$divID = $this->session->userdata('sessdiv');
		//$year = $this->session->userdata('sessyear');
		$year = $this->input->post("year");
		$round = $this->input->post("round");
		$orders = $this->input->post("orders");
		$indicatorNames = $this->input->post("indicatorNames");
		$weights = $this->input->post("weights");		
		$option = $this->input->post("option");
		
		$this->personindicator->deleteandAddIndicator($userID, $year, $round, $depID, $divID, $orders, $indicatorNames, $weights);		
	
		if($option == "record") {
			$this->session->set_flashdata('success', 'บันทึกข้อมูลตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');	
		} else if($option == "prove") {
			$this->personindicator->setIndicatorStatus($userID, $year, $round, $depID, $divID, 1);		
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