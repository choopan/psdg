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
				
            <div class="panel panel-default">
				<div class="panel-heading"><strong>แบบประเมินผลสัมฤทธิ์ของงาน</strong> ( ปีงบประมาณ  <?php echo $year; ?>  รอบที่  <?php echo $round ?> )</div>
				<div class="panel-body">
					<form class="form-inline" role="form">
					  <div class="form-group">
						<label class="forn-control" for="">ลำดับ</label>
						<input type="text" class="form-control" name="" id="main_order" value="" style="width: 50px">
					  </div>
					  <div class="form-group">
						<label class="forn-control" for="">ตัวชี้วัดผลงาน</label>
						<input type="text" class="form-control" name="" id="main_indicatorname" value="" style="width: 450px">
					  </div>
					  <div class="form-group">
						<label class="forn-control" for="">ค่าน้ำหนัก</label>
						<input type="text" class="form-control" name="" id="main_weight" value="" style="width: 100px">
					  </div>
					  <button type="button" class="btn btn-success" onclick="addIndicator();"><span class="glyphicon glyphicon-plus"></span> เพิ่มตัวชี้วัด</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading"><strong>ตัวชี้วัดรายบุคคลที่กำหนดแล้ว</strong></div>
				<div class="panel-body">
					<form class="form-inline" role="form"  action="<?php echo site_url('person_evaluation/submitIndicatorForm'); ?>" method="POST">
						<input type="hidden" name="year" value="<?php echo $year; ?>">
						<input type="hidden" name="round" value="<?php echo $round; ?>">					
					<table class="table table-hover" id="indicator_table">
						<thead>
							<tr>
								<th style="width: 200px">ลำดับ</th>
								<th>ชื่อตัวชี้วัด</th>
								<th>ค่าน้ำหนัก</th>
								<th></th>
							</tr>
						</thead>
						<tbody>	
								<?php
									
									$numIndex = 0;
									foreach($indicators as $ind) {
										$numIndex++;
								?>
									<tr id="indicator_row<?php echo $numIndex; ?>">
										<td><input type="text" class="form-control" name="orders[]" value="<?php echo $ind['order']; ?>" required></td>
										<td><input type="text" class="form-control" name="indicatorNames[]" value="<?php echo $ind['name']; ?>" required></td>
										<td><input type="text" class="form-control" name="weights[]" value="<?php echo $ind['weight']; ?>" required></td>
										<td><button type="button" class="btn btn-danger" onclick="deleteIndicator('<?php echo $numIndex; ?>')"><span class="glyphicon glyphicon-remove"></span> ลบ  </button></td>
                            		</tr>
                            		
								<?php       		
									}								
								?>
						</tbody>
					</table>
					
									<div class="col-lg-10 col-lg-offset-4">
										<button type="submit" class="btn btn-primary" name="option" value="record"><span class="glyphicon glyphicon-floppy-save"></span> บันทึก</button>
										<button type="submit" class="btn btn-success" name="option" value="prove"><span class="glyphicon glyphicon-envelope"></span> ส่งเพื่อพิจารณา</button>
									
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
var numIndex = <?php echo $numIndex; ?>;

function addIndicator() {
	var order = $('#main_order').val();
	var indicatorName = $('#main_indicatorname').val();
	var weight = $('#main_weight').val();
	
	if(order == "" || indicatorName == "" || weight == "")
	{
		alert("กรุณากรอกข้อมูลให้ครบ");
		return;
	}
	numIndex++;
	$('#indicator_table').append('<tr id="indicator_row' + numIndex +'">'
							+ '<td><input type="text" class="form-control" name="orders[]" value="' + order + '" required></td>'
							+ '<td><input type="text" class="form-control" name="indicatorNames[]" value="' + indicatorName + '" required></td>'
							+ '<td><input type="text" class="form-control" name="weights[]" value="' + weight + '"</td>'
							+ '<td><button type="button" class="btn btn-danger" onclick="deleteIndicator('
							+  numIndex + ')"><span class="glyphicon glyphicon-remove"></span> ลบ  </button></td>'
                            + '</tr>'
	);       	
}

function deleteIndicator(rnum) {
	$('#indicator_row'+rnum).remove();
}

</script>


</body>
</html>