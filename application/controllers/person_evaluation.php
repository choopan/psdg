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
	
	function execCancelIndicatorFromDep($id) {
		$this->personindicator->setPIStatus($id, 1);
		$this->session->set_flashdata('failed', 'ไม่อนุมัติตัวชี้วัดรายลุคคลเรียบร้อยแล้ว');
		redirect('person_evaluation/depManagePersonIndicator', 'location');
	}
	
	function execCancelEvaluationFromDep($id) {
		$this->personindicator->setEvalStatusByPID($id, 1);
		$this->session->set_flashdata('failed', 'ไม่อนุมัติรายงานผลการปฏิบัติราชการระดับบุคคลเรียบร้อยแล้ว');
		redirect('person_evaluation/depManagePersonEvaluation', 'location');
	}
	
	function execAgreeIndicatorFromDep($id, $user_id, $sumweight) {
		if((float)$sumweight == 1) {
			$this->personindicator->setPIStatus($id, 3);
			$this->session->set_flashdata('success', 'อนุมัติตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');
			redirect('person_evaluation/depManagePersonIndicator', 'location');
		} else {
			$this->session->set_flashdata('failed', 'ผลรวมของค่าน้ำหนักไม่เท่ากับ 1');
			redirect('person_evaluation/confirmExecIndicatorFromDep/'.$user_id, 'location');			
		}
	}
	
	function execAgreeEvaluationFromDep($id, $user_id) {
			$this->personindicator->setEvalStatusByPID($id, 3);
			$this->session->set_flashdata('success', 'อนุมัติรายงานผลการปฏิบัติการระดับบุคคลเรียบร้อยแล้ว');
			redirect('person_evaluation/depManagePersonEvaluation', 'location');
	}
	
	function managePersonIndicator() {
		$data['title'] = "MFA - Personal Indicator Management";	

		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			$userID = $this->session->userdata('sessid');
			$divID  = $this->session->userdata('sessdiv');
			$depID  = $this->session->userdata('sessdep');
			
			$person_indicator_id = $this->personindicator->getPersonIndicatorID($userID, $depID, $divID, $year, $round);
			
			$data['indicators'] = $this->personindicator->listIndicatorByPID($person_indicator_id);	

			$piStatus = $this->personindicator->getPIStatus($userID, $depID, $divID, $year, $round);
			
			if($piStatus == 0) {
				$this->load->view('evaluate/managePersonIndicator.php', $data);
			} else {
				switch($piStatus) {
					case 1  : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
					case 2  : $data['status_msg'] = '<span class="label label-warning">ผ่านการอนุมัติขั้นต้น</span>'; break;
					case 3  : $data['status_msg'] = '<span class="label label-success">ผ่านการอนุมัติแล้ว</span> <a href="'.base_url().'index.php/Managewarranty/gen_indic_cm"><img src="'.base_url().'images/word_k005.png" title="ส่งออกรายงาน"></a>'; break;
					default : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;	
				}
				$this->load->view('evaluate/displayPersonIndicator.php', $data);
			}	

		} else {
			$data['error_msg'] = "ผู้ดูแลระบบยังไม่ได้ตั้งค่ารอบการประเมิน<BR>กรุณาติดต่อผู้ดูแลระบบ";
			$this->load->view('evaluate/errorPersonEvaluation.php', $data);
		}		
	}
	
	
	function addPersonIndicator() {
		$data['title'] = "MFA - Personal Indicator Management";				
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {

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
	
	function deletePersonIndicatorDetail($id) {
			$this->personindicator->deletePersonIndicator($id);							
			$this->session->set_flashdata('success', 'ลบข้อมูลตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');		
			redirect('person_evaluation/managePersonIndicator', 'location');		
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
	

	// Div Executive View Indicator
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
			$data['user_info'] = $this->user->getUserFromDiv($data['userID'], $data['divID'],$year, $round); 
			$this->load->view('evaluate/displayPersonIndicatorInDiv.php', $data);
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
			$pi_set = $this->personindicator->getPersonIndicatorID($userID, $depID, $divID, $year, $round);
			$data['pi_set'] = $pi_set;
			$data['indicators'] = $this->personindicator->listIndicatorByPID($pi_set);	
			
			
			$tmp = $this->user->getMinProfile($id);
			$data['user'] =  $tmp[0];
			$this->load->view('evaluate/confirmPersonIndicator.php', $data);
		} else {
			echo "No evaluate round selected";
			die();
		}		
	}


	
	///////////////////// OLD CODE /////////////////////////////////////
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
	
	function agreeIndicatorFromDep($id, $user_id, $sumweight) {
		if((float)$sumweight == 1) {
			$this->personindicator->setPIStatus($id, 3);
			$this->session->set_flashdata('success', 'อนุมัติตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');
			redirect('person_evaluation/depManagePersonIndicator', 'location');
		} else {
			$this->session->set_flashdata('failed', 'ผลรวมของค่าน้ำหนักไม่เท่ากับ 1');
			redirect('person_evaluation/confirmIndicatorFromDep/'.$user_id, 'location');			
		}
	}
	
	
	function minCancelEvaluation($userID) {
		
		$tmp = $this->user->getMinProfile($userID);
		$depID  = $tmp[0]['depID'];
		$divID  = $tmp[0]['divID'];
	
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$pi_set = $this->personindicator->getPersonIndicatorID($userID, $depID, $divID, $year, $round);		
			$this->personindicator->setEvalStatusByPID($pi_set, 1);
			$this->session->set_flashdata('success', 'ยกเลิกการอนุมัติรายงานผลการปฏิบัติราขการระดับบุคคลเรียบร้อยแล้ว');
		} else {
			$this->session->set_flashdata('failed', 'รอบปีประเมินไม่ได้ถูกตั้งค่า');				
		}
		redirect('person_evaluation/minManagePersonEvaluation', 'location');		
	}

	
	
	function minCancelIndicator($userID) {
		
		$tmp = $this->user->getMinProfile($userID);
		$depID  = $tmp[0]['depID'];
		$divID  = $tmp[0]['divID'];
	
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$pi_set = $this->personindicator->getPersonIndicatorID($userID, $depID, $divID, $year, $round);		
			$this->personindicator->setPIStatus($pi_set, 1);
			$this->personindicator->setEvalStatusByPID($pi_set, 0);
			$this->session->set_flashdata('success', 'ยกเลิกการอนุมัติตัวชี้วัดรายลุคคลเรียบร้อยแล้ว');
		} else {
			$this->session->set_flashdata('failed', 'รอบปีประเมินไม่ได้ถูกตั้งค่า');	
			
		}
		redirect('person_evaluation/minManagePersonIndicator', 'location');		
	}
	
	function execCancelEvaluation($id) {
		$this->personindicator->setEvalStatusByPID($id, 0);
		$this->session->set_flashdata('failed', 'ไม่อนุมัติผลการประเมินรายลุคคลเรียบร้อยแล้ว');
		redirect('person_evaluation/divManagePersonEvaluation', 'location');
	}
	
	function execCancelIndicator($id) {
		$this->personindicator->setPIStatus($id, 0);
		$this->session->set_flashdata('failed', 'ไม่อนุมัติตัวชี้วัดรายลุคคลเรียบร้อยแล้ว');
		redirect('person_evaluation/divManagePersonIndicator', 'location');
	}
	

	function cancelIndicatorFromDep($id) {
		$this->personindicator->setPIStatus($id, 1);
		$this->session->set_flashdata('failed', 'ไม่อนุมัติตัวชี้วัดรายลุคคลเรียบร้อยแล้ว');
		redirect('person_evaluation/depManagePersonIndicator', 'location');
	}
	

	function viewIndicatorFromDep($id) {
		$data['title'] = "MFA - Person Indicator Management";
		$userID = $id;
		$tmp = $this->user->getMinProfile($id);
		$data['user'] =  $tmp[0];
		$depID  = $tmp[0]['depID'];
		$divID  = $tmp[0]['divID'];
	
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year'] = $year;
			$data['round'] = $round;
			$data['indicators'] = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);	
		
			$piStatus = $this->personindicator->getPIStatus($userID, $depID, $divID, $year, $round);
			
			switch($piStatus) {
					case 1  : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
					case 2  : $data['status_msg'] = '<span class="label label-warning">ผ่านการอนุมัติขั้นต้น</span>'; break;
					case 3  : $data['status_msg'] = '<span class="label label-success">ผ่านการอนุมัติแล้ว</span>'; break;
					default : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
			}
			$this->load->view('evaluate/viewPersonIndicator.php', $data);
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
			$piStatus = $this->personindicator->getPIStatus($userID, $depID, $divID, $year, $round);
			
			switch($piStatus) {
					case 1  : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
					case 2  : $data['status_msg'] = '<span class="label label-warning">ผ่านการอนุมัติขั้นต้น</span>'; break;
					case 3  : $data['status_msg'] = '<span class="label label-success">ผ่านการอนุมัติแล้ว</span>'; break;
					default : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
			}
			$this->load->view('evaluate/viewPersonIndicator.php', $data);
		} else {
			echo "No evaluate round selected";
			die();
		}						
	}


	function confirmIndicatorFromDep($id) {
		$data['title'] = "MFA - Person Indicator Management";
		$tmp = $this->user->getMinProfile($id);
		$userID = $id;
		$depID  = $tmp[0]['depID'];
		$divID  = $tmp[0]['divID'];
	
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year'] = $year;
			$data['round'] = $round;
			$pi_set = $this->personindicator->getPersonIndicatorID($userID, $depID, $divID, $year, $round);
			$data['pi_set'] = $pi_set;
			$data['indicators'] = $this->personindicator->listIndicatorByPID($pi_set);	
			$data['user'] =  $tmp[0];
			
			$piStatus = $this->personindicator->getPIStatus($userID, $depID, $divID, $year, $round);
			
			switch($piStatus) {
					case 1  : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
					case 2  : $data['status_msg'] = '<span class="label label-warning">ผ่านการอนุมัติขั้นต้น</span>'; break;
					case 3  : $data['status_msg'] = '<span class="label label-success">ผ่านการอนุมัติแล้ว</span>'; break;
					default : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
			}
			$this->load->view('evaluate/viewPersonIndicatorFromDep.php', $data);
		} else {
			echo "No evaluate round selected";
			die();
		}		
	}


	function confirmExecIndicatorFromDep($id) {
		$data['title'] = "MFA - Person Indicator Management";
		$tmp = $this->user->getMinProfile($id);
		$userID = $id;
		$depID  = $tmp[0]['depID'];
		$divID  = $tmp[0]['divID'];
	
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year'] = $year;
			$data['round'] = $round;
			$pi_set = $this->personindicator->getPersonIndicatorID($userID, $depID, $divID, $year, $round);
			$data['pi_set'] = $pi_set;
			$data['indicators'] = $this->personindicator->listIndicatorByPID($pi_set);	
			$data['user'] =  $tmp[0];
			$this->load->view('evaluate/confirmPersonIndicatorFromDep.php', $data);
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
			$user_info = $this->user->getUserFromDiv($data['userID'], $data['divID'], $year, $round);
			$data['user_info'] = $user_info;
			$user_indicator_score = array();
			$user_core_score = array(); 
			foreach($user_info as $ui) {
				$score = $this->personindicator->getUserScore($ui['userID'], $ui['depID'], $ui['divID'], $year, $round);
				$tmpID = $ui['userID'];
				if(count($score) != 0) {
					$user_indicator_score["$tmpID"] = $score[0]['exec_indicator_score'];
					$user_core_score["$tmpID"] = $score[0]['exec_core_score'];
				} else {
					$user_indicator_score["$tmpID"] = 0;
					$user_core_score["$tmpID"] = 0;
				}
			}
			$data['user_indicator_score'] = $user_indicator_score;
			$data['user_core_score'] = $user_core_score;
			$this->load->view('evaluate/displayPersonEvaluationInDiv.php', $data);
		} else {			
			echo "No evaluate round selected";
			die();
		}
	}

	function depManagePersonEvaluation() {
		$data['title'] = "MFA - Personal Evaluation Management";	
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
			
			
			$user_indicator_score = array();
			$user_core_score = array(); 
			foreach($user_info as $ui) {
				$score = $this->personindicator->getUserScore($ui['userID'], $ui['depID'], $ui['divID'], $year, $round);
				$tmpID = $ui['userID'];
				if(count($score) != 0) {
					$user_indicator_score["$tmpID"] = $score[0]['exec_indicator_score'];
					$user_core_score["$tmpID"] = $score[0]['exec_core_score'];
				} else {
					$user_indicator_score["$tmpID"] = 0;
					$user_core_score["$tmpID"] = 0;
				}
			}
			
			foreach($exec_info as $ui) {
				$score = $this->personindicator->getUserScore($ui['userID'], $ui['depID'], $ui['divID'], $year, $round);
				$tmpID = $ui['userID'];
				if(count($score) != 0) {
					$user_indicator_score["$tmpID"] = $score[0]['exec_indicator_score'];
					$user_core_score["$tmpID"] = $score[0]['exec_core_score'];
				} else {
					$user_indicator_score["$tmpID"] = 0;
					$user_core_score["$tmpID"] = 0;
				}
			}
			
			$data['user_indicator_score'] = $user_indicator_score;
			$data['user_core_score'] = $user_core_score;
			
			$data['exec_info'] = $exec_info;
			$data['user_info'] = $user_info;
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
			$data['user_info'] = $this->user->getAllProfileExceptDepExec(); 
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
			$data['user_info'] = $this->user->getAllProfileExceptDepExec(); 
			$this->load->view('evaluate/displayPersonIndicatorInMin.php', $data);
		} else {			
			echo "No evaluate round selected";
			die();
		}
	}
	
		
	function submitEvaluation() {
			$active_evalround = $this->personindicator->getActiveEvalRound();

			if(count($active_evalround) == 1) {
				$year = $active_evalround[0]['year'];
				$round = $active_evalround[0]['round'];
				$userID = $this->session->userdata('sessid');
				$depID = $this->session->userdata('sessdep');
				$divID = $this->session->userdata('sessdiv');
				
				//Check at least 1 activity in the indicator				
				$pid = $this->personindicator->getPersonIndicatorID($userID, $depID, $divID, $year, $round);
				$detail_id = $this->personindicator->listIndicatorByPID($pid);
				for($i = 0; $i < count($detail_id); $i++) {
					if($this->personindicator->getNumActivity($detail_id[$i]['ID']) == 0) {
						$this->session->set_flashdata('failed', 'ไม่สามารถส่งแบบประเมินได้ ต้องมีกิจกรรมที่ตอบตัวชี้วัดอย่างน้อย 1 กิจกรรม ต่อ 1 ตัวชี้วัด');				
						redirect('person_evaluation/managePersonEvaluation', 'location');								
					}
				}
				
				$this->personindicator->setEvaluationStatus($pid, 1);
				$this->session->set_flashdata('success', 'ส่งแบบประเมินผลการปฏิบัติราชการรายบุคคลให้ผู้บังคับบัญชาพิจารณาเรียบร้อยแล้ว');				
				redirect('person_evaluation/managePersonEvaluation', 'location');		
				
			} else {
				$data['error_msg'] = "ผู้ดูแลระบบยังไม่ได้ตั้งค่ารอบการประเมิน<BR>กรุณาติดต่อผู้ดูแลระบบ";
				$this->load->view('evaluate/errorPersonEvaluation.php', $data);				
			}
		
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

	function submitIndicatorFormFromExecDep($id) {
		//$year = $this->session->userdata('sessyear');
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {

			$data['title'] = "MFA - Personal Indicator Management";				

			$userID = $id;
			$tmp = $this->user->getMinProfile($userID);
			$data['user'] =  $tmp[0];
			$divID  = $tmp[0]['divID'];
			$depID  = $tmp[0]['depID'];
						
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
		
		redirect('person_evaluation/confirmExecIndicatorFromDep/'.$userID, 'location');
	}

	function confirmEvaluationFromDep($id)
	{
		$userID = $id;
		
		$tmp = $this->user->getMinProfile($userID);
		$data['user'] =  $tmp[0];
		$divID  = $tmp[0]['divID'];
		$depID  = $tmp[0]['depID'];
			
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$data['title'] = "MFA - View Evaluation ";
				
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			
			
			$pi_set = $this->personindicator->getPersonIndicatorID($userID, $depID, $divID, $year, $round);
			$data['pi_set'] = $pi_set;			
			
			$indicators = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);
			$data['indicators'] = $indicators;
			
			$total_evaluation_score = $this->personindicator->getEvaluationScore($userID, $year, $round, $depID, $divID);
			$data['exec_indicator_total_score'] = $total_evaluation_score[0]['exec_indicator_score'];
			$data['exec_core_total_score'] = $total_evaluation_score[0]['exec_core_score'];

			
			$data['userID'] = $userID;
					
			$all_saved_activities = array();
			$indicator_exec_avg_scores = array();
			$all_indicator_exec_score = 0;
			
			for($i = 0; $i < count($indicators); $i++) {
				$person_indicator_id = $indicators[$i]['ID'];
				$saved_activities = $this->personindicator->getSavedActivitiesByPID($person_indicator_id);
				
				//Calculate indicator score
				$indicator_exec_avg_score = 0;
				for($j = 0; $j < count($saved_activities); $j++) {
					$indicator_exec_avg_score += $saved_activities[$j]['execscore'];
				}
				
				if(count($saved_activities) != 0) {
					$indicator_exec_avg_score /= count($saved_activities);
				} else {
					$indicator_exec_avg_score = 0;
				}
				
				$all_indicator_exec_score += ($indicator_exec_avg_score * $indicators[$i]['weight']);
				
				$indicator_exec_avg_scores["$person_indicator_id"] = $indicator_exec_avg_score;
				
				$all_saved_activities["$person_indicator_id"] = $saved_activities;
			}
			
						
			$data['cores'] = $this->personindicator->getCoreName($userID, $year, $round, $depID, $divID);			
			$data['all_saved_activities'] = $all_saved_activities;
			$data['indicator_exec_avg_scores'] = $indicator_exec_avg_scores;
			$data['all_indicator_exec_score']  = $all_indicator_exec_score;
			
			
			$evalStatus = $this->personindicator->getPIEvalStatus($userID, $depID, $divID, $year, $round);
			
			switch($evalStatus) {
						case 0  : $data['status_msg'] = '<span class="label label-danger">ยังไม่ส่งรายงาน</span>'; break;
						case 1  : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
						case 2  : $data['status_msg'] = '<span class="label label-warning">ผ่านการอนุมัติขั้นต้น</span>'; break;
						case 3  : $data['status_msg'] = '<span class="label label-success">ผ่านการอนุมัติแล้ว</span>'; break;
						default : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;	
			}
				
			$this->load->view('evaluate/confirmPersonEvaluationFromDep.php', $data);
			
		}	else {
						
			$data['error_msg'] = "โปรดติดต่่อผู้ดูแลระบบ ยังไม่มีการตั้งรอบการประเมิน";
			$this->load->view('evaluate/errorPersonEvaluation.php', $data);					
		}		
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
			$data['title'] = "MFA - View Evaluation ";
				
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			
			
			$indicators = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);
			$data['indicators'] = $indicators;
			
			$total_evaluation_score = $this->personindicator->getEvaluationScore($userID, $year, $round, $depID, $divID);
			$data['exec_indicator_total_score'] = $total_evaluation_score[0]['exec_indicator_score'];
			$data['exec_core_total_score'] = $total_evaluation_score[0]['exec_core_score'];

			
			$data['userID'] = $userID;
					
			$all_saved_activities = array();
			$indicator_exec_avg_scores = array();
			$all_indicator_exec_score = 0;
			
			for($i = 0; $i < count($indicators); $i++) {
				$person_indicator_id = $indicators[$i]['ID'];
				$saved_activities = $this->personindicator->getSavedActivitiesByPID($person_indicator_id);
				
				//Calculate indicator score
				$indicator_exec_avg_score = 0;
				for($j = 0; $j < count($saved_activities); $j++) {
					$indicator_exec_avg_score += $saved_activities[$j]['execscore'];
				}
				
				if(count($saved_activities) != 0) {
					$indicator_exec_avg_score /= count($saved_activities);
				} else {
					$indicator_exec_avg_score = 0;
				}
				
				$all_indicator_exec_score += ($indicator_exec_avg_score * $indicators[$i]['weight']);
				
				$indicator_exec_avg_scores["$person_indicator_id"] = $indicator_exec_avg_score;
				
				$all_saved_activities["$person_indicator_id"] = $saved_activities;
			}
			
						
			$data['cores'] = $this->personindicator->getCoreName($userID, $year, $round, $depID, $divID);			
			$data['all_saved_activities'] = $all_saved_activities;
			$data['indicator_exec_avg_scores'] = $indicator_exec_avg_scores;
			$data['all_indicator_exec_score']  = $all_indicator_exec_score;
			
			
			$evalStatus = $this->personindicator->getPIEvalStatus($userID, $depID, $divID, $year, $round);
			
			switch($evalStatus) {
						case 0  : $data['status_msg'] = '<span class="label label-danger">ยังไม่ส่งรายงาน</span>'; break;
						case 1  : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
						case 2  : $data['status_msg'] = '<span class="label label-warning">ผ่านการอนุมัติขั้นต้น</span>'; break;
						case 3  : $data['status_msg'] = '<span class="label label-success">ผ่านการอนุมัติแล้ว</span>'; break;
						default : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;	
			}
				
			$this->load->view('evaluate/viewPersonEvaluation.php', $data);
			
		}	else {
						
			$data['error_msg'] = "โปรดติดต่่อผู้ดูแลระบบ ยังไม่มีการตั้งรอบการประเมิน";
			$this->load->view('evaluate/errorPersonEvaluation.php', $data);					
		}		
	}
	
	


	function divExecSaveCoreScore($pid, $userID) {
		$user = $this->user->getMinProfile($userID);
		$divID  = $user[0]['divID'];
		$depID  = $user[0]['depID'];
		
		$execScore = $this->input->post('execEvalScore');
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$data['title'] = "MFA - View Indicator ";
				
			$year  = $active_evalround[0]['year'];
			$evalRound = $active_evalround[0]['round'];
			
			$this->personindicator->divExecUpdateCoreSore($pid, $userID, $year ,$evalRound, $depID, $divID, $execScore);
			$this->session->set_flashdata('success', 'บันทึกคะแนนประเมินสมรรณะเรียบร้อยแล้ว');			
			redirect('person_evaluation/confirmEvaluation/'.$userID, 'location');
			
		} else {
			$data['error_msg'] = "ผู้ดูแลระบบยังไม่ได้ตั้งค่ารอบการประเมิน<BR>กรุณาติดต่อผู้ดูแลระบบ";
			$this->load->view('evaluate/errorPersonEvaluation.php', $data);
		}
		
	}
	
	
	function saveCoreScore($pid) {
		$userID = $this->session->userdata('sessid');
		$divID  = $this->session->userdata('sessdiv');
		$depID  = $this->session->userdata('sessdep');
		
		$coreSkillName = $this->input->post('coreSkillName');
		$expectVal = $this->input->post('expectVal');
		$evalScore = $this->input->post('evalScore');
		
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$data['title'] = "MFA - View Indicator ";
				
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
		
			//add and recalculate core score
			$this->personindicator->coreAddScore($pid, $userID, $year ,$round, $depID, $divID, $coreSkillName ,$expectVal, $evalScore);
			$this->session->set_flashdata('success', 'บันทึกคะแนนประเมินสมรรณะเรียบร้อยแล้ว');			
			redirect('person_evaluation/managePersonEvaluation', 'location');
			
			
		} else {
			$data['error_msg'] = "ผู้ดูแลระบบยังไม่ได้ตั้งค่ารอบการประเมิน<BR>กรุณาติดต่อผู้ดูแลระบบ";
			$this->load->view('evaluate/errorPersonEvaluation.php', $data);
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
			
			//choopan stll user it	$pinumber =  $this->personindicator->getPInumber($userID, $year, $round, $depID, $divID);
	
			$piStatus = $this->personindicator->getPIStatus($userID, $depID, $divID, $year, $round);

			if($piStatus != 3) {
				$data['error_msg'] = "กรุณาทำข้อตกลงตัวชี้วัดรายบุคคลกับผู้บังคับบัญชาก่อน";
				$this->load->view('evaluate/errorPersonEvaluation.php', $data);		
										
			} else {
			
				$indicators = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);
				$data['indicators'] = $indicators;
			
				$total_evaluation_score = $this->personindicator->getEvaluationScore($userID, $year, $round, $depID, $divID);
				$data['indicator_total_score'] = $total_evaluation_score[0]['indicator_score'];
				$data['core_total_score'] = $total_evaluation_score[0]['core_score'];
				$data['userID'] = $userID;
			//$data['']
			
			
				$all_saved_activities = array();
				$indicator_avg_scores = array();
				$all_indicator_score = 0;	
			
				for($i = 0; $i < count($indicators); $i++) {
					$person_indicator_id = $indicators[$i]['ID'];
					$saved_activities = $this->personindicator->getSavedActivitiesByPID($person_indicator_id);
				
					//Calculate indicator score
					$indicator_avg_score = 0;
					for($j = 0; $j < count($saved_activities); $j++) {
						$indicator_avg_score += $saved_activities[$j]['selfscore'];
					}
				
					if(count($saved_activities) != 0) {
						$indicator_avg_score /= count($saved_activities);
					} else {
						$indicator_avg_score = 0;
					}
				
					$all_indicator_score += ($indicator_avg_score * $indicators[$i]['weight']);
					$indicator_avg_scores["$person_indicator_id"] = $indicator_avg_score;
					$all_saved_activities["$person_indicator_id"] = $saved_activities;
				}
			
						
				$data['cores'] = $this->personindicator->getCoreName($userID, $year, $round, $depID, $divID);
				$data['all_saved_activities'] = $all_saved_activities;
				$data['indicator_avg_scores'] = $indicator_avg_scores;
				$data['all_indicator_score']  = $all_indicator_score;
				
				//choop
				$evalStatus = $this->personindicator->getPIEvalStatus($userID, $depID, $divID, $year, $round);
			
				if($evalStatus == 0) {
					$this->load->view('evaluate/managePersonEvaluation.php', $data);
				} else {
					switch($evalStatus) {
						case 1  : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;
						case 2  : $data['status_msg'] = '<span class="label label-warning">ผ่านการอนุมัติขั้นต้น</span>'; break;
						case 3  : $data['status_msg'] = '<span class="label label-success">ผ่านการอนุมัติแล้ว</span>'; break;
						default : $data['status_msg'] = '<span class="label label-danger">รอการพิจารณา</span>'; break;	
					}
					$this->load->view('evaluate/displayPersonEvaluation.php', $data);
				}	
			}	
		} else {			
			$data['error_msg'] = "โปรดติดต่่อผู้ดูแลระบบ ยังไม่มีการตั้งรอบการประเมิน";
			$this->load->view('evaluate/errorPersonEvaluation.php', $data);		
			
		}
		
	}

	function execAgreeEvaluation($pid) {
		$this->personindicator->setEvalStatusByPID($pid, 2);
		$this->session->set_flashdata('success', 'อนุมัติผลการประเมินรายลุคคลเรียบร้อยแล้ว');
		redirect('person_evaluation/divManagePersonEvaluation', 'location');
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
	
	function deleteActivity($id, $pid) {
		$this->personindicator->deleteActivity($id);
		//recalculate score
		$this->personindicator->recalculateIndicatorSelfScore($pid);
		$this->personindicator->setEvalModify($pid, 0);
		$this->session->set_flashdata('success', 'ลบผลการดำเนินการเรียบร้อยแล้ว');
		redirect('person_evaluation/managePersonEvaluation', 'location');
	}
	
	function divExecDeleteActivity($id, $pid, $user_id) {
		$this->personindicator->deleteActivity($id);
		//recalculate score
		$this->personindicator->recalculateIndicatorExecScore($pid);
		$this->personindicator->setEvalModify($pid, 1);
		$this->session->set_flashdata('success', 'ลบผลการดำเนินการเรียบร้อยแล้ว');
		redirect('person_evaluation/confirmEvaluation/'.$user_id, 'location');
	}


	function divExecEditActivity($id, $pid, $userID) {
		$activity = $this->personindicator->getActivity($id);
		$data['activity'] = $activity[0];
		$data['pid'] = $pid;
		$data['userID'] = $userID;
		$data['indicators'] = $this->personindicator->listIndicatorByPID($pid);
		$this->load->view('evaluate/showEditActivityInDiv', $data);	
	}
	
	
	function editActivity($id, $pid) {
		$activity = $this->personindicator->getActivity($id);
		$data['activity'] = $activity[0];
		$data['pid'] = $pid;
		$data['indicators'] = $this->personindicator->listIndicatorByPID($pid);
		$this->load->view('evaluate/showEditActivity', $data);	
	}
	
	
	function divExecEditActivityInfo($id, $pid, $userID) {
		$indicator = $this->input->post("indicator");
		$order = $this->input->post("order");
		$act_date = $this->input->post("activity_date");
		$act_name = $this->input->post("activity_name");
		$execscore = $this->input->post("score");
		$document_name = $this->input->post("document_name");		
		
		$activityID = $this->personindicator->updateActivityFromDiv($id, $indicator, $order, $act_date, $act_name,
														 $execscore, $document_name);
	
		$this->personindicator->recalculateIndicatorExecScore($pid);
		$this->personindicator->setEvalModify($pid, 1);
		
		$this->session->set_flashdata('success', 'แก้ไขผลการดำเนินภารกิจเรียบร้อยแล้ว');			
		redirect('person_evaluation/confirmEvaluation/'.$userID, 'location');
	
	}
	
	
	function editActivityInfo($id, $pid) {
		$indicator = $this->input->post("indicator");
		$order = $this->input->post("order");
		$act_date = $this->input->post("activity_date");
		$act_name = $this->input->post("activity_name");
		$selfscore = $this->input->post("score");
		$document_name = $this->input->post("document_name");		
		
		$activityID = $this->personindicator->updateActivity($id, $indicator, $order, $act_date, $act_name,
														 $selfscore, $document_name);
	
		$this->personindicator->recalculateIndicatorSelfScore($pid);
		$this->personindicator->setEvalModify($pid, 0);

		$this->session->set_flashdata('success', 'แก้ไขผลการดำเนินภารกิจเรียบร้อยแล้ว');			
		redirect('person_evaluation/managePersonEvaluation', 'location');
	
	}
	
	
	function saveActivity($pid) {
		$indicator = $this->input->post("indicator");		
		$order = $this->input->post("order");
		$act_date = $this->input->post("activity_date");
		$act_name = $this->input->post("activity_name");
		$selfscore = $this->input->post("score");
		$document_name = $this->input->post("document_name");		
		
		$activityID = $this->personindicator->addActivity($indicator, $order, $act_date, $act_name,
														 $selfscore, $document_name);

		$this->personindicator->recalculateIndicatorSelfScore($pid);
		$this->personindicator->setEvalModify($pid, 0);
		$this->session->set_flashdata('success', 'บันทึกผลการดำเนินภารกิจเรียบร้อยแล้ว');			
		redirect('person_evaluation/managePersonEvaluation', 'location');
	}
	
	function divExecSaveActivity($pid, $user_id) {
		$indicator = $this->input->post("indicator");		
		$order = $this->input->post("order");
		$act_date = $this->input->post("activity_date");
		$act_name = $this->input->post("activity_name");
		$execscore = $this->input->post("score");
		$document_name = $this->input->post("document_name");		
		
		$activityID = $this->personindicator->addActivityFromDiv($indicator, $order, $act_date, $act_name,
														 $execscore, $document_name);

		$this->personindicator->recalculateIndicatorExecScore($pid);
		$this->personindicator->setEvalModify($pid, 1);
		
		$this->session->set_flashdata('success', 'บันทึกผลการดำเนินภารกิจเรียบร้อยแล้ว');			
		redirect('person_evaluation/confirmEvaluation/'.$user_id, 'location');
	}
	

	function confirmEvaluation($id)
	{
		$userID = $id;
		
		$tmp = $this->user->getMinProfile($id);
		$data['user'] =  $tmp[0];
		
		$divID  = $data['user']['divID'];
		$depID  = $data['user']['depID'];
		
		$active_evalround = $this->personindicator->getActiveEvalRound();

		if(count($active_evalround) == 1) {
			$data['title'] = "MFA - View Indicator ";
				
			$year  = $active_evalround[0]['year'];
			$round = $active_evalround[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
			
			//choopan stll user it	$pinumber =  $this->personindicator->getPInumber($userID, $year, $round, $depID, $divID);
	
			$pi_set = $this->personindicator->getPersonIndicatorID($userID, $depID, $divID, $year, $round);
			$data['pi_set'] = $pi_set;
			$indicators = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID);
			$data['indicators'] = $indicators;
			
			$total_evaluation_score = $this->personindicator->getEvaluationScore($userID, $year, $round, $depID, $divID);
			$data['indicator_total_score'] = $total_evaluation_score[0]['indicator_score'];
			$data['core_total_score'] = $total_evaluation_score[0]['core_score'];

			$data['exec_indicator_total_score'] = $total_evaluation_score[0]['exec_indicator_score'];
			$data['exec_core_total_score'] = $total_evaluation_score[0]['exec_core_score'];


			$data['userID'] = $userID;
					
			$all_saved_activities = array();
			$indicator_avg_scores = array();
			$indicator_exec_avg_scores = array();
			$all_indicator_score = 0;	
			$all_indicator_exec_score = 0;
			
			for($i = 0; $i < count($indicators); $i++) {
				$person_indicator_id = $indicators[$i]['ID'];
				$saved_activities = $this->personindicator->getSavedActivitiesByPID($person_indicator_id);
				
				//Calculate indicator score
				$indicator_avg_score = 0;
				$indicator_exec_avg_score = 0;
				for($j = 0; $j < count($saved_activities); $j++) {
					$indicator_avg_score += $saved_activities[$j]['selfscore'];
					$indicator_exec_avg_score += $saved_activities[$j]['execscore'];
				}
				
				if(count($saved_activities) != 0) {
					$indicator_avg_score /= count($saved_activities);
					$indicator_exec_avg_score /= count($saved_activities);
				} else {
					$indicator_avg_score = 0;
					$indicator_exec_avg_score = 0;
				}
				
				$all_indicator_score += ($indicator_avg_score * $indicators[$i]['weight']);
				$all_indicator_exec_score += ($indicator_exec_avg_score * $indicators[$i]['weight']);
				
				$indicator_avg_scores["$person_indicator_id"] = $indicator_avg_score;
				$indicator_exec_avg_scores["$person_indicator_id"] = $indicator_exec_avg_score;
				
				$all_saved_activities["$person_indicator_id"] = $saved_activities;
			}
			
						
			$data['cores'] = $this->personindicator->getCoreName($userID, $year, $round, $depID, $divID);
			
			$data['all_saved_activities'] = $all_saved_activities;
			$data['indicator_avg_scores'] = $indicator_avg_scores;
			$data['indicator_exec_avg_scores'] = $indicator_exec_avg_scores;
			
			$data['all_indicator_score']  = $all_indicator_score;
			$data['all_indicator_exec_score']  = $all_indicator_exec_score;
				
			$this->load->view('evaluate/confirmPersonEvaluation.php', $data);
			
		}	else {
						
			$data['error_msg'] = "โปรดติดต่่อผู้ดูแลระบบ ยังไม่มีการตั้งรอบการประเมิน";
			$this->load->view('evaluate/errorPersonEvaluation.php', $data);		
			
		}
				
	}

	
	
	
	function editPersonIndicatorDetailFromExecDiv($id, $user_id) {
		$indicator = $this->personindicator->getIndicatorDetail($id);
		$data['indicator'] = $indicator[0];
		$data['user_id'] = $user_id;
		$this->load->view('evaluate/editPersonIndicatorDetailFromExecDiv.php', $data);
	}

	function editPersonIndicatorDetailFromExecDep($id, $user_id) {
		$indicator = $this->personindicator->getIndicatorDetail($id);
		$data['indicator'] = $indicator[0];
		$data['user_id'] = $user_id;
		$this->load->view('evaluate/editPersonIndicatorDetailFromExecDep.php', $data);
	}
	
	
	
	
	function deletePersonIndicatorDetailFromExecDiv($id, $user_id) {
			$this->personindicator->deletePersonIndicator($id, 1);							
			$this->session->set_flashdata('success', 'ลบข้อมูลตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');		
			redirect('person_evaluation/confirmIndicator/'.$user_id, 'location');		
	}
	
	function deletePersonIndicatorDetailFromExecDep($id, $user_id) {
			$this->personindicator->deletePersonIndicator($id, 1);							
			$this->session->set_flashdata('success', 'ลบข้อมูลตัวชี้วัดรายบุคคลเรียบร้อยแล้ว');		
			redirect('person_evaluation/confirmExecIndicatorFromDep/'.$user_id, 'location');		
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

	function savePersonIndicatorDetailFromExecDep($id, $user_id) {

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
			
			redirect('person_evaluation/confirmExecIndicatorFromDep/'.$user_id, 'location');
	}

	function manageEvaluationHistory() {
		$userID = $this->session->userdata('sessid');
		$data['historyEvals'] = $this->personindicator->getHistoryEval($userID);
		$this->load->view('evaluate/historyEvaluation.php', $data);	
		
	}
	
	function viewHistoryEvaluation($pid) {
		$data['title'] = 'MFA - Evaluation History';
		$userID = $this->session->userdata('sessid');		
		$tmp = $this->personindicator->getPIByPID($pid);
		$ownerID = $tmp[0]['userID'];
		
		if($userID == $ownerID) { 
			$divID  = $tmp[0]['div_id'];
			$depID  = $tmp[0]['dep_id'];
			$year 	= $tmp[0]['year'];
			$round	= $tmp[0]['round'];
			$data['year']  = $year;
			$data['round'] = $round;
						
			
			$indicators = $this->personindicator->listIndicator($userID, $year, $round, $depID, $divID); 
			$data['indicators'] = $indicators;
			
			$total_evaluation_score = $this->personindicator->getEvaluationScore($userID, $year, $round, $depID, $divID);
			$data['exec_indicator_total_score'] = $total_evaluation_score[0]['exec_indicator_score'];
			$data['exec_core_total_score'] = $total_evaluation_score[0]['exec_core_score'];

			
			$data['userID'] = $userID;
					
			$all_saved_activities = array();
			$indicator_exec_avg_scores = array();
			$all_indicator_exec_score = 0;
			
			for($i = 0; $i < count($indicators); $i++) {
				$person_indicator_id = $indicators[$i]['ID'];
				$saved_activities = $this->personindicator->getSavedActivitiesByPID($person_indicator_id);
				
				//Calculate indicator score
				$indicator_exec_avg_score = 0;
				for($j = 0; $j < count($saved_activities); $j++) {
					$indicator_exec_avg_score += $saved_activities[$j]['execscore'];
				}
				
				if(count($saved_activities) != 0) {
					$indicator_exec_avg_score /= count($saved_activities);
				} else {
					$indicator_exec_avg_score = 0;
				}
				
				$all_indicator_exec_score += ($indicator_exec_avg_score * $indicators[$i]['weight']);
				
				$indicator_exec_avg_scores["$person_indicator_id"] = $indicator_exec_avg_score;
				
				$all_saved_activities["$person_indicator_id"] = $saved_activities;
			}
			
						
			$data['cores'] = $this->personindicator->getCoreName($userID, $year, $round, $depID, $divID);			
			$data['all_saved_activities'] = $all_saved_activities;
			$data['indicator_exec_avg_scores'] = $indicator_exec_avg_scores;
			$data['all_indicator_exec_score']  = $all_indicator_exec_score;
			
			$this->load->view('evaluate/viewPersonEvaluationHistory.php', $data);
		} else {
			die ("YOU HAVE NO PERMISSION !!");
		}							
	}
}
?>


