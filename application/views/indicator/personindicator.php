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
            <div class="panel panel-primary">
				<div class="panel-heading"><strong>แบบประเมินผลสัมฤทธิ์ของงาน</strong></div>
				<div class="panel-body">
					<form class="form-inline" role="form">
					  <div class="form-group">
						<label class="forn-control" for="">ลำดับ</label>
						<input type="text" class="form-control" name="" id="order" value="" style="width: 50px">
					  </div>
					  <div class="form-group">
						<label class="forn-control" for="">ตัวชี้วัดผลงาน</label>
						<input type="text" class="form-control" name="" id="indicatorname" value="" style="width: 450px">
					  </div>
					  <div class="form-group">
						<label class="forn-control" for="">ค่าน้ำหนัก</label>
						<input type="text" class="form-control" name="" id="weight" value="" style="width: 100px">
					  </div>
					  <button type="button" class="btn btn-primary" onclick="addIndicator('order','indicatorname','weight');"><span class="glyphicon glyphicon-floppy-saved"></span> เพิ่มตัวชี้วัด</button>
					</form>
						
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-body">
					<table class="table table-hover" id="table1">
						<thead>
							<tr>
								<th style="width: 200px">ลำดับ</th>
								<th>ชื่อตัวชี้วัด</th>
								<th>ค่าน้ำหนัก</th>
								<th></th>
							</tr>
						</thead>
						<tbody>	
						
						</tbody>
					</table>
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
function deleteRow(tmpid, rows){
	var table = document.getElementById(tmpid);				
	var getRows = document.getElementById(rows);
	table.deleteRow(getRows.rowIndex);
}

function submit(order,indicatorname,weight){
	var _order = document.getElementById(order);
	var _indicatorname = document.getElementById(indicatorname);
	var _weight = document.getElementById(weight);
	var row = document.getElementById("row"+_order.value);
	row.innerHTML = "";
	if(_order.value == "" || _indicatorname.value == "" || _weight.value == "")
	{
		alert("กรุณากรอกข้อมูลให้ครบ");
		return;
	}
	$.ajax({
		url:"edit",
		"type": "POST",
		cache: false,
		data:"number="+_order.value+"&name="+_indicatorname.value+"&weight="+_weight.value,
		success:function(res){
				$("#row"+_order.value).append('<td><input type="text" class="form-control" name="" id="'+_order.value+'" value="'+_order.value+'" style="width: 50px" disabled></td>'
						+ '<td><input type="text" class="form-control" name="" id="indicator'+_order.value+'" value="'+_indicatorname.value+'" style="width: 750px" disabled></td>'
						+ '<td><input type="text" class="form-control" name="" id="weight'+_order.value+'" value="'+_weight.value+'" style="width: 100px" disabled></td>'
						+ '<td>'
						+ ' <button type="button" class="btn btn-info" onclick="edit(\'' + order + '\', \'indicator' + _order.value + '\', \'weight' + _order.value + '\');"><span class="glyphicon glyphicon-chevron-up"></span> Edit</button>'
						+ ' <button type="button" class="btn btn-danger" ><span class="glyphicon glyphicon-chevron-up"></span> Delete</button>'
						+ '</td>'
					);
				alert("Save !!");
		} ,
		error:function(err){
			alert("Error !!");
		}
	});
}

function edit(order,indicatorname,weight){
	var _order = document.getElementById(order);
	var _indicatorname = document.getElementById(indicatorname);
	var _weight = document.getElementById(weight);
	var row = document.getElementById("row"+_order.value);
	row.innerHTML = "";
	$("#row"+_order.value).append('<td><input type="text" class="form-control" name="" id="'+_order.value+'" value="'+_order.value+'" style="width: 50px" ></td>'
													+ '<td><input type="text" class="form-control" name="" id="indicator'+_order.value+'" value="'+_indicatorname.value+'" style="width: 750px" ></td>'
													+ '<td><input type="text" class="form-control" name="" id="weight'+_order.value+'" value="'+_weight.value+'" style="width: 100px" ></td>'
													+ '<td>'
													+ ' <button type="button" class="btn btn-success" onclick="submit(\'' + order + '\', \'indicator' + _order.value + '\', \'weight' + _order.value + '\');"><span class="glyphicon glyphicon-chevron-up"></span> Submit</button>'
													+ ' <button type="button" class="btn btn-danger" ><span class="glyphicon glyphicon-chevron-up"></span> Delete</button>'
													+ '</td>'
													);
}

function addIndicator(order,indicatorname,weight) {
	var _order = document.getElementById(order);
	var _indicatorname = document.getElementById(indicatorname);
	var _weight = document.getElementById(weight);
	if(_order.value == "" || _indicatorname.value == "" || _weight.value == "")
	{
		alert("กรุณากรอกข้อมูลให้ครบ");
		return;
	}
	$.ajax({
		url:"add",
		"type": "POST",
		cache: false,
		data:"number="+_order.value+"&name="+_indicatorname.value+"&weight="+_weight.value,
		success:function(res){
			if(res == "ok"){
				$("#table1").append('<tr id="row' + _order.value + '">'
						+ '<td><input type="text" class="form-control" name="" id="'+_order.value+'" value="'+_order.value+'" style="width: 50px" disabled></td>'
						+ '<td><input type="text" class="form-control" name="" id="indicator'+_order.value+'" value="'+_indicatorname.value+'" style="width: 750px" disabled></td>'
						+ '<td><input type="text" class="form-control" name="" id="weight'+_order.value+'" value="'+_weight.value+'" style="width: 100px" disabled></td>'
						+ '<td>'
						+ ' <button type="button" class="btn btn-info" onclick="edit(\'' + order + '\', \'indicator' + _order.value + '\', \'weight' + _order.value + '\');"><span class="glyphicon glyphicon-chevron-up"></span> Edit</button>'
						+ ' <button type="button" class="btn btn-danger" ><span class="glyphicon glyphicon-chevron-up"></span> Delete</button>'
						+ '</td>'
						+ '</tr>'
						);
				alert("Save !!");
			}
		} ,
		error:function(err){
			alert("Error !!");
		}
	});
	

}
</script>


</body>
</html>