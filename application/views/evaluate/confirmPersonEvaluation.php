<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view('menu'); ?>
<form action="<?php echo site_url('person_evaluation/execAgreeEvaluation')."/".$user['user_id']; ?>" method="POST">
<div id="page-wrapper">
	<h2>รายงานผลการปฏิบัติงาน รอบปีงบประมาณ <?php echo $year; ?> รอบที่ <?php echo $round ?> <button type="submit" class="btn btn-success pull-right" name="option" value="prove"><span class="glyphicon glyphicon-envelope"></span> อนุมัติผลรายงาน</button></h2>
	<div class="row">
		<div class="col-lg-12">
		<?php 	if($this->session->flashdata('success')) {
			?>
						<div class="alert alert-success alert-dismissable">
  							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php			echo $this->session->flashdata('success'); ?>
						</div>
			<?php	} ?>
			
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
										<th rowspan="2" style="text-align: center;width: 10%">คะแนน(ก)</th>
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
									$exec_total_score = 0;
									foreach($indicators as $ind) {
										$numIndex++;
								?>
								<tr id="indicator_row<?php echo $numIndex; ?>">
									<td><?php echo $ind['order']; ?></td>
									<td><?php echo $ind['name']; ?></td>
									<td>1</td>
									<td>2</td>
									<td>3</td>
									<td>4</td>
									<td>5</td>
									<td>
										
										ประเมินตนเอง : <?php echo $ind['score']; ?>
										<input type="text" class="form-control" name="score[]" id="point<?php echo $numIndex; ?>" value="<?php echo $ind['exec_score']; ?>" onchange="getvalonchange('point<?php echo $numIndex; ?>', 'weight<?php echo $numIndex; ?>', 'totalpoint<?php echo $numIndex; ?>');">
										
									</td>
									<td style="text-align: center;" name="" id="weight<?php echo $numIndex; ?>"><?php echo $ind['weight']; ?></td>
									<td style="text-align: center;" >
										<?php if($ind['score'] != 0) {
												$this_score = $ind['score'] * $ind['weight'];
												$total_score += $this_score;
												echo "ประเมินตนเอง: ". number_format($this_score, 2) . "<BR>";
											  } else {
											  	echo "ประเมินตนเอง: -<BR>";
											  }
										?>
										
											  <div id="totalpoint<?php echo $numIndex; ?>">
										<?php
											  
											  if($ind['exec_score'] != 0) {
												$exec_score = $ind['exec_score'] * $ind['weight'];
												$exec_total_score += $exec_score;
											  	echo number_format($exec_score, 2);
											  } else {
											  	echo " - ";
											  } 
											  
										?>
											</div>
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
									<th rowspan="2" style="text-align: center;width: 10%" >
										
										<?php 
											
										echo "ประเมินตนเอง : ".number_format($total_score,2)."<BR>"; 
										echo "<div id='alltotalpoint'>".number_format($exec_total_score,2)."</DIV>";										
											?>
									</th>
								</tr>
							</thead>
						</table>
						<table class="table table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th rowspan="2" style="text-align: center;width: 80%">แปลงคะแนนรวม (ค) ข้างต้น เป็นคะแนนการประเมินผลสัมฤทธิ์ของงานที่มีฐานคะแนนเป็น 100 คะแนน (โดยนำ 20 มาคูณ)</th>
									<th rowspan="2" style="text-align: center;width: 5%"></th>
									<th colspan="2" style="text-align: center;width: 5%"> =====> </th>
									<th rowspan="2" style="text-align: center;width: 10%" name="totalCalPoint"><?php 
										$last_score = $total_score * 20; echo "ประเมินตนเอง: ".number_format($last_score, 2)."<BR>"; 
										$last_exec_score = $exec_total_score * 20; echo "<div id='caltotalpoint'>".number_format($last_exec_score, 2)."</div>";	?>
										</th>
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
										<th>คะแนนประเมิน (ตนเอง)</th>
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
											<td>
												<?php 
													if(isset($ind['selfscore'])) {
														echo $ind['selfscore'];
													} else {
														echo " - ";
													} 														
												?>
											</td>
											<td>
												<input type="text" class="form-control" name="evalScore[]" value="<?php 
													if(isset($ind['exescore'])) {
														echo $ind['exescore'];
													} 														
												?>">
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
												echo "<td>ประเมินตนเอง : - ";	
											} else {
												echo "<td>ประเมินตนเอง : ".$act['score'][$ind['ID']];
											}
											echo "<input type='text' name='execScore[]' value='".$act['execscore'][$ind['ID']]."'></td>";
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
							<button type="submit" class="btn btn-primary" name="option" value="record"><span class="glyphicon glyphicon-floppy-save"></span> บันทึกผลประเมิน</button>							
				</div>
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

