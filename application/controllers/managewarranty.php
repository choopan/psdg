<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managewarranty extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('managewarranty_model');
	   $this->load->model('user','',TRUE);
	   $this->load->library("PHPWord/PHPWord");
	   $this->load->helper('download');
	}
    
	function index()
	{
		
	}
	
    function autocompleteResponse()
	{
		//$this->load->model('user');
		$term = $this->input->get('term', TRUE);
		$pwemployee = $this->managewarranty_model->searchName($term);
		/* echo '<pre>';
		print_r($pwemployee);
		echo '</pre>';
		exit(); */
		//echo $this->input->get("callback", true) . '(' . json_encode($pwemployee) . ')';
			echo  json_encode($pwemployee);
	}
	
	function get_data_user_ajax()
	{
		
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//													department
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	function department($alert=null)
    {
        // Form เพิ่ม ผู้ทำคำรับรอง และ ผู้รับคำรับรอง ระดับกรม อาจจะมีมากกว่า 1 คน
		$data['alert']=$alert;
		$this->load->view('managewarranty/managewarranty_depart_view',$data);
    }

	function add_ratification_depart()
	{
		$data['department'] = $this->managewarranty_model->get_data('*','department');
		$this->load->view('managewarranty/add_managewarranty_depart_view',$data);
	}
	
	function save_ratification_depart()
	{
		$department_id=$this->input->post('department_id');
		
		$recip_employee_id=$this->input->post('recip_employee_id');
		$recip_possition_id=$this->input->post('recip_possition_id');
		$recip_depname_id=$this->input->post('recip_depname_id');
		
		$maker_employee_id=$this->input->post('maker_employee_id');
		$maker_possition_id=$this->input->post('recip_employee_id');
		$maker_depname_id=$this->input->post('recip_employee_id');
		
		echo '<pre>';
		print_r($department_id);
		print_r($recip_employee_id);
		print_r($maker_employee_id);
		echo '</pre>';
		exit();
		redirect('managewarranty/department/save_war_dep_success');
	}




//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//													division
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


    function division()
    {
        // Form เพิ่ม ผู้ทำคำรับรอง และ ผู้รับคำรับรอง ระดับกอง อาจจะมีมากกว่า 1 คน   
    }

	
	
	
	
	
	
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//													gen docs
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	function gen_managewarranty_docx()
	{
		$PHPWord = new PHPWord();
		$PHPWord->setDefaultFontName('TH SarabunPSK');
		$PHPWord->setDefaultFontSize(16);
		$PHPWord->addFontStyle('HeadStyle', array('bold'=>true,'size'=>18));
		
		$HeadTables=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center');
		$ContentTables=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0);
		$style=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0);
		
		$PHPWord->addParagraphStyle('TextLongStyle', array('align'=>'both','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$PHPWord->addParagraphStyle('TextShortStyle', array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$PHPWord->addTableStyle('myOwnTableStyle',array('borderSize'=>6,'borderColor'=>'000000','valign'=>'center','cellMarginTop'=>80,'cellMarginLeft'=>80,'cellMarginRight'=>80,'cellMarginBottom'=>0));
		
		// New portrait section
		$section = $PHPWord->createSection();
		
		$section->addImage('images/garuda_logo.png',array('width'=>100, 'height'=>100, 'align'=>'center'));
		$section->addText('คำรับรองการปฏิบัติราชการ', 'HeadStyle',array('align'=>'center','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addText('กรมยุโรป', 'HeadStyle', array('align'=>'center','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addText('ประจำปีงบประมาณ พ.ศ. 2556', 'HeadStyle', array('align'=>'center','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addTextBreak(2);
		
		$section->addText('1. คำรับรองระหว่าง ');
		
		$section->addText('');
		
		$table = $section->addTable();
		$table->addRow();
		$table->addCell(4000)->addText('         นายสีหศักดิ์ พวงเกตุแก้ว');
		$table->addCell(3000)->addText('ปลัดกระทรวงการต่างประเทศ');
		$table->addCell(3000)->addText('ผู้รับคำรับรอง');
		
		$table->addRow();
		$table->addCell(180000, array('gridSpan' => 3))->addText('และ',null,array('align'=>'center'));
		
		
		$table->addRow();
		$table->addCell(4000)->addText('         นายวิชาวัฒน์ อิศรภัคดี');
		$table->addCell(3000)->addText('รองปลัดกระทรวงต่างประเทศ');
		$table->addCell(3000)->addText('ผู้ทำคำรับรอง');
		
		$table->addRow();
		$table->addCell(4000)->addText('         นายศรัณย์ เจริญสุวรรณ');
		$table->addCell(3000)->addText('อธิบดีกรมยุโรป');
		$table->addCell(3000)->addText('ผู้รับคำรับรอง');
		
		$section->addText('');
		
		$section->addText('2. คำรับรองนี้เป็นคำรับรองฝ่ายเดียว มิใช่สัญญาและใช้สำหรับระยะเวลา 1 ปี เริ่มตั้งแต่วันที่',null,'TextShortStyle');
		$section->addText('    1 ตุลาคม 2555 ถึงวันที่ 30 กันยายน 2556',null,'TextShortStyle');
		
		$section->addText('');
		
		$section->addText('3. รายละเอียดของคำรับรอง ได้แก่ กรอบการประเมินผล ประเด็นการประเมินผลการปฏิบัติราชการ',null,'TextShortStyle');
		$section->addText('    น้ำหนัก ตัวชี้วัดผลการปฏิบัติราชการ เป้าหมาย เกณฑ์การให้คะแนน และรายละเอียดอื่น ๆ',null,'TextShortStyle');
		$section->addText('    ตามที่ปรากฏอยู่ในเอกสารประกอบท้ายคำรับรองนี้',null,'TextShortStyle');
		
		$section->addText('');
		
		$section->addText('4. ข้าพเจ้า นายสีหศักดิ์ พวงเกตุแก้ว ในฐานะปลัดกระทรวงการต่างประเทศและผู้บังคับบัญชาของ',null,'TextShortStyle');
		$section->addText('    นายวิชาวัฒน์ อิศรภัคดี รองปลัดกระทรวงที่กำกับดูแลกรมยุโรป และนายศรัณย์ เจริญสุวรรณ',null,'TextShortStyle');
		$section->addText('    อธิบดีกรมยุโรป ได้พิจารณาและเห็นชอบกับแผนปฏิบัติราชการและแนวทางการพัฒนาการปฏิบัติ',null,'TextShortStyle');
		$section->addText('    ราชการของกรมยุโรป ประเด็นการประเมิลผลการปฏิบัติราชการ น้ำหนัก ตัวชี้วัดผลการปฏิบัติ',null,'TextShortStyle');
		$section->addText('    ราชการ เป้าหมาย เกณฑ์การให้คะแนน และรายละเอียดอื่น ๆ ตามที่กำหนดในเอกสารประกอบ',null,'TextShortStyle');
		$section->addText('    ท้ายคำรับรองนี้ และข้าพเจ้ายินดีจะให้คำแนะนำกำกับ และตรวจสอบผลการปฏิบัติราชการของ',null,'TextShortStyle');
		$section->addText('    นายวิชาวัฒน์ อิศรภัคดี และนายศรัณย์ เจริญสุวรรณ ให้เป็นไปตามคำรับรองที่จัดทำขึ้นนี้',null,'TextShortStyle');
		
		$section->addText('');
		
		$section->addText('5. ข้าพเจ้า นายวิชาวัฒน์ อิศรภัคดี รองปลัดกระทรวงการต่างประเทศที่กำกับดูแลกรมยุโรป และ',null,'TextShortStyle');
		$section->addText('    นายศรัณย์ เจริญสุวรรณ อธิบดีกรมยุโรป ได้ทำความเข้าใจคำรับรองตาม 3 แล้ว ขอให้คำรับรองกับ',null,'TextShortStyle');
		$section->addText('    ปลัดกระทรวงการต่างประเทศ ว่าจะมุ่งมั่นปฏิบัติราชการให้เกิดผลงานที่ดีตามเป้าหมายของตัวชี้วัด',null,'TextShortStyle');
		$section->addText('    แต่ละตัวในระดับสูงสุด เพื่อให้เกิดประโยชน์สุขแก่ประชาชน ตามที่ให้คำรับรองไว้',null,'TextShortStyle');
		
		$section->addText('');
		
		$section->addText('6. ผู้รับคำรับรองและผู้ทำคำรับรองได้เข้าใจคำรับรองการปฏิบัติราชการและเห็นพ้องกันแล้ว',null,'TextShortStyle');
		$section->addText('    จึงได้ลงลายมือชื่อไว้เป็นสำคัญ',null,'TextShortStyle');
		
		$section->addTextBreak(2);
		$st=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center');
		$table = $section->addTable();
		$table->addRow();
		$table->addCell(4600)->addText('…………………………………………………',null,$st);
		$table->addCell(4600)->addText('…………………………………………………',null,$st);

		$table->addRow();
		$table->addCell(4600)->addText('( นายสีหศักดิ์ พวงเกตุแก้ว )',null,$st);
		$table->addCell(4600)->addText('( นายวิชาวัฒน์ อิศรภัคดี )',null,$st);
		
		$table->addRow();
		$table->addCell(4600)->addText('ปลัดกระทรวงการต่างประเทศ',null,$st);
		$table->addCell(4600)->addText('รองปลัดกระทรวงการต่างประเทศ',null,$st);
		
		
		$table->addRow();
		$table->addCell(4600)->addText('วันที่ .........................................',null,$st);
		$table->addCell(4600)->addText('วันที่ .........................................',null,$st);
		
		$section->addTextBreak(1);
		$table = $section->addTable();
		$table->addRow();
		$table->addCell(4600)->addText('…………………………………………………',null,$st);

		$table->addRow();
		$table->addCell(4600)->addText('( นายศรัณย์ เจริญสุวรรณ )',null,$st);
		
		$table->addRow();
		$table->addCell(4600)->addText('อธิบดีกรมยุโรป',null,$st);
		
		
		$table->addRow();
		$table->addCell(4600)->addText('วันที่ .........................................',null,$st);
		
		$file_name=uniqid('managewarranty',true).'.docx';
		$path='docs/word'.$file_name;
		
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save($path);

		//$file['full_path']=$_SERVER['DOCUMENT_ROOT'].'/'.$path;
		$file['full_path']=$_SERVER['DOCUMENT_ROOT'].'/psdg/'.$path;
		$file['file_name']=$file_name;
		
		$this->download_file($file);
		
		
	}
	function download_file($file)
	{
		$data = file_get_contents($file['full_path']);
		$name = $file['file_name'];
		force_download($name,$data);
	}
	
	
	
	
	
}