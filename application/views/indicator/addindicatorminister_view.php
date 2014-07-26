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
	<?php $this->load->view('menu'); 
        $urlgoaltemp = site_url("manageindicator/deleteGoalTemp/1");
        ?>
	
	
	
<div id="page-wrapper">

       <a id="fancyboxall" href="<?php echo site_url("manageindicator/viewIndicatorFromAdd");  ?>"><button type="button" class="btn btn-primary">แสดงตัวชี้วัดระดับกระทรวงทั้งหมด</button></a>
<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong><h4>กำหนดตัวชี้วัดและประเด็นความสำเร็จ <u>ระดับกระทรวง</u></h4>(กรุณาใส่ข้อมูลให้ครบทุกช่อง)</strong></div>

                    <div class="panel-body">
						<?php $data = array('onsubmit' => "return check_adddata()"); 
							  echo form_open('manageindicator/saveMinister', $data); ?>

<?php if ($this->session->flashdata('success')) echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  elseif ($this->session->flashdata('fail')) echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';

					
?>
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
                                        <label>ตัวชี้วัดที่ *</label>
                                        <input type="text" class="form-control" name="indicatorNO" id="indicatorNO" value="<?php echo $indicatorNO; ?>">
											<p class="help-block"><?php echo form_error('indicatorNO'); ?></p>
                                    </div>
							</div>
							<div class="col-md-9">
									<div class="form-group">
                                        <label>ชื่อตัวชี้วัด *</label>
                                        <input type="text" class="form-control" name="indicatorName" id="indicatorName" value="<?php echo $indicatorName; ?>">
											<p class="help-block"><?php echo form_error('indicatorName'); ?></p>
                                    </div>
							</div>
						</div>
						<div class="row">
							
							<div class="col-md-3">
									<div class="form-group">
                                        <label>น้ำหนัก *</label>
                                        <input type="text" class="form-control" name="weightmin" id="weightmin" value="<?php echo $weightmin; ?>">
											<p class="help-block"><?php echo form_error('weightmin'); ?></p>
                                    </div>
							</div>
						</div>
						
<!-- save goal temp -->
<div class="row">
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">ประเด็นความสำเร็จ</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="newgoaltemp">
            <div class="row">
                <div class="form-group">
                <a data-toggle="modal" data-target="#addGoalForm" class="btn btn-success" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="เพิ่มประเด็นความสำเร็จ" data-backdrop="static" data-keyboard="false">
				<span class="glyphicon glyphicon-plus"></span> เพิ่ม<br>ประเด็นความสำเร็จ</a>
                
        <!-- add new goal temp modal -->
			<div class="modal fade" id="addGoalForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
        			<div class="modal-content">
        				<div class="modal-header">
                			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  			<h4 class="modal-title">	                 	
                 				<strong>เพิ่มประเด็นความสำเร็จ</strong> 
                 			</h4>
            			</div>            <!-- /modal-header -->
            			<div class="modal-body">
					  		<div class="form-group">
								<label for="">ลำดับที่ : </label>
								<input type="text" class="form-control" name="goalnumber" id="goalnumber" value="" style="width: 80px">
					  		</div>
					  		<div class="form-group">
								<label for=""> คำอธิบายประเด็นความสำเร็จ :</label>
								<input type="text" class="form-control" name="goalname" id="goalname" value="">
					  		</div>
                                
				        </div>            <!-- /modal-body -->
        			
            				<div class="modal-footer">
            					<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addNewGoalTemp();"><span class="glyphicon glyphicon-floppy-save"></span> บันทึกประเด็นความสำเร็จ</button>			
                				<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ปิด</button>
            				</div>  
    					</div>
					</div>
				</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- show all goal temp indicatorID=0 -->
<div class="row">
    <div class="col-md-12">
        
    <table class="table" name="showtempgoal">
        <thead>
            <tr>
                <th style="width: 80px;">ลำดับ</th>
                <th>คำอธิบาย</th>
                <th style="width: 250px"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($goaltemp_array as $loop) { ?>
            <tr>
                <input type="hidden" name="goalid[]" value="<?php echo $loop->goalid; ?>">
                <td><?php echo $loop->number; ?></td>
                <td><a id="fancyboxall" href="<?php echo site_url("manageindicator/view_minplan/".$loop->goalid."/1");  ?>"><?php echo $loop->name; ?></a></td>
                <td><a id="fancyboxall" href="<?php echo site_url("manageindicator/view_minplan/".$loop->goalid."/0");  ?>"><button type="button" class="btn btn-primary btn-xs">เพิ่มแผนงาน/โครงการและเป้าหมาย</button></a> <button type="button" class="btnDelete btn btn-danger btn-xs" onclick="delgoal_confirm(<?php echo $loop->goalid; ?>)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
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
	rowNum++;
    var row = '<div class="panel panel-success" id="rowNum'+rowNum+'"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#goal'+rowNum+'">ประเด็นความสำเร็จ</a><span style="float:right;"><button class="btnDelete btn btn-danger btn-xs" onclick="removeNewForm('+rowNum+')" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-remove"></span></button></span></div></h4><div id="goal'+rowNum+'" class="panel-collapse collapse"><div class="panel-body"><div class="row"><div class="col-md-3"><div class="form-group"><label>ลำดับที่ *</label></div></div><div class="col-md-7"><div class="form-group"><label>คำอธิบาย *</label></div></div></div><div class="row"><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" name="goalNO[]" id="goalNO" value=""></div></div><div class="col-md-7"><div class="form-group"><input type="text" class="form-control" name="goalName[]" id="goalName'+rowNum+'" value=""></div></div></div>';
    
    // add plan
    row += '<div class="panel panel-default"><div class="panel-heading">แผนงาน/โครงการ</div><div class="panel-body"><div id="keepplan'+rowNum+'"><input type="hidden" id="num_plan'+rowNum+'" value="1"><div class="row"><div class="col-md-2"><div class="form-group"><label>ลำดับที่</label></div></div><div class="col-md-8"><div class="form-group"><label>คำอธิบายแผนงาน/โครงการ *</label></div></div></div><div class="addNewPlan'+rowNum+'"><div class="row"><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="planNO'+rowNum+'-0[]" id="planNO'+rowNum+'-0" value=""></div></div><div class="col-md-8"><div class="form-group"><input type="text" class="form-control" name="planName'+rowNum+'-0[]" id="planName'+rowNum+'-0" value=""></div></div><div class="col-md-1"><div class="form-group"><button id="addNewPlan" type="button" class="btn btn-success" onClick="addNewPlanFrom('+rowNum+');"><span class="glyphicon glyphicon-plus"></span> เพิ่ม</button></div></div></div></div></div></div></div></div></div></div>';
	$( ".addinput" ).append(row);
	frm.add_qty.value = '';
	frm.add_name.value = '';


}
function removeNewForm(rnum) {
jQuery('#rowNum'+rnum).remove();
}

