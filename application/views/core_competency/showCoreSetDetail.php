<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Remote file for Bootstrap Modal</title>  
</head>
<body>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">ชื่อแบบประเมินสมรรณะ : <?php echo $coreSetName[0]['name']; ?></h4>
            </div>            <!-- /modal-header -->
            <div class="modal-body">
  				<table class="table table-striped table-bordered table-hover">
                	<thead>
                    	<tr>
                        	<th>สมรรณะ</th>
							<th>คะแนนที่คาดหวัง</th>
                        </tr>
                    </thead>
					<tbody>
					<?php 
						if(is_array($skillAndExVals) && count($skillAndExVals)) {
							foreach($skillAndExVals as $se) {
					?>								
						<tr><td><?php echo $se['name']; ?></td><td><?php echo $se['expectVal']; ?></td></tr>
					<?php   }
						}
					?>												
					</tbody>
				</table>

            </div>            <!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>            <!-- /modal-footer -->
</body>
</html>