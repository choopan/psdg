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
				<div class="panel-heading"><strong>ตัวชี้วัดรายบุคคลที่กำหนด ประจำปีงบประมาณ <?php echo $year; ?> รอบที่ <?php echo $round ?></strong></div>
				<div class="panel-body">
					<form class="form-inline" role="form" >					
					<table class="table table-hover" id="indicator_table">
						<thead>
							<tr>
								<th style="width: 200px">ลำดับ</th>
								<th>ชื่อตัวชี้วัด</th>
								<th>ค่าน้ำหนัก</th>
								
							</tr>
						</thead>
						<tbody>	
								<?php
									foreach($indicators as $ind) {
								?>
									<tr>
										<td><?php echo $ind['order']; ?></td>
										<td><?php echo $ind['name']; ?> </td>
										<td><?php echo $ind['weight']; ?></td>
								
                            		</tr>
                            		
								<?php       		
									}								
								?>
						</tbody>
					</table>
					</form>					
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<strong>สถานะ :</strong>&nbsp;&nbsp;<span class="label label-primary">ผ่านการอนุมัติแล้ว</span>
		</div>
		<div class="col-lg-6">
			<a href="<?php echo site_url('person_evaluation/depManagePersonIndicator'); ?>" type="button" class="btn btn-primary">ย้อนกลับ</a>&nbsp;&nbsp;
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