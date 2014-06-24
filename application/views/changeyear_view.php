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
                <h3 class="page-header">เปลี่ยนปีงบประมาณ</h3>
            </div>
        </div>
		
		<div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
				<?php if (isset($showresult)&&($showresult == 'success')) {
						echo '<div class="panel-heading"><div class="alert alert-success"> ระบบทำการเปลี่ยนปีงบประมาณเรียบร้อยแล้ว</div>'; 
						?> <button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("main"); ?>'"> กลับไปหน้าแรก </button></div> <?php
					  } else if (isset($showresult)&&($showresult == 'fail')) {
					    echo '<div class="panel-heading"><div class="alert alert-danger"> ระบบไม่สามารถเปลี่ยนปีงบประมาณได้</div>';
						?> <button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("main"); ?>'"> กลับไปหน้าแรก </button></div> <?php
					  } else { 
				?>
					<div class="panel-heading"><strong> </strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php echo form_open('main/updateyear'); ?>
                                    <div class="form-group">
                                            <label>เลือกปีงบประมาณ *</label>
                                            <select class="form-control" name="year" id="year">
											<?php 	if(is_array($year_array)) {
													foreach($year_array as $loop){
														echo "<option value='".$loop->id."'";
														if ($this->session->userdata('sessyear')==$loop->id) echo " selected";
														echo ">".$loop->id."</option>";
													} } ?>
											</select>
                                    </div>
									<button type="submit" class="btn btn-primary">  เปลี่ยนปีงบประมาณ  </button>
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("main"); ?>'"> ยกเลิก </button>
								</form>
								
							</div>
						</div>
					</div>
				<?php } ?>
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