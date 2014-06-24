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
					<strong>กำหนดตัวชี้วัดและประเด็นความสำเร็จ <u>ระดับบุคคล</u></strong>
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
						<?php echo form_open('manageindicator/saveIndicatorPerson'); ?>
						<div class="row">
							
							<div class="col-lg-4">
									<div class="form-group">
                                        <label>สอดคล้องกับตัวชี้วัดของ กอง</label>
										<select class="form-control" name="depid" id="depid" onChange="this.form.action='<?php echo site_url('manageindicator/viewDivisionPerson')?>/'+this.value;this.form.submit()"> 
										<option></option>
										<?php 	if(is_array($division_array)) {
												foreach($division_array as $loop){
													echo "<option value='".$loop->depid."'";
													if ($depid==$loop->depid) echo " selected";
													echo ">".$loop->thdepname."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
							
						</div>
						<div class="row">
							
							<div class="col-lg-8">
							<button id="buttonselect" type="button" class="btn btn-danger">เลือกเฉพาะตัวชี้วัด</button>
                            <table class="display" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="100">ตัวชี้วัด</th>
										<th>ชื่อ</th>
                                    </tr>
                                </thead>
								<tbody>
									<?php  if(is_array($indicatordep_array)) {
												foreach($indicatordep_array as $loop){
									?>
									<tr>
									
									<td><input type="hidden" name="depinid[]" id="depinid[]" value="<?php echo $loop->id;?>"><?php echo $loop->number; ?></td>
									<td><?php echo $loop->name; ?></td>
									</tr>
									<?php } } ?>
								</tbody>
							</table>
							</div>
							
						</div>
						<br>
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
							<div class="col-lg-4">
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
<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {

        var table = $('#dataTables-example').DataTable		
        ({
            "bJQueryUI": false,
            "bProcessing": true,
            "sPaginationType": "simple_numbers",
			'bFilter'  : false,
			"bInfo": false,
			"bLengthChange" : false,
			"bPaginate" : false,
			"iDisplayLength": 10000,
            "bDeferRender": false,
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
	 

		$('#dataTables-example tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
		} );
		
		$('#buttonselect').click( function () {
			var selectrow = table.row( '.selected' ).data() ;
			table.clear();
			table.row.add(selectrow).draw();
		} );
		

    });


</script>
<script>
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>