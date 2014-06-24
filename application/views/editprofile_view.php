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
                <h3 class="page-header">แก้ไขข้อมูลส่วนตัว</h3>
            </div>
        </div>
		
		<div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
				<?php if ($this->session->flashdata('showresult') == 'success') {
						echo '<div class="panel-heading"><div class="alert alert-success"> ระบบทำการแก้ไขข้อมูลเรียบร้อยแล้ว</div>'; 
						?> <button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("manageprofile/showprofile"); ?>'"> กลับไปหน้าข้อมูลส่วนตัว </button></div> <?php
					  } else if ($this->session->flashdata('showresult') == 'fail') {
					    echo '<div class="panel-heading"><div class="alert alert-danger"> ระบบไม่สามารถแก้ไขข้อมูลได้</div>';
						?> <button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("manageprofile/showprofile"); ?>'"> กลับไปหน้าข้อมูลส่วนตัว </button></div> <?php
					  } else { 
				?>
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง</strong></div>
					<?php echo form_open('manageprofile/update'); ?>
					<div class="panel-body">
					<?php if(is_array($profile_array)) {
							foreach($profile_array as $loop){
					?>
						
						<div class="row">
							<div class="col-lg-8">
								<div class="form-group">
                                            <label>ตำแหน่ง *</label>
                                            <select class="form-control" name="position" id="position">
											<?php 	
													if(is_array($position_array)) {
													foreach($position_array as $looppo){
														echo "<option value='".$looppo->pwposition."'";
														if ($loop->ponumber == $looppo->pwposition) echo " selected";
														echo ">".$looppo->poname."</option>";
											 } } ?>
											</select>
											<p class="help-block"><?php echo form_error('position'); ?></p>
                                </div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-lg-5">
								<div class="form-group">
                                        <label>Email *</label>
                                        <input type="text" class="form-control" name="email" id="email" value="<?php echo $loop->PWEMAIL; ?>">
										<p class="help-block"><?php echo form_error('email'); ?></p>
                                </div>
							</div>
							<div class="col-lg-5">
								<div class="form-group">
                                        <label>โทร. *</label>
                                        <input type="text" class="form-control" name="telephone" id="telephone" value="<?php echo $loop->PWTELOFFICE; ?>">
										<p class="help-block"><?php echo form_error('telephone'); ?></p>
                                </div>
							</div>
							
						</div>
						<?php } } ?>	

						<button type="submit" class="btn btn-primary">  แก้ไข </button>
						<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("manageprofile/showprofile"); ?>'"> ยกเลิก </button>
						</form>
						
					</div>
					<?php } ?>
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