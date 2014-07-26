<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.fancybox.css" >
</head>

<body>
<h4>แผนงาน/โครงการ ของประเด็นความสำเร็จที่ <?php echo $goalnumber." ".$goalname; ?></h4>
    
<?php if ($this->session->flashdata('success')) echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('fail')) echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-body">
<?php if ($show%2>0) {?>
<table class="table" id="dataTables-example">
    <thead>
    <tr>
        <th style="width: 8%;">ลำดับที่</th>
        <th style="width: 40%;">แผนงาน/โครงการ</th>
        <th style="width: 52%;">เป้าหมาย</th>
    </tr>
    </thead>
    <tbody>
        <?php $last=0;
            foreach($plan_array as $loop) { 
        ?>
        <tr>
            <td><?php if ($last!=$loop->pnumber) echo $loop->pnumber; ?></td>
            <td><?php if ($last!=$loop->pnumber) echo $loop->pname; ?></td>
            <td><?php echo $loop->tnumber.". ".$loop->tname;; ?></td>
        </tr>
        <?php $last = $loop->pnumber; } ?>
    </tbody>
</table>
<?php } else { ?>

<div class="row">
    <div class="col-md-12">
    <form class="form-inline" action="<?php echo site_url("manageindicator/add_plan/".$show); ?>" method="POST">
    <input type="hidden" name="goalid" value="<?php echo $goalid; ?>">
    <div class="form-group">
        <label for="">ลำดับที่ : </label>
        <input type="text" class="form-control" name="number" id="number" value="" style="width: 80px" required>
    </div>
	<div class="form-group">
		<label for=""> แผนงาน/โครงการ :</label>
		<textarea type="text" class="form-control" name="name" id="name" style="width: 450px" required></textarea>
	</div>
    <div class="panel panel-default">
            <div class="panel-heading">เป้าหมายของแผนงาน/โครงการ</div>
    </div>
    <div class="form-group">
        <input type="hidden" id="num_target" value="1">
        <label for="">ลำดับที่ : </label>
        <input type="text" class="form-control" name="target_number[]" id="target_number" value="" style="width: 80px" required>
    </div>
	<div class="form-group">
		<label for=""> เป้าหมาย :</label>
		<textarea type="text" class="form-control" name="target_name[]" id="target_name" style="width: 450px" required></textarea>
	</div>
    <div class="form-group">
	   <button type="button" class="btn btn-success" onclick="addNewTarget();"><span class="glyphicon glyphicon-plus"></span> เพิ่ม</button>	
    </div><div><br></div>
<div id="frmname"></div>
</div></div><br>
<div class="row">
    <div class="col-md-12">
    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> บันทึกแผนงาน/โครงการ</button>
    
</div></div>
</form>
<?php } ?>
<br><br><br><br>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>
<script type="text/javascript" charset="utf-8">
var row = 0;
function removeNewTarget(rnum) {
jQuery('#row'+rnum).remove();
}

function addNewTarget() {
    row++;
    var newkeepdata='<div id="row'+row+'"><div class="form-group"><label for="">ลำดับที่ : </label> <input type="text" class="form-control" name="target_number[]" id="target_number" value="" style="width: 80px" required></div> <div class="form-group"><label for="">เป้าหมาย :</label> <textarea type="text" class="form-control" name="target_name[]" id="target_name" style="width: 450px" required></textarea></div><div class="form-group"><button class="btn btn-danger" onclick="removeNewTarget('+row+')"><span class="glyphicon glyphicon-minus"></span> ลบ</button></div><div><br></div></div>';
    $(newkeepdata).appendTo('#frmname');
    //$('#num_plan'+row).val(++num_plan);
}

$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);

</script>
</body>
</html>