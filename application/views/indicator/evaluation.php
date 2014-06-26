<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>font-awesome/css/font-awesome.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/sb-admin.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/plugins/dataTables/dataTables.bootstrap.css" >
</head>
<body>
<div id="wrapper">
<?php $this->load->view('menu'); ?>
	<?php $url = site_url("manageindicator/delete");
          $urleditnum = site_url("manageindicator/editNumber");
    ?>
	
<div id="page-wrapper">
	
	<div class="row">
		<div class="col-lg-12">
            <div class="panel panel-primary">
				<div class="panel-heading"><strong>แบบประเมินผลสัมฤทธิ์ของงาน</strong></div>
				<div class="panel-body">
					<div class="col-md-3 col-md-offset-3">
						<label>รอบที่</label>
						<select class="form-control" name="" id="">
							<option value=""></option>
							<option value="1">1</option>
							<option value="2">2</option>
                        </select>
					</div>
					<div class="col-md-3 col-md-offset-3">
						<label>สังกัดกอง</label>
						<select class="form-control" name="" id="">
							<option value=""></option>
							
							
							<!--
							//when this selected will return "year", "round", "kong"
							
							<?php if(is_array($__data)) {
								foreach($__data as $__tmp){ ?>
							-->
														
							<!--
							<?php } } ?>
							-->
							
							<option value="1">กองที่ 1</option>
							<option value="2">กองที่ 2</option>
                        </select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-body">
					<div class="table-responsive">
                        <table class="table table-hover" id="dataTables-example">
							<thead>
								<tr class="success">
									<th rowspan="2" style="width: 45%">ตัวชี้วัดผลงาน</th>
									<th colspan="5" style="text-align: center;">คะแนนตามระดับค่าเป้าหมาย</th>
									<th rowspan="2" style="text-align: center;width: 5%">คะแนน(ก)</th>
									<th rowspan="2" style="text-align: center;width: 5%">น้ำหนัก(ข)</th>
									<th rowspan="2" style="text-align: center;width: 10%">คะแนนรวม(ค)<br />(ค = ก x ข)</th>
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
							
								<!--
								<?php if(is_array($__data)) {
									foreach($__data as $__tmp){ ?>
								-->
															
								<!--
								<?php } } ?>
								-->
							
								<tr>
									<td>ระดับความสำเร็จ 1</td>
									<td>1</td>
									<td>2</td>
									<td>3</td>
									<td>4</td>
									<td>5</td>
									<td>
										<select class="form-control" name="" id="point1" onchange="getvalonchange('point1', 'weight1', 'totalpoint1');">
											<option value=""></option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</td>
									<td style="text-align: center;" id="weight1">0.15</td>
									<td style="text-align: center;" id="totalpoint1"></td>
								</tr>
								<tr>
									<td>ระดับความสำเร็จ 2</td>
									<td>ร้อยละ 50</td>
									<td>ร้อยละ 60</td>
									<td>ร้อยละ 70</td>
									<td>ร้อยละ 80</td>
									<td>ร้อยละ 90</td>
									<td>
										<select class="form-control" name="" id="point2" onchange="getvalonchange('point2', 'weight2', 'totalpoint2');">
											<option value=""></option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</td>
									<td style="text-align: center;" id="weight2">0.30</td>
									<td style="text-align: center;" id="totalpoint2"></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th rowspan="2" style="width: 80%"></th>
									<th rowspan="2" style="text-align: center;width: 5%">Total</th>
									<th rowspan="2" style="text-align: center;width: 5%" id="totalweight"></th>
									<th rowspan="2" style="text-align: center;width: 10%" id="alltotalpoint"></th>
								</tr>
							</thead>
						</table>
						<table class="table table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th rowspan="2" style="text-align: center;width: 80%">แปลงคะแนนรวม (ค) ข้างต้น เป็นคะแนนการประเมินผลสัมฤทธิ์ของงานที่มีฐานคะแนนเป็น 100 คะแนน (โดยนำ 20 มาคูณ)</th>
									<th rowspan="2" style="text-align: center;width: 5%"></th>
									<th colspan="2" style="text-align: center;width: 5%"> =====> </th>
									<th rowspan="2" style="text-align: center;width: 10%" id="caltotalpoint"></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="panel-group" id="accordion">
					
						<!--
						<?php if(is_array($__data)) {
							foreach($__data as $__tmp){ ?>
						-->
													
						<!--
						<?php } } ?>
						-->
					
					
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
										ระดับความสำเร็จ 1
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="row">
										<div class="table-responsive">
											<table class="table table-hover" id="dataTables-example">
												<thead>
													<tr>
														<th style="width: 200px">วันที่</th>
														<th>ภาระกิจสำคัญที่ได้ดำเนินการ</th>
														<th>ผลการปฏิบัติงาน</th>
														<th>หลักฐาน(ใส่ชื่อแฟ้ม)</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><input type="text" class="form-control" id="test" style="width: 200px"></td>
														<td><textarea class="form-control" rows="1" cols="100"></textarea></td>
														<td><textarea class="form-control" rows="1" cols="40"></textarea></td>
														<td>
															<div class="form-group"><input type="file" id="exampleInputFile"></div>
															<button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-chevron-up"></span> Add Up</button>
															<button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-chevron-down"></span> Add Down</button>
															<button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span> Delete</button>
														</td>
													</tr>
													<tr>
														<td><input type="text" class="form-control" id="test" style="width: 200px"></td>
														<td><textarea class="form-control" rows="1" cols="100"></textarea></td>
														<td><textarea class="form-control" rows="1" cols="40"></textarea></td>
														<td>
															<div class="form-group"><input type="file" id="exampleInputFile"></div>
															<button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-chevron-up"></span> Add Up</button>
															<button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-chevron-down"></span> Add Down</button>
															<button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span> Delete</button>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
										ระดับความสำเร็จ 2
									</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="row">
										<div class="table-responsive">
											<table class="table table-hover" id="dataTables-example">
												<thead>
													<tr>
														<th style="width: 200px">วันที่</th>
														<th>ภาระกิจสำคัญที่ได้ดำเนินการ</th>
														<th>ผลการปฏิบัติงาน</th>
														<th>หลักฐาน(ใส่ชื่อแฟ้ม)</th>
													</tr>
												</thead>
												<tbody>
												
													<!--
													<?php if(is_array($__data)) {
														foreach($__data as $__tmp){ ?>
													-->
													
													<!--
													<?php } } ?>
													-->
												
													<tr>
														<td><input type="text" class="form-control" name="" id="" style="width: 200px"></td>
														<td><textarea class="form-control" name="" id="" rows="1" cols="100"></textarea></td>
														<td><textarea class="form-control" name="" id="" rows="1" cols="40"></textarea></td>
														<td>
															<div class="form-group"><input type="file" name="" id=""></div>
															<button type="button" name="" id="" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-chevron-up" onclick()></span> Add Up</button>
															<button type="button" name="" id="" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-chevron-down" onclick()></span> Add Down</button>
															<button type="button" name="" id="" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus" onclick()></span> Delete</button>
														</td>
													</tr>
													
													
													<tr>
														<td><input type="text" class="form-control" id="test" style="width: 200px"></td>
														<td><textarea class="form-control" rows="1" cols="100"></textarea></td>
														<td><textarea class="form-control" rows="1" cols="40"></textarea></td>
														<td>
															<div class="form-group"><input type="file" id="exampleInputFile"></div>
															<button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-chevron-up"></span> Add Up</button>
															<button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-chevron-down"></span> Add Down</button>
															<button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span> Delete</button>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-hover" id="dataTables-example">
				<thead>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<thead>
					<tr>
						<th style="width: 80%"></th>
						<th><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> บันทึก</button></th>
						<th></th>
						<th><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-paperclip"></span> ส่งรายงาน</button></th>
					</tr>
				</thead>
			</table>
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
function getvalonchange(point, weight, totalpoint) {

	//count is from models
	var count = 1;
	
	var _alltotalpoint = document.getElementById('alltotalpoint');
	var __alltotalpoint = 0;
	var _caltotalpoint = document.getElementById('caltotalpoint');

	var _point = document.getElementById(point).value;
	var _weight = document.getElementById(weight);
	var _totalpoint = document.getElementById(totalpoint);
	_totalpoint.innerText = (_point * _weight.innerText).toFixed(2);

	//wait for count from models
	for(i = 0; i < count; i++){
		_alltotalpoint.innerText = 0.00;
		var _totalpoint1 = document.getElementById('totalpoint1');
		var _totalpoint2 = document.getElementById('totalpoint2');
		__alltotalpoint = parseInt((_totalpoint1.innerText*100) + (_totalpoint2.innerText*100)) / 100;
	}
	_alltotalpoint.innerText = __alltotalpoint;
	_caltotalpoint.innerText = 0.00;
	_caltotalpoint.innerText = (_alltotalpoint.innerText * 20).toFixed(2)
}
</script>
<script type="text/javascript">
$(document).ready(function()
{
	//count is from models
	var count = 1;
	
	var _totalweight = document.getElementById('totalweight');
	var __totalweight = 0;
	
	//wait for count from models
	for(i = 0; i < count; i++){
		var _weight1 = document.getElementById('weight1');
		var _weight2 = document.getElementById('weight2');
		__totalweight = parseInt((_weight1.innerText*100) + (_weight2.innerText*100)) / 100;
	}
	_totalweight.innerText = __totalweight;
	
	
});
</script>

</body>
</html>