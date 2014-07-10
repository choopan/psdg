<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view('menu_person'); ?>
<div id="page-wrapper">
	
	<div class="pull-right"><h4><strong>สถานะ :</strong>&nbsp;&nbsp;<?php echo $status_msg; ?></h4></div><br><br>
			
	<div class="row">
		<div class="col-lg-12">
			<?php 	if($this->session->flashdata('success')) {
			?>
						<div class="alert alert-success alert-dismissable">
  							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php			echo $this->session->flashdata('success'); ?>
						</div>
			<?php	}
					$sumweight = 0;
			?>
				
			<?php $this->load->view('evaluate/viewPersonInfo'); ?>			
			
		    <div class="panel panel-success">
		    		<div class="panel-heading">
		    			<h4>ตัวชี้วัดรายบุคคลที่กำหนด ประจำปีงบประมาณ <?php echo $year; ?> รอบที่ <?php echo $round; ?></h4>
		    		</div>	
        
								<div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped row-border table-hover" id="dataTables-example">
                                <thead>
                                	<tr>
										<th rowspan="2">ลำดับที่</th>
										<th rowspan="2">ชื่อตัวชี้วัด</th>
										<th colspan="5" style="text-align: center;">เกณฑ์การให้คะแนน</th>
										<th rowspan="2">น้ำหนัก</th>	
										<th rowspan="2">รายละเอียด</th>								
									</tr>
									<tr>
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
										<th>5</th>
										
									</tr>
								</thead>
                                <tbody>
                                <?php
									foreach($indicators as $ind) {
								?>	
										<tr>
											<td><?php echo $ind['order']; ?></td>
											<td><?php echo $ind['name']; ?></td>
											<td><?php echo $ind['indicator1']; ?></td>
											<td><?php echo $ind['indicator2']; ?></td>
											<td><?php echo $ind['indicator3']; ?></td>
											<td><?php echo $ind['indicator4']; ?></td>
											<td><?php echo $ind['indicator5']; ?></td>
											<td><?php echo $ind['weight']; $sumweight +=  $ind['weight'];?></td>
											<td>
												<a data-toggle="modal" data-target="#myModal<?php echo $ind['ID']; ?>" href='<?php echo site_url("person_evaluation/viewPersonIndicatorDetail/".$ind['ID']); ?>' class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
														<div class="modal fade" id="myModal<?php echo $ind['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											    			<div class="modal-dialog modal-lg">
        														<div class="modal-content">
        														</div> 
    														</div>
														</div>
												
											</td>
										</tr>
								<?php
									}
								?>
								<tr><td colspan=7 style="text-align: right"><strong>รวมค่าน้ำหนัก ==> </strong></td><td><strong><?php echo number_format($sumweight, 2); ?></strong></td><td></td></tr>
								</tbody>
					</table>
					<center>
						<a type="button" href="<?php echo site_url('person_evaluation/depManagePersonIndicator'); ?>" class="btn btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> ย้อนกลับ</a>&nbsp;&nbsp;
						<a href="<?php echo site_url('person_evaluation/agreeIndicatorFromDep').  "/" . $pi_set ."/". $user['user_id'] ."/".$sumweight; ?>" type="button" class="btn btn-primary" onClick='return confirm(" คุณอนุมัติตัวชี้วัดนี้หรือไม่ ")'><span class="glyphicon glyphicon-ok"></span> อนุมัติตัวชี้วัด</a>&nbsp;&nbsp;
						<a href="<?php echo site_url('person_evaluation/cancelIndicatorFromDep'). "/" . $pi_set; ?>" type="button" class="btn btn-danger" onClick='return confirm(" คุณต้องการไม่อนุมัติตัวชี้วัดจริงหรือไม่ ")'><span class="glyphicon glyphicon-remove"></span> ไม่อนุมัติ</a>
		
					</center>			
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-10">
			
		</div>
	</div>

</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.min.js"></script>

</body>
</html>