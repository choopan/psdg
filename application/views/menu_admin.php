        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href=""><img style="max-width:90px; margin-top: -7px;" src="<?php echo base_url(); ?>images/logo.png"> ระบบข้อมูลสารสนเทศเพื่อการบริหารงานยุทธศาสตร์ของกระทรวงการต่างประเทศ</a>
            </div>
            <!-- /.navbar-header -->


            <ul class="nav navbar-top-links navbar-right">
				ผู้ใช้งาน :  <strong><?php echo $this->session->userdata('sessfirstname')." ".$this->session->userdata('sesslastname'); ?></strong>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo site_url("main/changepass"); ?>"><i class="fa fa-gear fa-fw"></i> เปลี่ยนรหัสผ่าน</a>
                        </li>
						<!--
						<li><a href="<?php echo site_url("main/changeyear"); ?>"><i class="fa fa-gear fa-fw"></i> เปลี่ยนปีงบประมาณ</a>
                        </li>
						-->
                        <li class="divider"></li>
                        <li><a href="<?php echo site_url("main/logout"); ?>"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
                        </li>
                    </ul>

                </li>

            </ul>


            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">

                        </li>
                        <li>
                            <a href="<?php echo site_url("main"); ?>"><i class="fa fa-dashboard fa-fw"></i> หน้าแรก (MENU ADMIN)</a>
                        </li>
						<li>
                            <a href="<?php echo site_url("main/changeyear"); ?>"><i class="fa fa-calendar fa-fw"></i> ปีงบประมาณ <strong><u><?php echo $this->session->userdata('sessyear'); ?></u></strong></a>
                        </li>
                        
                        
                        <li>
                            <a href=""><i class="fa fa-bar-chart-o fa-fw"></i> จัดการข้อมูล <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo site_url("manageuser/user_view"); ?>">จัดการผู้ใช้งาน</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("manageuser/department_view"); ?>">จัดการกรม</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("manageuser/division_view"); ?>">จัดการกอง</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("manageuser/position_view"); ?>">จัดการตำแหน่ง</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("person_evaluation/manageEvalRound"); ?>">จัดการรอบการประเมิน</a>
                                </li>

                            </ul>
                           
                        </li>
                        
                        
				       <li>
                            <a href=""><i class="fa fa-bar-chart-o fa-fw"></i> แบบประเมินสมรรณะ<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo site_url("core_competency/manageSkill"); ?>">จัดการชื่อสมรรณะ</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("core_competency/manageCoreSet"); ?>">จัดการชุุดประเมินสมรรณะ</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("core_competency/assignCoreSetIndex"); ?>">กำหนดชุุดประเมินสมรรณะ</a>
                                </li>								
                            </ul>
                        </li>
						                        
  
				
						<li>
                            <a href=""><i class="fa fa-bar-chart-o fa-fw"></i> กำหนดตัวชี้วัด<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo site_url("manageindicator/addIndicatorMinister"); ?>">ระดับกระทรวง</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("manageindicator/addDepartment"); ?>">ระดับกรม</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("manageindicator/addKong"); ?>">ระดับกอง</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("manageindicator/addPerson"); ?>">ระดับบุคคล</a>
                                </li>
                            </ul>
                        </li>
						<li>
                            <a href=""><i class="fa fa-bar-chart-o fa-fw"></i> แสดงตัวชี้วัด<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo site_url("manageindicator/showMinister"); ?>">ระดับกระทรวง</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("manageindicator/showDepartment"); ?>">ระดับกรม</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("manageindicator/showKong"); ?>">ระดับกอง</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("manageindicator/showPerson"); ?>">ระดับบุคคล</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("manageindicator/viewindicator_person/".$this->session->userdata('sessid')); ?>">ผู้ใช้งาน</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href=""><i class="fa fa-bar-chart-o fa-fw"></i> คำรับรองการปฏิบัติราชการ<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo site_url("managewarranty/department"); ?>">ระดับกรม</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("managewarranty/division"); ?>">ระดับกอง</a>
                                </li>
                            </ul>
                        </li>

                        
                        <li>
                            <a href=""><i class="fa fa-bar-chart-o fa-fw"></i> รายงานปฏิบัติราชการระดับบุคคล<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                
                                	<li><a href="<?php echo site_url("person_evaluation/minManagePersonIndicator"); ?>">แสดงตัวชี้วัดรายบุคคล</a></li>
                                	<li><a href="<?php echo site_url("person_evaluation/minManagePersonEvaluation"); ?>">แสดงรายงานผลปฏิบัติการ</a></li>									
                            </ul>
                        </li>
                        
                 
                    </ul>
                </div>
            </div>  
        </nav>