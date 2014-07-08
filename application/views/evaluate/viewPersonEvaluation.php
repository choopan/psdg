<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view('menu'); ?>
<div id="page-wrapper">
	<h2>รายงานผลการปฏิบัติงาน รอบปีงบประมาณ <?php echo $year; ?> รอบที่ <?php echo $round ?>
	</h2>
	
	
	
	
	<div class="row">
	
	
	
		<div class="col-lg-12">
			
			
			<div class="panel panel-default">
				<div class="panel-heading"><strong>ข้อมูลเบื้องต้น</strong></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-5">
							<strong>ชื่อ-นามสกุล :</strong> <?php echo $user['PWFNAME']." ".$user['PWLNAME']; ?>
						</div>
						<div class="col-lg-5">						
							<strong>ตำแหน่ง : </strong> <?php echo $user['position'] ." (ระดับ ". $user['PWLEVEL'] . ")"; ?>
						</div>	
					</div>
					<div class="row">
						<div class="col-lg-5">
							<strong>กอง :</strong> <?php echo $user['divname']; ?>
						</div>
						<div class="col-lg-5">
							<strong>กรม :</strong> <?php echo $user['depname']; ?>
						</div>
					</div>
					
				</div>
			</div>

			
			
			
            <div class="panel panel-primary">
				<div class="panel-heading"><strong>แบบประเมินผลสัมฤทธิ์ของงาน</strong></div>
				<div class="panel-body">
					<div class="table-responsive">
                        	<table class="table table-hover" id="dataTables-example">
								<thead>
									<tr class="success">
										<th rowspan="2">ตัวชี้วัดที่</th>
										<th rowspan="2" style="width: 45%">ตัวชี้วัดผลงาน</th>
										<th colspan="5" style="text-align: center;">คะแนนตามระดับค่าเป้าหมาย</th>
										<th rowspan="2" style="text-align: center;width: 5%">คะแนน(ก)</th>
										<th rowspan="2" style="text-align: center;width: 5%">น้ำหนัก(ข)</th>
										<th 
										rowspan="2" style="text-align: center;width: 10%">คะแนนรวม(ค)<br />(ค = ก x ข)</th>
									</tr>
									<tr class="success">
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
										<th>5</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$numIndex = 0;
									$total_score = 0;
									foreach($indicators as $ind) {
										$numIndex++;
								?>
								<tr>
									<td><?php echo $ind['order']; ?></td>
									<td><?php echo $ind['name']; ?></td>
									<td>1</td>
									<td>2</td>
									<td>3</td>
									<td>4</td>
									<td>5</td>
									<td style="text-align: center;">
										<?php echo $ind['exec_score']; ?>
									</td>
									<td style="text-align: center;"><?php echo $ind['weight']; ?></td>
									<td style="text-align: center;">
										<?php if($ind['exec_score'] != 0) {
												$this_score = $ind['exec_score'] * $ind['weight'];
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
									<th rowspan="2" style="text-align: center;width: 5%">Total</th>
									<th rowspan="2" style="text-align: center;width: 5%" id="totalweight"></th>
									<th rowspan="2" style="text-align: center;width: 10%" id="alltotalpoint"><?php echo number_format($total_score,2); ?></th>
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
				</div>
				</div>
						
                <div class="panel panel-primary">
                	<div class="panel-heading"><strong>แบบประเมินสมรรณะประจำตำแหน่ง</strong></div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="skillTable">
                                <thead>
                                    <tr>
                                        <th style="width: 400px">ชื่อสมรรณะ</th>
                                        <th>คะแนนคาดหวัง</th>
										<th>คะแนนประเมิน</th>
                                    </tr>
                                </thead>
								<tbody>
										<?php
											$numIndex = 0;
											foreach($array_i as $ind) {
												$numIndex++;
										?>
										<tr>
											<td >
												<?php echo $ind['name']; ?>
											</td>
											<td>
												<?php echo $ind['expectVal']; ?>
											</td>
											<td><?php echo $ind['exescore']; ?>
											</td>
										</tr>
										<?php
											}
										?>
                                </tbody>
							</table>
						</div>
					</div>
				</div>
					</div>
</form>						
	
	<div class="col-lg-12">
			<div class="panel panel-warning">
				<div class="panel-heading"><strong>ผลการดำเนินงานตามภารกิจ</strong></div>
				<div class="panel-body">
						<div class="table-responsive">
					    <table class="table table-hover" id="dataTables-example">
							<thead>
								<tr class="warning">
								<?php
									$countRow = 0;
									foreach($indicators as $ind) {
										$countRow++;
								?>
								<?php       		
									}								
								?>
									<th rowspan="2" style="width: 12%;">วันที่</th>
									<th rowspan="2">ผลการดำเนินงาน</th>
									<th colspan="<?php echo $countRow; ?>" style="text-align: center;">ผลการปฏิบัติงาน</th>									
									<th rowspan="2" style="width: 20%">(ชื่อ) เอกสาร</th>
								</tr>
								
								<tr class="warning">
								<?php
									$numIndex = 0;
									foreach($indicators as $ind) {
										$numIndex++;
								?>
									<th style="width: 7%;"><span rel="tooltip" title="<?php echo $ind['name']; ?>"><?php echo "ตัวชี้วัดที่  ". $numIndex; ?></span></th>
								<?php       		
									}								
								?>	
								</tr>
							</thead>
							
							<tbody>
							<?php
								foreach($saved_activities as $act) {
							?>
								<tr>
									<td><?php echo $act['date']; ?></td>
									<td><?php echo $act['activityName']; ?></td>									
									<?php									
										foreach($indicators as $ind) {
											if($act['score'][$ind['ID']] == 0) {
												echo "<td> - </td>";	
											} else {
												echo "<td>".$act['score'][$ind['ID']]."</td>";
											}
										}
									?>
									<td><?php echo $act['documentName']; ?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>



			<div class="col-lg-10 col-lg-offset-5">
							<button onclick="javascript:history.go(-1);" type="button" class="btn btn-primary"> ย้อนกลับ </button><br><br>							
			</div>
	
		
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
</body>
</html>