function addNewPlanFrom(row) {
    var num_plan=$('#num_plan'+row).val();
    var newkeepdata='<div class="row">'+
			'<div class="col-md-2">'+
            '<div class="form-group">'+
            '<input type="text" class="form-control" name="planNO'+row+'-'+num_plan+'[]" id="planNO'+row+'-'+num_plan+'" value="" onChange="check_null(this)">'+
            '</div></div>'+
			'<div class="col-md-8">'+
            '<div class="form-group">'+
            '<input type="text" class="form-control" name="planName'+row+'-'+num_plan+'[]" id="planName'+row+'-'+num_plan+'" value="" onChange="check_null(this)">'+
			'</div></div>'+
			'<div class="col-lg-1">'+
			'<div class="form-group">'+
			'<button class="btn btn-danger" onclick="remove_tag(this)"><span class="glyphicon glyphicon-minus"></span> ลบ</button>'+
			'</div></div>'+
			'</div>';
    $(newkeepdata).appendTo('#keepplan'+row);
    $('#num_plan'+row).val(++num_plan);
}

function addNewGoalTemp()
{
    var goalnumber=$('#goalnumber').val();
    if(goalname==''){
        alert('กรุณาป้อนข้อมูลให้ครบ');
		$('#goalnumber').focus();
		return false;
    }
    
    var goalname=$('#goalname').val();
    if(goalname==''){
        alert('กรุณาป้อนข้อมูลให้ครบ');
		$('#goalname').focus();
		return false;
    }
    
    var number=$('#indicatorNO').val();
    var name=$('#indicatorName').val();
    var weight=$('#weightmin').val();
    
    $.ajax({
		  url: "<?php echo site_url('manageindicator/addMinGoalTemp'); ?>",
		  type: "POST",
		  data: { goalnumber:goalnumber, goalname:goalname, number:number, name:name, weight:weight },
		  'error' : function(data){ 
				alert('error');
          },
		  'success': function(data){
                alert('เพิ่มประเด็นความสำเร็จเรียบร้อยแล้ว');
                window.location.reload(true);
		  }
    })
}
    
function delgoal_confirm(val1) 
{
	bootbox.confirm("ต้องการลบข้อมูลที่เลือกไว้ใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = <?php echo json_encode($urlgoaltemp); ?>;
            	if (result) {
				
					window.location.replace(myurl+"/"+val1);
				}

		});
}

</script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	$('#fancyboxall').fancybox({ 
	'width': '80%',
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
    /*
    $('#addNewPlan').click(function(){
		var num_plan=$('#num_plan').val();
		var newkeepdata='<div class="row">'+
			'<div class="col-md-2">'+
            '<div class="form-group">'+
            '<input type="text" class="form-control" name="planNO0-'+num_plan+'[]" id="planNO0-'+num_plan+'" value="" onChange="check_null(this)">'+
            '</div></div>'+
			'<div class="col-md-8">'+
            '<div class="form-group">'+
            '<input type="text" class="form-control" name="planName0-'+num_plan+'[]" id="planName0-'+num_plan+'" value="" onChange="check_null(this)">'+
			'</div></div>'+
			'<div class="col-lg-1">'+
			'<div class="form-group">'+
			'<button class="btn btn-danger" onclick="remove_tag(this)"><span class="glyphicon glyphicon-minus"></span> ลบ</button>'+
			'</div></div>'+
			'</div>';
		$(newkeepdata).appendTo('#keepplan');
		$('#num_plan').val(++num_plan);
	});*/
			

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
		/*
		var goalName0=$('#goalName0').val();
		if(goalName0==''){
			alert('กรุณาป้อนข้อมูลให้ครบ');
			$('#goalName0').focus();
			ok = false;
			return false;
		}*/
		
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