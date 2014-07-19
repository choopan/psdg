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
	<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
	
	
<div id="page-wrapper">
	<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
				<div class="panel-heading">
					<strong>รายงานผลการดำเนินการ ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?> รอบ 6 เดือน</strong>
                </div>

                    <div class="panel-body">
						<?php $data = array('onsubmit' => "return check_adddata()"); 
							  echo form_open('', $data); ?>
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
                                        <label>ประเด็นความสำเร็จที่ *</label>
                                        <input type="text" class="form-control" name="indicatorNO" id="indicatorNO" value="<?php echo $number; ?>">
											<p class="help-block"><?php echo form_error('indicatorNO'); ?></p>
                                    </div>
							</div>
							<div class="col-md-9">
									<div class="form-group">
                                        <label>ชื่อประเด็นความสำเร็จ *</label>
                                        <input type="text" class="form-control" name="indicatorName" id="indicatorName" value="<?php echo $name; ?>">
											<p class="help-block"><?php echo form_error('indicatorName'); ?></p>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
                                        <label>ตัวชี้วัดที่ *</label>
                                        <input type="text" class="form-control" name="indicatorNO" id="indicatorNO" value="<?php echo $innumber; ?>">
											<p class="help-block"><?php echo form_error('indicatorNO'); ?></p>
                                    </div>
							</div>
							<div class="col-md-9">
									<div class="form-group">
                                        <label>ชื่อตัวชี้วัด *</label>
                                        <input type="text" class="form-control" name="indicatorName" id="indicatorName" value="<?php echo $inname; ?>">
											<p class="help-block"><?php echo form_error('indicatorName'); ?></p>
                                    </div>
							</div>
						</div>
						<div class="row">
							
							<div class="col-md-2">
									<div class="form-group">
                                        <label>ประเภทตัวชี้วัด *</label>
                                        <input type="text" class="form-control" name="weightmin" id="weightmin" value="ตัวชี้วัดของกรม">
											<p class="help-block"><?php echo form_error('weightmin'); ?></p>
                                    </div>
							</div>
                            <div class="col-md-9">
									<div class="form-group">
                                        <label>ผู้รายงานผล *</label>
                                        <input type="text" class="form-control" name="userid" id="userid" value="<?php echo $user; ?>">
											<p class="help-block"><?php echo form_error('userid'); ?></p>
                                    </div>
							</div>
						</div>
						
		<div class="panel panel-success">
				<div class="panel-heading">
					<strong>เอกสารแนบ</strong>
                </div>
                <div class="panel-body">
                	
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
                                            <label>ลำดับที่ *</label>
                                    </div>
							</div>
							<div class="col-md-5">
									<div class="form-group">
                                        <label>ชื่อเอกสาร *</label>

                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group">
                                        <label>เลือกไฟล์ *</label>

                                    </div>
							</div>
						</div>
					<div class="addinput">
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
                                            <input type="text" class="form-control" name="goalNO[]" id="goalNO" value="<?php echo set_value('goalNO[0]'); ?>">
											<p class="help-block"><?php echo form_error('goalNO[0]'); ?></p>
                                    </div>
							</div>
							<div class="col-md-5">
									<div class="form-group">
                                        <input type="text" class="form-control" name="goalName[]" id="goalName0" value="<?php echo set_value('goalName'); ?>">
										<p class="help-block"><?php echo form_error('goalName'); ?></p>

                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group">
                                        <input type="file">

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
        <div class="panel panel-success">
				<div class="panel-heading">
					<strong>แนวทางการประเมินผล</strong>
                </div>
                <div class="panel-body">
                	
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
                                            <label>ระดับ/ขั้นตอน *</label>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
                                        <label>แผนงาน/โครงการ *</label>

                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group">
                                        <label>เป้าหมาย *</label>

                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group">
                                        <label>น้ำหนักคะแนน *</label>

                                    </div>
							</div>
						</div>
					<div class="addinput2">
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
                                            <input type="text" class="form-control" name="goalNO[]" id="goalNO" value="<?php echo set_value('goalNO[0]'); ?>">
											<p class="help-block"><?php echo form_error('goalNO[0]'); ?></p>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
                                        <textarea class="form-control" name="technote" id="technote" rows="3"></textarea>

                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group">
                                        <textarea class="form-control" name="technote" id="technote" rows="3"></textarea>

                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group">
                                            <input type="text" class="form-control" name="goalNO[]" id="goalNO" value="<?php echo set_value('goalNO[0]'); ?>">
											<p class="help-block"><?php echo form_error('goalNO[0]'); ?></p>
                                    </div>
							</div>
							<div class="col-md-1">
									<div class="form-group">
										<button id="addNew" type="button" onClick="addNewForm2(this.form);" class="btn btn-success">เพิ่ม</button>	
									</div>
							</div>
						</div>
					</div>
				</div></div>
						<div class="row">
							<div class="col-md-6">
									<button type="submit" class="btn btn-primary">  ส่งรายงาน  </button>
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("reportgoal/goal_response"); ?>'"> ยกเลิก </button>
							</div>
						</div>
								
								
						</form>

					</div>
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
	var row = '<div class="row" id="rowNum'+rowNum+'"><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="goalNO[]" id="goalNO" value="<?php echo set_value('goalNO'); ?>"><p class="help-block"><?php echo form_error('goalNO'); ?></p></div></div><div class="col-md-5"><div class="form-group"><input type="text" class="form-control" name="goalName[]" id="goalName" value="<?php echo set_value('goalName'); ?>"><p class="help-block"><?php echo form_error('goalName'); ?></p></div></div><div class="col-md-3"><div class="form-group"><input type="file"></div></div><div class="col-md-1"><div class="form-group"><button id="addNew" type="button" onClick="removeNewForm('+rowNum+');" class="btn btn-danger">ลบ</button></div></div></div>';
	$( ".addinput" ).append(row);
	frm.add_qty.value = '';
	frm.add_name.value = '';


}
function removeNewForm(rnum) {
jQuery('#rowNum'+rnum).remove();
}

