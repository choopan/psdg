<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); 

class Manageindicator extends CI_Controller {

	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user','',TRUE);
	   $this->load->model('department','',TRUE);
	   $this->load->model('ministerindicator','',TRUE);
	   $this->load->model('position','',TRUE);
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

	function showMinister()
	{
		$query = $this->ministerindicator->getIndicatorGroupDepartment($this->session->userdata('sessyear'));
		if($query){
			$data['view_array'] =  $query;
		}else{
			$data['view_array'] = array();
		}

		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatorminister_view',$data);


	}
	
	function showDepartment()
	{
		//$this->load->helper(array('form'));
		
		$query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}

		$data['admin_array'] = array();		
		$data['depid']=0;
		$data['indicatordep_array'] = array();

		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatordepartment_view',$data);


	}

	function showKong()
	{
		//$this->load->helper(array('form'));
		
		$query = $this->department->getKong();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}

		$data['admin_array'] = array();		
		$data['divid']=0;
		$data['indicatordivision_array'] = array();

		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatordivision_view',$data);


	}
	
	function showPerson()
	{
		
		//$data['indicatordep_array'] = array();
		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatorperson_view',$data);


	}
	
	function addIndicatorMinister()
	{
		$this->load->helper(array('form'));
		
		$query = $this->position->getPosition();
		if($query){
			$data['position_array'] =  $query;
		}else{
			$data['position_array'] = array();
		}

		$query = $this->department->getDepName();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
		
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addindicatorminister_view',$data);

	}

	function addDepartment()
	{
		$this->load->helper(array('form'));
		
		$query = $this->position->getPosition();
		if($query){
			$data['position_array'] =  $query;
		}else{
			$data['position_array'] = array();
		}

		$query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}

		$query = $this->ministerindicator->getIndicatorGroupDepartment();
		if($query){
			$data['view_array'] =  $query;
		}else{
			$data['view_array'] = array();
		}


		$query = $this->ministerindicator->getIndicatorDep(0);
		if($query){
			$data['indicatordep_array'] =  $query;
		}else{
			$data['indicatordep_array'] = array();
		}

		
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/adddepartment_view',$data);

	}

	function addKong()
	{
		$this->load->helper(array('form'));
		
		$query = $this->position->getPosition();
		if($query){
			$data['position_array'] =  $query;
		}else{
			$data['position_array'] = array();
		}

		$query = $this->department->getKong();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}

		$query = $this->ministerindicator->getIndicatorGroupDepartment();
		if($query){
			$data['view_array'] =  $query;
		}else{
			$data['view_array'] = array();
		}


		$query = $this->ministerindicator->getIndicatorDivision(0);
		if($query){
			$data['indicatordep_array'] =  $query;
		}else{
			$data['indicatordep_array'] = array();
		}

		
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addkong_view',$data);

	}

	function addPerson()
	{
		$this->load->helper(array('form'));
		
		$query = $this->user->getProfile($this->session->userdata('sessid'));
		if($query){
			$data['person_array'] =  $query;
		}else{
			$data['person_array'] = array();
		}
		
		$query = $this->position->getPosition();
		if($query){
			$data['position_array'] =  $query;
		}else{
			$data['position_array'] = array();
		}

		$query = $this->department->getDepName();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
		
		$query = $this->ministerindicator->getIndicatorPersonNoRound($this->session->userdata('sessid'));
		if($query){
			$data['indicatorperson_array'] =  $query;
		}else{
			$data['indicatorperson_array'] = array();
		}
		
		$query = $this->ministerindicator->getOneIndicatorPersonLast($this->session->userdata('sessid'));
		if($query){
			$data['last_array'] =  $query;
		}else{
			$data['last_array'] = array();
		}
		
		//$data['last_array'] = array();
		
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addperson_view',$data);

	}

	function addNewIndicatorDep()
	{
		$this->load->helper(array('form'));
		
		

		$query = $this->position->getPosition();
		if($query){
			$data['position_array'] =  $query;
		}else{
			$data['position_array'] = array();
		}

		$query = $this->department->getDepName();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
		
			
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordep_view',$data);

	}
	
	function addNewIndicatorDivision()
	{
		$this->load->helper(array('form'));
		
		

		$query = $this->position->getPosition();
		if($query){
			$data['position_array'] =  $query;
		}else{
			$data['position_array'] = array();
		}

		$query = $this->department->getDepName();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
		
			
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordivision_view',$data);

	}

	function addNewIndicatorPerson()
	{
		$id = $this->uri->segment(3);
		$this->load->helper(array('form'));
		
		$query = $this->department->getKong();
		if($query){
			$data['division_array'] =  $query;
		}else{
			$data['division_array'] = array();
		}
		$data['indicatordep_array'] =array();
		$data['depid'] = 0;
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatorperson_view',$data);

	}

	function addIndicatorDep()
	{
		$this->load->helper(array('form'));
		
	
		$query = $this->department->getName();
		if($query){
			$data['depname_array'] =  $query;
		}else{
			$data['depname_array'] = array();
		}
			
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addindicatordep_view',$data);

	}
	
	function addIndicatorPerson()
	{
		$this->load->helper(array('form'));
		$data['depid']=0;
		if($this->session->userdata('logged_in'))
		{

			$query = $this->department->getName();
			if($query){
				$data['depname_array'] =  $query;
			}else{
				$data['depname_array'] = array();
			}
			
			$query = $this->ministerindicator->getIndicatorDep(0);
			if($query){
				$data['indicatordep_array'] =  $query;
			}else{
				$data['indicatordep_array'] = array();
			}
			$query = $this->ministerindicator->getIndicatorPerson(0);
			if($query){
				$data['indicatorperson_array'] =  $query;
			}else{
				$data['indicatorperson_array'] = array();
			}
			
			$session_data = $this->session->userdata('logged_in');
			$data['firstname'] = $session_data['firstname'];
			$data['lastname'] = $session_data['lastname'];
			$data['year'] = $session_data['year'];
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addindicatorperson_view',$data);
		}
	   else
	   {
		 //If no session, redirect to login page
		 show_404();
	   }
	}
	
	function viewDivisionPerson()
	{
		$this->load->helper(array('form'));
		$id = $this->uri->segment(3);

			
			$query = $this->department->getKong();
			if($query){
				$data['division_array'] =  $query;
			}else{
				$data['division_array'] = array();
			}
			
			$query = $this->ministerindicator->getIndicatorDivision($id);
			if($query){
				$data['indicatordep_array'] =  $query;
			}else{
				$data['indicatordep_array'] = array();
			}
			/*
			$query = $this->ministerindicator->getIndicatorPerson(0);
			if($query){
				$data['indicatorperson_array'] =  $query;
			}else{
				$data['indicatorperson_array'] = array();
			}*/
			$data['depid']=$id;
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addnewindicatorperson_view',$data);

	}
	
	function viewDep()
	{
		$this->load->helper(array('form'));
		$id = $this->uri->segment(3);
		
			
		$query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
			
		$query = $this->ministerindicator->getIndicatorDep($id);
		if($query){
			$data['indicatordep_array'] =  $query;
		}else{
			$data['indicatordep_array'] = array();
		}

		$query = $this->ministerindicator->getIndicatorOneDepAdmin($id);
		if($query){
			$data['admin_array'] =  $query;
		}else{
			$data['admin_array'] = array();
		}

		$data['depid']=$id;
		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatordepartment_view',$data);

	}
	
	function viewDiv()
	{
		$this->load->helper(array('form'));
		$id = $this->uri->segment(3);
		
			
		$query = $this->department->getKong();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
			
		$query = $this->ministerindicator->getIndicatorDivision($id);
		if($query){
			$data['indicatordivision_array'] =  $query;
		}else{
			$data['indicatordivision_array'] = array();
		}

		$query = $this->ministerindicator->getIndicatorOneDivisionAdmin($id);
		if($query){
			$data['admin_array'] =  $query;
		}else{
			$data['admin_array'] = array();
		}

		$data['divid']=$id;
		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatordivision_view',$data);

	}
	
	function insertDep()
	{
		$this->load->helper(array('form'));
		
		if($this->session->userdata('logged_in'))
		{

			
			$query = $this->department->getName();
			if($query){
				$data['depname_array'] =  $query;
			}else{
				$data['depname_array'] = array();
			}
			
			$query = $this->ministerindicator->getIndicatorDep(0);
			if($query){
				$data['indicatordep_array'] =  $query;
			}else{
				$data['indicatordep_array'] = array();
			}
			$query = $this->ministerindicator->getIndicatorPerson(0);
			if($query){
				$data['indicatorperson_array'] =  $query;
			}else{
				$data['indicatorperson_array'] = array();
			}
			$data['min'] = 0;
			$session_data = $this->session->userdata('logged_in');
			$data['firstname'] = $session_data['firstname'];
			$data['lastname'] = $session_data['lastname'];
			$data['year'] = $session_data['year'];
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addindicatorminister_view',$data);
		}
	   else
	   {
		 //If no session, redirect to login page
		 show_404();
	   }
	}
	
	function insertPerson()
	{
		$this->load->helper(array('form'));
		
		if($this->session->userdata('logged_in'))
		{

			
			$query = $this->department->getName();
			if($query){
				$data['depname_array'] =  $query;
			}else{
				$data['depname_array'] = array();
			}
			
			$query = $this->ministerindicator->getIndicatorDep(0);
			if($query){
				$data['indicatordep_array'] =  $query;
			}else{
				$data['indicatordep_array'] = array();
			}
			
			$query = $this->ministerindicator->getIndicatorPerson(0);
			if($query){
				$data['indicatorperson_array'] =  $query;
			}else{
				$data['indicatorperson_array'] = array();
			}
			$data['min'] = 2;
			$session_data = $this->session->userdata('logged_in');
			$data['firstname'] = $session_data['firstname'];
			$data['lastname'] = $session_data['lastname'];
			$data['year'] = $session_data['year'];
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addindicatorminister_view',$data);
		}
	   else
	   {
		 //If no session, redirect to login page
		 show_404();
	   }
	}
	
	public function getdatabyajax()
	{
		$this->load->library('Datatables');
		$this->datatables
		->select("id, name", FALSE)
		->from('min_indicator')
		/*
		->edit_column("id",'$1',"id")
		->add_column("goalDetail",'unknown',"id")
		->add_column("goal",'unknown',"id");
		*/
		->edit_column("id",'<input type="hidden" name="indicatorid[]" id="indicatorid[]" value="$1"><input type="text" class="form-control" name="number[]" id="number[]" value="">',"id")
		->add_column("goal",'<div class="form-group"><label class="radio-inline"><input type="radio" name="goal-$1" id="goal-$1" value="1">1</label>
                                            <label class="radio-inline"><input type="radio" name="goal-$1" id="goal-$1" value="2">2</label>
											<label class="radio-inline"><input type="radio" name="goal-$1" id="goal-$1" value="3">3</label>
											<label class="radio-inline"><input type="radio" name="goal-$1" id="goal-$1" value="4">4</label>
											<label class="radio-inline"><input type="radio" name="goal-$1" id="goal-$1" value="5">5</label>
                                        </div>',"id")
		->add_column("weight",'<input type="text" class="form-control" name="weight[]" id="weight[]" value="">',"id");
		echo $this->datatables->generate(); 
		
		
	}
	
	public function getdataAndButtonbyajax()
	{
		$this->load->library('Datatables');
		$this->datatables
		->select("number, name, resName,id", FALSE)
		->from('min_indicator')
		/*
		->edit_column("id",'$1',"id")
		->add_column("goalDetail",'unknown',"id")
		->add_column("goal",'unknown',"id");
		*/
		->edit_column("id",'<div class="tooltip-demo">
	<a href="'.site_url("manageindicator/viewindicator_min/$1").'" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
	<a href="'.site_url("manageindicator/viewindicator_min/$1").'" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
	<button class="btnDelete btn btn-danger btn-xs" onclick="del_confirm($1)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></button>
	</div>',"id");
		
		echo $this->datatables->generate(); 
	}
	
	public function getdataPersonAndButtonbyajax()
	{
		$this->load->library('Datatables');
		$this->datatables
		->select("CONCAT(pwfname,' ', pwlname) as fullname, pwposition.pwname as poname, person_indicator.userID as uid", FALSE)
		->from('person_indicator')
		->join('pwemployee','pwemployee.userid=person_indicator.userID')
		->join('pwposition','pwemployee.pwposition=pwposition.pwposition')
		->where('person_indicator.year',$this->session->userdata('sessyear'))
		->group_by("person_indicator.userID")
		/*
		->edit_column("id",'$1',"id")
		->add_column("goalDetail",'unknown',"id")
		->add_column("goal",'unknown',"id");
		*/
		->edit_column("uid",'<div class="tooltip-demo">
	<a href="'.site_url("manageindicator/viewindicator_person/$1").'" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
	<a href="'.site_url("manageindicator/viewindicator_person/$1").'" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
	<button class="btnDelete btn btn-danger btn-xs" onclick="del_confirm($1)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></button>
	</div>',"uid");
		
		echo $this->datatables->generate(); 
	}
	
	function required_resid0()
    {
        if( ! $this->input->post('resid')[0])
        {
            $this->form_validation->set_message('required_resid0', '<code>กรุณาใส่ข้อมูล</code>');
            return FALSE;
        }
		
        return TRUE;
    }



	function saveMinister()
	{
		$this->form_validation->set_rules('indicatorNO', 'indicatorNO', 'trim|xss_clean|required|numeric');
		$this->form_validation->set_rules('indicatorName', 'indicatorName', 'trim|xss_clean|required');

		$this->form_validation->set_rules('goalmin', 'goalmin', 'trim|required|maxlength[1]|xss_clean');
		$this->form_validation->set_rules('weightmin', 'weightmin', 'trim|xss_clean|required');
		
		// validate only control name
		$this->form_validation->set_rules('controlname', 'controlname', 'trim|xss_clean|required');
		
		// validate only first response name
		$this->form_validation->set_rules('resid0', 'resid0', 'trim|xss_clean|callback_required_resid0');
		//$this->form_validation->set_rules('position0', 'position0', 'trim|xss_clean|required');
		//$this->form_validation->set_rules('telephone0', 'telephone0', 'trim|xss_clean|required');

		$test1= ($this->input->post('resid'));

		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		
		if($this->form_validation->run() == TRUE) {
			$year = $this->session->userdata('sessyear');

			$indicatorNO= ($this->input->post('indicatorNO'));
			$indicatorName= ($this->input->post('indicatorName'));

			$goalmin= ($this->input->post('goalmin'));
			$weightmin= ($this->input->post('weightmin'));
			
			$controluserid= ($this->input->post('controluserid'));
			
			// array
			$uid= ($this->input->post('uid'));
			/*
			$resid= ($this->input->post('resid'));
			$position= ($this->input->post('position'));
			$depid= ($this->input->post('depid'));
			$telephone= ($this->input->post('telephone'));
			*/

			//array
			$goalNO = $this->input->post('goalNO');
			$goalName = $this->input->post('goalName');

			$criterion1 = $this->input->post('criterion1');
			$criterion2 = $this->input->post('criterion2');
			$criterion3 = $this->input->post('criterion3');
			$criterion4 = $this->input->post('criterion4');
			$criterion5 = $this->input->post('criterion5');

			$technote = $this->input->post('technote');
			

			$indicator = array(
				'year' => $year,
				'number' => $indicatorNO,
				'name' => $indicatorName,
				'goal' => $goalmin,
				'weight' => $weightmin,
				'criteria1' => $criterion1,
				'criteria2' => $criterion2,
				'criteria3' => $criterion3,
				'criteria4' => $criterion4,
				'criteria5' => $criterion5,
				'technicalNote' => $technote
				
			);


			$resultMin = $this->ministerindicator->addIndicator($indicator);
			if ($resultMin) {

				$indicatorid = $this->db->insert_id();
				$control = array(
					'minIndicatorID' => $indicatorid,
					'userID' => $controluserid,
					'isControl' => 1
				);
				$resultRes = $this->ministerindicator->addIndicatorResponse($control);
				$response = array();
				for ($i=0; $i<count($uid); $i++) {
					if ($uid[$i]>0) {
						$response['minIndicatorID'] = $indicatorid;
						$response['userID'] = $uid[$i];
						$response['isControl'] = 0;
						/*
						$response['resName'] = $resid[$i];
						$response['resPosition'] = $position[$i];
						$response['resTelephone'] = $telephone[$i];
						$response['resDepartmentID'] = $depid[$i];
						*/
					

						$resultRes = $this->ministerindicator->addIndicatorResponse($response);
						/*
						if ($result) $this->session->set_flashdata('showresult', 'success');
						else { 
							$this->session->set_flashdata('showresult', 'fail');
							$this->ministerindicator->delIndicator($indicatorid);
							$this->ministerindicator->delGoalbyIndicator($indicatorid);
						}
						*/
					}
				}

				$goal = array();
				for ($i=0; $i<count($goalNO); $i++) {
					if ($goalName[$i]!=null) {
						$goal['indicatorID']= $indicatorid;
						$goal['number']= $goalNO[$i];
						$goal['name']= $goalName[$i];
						$result = $this->ministerindicator->addIndicatorGoal($goal);
						/*
						if ($result) $this->session->set_flashdata('showresult', 'success');
						else { 
							$this->session->set_flashdata('showresult', 'fail');
							$this->ministerindicator->delIndicator($indicatorid);
							$this->ministerindicator->delGoalbyIndicator($indicatorid);
						}*/
					}
				}
				
				$this->session->set_flashdata('showresult', 'success');

				// if success , go to indicator table


			}
			else {
				$this->session->set_flashdata('showresult', 'fail');
			}
				redirect(current_url());
			
		}
		
			$query = $this->position->getPosition();
			if($query){
				$data['position_array'] =  $query;
			}else{
				$data['position_array'] = array();
			}

			$query = $this->department->getDepName();
			if($query){
				$data['dep_array'] =  $query;
			}else{
				$data['dep_array'] = array();
			}
			
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addindicatorminister_view',$data);
	}

	function viewIndicatorFromAdd() {

		$query = $this->ministerindicator->getIndicatorGroupDepartment();
		if($query){
			$data['view_array'] =  $query;
		}else{
			$data['view_array'] = array();
		}

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/viewindicatorfromadd_view',$data);
	}
	
	function selectIndicatorMinisterList() {

		$query = $this->ministerindicator->getIndicatorMin($this->session->userdata('sessyear'));
		$result = array();
		foreach($query->result_array() as $row)
		{
			$row['goalid'] = 0;
			$result[] = $row;
			$query2 = $this->ministerindicator->getIndicatorMinGoal($row['id'],$this->session->userdata('sessyear'));
			foreach($query2->result_array() as $row2)
			{
				$result[] = $row2;
			}
		}
		
		$data['goal_array'] = $result;

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/selectindicatorminlist_view',$data);
	}
	
	function saveIndicatorSession($value) {
		$this->session->set_userdata('in_selected',$value);
	}

	function viewIndicatorLink() {

		$id = $this->uri->segment(3);
		$query = $this->ministerindicator->getOneIndicator($id);
		if($query){
			$data['minis_indicator_array'] =  $query;
		}
		$query = $this->ministerindicator->getOneIndicatorGoal($id);
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}
		$query = $this->ministerindicator->getOneIndicatorResponse($id);
		if($query){
			$data['res_indicator_array'] =  $query;
		}else{
			$data['res_indicator_array'] =  array();
		}

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/viewindicatorfromlink_view',$data);
	}

	function viewIndicatorLinkDep() {

		$id = $this->uri->segment(3);
		$query = $this->ministerindicator->getOneIndicatorDep($id);
		if($query){
			$data['minis_indicator_array'] =  $query;
		}
		$query = $this->ministerindicator->getOneIndicatorGoalDep($id);
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}
		$query = $this->ministerindicator->getOneIndicatorResponseDep($id);
		if($query){
			$data['res_indicator_array'] =  $query;
		}else{
			$data['res_indicator_array'] =  array();
		}

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/viewindicatorfromlinkdep_view',$data);
	}
	
	function viewIndicatorLinkDivision() {

		$id = $this->uri->segment(3);
		$query = $this->ministerindicator->getOneIndicatorDivision($id);
		if($query){
			$data['minis_indicator_array'] =  $query;
		}
		$query = $this->ministerindicator->getOneIndicatorGoalDivision($id);
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}
		$query = $this->ministerindicator->getOneIndicatorResponseDivision($id);
		if($query){
			$data['res_indicator_array'] =  $query;
		}else{
			$data['res_indicator_array'] =  array();
		}

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/viewindicatorfromlinkdivision_view',$data);
	}
	
	function viewIndicatorLinkPerson() {

		$id = $this->uri->segment(3);
		$query = $this->ministerindicator->getOneIndicatorPerson($id);
		if($query){
			$data['person_indicator_array'] =  $query;
		}
		$query = $this->ministerindicator->getOneIndicatorGoalPerson($id);
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}


		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/viewindicatorfromlinkperson_view',$data);
	}
	


	function saveDepartment()
	{
		$this->form_validation->set_rules('residdep', 'residdep', 'trim|xss_clean|required');
		$this->form_validation->set_rules('positiondep', 'positiondep', 'trim|xss_clean|required');
		$this->form_validation->set_rules('telephonedep', 'telephonedep', 'trim|xss_clean|required');
		//$this->form_validation->set_rules('number', 'number', 'trim|xss_clean|required|numeric');
		//$this->form_validation->set_rules('numberdep', 'numberdep', 'trim|xss_clean|required|numeric');
		//$this->form_validation->set_rules('goalNO[]', 'goalNO', 'trim|xss_clean|required|numeric');
		//$this->form_validation->set_rules('goalName[]', 'goalName', 'trim|xss_clean|required');
		//$this->form_validation->set_rules('indicatorName', 'indicatorName', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		
		if($this->form_validation->run() == TRUE) {
			$uiddep= ($this->input->post('uiddep'));
			$depid= ($this->input->post('depid'));
			$residdep= ($this->input->post('residdep'));
			$positiondep= ($this->input->post('positiondep'));
			$telephonedep= ($this->input->post('telephonedep'));
			$year = $this->session->userdata('sessyear');
			$indicatorid= ($this->input->post('indicatorid'));
			$indicatordepid= ($this->input->post('indicatordepid'));
			$number = $this->input->post('number');
			$numberdep = $this->input->post('numberdep');
			//$goal = $this->input->post('goal');
			//$goaldep = $this->input->post('goaldep');
			$weight = $this->input->post('weight');
			$weightdep = $this->input->post('weightdep');
			//$count = count($goalNO);
			

			$indicator = array(
				'depID' => $depid,
				'year' => $year
			);
			
			$indicatordep = array(
				'depID' => $depid,
				'isMinister' => 0
			);

			$indicatoradmin = array(
				'depID' => $depid,
				'userID' => $uiddep,
				'adminName' => $residdep,
				'adminPosition' => $positiondep,
				'adminTelephone' => $telephonedep
			);

			$this->ministerindicator->addIndicatorAdminDep($indicatoradmin);

			// insert new indicator from minister
			for ($i=0; $i<count($indicatorid); $i++) {
				if ($indicatorid[$i]>0) {
					$query = $this->ministerindicator->getOneIndicator($indicatorid[$i]);
					if(is_array($query)) {
						foreach($query as $loop){
							$name = $loop->name;
							$cri1 = $loop->criteria1;
							$cri2 = $loop->criteria2;
							$cri3 = $loop->criteria3;
							$cri4 = $loop->criteria4;
							$cri5 = $loop->criteria5;
							$tech = $loop->technicalnote;
						}
					
						$indicator['name'] = $name;
						$indicator['technicalNote'] = $tech;
						$indicator['criteria1'] = $cri1;
						$indicator['criteria2'] = $cri2;
						$indicator['criteria3'] = $cri3;
						$indicator['criteria4'] = $cri4;
						$indicator['criteria5'] = $cri5;
						$indicator['isMinister'] = $indicatorid[$i];
						$indicator['number'] = $number[$i];
						$indicator['goal'] = $this->input->post('goal-'.$indicatorid[$i]);
						$indicator['weight'] = $weight[$i];
						$this->ministerindicator->addIndicatorDep($indicator);
					}
				}
			}
			
			// edit new indicator into dep
			for ($i=0; $i<count($indicatordepid); $i++) {
				$indicatordep['id'] = $indicatordepid[$i];
				$this->ministerindicator->editIndicatorDep($indicatordep);
			}
			
			$this->session->set_flashdata('showresult2', 'success');
			redirect(current_url());
		}
			//$this->session->set_flashdata('showresult2', 'fail');
			$query = $this->position->getPosition();
			if($query){
				$data['position_array'] =  $query;
			}else{
				$data['position_array'] = array();
			}

			$query = $this->department->getGom();
			if($query){
				$data['dep_array'] =  $query;
			}else{
				$data['dep_array'] = array();
			}

			$query = $this->ministerindicator->getIndicatorGroupDepartment();
			if($query){
				$data['view_array'] =  $query;
			}else{
				$data['view_array'] = array();
			}


			$query = $this->ministerindicator->getIndicatorDep(0);
			if($query){
				$data['indicatordep_array'] =  $query;
			}else{
				$data['indicatordep_array'] = array();
			}

			
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/adddepartment_view',$data);

	}
	
	function saveDep()
	{
		$this->form_validation->set_rules('indicatorNO', 'indicatorNO', 'trim|xss_clean|required|numeric');
		$this->form_validation->set_rules('indicatorName', 'indicatorName', 'trim|xss_clean|required');

		$this->form_validation->set_rules('goalmin', 'goalmin', 'trim|required|maxlength[1]|xss_clean');
		$this->form_validation->set_rules('weightmin', 'weightmin', 'trim|xss_clean|required');
		
		// validate only first response name
		$this->form_validation->set_rules('resid0', 'resid0', 'trim|xss_clean|callback_required_resid0');
		//$this->form_validation->set_rules('position0', 'position0', 'trim|xss_clean|required');
		//$this->form_validation->set_rules('telephone0', 'telephone0', 'trim|xss_clean|required');

		$test1= ($this->input->post('resid'));

		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		
		if($this->form_validation->run() == TRUE) {
			$year = $this->session->userdata('sessyear');

			$indicatorNO= ($this->input->post('indicatorNO'));
			$indicatorName= ($this->input->post('indicatorName'));

			$goalmin= ($this->input->post('goalmin'));
			$weightmin= ($this->input->post('weightmin'));
			
			// array
			$uid= ($this->input->post('uid'));
			$resid= ($this->input->post('resid'));
			$position= ($this->input->post('position'));
			$depid= ($this->input->post('depid'));
			$telephone= ($this->input->post('telephone'));

			//array
			$goalNO = $this->input->post('goalNO');
			$goalName = $this->input->post('goalName');

			$criterion1 = $this->input->post('criterion1');
			$criterion2 = $this->input->post('criterion2');
			$criterion3 = $this->input->post('criterion3');
			$criterion4 = $this->input->post('criterion4');
			$criterion5 = $this->input->post('criterion5');

			$technote = $this->input->post('technote');
			

			$indicator = array(
				'year' => $year,
				'number' => $indicatorNO,
				'name' => $indicatorName,
				'goal' => $goalmin,
				'weight' => $weightmin,
				'criteria1' => $criterion1,
				'criteria2' => $criterion2,
				'criteria3' => $criterion3,
				'criteria4' => $criterion4,
				'criteria5' => $criterion5,
				'technicalNote' => $technote
				
			);


			$resultMin = $this->ministerindicator->addIndicatorDep($indicator);
			if ($resultMin) {

				$indicatorid = $this->db->insert_id();
				$response = array();
				for ($i=0; $i<count($uid); $i++) {
					if ($uid[$i]>0) {
						$response['depIndicatorID'] = $indicatorid;
						$response['userID'] = $uid[$i];
						$response['resName'] = $resid[$i];
						$response['resPosition'] = $position[$i];
						$response['resTelephone'] = $telephone[$i];
						$response['resDepartmentID'] = $depid[$i];


						$resultRes = $this->ministerindicator->addIndicatorResponseDep($response);
						/*
						if ($result) $this->session->set_flashdata('showresult', 'success');
						else { 
							$this->session->set_flashdata('showresult', 'fail');
							$this->ministerindicator->delIndicator($indicatorid);
							$this->ministerindicator->delGoalbyIndicator($indicatorid);
						}
						*/
					}
				}

				$goal = array();
				for ($i=0; $i<count($goalNO); $i++) {
					if ($goalName[$i]!=null) {
						$goal['indicatorID']= $indicatorid;
						$goal['number']= $goalNO[$i];
						$goal['name']= $goalName[$i];
						$result = $this->ministerindicator->addIndicatorGoalDep($goal);
						/*
						if ($result) $this->session->set_flashdata('showresult', 'success');
						else { 
							$this->session->set_flashdata('showresult', 'fail');
							$this->ministerindicator->delIndicator($indicatorid);
							$this->ministerindicator->delGoalbyIndicator($indicatorid);
						}*/
					}
				}
				
				$this->session->set_flashdata('showresult', 'success');

				// if success , go to indicator table


			}
			else {
				$this->session->set_flashdata('showresult', 'fail');
			}
				redirect(current_url());
			
		}
		
			$query = $this->position->getPosition();
			if($query){
				$data['position_array'] =  $query;
			}else{
				$data['position_array'] = array();
			}

			$query = $this->department->getDepName();
			if($query){
				$data['dep_array'] =  $query;
			}else{
				$data['dep_array'] = array();
			}
			
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addnewindicatordep_view',$data);
	}	

	function saveDivision()
	{
		$this->form_validation->set_rules('residdep', 'residdep', 'trim|xss_clean|required');
		$this->form_validation->set_rules('positiondep', 'positiondep', 'trim|xss_clean|required');
		$this->form_validation->set_rules('telephonedep', 'telephonedep', 'trim|xss_clean|required');
		//$this->form_validation->set_rules('number', 'number', 'trim|xss_clean|required|numeric');
		//$this->form_validation->set_rules('numberdep', 'numberdep', 'trim|xss_clean|required|numeric');
		//$this->form_validation->set_rules('goalNO[]', 'goalNO', 'trim|xss_clean|required|numeric');
		//$this->form_validation->set_rules('goalName[]', 'goalName', 'trim|xss_clean|required');
		//$this->form_validation->set_rules('indicatorName', 'indicatorName', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		
		if($this->form_validation->run() == TRUE) {
			$uiddep= ($this->input->post('uiddep'));
			$depid= ($this->input->post('depid'));
			$residdep= ($this->input->post('residdep'));
			$positiondep= ($this->input->post('positiondep'));
			$telephonedep= ($this->input->post('telephonedep'));
			$year = $this->session->userdata('sessyear');
			$indicatorid= ($this->input->post('indicatorid'));
			$indicatordepid= ($this->input->post('indicatordepid'));
			$number = $this->input->post('number');
			$numberdep = $this->input->post('numberdep');
			//$goal = $this->input->post('goal');
			//$goaldep = $this->input->post('goaldep');
			$weight = $this->input->post('weight');
			$weightdep = $this->input->post('weightdep');
			//$count = count($goalNO);
			

			$indicator = array(
				'divisionID' => $depid,
				'year' => $year
			);
			
			$indicatordep = array(
				'divisionID' => $depid,
				'isMinister' => 0
			);

			$indicatoradmin = array(
				'divisionID' => $depid,
				'userID' => $uiddep,
				'adminName' => $residdep,
				'adminPosition' => $positiondep,
				'adminTelephone' => $telephonedep
			);

			$this->ministerindicator->addIndicatorAdminDivision($indicatoradmin);

			// insert new indicator from minister
			for ($i=0; $i<count($indicatorid); $i++) {
				if ($indicatorid[$i]>0) {
					$query = $this->ministerindicator->getOneIndicator($indicatorid[$i]);
					if(is_array($query)) {
						foreach($query as $loop){
							$name = $loop->name;
							$cri1 = $loop->criteria1;
							$cri2 = $loop->criteria2;
							$cri3 = $loop->criteria3;
							$cri4 = $loop->criteria4;
							$cri5 = $loop->criteria5;
							$tech = $loop->technicalnote;
						}
					
						$indicator['name'] = $name;
						$indicator['technicalNote'] = $tech;
						$indicator['criteria1'] = $cri1;
						$indicator['criteria2'] = $cri2;
						$indicator['criteria3'] = $cri3;
						$indicator['criteria4'] = $cri4;
						$indicator['criteria5'] = $cri5;
						$indicator['isMinister'] = $indicatorid[$i];
						$indicator['number'] = $number[$i];
						$indicator['goal'] = $this->input->post('goal-'.$indicatorid[$i]);
						$indicator['weight'] = $weight[$i];
						$this->ministerindicator->addIndicatorDivision($indicator);
					}
				}
			}
			
			// edit new indicator into dep
			for ($i=0; $i<count($indicatordepid); $i++) {
				$indicatordep['id'] = $indicatordepid[$i];
				$this->ministerindicator->editIndicatorDivision($indicatordep);
			}
			
			$this->session->set_flashdata('showresult2', 'success');
			redirect(current_url());
		}
			//$this->session->set_flashdata('showresult2', 'fail');
			$query = $this->position->getPosition();
			if($query){
				$data['position_array'] =  $query;
			}else{
				$data['position_array'] = array();
			}

			$query = $this->department->getKong();
			if($query){
				$data['dep_array'] =  $query;
			}else{
				$data['dep_array'] = array();
			}

			$query = $this->ministerindicator->getIndicatorGroupDepartment();
			if($query){
				$data['view_array'] =  $query;
			}else{
				$data['view_array'] = array();
			}


			$query = $this->ministerindicator->getIndicatorDivision(0);
			if($query){
				$data['indicatordep_array'] =  $query;
			}else{
				$data['indicatordep_array'] = array();
			}

			
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addkong_view',$data);

	}	
	
	function saveDiv()
	{
		$this->form_validation->set_rules('indicatorNO', 'indicatorNO', 'trim|xss_clean|required|numeric');
		$this->form_validation->set_rules('indicatorName', 'indicatorName', 'trim|xss_clean|required');

		$this->form_validation->set_rules('goalmin', 'goalmin', 'trim|required|maxlength[1]|xss_clean');
		$this->form_validation->set_rules('weightmin', 'weightmin', 'trim|xss_clean|required');
		
		// validate only first response name
		$this->form_validation->set_rules('resid0', 'resid0', 'trim|xss_clean|callback_required_resid0');
		//$this->form_validation->set_rules('position0', 'position0', 'trim|xss_clean|required');
		//$this->form_validation->set_rules('telephone0', 'telephone0', 'trim|xss_clean|required');

		$test1= ($this->input->post('resid'));

		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		
		if($this->form_validation->run() == TRUE) {
			$year = $this->session->userdata('sessyear');

			$indicatorNO= ($this->input->post('indicatorNO'));
			$indicatorName= ($this->input->post('indicatorName'));

			$goalmin= ($this->input->post('goalmin'));
			$weightmin= ($this->input->post('weightmin'));
			
			// array
			$uid= ($this->input->post('uid'));
			$resid= ($this->input->post('resid'));
			$position= ($this->input->post('position'));
			$depid= ($this->input->post('depid'));
			$telephone= ($this->input->post('telephone'));

			//array
			$goalNO = $this->input->post('goalNO');
			$goalName = $this->input->post('goalName');

			$criterion1 = $this->input->post('criterion1');
			$criterion2 = $this->input->post('criterion2');
			$criterion3 = $this->input->post('criterion3');
			$criterion4 = $this->input->post('criterion4');
			$criterion5 = $this->input->post('criterion5');

			$technote = $this->input->post('technote');
			

			$indicator = array(
				'year' => $year,
				'number' => $indicatorNO,
				'name' => $indicatorName,
				'goal' => $goalmin,
				'weight' => $weightmin,
				'criteria1' => $criterion1,
				'criteria2' => $criterion2,
				'criteria3' => $criterion3,
				'criteria4' => $criterion4,
				'criteria5' => $criterion5,
				'technicalNote' => $technote
				
			);


			$resultMin = $this->ministerindicator->addIndicatorDivision($indicator);
			if ($resultMin) {

				$indicatorid = $this->db->insert_id();
				$response = array();
				for ($i=0; $i<count($uid); $i++) {
					if ($uid[$i]>0) {
						$response['divisionIndicatorID'] = $indicatorid;
						$response['userID'] = $uid[$i];
						$response['resName'] = $resid[$i];
						$response['resPosition'] = $position[$i];
						$response['resTelephone'] = $telephone[$i];
						$response['resDepartmentID'] = $depid[$i];


						$resultRes = $this->ministerindicator->addIndicatorResponseDivision($response);
						/*
						if ($result) $this->session->set_flashdata('showresult', 'success');
						else { 
							$this->session->set_flashdata('showresult', 'fail');
							$this->ministerindicator->delIndicator($indicatorid);
							$this->ministerindicator->delGoalbyIndicator($indicatorid);
						}
						*/
					}
				}

				$goal = array();
				for ($i=0; $i<count($goalNO); $i++) {
					if ($goalName[$i]!=null) {
						$goal['indicatorID']= $indicatorid;
						$goal['number']= $goalNO[$i];
						$goal['name']= $goalName[$i];
						$result = $this->ministerindicator->addIndicatorGoalDivision($goal);
						/*
						if ($result) $this->session->set_flashdata('showresult', 'success');
						else { 
							$this->session->set_flashdata('showresult', 'fail');
							$this->ministerindicator->delIndicator($indicatorid);
							$this->ministerindicator->delGoalbyIndicator($indicatorid);
						}*/
					}
				}
				
				$this->session->set_flashdata('showresult', 'success');

				// if success , go to indicator table


			}
			else {
				$this->session->set_flashdata('showresult', 'fail');
			}
				redirect(current_url());
			
		}
		
			$query = $this->position->getPosition();
			if($query){
				$data['position_array'] =  $query;
			}else{
				$data['position_array'] = array();
			}

			$query = $this->department->getDepName();
			if($query){
				$data['dep_array'] =  $query;
			}else{
				$data['dep_array'] = array();
			}
			
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addnewindicatordivision_view',$data);
	}	
	
	function saveIndicatorPerson(){
		
	
		$this->form_validation->set_rules('indicatorNO', 'indicatorNO', 'trim|xss_clean|required|numeric');
		$this->form_validation->set_rules('indicatorName', 'indicatorName', 'trim|xss_clean|required');

		$this->form_validation->set_rules('goalmin', 'goalmin', 'trim|required|maxlength[1]|xss_clean');
		$this->form_validation->set_rules('weightmin', 'weightmin', 'trim|xss_clean|required');
		

		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		
		if($this->form_validation->run() == TRUE) {
			$year = $this->session->userdata('sessyear');

			$uid = $this->session->userdata('sessid');

			$indicatorNO= ($this->input->post('indicatorNO'));
			$indicatorName= ($this->input->post('indicatorName'));

			$goalmin= ($this->input->post('goalmin'));
			$weightmin= ($this->input->post('weightmin'));
			

			//array
			$goalNO = $this->input->post('goalNO');
			$goalName = $this->input->post('goalName');

			$criterion1 = $this->input->post('criterion1');
			$criterion2 = $this->input->post('criterion2');
			$criterion3 = $this->input->post('criterion3');
			$criterion4 = $this->input->post('criterion4');
			$criterion5 = $this->input->post('criterion5');

			$technote = $this->input->post('technote');
			
			// depend division
			$depinid_array= ($this->input->post('depinid'));
			for ($i=0; $i<count($depinid_array); $i++) {
				if ($depinid_array[$i]!=NULL) $depinid = $depinid_array[$i];
			}

			$indicator = array(
				'userID' => $uid,
				'divIndicatorID' => $depinid,
				'year' => $year,
				'number' => $indicatorNO,
				'name' => $indicatorName,
				'goal' => $goalmin,
				'weight' => $weightmin,
				'criteria1' => $criterion1,
				'criteria2' => $criterion2,
				'criteria3' => $criterion3,
				'criteria4' => $criterion4,
				'criteria5' => $criterion5,
				'technicalNote' => $technote
				
			);


			$resultMin = $this->ministerindicator->addIndicatorPerson($indicator);
			if ($resultMin) {

				$indicatorid = $this->db->insert_id();
				$goal = array();
				for ($i=0; $i<count($goalNO); $i++) {
					if ($goalName[$i]!=null) {
						$goal['indicatorID']= $indicatorid;
						$goal['number']= $goalNO[$i];
						$goal['name']= $goalName[$i];
						$result = $this->ministerindicator->addIndicatorGoalPerson($goal);
						/*
						if ($result) $this->session->set_flashdata('showresult', 'success');
						else { 
							$this->session->set_flashdata('showresult', 'fail');
							$this->ministerindicator->delIndicator($indicatorid);
							$this->ministerindicator->delGoalbyIndicator($indicatorid);
						}*/
					}
				}
				
				$this->session->set_flashdata('showresult', 'success');

				// if success , go to indicator table


			}
			else {
				$this->session->set_flashdata('showresult', 'fail');
			}
				redirect(current_url());
			
		}
		
			$query = $this->department->getKong();
			if($query){
				$data['division_array'] =  $query;
			}else{
				$data['division_array'] = array();
			}
			
			$data['indicatordep_array'] =array();
			$data['depid'] = 0;
			
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addnewindicatorperson_view',$data);
	}
	
	function savePersonOnlyName()
	{

		$this->form_validation->set_rules('indicatorName', 'indicatorName', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		$depid= $this->input->post('depid');
		
		if($this->form_validation->run() == TRUE) {
			$indicatorName= ($this->input->post('indicatorName'));
			$depinid_array= ($this->input->post('depinid'));
			
			$year = $this->session->userdata('logged_in')['year'];
			//$count = count($goalNO);
			for ($i=0; $i<count($depinid_array); $i++) {
				if ($depinid_array[$i]!=NULL) $depinid = $depinid_array[$i];
			}

			$indicator = array(
				'depIndicatorID' => $depinid,
				'name' => $indicatorName,
				'year' => $year
			);

			$result = $this->ministerindicator->addIndicatorPerson($indicator);
			if ($result) {
				$this->session->set_flashdata('showresult', 'success');
			}
			else
				$this->session->set_flashdata('showresult', 'fail');
			redirect(current_url());
		}
		
			$query = $this->department->getName();
			if($query){
				$data['depname_array'] =  $query;
			}else{
				$data['depname_array'] = array();
			}
			
			$query = $this->ministerindicator->getIndicatorDep($depid);
			if($query){
				$data['indicatordep_array'] =  $query;
			}else{
				$data['indicatordep_array'] = array();
			}
			
			$data['depid'] = $depid;
			$session_data = $this->session->userdata('logged_in');
			$data['firstname'] = $session_data['firstname'];
			$data['lastname'] = $session_data['lastname'];
			$data['year'] = $session_data['year'];
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addindicatorperson_view',$data);
	}	
	
	function required_depid() {
		if( $this->input->post('depid')[0] < 0)
        {
            $this->form_validation->set_message('required_depid', '<code>กรุณาเลือกสังกัด</code>');
            return FALSE;
        }
		
        return TRUE;
	}
	
	function savePerson()
	{
		$this->form_validation->set_rules('round', 'round', 'trim|required|maxlength[1]|xss_clean');
		$this->form_validation->set_rules('depid[]', 'depid', 'required|xss_clean|callback_required_depid');
		
		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		
		if($this->form_validation->run() == TRUE) {
			$round= ($this->input->post('round'));
			$userid = $this->session->userdata('sessid');
			$year = $this->session->userdata('sessyear');

			//array
			$depid = ($this->input->post('depid'));
			if (count($depid) > 1) {
				$startdate = ($this->input->post('startdate'));
				$enddate = ($this->input->post('enddate'));
			}
			$indicatorid = ($this->input->post('indicatorid'));
			$number = ($this->input->post('number'));
			$weight = ($this->input->post('weight'));
			$indicatorpersonid = ($this->input->post('indicatorpersonid'));
			
			
			$workat = array(
				'userID' => $userid,
				'evaluateRound' => $round,
				'year' => $year
			);
			
			$indicatorlast = array(
				'userID' => $userid,
				'evaluateRound' => $round,
				'year' => $year
			);
			
			$indicatornew = array(
				'evaluateRound' => $round
			);
			
			// insert new workat from depid array
			for ($i=0; $i<count($depid); $i++) {
				if ($depid[$i]>0) {
								
					$workat['depID'] = $depid[$i];
					if (count($depid) > 1) {
						$workat['startdate'] = date('Y-m-d', strtotime($startdate[$i]));
						$workat['enddate'] = date('Y-m-d', strtotime($enddate[$i]));
					}
					$this->ministerindicator->addEvaluatePersonWorkat($workat);
					
				}
			}
			
			
			// insert new indicator from last
			for ($i=0; $i<count($indicatorid); $i++) {
				if ($indicatorid[$i]>0) {
					$query = $this->ministerindicator->getOneIndicatorPersonOnlyOneTable($indicatorid[$i]);
					if(is_array($query)) {
						foreach($query as $loop){
							$name = $loop->name;
							$cri1 = $loop->criteria1;
							$cri2 = $loop->criteria2;
							$cri3 = $loop->criteria3;
							$cri4 = $loop->criteria4;
							$cri5 = $loop->criteria5;
							$tech = $loop->technicalnote;
							$divIndicatorID = $loop->divIndicatorID;
						}
					
						$indicatorlast['name'] = $name;
						$indicatorlast['technicalNote'] = $tech;
						$indicatorlast['criteria1'] = $cri1;
						$indicatorlast['criteria2'] = $cri2;
						$indicatorlast['criteria3'] = $cri3;
						$indicatorlast['criteria4'] = $cri4;
						$indicatorlast['criteria5'] = $cri5;
						$indicatorlast['divIndicatorID'] = $divIndicatorID;
						$indicatorlast['number'] = $number[$i];
						$indicatorlast['goal'] = $this->input->post('goal-'.$indicatorid[$i]);
						$indicatorlast['weight'] = $weight[$i];
						$this->ministerindicator->addIndicatorPerson($indicatorlast);
					}
				}
			}
			
			// edit round into person_indicator
			for ($i=0; $i<count($indicatorpersonid); $i++) {
				$indicatornew['id'] = $indicatorpersonid[$i];
				$this->ministerindicator->editIndicatorPerson($indicatornew);
			}
			
			$this->session->set_flashdata('showresult', 'success');
			redirect(current_url());
		}
			$query = $this->user->getProfile($this->session->userdata('sessid'));
			if($query){
				$data['person_array'] =  $query;
			}else{
				$data['person_array'] = array();
			}
			
			$query = $this->position->getPosition();
			if($query){
				$data['position_array'] =  $query;
			}else{
				$data['position_array'] = array();
			}

			$query = $this->department->getDepName();
			if($query){
				$data['dep_array'] =  $query;
			}else{
				$data['dep_array'] = array();
			}
			
			$query = $this->ministerindicator->getIndicatorPersonNoRound($this->session->userdata('sessid'));
			if($query){
				$data['indicatorperson_array'] =  $query;
			}else{
				$data['indicatorperson_array'] = array();
			}

			$query = $this->ministerindicator->getOneIndicatorPersonLast($this->session->userdata('sessid'));
			if($query){
				$data['last_array'] =  $query;
			}else{
				$data['last_array'] = array();
			}
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addperson_view',$data);

	}

	function editNumber() {
		$indicatorid = $this->uri->segment(3);
		$newnum = $this->uri->segment(4);

		$indicator = array(
			"id" => $indicatorid,
			"number" => $newnum
			);

		$result = $this->ministerindicator->editNumber($indicator);
		$query = $this->ministerindicator->getIndicatorGroupDepartment($this->session->userdata('sessyear'));
		if($query){
			$data['view_array'] =  $query;
		}else{
			$data['view_array'] = array();
		}

		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatorminister_view',$data);
				
	}
	
	function delete()
	{
		
		$indicatorid = $this->uri->segment(3);
		$this->ministerindicator->delIndicator($indicatorid);
		$this->ministerindicator->delGoalbyIndicator($indicatorid);
		$this->ministerindicator->delResponsebyIndicator($indicatorid);
		
		redirect('manageindicator/showMinister', 'refresh');
	}
	
	function deleteDep()
	{
		
		$id = $this->uri->segment(3);
		$depid = $this->uri->segment(4);
		$this->ministerindicator->delIndicatorDep($id);
		//$this->ministerindicator->delGoalbyIndicatorDep($id);
		
		$query = $this->department->getName();
		if($query){
			$data['depname_array'] =  $query;
		}else{
			$data['depname_array'] = array();
		}
		//$data['depid']=0;
		$data['indicatordep_array'] = array();
		
		redirect('manageindicator/viewDep/'.$depid, 'refresh');
	}
	
	function deleteDivision()
	{
		
		$id = $this->uri->segment(3);
		$divid = $this->uri->segment(4);
		$this->ministerindicator->delIndicatorDivision($id);
		//$this->ministerindicator->delGoalbyIndicatorDivision($id);
		
		$query = $this->department->getKong();
		if($query){
			$data['depname_array'] =  $query;
		}else{
			$data['depname_array'] = array();
		}
		//$data['depid']=0;
		$data['indicatordivision_array'] = array();
		
		redirect('manageindicator/viewDiv/'.$divid, 'refresh');
	}
	
	function deletePerson()
	{
		
		$id = $this->uri->segment(3);
		$this->ministerindicator->delIndicatorPerson($id, $this->session->userdata('sessyear'));
		

		
		redirect('manageindicator/showPerson', 'refresh');
	}
	
	function viewindicator_min()
	{
		$id = $this->uri->segment(3);
		$query = $this->ministerindicator->getOneIndicator($id);
		if($query){
			$data['minis_indicator_array'] =  $query;
		}
		$query = $this->ministerindicator->getOneIndicatorGoal($id);
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}
		$query = $this->ministerindicator->getOneIndicatorResponse($id);
		if($query){
			$data['res_indicator_array'] =  $query;
		}else{
			$data['res_indicator_array'] =  array();
		}
		

		$data['title'] = "MFA - View Indicator";
		$this->load->view('indicator/viewindicatorminister_view',$data);
	}
	
	function viewindicator_dep()
	{
		$id = $this->uri->segment(3);
		$isMin = $this->uri->segment(4);
		$query = $this->ministerindicator->getOneIndicatorDep($id);
		if($query){
			$data['dep_indicator_array'] =  $query;
		}
		if ($isMin==0) {
			$query = $this->ministerindicator->getOneIndicatorGoalDep($id);
			$query2 = $this->ministerindicator->getOneIndicatorResponseDep($id);
		}
		else{
			$query = $this->ministerindicator->getOneIndicatorGoal($isMin);
			$query2 = $this->ministerindicator->getOneIndicatorResponse($isMin);
		}	
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}

		if($query2){
			$data['res_indicator_array'] =  $query2;
		}else{
			$data['res_indicator_array'] =  array();
		}
		$data['depID'] = $id;
		$data['title'] = "MFA - View Indicator";
		$this->load->view('indicator/viewindicatordepartment_view',$data);
	}
	
	function viewindicator_div()
	{
		$id = $this->uri->segment(3);
		$isMin = $this->uri->segment(4);
		$query = $this->ministerindicator->getOneIndicatorDivision($id);
		if($query){
			$data['dep_indicator_array'] =  $query;
		}
		if ($isMin==0) {
			$query = $this->ministerindicator->getOneIndicatorGoalDivision($id);
			$query2 = $this->ministerindicator->getOneIndicatorResponseDivision($id);
		}
		else{
			$query = $this->ministerindicator->getOneIndicatorGoal($isMin);
			$query2 = $this->ministerindicator->getOneIndicatorResponse($isMin);
		}	
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}

		if($query2){
			$data['res_indicator_array'] =  $query2;
		}else{
			$data['res_indicator_array'] =  array();
		}
		$data['divID'] = $id;
		$data['title'] = "MFA - View Indicator";
		$this->load->view('indicator/viewindicatordivision_view',$data);
	}
	
	function viewindicator_person()
	{
		$id = $this->uri->segment(3);
		$year = $this->session->userdata('sessyear');
		$query1 = $this->ministerindicator->getOneIndicatorPersonByUserid($id, $year, 1);
		$query2 = $this->ministerindicator->getOneIndicatorPersonByUserid($id, $year, 2);
		if($query1){
			$data['person_indicator_array1'] =  $query1;
		}else{
			$data['person_indicator_array1'] = array();
		}
		
		if($query2){
			$data['person_indicator_array2'] =  $query2;
		}else{
			$data['person_indicator_array2'] = array();
		}
		
		$query1 = $this->ministerindicator->getWorkatIndicatorPerson($id, $year, 1);
		$query2 = $this->ministerindicator->getWorkatIndicatorPerson($id, $year, 2);
		
		if($query1){
			$data['workat_array1'] =  $query1;
		}else{
			$data['workat_array1'] = array();
		}
		
		if($query2){
			$data['workat_array2'] =  $query2;
		}else{
			$data['workat_array2'] = array();
		}
		
		$query = $this->user->getProfile($this->session->userdata('sessid'));
		if($query){
			$data['user_array'] =  $query;
		}else{
			$data['user_array'] = array();
		}

		$data['title'] = "MFA - View Indicator";
		$this->load->view('indicator/viewindicatorperson_view',$data);
	}
	
	function autocompleteResponse()
	{
		//$this->load->model('user');
		$term = $this->input->get('term', TRUE);
		$pwemployee = $this->user->searchName($term);
		echo json_encode($pwemployee);
	}
	

}