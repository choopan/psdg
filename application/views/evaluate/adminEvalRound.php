<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view('menu'); ?>
<div id="page-wrapper">
	
	<div class="row">
		<div class="col-lg-12">
			<?php 	if($this->session->flashdata('success')) {
			?>
						<div class="alert alert-success alert-dismissable">
  							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php			echo $this->session->flashdata('success'); ?>
						</div>
			<?php	}?>
				
            <div class="panel panel-primary">
				<div class="panel-heading"><strong>เพิ่มรอบการประเมินผลการปฏิบัติราขการรายบุคคล</strong></div>
				<div class="panel-body">
					<form class="form-inline" role="form" action="<?php echo site_url('person_evaluation/addEvalRound'); ?>" method="POST">
					  <div class="form-group">
						<label class="forn-control" for="">ปีงบประมาณ</label>
						<input type="text" class="form-control" name="year" id="year" value="<?php echo $this->session->userdata('sessyear')?>">
					  </div>
					  <div class="form-group">
						<label class="forn-control" for=""> รอบที่</label>
						<select id="round" name="round" class="form-control">
							<option value="1"> 1 </option>
							<option value="2"> 2 </option>
						</select>
					  </div>
					  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> เพิ่มรอบการประเมิน</button>
					</form>
				</div>
			</div>
			
			<div class="panel panel-success">
				<div class="panel-heading"><strong>ตั้งรอบการประเมินผลการปฏิบัติราขการรายบุคคล</strong></div>
				<div class="panel-body">
						<form class="form-inline" role="form"  action="<?php echo site_url('person_evaluation/setEvalRound'); ?>" method="POST">
					  		<div class="form-group">
								<label class="forn-control" for="">รอบประเมิน</label>
								<select name="eval_round_id" class="form-control">
								<?php
									foreach($evalrounds as $eva) {
										echo "<option value='".$eva['ID']."'>ปีงบประมาณ ".$eva['year']." รอบที่ ".$eva['round']."</option>";								
									}
								?>
								</select>
					  		</div>					  
					  <button type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-floppy-disk"></span> ตั้งค่ารอบการประเมิน</button>
					</form>
					<br>
					รอบประเมินที่ตั้งค่าในปัจจุบัน : 
						<?php 
							if($active_year == 0) { echo "ไม่มีการตั้งค่า"; }
							else {
								echo "ปีงบประมาณ ". $active_year . " รอบที่ ".$active_round;
							}
						?>							
						
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading"><strong>รอบการประเมินผลการปฏิบัติราขการรายบุคคล</strong></div>
				<div class="panel-body">
					  <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="skillTable">
                                <thead>
                                    <tr>
                                        <th>ปีงบประมาณ</th>
										<th>รอบที่</th>
										<th>ลบ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php
									foreach($evalrounds as $eva) {
										echo"<tr>";
										echo "<td>".$eva['year']."</td><td>".$eva['round']."</td>";
										echo "<td><a class='btn btn-danger' href=".site_url('person_evaluation/delEvalRound') . "/" . $eva['ID']."> ลบ </a></td>";
										echo "</tr>";								
									}
								?>

								</tbody>
							</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
</div>
</div>

<?php $this->load->view('js_footer'); ?>
<<script src="<?php echo base_url(); ?>/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>/js/bootbox.min.js"></script>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#skillTable').dataTable({"order": [[ 0, "desc" ], [1, "desc"]]});
	});
</script>
</script>


</body>
</html>