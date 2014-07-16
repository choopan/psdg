<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/plugins/dataTables/jquery.dataTables.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.fancybox.css" >
<style type="text/css" class="init">



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
				    <?php echo $admin_level; ?>
                </div>
                <div class="panel-body">
                <div class="table-responsive">
						
                <table class="table" id="dataTables" cellspacing="0px" width="100%">
                                <thead>
                                    <tr>
										<th style="width: 30%">ชื่อ-นามสกุล</th>
										<th>สังกัด</th>
										<th>หน่วยงาน</th>
										<th style="width: 20%">ตำแหน่ง</th>
                                    </tr>
                                </thead>
								<tbody>
									<?php 	if(is_array($admin_array)) {
												foreach($admin_array as $loop){ ?>
												<tr>
												<td>
												<?php echo $loop->PWFNAME." ".$loop->PWLNAME; ?>
												</td>
												<td><?php echo $loop->depname; ?></td>
												<td><?php echo $loop->divname; ?></td>
												<td><?php echo $loop->position; ?></td>
												</tr>
									<?php } }?>
								</tbody>
							</table>
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