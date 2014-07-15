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
		<div class="col-lg-12">
			<?php 	if($this->session->flashdata('success')) {
			?>
						<div class="alert alert-success alert-dismissable">
  							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php			echo $this->session->flashdata('success'); ?>
						</div>
			<?php	}?>
				
            <div class="panel panel-default">
				<div class="panel-heading"><strong>รายงานผลการปฏิบัติราชการรายบุคคล ประจำปีงบประมาณ <?php echo $year; ?> รอบที่ <? echo $round; ?></strong></div>
				<div class="panel-body">
					<form class="form-inline" role="form" >					
					<table class="table table-hover" id="indicator_table">
						<thead>
							<tr>
								<th style="width: 200px">ชื่อ - นามสกุล</th>		
								<th>กรม</th>			
								<th>กอง</th>		
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
										<td><?php echo $ui['depname']; ?></td>
										<td><?php echo $ui['divname']; ?></td>
										<td><?php echo $ui['position']." (ระดับ ".$ui['PWLEVEL'].")"; ?> </td>
										<?php 
											if($this->personindicator->getPIStatus($ui['user_id'], $ui['dep_id'], $ui['div_id'], $year, $round) != 3) {
												echo "<td><span class='label label-default'>ตัวชี้วัดยังไม่ผ่านการอนุมัติ</span></td><td> - </td>";
											} else {
										
												switch($this->personindicator->getPIEvalStatus($ui['user_id'], $ui['dep_id'], $ui['div_id'], $year, $round)) {
													case 0 : echo "<td><span class='label label-danger'>ยังไม่ส่งรายงาน</span></td><td> - </td>"; break;
													case 1 : echo "<td><span class='label label-warning'> รอการพิจารณา <BR>จากผู้บังคับบัญชาเบื้องต้น</span></td><td> - </td>"; break;
													case 2 : echo "<td><span class='label label-success'> อนุมัติ <BR>จากผู้บังคับบัญชาเบื้องต้น</span></td><td> - </td>"; break;
													case 3 : echo "<td><span class='label label-primary'>อนุมัติแล้ว</span></td><td>"
										 ?>
													<a type="button" class="btn btn-danger" onclick="javascript:confirm('ต้องการยกเลิกการอนุมัติตัวชี้วัดจริงหรือไม่ ?')" 
																href="<?php echo site_url('person_evaluation/minCancelEvaluation/'.$ui['user_id']); ?>"> ยกเลิกการอนุมัติ</a></td>
										<?php 				break;
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
		$('#indicator_table').dataTable({"order": [[ 0, "asc" ]]});
	});
</script>
</body>
</html>