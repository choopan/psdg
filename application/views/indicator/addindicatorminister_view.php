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
            <div class="panel panel-default">
				<div class="panel-heading">
					<strong>กำหนดตัวชี้วัดและประเด็นความสำเร็จ <u>ระดับกระทรวง</u></strong>
                </div>
                <div class="panel-body">
                            <!-- Nav tabs -->


                            <!-- Tab panes -->
       <a id="fancyboxall" href="<?php echo site_url("manageindicator/viewIndicatorFromAdd");  ?>"><button type="button" class="btn btn-primary">แสดงตัวชี้วัดระดับกระทรวงทั้งหมด</button></a>
									<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง</strong></div>
					<?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว'.$this->session->flashdata('insertid').'</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>

                    <div class="panel-body">
						<?php $data = array('onsubmit' => "return check_adddata()"); 
							  echo form_open('manageindicator/saveMinister', $data); ?>
						
						<div class="row">
							<div class="col-md-3">
									<div class="form-group">
                                        <label>ตัวชี้วัดที่ *</label>
                                        <input type="text" class="form-control" name="indicatorNO" id="indicatorNO" value="<?php echo set_value('indicatorNO'); ?>">
											<p class="help-block"><?php echo form_error('indicatorNO'); ?></p>
                                    </div>
							</div>
							<div class="col-md-9">
									<div class="form-group">
                                        <label>ชื่อตัวชี้วัด *</label>
                                        <input type="text" class="form-control" name="indicatorName" id="indicatorName" value="<?php echo set_value('indicatorName'); ?>">
											<p class="help-block"><?php echo form_error('indicatorName'); ?></p>
                                    </div>
							</div>
						</div>
						<div class="row">
							
							<div class="col-md-3">
									<div class="form-group">
                                        <label>น้ำหนัก *</label>
                                        <input type="text" class="form-control" name="weightmin" id="weightmin" value="<?php echo set_value('weightmin'); ?>">
											<p class="help-block"><?php echo form_error('weightmin'); ?></p>
                                    </div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3">
                                            <label>ผู้กำกับดูแล *</label>
							</div>
							<div class="col-md-3">
                                            <label>ตำแหน่ง *</label>
							</div>
							<div class="col-md-3">
                                            <label>หน่วยงาน *</label>
							</div>
							<div class="col-md-2">
                                            <label>โทร. *</label>
							</div>
						</div>
						<div id="control">
							<input type="hidden" id="num_control" value="1">
						<div class="row">
                            <div class="col-md-3">
                                    <div class="form-group">
									<input type="hidden" name="controluserid" id="controluserid" value="">
                                            <input type="text" class="form-control" name="controlname" id="controlname" value="" onChange="check_null(this)">
                                    </div>
							</div>
							<div class="col-md-3">
                                    <div class="form-group has-success">
                                            <input type="text" class="form-control" name="controlposition" id="controlposition" value="" readonly>
                                    </div>
							</div>
							<div class="col-md-3">
                                    <div class="form-group has-success">
										<input type="text" class="form-control" name="controldepid" id="controldepid" value="" readonly>
                                    </div>
							</div>
							<div class="col-md-2">
                                    <div class="form-group has-success">
                                            <input type="text" class="form-control" name="controltelephone" id="controltelephone" value="" readonly>
                                    </div>
							</div>
						</div>
						</div>
						<hr/>
						<div id="keepdata">
							<input type="hidden" id="num_response" value="1">
						<div class="row">
							<div class="col-md-3">
                                            <label>ผู้จัดเก็บข้อมูล *</label>
							</div>
							<div class="col-md-3">
                                            <label>ตำแหน่ง *</label>
							</div>
							<div class="col-md-3">
                                            <label>หน่วยงาน *</label>
							</div>
							<div class="col-md-2">
                                            <label>โทร. *</label>
							</div>
							<div class="col-md-1">
                                            <label> </label>
							</div>
						</div>

                        <div class="row">
                            <div class="col-md-3">
                                    <div class="form-group">
									<input type="hidden" name="uid[]" id="uid0" value="">
                                            <input type="text" class="form-control" name="resid[]" id="resid0" value="" onChange="check_null(this)">
                                    </div>
							</div>
							<div class="col-md-3">
                                    <div class="form-group has-success">
                                            <input type="text" class="form-control" name="position[]" id="position0" value="" readonly>

                                    </div>
							</div>
							<div class="col-md-3">
                                    <div class="form-group has-success">
										<input type="text" class="form-control" name="depid[]" id="depid0" value="" readonly>

                                    </div>
							</div>
							<div class="col-md-2">
                                    <div class="form-group has-success">
                                            <input type="text" class="form-control" name="telephone[]" id="telephone0" value="" readonly>
	
                                    </div>
							</div>
							<div class="col-md-1">
									<div class="form-group">
										<button id="addNewResponse" type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> เพิ่ม</button>	
									</div>
							</div>
						</div></div>
						<hr/>
		<div class="panel panel-success">
				<div class="panel-heading">
					<strong>ประเด็นความสำเร็จ</strong>
                </div>
                <div class="panel-body">
                	
						<div class="row">
							<div class="col-md-3">
									<div class="form-group">
                                            <label>ลำดับที่ *</label>
                                    </div>
							</div>
							<div class="col-md-7">
									<div class="form-group">
                                        <label>คำอธิบาย *</label>

                                    </div>
							</div>
						</div>
					<div class="addinput">
						<div class="row">
							<div class="col-md-3">
									<div class="form-group">
                                            <input type="text" class="form-control" name="goalNO[]" id="goalNO" value="<?php echo set_value('goalNO[0]'); ?>">
											<p class="help-block"><?php echo form_error('goalNO[0]'); ?></p>
                                    </div>
							</div>
							<div class="col-md-7">
									<div class="form-group">
                                        <input type="text" class="form-control" name="goalName[]" id="goalName0" value="<?php echo set_value('goalName'); ?>">
										<p class="help-block"><?php echo form_error('goalName'); ?></p>

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
				<div class="row"><div class="col-md-4">
					<div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1">ระดับคะแนน</th>
                                            <th class="col-md-2">เกณฑ์การให้คะแนน</th>
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
					<div class="col-md-6">
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
							<textarea class="form-control" name="technote" id="technote" rows="3"><?php echo set_value('technote'); ?></textarea>
							<p class="help-block"><?php echo form_error('technote'); ?></p>
                        </div>
                	</div>
                </div>
						<div class="row">
							<div class="col-md-6">
									<button type="submit" class="btn btn-primary">  เพิ่มตัวชี้วัด  </button>
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("main"); ?>'"> ยกเลิก </button>
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
	var row = '<div class="row" id="rowNum'+rowNum+'"><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" name="goalNO[]" id="goalNO" value="<?php echo set_value('goalNO'); ?>"><p class="help-block"><?php echo form_error('goalNO'); ?></p></div></div><div class="col-md-7"><div class="form-group"><input type="text" class="form-control" name="goalName[]" id="goalName" value="<?php echo set_value('goalName'); ?>"><p class="help-block"><?php echo form_error('goalName'); ?></p></div></div><div class="col-md-1"><div class="form-group"><button id="addNew" type="button" onClick="removeNewForm('+rowNum+');" class="btn btn-danger">ลบ</button></div></div></div>';
	$( ".addinput" ).append(row);
	frm.add_qty.value = '';
	frm.add_name.value = '';


}
function removeNewForm(rnum) {
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