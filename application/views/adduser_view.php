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
                <h3 class="page-header">จัดการผู้ใช้งาน</h3>
            </div>
        </div>
		
		<div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
					<div class="panel-heading"><button type="button" class="btn btn-outline btn-success" onClick="window.location.href='<?php echo site_url("manageuser/adduser"); ?>'">เพิ่มผู้ใช้งาน</button></div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>ชื่อ</th>
                                        <th>นามสกุล</th>
                                        <th>สิทธิ</th>
										<th>จัดการ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php if(is_array($user_array) && count($user_array) ) {
									foreach($user_array as $loop){
								?>
									<tr>
                                        <td><?php echo $loop->username; ?></td>
                                        <td><?php echo $loop->firstname; ?></td>
                                        <td><?php echo $loop->lastname; ?></td>
                                        <td class="center">
										<?php
											if ($loop->status == 1) { echo "Admin"; }
											else if ($loop->status == 2) {echo "Stock";}
											else if ($loop->status == 3) {echo "Owner";}
											else { echo "error"; }
										?>
										</td>
										<td>-</td>
                                    </tr>
									<?php } } ?>
                                </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>


<?php $this->load->view('js_footer'); ?>
</body>
</html>