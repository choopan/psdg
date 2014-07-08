<?php 
	$data['title']='ข้อมูลคำรับรองการปฏิบัติราชการ  ระดับกรม';
	$this->load->view('header_view',$data);
?>
	<body>
		<div class="row">
			<div class="col-md-3">
				<label>ชื่อกรม</label>
				<label><?php echo $data_warranty[0]['depname'] ?></label>
			</div>
		</div>
		<br/>
		<table class="table table-striped row-border table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th>ผู้รับคำรับรอง</th>
					<th>ตำแหน่ง</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($data_warranty as $key=>$val){ ?>
			<?php if($val['status']==1){ ?>
				<tr>
					<td><?php echo $val['pwfname'].' '.$val['pwlname']; ?></td>
					<td><?php echo $val['poname']; ?></td>
				</tr>
			<?php } ?>
			<?php } ?>
			</tbody>
		</table> 
		<br/>
		<table class="table table-striped row-border table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th>ผู้ทำคำรับรอง</th>
					<th>ตำแหน่ง</th>
				</tr>
			</thead>
			<?php foreach($data_warranty as $key=>$val){ ?>
			<?php if($val['status']==2){ ?>
				<tr>
					<td><?php echo $val['pwfname'].' '.$val['pwlname']; ?></td>
					<td><?php echo $val['poname']; ?></td>
				</tr>
			<?php } ?>
			<?php } ?>
		</table> 
		

	<?php $this->load->view('js_footer'); ?>

	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			
		});
		
		
	</script>
	</body>
	</html>