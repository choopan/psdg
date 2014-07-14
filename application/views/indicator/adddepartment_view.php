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
        <div class="col-lg-11">
            <div class="panel panel-default">
				<div class="panel-heading">
					<strong>กำหนดตัวชี้วัดและประเด็นความสำเร็จ <u>ระดับกรม</u><?php echo $this->session->userdata('in_selected'); ?></strong>
                </div>
                <div class="panel-body">
                            <!-- Nav tabs -->


                            <!-- Tab panes -->
       		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง</strong></div>
					<?php if ($this->session->flashdata('showresult2') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('showresult2') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
                    <div class="panel-body">
						<?php echo form_open('manageindicator/saveDepartment'); ?>

						
						<div class="row">
							<div class="col-lg-4">
									<div class="form-group">
                                        <label>กรม *</label>
										<select class="form-control" name="depid" id="depid">
											<option value=""></option>
                                    <!-- <select class="form-control" name="depid" id="depid" onChange="this.form.action='<?php echo site_url('manageindicator/viewDep')?>/'+this.value;this.form.submit()"> -->
										<?php 	if(is_array($dep_array)) {
												foreach($dep_array as $loop){
													echo "<option value='".$loop->depid."'>".$loop->thdepname."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-lg-4">
                                    <div class="form-group">
											<input type="hidden" name="uiddep" id="uiddep" value="">
                                            <label>ผู้ดูแล *</label>
                                            <input type="text" class="form-control" name="residdep" id="residdep" value="<?php echo set_value('residdep'); ?>">
											<p class="help-block"><?php echo form_error('residdep'); ?></p>
                                    </div>
							</div>
							<div class="col-lg-4">
                                    <div class="form-group">
                                            <label>ตำแหน่ง *</label>
                                            <select class="form-control" name="positiondep" id="positiondep">
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
							<div class="col-lg-4">
                                    <div class="form-group">
                                            <label>โทร. *</label>
                                            <input type="text" class="form-control" name="telephonedep" id="telephonedep" value="<?php echo set_value('telephonedep'); ?>">
											<p class="help-block"><?php echo form_error('telephonedep'); ?></p>
                                    </div>
							</div>
						</div>
						
		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>รายการตัวชี้วัดและประเด็นความสำเร็จของกระทรวงที่เลือก</strong> </div>
                    <div class="panel-body">
                        <div class="table-responsive" id="dtbody">
						<!--<button id="buttonselect" type="button" class="btn btn-primary">แสดงเฉพาะตัวชี้วัดที่เลือก</button> -->
						<!-- show all indicator minister -->
						<a id="fancyboxall" href="<?php echo site_url("manageindicator/selectIndicatorMinisterList");  ?>"><button id="buttonselect" type="button" class="btn btn-primary">แสดงตัวชี้วัดของกระทรวงทั้งหมด</button></a>
                            <table class="table table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
										<th>ชื่อตัวชี้วัด</th>
										<th width="200">เลือกมาจาก</th>
										<th width="100">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php for ($i=0; $i<count($indicator_min); $i++) {
                                        ?>
                                    <tr>
                                    <td>
										<?php echo $indicator_min[$i]; ?>
									</td>
									<td>
										ตัวชี้วัดของกระทรวง
									</td>
									<td>
										<?php echo $indicator_min[$i]; ?>
									</td>
                                    </tr>
                                <?php  } ?>
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
					<div class="panel-heading"><strong>รายการตัวชี้วัดของกรม</strong> </div>
                    <div class="panel-body">
                        <div class="table-responsive">
						<a id="buttonadddep" href="<?php echo site_url("manageindicator/addNewIndicatorDep");  ?>"><button type="button" class="btn btn-primary">เพิ่มตัวชี้วัดของกรม</button></a>
						<button id="buttondel2" type="button" class="btn btn-danger">ลบตัวชี้วัดที่เลือก</button>
                            <table class="display" id="dataTables-example2" cellspacing="0px" width="100%">
                                <thead>
                                    <tr>
										<th width="100">ตัวชี้วัดที่</th>
										<th width="500">ชื่อตัวชี้วัด</th>
										<th width="100">ค่าเป้าหมาย</th>
										<th width="100">น้ำหนัก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($indicatordep_array)) {
                                        foreach($indicatordep_array as $loop){ ?>
                                    <tr>
                                    <td><input type="hidden" name="indicatordepid[]" id="indicatordepid[]" value="<?php echo $loop->id; ?>"><?php echo $loop->number; ?></td>
                                    <td><a id="fancyboxview" href="<?php echo site_url("manageindicator/viewIndicatorLinkDep/".$loop->id);  ?>"><?php echo $loop->name; ?></a></td>
                                    <td><?php echo $loop->goal; ?></td>
                                    <td><?php echo $loop->weight; ?></td>
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
<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {
		/*
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
		*/

		var table2 = $('#dataTables-example2').DataTable		
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
	 

		$('#dataTables-example2 tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table2.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
		} );
		
		$('#buttondel2').click( function () {
			table2.row('.selected').remove().draw( false );
		} );

    });


</script>
<script type='text/javascript'> 
$(document).ready(function() {
$('#fancyboxall').fancybox({ 
'width': '80%',
'height': '80%', 
'autoScale':false,
'transitionIn':'none', 
'transitionOut':'none', 
'afterClose': function() {  parent.location.reload(true); },
'type':'iframe',
}); 
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
$('#buttonadddep').fancybox({ 
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



	$(function(){


		$('#residdep').autocomplete({
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
			$("#residdep").val(ui.item.pwname);
			$("#positiondep").val(ui.item.positionid);
			$("#telephonedep").val(ui.item.pwtelephone);
			$("#uiddep").val(ui.item.id);
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