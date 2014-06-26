<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class evaluation_controller extends CI_Controller {

	function index()
	{

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