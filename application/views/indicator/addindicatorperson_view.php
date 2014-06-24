<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/plugins/dataTables/jquery.dataTables.css" >
<style type="text/css" class="init">



</style>
</head>

<body>

	<div class="row">
        <div class="col-lg-10">
            <div class="panel panel-default">
				<div class="panel-heading">
					เพื่อตัวชี้วัดและประเด็นความสำเร็จ เฉพาะบุคคล
                </div>
                <div class="panel-body">


			<div class="row">
            <div class="col-lg-10">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง</strong></div>
					<?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว'.$this->session->flashdata('insertid').'</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
                    <div class="panel-body">
						<?php echo form_open('manageindicator/savePersonOnlyName'); ?>

						<div class="row">
							
							<div class="col-lg-8">
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
                                        <label>สอดคล้องกับตัวชี้วัดของ กรม/กอง</label>
										<select class="form-control" name="depid" id="depid" onChange="this.form.action='<?php echo site_url('manageindicator/viewDepPerson')?>/'+this.value;this.form.submit()"> 
										<?php 	if(is_array($depname_array)) {
												foreach($depname_array as $loop){
													echo "<option value='".$loop->pwsection."'";
													if ($depid==$loop->pwsection) echo " selected";
													echo ">".$loop->pwname."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
							
						</div>
							<button id="buttonselect" type="button" class="btn btn-danger">เลือกเฉพาะตัวชี้วัด</button>
                            <table class="display" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ตัวชี้วัด</th>
										<th width="50%">ชื่อ</th>
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
						<div class="row">
							<div class="col-lg-6">
									<button type="submit" class="btn btn-primary">  เพิ่มตัวชี้วัด  </button>
									<button type="button" class="btn btn-warning" onclick="javascript: return CloseWindow();"> ยกเลิก </button>
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

<script type="text/javascript">
    function CloseWindow() {
        window.close();
		window.opener.location='<?php echo site_url("manageindicator/insertPerson"); ?>';
        //window.opener.location.reload();
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
<script type="text/javascript">
var rowNum = 0;
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
</script>
<script>
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>