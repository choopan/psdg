<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/plugins/dataTables/jquery.dataTables.css" >
<style type="text/css" class="init">



</style>
</head>

<body>

	<div class="row">
        <div class="col-lg-10">
            <div class="panel panel-default">
				<div class="panel-heading">
					เพื่อตัวชี้วัดและประเด็นความสำเร็จ เฉพาะกรม/กอง
                </div>
                <div class="panel-body">


			<div class="row">
            <div class="col-lg-10">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง</strong></div>
					<?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว'.$this->session->flashdata('insertid').'</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
                    <div class="panel-body">
						<?php echo form_open('manageindicator/saveDep'); ?>

						<div class="row">
							
							<div class="col-lg-8">
									<div class="form-group">
                                        <label>ชื่อตัวชี้วัด *</label>
                                        <input type="text" class="form-control" name="indicatorName" id="indicatorName" value="<?php echo set_value('indicatorName'); ?>">
											<p class="help-block"><?php echo form_error('indicatorName'); ?></p>
                                    </div>
							</div>
						</div>
		<div class="panel panel-default">
				<div class="panel-heading">
					<strong>ประเด็นความสำเร็จ</strong>
                </div>
                <div class="panel-body">
                	
						<div class="row">
							<div class="col-lg-3">
									<div class="form-group">
                                            <label>ลำดับที่ *</label>
                                    </div>
							</div>
							<div class="col-lg-7">
									<div class="form-group">
                                        <label>คำอธิบาย *</label>

                                    </div>
							</div>
						</div>
					<div class="addinput">
						<div class="row">
							<div class="col-lg-3">
									<div class="form-group">
                                            <input type="text" class="form-control" name="goalNO[]" id="goalNO" value="<?php echo set_value('goalNO[0]'); ?>">
											<p class="help-block"><?php echo form_error('goalNO[0]'); ?></p>
                                    </div>
							</div>
							<div class="col-lg-7">
									<div class="form-group">
                                        <input type="text" class="form-control" name="goalName[]" id="goalName" value="<?php echo set_value('goalName'); ?>">
										<p class="help-block"><?php echo form_error('goalName'); ?></p>

                                    </div>
							</div>
							<div class="col-lg-1">
									<div class="form-group">
										<button id="addNew" type="button" onClick="addNewForm(this.form);" class="btn btn-success">เพิ่ม</button>	
									</div>
							</div>
						</div>
					</div>
				</div></div>
						<div class="row">
							<div class="col-lg-6">
									<button type="submit" class="btn btn-primary">  เพิ่มตัวชี้วัด  </button>
									<button type="button" class="btn btn-warning" onclick="javascript: return CloseWindow();"> ยกเลิก </button>
							</div>
						</div>
								
								
						</form>

					</div>
				</div>
			</div>	
		</div>


                   
								
                </div>
                        <!-- /.panel-body -->
            </div>
                    <!-- /.panel -->
        </div>
	</div>



<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.min.js"></script>

<script type="text/javascript">
    function CloseWindow() {
        window.close();
		window.opener.location='<?php echo site_url("manageindicator/insertDep"); ?>';
        //window.opener.location.reload();
    }
</script>
<script type="text/javascript">
var rowNum = 0;
function addNewForm(frm) {
	rowNum ++;
	var row = '<div class="row" id="rowNum'+rowNum+'"><div class="col-lg-3"><div class="form-group"><input type="text" class="form-control" name="goalNO[]" id="goalNO" value="<?php echo set_value('goalNO'); ?>"><p class="help-block"><?php echo form_error('goalNO'); ?></p></div></div><div class="col-lg-7"><div class="form-group"><input type="text" class="form-control" name="goalName[]" id="goalName" value="<?php echo set_value('goalName'); ?>"><p class="help-block"><?php echo form_error('goalName'); ?></p></div></div><div class="col-lg-1"><div class="form-group"><button id="addNew" type="button" onClick="removeNewForm('+rowNum+');" class="btn btn-danger">ลบ</button></div></div></div>';
	$( ".addinput" ).append(row);
	frm.add_qty.value = '';
	frm.add_name.value = '';


}
function removeNewForm(rnum) {
jQuery('#rowNum'+rnum).remove();
}
</script>
<script>
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>