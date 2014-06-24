<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/plugins/dataTables/jquery.dataTables.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.fancybox.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datepicker.css" >
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
					<?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
                    <div class="panel-body">
						<?php echo form_open('manageindicator/savePerson'); ?>
						<div class="row">
							<div class="col-lg-4">
									<div class="form-group">
                                        <label>รอบการประเมิน *</label>
                                        <div class="form-group"><label class="radio-inline"><input type="radio" name="round" id="round" <?php echo set_radio('round', '1'); ?> value="1">รอบที่ 1</label>
											<label class="radio-inline"><input type="radio" name="round" id="round" <?php echo set_radio('round', '2'); ?> value="2">รอบที่ 2</label>
									
											<p class="help-block"><?php echo form_error('round'); ?></p>
										</div>
                                    </div>
							</div>
							<div class="col-lg-4">
									<div class="form-group">
                                        <label>ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?></label>
                                        
                                    </div>
							</div>
						</div>
						<?php 	if(is_array($person_array)) {
									foreach($person_array as $loop){ ?>
						
                        <div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group">
											<input type="hidden" name="uidperson" id="uidperson" value="">
                                            <label>ผู้รับผิดชอบ *</label>
                                            <input type="text" class="form-control" name="residperson" id="residperson" value="<?php echo $loop->fullname; ?>" readonly>
											<p class="help-block"><?php echo form_error('residperson'); ?></p>
                                    </div>
							</div>
							<div class="col-lg-4">
                                    <div class="form-group">
                                            <label>ตำแหน่ง *</label>
                                            <input type="text" class="form-control" name="positionperson" id="positionperson" value="<?php echo $loop->poname; ?>" readonly>
											<p class="help-block"><?php echo form_error('positionperson'); ?></p>
                                    </div>
							</div>
							<div class="col-lg-4">
                                    <div class="form-group">
                                            <label>โทร. *</label>
                                            <input type="text" class="form-control" name="telephoneperson" id="telephoneperson" value="<?php echo $loop->PWTELOFFICE; ?>" readonly>
											<p class="help-block"><?php echo form_error('telephoneperson'); ?></p>
                                    </div>
							</div>
						</div>
						<?php } }?>

					<div class="row" id="addshowlabel">
							<div class="col-lg-3">
									<div class="form-group">
                                            <label>สังกัด *</label>
                                    </div>
							</div>
							
					</div>
					<div class="addinput">
						<div class="row" id="newform">
							<div class="col-lg-3">
									<div class="form-group">
                                        <select class="form-control" name="depid[]" id="depid0">
											<option value="-1"> </option>
											<?php 	
													if(is_array($dep_array)) {
													foreach($dep_array as $loopdep){
														echo "<option value='".$loopdep->depid."'";
														echo set_select('depid[]', $loopdep->depid);
														echo ">".$loopdep->thdepname."</option>";
											 } } ?>
										</select>
										<p class="help-block"><?php echo form_error('depid[]'); ?></p>
                                    </div>
							</div>
							
							
							<div class="col-lg-1">
									<div class="form-group">
										<button id="addNew" type="button" onClick="addNewForm(this.form);" class="btn btn-success">เพิ่ม</button>	
									</div>
							</div>
						</div>
					</div>
					

		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>รายการตัวชี้วัดของบุคคล รอบการประเมินล่าสุด</strong> </div>
                    <div class="panel-body">
                        <div class="table-responsive">
						<button id="buttonselect" type="button" class="btn btn-primary">แสดงเฉพาะตัวชี้วัดที่เลือก</button>
                            <table class="display" id="dataTables-example" cellspacing="0px" width="100%">
                                <thead>
                                    <tr>
										<th width="80">ตัวชี้วัดที่</th>
										<th width="500">ชื่อตัวชี้วัด</th>
										<th width="200">ค่าเป้าหมาย</th>
										<th width="80">น้ำหนัก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($last_array)) {
                                        foreach($last_array as $loop){ ?>
                                    <tr>
                                    <td><input type="hidden" name="indicatorid[]" id="indicatorid[]" value="<?php echo $loop->id; ?>"><input type="text" class="form-control" name="number[]" id="number[]" value=""></td>
                                    <td><a id="fancyboxview" href="<?php echo site_url("manageindicator/viewIndicatorLinkPerson/".$loop->id);  ?>"><?php echo $loop->name; ?></a></td>
                                    <td><div class="form-group"><label class="radio-inline"><input type="radio" name="goal-<?php echo $loop->id; ?>" id="goal-<?php echo $loop->id; ?>" value="1">1</label>
                                            <label class="radio-inline"><input type="radio" name="goal-<?php echo $loop->id; ?>" id="goal-<?php echo $loop->id; ?>" value="2">2</label>
											<label class="radio-inline"><input type="radio" name="goal-<?php echo $loop->id; ?>" id="goal-<?php echo $loop->id; ?>" value="3">3</label>
											<label class="radio-inline"><input type="radio" name="goal-<?php echo $loop->id; ?>" id="goal-<?php echo $loop->id; ?>" value="4">4</label>
											<label class="radio-inline"><input type="radio" name="goal-<?php echo $loop->id; ?>" id="goal-<?php echo $loop->id; ?>" value="5">5</label>
                                        </div></td>
                                    <td><div class="form-group"><input type="text" class="form-control" name="weight[]" id="weight[]" value=""></td>
                                    </tr>
                                <?php } } ?>
                                </tbody>
								
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>

		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>รายการตัวชี้วัดของบุคคล</strong> </div>
                    <div class="panel-body">
                        <div class="table-responsive">
						<a id="buttonadd" href="<?php echo site_url("manageindicator/addNewIndicatorPerson");  ?>"><button type="button" class="btn btn-primary">เพิ่มตัวชี้วัดของบุคคล</button></a>
						
                            <table class="display" id="dataTables-example3" cellspacing="0px" width="100%">
                                <thead>
                                    <tr>
										<th width="100">ตัวชี้วัดที่</th>
										<th width="500">ชื่อตัวชี้วัด</th>
										<th width="100">ค่าเป้าหมาย</th>
										<th width="100">น้ำหนัก</th>
                                    </tr>
                                </thead>
								<tbody>
									<?php 	if(is_array($indicatorperson_array)) {
												foreach($indicatorperson_array as $loop){ ?>
												<tr>
												<td>
												<input type="hidden" name="indicatorpersonid[]" id="indicatorpersonid[]" value="<?php echo $loop->id; ?>">
												<?php echo $loop->number; ?>
												</td>
												<td><a id="fancyboxview" href="<?php echo site_url("manageindicator/viewIndicatorLinkPerson/".$loop->id);  ?>"><?php echo $loop->name; ?></a></td>
												<td><?php echo $loop->goal; ?></td>
												<td><?php echo $loop->weight; ?></td>
												</tr>
									<?php } }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>

						<div class="row">
							<div class="col-lg-6">
									<button type="submit" class="btn btn-primary">  บันทึก  </button>
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
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>


