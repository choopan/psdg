<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view('menu_person'); ?>
<div id="page-wrapper">
	
	<h3>รายงานผลการปฏิบัติราชการระดับบุคคล ประจำปีงบประมาณ <?php echo $year; ?> รอบที่ <? echo $round; ?></h3>
	<div class="row">
		<div class="col-lg-12">
		<?php 	if($this->session->flashdata('success')) {
			?>
						<div class="alert alert-success alert-dismissable">
  							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php			echo $this->session->flashdata('success'); ?>
						</div>
			<?php	} elseif($this->session->flashdata('failed')) { ?>
						<div class="alert alert-danger alert-dismissable">
  							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php			echo $this->session->flashdata('failed'); ?>
						</div>				
			<?php   } ?>
				
            <div class="panel panel-default">
				<div class="panel-heading">รายการรอการพิจารณาและแก้ไข</div>
				<div class="panel-body">
					<form class="form-inline" role="form" >					
					<table class="table table-hover" id="exec_table">
						<thead>
							<tr>
								<th style="width: 200px">ชื่อ - นามสกุล</th>	
								<th>สังกัด</th>	
								<th>หน่วยงาน</th>					
								<th>ตำแหน่ง</th>
								<th>สถานะ</th>
								<th>จัดการ</th>
							</tr>
						</thead>
						<tbody>	
								<?php
									foreach($exec_info as $ui) {
								?>
									<tr>
										<td><?php echo $ui['PWFNAME']." ".$ui['PWLNAME']; ?></td>
										<td><?php echo $ui['depname'] ?></td>
										<td><?php echo $ui['divname']; ?></td>
										<td><?php echo $ui['position']; ?> </td>
										<?php 
											if($this->personindicator->getPIStatus($ui['userID'], $ui['depID'], $ui['divID'], $year, $round) != 3) {
												echo "<td><span class='label label-default'>ตัวชี้วัดยังไม่ผ่านการอนุมัติ</span></td><td> - </td>";
											} else {
												switch($this->personindicator->getPIEvalStatus($ui['userID'], $ui['depID'], $ui['divID'], $year, $round)) {
													case 0 : echo "<td><span class='label label-danger'>ยังไม่ส่งรายงาน</span></td><td> - </td>"; break;
													case 1 : echo "<td><span class='label label-success'>รอการพิจารณา</span></td><td><a href='". site_url('person_evaluation/confirmEvaluationFromDep') ."/". $ui['userID'] ."' class='btn btn-primary' type='button'> ดูรายละเอียด</a></td>"; break;
													case 3 : echo "<td><span class='label label-primary'>อนุมัติแล้ว</span></td><td><a href='". site_url('person_evaluation/viewEvaluation') ."/". $ui['userID'] ."' class='btn btn-primary' type='button'> ดูรายละเอียด</a></td>"; break;
													default : echo "<td><span class='label label-primary'>????</span></td><td> - </td>"; break;
												}											
											}
										?>								
                            		</tr>
                            		
								<?php       		
									}								
								?>
						</tbody>
					</table>
					</form>					
				</div>
			</div>
			
			
			
			    <div class="panel panel-warning">
				<div class="panel-heading">รายการรอการตรวจสอบและอนุมัติ</div>
				<div class="panel-body">
					<form class="form-inline" role="form" >					
					<table class="table table-hover" id="user_table">
						<thead>
							<tr>
								<th style="width: 200px">ชื่อ - นามสกุล</th>	
								<th>สังกัด</th>	
								<th>หน่วยงาน</th>					
								<th>ตำแหน่ง</th>
								<th>สถานะ</th>
								<th>จัดการ</th>
							</tr>
						</thead>
						<tbody>	
								<?php
									foreach($user_info as $ui) {
								?>
									<tr>
										<td><?php echo $ui['PWFNAME']." ".$ui['PWLNAME']; ?></td>
										<td><?php echo $ui['depname'] ?></td>
										<td><?php echo $ui['divname']; ?></td>
										<td><?php echo $ui['position']; ?> </td>
										<?php 
											if($this->personindicator->getPIStatus($ui['userID'], $ui['depID'], $ui['divID'], $year, $round) != 3) {
												echo "<td><span class='label label-default'>ตัวชี้วัดยังไม่ผ่านการอนุมัติ</span></td><td> - </td>";
											} else {
												switch($this->personindicator->getPIEvalStatus($ui['userID'], $ui['depID'], $ui['divID'], $year, $round)) {
													case 0 : echo "<td><span class='label label-danger'>ยังไม่รายงาน</span></td><td> - </td>"; break;
													case 1 : echo "<td><span class='label label-warning'> รอการพิจารณา <BR>จากผู้บังคับบัญชาเบื้องต้น</span></td><td> - </td>"; break;
													case 2 : echo "<td><span class='label label-success'> อนุมัติ <BR>จากผู้บังคับบัญชาเบื้องต้น</span></td><td><a href='". site_url('person_evaluation/confirmEvaluationFromDep') ."/". $ui['userID'] ."' class='btn btn-primary' type='button'> ดูรายละเอียด</a></td>"; break;
													case 3 : echo "<td><span class='label label-primary'>อนุมัติแล้ว</span></td><td><a href='". site_url('person_evaluation/viewEvaluation') ."/". $ui['userID'] ."' class='btn btn-primary' type='button'> ดูรายละเอียด</a> </td>"; break;
													default : echo "<td><span class='label label-default'>????</span></td><td> - </a></td>"; break;											
												}
											}
										?>								
                            		</tr>
                            		
								<?php       		
									}								
								?>
						</tbody>
					</table>
					</form>					
				</div>
			</div>

		</div>
	</div>


</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.min.js"></script>
<script type="text/javascript" charset="utf-8">	
	$(document).ready(function() {
		$('#user_table').dataTable({
			"order": [[ 0, "asc" ]],
			"paging": false,
			"info":     false,
		});
	});
</script>
</body>
</html>