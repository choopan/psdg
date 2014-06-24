<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>


		 <h4>ข้อมูลตัวชี้วัด</h4>
		<div class="row">
            <div class="col-lg-11">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>แสดงข้อมูลตัวชี้วัด</strong></div>
                    <div class="panel-body">
					<?php if(is_array($person_indicator_array)) {
							foreach($person_indicator_array as $loop){
					?>
						<div class="row">
							<div class="col-lg-2">
									<div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess">ตัวชี้วัดที่</label>
                                        <input type="text" class="form-control" name="indicatorNO" id="indicatorNO" value="<?php echo $loop->pnumber; ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-8">
									<div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess">ชื่อตัวชี้วัด</label> 
                                        <input type="text" class="form-control" name="indicatorName" id="indicatorName" value="<?php echo $loop->pname; ?>" readonly>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-2">
									<div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess">ค่าเป้าหมาย</label>
                                        <input type="text" class="form-control" name="goal" id="goal" value="<?php echo $loop->pgoal; ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-2">
									<div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess">น้ำหนัก</label> 
                                        <input type="text" class="form-control" name="weight" id="weight" value="<?php echo $loop->pweight; ?>" readonly>
                                    </div>
							</div>
						</div>
		<div class="row">
            <div class="col-lg-10">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped row-border table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
										<th width="20%">ประเด็นความสำเร็จที่</th>
										<th>คำอธิบาย</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php if(is_array($goal_indicator_array) && count($goal_indicator_array) ) {
									foreach($goal_indicator_array as $loop2){
								?>
									<tr>
                                        <td><?php if ($loop2->number!= "") echo $loop2->number; ?></td>
                                        <td><?php echo $loop2->name; ?></td>
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
									$col = "pcriteria".$i;
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
											<textarea class="form-control" name="technote" id="technote" rows="3" style="font-weight: bold;" readonly><?php echo $loop->ptechnicalnote; ?></textarea>
                                    </div>
							</div>
						</div>
                        
						<div class="row">
							
							<div class="col-lg-4">
									<div class="form-group">
										<div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess">สอดคล้องกับตัวชี้วัดของ</label> 
                                        <input type="text" class="form-control" name="divname" id="divname" value="<?php echo $loop->thdepname; ?>" readonly>
                                    </div>
                                    </div>
							</div>
							
						</div>
						

		<div class="row">
            <div class="col-lg-10">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table row-border" id="dataTables-example3">
                                <thead>
                                    <tr>
                                        <th width="100">ตัวชี้วัด</th>
										<th>ชื่อ</th>
                                    </tr>
                                </thead>
								<tbody>

									<tr>
									
									<td><?php echo $loop->indivnumber; ?></td>
									<td><?php echo $loop->indivname; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>

								
						<?php } } ?>			
						</form>

					</div>
				</div>
			</div>	
		</div>


<?php $this->load->view('js_footer'); ?>

</body>
</html>