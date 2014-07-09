<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class person_evaluation extends CI_Controller {
		
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('personindicator', '',TRUE);
	   $this->load->model('user', '',TRUE);
	   $this->load->helper('url');
	}
	
	function index()
	{

	}
	
	function execAgreeIndicator($id, $user_id, $sumweight) {
		if((float)$sumweight == 1) {
			$this->personindicator->setPIStatus($id, 2);
			$this->session->set_flashdata('success', 'อนุมัติตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');
			redirect('person_evaluation/divManagePersonIndicator', 'location');
		} else {
			$this->session->set_flashdata('failed', 'ผลรวมของค่าน้ำหนักไม่เท่ากับ 1');
			redirect('person_evaluation/confirmIndicator/'.$user_id, 'location');			
		}
	}
	
	function execCancelIndicator($id) {
		$this->personindicator->setPIStatus($id, 0);
		$this->session->set_flashdata('failed', 'ไม่อนุมัติตัวชี้วัดรายลุคคลเรียบร้อยแล้ว');
		redirect('person_evaluation/divManagePersonIndicator', 'location');
	}

	function viewIndicatorFromDep($id) {
		$data['title'] = "MFA - Person Indicator Management";
		$userID = $id;
		$depID  = $this->session->userdata('sessdep');
		$divID  = $this->session->userdata('sessdiv');
	
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year'] = $year;
			$data['round'] = $round;
			$tmp = $this->user->getMinProfile($id);
			$data['user'] =  $tmp[0];

			$pi_set = $this->personindicator->getPINumber($userID, $year, $round, $tmp[0]['depID'], $tmp[0]['divID']);
			$data['pi_set'] = $pi_set[0]['ID'];
			$data['indicators'] = $this->personindicator->listIndicator($userID, $year, $round, $tmp[0]['depID'], $tmp[0]['divID']);	
			$this->load->view('evaluate/viewPersonIndicatorFromDep.php', $data);
		} else {
			echo "No evaluate round selected";
			die();
		}		
	}

	
	function viewIndicator($id) {
		$data['title'] = "MFA - Person Indicator Management";
		$userID = $id;
		$depID  = $this->session->userdata('sessdep');
		$divID  = $this->session->userdata('sessdiv');
	
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year'] = $year;
			$data['round'] = $round;
			$data['indicators'] = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);	
			$tmp = $this->user->getMinProfile($id);
			$data['user'] =  $tmp[0];
			$piStatus = $this->personindicator->getIndicatorStatus($userID, $year, $round, $depID, $divID);
			
			switch($piStatus) {
					case 1  : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
					case 2  : $data['status_msg'] = '<span class="label label-warning">ผ่านการอนุมัติขั้นตอน</span>'; break;
					case 3  : $data['status_msg'] = '<span class="label label-green">ผ่านการอนุมัติแล้ว</span>'; break;
					default : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
			}
			$this->load->view('evaluate/viewPersonIndicator.php', $data);
		} else {
			echo "No evaluate round selected";
			die();
		}						
	}


	function confirmIndicator($id) {
		$data['title'] = "MFA - Person Indicator Management";
		$userID = $id;
		$depID  = $this->session->userdata('sessdep');
		$divID  = $this->session->userdata('sessdiv');
	
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year'] = $year;
			$data['round'] = $round;
			$pi_set = $this->personindicator->getPINumber($userID, $year, $round, $depID, $divID);
			$data['pi_set'] = $pi_set[0]['ID'];
			$data['indicators'] = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);	
			$tmp = $this->user->getMinProfile($id);
			$data['user'] =  $tmp[0];
			$this->load->view('evaluate/confirmPersonIndicator.php', $data);
		} else {
			echo "No evaluate round selected";
			die();
		}		
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
		$data['title'] = "MFA - Personal Indicator Management";	
		//Verify if this account is an executive of division
		if(!$this->session->userdata('sessexecdiv')) {
			show_error("คุณไม่มีสิทธิในการเข้าถึงหน้านี้", 500);
		}
		
		$data['userID'] = $this->session->userdata('sessid');
		$data['depID']  = $this->session->userdata('sessdep');	
		$data['divID']  = $this->session->userdata('sessdiv');
		
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			$data['user_info'] = $this->user->getUserFromDiv($data['userID'], $data['divID']); 
			$this->load->view('evaluate/displayPersonIndicatorInDiv.php', $data);
		} else {			
			echo "No evaluate round selected";
			die();
		}
	}

	function divManagePersonEvaluation() {
		$data['title'] = "MFA - Personal Indicator Management";	
		//Verify if this account is an executive of division
		if(!$this->session->userdata('sessexecdiv')) {
			show_error("คุณไม่มีสิทธิในการเข้าถึงหน้านี้", 500);
		}
		$data['userID'] = $this->session->userdata('sessid');
		$data['depID']  = $this->session->userdata('sessdep');	
		$data['divID']  = $this->session->userdata('sessdiv');
		
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			$data['user_info'] = $this->user->getUserFromDiv($data['userID'], $data['divID']); 
			$this->load->view('evaluate/displayPersonEvaluationInDiv.php', $data);
		} else {			
			echo "No evaluate round selected";
			die();
		}
	}

	function depManagePersonEvaluation() {
		$data['title'] = "MFA - Personal Indicator Management";	
		//Verify if this account is an executive of division
		if(!$this->session->userdata('sessexecdep')) {
			show_error("คุณไม่มีสิทธิในการเข้าถึงหน้านี้", 500);
		}
		$data['userID'] = $this->session->userdata('sessid');
		$data['depID']  = $this->session->userdata('sessdep');
		$data['divID']  = $this->session->userdata('sessdiv');
	
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			$data['user_info'] = $this->user->getUserFromDep($data['userID'], $data['depID']); 
			$this->load->view('evaluate/displayPersonEvaluationInDep.php', $data);
		} else {			
			echo "No evaluate round selected";
			die();
		}
	}


	function depManagePersonIndicator() {
		$data['title'] = "MFA - Personal Indicator Management";	
		//Verify if this account is an executive of division
		if(!$this->session->userdata('sessexecdep')) {
			show_error("คุณไม่มีสิทธิในการเข้าถึงหน้านี้", 500);
		}
		
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;

			$userID = $this->session->userdata('sessid');
			$data['userID'] = $userID;
			
			$tmp_depIDs = $this->user->getDepUnderControl($userID);
			$depIDs = array();
			for($i = 0; $i < count($tmp_depIDs); $i++) {
				$depIDs[$i] = $tmp_depIDs[$i]['dep_id'];
			}
		
			$divExecUserID = $this->user->getDivExecUnderControl($depIDs); // div exec
			$depExecUserID = $this->user->getDepExecUnderControl($depIDs); // dep exec
			$execUserID = array_unique(array_merge($divExecUserID, $depExecUserID));
		
			$exec_info = $this->user->getUserInfo($execUserID);
			$user_info = $this->user->getUserInfoUnderControlExceptExec($execUserID, $depIDs);
			$data['exec_info'] = $exec_info;
			$data['user_info'] = $user_info;
			$this->load->view('evaluate/displayPersonIndicatorInDep.php', $data);
		} else {			
			echo "No evaluate round selected";
			die();
		}
	}

	function minManagePersonEvaluation() {
		$data['title'] = "MFA - Personal Indicator Management";	
		//Verify if this account is an executive of division
		if(!$this->session->userdata('sessadmin_min')) {
			show_error("คุณไม่มีสิทธิในการเข้าถึงหน้านี้", 500);
		}
	
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			$data['user_info'] = $this->user->getAllProfile(); 
			$this->load->view('evaluate/displayPersonEvaluationInMin.php', $data);
		} else {			
			echo "No evaluate round selected";
			die();
		}
	}

	function minManagePersonIndicator() {
		$data['title'] = "MFA - Personal Indicator Management";	
		//Verify if this account is an executive of division
		if(!$this->session->userdata('sessadmin_min')) {
			show_error("คุณไม่มีสิทธิในการเข้าถึงหน้านี้", 500);
		}

		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			$data['user_info'] = $this->user->getAllProfile(); 
			$this->load->view('evaluate/displayPersonIndicatorInMin.php', $data);
		} else {			
			echo "No evaluate round selected";
			die();
		}
	}
	
	function managePersonIndicator() {
		//choopan
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
					case 1  : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
					case 2  : $data['status_msg'] = '<span class="label label-warning">ผ่านการอนุมัติขั้นตอน</span>'; break;
					case 3  : $data['status_msg'] = '<span class="label label-green">ผ่านการอนุมัติแล้ว</span>'; break;
					default : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;	
				}
				$this->load->view('evaluate/displayPersonIndicator.php', $data);
			}	

		} else {
			$data['error_msg'] = "ผู้ดูแลระบบยังไม่ได้ตั้งค่ารอบการประเมิน<BR>กรุณาติดต่อผู้ดูแลระบบ";
			$this->load->view('evaluate/errorPersonEvaluation.php', $data);
		}		
	}
	
	function submitIndicatorToProve($weight) {
		$active_evalround = $this->personindicator->getActiveEvalRound();
		if(count($active_evalround) == 1) {
			//Check weight
			if((float)$weight != 1) {
				$this->session->set_flashdata('failed', 'ค่าน้ำหนักรวมของตัวชี้วัดไม่เท่ากับ 1 ไม่สามารถส่งตัวชี้วัดเพื่อให้ผู้บังคับบัญชาพิจารณาได้');			
				redirect('person_evaluation/managePersonIndicator', 'location');		
				die();
			}
			
			$year = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$userID = $this->session->userdata('sessid');
			$depID = $this->session->userdata('sessdep');
			$divID = $this->session->userdata('sessdiv');

			$this->personindicator->setIndicatorStatus($userID, $year, $round, $depID, $divID, 1);
			$this->session->set_flashdata('success', 'ส่งข้อมูลข้อมูลตัวชี้วัดรายบุคคลให้ผู้บังคับบัญชาพิจารณาเรียบร้อยแล้ว');				
			redirect('person_evaluation/managePersonIndicator', 'location');		
		
		} else {
			$data['error_msg'] = "ผู้ดูแลระบบยังไม่ได้ตั้งค่ารอบการประเมิน<BR>กรุณาติดต่อผู้ดูแลระบบ";
			$this->load->view('evaluate/errorPersonEvaluation.php', $data);						
		}
	}
		
	function submitIndicatorForm() {
		//$year = $this->session->userdata('sessyear');
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {

			$data['title'] = "MFA - Personal Indicator Management";				

			$userID = $this->session->userdata('sessid');
			$depID = $this->session->userdata('sessdep');
			$divID = $this->session->userdata('sessdiv');

			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$order = $this->input->post("main_order");
			$indicatorName = $this->input->post("main_indicatorname");
			$weight = $this->input->post("main_weight");
			$ind1 = $this->input->post('indicator1');
			$ind2 = $this->input->post('indicator2');
			$ind3 = $this->input->post('indicator3');
			$ind4 = $this->input->post('indicator4');
			$ind5 = $this->input->post('indicator5');
			$ind_detail1 = $this->input->post('detail_indicator1');
			$ind_detail2 = $this->input->post('detail_indicator2');
			$ind_detail3 = $this->input->post('detail_indicator3');
			$ind_detail4 = $this->input->post('detail_indicator4');
			$ind_detail5 = $this->input->post('detail_indicator5');
			
			$this->personindicator->addPersonIndicator($userID, $year, $round, $depID, $divID, $order, $indicatorName, $weight,
													   $ind1, $ind2, $ind3, $ind4, $ind5, $ind_detail1, $ind_detail2, $ind_detail3, $ind_detail4, $ind_detail5);					
			$this->session->set_flashdata('success', 'บันทึกข้อมูลตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');
		} else {
			$data['error_msg'] = "ผู้ดูแลระบบยังไม่ได้ตั้งค่ารอบการประเมิน<BR>กรุณาติดต่อผู้ดูแลระบบ";
			$this->load->view('evaluate/errorPersonEvaluation.php', $data);			
		}
		
		redirect('person_evaluation/managePersonIndicator', 'location');
	}
	
	function submitIndicatorFormFromExecDiv($id) {
		//$year = $this->session->userdata('sessyear');
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {

			$data['title'] = "MFA - Personal Indicator Management";				

			$userID = $id;
			$depID = $this->session->userdata('sessdep');
			$divID = $this->session->userdata('sessdiv');

			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$order = $this->input->post("main_order");
			$indicatorName = $this->input->post("main_indicatorname");
			$weight = $this->input->post("main_weight");
			$ind1 = $this->input->post('indicator1');
			$ind2 = $this->input->post('indicator2');
			$ind3 = $this->input->post('indicator3');
			$ind4 = $this->input->post('indicator4');
			$ind5 = $this->input->post('indicator5');
			$ind_detail1 = $this->input->post('detail_indicator1');
			$ind_detail2 = $this->input->post('detail_indicator2');
			$ind_detail3 = $this->input->post('detail_indicator3');
			$ind_detail4 = $this->input->post('detail_indicator4');
			$ind_detail5 = $this->input->post('detail_indicator5');
			
			$this->personindicator->addPersonIndicator($userID, $year, $round, $depID, $divID, $order, $indicatorName, $weight,
													   $ind1, $ind2, $ind3, $ind4, $ind5, $ind_detail1, $ind_detail2, $ind_detail3, $ind_detail4, $ind_detail5, 1);					
			$this->session->set_flashdata('success', 'บันทึกข้อมูลตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');
		} else {
			$data['error_msg'] = "ผู้ดูแลระบบยังไม่ได้ตั้งค่ารอบการประเมิน<BR>กรุณาติดต่อผู้ดูแลระบบ";
			$this->load->view('evaluate/errorPersonEvaluation.php', $data);			
		}
		
		redirect('person_evaluation/confirmIndicator/'.$userID, 'location');
	}

	
	function viewEvaluation($id)
	{
		$userID = $id;
		
		$tmp = $this->user->getMinProfile($userID);
		$data['user'] =  $tmp[0];
		$divID  = $tmp[0]['divID'];
		$depID  = $tmp[0]['depID'];
			
		
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$data['title'] = "MFA - View Indicator ";
				
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			$data['indicators'] = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);
			$data['array_i'] = $this->personindicator->getCoreName($userID, $year, $round, $depID, $divID);
			$saved_activities = $this->personindicator->getSavedActivities($userID, $year, $round, $depID, $divID);
			
			$numSavedActivity = count($saved_activities);
			for($i = 0; $i < $numSavedActivity; $i++) {
				$score = array();
				$activity_score = $this->personindicator->getActivityScore($saved_activities[$i]['ID']);
				$numind = count($activity_score);
				for($j = 0; $j < $numind; $j++) {
					$pid = $activity_score[$j]['pid'];
					$score[(string)$pid] = $activity_score[$j]['execscore'];
				}
				$saved_activities[$i]['score'] = $score;
			}
			
			$data['saved_activities'] = $saved_activities;
			
			$piStatus = $this->personindicator->getIndicatorStatus($userID, $year, $round, $depID, $divID);

			$this->load->view('evaluate/viewPersonEvaluation', $data);

		} else {			
			echo "No evaluate round selected";
			die();
		}
		
	}
	
	function managePersonEvaluation()
	{
		$userID = $this->session->userdata('sessid');
		$divID  = $this->session->userdata('sessdiv');
		$depID  = $this->session->userdata('sessdep');
		
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$data['title'] = "MFA - View Indicator ";
				
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			$data['indicators'] = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);
			$data['array_i'] = $this->personindicator->getCoreName($userID, $year, $round, $depID, $divID);
			$saved_activities = $this->personindicator->getSavedActivities($userID, $year, $round, $depID, $divID);
			
			$numSavedActivity = count($saved_activities);
			for($i = 0; $i < $numSavedActivity; $i++) {
				$score = array();
				$activity_score = $this->personindicator->getActivityScore($saved_activities[$i]['ID']);
				$numind = count($activity_score);
				for($j = 0; $j < $numind; $j++) {
					$pid = $activity_score[$j]['pid'];
					$score[(string)$pid] = $activity_score[$j]['score'];
				}
				$saved_activities[$i]['score'] = $score;
			}
			
			$data['saved_activities'] = $saved_activities;
			
			$piStatus = $this->personindicator->getIndicatorStatus($userID, $year, $round, $depID, $divID);

			if($piStatus < 2) {
				$data['error_msg'] = "กรุณาทำข้อตกลงตัวชี้วัดรายบุคคลกับผู้บังคับบัญชาก่อน";
				$this->load->view('evaluate/errorPersonEvaluation.php', $data);				
			} else if($piStatus == 2) {
				$this->load->view('evaluate/managePersonEvaluation.php', $data);
			} else if(($piStatus == 3) || ($piStatus == 4)) {
				$data['piStatus'] = $piStatus;
				$this->load->view('evaluate/displayPersonEvaluation.php', $data);
			} else if($piStatus == 5) {
				//OK now
			} else {
				$data['error_msg'] = "กรุณาทำข้อตกลงตัวชี้วัดรายบุคคลกับผู้บังคับบัญชาก่อน ".$piStatus;
				$this->load->view('evaluate/errorPersonEvaluation.php', $data);
			}	

		} else {			
			echo "No evaluate round selected";
			die();
		}
		
	}

	function execAgreeEvaluation($id) {
		$userID = $id;
		$div_id  = $this->session->userdata('sessdiv');
		$dep_id  = $this->session->userdata('sessdep');
		$option  = $this->input->post("option");
		
		$score = $this->input->post("score");
		$act_score = $this->input->post("execScore");
		
		$active_evalround = $this->personindicator->getActiveEvalRound();
		if(count($active_evalround) == 1) {
			$year = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
		} else {
			echo "Please set evaluation year and round first";
			die();
		}
		//$coreSkillName = $this->input->post("evalName");
		//$expectVal = $this->input->post("expVal");
		$exec_score = $this->input->post("score");
		$exec_core_score = $this->input->post("evalScore");
		$res = $this->personindicator->getCoreName($userID, $year, $round, $dep_id, $div_id);
		
		$this->personindicator->evalAddExecScore($userID, $year ,$round, $dep_id, $div_id, $exec_score);	
		
		$this->personindicator->coreAddExecScore($userID, $year ,$round, $dep_id, $div_id, $exec_core_score, $res);

		$saved_activities = $this->personindicator->getSavedActivities($userID, $year, $round, $dep_id, $div_id);
			
		$numSavedActivity = count($saved_activities);
		$counter = 0;
		for($i = 0; $i < $numSavedActivity; $i++) {
				$activity_score = $this->personindicator->getActivityScore($saved_activities[$i]['ID']);
				$numind = count($activity_score);
				for($j = 0; $j < $numind; $j++) {
					$this->personindicator->setExecActivityScore($activity_score[$j]['id'], $act_score[$counter]);
					$counter++;
				}
		}
		if($option == "record") {
			$this->session->set_flashdata('success', 'บันทึกข้อมูลตัวชี้วัดผลสัมฤทธิ์เรียบร้อยแล้ว');
			redirect('person_evaluation/confirmEvaluation/'.$id, 'location');	
		} else if($option == "prove") {
			$this->personindicator->setIndicatorStatus($userID, $year, $round, $dep_id, $div_id, 4);		
			$this->session->set_flashdata('success', 'ส่งข้อมูลข้อมูลตัวชี้วัดผลสัมฤทธิ์ให้ผู้บังคับบัญชาพิจารณาเรียบร้อยแล้ว');
			redirect('person_evaluation/viewEvaluation/'.$id, 'location');				
		}
				
	}
	
	
	function saveEvaluation() {
		$userID = $this->session->userdata('sessid');
		$div_id  = $this->session->userdata('sessdiv');
		$dep_id  = $this->session->userdata('sessdep');
		$option = $this->input->post("option");
		
		$score = $this->input->post("score");

		$active_evalround = $this->personindicator->getActiveEvalRound();
		if(count($active_evalround) == 1) {
			$year = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
		} else {
			echo "Please set evaluation year and round first";
			die();
		}
		
		$coreSkillName = $this->input->post("evalName");
		$expectVal = $this->input->post("expVal");
		$selfscore = $this->input->post("evalScore");
		$res = $this->personindicator->getCoreName($userID, $year, $round, $dep_id, $div_id);
		
		$this->personindicator->evalAddScore($userID, $year ,$round, $dep_id, $div_id, $score);	
		
		$this->personindicator->coreAddScore($userID, $year ,$round, $dep_id, $div_id, $coreSkillName ,$expectVal, $selfscore, $res);

		if($option == "record") {
			$this->session->set_flashdata('success', 'บันทึกข้อมูลตัวชี้วัดผลสัมฤทธิ์เรียบร้อยแล้ว');	
		} else if($option == "prove") {
			$this->personindicator->setIndicatorStatus($userID, $year, $round, $dep_id, $div_id, 3);		
			$this->session->set_flashdata('success', 'ส่งข้อมูลข้อมูลตัวชี้วัดผลสัมฤทธิ์ให้ผู้บังคับบัญชาพิจารณาเรียบร้อยแล้ว');				
		}
		redirect('person_evaluation/managePersonEvaluation', 'location');
	}
	
	function deleteSavedActivity($id) {
		//delete person_indicator_activity
		$this -> personindicator->deleteActivity($id);
		//delete person_indicator_activity_score
		$this -> personindicator -> deleteActivityScore($id);
		$this->session->set_flashdata('success', 'ลบผลการดำเนินการเรียบร้อยแล้ว');
		redirect('person_evaluation/managePersonEvaluation', 'location');
	}
	
	
	function saveActivity() {
		$userID = $this->session->userdata('sessid');
		$divID  = $this->session->userdata('sessdiv');
		$depID  = $this->session->userdata('sessdep');

		$active_evalround = $this->personindicator->getActiveEvalRound();
		$year = $active_evalround[0]['year'];
		$round = $active_evalround[0]['round'];
				
		$activityDate = $this->input->post("activity_date");		
		$activityName = $this->input->post("activityName");
		$documentName = $this->input->post("documentName");
		
		$indicatorID = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);
		$indicatorVal = $this->input->post("indicatorVal");

		$activityID = $this->personindicator->addActivity($userID, $depID, $divID, $year, $round, $activityDate, $activityName, $documentName);

		$this->personindicator->activityAddScore($activityID, $indicatorID, $indicatorVal);	
		
		$this->session->set_flashdata('success', 'บันทึกผลการดำเนินภารกิจเรียบร้อยแล้ว');	
		
		redirect('person_evaluation/managePersonEvaluation', 'location');
	}

	function confirmEvaluation($id)
	{
		//todo add execscore
		$userID = $id;
		$divID  = $this->session->userdata('sessdiv');
		$depID  = $this->session->userdata('sessdep');
		
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$data['title'] = "MFA - View Indicator ";
				
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			$data['indicators'] = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);
			
			$data['array_i'] = $this->personindicator->getCoreName($userID, $year, $round, $depID, $divID);
			
			$saved_activities = $this->personindicator->getSavedActivities($userID, $year, $round, $depID, $divID);
			
			$numSavedActivity = count($saved_activities);
			for($i = 0; $i < $numSavedActivity; $i++) {
				$score = array();
				$exec_act_score = array();
				$activity_score = $this->personindicator->getActivityScore($saved_activities[$i]['ID']);
				$numind = count($activity_score);
				for($j = 0; $j < $numind; $j++) {
					$pid = $activity_score[$j]['pid'];
					$score[(string)$pid] = $activity_score[$j]['score'];
					$exec_act_score[(string)$pid] = $activity_score[$j]['execscore'];
				}
				$saved_activities[$i]['score'] = $score;
				$saved_activities[$i]['execscore'] = $exec_act_score;
			}
			
			$data['saved_activities'] = $saved_activities;
			$tmp = $this->user->getMinProfile($id);
			$data['user'] =  $tmp[0];
			
			$this->load->view('evaluate/confirmPersonEvaluation.php', $data);
		} else {			
			echo "No evaluate round selected";
			die();
		}
		
	}

	function viewPersonIndicatorDetail($id) {
		$indicator = $this->personindicator->getIndicatorDetail($id);
		$data['indicator'] = $indicator[0];
		$this->load->view('evaluate/showPersonIndicatorDetail.php', $data);
	}
	
	function editPersonIndicatorDetail($id) {
		$indicator = $this->personindicator->getIndicatorDetail($id);
		$data['indicator'] = $indicator[0];
		$this->load->view('evaluate/editPersonIndicatorDetail.php', $data);
	}
	
	function editPersonIndicatorDetailFromExecDiv($id, $user_id) {
		$indicator = $this->personindicator->getIndicatorDetail($id);
		$data['indicator'] = $indicator[0];
		$data['user_id'] = $user_id;
		$this->load->view('evaluate/editPersonIndicatorDetailFromExecDiv.php', $data);
	}
	
	function deletePersonIndicatorDetail($id) {
			$this->personindicator->deletePersonIndicator($id);							
			$this->session->set_flashdata('success', 'ลบข้อมูลตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');		
			redirect('person_evaluation/managePersonIndicator', 'location');		
	}
	
	function deletePersonIndicatorDetailFromExecDiv($id, $user_id) {
			$this->personindicator->deletePersonIndicator($id, 1);							
			$this->session->set_flashdata('success', 'ลบข้อมูลตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');		
			redirect('person_evaluation/confirmIndicator/'.$user_id, 'location');		
	}
	
	function savePersonIndicatorDetail($id) {

			$data['title'] = "MFA - Personal Indicator Management";				

			$order = $this->input->post("order");
			$indicatorName = $this->input->post("indicatorName");
			$weight = $this->input->post("weight");
			$ind1 = $this->input->post('indicator1');
			$ind2 = $this->input->post('indicator2');
			$ind3 = $this->input->post('indicator3');
			$ind4 = $this->input->post('indicator4');
			$ind5 = $this->input->post('indicator5');
			$ind_detail1 = $this->input->post('detail_indicator1');
			$ind_detail2 = $this->input->post('detail_indicator2');
			$ind_detail3 = $this->input->post('detail_indicator3');
			$ind_detail4 = $this->input->post('detail_indicator4');
			$ind_detail5 = $this->input->post('detail_indicator5');
			
			$this->personindicator->updatePersonIndicator($id, $order, $indicatorName, $weight,
													   $ind1, $ind2, $ind3, $ind4, $ind5, $ind_detail1, $ind_detail2, $ind_detail3, $ind_detail4, $ind_detail5);					
			$this->session->set_flashdata('success', 'บันทึกข้อมูลตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');
			
			redirect('person_evaluation/managePersonIndicator', 'location');
	}

	function savePersonIndicatorDetailFromExecDiv($id, $user_id) {

			$data['title'] = "MFA - Personal Indicator Management";				

			$order = $this->input->post("order");
			$indicatorName = $this->input->post("indicatorName");
			$weight = $this->input->post("weight");
			$ind1 = $this->input->post('indicator1');
			$ind2 = $this->input->post('indicator2');
			$ind3 = $this->input->post('indicator3');
			$ind4 = $this->input->post('indicator4');
			$ind5 = $this->input->post('indicator5');
			$ind_detail1 = $this->input->post('detail_indicator1');
			$ind_detail2 = $this->input->post('detail_indicator2');
			$ind_detail3 = $this->input->post('detail_indicator3');
			$ind_detail4 = $this->input->post('detail_indicator4');
			$ind_detail5 = $this->input->post('detail_indicator5');
			
			$this->personindicator->updatePersonIndicator($id, $order, $indicatorName, $weight,
													   $ind1, $ind2, $ind3, $ind4, $ind5, $ind_detail1, $ind_detail2, $ind_detail3, $ind_detail4, $ind_detail5,1);					
			$this->session->set_flashdata('success', 'บันทึกข้อมูลตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');
			
			redirect('person_evaluation/confirmIndicator/'.$user_id, 'location');
	}
}
?>