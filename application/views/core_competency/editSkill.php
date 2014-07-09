<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>
	<div id="wrapper">
	<?php $this->load->view('menu_admin'); ?>
	
	
	
	<div id="page-wrapper">
		<div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
					<div class="panel-heading">
						<h4>แก้ไขหัวข้อสมรรณะ</h4>					
					</div>
                                        
                    <div class="panel-body">
						<form class="form-horizontal" action="<?php echo site_url('core_competency/updateSkill/'.$skillID); ?>" method="POST">
							<div class="form-group row">
									<div class="col-lg-2">
										<label for='skill' class="control-label">ชื่อสมรรณะ :</label>
									</div>
									<div class="col-lg-6">										
										<input type="hidden" name="skillID" value="<? echo $skillID; ?>">			
										<input id='skill' type="text" class="form-control" name="skill" value="<?php echo $skillname[0]['name']; ?>">
									</div>
							</div>
							<div class="form-group row">							
									<div class="col-lg-6">												
										<input type="submit" class="btn btn-success" value="บันทึก">
										<a href="<? echo site_url('core_competency/manageSkill'); ?>" class="btn  btn-danger">ยกเลิก</a>																														
									</div>
							</div>
						</form>
					</div>
				</div>
			</div>	
		</div>
	</div>


<?php $this->load->view('js_footer'); ?>
</body>
</html>