<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/plugins/dataTables/jquery.dataTables.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.fancybox.css" >
<style type="text/css" class="init">


td.highlight {
    background-color: red !important;
}


	</style>
</head>

<body>
	<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
				<div class="panel-heading">
					<strong>กำหนดตัวชี้วัดและประเด็นความสำเร็จ <u>ระดับกรม</u> (กรุณาใส่ข้อมูลให้ครบทุกช่อง)</strong>
                </div>
                <div class="panel-body">
                            <!-- Nav tabs -->


                            <!-- Tab panes -->
					<?php if ($showresult == 'success') { echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; }
						  else if ($showresult == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
                          else {
					
					?>

						<?php echo form_open('manageindicator/saveDep'); ?>
                        
                        <?php foreach($min_array as $loop) { ?>
						<input type="hidden" name="mingoalid" id="mingoalid" value="<?php echo $min_goal_id; ?>">
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
                                        <label>ตัวชี้วัดที่ *</label>
                                        <input type="text" class="form-control" name="indicatorNO" id="indicatorNO" value="<?php echo set_value('indicatorNO'); ?>">
											<p class="help-block"><?php echo form_error('indicatorNO'); ?></p>
                                    </div>
							</div>
							<div class="col-md-9">
									<div class="form-group">
                                        <label>ชื่อตัวชี้วัด *</label>
                                        <input type="text" class="form-control" name="indicatorName" id="indicatorName" value="<?php echo $loop['name']; ?>">
											<p class="help-block"><?php echo form_error('indicatorName'); ?></p>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
                                        <label>น้ำหนัก *</label>
                                        <input type="text" class="form-control" name="weightmin" id="weightmin" value="<?php echo set_value('weightmin'); ?>">
											<p class="help-block"><?php echo form_error('weightmin'); ?></p>
                                    </div>
							</div>
						</div>
		<div class="panel panel-primary">
				<div class="panel-heading">
					<strong>ประเด็นความสำเร็จ</strong>
                </div>
                <div class="panel-body">
                	
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
                                            <label>ลำดับที่ *</label>
                                    </div>
							</div>
							<div class="col-md-7">
									<div class="form-group">
                                        <label>คำอธิบาย *</label>

                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group">
                                        <label>ผู้รับผิดชอบ *</label>

                                    </div>
							</div>
						</div>
                    <div class="addinput">
                        <input type="hidden" name="userid[]" id="userid0" value="">
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
                                            <input type="text" class="form-control" name="goalNO[]" id="goalNO0" value="">
											<p class="help-block"><?php echo form_error('goalNO[0]'); ?></p>
                                    </div>
							</div>
							<div class="col-md-7">
									<div class="form-group">
                                        <input type="text" class="form-control" name="goalName[]" id="goalName0" value="">
										<p class="help-block"><?php echo form_error('goalName'); ?></p>

                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group">
                                        <input type="text" class="form-control" name="responseName[]" id="responseName0" value="">
										<p class="help-block"><?php echo form_error('responseName'); ?></p>

                                    </div>
							</div>
							<div class="col-md-1">
									<div class="form-group">
										<button id="addNew" type="button" onClick="addNewForm(this.form);" class="btn btn-success">เพิ่ม</button>	
									</div>
							</div>
						</div>
					</div>
				</div></div>
				<div class="row"><div class="col-md-5">
					<div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="col-md-2" style="text-align: center;">ระดับที่</th>
                                            <th class="col-md-4">เกณฑ์การให้คะแนน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                            <td style="text-align: center;">1</td>
                                            <td><input type="text" class="form-control" name="criterion1" id="criterion1" value="">
										</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center;">2</td>
                                            <td><input type="text" class="form-control" name="criterion2" id="criterion2" value="">
										</td></tr>
                                        <tr>
                                            <td style="text-align: center;">3</td>
                                            <td><input type="text" class="form-control" name="criterion3" id="criterion3" value="">
										</td></tr>
                                        <tr>
                                            <td style="text-align: center;">4</td>
                                            <td><input type="text" class="form-control" name="criterion4" id="criterion4" value="">
										</td></tr>
                                        <tr>
                                            <td style="text-align: center;">5</td>
                                            <td><input type="text" class="form-control" name="criterion5" id="criterion5" value="">
										</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                </div></div>
                <br>
                <div class="row">
                    <div class="col-md-3">
									<div class="form-group">
                                        <label>ค่าเป้าหมาย *</label>
                                        <div class="form-group"><label class="radio-inline"><input type="radio" name="goalmin" id="goalmin" <?php echo set_radio('goalmin', '1'); ?> value="1">1</label>
											<label class="radio-inline"><input type="radio" name="goalmin" id="goalmin" <?php echo set_radio('goalmin', '2'); ?> value="2">2</label>
											<label class="radio-inline"><input type="radio" name="goalmin" id="goalmin" <?php echo set_radio('goalmin', '3'); ?> value="3">3</label>
											<label class="radio-inline"><input type="radio" name="goalmin" id="goalmin" <?php echo set_radio('goalmin', '4'); ?> value="4">4</label>
											<label class="radio-inline"><input type="radio" name="goalmin" id="goalmin" <?php echo set_radio('goalmin', '5'); ?> value="5">5</label>
											<p class="help-block"><?php echo form_error('goalmin'); ?></p>
										</div>
                                    </div>
							</div>
                </div>            
                <div class="row">
                	<div class="col-md-10">
                		<div class="form-group">
                            <label>Technical Note *</label>
							<textarea class="form-control" name="technote" id="technote" rows="3"></textarea>
							<p class="help-block"><?php echo form_error('technote'); ?></p>
                        </div>
                	</div>
                </div>
                        <?php } ?>
						<div class="row">
							<div class="col-md-6">
									<button type="submit" class="btn btn-primary">  เพิ่มตัวชี้วัดระดับกรม  </button>
							</div>
						</div>
								
								
						</form>
                    <?php } ?>
					</div>
				</div>
			</div>	
		</div>


<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>



<script type="text/javascript">
var rowNum = 0;
var rowNumRes = 0;
function addNewForm(frm) {
	rowNum ++;
	var row = '<div class="row" id="rowNum'+rowNum+'"><input type="hidden" name="userid[]" id="userid'+rowNum+'" value=""><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="goalNO[]" id="goalNO" value=""></div></div><div class="col-md-7"><div class="form-group"><input type="text" class="form-control" name="goalName[]" id="goalName" value=""></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="responseName[]" id="responseName'+rowNum+'" value=""></div></div><div class="col-md-1"><div class="form-group"><button id="addNew" type="button" onClick="removeNewForm('+rowNum+');" class="btn btn-danger">ลบ</button></div></div></div>';
	$( ".addinput" ).append(row);
    auto_tag("#responseName",rowNum);
	frm.add_qty.value = '';
	frm.add_name.value = '';


}
function removeNewForm(rnum) {
jQuery('#rowNum'+rnum).remove();
}
function addNewFormResponse(idd) {

	while (idd<6) {
		var post1 = document.getElementById('addinputResponse'+idd);
		if (post1.style.display == 'block')  idd++;
		else { 
			post1.style.display = 'block';
			break;
		}
		
	}
		



}
function removeNewFormResponse(idd) {
	var post1 = document.getElementById('addinputResponse'+idd);
	if (post1.style.display == 'block') {
		post1.style.display = 'none';
		$("#resid"+idd).val("");
		$("#position"+idd).val("");
		$("#telephone"+idd).val("");
		$("#uid"+idd).val("");
	}
}

function auto_tag(tag,num)
{
    $(tag+num).autocomplete({
		source: function(request, response){
			$.ajax({
                url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                dataType: "json",
                data: {term: request.term},
				error: function(data){
					alert('error');
				},
                success: function(data) {
	
				    response($.map(data,function(pwemployee){
                        return {
							id: pwemployee.userid,
							value: pwemployee.pwname
                        };
                    }));
                }
            });
		},
		minLength: 2,
		autofocus: true,
		mustMatch: true,
		select: function(event,ui){
				$("#userid"+num).val(ui.item.id);
				$("#responseName"+num).val(ui.item.value);

        }
    });
			
}

</script>
<script type='text/javascript'> 
$(document).ready(function() {
    $('#fancyboxall').fancybox({ 
    'width': '85%',
    'height': '100%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
    

    auto_tag("#responseName",0);

});
 </script>
<script>
$(".alert-message").alert();
//window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>