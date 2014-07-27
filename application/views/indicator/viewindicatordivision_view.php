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
            <div class="col-lg-11">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>แสดงข้อมูลตัวชี้วัด</strong></div>
                    <div class="panel-body">
					<?php if(is_array($dep_indicator_array)) {
							foreach($dep_indicator_array as $loop){
					?>
						<div class="row">
							<div class="col-lg-2">
									<div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess">ตัวชี้วัดที่</label>
                                        <input type="text" class="form-control" name="indicatorNO" id="indicatorNO" value="<?php echo $loop->number; ?>">
                                    </div>
							</div>
							<div class="col-lg-8">
									<div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess">ชื่อตัวชี้วัด</label>
                                        <input type="text" class="form-control" name="indicatorName" id="indicatorName" value="<?php echo $loop->name; ?>">
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-2">
									<div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess">ค่าเป้าหมาย</label>
                                        <input type="text" class="form-control" name="goal" id="goal" value="<?php echo $loop->goal; ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-2">
									<div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess">น้ำหนัก</label> 
                                        <input type="text" class="form-control" name="weight" id="weight" value="<?php echo $loop->weight; ?>" readonly>
                                    </div>
							</div>
						</div>
						
		<div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTables-example">
                                <thead>
                                    <tr>
										<th style="width: 30%">ประเด็นความสำเร็จ</th>
										<th style="width: 30%">แผนงาน/โครงการ</th>
                                        <th style="width: 30%">เป้าหมาย</th>
                                        <th style="width: 10%">ผู้รับผิดชอบ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php 
                                    $lastgoal=0;
                                    $lastplan=0;
                                
                                if(is_array($goal_indicator_array) && count($goal_indicator_array) ) {
									foreach($goal_indicator_array as $loop1){
								?>
									<tr>
                                        <td><?php if ($lastgoal!=$loop1->gnumber) { 
                                                    if ($loop1->gnumber!= "") echo $loop1->gnumber.". "; 
                                                    echo $loop1->gname;
                                                  }
                                                
                                            ?>
                                        </td>
                                        <td><?php if ($lastplan!=$loop1->pnumber) { 
                                                echo $loop1->pnumber.". ".$loop1->pname; 
                                                $lastplan = $loop1->pnumber;
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $loop1->tnumber.". ".$loop1->tname; ?></td>
                                        <td><?php if ($lastgoal!=$loop1->gnumber) { 
                                                echo $loop1->pwfname." ".$loop1->pwlname;
                                                $lastgoal = $loop1->gnumber;
                                            } ?>
                                        </td>
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
            <div class="col-lg-5">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table row-border" id="dataTables-example2">
                                <thead>
                                    <tr>
										<th>ระดับที่</th>
										<th>เกณฑ์การให้คะแนน</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php for ($i=1; $i<6; $i++) {
									$col = "criteria".$i;
								?>
									<tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $loop->$col; ?></td>
                                    </tr>
									<?php  } ?>
                                </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>
						<div class="row">
							<div class="col-lg-8">
									<div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">Technical Note</label>
											<textarea class="form-control" name="technote" id="technote" rows="3" style="font-weight: bold;" readonly><?php echo $loop->technicalnote; ?></textarea>
                                    </div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-4">
									<div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess">แก้ไขล่าสุดโดย </label>
                                        <input type="text" class="form-control" name="editor" id="editor" value="<?php echo $loop->pwfname." ".$loop->pwlname; ?>" readonly>
                                    </div>
							</div>
                        </div>
						
						<div class="row">
							<div class="col-lg-5">
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("manageindicator/viewDiv/".$loop->divisionID); ?>'"> กลับไปหน้าแสดงตัวชี้วัดระดับกอง </button>
							</div>
						</div>
								
						<?php } } ?>			
						</form>

					</div>
				</div>
			</div>	
		</div>
	</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script>
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>