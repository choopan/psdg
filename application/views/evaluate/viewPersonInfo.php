 <div class="panel panel-default">
	<div class="panel-heading"><strong>ข้อมูลเบื้องต้น</strong></div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-5">
				<strong>ชื่อ-นามสกุล :</strong> <?php echo $user['PWFNAME']." ".$user['PWLNAME']; ?>
			</div>
			<div class="col-lg-5">						
				<strong>ตำแหน่ง : </strong> <?php echo $user['position'] ." (ระดับ ". $user['PWLEVEL'] . ")"; ?>
			</div>	
		</div>
		
		<div class="row">
			<div class="col-lg-5">
				<strong>สังกัด :</strong> <?php echo $user['depname']; ?>
			</div>
			<div class="col-lg-5">
				<strong>หน่วยงาน :</strong> <?php echo $user['divname']; ?>
			</div>
		</div>
	</div>
</div>
