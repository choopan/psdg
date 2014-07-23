<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

	function showDivision()
	{
		//$this->load->helper(array('form'));
        
        $query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
		
        $data['div_array'] = array();


		$data['admin_array'] = array();		
		$data['divid']=0;
        $data['depid']=0;
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
        
        $data['indicatorNO'] = $this->session->userdata('number');
        $data['indicatorName'] = $this->session->userdata('name');
        $data['weightmin'] = $this->session->userdata('weightmin');
		
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
		
        $userid = $this->session->userdata('sessid');
        $query = $this->ministerindicator->getMinGoalTemp($userid);
        if($query){
			$data['goaltemp_array'] =  $query;
		}else{
			$data['goaltemp_array'] = array();
		}
        
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addindicatorminister_view',$data);

	}

	function addDepartment()
	{
		$this->load->helper(array('form'));
        
        // save dep id
        $data['depid'] = $this->session->userdata('depid');
		
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
        
        

		
		// get minister indicator id and goal id from selected 
		$indicator_min_name_selected = null;
		$goal_min_name_selected = null;
		for ($i=0; $i<count($this->session->userdata('indicator_select')); $i++) {
			if ($this->session->userdata('indicator_select')[$i] > 0) {
				$indicator_min_name_selected[$i] = $this->ministerindicator->getNameFromMinister("min_indicator","id",$this->session->userdata('indicator_select')[$i])[0];
				
			}
		}
		
		for ($i=0; $i<count($this->session->userdata('goal_select')); $i++) {
			if ($this->session->userdata('goal_select')[$i] > 0) {
				$goal_min_name_selected[$i] = $this->ministerindicator->getNameFromMinister("min_goal","id",$this->session->userdata('goal_select')[$i])[0];
			}
		}
		
		$data['indicator_min_id'] = $this->session->userdata('indicator_select');
		$data['indicator_min_name'] = $indicator_min_name_selected;
		
		$data['goal_min_id'] = $this->session->userdata('goal_select');
		$data['goal_min_name'] = $goal_min_name_selected;
        
        // show saved minister indicator temp no depid
        $query = $this->ministerindicator->getIndicatorDep(0,"isMinister >",0,"isGoalmin",0,$this->session->userdata('sessid'));
        if($query){
			$data['newmin_array'] =  $query;
		}else{
			$data['newmin_array'] = array();
		}
        
        // show saved minister goal temp no depid
        $query = $this->ministerindicator->getIndicatorDep(0,"isMinister",0,"isGoalmin >",0,$this->session->userdata('sessid'));
        if($query){
			$data['newgoal_array'] =  $query;
		}else{
			$data['newgoal_array'] = array();
		}
		
		// show department indicator temp no depid
		$query = $this->ministerindicator->getIndicatorDep(0,"isMinister",0,"isGoalmin",0,$this->session->userdata('sessid'));
		if($query){
			$data['indicatordep_array'] =  $query;
		}else{
			$data['indicatordep_array'] = array();
		}

		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/adddepartment_view',$data);

	}
    
    function savedepid()
    {
        $id = $this->input->post('depid'); 
        $this->session->set_userdata('depid',$id);
        return true;
    }
    
    function addNewIndicatorDepFromInMin() 
    {
        $id = $this->uri->segment(3);
        
        $data['min_array'] = $this->ministerindicator->getOneIndicator($id);
        $data['goal_array'] = $this->ministerindicator->getIndicatorMinGoal($id,$this->session->userdata('sessyear'))->result();
        
        $data['showresult'] = null;
        
        
        $data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordepfrominmin_view',$data);
    }
    
    function addNewIndicatorDepFromGoalMin() 
    {
        $id = $this->uri->segment(3);
        
        $data['min_array'] = $this->ministerindicator->getNameFromMinister("min_goal","id",$id);
        $data['min_goal_id'] = $id;
        
        $data['showresult'] = null;
        
        $data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordepfromgoalmin_view',$data);
    }

	function addDivision()
	{
		$this->load->helper(array('form'));
		
        $data['divid'] = $this->session->userdata('divid');
        $data['depid'] = $this->session->userdata('divdepid');
        
        // dep of user
        $query = $this->department->getOneGom($this->session->userdata('sessdep'));
        $data['sessdep'] = $this->session->userdata('sessdep');
        foreach ($query as $result) {
            $data['depname'] = $result->name;
        }
        
        $query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}

		$query = $this->department->getKongFromOneGom($this->session->userdata('sessdep'));
		if($query){
			$data['div_array'] =  $query;
		}else{
			$data['div_array'] = array();
		}
        
        

		
		// get dep indicator id and goal id from selected 
		$indicator_dep_name_selected = null;
		$goal_dep_name_selected = null;
		for ($i=0; $i<count($this->session->userdata('indicator_dep_select')); $i++) {
			if ($this->session->userdata('indicator_dep_select')[$i] > 0) {
				$indicator_dep_name_selected[$i] = $this->ministerindicator->getNameFromMinister("dep_indicator","id",$this->session->userdata('indicator_dep_select')[$i])[0];
				
			}
		}
		
		for ($i=0; $i<count($this->session->userdata('goal_dep_select')); $i++) {
			if ($this->session->userdata('goal_dep_select')[$i] > 0) {
				$goal_dep_name_selected[$i] = $this->ministerindicator->getNameFromMinister("dep_goal","id",$this->session->userdata('goal_dep_select')[$i])[0];
			}
		}
		
		$data['indicator_dep_id'] = $this->session->userdata('indicator_dep_select');
		$data['indicator_dep_name'] = $indicator_dep_name_selected;
		
		$data['goal_dep_id'] = $this->session->userdata('goal_dep_select');
		$data['goal_dep_name'] = $goal_dep_name_selected;
        
        // show saved dep indicator temp no depid
        $query = $this->ministerindicator->getIndicatorDiv(0,"isDep >",0,"isGoalDep",0,$this->session->userdata('sessid'));
        if($query){
			$data['newdep_array'] =  $query;
		}else{
			$data['newdep_array'] = array();
		}
        
        // show saved minister goal temp no depid
        $query = $this->ministerindicator->getIndicatorDiv(0,"isDep",0,"isGoalDep >",0,$this->session->userdata('sessid'));
        if($query){
			$data['newgoal_array'] =  $query;
		}else{
			$data['newgoal_array'] = array();
		}
		
		// show department indicator temp no depid
		$query = $this->ministerindicator->getIndicatorDiv(0,"isDep",0,"isGoalDep",0,$this->session->userdata('sessid'));
		if($query){
			$data['indicatordiv_array'] =  $query;
		}else{
			$data['indicatordiv_array'] = array();
		}

		
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/adddivision_view',$data);

	}
    
    function savedivid()
    {
        list($id,$depid) = explode("x",$this->input->post('divid')); 
        $this->session->set_userdata('divid',$id);
        $this->session->set_userdata('divdepid',$depid);
        return true;
    }
    
    function addNewIndicatorDivFromInDep() 
    {
        $id = $this->uri->segment(3);
        
        $data['dep_array'] = $this->ministerindicator->getOneIndicatorDep($id);
        $data['goal_array'] = $this->ministerindicator->getOneIndicatorGoalDep($id,$this->session->userdata('sessyear'));
        
        $data['showresult'] = null;
        
        
        $data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordivfromindep_view',$data);
    }
    
    function addNewIndicatorDivFromGoalDep() 
    {
        $id = $this->uri->segment(3);
        
        $data['dep_array'] = $this->ministerindicator->getNameFromMinister("dep_goal","id",$id);
        $data['dep_goal_id'] = $id;
        
        $data['showresult'] = null;
        
        $data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordivfromgoaldep_view',$data);
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
		
        $data['showresult'] = null;
			
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordep_view',$data);

	}
	
	function addNewIndicatorDivision()
	{
		$this->load->helper(array('form'));

		$data['showresult'] = null;
	
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
			
		$query = $this->ministerindicator->getAllIndicatorDep($id);
		if($query){
			$data['indicatordep_array'] =  $query;
		}else{
			$data['indicatordep_array'] = array();
		}

		$query = $this->user->getAllAdminDep("admin_dep",$id);
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
        
        
		$query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
        
		$query = $this->department->getOneKong($id);
		foreach($query as $loop) {
            $depid = $loop->dep_id;   
        }
			
		$query = $this->ministerindicator->getIndicatorDivision($id);
		if($query){
			$data['indicatordivision_array'] =  $query;
		}else{
			$data['indicatordivision_array'] = array();
		}

		$query = $this->user->getAllAdminDiv("admin_div",$id);
		if($query){
			$data['admin_array'] =  $query;
		}else{
			$data['admin_array'] = array();
		}

		$data['divid']=$id;
        $data['depid']=$depid;
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

		$query = $this->ministerindicator->getIndicatorGroupDepartment($this->session->userdata('sessyear'));
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
    
    function selectIndicatorDepList() {

		
        // dep of user
        $query = $this->department->getOneGom($this->session->userdata('sessdep'));
        if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
        
        $query = $this->ministerindicator->getIndicatorOneDep($this->session->userdata('sessdep'),$this->session->userdata('sessyear'));
        
		$result = array();
		foreach($query->result_array() as $row)
		{
			$row['goalid'] = 0;
			$result[] = $row;
			$query2 = $this->ministerindicator->getIndicatorOneDepGoal($row['id'],$this->session->userdata('sessyear'));
			foreach($query2->result_array() as $row2)
			{
				$result[] = $row2;
			}
		}
		
		$data['goal_array'] = $result;

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/selectindicatordeplist_view',$data);
	}
	
	function saveIndicatorSession() {
		$this->session->set_userdata('indicator_select',$this->input->post('indicator'));
		$this->session->set_userdata('goal_select',$this->input->post('goal'));
	}
        
    function saveIndicatorDepSession() {
		$this->session->set_userdata('indicator_dep_select',$this->input->post('indicator'));
		$this->session->set_userdata('goal_dep_select',$this->input->post('goal'));
	}
    
    function clearIndicatorSession() {
        
        $this->session->set_userdata('indicator_select');
		$this->session->set_userdata('goal_select');
        
        $this->addDepartment();
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

        $depid= ($this->input->post('departmentid'));
        
        
        // array new indicator temp
        $newminid = ($this->input->post('newminid'));
        $newgoalid = ($this->input->post('newgoalid'));
        $newdepid = ($this->input->post('newdepid'));
        
        if ($depid > 0) {
			
			$indicatordep = array(
				'depID' => $depid
			);
			
			// edit new indicator into dep
			for ($i=0; $i<count($newminid); $i++) {
				$indicatordep['id'] = $newminid[$i];
				$this->ministerindicator->editIndicatorDep($indicatordep);
			}
            
            for ($i=0; $i<count($newgoalid); $i++) {
				$indicatordep['id'] = $newgoalid[$i];
				$this->ministerindicator->editIndicatorDep($indicatordep);
			}
            
            for ($i=0; $i<count($newdepid); $i++) {
				$indicatordep['id'] = $newdepid[$i];
				$this->ministerindicator->editIndicatorDep($indicatordep);
			}
			
			$this->session->set_flashdata('success', 'yes');

        }else{
            $this->session->set_flashdata('fail', 'yes');
        }

        redirect('manageindicator/addDepartment', 'location');
	}
	
	function saveDep()
	{
        
		$year = $this->session->userdata('sessyear');
        $nextpage = 0;
        
        // link minister indicator id 
        if ($this->input->post('minid') > 0) {
            $indicator_min_id = $this->input->post('minid');
            $nextpage = 1;
            
            // remove minister indicator in session
            $filter = $this->session->userdata('indicator_select');
            $index = array_search($indicator_min_id,$filter);
            unset($filter[$index]);
            $filter = array_values($filter);
            $this->session->set_userdata('indicator_select', $filter);
        }else{
            $indicator_min_id = 0;
        }
        
        // link minister goal id 
        if ($this->input->post('mingoalid') > 0) {
            $goal_min_id = $this->input->post('mingoalid');
            $nextpage = 2;
            
            // remove minister goal in session
            $filter = $this->session->userdata('goal_select');
            $index = array_search($goal_min_id,$filter);
            unset($filter[$index]);
            $filter = array_values($filter);
            $this->session->set_userdata('goal_select', $filter);
        }else{
            $goal_min_id = 0;
        }

        $indicatorNO= ($this->input->post('indicatorNO'));
		$indicatorName= ($this->input->post('indicatorName'));

		$goalmin= ($this->input->post('goalmin'));
		$weightmin= ($this->input->post('weightmin'));
		
        // dep goal response name array
		$userid= ($this->input->post('userid'));
            
		//array
		$goalNO = $this->input->post('goalNO');
		$goalName = $this->input->post('goalName');

		$criterion1 = $this->input->post('criterion1');
		$criterion2 = $this->input->post('criterion2');
		$criterion3 = $this->input->post('criterion3');
		$criterion4 = $this->input->post('criterion4');
		$criterion5 = $this->input->post('criterion5');
		$technote = $this->input->post('technote');
        
        $editid = $this->session->userdata('sessid');
			
        
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
				'technicalNote' => $technote,
                'isMinister' => $indicator_min_id,
                'isGoalmin' => $goal_min_id,
                'editorID' => $editid
				
        );


        $resultMin = $this->ministerindicator->addIndicatorDep($indicator);
		if ($resultMin) {

		  $indicatorid = $this->db->insert_id();
		  $goal = array();
		  for ($i=0; $i<count($goalNO); $i++) {
			if ($goalName[$i]!=null) {
				$goal['indicatorID']= $indicatorid;
				$goal['number']= $goalNO[$i];
				$goal['name']= $goalName[$i];
                $goal['responseID'] = $userid[$i];
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
				
                
                $data['showresult'] = "success";
				// if success , go to indicator table


        }
		else {
		  $data['showresult'] = "fail";
		}
        
        if ($nextpage == 1) {
            $this->load->view('indicator/addnewindicatordepfrominmin_view',$data);
        }elseif ($nextpage == 2) {
            $this->load->view('indicator/addnewindicatordepfromgoalmin_view',$data);
        }else{
            $this->load->view('indicator/addnewindicatordep_view',$data);
        }
	}	

	function saveDivision()
	{
		
        $divid= ($this->input->post('divid'));
        
        
        // array new indicator temp
        $newminid = ($this->input->post('newminid'));
        $newgoalid = ($this->input->post('newgoalid'));
        $newdepid = ($this->input->post('newdepid'));
        
        if ($divid > 0) {
			
			$indicatordep = array(
				'divisionID' => $divid
			);
			
			// edit new indicator into dep
			for ($i=0; $i<count($newminid); $i++) {
				$indicatordep['id'] = $newminid[$i];
				$this->ministerindicator->editIndicatorDivision($indicatordep);
			}
            
            for ($i=0; $i<count($newgoalid); $i++) {
				$indicatordep['id'] = $newgoalid[$i];
				$this->ministerindicator->editIndicatorDivision($indicatordep);
			}
            
            for ($i=0; $i<count($newdepid); $i++) {
				$indicatordep['id'] = $newdepid[$i];
				$this->ministerindicator->editIndicatorDivision($indicatordep);
			}
			
			$this->session->set_flashdata('success', 'yes');

        }else{
            $this->session->set_flashdata('fail', 'yes');
        }

        redirect('manageindicator/addDivision', 'location');

	}	
	
	function saveDiv()
	{
		$year = $this->session->userdata('sessyear');
        $nextpage = 0;
        
        // link minister indicator id 
        if ($this->input->post('depid') > 0) {
            $indicator_dep_id = $this->input->post('depid');
            $nextpage = 1;
            
            // remove minister indicator in session
            $filter = $this->session->userdata('indicator_dep_select');
            $index = array_search($indicator_dep_id,$filter);
            unset($filter[$index]);
            $filter = array_values($filter);
            $this->session->set_userdata('indicator_dep_select', $filter);
        }else{
            $indicator_dep_id = 0;
        }
        
        // link minister goal id 
        if ($this->input->post('depgoalid') > 0) {
            $goal_dep_id = $this->input->post('depgoalid');
            $nextpage = 2;
            
            // remove minister goal in session
            $filter = $this->session->userdata('goal_dep_select');
            $index = array_search($goal_dep_id,$filter);
            unset($filter[$index]);
            $filter = array_values($filter);
            $this->session->set_userdata('goal_dep_select', $filter);
        }else{
            $goal_dep_id = 0;
        }

        $indicatorNO= ($this->input->post('indicatorNO'));
		$indicatorName= ($this->input->post('indicatorName'));

		$goalmin= ($this->input->post('goalmin'));
		$weightmin= ($this->input->post('weightmin'));
		
        // dep goal response name array
		$userid= ($this->input->post('userid'));
            
		//array
		$goalNO = $this->input->post('goalNO');
		$goalName = $this->input->post('goalName');

		$criterion1 = $this->input->post('criterion1');
		$criterion2 = $this->input->post('criterion2');
		$criterion3 = $this->input->post('criterion3');
		$criterion4 = $this->input->post('criterion4');
		$criterion5 = $this->input->post('criterion5');
		$technote = $this->input->post('technote');
        
        $editid = $this->session->userdata('sessid');
			
        
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
				'technicalNote' => $technote,
                'isDep' => $indicator_dep_id,
                'isGoalDep' => $goal_dep_id,
                'editorID' => $editid
				
        );


        $resultMin = $this->ministerindicator->addIndicatorDivision($indicator);
		if ($resultMin) {

		  $indicatorid = $this->db->insert_id();
		  $goal = array();
		  for ($i=0; $i<count($goalNO); $i++) {
			if ($goalName[$i]!=null) {
				$goal['indicatorID']= $indicatorid;
				$goal['number']= $goalNO[$i];
				$goal['name']= $goalName[$i];
                $goal['responseID'] = $userid[$i];
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
				
                
                $data['showresult'] = "success";
				// if success , go to indicator table


        }
		else {
		  $data['showresult'] = "fail";
		}
        
        if ($nextpage == 1) {
            $this->load->view('indicator/addnewindicatordivfromindep_view',$data);
        }elseif ($nextpage == 2) {
            $this->load->view('indicator/addnewindicatordivfromgoaldep_view',$data);
        }else{
            $this->load->view('indicator/addnewindicatordivision_view',$data);
        }
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
    
    function editNumberDep() {
		$indicatorid = $this->uri->segment(3);
		$newnum = $this->uri->segment(4);
        $depid = $this->uri->segment(5);

		$indicator = array(
			"id" => $indicatorid,
			"number" => $newnum
			);

		$result = $this->ministerindicator->editNumberDep($indicator);

		redirect('manageindicator/viewDep/'.$depid, 'location');
				
	}
    
    function editNumberDiv() {
		$indicatorid = $this->uri->segment(3);
		$newnum = $this->uri->segment(4);
        $divid = $this->uri->segment(5);

		$indicator = array(
			"id" => $indicatorid,
			"number" => $newnum
			);

		$result = $this->ministerindicator->editNumberDiv($indicator);

		redirect('manageindicator/viewDiv/'.$divid, 'location');
				
	}
	
	function delete()
	{
		
		$indicatorid = $this->uri->segment(3);
		$this->ministerindicator->delIndicator($indicatorid);
		$this->ministerindicator->delGoalbyIndicator($indicatorid);
		$this->ministerindicator->delResponsebyIndicator($indicatorid);
		
		redirect('manageindicator/showMinister', 'refresh');
	}
    
    function deleteGoalTemp($table=null)
	{
		$goalid = $this->uri->segment(4);
        switch($table) {
            case 1: $this->ministerindicator->delGoalTemp($goalid,"min_goal");
                    break;
            default: break;
        }
		
		redirect('manageindicator/addIndicatorMinister', 'location');
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
    
    function deleteDepTemp()
    {
        $id = $this->uri->segment(3);
        $this->ministerindicator->delDepIndicatorTemp($id);
        
        $this->addDepartment();
    }
    
    function deleteDivTemp()
    {
        $id = $this->uri->segment(3);
        $this->ministerindicator->delDivIndicatorTemp($id);
        
        $this->addDivision();
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
    
    function getKongFromGom()
    {
        $depid = $this->input->post('depid');
        $result = $this->department->getKongFromOneGom($depid);
        echo json_encode($result);
    }
    
    function addMinGoalTemp() 
    {
        $number = $this->input->post('goalnumber');
        $name = $this->input->post('goalname');
        
        $this->session->set_userdata('number', $this->input->post('number'));
        $this->session->set_userdata('name', $this->input->post('name'));
        $this->session->set_userdata('weightmin', $this->input->post('weight'));
        
        $userid = $this->session->userdata('sessid');
        
        $goal = array('number' => $number, 'name' => $name, 'indicatorID' => 0, 'editorID' => $userid);
        
        $this->ministerindicator->addIndicatorGoal($goal);
        redirect('manageindicator/addIndicatorMinister', 'location');
    }

}