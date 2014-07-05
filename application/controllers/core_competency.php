<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core_competency extends CI_Controller {

	function __construct()
	{
	   parent::__construct();
	   $this->load->model('core_competency_model', '',TRUE);
	   $this->load->model('user_manage', '',TRUE);
	   $this->load->helper('url');
	}
	
	
	function index()
	{
		if($this->session->userdata('sessusername'))
		{

			$data['title'] = "MFA - Indicator";
			//redirect('manageSkill', 'refresh');
		}
	   else
	   {
		 //If no session, redirect to login page
		// redirect('login', 'refresh');
	   }
	}
	
	
	function manageSkill()
	{
		$data['title'] = "MFA - Core Competency Management";
		$data['skill_array'] = $this->core_competency_model->listSkill();
		$this->load->view('core_competency/manageSkill.php',$data);
	}
	
	function addSkill() 
	{
		$skillname = $this->input->post('skill');		
		$this->core_competency_model->addSkill($skillname);
		redirect(site_url("core_competency/manageSkill"), 'location');		
	}
	
	function editSkill($id)
	{
		$data['skillID'] = $id;
		$data['skillname']	= $this->core_competency_model->getSkillName($id);
		$this->load->view('core_competency/editSkill', $data);
	}
	
	function updateSkill($id) 
	{
		$skillname = $this->input->post('skill');
		$this->core_competency_model->updateSkill($id, $skillname);
		redirect(site_url("core_competency/manageSkill"), 'location');		

	}
	
	function deleteSkill($id) 
	{
		$this->core_competency_model->deleteSkill($id);
		redirect(site_url("core_competency/manageSkill"), 'location');
	}
	
	function manageCoreSet()
	{
		$data['title'] = "MFA - Core Competency Management";
		$data['coreset_array'] = $this->core_competency_model->listCoreSet();		
		$this->load->view('core_competency/manageCoreSet.php',$data);		
	}
	
	function addCoreSet()
	{
		$data['title'] = "MFA - Core Competency Management";
		$data['skill_array'] = $this->core_competency_model->listSkill();
		$this->load->view('core_competency/addCoreSet.php', $data);
	}
	
	function saveCoreSet()
	{
		$coreSetName = $this->input->post("coreset_name");
		$skills = $this->input->post("skill");
		$expectVals = $this->input->post("expectVal");
		$coresetID = $this->core_competency_model->createCoreSet($coreSetName);
		$numSkill = count($skills);
		for($i = 0; $i < $numSkill; $i++) {
			$this->core_competency_model->addSkilltoCoreSet($coresetID, $skills[$i], $expectVals[$i]);
		}
		redirect(site_url("core_competency/manageCoreSet"), 'location');
	}

	function viewCoreSet($id) 
	{
		$data['coreSetName'] = $this->core_competency_model->getCoreSetName($id);
		$data['skillAndExVals'] = $this->core_competency_model->getSkillandExceptVal($id);
		$this->load->view('core_competency/showCoreSetDetail.php', $data);
	}
	
	function deleteCoreSet($id)
	{
		$this->core_competency_model->deleteCoreSet($id);
		redirect(site_url("core_competency/manageCoreSet"), 'location');
	}

	function editCoreSet($id)
	{
		$data['title'] = "MFA - Core Competency Management";
		$coreSetNames = $this->core_competency_model->getCoreSetName($id);
		$data['coreSetName'] = $coreSetNames[0]['name'];
		//$data['coreSetName'] = "test";
		$data['coreSetID'] = $id;
		$data['skill_array'] = $this->core_competency_model->listSkill();
		$data['skillAndExVals'] = $this->core_competency_model->getSkillandExceptVal($id);
		$this->load->view('core_competency/editCoreSet.php', $data);
	}
	
	function saveEditCoreSet($id)
	{		
		$coreSetName = $this->input->post("coreset_name");
		$skills = $this->input->post("skill");
		$expectVals = $this->input->post("expectVal");
		
		$this->core_competency_model->updateCoreSet($id, $coreSetName);
		$this->core_competency_model->deleteAllSkillofCoreSet($id);
		
		$numSkill = count($skills);
		for($i = 0; $i < $numSkill; $i++) {
			$this->core_competency_model->addSkilltoCoreSet($id, $skills[$i], $expectVals[$i]);
		}
		redirect(site_url("core_competency/manageCoreSet"), 'location');	
	}
	
	function assignCoreSetIndex() {
		$data['title'] = "Testing";
		$data['users'] = $this->user_manage->getUserandCoreSet();
		$data['coresets'] = $this->core_competency_model->listCoreSet();
		$this->load->view('core_competency/showAssignCoreSet.php', $data);
	}
	
	function saveAssignCoreSet() {
		$userID = $this->input->post("userID");
		$coreSetID = $this->input->post("coreSetID");
		$result = $this->core_competency_model->updateUserCoreSet($userID, $coreSetID);
		echo json_encode($result);
	}
	
}

?>