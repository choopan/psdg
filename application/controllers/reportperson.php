<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); 

class Main extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user','',TRUE);
	   $this->load->helper('url');
	}
	function index()
	{
		if($this->session->userdata('sessusername'))
		{
			$data['title'] = "MFA - Main";
			$this->load->view('main_view',$data);
		}
	   else
	   {
		 //If no session, redirect to login page
		 redirect('login', 'refresh');
	   }
	}
	
	
	function division()
	{
		//find person in this division
		//$this->load->view('changepass_view',$data);
	}
}