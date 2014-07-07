<?php 
	$data['title']='ข้อมูลคำรับรองการปฏิบัติราชการ  ระดับกรม';
	$this->load->view('header_view',$data);
?>
	<body>
		<div class="row">
			<div class="col-md-3">
				<label>ชื่อกรม</label>
				<label>กรม</label>
			</div>
		</div>
		<br/>
		<table class="table table-striped row-border table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th>ผู้รับคำรับรอง</th>
					<th>ตำแหน่ง</th>
					<th>หน่วยงาน</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>a</td>
					<td>b</td>
					<td>c</td>
				</tr>
			</tbody>
		</table> 
		<br/>
		<table class="table table-striped row-border table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th>ผู้ทำคำรับรอง</th>
					<th>ตำแหน่ง</th>
					<th>หน่วยงาน</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>a</td>
					<td>b</td>
					<td>c</td>
				</tr>
			</tbody>
		</table> 
		

	<?php $this->load->view('js_footer'); ?>

	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			
		});
		
		
	</script>
	</body>
	</html>