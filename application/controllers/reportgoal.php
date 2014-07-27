<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportgoal extends CI_Controller {

	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user','',TRUE);
       $this->load->model('report_goal','',TRUE);
	   $this->load->library('form_validation');
	   $this->load->helper('url');
	}
	
	function index()
	{
		if($this->session->userdata('sessusername'))
		{

			$data['title'] = "MFA - Indicator";
			$this->load->view('indicator/addindicator_view',$data);
		}
	   else
	   {
		 //If no session, redirect to login page
		 redirect('login', 'refresh');
	   }
	}
    
    function goal_response()
    {
        $userid = $this->session->userdata("sessid");
        $year = $this->session->userdata("sessyear");
        $query = $this->report_goal->getDivGoalResponse($userid,$year);
        if ($query) $data['div_array'] = $query;
        else $data['div_array'] = array();
                                                        
        $data['title'] = "MFA - Goal Response";
        $this->load->view('reportgoal/view_goalresponse',$data);
    }
    
    function addreport($month, $goalid)
    {
        $userid = $this->session->userdata("sessid");
        $query = $this->user->getProfile($userid);
        foreach($query as $loop) {
            $data['user'] = $loop->fullname;
            $data['tel'] = $loop->PWTELOFFICE;
        }
        
        $query = $this->report_goal->getIndicatorDivDetail($goalid);
        if ($query) $data['indicator_array'] = $query;
        else $data['indicator_array'] = array();
        
        foreach($query as $loop) $isGoalDep = $loop->isGoalDep;
        
        if ($isGoalDep > 0) {
            $query = $this->report_goal->getOneGoalDivFromDep($goalid);
            $query2 = $this->report_goal->getRowSpanFromDep($goalid);
            if ($query) { $data['goal_array'] = $query; $data['rowspan_array']=$query2; }
            else { $data['goal_array'] = array(); $data['rowspan_array'] = array(); }
            $data['dep'] =1;
        }else{
            $query = $this->report_goal->getOneGoalDiv($goalid);
            $query2 = $this->report_goal->getRowSpan($goalid);
            if ($query) { $data['goal_array'] = $query; $data['rowspan_array']=$query2; }
            else { $data['goal_array'] = array(); $data['rowspan_array'] = array(); }
            $data['dep'] =0;
        }
        
        $depid = $this->session->userdata("sessdep");
        $divid = $this->session->userdata("sessdiv");
        $data['depname'] = $this->report_goal->getName("department",$depid)[0]['name'];
        $data['divname'] = $this->report_goal->getName("division",$divid)[0]['name'];
        $data['title'] = "MFA - Add Report";
        $data['month'] = $month;
        $this->load->view('reportgoal/add_report',$data);
    }
    
    function savereport()
    {
        $editorid= ($this->session->userdata('sessid'));
        
        $month = ($this->input->post('month'));
        
        // array target report
        $dep = ($this->input->post('dep'));
        $targetid = ($this->input->post('targetid'));
        $reporttarget = ($this->input->post('reporttarget'));
        
        // report goal
        $goalid = ($this->input->post('goalid'));
        $report12 = ($this->input->post('report12'));
        $support12 = ($this->input->post('support12'));
        $problem12 = ($this->input->post('problem12'));
        $suggest12 = ($this->input->post('suggest12'));
        $selfscore = ($this->input->post('selfscore'));
        
        // add target report
        $report = array("year" => $this->session->userdata('sessyear'), "month" => $month, "editorID" => $editorid);
        
        // target from dep
        if ($dep > 0) {
            for($i=0; $i<count($targetid); $i++) {
                $report['dep_target_id'] = $targetid[$i];
                $report['detail'] = $reporttarget[$i];
                $result = $this->report_goal->addDivTargetReport($report);
            }
        }else{
            // div target 
            for($i=0; $i<count($targetid); $i++) {
                $report['div_target_id'] = $targetid[$i];
                $report['detail'] = $reporttarget[$i];
                $result = $this->report_goal->addDivTargetReport($report);
            }
        }
        
        // add goal report
        $reportgoal = array(
            "div_goal_id" => $goalid,
            "report" => $report12,
            "support" => $support12,
            "problem" => $problem12,
            "suggest" => $suggest12,
            "selfscore" => $selfscore,
            "year" => $this->session->userdata('sessyear'), 
            "month" => $month, 
            "editorID" => $editorid
        );
        $result = $this->report_goal->addDivGoalReport($reportgoal);
        
        if ($result) {
			$this->session->set_flashdata('result', 'success');
        }else{
            $this->session->set_flashdata('result', 'fail');
        }

        redirect('reportgoal/goal_response', 'location');

    }
}