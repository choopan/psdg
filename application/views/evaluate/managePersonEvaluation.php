<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view('menu_person'); ?>
  <div id="page-wrapper">
	<h2>รายงานผลการปฏิบัติงาน รอบปีงบประมาณ <?php echo $year; ?> รอบที่ <?php echo $round ?> 
	<a href="<?php echo site_url('person_evaluation/submitEvaluation');?>" type="button" class="btn btn-success pull-right"><span class="glyphicon glyphicon-envelope"></span> ส่งเพื่อพิจารณา</a></h2>
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
			<?php	} 
					$sumweight = 0;
			?>

			<div class="panel panel-primary">
				<div class="panel-heading">
					สรุปผลการประเมิน
				</div>
				<div class="panel-body">
					<table class="table table-border table-hover">
						<thead>
							<tr>
								<th>องค์ประกอบการประเมิน</th>
								<th>คะแนน (ก)</th>
								<th>น้ำหนัก (ข)</th>
								<th>รวมคะแนน (ก) x (ข)</th>								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>องค์ประกอบที่  1 : ผลสัมฤทธิ์ของงาน</td>
								<td><?php 
										$total_score = 0;
										echo number_format($indicator_total_score,2); ?></td>
								<td>0.70</td>
								<td><?php
										$ind_final_score = round($indicator_total_score * 0.7, 2);
										$total_score += $ind_final_score; 
								
										echo number_format($ind_final_score, 2); ?></td>
							</tr>
							<tr>
								<td>องค์ประกอบที่  2 : พฤติกรรมการปฏิบัติราชการ (สมมรณะ)</td>
								<td><?php echo number_format($core_total_score,2); ?></td>
								<td>0.30</td>
								<td><?php 
										$core_final_score = round($core_total_score * 0.3, 2);
										$total_score += $core_final_score;
								
										echo number_format($core_final_score, 2); ?></td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right"><strong>รวม</strong></td>
								<td><strong>100%</strong></td>
								<td><strong><? echo number_format($ind_final_score + $core_final_score, 2); ?></strong></td>								
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
            <div class="panel panel-primary">
				<div class="panel-heading">
					<span class="glyphicon glyphicon-chevron-right"></span> องค์ประกอบที่  1 : แบบประเมินผลสัมฤทธิ์ของงาน
				</div>
				<div class="panel-body">
					<div class="table-responsive">
                   	    	<table class="table table-hover" id="dataTables-example">
								<thead>
									<tr class="success">
										<th rowspan="2" style="width: 5%">ตัวชี้วัดที่</th>
										<th rowspan="2" style="width: 35%">ตัวชี้วัดผลงาน</th>
										<th colspan="5" style="text-align: center;">คะแนนตามระดับค่าเป้าหมาย</th>
										<th rowspan="2" style="text-align: center;width: 5%">คะแนน(ก)</th>
										<th rowspan="2" style="text-align: center;width: 5%">น้ำหนัก(ข)</th>
										<th 
											rowspan="2" style="text-align: center;width: 10%">คะแนนรวม(ค)<br />(ค = ก x ข)</th>
									</tr>
									<tr class="success">
										<th style="text-align: center">1</th>
										<th style="text-align: center">2</th>
										<th style="text-align: center">3</th>
										<th style="text-align: center">4</th>
										<th style="text-align: center">5</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$total_score = 0;
									$sum_all_weight = 0;
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
										<td style="text-align: center">
											<?php echo $ind['score']; ?>
										</td>
										<td style="text-align: center;"><?php $sum_all_weight += $ind['weight']; echo $ind['weight']; ?></td>
										<td style="text-align: center;">
										<?php if($ind['score'] != 0) {
											$this_score = round($ind['score'] * $ind['weight'], 2);
											$total_score += $this_score;
											echo number_format($this_score, 2);
										  } else {
										  	echo "-";
										  }
										?>
										</td>
									</tr>
								<?php       		
									}								
								?>
								</tbody>
						</table>
						<table class="table table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th rowspan="2" style="width: 80%"></th>
									<th rowspan="2" style="text-align: center;width: 5%">รวม</th>
									<th rowspan="2" style="text-align: center;width: 5%"><?php echo number_format($sum_all_weight,2); ?></th>
									<th rowspan="2" style="text-align: center;width: 10%"><?php echo number_format($total_score,2); ?></th>
								</tr>
							</thead>
						</table>
						<table class="table table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th rowspan="2" style="text-align: center;width: 80%">แปลงคะแนนรวม (ค) ข้างต้น เป็นคะแนนการประเมินผลสัมฤทธิ์ของงานที่มีฐานคะแนนเป็น 100 คะแนน (โดยนำ 20 มาคูณ)</th>
									<th rowspan="2" style="text-align: center;width: 5%"></th>
									<th colspan="2" style="text-align: center;width: 5%"> =====> </th>
									<th rowspan="2" style="text-align: center;width: 10%" id="caltotalpoint" name="totalCalPoint"><?php $last_score = $total_score * 20; echo number_format($last_score, 2); ?></th>
								</tr>
							</thead>
						</table>
					</div>
				
					
					
					<div class="panel panel-danger">
							<div class="panel-heading">
										<strong>ผลการดำเนินงานตามภารกิจ</strong>
							</div>
							<div class="panel-body">


								<?php foreach($indicators as $ind) { ?>
								<div class="panel panel-warning">
									<div class="panel-heading">ตัวชี้วัดที่  <?php echo $ind['order']." : " .$ind['name']?></div>
									<div class="panel-body">
					    				<table class="table table-hover" id="dataTables-example">
											<thead>
												<tr class="warning">
													<th style="width: 8%">ลำดับที่</th>
													<th style="width: 14%">วันที่</th>
													<th>ภารกิจ</th>
													<th style="width: 5%">คะแนน</th>
													<th style="width: 20%">เอกสารอ้างอิง</th>
													<th style="width: 10%">จัดการ</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($all_saved_activities[$ind['ID']] as $activity) {
														echo "<tr>";
														echo "<td>".$activity['order']."</td>";
														echo "<td>".$activity['activity_date']."</td>";
														echo "<td>".$activity['activity_name']."</td>";
														echo "<td>".$activity['selfscore']."</td>";
														echo "<td>".$activity['document_name']."</td>";
														echo "<td>";
												?>
													<a data-toggle="modal" data-target="#editActivity<?php echo $activity['ID']; ?>" href="<?php echo site_url('person_evaluation/editActivity/'.$activity['ID'].'/'.$ind['PID']); ?>" 
													class= "btn btn-primary btn-xs" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
													
													<div class="modal fade"    id="editActivity<?php echo $activity['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-lg">
        													<div class="modal-content">
        													</div>
        												</div>
        											</div>
													<a href='<?php echo site_url("person_evaluation/deleteActivity/".$activity['ID']."/".$ind['PID']); ?>' class="btn btn-danger btn-xs" onClick='return confirm(" คุณต้องการลบหรือไม่ ")' title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></a>
													
												<?php	echo "</td></tr>";													
												}?>
											</tbody>
										</table>										
									</div>
								</div>
								<? } ?>
								<center>
								<a data-toggle="modal" data-target="#addActivity" class="btn btn-success" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-plus"></span> เพิ่มภารกิจตามตัวชี้วัด </a>
								</center>								
											<div class="modal fade" id="addActivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-lg">
        												<div class="modal-content">
        														<div class="modal-header">
													                	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 														<h4 class="modal-title">เพิ่มภารกิจตามตัวชี้วัด </h4>                 
            													</div>            <!-- /modal-header -->
            													<form class="form-inline" role="form"  action="<?php echo site_url('person_evaluation/saveActivity/'.$ind['PID']); ?>" method="POST">            														
            													<div class="modal-body">    
            																<div class="form-group">
            																	<label  for="">ตัวชี้วัด : </label>
            																	<select class="form-control" name="indicator">
            																	<?php foreach($indicators as $ind) { ?> 
            																		<option value="<?php echo $ind['ID']; ?>"><?php echo "ตัวชี้วัดที่ ".$ind['order']." : ".$ind['name']; ?></option>
            																	<?php } ?>
            																	</select>
            																</div>		
            																<BR><BR>
            														            														
            																<div class="form-group">
            																	<label  for="">ลำดับที่ : </label>
            																	<input type="text" class="form-control" name="order" style="width: 50px" required>
            																</div>		
            																<div class="form-group">            																
            																	<label for="">วันที่ :</label>
            																	<input type="text" class="form-control" name="activity_date" style="width: 250px" required>
            																</div>
            																<BR><BR>
            																	
            																<div class="form-group">            																
            																	<label for="">ภารกิจสำคัญที่ได้ดำเนินการ :</label>
            																	<input type="text" class="form-control" name="activity_name" style="width: 500px" required>
																			</div>            																	
            																<BR><BR>

            																<div class="form-group">            																
            																	<label for="">ผลการปฏิบัติงาน :</label>
            																	<input type="text" class="form-control" name="score" style="width: 100px">
																			</div>            																	
            																<div class="form-group">            																
            																	<label for="">หลักฐาน (ชื่อเอกสาร):</label>
            																	<input type="text" class="form-control" name="document_name" style="width: 280px">
																			</div>            																	            													
  																</div>            <!-- /modal-body -->
            													<div class="modal-footer">
                														<button type="submit" class="btn btn-primary">บันทึกผลการดำเนินงาน</button>&nbsp;&nbsp;
                														<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ปิด</button>
            													</div>            <!-- /modal-footer -->
            													</form>
        												</div> 
        										</div> 
    										</div>
									
							</div>
							</div>	
			</div>
	

	</div>




			   <form action="<?php echo site_url('person_evaluation/saveCoreScore/'.$indicators[0]['PID']); ?>" method="POST">
               <div class="panel panel-primary">
               		<div class="panel-heading">
                			<span class="glyphicon glyphicon-chevron-right"></span> องค์ประกอบที่ 2 : แบบประเมินพฤติกรรมการปฏิบัติราชการ (สมรรณะ)						
                	</div>
                	<div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="skillTable">
                                <thead>
                                    <tr>
                                        <th>ชื่อสมรรณะ</th>
                                        <th>ระดับที่คาดหวัง</th>
										<th>ระดับสมมรณะที่แสดงออก (ประเมินตนเอง) (ก)</th>
                                        <th>น้ำหนัก (ข)</th>
										<th>คะแนนรวม (ค = ก  x ข) (ประเมินตนเอง)</th>
                                    </tr>
                                </thead>
								<tbody>
										<?php
											$numIndex = 0;
											$sum_core_score = 0;
											$core_weight = round(1.0/count($cores), 2);
											foreach($cores as $ind) {
												$numIndex++;
										?>
										<tr>
											<td >
												<input type="hidden" name="coreSkillName[]" value="<?php echo $ind['name']; ?>">
												<?php echo $ind['name']; ?>
											</td>
											<td style="text-align: center">
												<input type="hidden" name="expectVal[]" value="<?php echo $ind['expectVal']; ?>">
												<?php echo $ind['expectVal']; ?>
											</td>
											<td>
												<input type="text" class="form-control" name="evalScore[]" value="<?php 
													if(isset($ind['selfscore'])) {
														echo $ind['selfscore'];
													} else {
														$ind['selfscore'] = 0;
													} 														
												?>">
											</td>
											<td style="text-align: center">
												<?php echo number_format($core_weight, 2); ?>
											</td>
											<td style="text-align: center">
												<?php 
												$core_score = round($core_weight * $ind['selfscore'], 2);
												$sum_core_score += $core_score;
												echo number_format($core_score, 2); ?></td>
										</tr>
										<?php
											}
										?>
										<tr>
											<td colspan="3" style="text-align: right"><strong>รวม</strong></td>
											<td style="text-align: center"><strong>1.00</strong></td>
											<td style="text-align: center"><strong><?php echo number_format($sum_core_score,2); ?></strong></td>
										</tr>
										<tr>
											<td colspan="4">
												<strong>
													แปลงคะแนนรวม (ค) ข้างต้น เป็นคะแนนการประเมินสมรรณะที่มีฐานคะแนนเต็มเป็น 100 (โดยนำ 20 มาคูณ) ===>
												</strong>
											</td>
											<td style="text-align: center"><strong><?php echo number_format($sum_core_score * 20, 2); ?></strong></td>
										</tr>
                                </tbody>
							</table>
							
							<center>
							<button type="submit" class="btn btn-success" name="option"><span class="glyphicon glyphicon-floppy-save"></span> บันทึกคะแนนแบบประเมินสมรรณะ</button>
							</center>
						</div>
					</div>
				</div>
				</form>
			


			

		</div> <!-- col-lg-12 -->
	</div> <!-- row -->
  </div> <!--page-wrapper -->
 </div> <!-- wrapper -->
<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.min.js"></script>
</body>
</html>