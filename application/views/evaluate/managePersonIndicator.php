<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view('menu_person'); ?>
<div id="page-wrapper">
	
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

			<div style="text-align: right"><a data-toggle="modal" data-target="#addIndicatorForm" class="btn btn-success" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="เพิ่มตัวชี้วัด" data-backdrop="static" data-keyboard="false">
				<span class="glyphicon glyphicon-plus"></span> เพิ่มตัวชี้วัด</a><BR><BR>
			</div>
			<div class="modal fade" id="addIndicatorForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
        			<div class="modal-content">
        				<div class="modal-header">
                			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  			<h4 class="modal-title">	                 	
                 				<strong>เพิ่มตัวชี้วัดการปฏิบัติราชการระดับบุคคล</strong> ( ปีงบประมาณ  <?php echo $year; ?>  รอบที่  <?php echo $round ?> )
                 			</h4>
            			</div>            <!-- /modal-header -->
            			<div class="modal-body">

							<form class="form-inline" role="form" action="<?php echo site_url('person_evaluation/submitIndicatorForm'); ?>" method="POST">
					  		<div class="form-group">
								<label  for="">ลำดับที่ : </label>
								<input type="text" class="form-control" name="main_order" id="main_order" value="" style="width: 50px" required>
					  		</div>
					  		<div class="form-group">
								<label for=""> ชื่อตัวชี้วัดผลงาน :</label>
								<input type="text" class="form-control" name="main_indicatorname" id="main_indicatorname" value="" style="width: 450px" required>
					  		</div>
					  		<div class="form-group">
								<label  for=""> ค่าน้ำหนัก : </label>
								<input type="text" class="form-control" name="main_weight" id="main_weight" value="" style="width: 50px" required>
					  		</div>
					  		<div><BR></div>	
					  					  	
								<div class="panel panel-default">
									<div class="panel-heading">รายละเอียดเกณฑ์การประเมินผล</div>
										<div class="panel-body">
											<table class="table table-hover">
											<tr><th style="width: 10%">ระดับที่</th><th style="width: 20%">เกณฑ์การให้คะแนน</th><th style="width: 70%">รายละเอียด</th></tr>
											<tr><td>1</td>
												<td><input type="text" name="indicator1" class="form-control" style="width: 100%" required></td>
												<td><input type="text" name="detail_indicator1" class="form-control" style="width: 100%"></td>
											</tr>
											<tr><td>2</td>
												<td><input type="text" name="indicator2" class="form-control" style="width: 100%" required></td>
												<td><input type="text" name="detail_indicator2" class="form-control" style="width: 100%"></td>
											</tr>
											<tr><td>3</td>
												<td><input type="text" name="indicator3" class="form-control" style="width: 100%" required></td>
												<td><input type="text" name="detail_indicator3" class="form-control" style="width: 100%"></td>
											</tr>
											<tr><td>4</td>
												<td><input type="text" name="indicator4" class="form-control" style="width: 100%" required></td>
												<td><input type="text" name="detail_indicator4" class="form-control" style="width: 100%"></td>
											</tr>
											<tr><td>5</td>
												<td><input type="text" name="indicator5" class="form-control" style="width: 100%" required></td>
												<td><input type="text" name="detail_indicator5" class="form-control" style="width: 100%"></td>
											</tr>
											</table>									
										</div>
									</div>
							
							</div>            <!-- /modal-body -->
        			
            				<div class="modal-footer">
            					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> บันทึกตัวชี้วัด</button>			
                				<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ปิด</button>
            				</div>  
            			</form>
    					</div>
					</div>
				</div>
		
											
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					       	                 	
                 				<strong>ตัวชี้วัดการปฏิบัติราชการระดับบุคคล</strong> ( ปีงบประมาณ  <?php echo $year; ?>  รอบที่  <?php echo $round ?> )
                 			
				</div>
				<div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped row-border table-hover" id="dataTables-example">
                                <thead><tr>
									<th rowspan="2">ลำดับที่</th>
									<th rowspan="2">ชื่อตัวชี้วัด</th>
									<th colspan="5" style="text-align: center;">เกณฑ์การให้คะแนน</th>
									<th rowspan="2">น้ำหนัก</th>
									<th rowspan="2" width="125">จัดการ</th>
								</tr>
								<tr>
									<th>1</th>
									<th>2</th>
									<th>3</th>
									<th>4</th>
									<th>5</th>
								</tr>
								</thead>
                                <tbody>
                                <?php
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
											<td><?php echo $ind['weight']; $sumweight +=  $ind['weight'];?></td>
											<td>
    											<div class="tooltip-demo">
    												
    												<a data-toggle="modal" data-target="#myModal<?php echo $ind['ID']; ?>" href='<?php echo site_url("person_evaluation/viewPersonIndicatorDetail/".$ind['ID']); ?>' class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-fullscreen"></span></a>
														<div class="modal fade" id="myModal<?php echo $ind['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											    			<div class="modal-dialog modal-lg">
        													<div class="modal-content">
        													</div> 
    													</div>
													</div>
													
													<a data-toggle="modal" data-target="#myEditModal<?php echo $ind['ID']; ?>" href='<?php echo site_url("person_evaluation/editPersonIndicatorDetail/".$ind['ID']); ?>' class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไข" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-pencil"></span></a>
														<div class="modal fade" id="myEditModal<?php echo $ind['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											    			<div class="modal-dialog modal-lg">
        													<div class="modal-content">
        													</div> 
    													</div>
													</div> 
													
													<a href='<?php echo site_url("person_evaluation/deletePersonIndicatorDetail/".$ind['ID']); ?>' class="btnDelete btn btn-danger btn-xs" onClick='return confirm(" คุณต้องการลบหรือไม่ ")' title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></a>		
												
    											</div>
                                    		</td>
										</tr>
										
								<?php
									}
								?>
								<tr><td colspan=7 style="text-align: right"><strong>รวมค่าน้ำหนัก ==> </strong></td><td><strong><?php echo number_format($sumweight, 2); ?></strong></td><td></td></tr>
								</tbody>
							</table>
					</div>
				</div>
				<center><a href="<?php echo site_url('person_evaluation/submitIndicatorToProve/'.$sumweight); ?>" type="button" class="btn btn-primary" onClick='return confirm(" คุณต้องการส่งตัวชี้วัดจริงหรือไม่ ")'>
					<span class="glyphicon glyphicon-envelope"></span> ส่งเพื่อพิจารณา</a>
				</center><BR>
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