<script type="text/javascript">
/*
var rowCount = 3;
function addUp(tmpid, rows){
	var table = document.getElementById(tmpid);
	$("#"+tmpid).append('<tr id="row' + rowCount + '">'
						+ '<td><input type="text" class="form-control" name="" id="" value="" style="width: 200px"></td>'
						+ '<td><textarea class="form-control" name="" id="" rows="1" cols="100"></textarea></td>'
						+ '<td><textarea class="form-control" name="" id="" rows="1" cols="40"></textarea></td>'
						+ '<td>'
						+ '<div class="form-group"><input type="file" name="" id=""></div>'
						+ '<button type="button" name="" id="" class="btn btn-primary btn-xs" onclick="addUp(\'' + tmpid + '\', \'row' + rowCount + '\');"><span class="glyphicon glyphicon-chevron-up"></span> Add Up</button>'
						+ ' <button type="button" name="" id="" class="btn btn-info btn-xs" onclick="addDown(\'' + tmpid + '\', \'row' + rowCount + '\');"><span class="glyphicon glyphicon-chevron-down" onclick()></span> Add Down</button>'
						+ ' <button type="button" name="" id="" class="btn btn-danger btn-xs" onclick="deleteRow(\'' + tmpid + '\', \'row' + rowCount + '\');"><span class="glyphicon glyphicon-minus" onclick()></span> Delete</button>'
						+ '</td>'
						+ '</tr>'
						);
						
	var getStartRows = document.getElementById(rows);
	var getStopRows = document.getElementById("row"+rowCount);

	var firstRow = table.rows[getStartRows.rowIndex];
    var secondRow = table.rows[getStopRows.rowIndex];
    firstRow.parentNode.insertBefore (secondRow, firstRow);
	
	rowCount += 1;
}

function addDown(tmpid, rows){
	var table = document.getElementById(tmpid);
	$("#"+tmpid).append('<tr id="row' + rowCount + '">'
						+ '<td><input type="text" class="form-control" name="" id="" value="" style="width: 200px"></td>'
						+ '<td><textarea class="form-control" name="" id="" rows="1" cols="100"></textarea></td>'
						+ '<td><textarea class="form-control" name="" id="" rows="1" cols="40"></textarea></td>'
						+ '<td>'
						+ '<div class="form-group"><input type="file" name="" id=""></div>'
						+ '<button type="button" name="" id="" class="btn btn-primary btn-xs" onclick="addUp(\'' + tmpid + '\', \'row' + rowCount + '\');"><span class="glyphicon glyphicon-chevron-up"></span> Add Up</button>'
						+ ' <button type="button" name="" id="" class="btn btn-info btn-xs" onclick="addDown(\'' + tmpid + '\', \'row' + rowCount + '\');"><span class="glyphicon glyphicon-chevron-down" onclick()></span> Add Down</button>'
						+ ' <button type="button" name="" id="" class="btn btn-danger btn-xs" onclick="deleteRow(\'' + tmpid + '\', \'row' + rowCount + '\');"><span class="glyphicon glyphicon-minus" onclick()></span> Delete</button>'
						+ '</td>'
						+ '</tr>'
						);
						
	var getStartRows = document.getElementById(rows);
	var getStopRows = document.getElementById("row"+rowCount);

	var firstRow = table.rows[getStartRows.rowIndex + 1];
    var secondRow = table.rows[getStopRows.rowIndex];
    firstRow.parentNode.insertBefore (secondRow, firstRow);
	
	rowCount += 1;
}

function deleteRow(tmpid, rows){
	var table = document.getElementById(tmpid);				
	var getRows = document.getElementById(rows);
	table.deleteRow(getRows.rowIndex);
}

*/
function getvalonchange(point, weight, totalpoint) {
	
	
	//count is from models
	var count = 1;
	
	var _alltotalpoint = document.getElementById('alltotalpoint');
	var __alltotalpoint = 0;
	var _caltotalpoint = document.getElementById('caltotalpoint');

	var _point = document.getElementById(point).value;
	var _weight = document.getElementById(weight);
	var _totalpoint = document.getElementById(totalpoint);
	if(_point < 0 | _point > 5){
		alert("กรุณากรอกเฉพาะตัวเลข 1 - 5 เท่านั้น");
		//Choopan: TODO not accept
		_totalpoint.innerText = "0.00";
		_caltotalpoint.innerText = "0.00";
		return false;
	}
	_totalpoint.innerText = (_point * _weight.innerText).toFixed(2);

	var rowCount = document.getElementById('dataTables-example').rows.length - 2;
	
	for(i = 1; i <= rowCount; i++){
		var _totalpoint = document.getElementById('totalpoint'+i);
		var __totalpoint = _totalpoint.innerText;
		if(__totalpoint == '-') {
			__totalpoint = 0;
		}
		//alert(__totalpoint);
		__alltotalpoint += parseInt((__totalpoint*100));
	}
	//alert(__alltotalpoint);
	_alltotalpoint.innerText = (__alltotalpoint / 100).toFixed(2);
	_caltotalpoint.innerText = 0.00;
	_caltotalpoint.innerText = (_alltotalpoint.innerText * 20).toFixed(2);
	_caltotalpoint.value = (_alltotalpoint.innerText * 20).toFixed(2);
}
</script>
<script type="text/javascript">
$(document).ready(function()
{
	//count is from models
	var count = 1;
	
	var _totalweight = document.getElementById('totalweight');
	var __totalweight = 0;
	
	var rowCount = document.getElementById('dataTables-example').rows.length - 2;
	
	for(i = 1; i <= rowCount; i++){
		var _weight1 = document.getElementById('weight'+i);
		__totalweight += parseInt((_weight1.innerText*100) );
	}
	_totalweight.innerText = __totalweight / 100;
	
	
});
</script>

</body>
</html>