function addNewForm2(frm) {
	rowNum ++;
	var row = '<div class="row" id="rowNum'+rowNum+'"><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="goalNO[]" id="goalNO" value="<?php echo set_value('goalNO'); ?>"><p class="help-block"><?php echo form_error('goalNO'); ?></p></div></div><div class="col-md-3"><div class="form-group"><textarea class="form-control" name="technote" id="technote" rows="3"></textarea></div></div><div class="col-md-3"><div class="form-group"><textarea class="form-control" name="technote" id="technote" rows="3"></textarea></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="goalName[]" id="goalName" value="<?php echo set_value('goalName'); ?>"></div></div><div class="col-md-1"><div class="form-group"><button id="addNew" type="button" onClick="removeNewForm('+rowNum+');" class="btn btn-danger">ลบ</button></div></div></div>';
	$( ".addinput2" ).append(row);
	frm.add_qty.value = '';
	frm.add_name.value = '';


}
function removeNewForm2(rnum) {
jQuery('#rowNum'+rnum).remove();
}


</script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	$('#fancyboxall').fancybox({ 
	'width': '85%',
	'height': '100%', 
	'autoScale':false,
	'transitionIn':'none', 
	'transitionOut':'none', 
	'type':'iframe'}); 
	
	auto_tag("#controlname",'','control');
	auto_tag("#resid",0,'keepdata');
	$('#addNewResponse').click(function(){
		var num_response=$('#num_response').val();
		var newkeepdata='<div class="row">'+
			'<div class="col-md-3">'+
            '<div class="form-group">'+
			'<input type="hidden" name="uid[]" id="uid'+num_response+'" value="">'+
            '<input type="text" class="form-control" name="resid[]" id="resid'+num_response+'" value="" onChange="check_null(this)">'+
            '</div></div>'+
			'<div class="col-md-3">'+
            '<div class="form-group has-success">'+
            '<input type="text" class="form-control" name="position[]" id="position'+num_response+'" value="" readonly>'+
			'</div></div>'+
			'<div class="col-md-3">'+
            '<div class="form-group has-success">'+
			'<input type="text" class="form-control" name="depid[]" id="depid'+num_response+'" value="" readonly>'+
			'</div></div>'+
			'<div class="col-md-2">'+
            '<div class="form-group has-success">'+
            '<input type="text" class="form-control" name="telephone[]" id="telephone'+num_response+'" value="" readonly>'+
			'</div></div>'+
			'<div class="col-lg-1">'+
			'<div class="form-group">'+
			'<button class="btn btn-danger" onclick="remove_tag(this)"><span class="glyphicon glyphicon-minus"></span> ลบ</button>'+
			'</div></div>'+
			'</div>';
		$(newkeepdata).appendTo('#keepdata');
		auto_tag("#resid",num_response,'keepdata');
		$('#num_response').val(++num_response);
	});
			

});
		
	function check_null(obj)
	{
		var value_before=$(obj).val();
		$(obj).val(value_before.trim());
	}
		
	function remove_tag(obj)
	{
		$(obj).parent().parent().parent().remove();
	}
		
	function auto_tag(tag,num,select)
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
							position: pwemployee.poname,
                            pwname: pwemployee.pwname,
							value: pwemployee.pwname,
							pwtelephone: pwemployee.pwtelephone,
							depname: pwemployee.depname
                        };
                    }));
                }
            });
		},
		minLength: 2,
		autofocus: true,
		mustMatch: true,
		select: function(event,ui){
			if (select=='keepdata') {
				$("#position"+num).val(ui.item.position);
				$("#depid"+num).val(ui.item.depname);
				$("#resid"+num).val(ui.item.pwname);
				$("#telephone"+num).val(ui.item.pwtelephone);
				$("#uid"+num).val(ui.item.id);
			}else{
				$("#controlposition").val(ui.item.position);
				$("#controlname").val(ui.item.pwname);
				$("#controldepid").val(ui.item.depname);
				$("#controltelephone").val(ui.item.pwtelephone);
				$("#controluserid").val(ui.item.id);
			}
		}
		});
			
	}
	
	function check_adddata()
	{
		var indicatorNO=$('#indicatorNO').val();
		if(indicatorNO==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#indicatorNO').focus();
			return false;
		}
		var ok = true;
		
		var indicatorName=$('#indicatorName').val();
		if(indicatorName==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#indicatorName').focus();
			ok = false;
			return false;
		}
		
		var weightmin=$('#weightmin').val();
		if(weightmin==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#weightmin').focus();
			ok = false;
			return false;
		}
		
		var controlname=$('#controlname').val();
		if(controlname==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#controlname').focus();
			ok = false;
			return false;
		}
		
		var resid0=$('#resid0').val();
		if(resid0==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#resid0').focus();
			ok = false;
			return false;
		}
		
		var goalName0=$('#goalName0').val();
		if(goalName0==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#goalName0').focus();
			ok = false;
			return false;
		}
		
		var criterion1=$('#criterion1').val();
		if(criterion1==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#criterion1').focus();
			ok = false;
			return false;
		}
		
		var criterion2=$('#criterion2').val();
		if(criterion2==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#criterion2').focus();
			ok = false;
			return false;
		}
		
		var criterion3=$('#criterion3').val();
		if(criterion3==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#criterion3').focus();
			ok = false;
			return false;
		}
		
		var criterion4=$('#criterion4').val();
		if(criterion4==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#criterion4').focus();
			ok = false;
			return false;
		}
		
		var criterion5=$('#criterion5').val();
		if(criterion5==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#criterion5').focus();
			ok = false;
			return false;
		}
		
		var criterion5=$('#criterion5').val();
		if(criterion5==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#criterion5').focus();
			ok = false;
			return false;
		}
		var goalmin = $("input:radio[name=goalmin]:checked").val();
        if(goalmin=="" || goalmin==undefined){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			ok = false;
			return false;
		}

		if(!ok) {return false;}
		
	}
 </script>
<script>
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>