<script type="text/javascript">
var rowNum = 0;
var countRow = 0;
function addNewForm(frm) {
	rowNum ++;
	countRow++;
	var row = '<div class="row" id="rowNum'+rowNum+'"><div class="col-lg-3"><div class="form-group"><select class="form-control" name="depid[]" id="depid'+rowNum+'"></select></div></div><div class="col-lg-3"><div class="form-group"><input type="text" class="form-control datepick" name="startdate[]" value="" id="dp1-'+rowNum+'" ></div></div><div class="col-lg-3"><div class="form-group"><input type="text" class="form-control datepick" name="enddate[]" value="" id="dp2-'+rowNum+'" ></div></div><div class="col-lg-1"><div class="form-group"><button id="addNew" type="button" onClick="removeNewForm('+rowNum+');" class="btn btn-danger">ลบ</button></div></div></div>';
	$( ".addinput" ).append(row);
	var options = document.getElementById('depid0').innerHTML;
    document.getElementById('depid'+rowNum).innerHTML = options;
	if (countRow == 1) {
		var newlabel = '<div class="col-lg-3"><div class="form-group"><label>สังกัด *</label></div></div><div class="col-lg-3"><div class="form-group"><label>วันที่เริ่มทำงานในสังกัด *</label></div></div><div class="col-lg-3"><div class="form-group"><label>วันที่สิ้นสุดทำงานในสังกัด</label></div></div>';
		document.getElementById('addshowlabel').innerHTML = newlabel;
		
		var newform = '<div class="col-lg-3"><div class="form-group"><select class="form-control" name="depid[]" id="depid0"><option value=""> </option></select></div></div><div class="col-lg-3"><div class="form-group"><input type="text" class="form-control datepick" name="startdate[]" value="" id="dp1-0" ></div></div><div class="col-lg-3"><div class="form-group"><input type="text" class="form-control datepick" name="enddate[]" value="" id="dp2-0" ></div></div><div class="col-lg-1"><div class="form-group"><button id="addNew" type="button" onClick="addNewForm(this.form);" class="btn btn-success">เพิ่ม</button></div></div>';
		document.getElementById('newform').innerHTML = newform;

		document.getElementById('depid0').innerHTML = options;
	}
	
	$( ".datepick").each(function() {
             $(this).datepicker({
				format: 'dd-mm-yyyy',
                todayBtn: 'linked'
			});
     });

}
function removeNewForm(rnum) {

countRow--;
	if (countRow == 0) {
		var options = document.getElementById('depid'+rnum).innerHTML;
		var newlabel = '<div class="col-lg-3"><div class="form-group"><label>สังกัด *</label></div></div>';
		document.getElementById('addshowlabel').innerHTML = newlabel;
		var newform = '<div class="col-lg-3"><div class="form-group"><select class="form-control" name="depid[]" id="depid0"><option value=""> </option></select></div></div><div class="col-lg-1"><div class="form-group"><button id="addNew" type="button" onClick="addNewForm(this.form);" class="btn btn-success">เพิ่ม</button></div></div>';
		document.getElementById('newform').innerHTML = newform;	
		document.getElementById('depid0').innerHTML = options;		
	}
jQuery('#rowNum'+rnum).remove();
}




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
        	$(this).toggleClass('selected');
    	} );
		
		$('#buttondel').click( function () {
			table.row('.selected').remove().draw( false );
		} );
		
		$('#buttonselect').click( function () {
			var selectrow = table.rows( '.selected' ).data() ;
			table.clear();
				table.rows.add(selectrow).draw();
		} );
        
		var table3 = $('#dataTables-example3').DataTable		
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

    });


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
 <script type='text/javascript'> 
$(document).ready(function() {
$('#fancyboxview').fancybox({ 
'width': '80%',
'height': '100%', 
'autoScale':false,
'transitionIn':'none', 
'transitionOut':'none', 
'type':'iframe'}); 
});
 </script>
<script type='text/javascript'> 
$(document).ready(function() {
$('#buttonadd').fancybox({ 
'width': '90%',
'height': '100%', 
'autoScale':false,
'transitionIn':'none', 
'transitionOut':'none', 
'afterClose': function() {  parent.location.reload(true); },
'type':'iframe'}); 
});
 </script>
<script type="text/javascript">
$(document).ready(function()
{

	$('.datepick').datepicker({
				format: 'dd-mm-yyyy',
			}).datepicker("setDate", "0");
});
</script>

<script>
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>