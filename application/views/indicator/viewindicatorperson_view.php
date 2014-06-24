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
            <div class="col-lg-8">
                <h3 class="page-header">ข้อมูลตัวชี้วัด</h3>
            </div>
        </div>
		
		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>แสดงข้อมูลตัวชี้วัดบุคคล ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?></strong></div>
                    <div class="panel-body">
						<ul class="nav nav-tabs">
                               <li class="active">
								<a href="#round1" data-toggle="tab">รอบที่ 1</a>
                                </li>
                                <li><a href="#round2" data-toggle="tab">รอบที่ 2</a>
                                </li>
                        </ul>

                     <!-- Tab Round1 -->
                     <div class="tab-content"><div class="tab-pane fade in active" id="round1">
								
					<?php 
					if ((count($workat_array1)) > 0) {	
						if(is_array($user_array)) {
							foreach($user_array as $loop){
								$fullname1 = $loop->fullname;
					?>
						<div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">ผู้รับผิดชอบ</label>
                                            <input type="text" class="form-control" name="resid" id="resid" value="<?php echo $loop->fullname; ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-4">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">ตำแหน่ง</label>
                                            <input type="text" class="form-control" name="position" id="position" value="<?php echo $loop->poname; ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-4">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">โทร.</label>
                                            <input type="text" class="form-control" name="telephone" id="telephone" value="<?php echo $loop->PWTELOFFICE; ?>" readonly>
                                    </div>
							</div>
						</div>
						<?php } } ?>	
						
						<div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">สังกัด</label>
                                    </div>
							</div>
							<div class="col-lg-3">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">วันที่เริ่มทำงานในสังกัด</label>
                                    </div>
							</div>
							<div class="col-lg-3">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">วันที่สิ้นสุดทำงานในสังกัด</label>
                                    </div>
							</div>
							
						</div>
						
						
						<?php if(is_array($workat_array1)) {
							foreach($workat_array1 as $loop){
							?>
						<div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group has-success">
									<input type="hidden" name="uid" id="uid" value="">
                                            <input type="text" class="form-control" name="depid" id="depid" value="<?php echo $loop->thdepname; ?>" readonly>
                                    </div>
							</div>
							<?php if($loop->pstartdate!='0000-00-00') { ?>
							<div class="col-lg-3">
                                    <div class="form-group has-success">
                                            <input type="text" class="form-control" name="startdate" id="startdate" value="<?php echo date("d-m-Y", strtotime($loop->pstartdate)); ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-3">
                                    <div class="form-group has-success">
                                            <input type="text" class="form-control" name="enddate" id="enddate" value="<?php echo date("d-m-Y", strtotime($loop->penddate)); ?>" readonly>
                                    </div>
							</div>
							<?php } ?>
						</div>
						<?php } } ?>	
						
		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped row-border table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
										<th rowspan="2" width="50%">ตัวชี้วัด</th>
										<th colspan="5">เกณฑ์การให้คะแนน</th>
										<th rowspan="2" width="10%">น้ำหนัก</th>
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
								<?php if(is_array($person_indicator_array1) && count($person_indicator_array1) ) {
									$iseditor1 = 0;
									foreach($person_indicator_array1 as $loop){
										$iseditor1 += $loop->isEditor;
								?>
									<tr>
                                        <td><?php echo $loop->pnumber.". ".$loop->pname; ?></td>
                                        <td><?php echo $loop->pcriteria1; ?></td>
										<td><?php echo $loop->pcriteria2; ?></td>
										<td><?php echo $loop->pcriteria3; ?></td>
										<td><?php echo $loop->pcriteria4; ?></td>
										<td><?php echo $loop->pcriteria5; ?></td>
                                        <td><?php echo $loop->pweight; ?></td>
                                    </tr>
									<?php  } } ?>
                                </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>
			
						<div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">แก้ไขล่าสุดโดย</label>
                                            <input type="text" class="form-control" name="resid" id="resid" value="<?php if ($iseditor1 < 1) echo $fullname1; ?>" readonly>
                                    </div>
							</div>

						</div>			
                        
						
					<?php }else{ ?>
					 <div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group has-error">
                                            <label class="control-label" for="inputError">ไม่พบข้อมูล</label>
                                    </div>
							</div>
					<?php } ?>
		</div>


		
		<!-- Tab Round2 -->
                <div class="tab-pane fade" id="round2">
								
					<?php 
					if ((count($workat_array2)) > 0) {	
						
						if(is_array($user_array)) {
							foreach($user_array as $loop){
								$fullname2 = $loop->fullname;
					?>
						<div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">ผู้รับผิดชอบ</label>
                                            <input type="text" class="form-control" name="resid" id="resid" value="<?php echo $loop->fullname; ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-4">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">ตำแหน่ง</label>
                                            <input type="text" class="form-control" name="position" id="position" value="<?php echo $loop->poname; ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-4">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">โทร.</label>
                                            <input type="text" class="form-control" name="telephone" id="telephone" value="<?php echo $loop->PWTELOFFICE; ?>" readonly>
                                    </div>
							</div>
						</div>
						<?php } } ?>	
						
						<div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">สังกัด</label>
                                    </div>
							</div>
							<div class="col-lg-3">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">วันที่เริ่มทำงานในสังกัด</label>
                                    </div>
							</div>
							<div class="col-lg-3">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">วันที่สิ้นสุดทำงานในสังกัด</label>
                                    </div>
							</div>
							
						</div>
						
						
						<?php if(is_array($workat_array2)) {
							foreach($workat_array2 as $loop){
							?>
						<div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group has-success">
									<input type="hidden" name="uid" id="uid" value="">
                                            <input type="text" class="form-control" name="depid" id="depid" value="<?php echo $loop->thdepname; ?>" readonly>
                                    </div>
							</div>
							<?php if($loop->pstartdate!='0000-00-00') { ?>
							<div class="col-lg-3">
                                    <div class="form-group has-success">
                                            <input type="text" class="form-control" name="startdate" id="startdate" value="<?php echo date("d-m-Y", strtotime($loop->pstartdate)); ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-3">
                                    <div class="form-group has-success">
                                            <input type="text" class="form-control" name="enddate" id="enddate" value="<?php echo date("d-m-Y", strtotime($loop->penddate)); ?>" readonly>
                                    </div>
							</div>
							<?php } ?>
						</div>
						<?php } } ?>	
						
		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped row-border table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
										<th rowspan="2" width="50%">ตัวชี้วัด</th>
										<th colspan="5">เกณฑ์การให้คะแนน</th>
										<th rowspan="2" width="10%">น้ำหนัก</th>
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
								<?php if(is_array($person_indicator_array2) && count($person_indicator_array2) ) {
									$iseditor2 = 0;
									foreach($person_indicator_array2 as $loop){
										$iseditor2 += $loop->isEditor;
								?>
									<tr>
                                        <td><?php echo $loop->pnumber.". ".$loop->pname; ?></td>
                                        <td><?php echo $loop->pcriteria1; ?></td>
										<td><?php echo $loop->pcriteria2; ?></td>
										<td><?php echo $loop->pcriteria3; ?></td>
										<td><?php echo $loop->pcriteria4; ?></td>
										<td><?php echo $loop->pcriteria5; ?></td>
                                        <td><?php echo $loop->pweight; ?></td>
                                    </tr>
									<?php  } } ?>
                                </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>
						
                     
						<div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">แก้ไขล่าสุดโดย</label>
                                            <input type="text" class="form-control" name="resid" id="resid" value="<?php if ($iseditor2 < 1) echo $fullname2; ?>" readonly>
                                    </div>
							</div>

						</div>
					 <?php }else{ ?>
					 <div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group has-error">
                                            <label class="control-label" for="inputError">ไม่พบข้อมูล</label>
                                    </div>
							</div>
					<?php } ?>
					 
		</div></div>	
		
						<div class="row">
							<div class="col-lg-5">
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("manageindicator/showPerson"); ?>'"> กลับไปหน้าแสดงตัวชี้วัดระดับบุคคล</button>
							</div>
						</div>
								
								
						</form>

					</div>
				</div>
			</div>	
		</div>
	</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {
        var oTable = $('#dataTables-example').DataTable
        ({
            "bJQueryUI": false,
            "bProcessing": true,
            "sPaginationType": "full_numbers",
            'bServerSide'    : false,
			"bPaginate" : false,
            "bDeferRender": true,
            "fnServerData": function ( sSource, aoData, fnCallback ) {
                $.ajax( {
                    "dataType": 'json',
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success":fnCallback
                
                });
            }
        });
    });
</script>
<script>
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>