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
                            <a href="<?php echo site_url("main"); ?>"><i class="fa fa-dashboard fa-fw"></i> หน้าแรก (MENU INDICATOR)</a>
                        </li>
						<li>
                            <a href="<?php echo site_url("main/changeyear"); ?>"><i class="fa fa-calendar fa-fw"></i> ปีงบประมาณ <strong><u><?php echo $this->session->userdata('sessyear'); ?></u></strong></a>
                        </li>
                        
                        <?php	if($this->session->userdata('sessadmin_min') == 1) { ?>
                        <li>
                            <a href=""><i class="fa fa-bar-chart-o fa-fw"></i> ผู้ดูแลตัวชี้วัด <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo site_url("indicator_admin/minister_view"); ?>">แสดงระดับกระทรวง</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("indicator_admin/department_view"); ?>">แสดงระดับกรม</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("indicator_admin/division_view"); ?>">แสดงระดับกอง</a>
                                </li>
                            </ul>
                           
                        </li>
                        <?php } ?>
                                                
  
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
                                    <a href="<?php echo site_url("manageindicator/addDivision"); ?>">ระดับกอง</a>
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
                            <a href=""><i class="fa fa-bar-chart-o fa-fw"></i> ผลการปฏิบัติการตามตัวชี้วัด<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo site_url("reportplan/minister"); ?>">ระดับกระทรวง</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("reportplan/department"); ?>">ระดับกรม</a>
                                </li>
								<li>
                                    <a href="<?php echo site_url("reportplan/division"); ?>">ระดับกอง</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="fa fa-bar-chart-o fa-fw"></i> รายงานปฏิบัติราชการระดับบุคคล<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="<?php echo site_url("person_evaluation/managePersonIndicator"); ?>">กำหนดตัวชี้วัด</a></li>
                                <li><a href="<?php echo site_url("person_evaluation/managePersonEvaluation"); ?>">รายงานผลการปฏิบัติการ </a></li>
                                
								<?php   if ($this->session->userdata('sessadmin_min') == 1) { ?>
                                	<li><a href="<?php echo site_url("person_evaluation/minManagePersonIndicator"); ?>">แสดงตัวชี้วัดรายบุคคล</a></li>
                                	<li><a href="<?php echo site_url("person_evaluation/minManagePersonEvaluation"); ?>">แสดงรายงานผลปฏิบัติการ</a></li>									
								<?php   } elseif($this->session->userdata('sessexecdiv') == 1) { ?>
                                	<li><a href="<?php echo site_url("person_evaluation/divManagePersonIndicator"); ?>">แสดงตัวชี้วัดรายบุคคล</a></li>
                                	<li><a href="<?php echo site_url("person_evaluation/divManagePersonEvaluation"); ?>">แสดงรายงานผลปฏิบัติการ</a></li>
                                <?php   } elseif($this->session->userdata('sessexecdep') == 1) { ?>
                                	<li><a href="<?php echo site_url("person_evaluation/depManagePersonIndicator"); ?>">แสดงตัวชี้วัดรายบุคคล</a></li>
                                	<li><a href="<?php echo site_url("person_evaluation/depManagePersonEvaluation"); ?>">แสดงรายงานผลปฏิบัติการ</a></li>
                                <?php   } ?>
                                

                            </ul>
                        </li>
                        
                 
                    </ul>
                </div>
            </div>  
        </nav>