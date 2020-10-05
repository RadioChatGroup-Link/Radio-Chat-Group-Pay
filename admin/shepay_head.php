<?php
$baidu="12345678";
	include("../shepay/common.php");
	if($islogin==1){}else exit("<script language='javascript'>window.location.href='./shepay_login.php';</script>");
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8" />
        <title><?=$title?>-<?=$conf['web_name']?>-本站骄傲的采用都潮汇系统</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content=<?=$title?> name="description" />
        <meta content=<?=$title?> name="author" />
        <!-- App css -->
        <!-- build:css -->
		<link href="//shepay.ayunx.com/admin/css/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
		<link href="//shepay.ayunx.com/admin/css/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
		<link href="//shepay.ayunx.com/admin/css/select.bootstrap4.css" rel="stylesheet" type="text/css" />
        <link href="//shepay.ayunx.com/admin/css/app.min.css" rel="stylesheet" type="text/css"/>
        <!-- endbuild -->
        <!-- Begin page -->
	</head>
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">
                <div class="slimscroll-menu">
                    <!-- LOGO -->
                    <a href="/" class="logo text-center mb-4">
                        <span class="logo-lg">
                            <font color='white' size=5><?php echo file_get_contents("https://shepay.me.ayunx.com/readme/admin-head-name.txt");?></font>
                        </span>
						<span class="logo-sm">
                            <font color='white' size=4>深海</font></font>
                        </span>
                    </a>
                    <!--- Sidemenu -->
                    <ul class="metismenu side-nav">
                        <li class="side-nav-item">
                            <a href="./index.php" class="side-nav-link">
                                <i class="dripicons-meter"></i>
                                <span><font color='white'>后台首页</font></span>
                                </a>
                                </li>
						           <li class="side-nav-item">
                                <a href="javascript: void(0);" class="side-nav-link">
                                <i class="dripicons-graph-bar"></i>
                                <span>商户管理</span>
                                <span class="menu-arrow"></span>
                                </a>
                                <ul class="side-nav-second-level" aria-expanded='false'>
                                <li><a href="shepay_ulist.php?my=add"> 添加商户</a></li>
                                <li><a href="shepay_plist.php?my=add"> 添加合作者</a></li>
							   	    <li><a href="shepay_ulist.php"> 商户列表</a></li>
								    <li><a href="shepay_plist.php"> 合作者列表</a></li>
                                </ul>
                                </li>  
                                <li class="side-nav-item">
                                <a href="javascript: void(0);" class="side-nav-link">
                                <i class="dripicons-document"></i>
                                <span>资金管理</span>
                                <span class="menu-arrow"></span>
                                </a>
                                <ul class="side-nav-second-level" aria-expanded="false">
                                <li><a href="shepay_order.php"> 订单明细</a></li>
								    <li><a href="shepay_settle.php">结算操作</a></li>
			                      <li><a href="shepay_slist.php">结算列表</a></li>
                                </ul>
                                </li>
                                <li class="side-nav-item">
                                <a href="javascript: void(0);" class="side-nav-link">
                                <i class="dripicons-list"></i>
                                <span>所有设置</span>
                                <span class="menu-arrow"></span>
                                </a>
                                <ul class="side-nav-second-level" aria-expanded="false">
                                <li class="side-nav-item">
                                <a href="javascript: void(0);" class="side-nav-link">
                                <i class="dripicons-article"></i>
                                <span>系统</span>
                                <span class="menu-arrow"></span>
                                </a>
                                <ul class="side-nav-second-level" aria-expanded="false">
                                <li>
									 <li><a href="shepay_webset.php">站点信息配置</a></li>
                                <li><a href="shepay_jkset.php">系统监控配置</a></li>
              <li><a href="shepay_agreement.php">服务条款配置</a></li>
              <li><a href="shepay_gg.php">用户公告配置</a></li>
              <li><a href="shepay_mqkf.php">美洽客服配置</a></li>
              <li><a href="shepay_jcb.php">集成文件配置</a></li>
              <li><a href="shepay_splj.php">商品拦截配置</a></li>
              <li><a href="shepay_shdl.php">商户登录配置</a></li>
              <li><a href="shepay_sqsh.php">商户申请配置</a></li>
              <li><a href="shepay_ylfl.php">盈利费率配置</a></li>
              <li><a href="shepay_dxyx.php">短信邮箱配置</a></li>
              <li><a href="shepay_update.php">检查版本更新</a></li>
                            </ul>
                        </li>
                        <li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="dripicons-folder-open"></i>
                                <span>接口</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li>
            <li><a href="shepay_sytset.php">收银台页面配置</a></li>
            <li><a href="shepay_tdset.php">支付接口通道配置</a></li>
              <li><a href="shepay_gfjk.php">官方支付接口配置</a></li>
              <li><a href="shepay_mzfset.php">码支付接口配置</a></li>
              <li><a href="shepay_yzf.php">易支付接口配置</a>
              </ul>
                        </li>
