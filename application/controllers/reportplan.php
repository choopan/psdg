<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportplan extends CI_Controller {

	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user','',TRUE);
       $this->load->model('report_plan','',TRUE);
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
        
    }
    
    function minister()
    {
        $data['admin_array'] = $this->user->getAllAdminMinister("admin_min");
        $data['admin_level'] = "<strong>แสดงรายชื่อผู้ดูแลตัวชี้วัด <u>ระดับกระทรวง</u></strong>";
        
        $data['title'] = "MFA - Minister Admin Management";
        $this->load->view('indicator/admin_view',$data);
    }
    
    function department()
    {
        $data['admin_array'] = $this->user->getAllAdminMinister("admin_dep");
        $data['admin_level'] = "<strong>แสดงรายชื่อผู้ดูแลตัวชี้วัด <u>ระดับกรม</u></strong>";
        
        $data['title'] = "MFA - Department Admin Management";
        $this->load->view('indicator/admin_view',$data);
    }
    
    function division()
    {
        $data['admin_array'] = $this->user->getAllAdminMinister("admin_div");
        $data['admin_level'] = "<strong>แสดงตัวชี้วัดที่ดูแล <u>ระดับกอง</u></strong>";
        
        $query = $this->report_plan->getIndicatorDivision(16);
		if($query){
			$data['div_array'] =  $query;
		}else{
			$data['div_array'] = array();
		}
        
        $data['title'] = "MFA - Division Admin Management";
        $this->load->view('reportplan/view_admindiv',$data);
    }
}