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
                <h3 class="page-header">ข้อมูลส่วนตัว</h3>
            </div>
        </div>
		
		<div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
					<div class="panel-heading"><button type="button" class="btn btn-primary" onClick="window.location.href='<?php echo site_url("manageprofile/editprofile"); ?>'">แก้ไขข้อมูลส่วนตัว</button></div>
                    <div class="panel-body">
					<?php if(is_array($profile_array)) {
							foreach($profile_array as $loop){
					?>
						<div class="row">
                            <div class="col-lg-5">
                                    <div class="form-group has-success">
									<input type="hidden" name="uid" id="uid" value="">
                                            <label class="control-label" for="inputSuccess">ชื่อ</label>
                                            <input type="text" class="form-control" name="resid" id="resid" value="<?php echo $loop->PWFNAME; ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-5">
                                    <div class="form-group has-success">
									<input type="hidden" name="uid" id="uid" value="">
                                            <label class="control-label" for="inputSuccess">นามสกุล</label>
                                            <input type="text" class="form-control" name="resid" id="resid" value="<?php echo $loop->PWLNAME; ?>" readonly>
                                    </div>
							</div>
						</div>
						<div class="row">
                            <div class="col-lg-5">
                                    <div class="form-group has-success">
									<input type="hidden" name="uid" id="uid" value="">
                                            <label class="control-label" for="inputSuccess">First Name</label>
                                            <input type="text" class="form-control" name="resid" id="resid" value="<?php echo $loop->PWEFNAME; ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-5">
                                    <div class="form-group has-success">
									<input type="hidden" name="uid" id="uid" value="">
                                            <label class="control-label" for="inputSuccess">Last Name</label>
                                            <input type="text" class="form-control" name="resid" id="resid" value="<?php echo $loop->PWELNAME; ?>" readonly>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-8">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">ตำแหน่ง</label>
                                            <input type="text" class="form-control" name="position" id="position" value="<?php echo $loop->poname." ".$loop->poename; ?>" readonly>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-5">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">Email</label>
                                            <input type="text" class="form-control" name="position" id="position" value="<?php echo $loop->PWEMAIL; ?>" readonly>
                                    </div>
							</div>
							<div class="col-lg-5">
                                    <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">โทร.</label>
                                            <input type="text" class="form-control" name="telephone" id="telephone" value="<?php echo $loop->PWTELOFFICE; ?>" readonly>
                                    </div>
							</div>
						</div>
						<?php } } ?>	



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