<li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="dripicons-rocket"></i>
                                <span>安全</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="side-nav-second-level" aria-expanded="false">
          <li><a href="shepay_dljl.php"></span> 登录记录查询</a></li>
		  <li><a href="shepay_ht_link.php"></span>后台路径修改</a></li>
          <li><a href="shepay_adminset.php"></span>管理员账号配置</a></li>
		  <li><a href="shepay_cc.php"></span>CC防护模块配置</a></li>
                            </ul>
                        </li>
						                  <li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="dripicons-copy"></i>
                                <span>外观</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li><a href="shepay_template.php">首页模板配置</a></li>
                                <li><a href="shepay_logo.php">站点Logo配置</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- AD Box -->
                    <div class="help-box text-center text-white" id='ad_box'>
                        <h5 class="mt-3">温馨提醒</h5>
                        <p class="mb-3">本版本都潮汇系统不允许修改后台路径，否则后果自负！另外，都潮汇系统需要监控后才能够实时统计款项及对接自动补单，请务必完成监控配置！</p>
                        <a href="shepay_jkset.php" class="btn btn-outline-light btn-sm">监控配置</a>
                    </div>
                    <!-- end AD Box -->
                    <!-- End Sidebar -->
                    <div class="clearfix"></div>
                </div>
                <!-- Sidebar -left -->
            </div>
            <!-- Left Sidebar End -->
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <div class="content">

                    <!-- Topbar Start -->
                    <div class="navbar-custom">
                        <ul class="list-unstyled topbar-right-menu float-right mb-1">
                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="javascript: void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="mdi mdi-bell noti-icon"></i>
                                    <span class="badge badge-danger noti-icon-badge">5</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg">
                                    <!-- 公告-->
                                    <?php echo file_get_contents("https://shepay.me.ayunx.com/readme/admin-head-gonggao.txt");?>
                            </li>
                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="" role="button" aria-haspopup="false"
                                    aria-expanded="false">
                                    <img src="//q4.qlogo.cn/headimg_dl?dst_uin=<?=$conf['web_qq']?>&amp;spec=100" alt="Avatar" width="50" height="50"   class="rounded">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                                    <!-- item-->
                                    <div class=" dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">欢迎使用都潮汇系统</h6>
                                    </div>
                                    <!-- item-->
                                    <a href="shepay_adminset.php" class="dropdown-item notify-item">
                                        <i class="mdi mdi-account-circle"></i>
                                        <span>账号配置</span>
                                    </a>
                                    <!-- item-->
                                    <a href="" class="dropdown-item notify-item" data-toggle="modal" data-target="#tips_help">
                                        <i class="mdi mdi-lifebuoy"></i>
                                        <span>更新轨迹</span>
                                    </a>
                                    <!-- item-->
                                    <a href="./shepay_login.php?logout=" class="dropdown-item notify-item">
                                        <i class="mdi mdi-logout"></i>
                                        <span>退出登陆</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <div class="app-search">
                            <font size=4><font color='dodgerblue'><?=$title?></font>-<font color="orange"><?=$conf['web_name']?>-本站骄傲的采用都潮汇系统</font>-欢迎回家</font>
                        </div>
                        <button class="button-menu-mobile open-left disable-btn">
                            <i class="mdi mdi-menu" ></i>
                        </button>
                    </div>
                    <!-- end Topbar -->
                    <!-- Start Content-->
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <br>
								<br>
                            </div>
                        </div>     
                        <!-- end page title --> 
					<div id="tips_help" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">系统简介</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
              <?php echo file_get_contents("https://shepay.me.ayunx.com/readme/admin-head-banben.txt");?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">关闭</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
					<script src="//shepay.ayunx.com/admin/js/app.min.js"></script>
					<script src="//shepay.ayunx.com/admin/js/Chart.bundle.js"></script>
					<script src="//shepay.ayunx.com/admin/js/jquery-jvectormap-1.2.2.min.js"></script>
					<script src="//shepay.ayunx.com/admin/js/jquery-jvectormap-world-mill-en.js"></script>
        <!-- third party js ends -->