<?php
@header('Content-Type: text/html; charset=UTF-8');
if($userrow['active']==0){
  sysmsg($conf['user_no']);
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
 <!-- 用户中心模板原创自都潮汇系统，盗版狗必死 -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no" />
 <meta name="author" content="AS" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
 <title><?php echo $title?> | <?php echo $conf['web_name']?></title>
 <link rel="stylesheet" href="//lib.baomitu.com/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
 <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
 <link rel="stylesheet" href="//shepay.ayunx.com/user/css/ready.css">
 <link rel="stylesheet" href="//shepay.ayunx.com/user/css/demo.css">
 <link rel="shortcut icon" href="<?php echo ($userrow['qq'])?'//q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$userrow['qq'].'&src_uin='.$userrow['qq'].'&fid='.$userrow['qq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'//shepay.ayunx.com/user/img/profile.jpg'?>" />
</head>
<body style="overflow-x:hidden;">
 <div class="wrapper">
  <div class="main-header">
   <div class="logo-header">
    <a href="index.php" class="logo"><?php echo $conf['web_name']?></a>
    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
   </div>
   <nav class="navbar navbar-header navbar-expand-lg">
    <div class="container-fluid">
     <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
      <li class="nav-item dropdown">
       <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false"> <img src="<?php echo ($userrow['qq'])?'//q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$userrow['qq'].'&src_uin='.$userrow['qq'].'&fid='.$userrow['qq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'//shepay.ayunx.com/user/img/profile.jpg'?>" alt="头像" width="36" class="img-circle"><span ><?php echo $pid?></span></a>
       <ul class="dropdown-menu dropdown-user">
        <li>
         <div class="user-box">
          <div class="u-img"><img src="<?php echo ($userrow['qq'])?'//q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$userrow['qq'].'&src_uin='.$userrow['qq'].'&fid='.$userrow['qq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'//shepay.ayunx.com/user/img/profile.jpg'?>" alt="头像"></div>
          <div class="u-text">
           <h4><?php echo $pid?></h4>
           <p class="text-muted"><?php echo $userrow['email']?></p><a href="userinfo.php" class="btn btn-rounded btn-danger btn-sm">朕的户籍</a>
          </div>
         </div>
        </li>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="login.php?logout"><i class="fa fa-power-off"></i>我滚还不行吗？</a>
       </ul>
      </li>
     </ul>
    </div>
   </nav>
  </div>
  <!-- 顶部栏结束 -->
  <div class="sidebar">
   <div class="scrollbar-inner sidebar-wrapper">
    <div class="user">
     <div class="photo">
      <img src="<?php echo ($userrow['qq'])?'//q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$userrow['qq'].'&src_uin='.$userrow['qq'].'&fid='.$userrow['qq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'//shepay.ayunx.com/user/img/profile.jpg'?>" alt="头像">
     </div>
     <div class="info">
      <a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
       <span><?php echo $pid?><span class="user-level"><?php echo $conf['web_name']?>感谢有您~</span><span class="caret"></span></span>
      </a>
      <div class="clearfix"></div>
      <div class="collapse in" id="collapseExample" aria-expanded="true" style="">
       <ul class="nav">
        <li>
         <a href="userinfo.php">
          <span class="link-collapse">朕的户籍</span>
         </a>
        </li>
        <li>
         <a href="login.php?logout">
          <span class="link-collapse">我滚还不行吗？</span>
         </a>
        </li>
       </ul>
      </div>
     </div>
    </div>
    <ul class="nav">
     <li class="nav-item">
      <a href="index.php">
       <i class="la la-dashboard"></i>
       <p>用户中心</p>
      </a>
     </li>
     <li class="nav-item">
      <a href="test.php">
       <i class="la la-hand-peace-o"></i>
       <p>在线测试</p>
      </a>
     </li>
     <li class="nav-item">
       <a href="order.php">
         <i class="la la-bar-chart"></i>
         <p>订单明细</p>
       </a>
     </li>
     <li class="nav-item">
       <a href="settle.php">
         <i class="la la-calculator"></i>
         <p>结算明细</p>
       </a>
     </li>
     <li class="nav-item">
       <a href="apply.php">
         <i class="la la-graduation-cap"></i>
         <p>手动结算</p>
       </a>
     </li>
	 <li class="nav-item">
       <a href="tglj.php">
         <i class="la la-lightbulb-o"></i>
         <p>推广返利</p>
       </a>
     </li>
     <li class="nav-item">
      <a href="<?php echo $conf['qun']?>" target="blank" onclick="return confirm('进群可获取平台最新信息，请在进群验证信息中填写您的商户ID，点击确定立即加群！')"><i class="la la-qq"></i>
       <p>商户群聊</p>
      </a>
     </li>
     <li class="nav-item">
       <a href="<?php echo $conf['hzlink1']?>" target="blank">
         <i class="la la-link"></i>
         <p><?php echo $conf['hzhb1']?></p>
       </a>
     </li>
     <li class="nav-item">
       <a href="<?php echo $conf['hzlink2']?>" target="blank">
         <i class="la la-link"></i>
         <p><?php echo $conf['hzhb2']?></p>
       </a>
     </li>
      <li class="nav-item update-pro">
        <button data-toggle="modal" data-target="#aswlcmgg"><i class="la la-hand-pointer-o"></i>
        <p>点我查看重要公告</p>
        </button>
      </li>
    </ul>
  </div>
</div>
</div>
 <div class="modal fade" id="aswlcmgg" tabindex="-1" role="dialog" aria-labelledby="aswlcm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
    <div class="modal-header bg-primary">
     <h6 class="modal-title"><i class="la la-frown-o"></i> 本站最新重要公告</h6>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body text-center">
     <p><?php echo $conf['tcgg']?></p>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-dismiss="modal">朕已阅</button>
    </div>
   </div>
  </div>
 </div>
 <!-- 侧边栏结束 -->