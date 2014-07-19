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
        $query = $this->report_goal->getDepGoalResponse($this->session->userdata("sessid"));
        if ($query) $data['dep_array'] = $query;
        else $data['dep_array'] = array();
        
        $query = $this->report_goal->getDivGoalResponse($this->session->userdata("sessid"));
        if ($query) $data['div_array'] = $query;
        else $data['div_array'] = array();
                                                        
        $data['title'] = "MFA - Goal Response";
        $this->load->view('reportgoal/view_goalresponse',$data);
    }
    
    function addreport()
    {
        $goalid = $this->uri->segment(3);
        
        $query = $this->user->getThaiName($this->session->userdata("sessid"));
        foreach($query as $loop) {
            $data['user'] = $loop->pwfname." ".$loop->pwlname;
        }
        
        $query = $this->report_goal->getOneDepGoal($goalid);
        foreach($query as $loop) {
            $data['number'] = $loop->number;
            $data['name'] = $loop->name;
            $data['innumber'] = $loop->innumber;
            $data['inname'] = $loop->inname;
        }
        
        $data['title'] = "MFA - Add Report";
        $this->load->view('reportgoal/add_report',$data);
    }
}