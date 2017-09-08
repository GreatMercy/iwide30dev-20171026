<div style="padding-top:52px;"></div>
<header class="main-header">
<!-- Logo -->
    <a href="<?php echo EA_const_url::inst()->get_default_admin(); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">iwide</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><?php echo CORP_NAME; ?></b>v<?php echo VERSION; ?></span>
    </a>
    
<!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="javascript:void();" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">菜单隐藏</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

<!-- Messages: style can be found in dropdown.less 
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope-o"></i> <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
						<li class="header">You have 4 messages</li>
						<li>
							<ul class="menu">
								<li> 
									<a href="#">
										<div class="pull-left">
											<img src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
										</div>
										<h4>
											Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small>
										</h4>
										<p>Why not buy a new awesome theme?</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="footer"><a href="#">See All Messages</a></li>
					</ul>
                </li> -->
                
<!-- Notifications: style can be found in dropdown.less  -->
                <li class="dropdown notifications-menu" id="top_alter_order" rel="top_alter_order">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bell-o"></i> <span class="label "></span>
						<!--<i class="fa fa-bell-o"></i> <span class="label label-danger">10</span>-->
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"></li>
                        <li>
							<ul class="menu"> </ul>
                        </li>
                        <li class="footer"><a href="#" >更多</a></li>
                    </ul>
                </li>
                
    <!-- Tasks: style can be found in dropdown.less
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bullhorn"></i> <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
							<ul class="menu">
								<li> 
									<a href="#">
										<h3>
											Design some buttons <small class="pull-right">20%</small>
										</h3>
										<div class="progress xs">
											<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
											  <span class="sr-only">20% Complete</span>
											</div>
										</div>
									</a>
								</li>
							</ul>
                        </li>
                        <li class="footer">
							<a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>  -->

<!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="javascript:void();" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/dist/img/iwide_logo.png" class="user-image" alt="User Image">
                        <span class="hidden-xs">您好，<b><?php echo $profile['nickname']; ?></b></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo base_url(FD_PUBLIC). '/'. $tpl ?>/dist/img/iwide_logo.png" class="img-circle" alt="User Image">
                            <p><?php echo hide_string_prefix($profile['username'], 3); ?> - <?php echo isset($profile['role']['role_label'])? $profile['role']['role_label']: '商家用户'; ?>
                                <small>上次登录：<?php echo $profile['update_time']; ?></small>
                            </p>
                        </li>
                        <!-- Menu Body
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li> -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo EA_const_url::inst()->get_url('privilege/adminuser/profile') ?>" class="btn btn-default bg-green"><i class="fa fa-edit"></i> 编辑</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo EA_const_url::inst()->get_logout_admin() ?>" class="btn btn-default bg-red"><i class="fa fa-sign-out"></i> 退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
                
<!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
            
        </div>
    </nav>
</header>


