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
        <div class="col-lg-11">
            <div class="panel panel-default">
				<div class="panel-heading">
					<strong>กำหนดตัวชี้วัดและประเด็นความสำเร็จ <u>ระดับกรม</u></strong>
                </div>
                <div class="panel-body">
                            <!-- Nav tabs -->


                            <!-- Tab panes -->
       		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง</strong></div>
					<?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว'.$this->session->flashdata('insertid').'</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>

                    <div class="panel-body">
						<?php echo form_open('manageindicator/saveDep'); ?>
						
						<div class="row">
							<div class="col-lg-3">
									<div class="form-group">
                                        <label>ตัวชี้วัดที่ *</label>
                                        <input type="text" class="form-control" name="indicatorNO" id="indicatorNO" value="<?php echo set_value('indicatorNO'); ?>">
											<p class="help-block"><?php echo form_error('indicatorNO'); ?></p>
                                    </div>
							</div>
							<div class="col-lg-9">
									<div class="form-group">
                                        <label>ชื่อตัวชี้วัด *</label>
                                        <input type="text" class="form-control" name="indicatorName" id="indicatorName" value="<?php echo set_value('indicatorName'); ?>">
											<p class="help-block"><?php echo form_error('indicatorName'); ?></p>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">
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
							<div class="col-lg-3">
									<div class="form-group">
                                        <label>น้ำหนัก *</label>
                                        <input type="text" class="form-control" name="weightmin" id="weightmin" value="<?php echo set_value('weightmin'); ?>">
											<p class="help-block"><?php echo form_error('weightmin'); ?></p>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">
                                            <label>ผู้รับผิดชอบ *</label>
							</div>
							<div class="col-lg-3">
                                            <label>ตำแหน่ง *</label>
							</div>
							<div class="col-lg-3">
                                            <label>หน่วยงาน *</label>
							</div>
							<div class="col-lg-2">
                                            <label>โทร. *</label>
							</div>
						</div>


						<div id="addinputResponse0">
                        <div class="row">
                            <div class="col-lg-3">
                                    <div class="form-group">
									<input type="hidden" name="uid[]" id="uid0" value="">
                                            <input type="text" class="form-control" name="resid[]" id="resid0" value="<?php echo set_value('resid0'); ?>">
											<p class="help-block"><?php echo form_error('resid0'); ?></p>
                                    </div>
							</div>
							<div class="col-lg-3">
                                    <div class="form-group">
										<select class="form-control" name="position[]" id="position0">
											<option value=""> </option>
											<?php 	
													if(is_array($position_array)) {
													foreach($position_array as $looppo){
														echo "<option value='".$looppo->pwposition."'";
														//if ($loop->ponumber == $looppo->pwposition) echo " selected";
														echo ">".$looppo->pwname."</option>";
											 } } ?>
										</select>
                                    </div>
							</div>
							<div class="col-lg-3">
                                    <div class="form-group">
										<select class="form-control" name="depid[]" id="depid0">
											<option value=""> </option>
											<?php 	
													if(is_array($dep_array)) {
													foreach($dep_array as $loopdep){
														echo "<option value='".$loopdep->depid."'";
														//if ($loop->ponumber == $looppo->pwposition) echo " selected";
														echo ">".$loopdep->thdepname."</option>";
											 } } ?>
										</select>
                                    </div>
							</div>
							<div class="col-lg-2">
                                    <div class="form-group">
                                            <input type="text" class="form-control" name="telephone[]" id="telephone0" value="<?php echo set_value('telephone0'); ?>">
											<p class="help-block"><?php echo form_error('telephone0'); ?></p>
                                    </div>
							</div>
							<div class="col-lg-1">
									<div class="form-group">
										<button id="addNewResponse" type="button" onClick="addNewFormResponse(1);" class="btn btn-success">เพิ่ม</button>	
									</div>
							</div>
						</div></div>
						<?php for ($i=1; $i<5; $i++) { ?>
						<div id="addinputResponse<?php echo $i; ?>">
                        <div class="row">
                            <div class="col-lg-3">
                                    <div class="form-group">
									<input type="hidden" name="uid[]" id="uid<?php echo $i; ?>" value="">
                                            <input type="text" class="form-control" name="resid[]" id="resid<?php echo $i; ?>" value="">
                                    </div>
							</div>
							<div class="col-lg-3">
                                    <div class="form-group">
										<select class="form-control" name="position[]" id="position<?php echo $i; ?>">
											
										</select>
                                    </div>
							</div>
							<div class="col-lg-3">
                                    <div class="form-group">
										<select class="form-control" name="depid[]" id="depid<?php echo $i; ?>">
											
										</select>
                                    </div>
							</div>
							<div class="col-lg-2">
                                    <div class="form-group">
                                            <input type="text" class="form-control" name="telephone[]" id="telephone<?php echo $i; ?>" value="">
                                    </div>
							</div>
							<div class="col-lg-1">
									<div class="form-group">
										<button id="addNewResponse" type="button" onClick="removeNewFormResponse(<?php echo $i; ?>);" class="btn btn-danger">ลบ</button>	
									</div>
							</div>
						</div></div>
						<?php } ?>
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
				<div class="row"><div class="col-lg-5">
					<div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="col-lg-3">ระดับที่</th>
                                            <th class="col-lg-4">เกณฑ์การให้คะแนน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i=1; $i<6; $i++) { ?>
                                    	<tr>
                                            <td><?php echo $i; ?></td>
                                            <td><input type="text" class="form-control" name="criterion<?php echo $i; ?>" id="criterion<?php echo $i; ?>" value="<?php echo set_value('criterion<?php echo $i; ?>'); ?>">
										<p class="help-block"><?php echo form_error('criterion<?php echo $i; ?>'); ?></p></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                </div></div>
                <br>
                <div class="row">
                	<div class="col-lg-10">
                		<div class="form-group">
                            <label>Technical Note *</label>
							<textarea class="form-control" name="technote" id="technote" rows="3"><?php echo set_value('technote'); ?></textarea>
							<p class="help-block"><?php echo form_error('technote'); ?></p>
                        </div>
                	</div>
                </div>
						<div class="row">
							<div class="col-lg-6">
									<button type="submit" class="btn btn-primary">  เพิ่มตัวชี้วัด  </button>
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
<script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>



<script type="text/javascript">
var rowNum = 0;
var rowNumRes = 0;
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
});
 </script>
