<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Remote file for Bootstrap Modal</title>  
</head>
<body>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">แก้ไขภารกิจตามตัวชี้วัด </h4>                 
    </div>            <!-- /modal-header -->
    <form class="form-inline" role="form"  action="<?php echo site_url('person_evaluation/editActivityInfo/'.$activity['ID'].'/'.$pid); ?>" method="POST">            														
    <div class="modal-body">    
    	<div class="form-group">
        	<label  for="">ตัวชี้วัด : </label>
				<select class="form-control" name="indicator">
					<?php foreach($indicators as $ind) { 
							if($ind['ID'] == $activity['person_indicator_detail_id']) {
					?>
								<option value="<?php echo $ind['ID']; ?>" SELECTED><?php echo "ตัวชี้วัดที่ ".$ind['order']." : ".$ind['name']; ?></option>
					<?php	}
							else {
					?>
								<option value="<?php echo $ind['ID']; ?>"><?php echo "ตัวชี้วัดที่ ".$ind['order']." : ".$ind['name']; ?></option>
					<?php			
							}	
					?> 
						
            		<?php } ?>
				</select>
		</div>		
        <BR><BR>
            														            														
        <div class="form-group">
        	<label  for="">ลำดับที่ : </label>
            <input type="text" class="form-control" name="order" style="width: 50px" value="<?php echo $activity['order']; ?>" required>
        </div>		
        <div class="form-group">            																
        	<label for="">วันที่ :</label>
        	<input type="text" class="form-control" name="activity_date" style="width: 250px" value="<?php echo $activity['activity_date']; ?>" required>
        </div>
        <BR><BR>            																	
        <div class="form-group">            																
        	<label for="">ภารกิจสำคัญที่ได้ดำเนินการ :</label>
            <input type="text" class="form-control" name="activity_name" style="width: 500px" value="<?php echo $activity['activity_name']; ?>" required>
		</div>            																	
        <BR><BR>
        <div class="form-group">            																
        	<label for="">ผลการปฏิบัติงาน :</label>
            <input type="text" class="form-control" name="score" style="width: 100px" value="<?php echo $activity['selfscore']; ?>" >
		</div>            																	
        <div class="form-group">            																
        	<label for="">หลักฐาน (ชื่อเอกสาร):</label>
            <input type="text" class="form-control" name="document_name" style="width: 280px" value="<?php echo $activity['document_name']; ?>" >
		</div>            																	            													
  	</div>            <!-- /modal-body -->
    <div class="modal-footer">
    	<button type="submit" class="btn btn-primary">บันทึกผลการดำเนินงาน</button>&nbsp;&nbsp;
        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ปิด</button>
    </div>            <!-- /modal-footer -->
    </form>
</body>
</html>