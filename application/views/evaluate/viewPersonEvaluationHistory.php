<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view('menu_person'); ?>

<div id="page-wrapper">
	<h2>รายงานผลการปฏิบัติงาน รอบปีงบประมาณ <?php echo $year; ?> รอบที่ <?php echo $round ?> </h2>
	<div class="row">
		<div class="col-lg-12">
		<?php 	if($this->session->flashdata('success')) {
			?>
						<div class="alert alert-success alert-dismissable">
  							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php			echo $this->session->flashdata('success'); ?>
						</div>
			<?php	} ?>
			

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
										$exec_total_score = 0;
										echo number_format($exec_indicator_total_score, 2);
									 ?></td>
								<td>0.70</td>
								<td><?php
										$exec_ind_final_score = round($exec_indicator_total_score * 0.7, 2);
										echo number_format($exec_ind_final_score, 2);
										 
									?></td>
							</tr>
							<tr>
								<td>องค์ประกอบที่  2 : พฤติกรรมการปฏิบัติราชการ (สมมรณะ)</td>
								<td><?php echo number_format($exec_core_total_score, 2);
										 
										?></td>
								<td>0.30</td>
								<td><?php 
										$exec_core_final_score = round($exec_core_total_score * 0.3, 2);
										
										//$total_score += $core_final_score;
										//$exec_total_score += $exec_core_final_score;
										
										echo number_format($exec_core_final_score, 2);
										 ?></td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right"><strong>รวม</strong></td>
								<td><strong>100%</strong></td>
								<td><strong><? 	echo number_format($exec_ind_final_score + $exec_core_final_score, 2);
											?></strong></td>								
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
											<?php	echo $ind['exec_score']; 
													echo " (".$ind['score'].")"; ?>
										</td>
										<td style="text-align: center;"><?php $sum_all_weight += $ind['weight']; echo $ind['weight']; ?></td>
										<td style="text-align: center;">
										<?php 
											$exec_this_score = round($ind['exec_score'] * $ind['weight'], 2);
											$exec_total_score += $exec_this_score;
											echo number_format($exec_this_score, 2);
																					  
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
									<th rowspan="2" style="text-align: center;width: 10%"><?php echo number_format($exec_total_score, 2); ?></th>
								</tr>
							</thead>
						</table>
						<table class="table table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th rowspan="2" style="text-align: center;width: 80%">แปลงคะแนนรวม (ค) ข้างต้น เป็นคะแนนการประเมินผลสัมฤทธิ์ของงานที่มีฐานคะแนนเป็น 100 คะแนน (โดยนำ 20 มาคูณ)</th>
									<th rowspan="2" style="text-align: center;width: 5%"></th>
									<th colspan="2" style="text-align: center;width: 5%"> =====> </th>
									<th rowspan="2" style="text-align: center;width: 10%">
										<?php 	
												$exec_last_score = $exec_total_score * 20; 
												echo number_format($exec_last_score, 2); ?></th>
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
													
												</tr>
											</thead>
											<tbody>
												<?php foreach($all_saved_activities[$ind['ID']] as $activity) {
														echo "<tr>";
														echo "<td>".$activity['order']."</td>";
														echo "<td>".$activity['activity_date']."</td>";
														echo "<td>".$activity['activity_name']."</td>";
														echo "<td>".$activity['execscore']."</td>";
														echo "<td>".$activity['document_name']."</td>";
													}													
												?>													
											</tbody>
										</table>										
									</div>
								</div>
								<? } ?>
							</div>
									
						</div>
					</div>
				</div>


			

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
                                        <th style="text-align: center">ระดับที่คาดหวัง</th>
                                        <th style="text-align: center">ระดับสมมรณะที่แสดงออก  (ก)</th>										
                                        <th style="text-align: center">น้ำหนัก (ข)</th>
										<th style="text-align: center">คะแนนรวม (ค = ก  x ข) (ประเมินตนเอง)</th>
                                    </tr>
                                </thead>
								<tbody>
										<?php
											
											$exec_sum_core_score = 0;
											$core_weight = round(1.0/count($cores), 2);
											foreach($cores as $ind) {
											
										?>
										<tr>
											<td >
												<?php echo $ind['name']; ?>
											</td>
											<td style="text-align: center">
												<?php echo $ind['expectVal']; ?>
											</td>
											<td style="text-align: center"> 
												<?php 												
														echo $ind['exescore'];												 												
												?>	
												</center>											
											</td>
											<td style="text-align: center">
												<?php echo number_format($core_weight, 2); ?>
											</td>
											<td style="text-align: center">
												<?php 
												$exec_core_score = round($core_weight * $ind['exescore'], 2);
												$exec_sum_core_score += $exec_core_score;
												echo number_format($exec_core_score, 2);
												; ?></td>
										</tr>
										<?php
											}
										?>
										<tr>
											<td colspan="3" style="text-align: right"><strong>รวม</strong></td>
											<td style="text-align: center"><strong>1.00</strong></td>
											<td style="text-align: center"><strong><?php echo number_format($exec_sum_core_score,2); ?></strong></td>
										</tr>
										<tr>
											<td colspan="3" style="text-align: right">
												<strong>
													แปลงคะแนนรวม (ค) ข้างต้น เป็นคะแนนการประเมินสมรรณะที่มีฐานคะแนนเต็มเป็น 100 (โดยนำ 20 มาคูณ) 
												</strong>
											</td>
											<td style="text-align: right"> ====></td>
											<td style="text-align: center"><strong><?php echo number_format($exec_sum_core_score * 20, 2); ?></strong></td>
										</tr>
                                </tbody>
							</table>
							
						</div>
					</div>
				</div>
				<center>
				    <button type="button" onclick="javascript:history.go(-1)" class="btn btn-warning">
					<span class="glyphicon glyphicon-chevron-left"></span> ย้อนกลับ</button>

				</center>
				<BR><BR><BR>
			
						
					
			
			
			
			



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