<script type="text/javascript">
$(document).ready(function()
{
	for (var i=1; i<5; i++) {
		var post1 = document.getElementById('addinputResponse'+i);
		post1.style.display = 'none';
		var options = document.getElementById('position0').innerHTML;
    	document.getElementById('position'+i).innerHTML = options;
    	var options2 = document.getElementById('depid0').innerHTML;
    	document.getElementById('depid'+i).innerHTML = options2;
	}



	$(function(){


		$('#resid0').autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(pwemployee) {
                                return {
									id: pwemployee.userid,
									//position: pwemployee.poname,
									positionid: pwemployee.positionid,
                                    pwname: pwemployee.pwname,
									value: pwemployee.pwname,
									pwtelephone: pwemployee.pwtelephone

                                    };
                            }));
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			select: function (event, ui) {
            event.preventDefault();
            //$("#position").val(ui.item.position);
			$("#resid0").val(ui.item.pwname);
			$("#position0").val(ui.item.positionid);
			$("#telephone0").val(ui.item.pwtelephone);
			$("#uid0").val(ui.item.id);
        }
		});

		
		
	});

	
	
});
</script>
<script type="text/javascript">
$(document).ready(function()
{
	$(function(){
		

		$('#resid1').autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(pwemployee) {
                                return {
									id: pwemployee.userid,
									//position: pwemployee.poname,
									positionid: pwemployee.positionid,
                                    pwname: pwemployee.pwname,
									value: pwemployee.pwname,
									pwtelephone: pwemployee.pwtelephone

                                    };
                            }));
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			select: function (event, ui) {
            event.preventDefault();
            //$("#position").val(ui.item.position);
			$("#resid1").val(ui.item.pwname);
			$("#position1").val(ui.item.positionid);
			$("#telephone1").val(ui.item.pwtelephone);
			$("#uid1").val(ui.item.id);
        }
		});

		
		
	});

	
	
});
</script>
<script type="text/javascript">
$(document).ready(function()
{
	$(function(){
		

		$('#resid2').autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(pwemployee) {
                                return {
									id: pwemployee.userid,
									//position: pwemployee.poname,
									positionid: pwemployee.positionid,
                                    pwname: pwemployee.pwname,
									value: pwemployee.pwname,
									pwtelephone: pwemployee.pwtelephone

                                    };
                            }));
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			select: function (event, ui) {
            event.preventDefault();
            //$("#position").val(ui.item.position);
			$("#resid2").val(ui.item.pwname);
			$("#position2").val(ui.item.positionid);
			$("#telephone2").val(ui.item.pwtelephone);
			$("#uid2").val(ui.item.id);
        }
		});

		
		
	});

	
	
});
</script>
<script type="text/javascript">
$(document).ready(function()
{
	$(function(){
		

		$('#resid3').autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(pwemployee) {
                                return {
									id: pwemployee.userid,
									//position: pwemployee.poname,
									positionid: pwemployee.positionid,
                                    pwname: pwemployee.pwname,
									value: pwemployee.pwname,
									pwtelephone: pwemployee.pwtelephone

                                    };
                            }));
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			select: function (event, ui) {
            event.preventDefault();
            //$("#position").val(ui.item.position);
			$("#resid3").val(ui.item.pwname);
			$("#position3").val(ui.item.positionid);
			$("#telephone3").val(ui.item.pwtelephone);
			$("#uid3").val(ui.item.id);
        }
		});

		
		
	});

	
	
});
</script>
<script type="text/javascript">
$(document).ready(function()
{
	$(function(){
		

		$('#resid4').autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(pwemployee) {
                                return {
									id: pwemployee.userid,
									//position: pwemployee.poname,
									positionid: pwemployee.positionid,
                                    pwname: pwemployee.pwname,
									value: pwemployee.pwname,
									pwtelephone: pwemployee.pwtelephone

                                    };
                            }));
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			select: function (event, ui) {
            event.preventDefault();
            //$("#position").val(ui.item.position);
			$("#resid4").val(ui.item.pwname);
			$("#position4").val(ui.item.positionid);
			$("#telephone4").val(ui.item.pwtelephone);
			$("#uid4").val(ui.item.id);
        }
		});

		
		
	});

	
	
});
</script>
<script>
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>