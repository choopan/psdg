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
    <?php $urlgoaltemp = site_url("manageindicator/deleteGoalTemp/5"); ?>
	<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
				<div class="panel-heading">
					<strong>กำหนดตัวชี้วัดและประเด็นความสำเร็จ <u>ระดับกอง</u> (กรุณาใส่ข้อมูลให้ครบทุกช่อง)</strong>
                </div>
                <div class="panel-body">
                            <!-- Nav tabs -->


                            <!-- Tab panes -->
					<?php if ($showresult == 'success') { echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; }
						  else if ($showresult == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
                          else {
					
					?>

						<?php echo form_open('manageindicator/saveDiv'); ?>
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
							<div class="col-md-2">
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
                            <div class="form-group">
								<label for=""> ผู้รับผิดชอบ :</label>
                                <input type="hidden" name="responseid" id="responseid" value="">
								<input type="text" class="form-control" name="responsename" id="responseName" value="">
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
                <th style="width: 140px;">ผู้รับผิดชอบ</th>
                <th style="width: 250px"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($goaltemp_array as $loop) { ?>
            <tr>
                <input type="hidden" name="goalid[]" value="<?php echo $loop->goalid; ?>">
                <td><?php echo $loop->number; ?></td>
                <td><a id="fancyboxall" href="<?php echo site_url("manageindicator/view_minplan/".$loop->goalid."/5");  ?>"><?php echo $loop->name; ?></a></td>
                <td><?php echo $loop->pwfname." ".$loop->pwlname; ?></td>
                <td><a id="fancyboxall" href="<?php echo site_url("manageindicator/view_minplan/".$loop->goalid."/4");  ?>"><button type="button" class="btn btn-primary btn-xs">เพิ่มแผนงาน/โครงการและเป้าหมาย</button></a> <button type="button" class="btnDelete btn btn-danger btn-xs" onclick="delgoal_confirm(<?php echo $loop->goalid; ?>)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
</div>
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
						<div class="row">
							<div class="col-md-6">
									<button type="submit" class="btn btn-primary">  เพิ่มตัวชี้วัดระดับกอง  </button>
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

function auto_tag(tag)
{
    $(tag).autocomplete({
		source: function(request, response){
			$.ajax({
                url: "<?php echo site_url('manageindicator/autocompleteResponse/'.$divid); ?>",
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
				$("#responseid").val(ui.item.id);
				$("#responseName").val(ui.item.value);

        }
    });
    $(tag).autocomplete( "option", "appendTo", "#addGoalForm" );
			
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
    

    auto_tag("#responseName");

});
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
    
    var responsename=$('#responseName').val();
    if(responsename==''){
        alert('กรุณาป้อนข้อมูลให้ครบ');
		$('#responsename').focus();
		return false;
    }
    
    var number=$('#indicatorNO').val();
    var name=$('#indicatorName').val();
    var weight=$('#weightmin').val();
    
    var responseid = $('#responseid').val();
    
    $.ajax({
		  url: "<?php echo site_url('manageindicator/addDivGoalTemp'); ?>",
		  type: "POST",
		  data: { goalnumber:goalnumber, goalname:goalname, responseid:responseid, number:number, name:name, weight:weight },
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
<script>
$(".alert-message").alert();
//window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>