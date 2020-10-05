<?php
$mod='blank';
include("../shepay/common.php");
$title='管理首页';
include './shepay_head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./shepay_login.php';</script>");
?>
<?php
$count1=$DB->query("SELECT count(*) from pay_order")->fetchColumn();
$count2=$DB->query("SELECT count(*) from pay_user")->fetchColumn();
$data=unserialize(file_get_contents(SYSTEM_ROOT.'db.txt'));
$mysqlversion=$DB->query("select VERSION()")->fetch();
if($_SESSION['connet']!=true){
	if(file_get_contents('http://auth.ooeecc.cn')){//服务器系统
		$connect='<font color="green">连接正常</font> <a href="http://auth.ooeecc.cn/" class="btn btn-xs btn-info">点此访问授权站</a>';
		$_SESSION['connet']==true;//防止过多访问造成卡顿
	}else{
		$connect='<font color="red">连接失败</font> <a href="http://auth.ooeecc.cn/" class="btn btn-xs btn-info">点此访问授权站</a>';
		$_SESSION['connet']==true;//防止过多访问造成卡顿 直接结束
	}
}
if($_SESSION['connet']!=true){
	if(file_get_contents('https://shepay.me.ayunx.com')){//服务器系统
		$connect2='<font color="green">连接正常</font> <a href="https://shepay.me.ayunx.com/" class="btn btn-xs btn-info">点此访问主控站</a>';
		$_SESSION['connet']==true;//防止过多访问造成卡顿
	}else{
		$connect2='<font color="red">连接失败</font> <a href="https://shepay.me.ayunx.com/" class="btn btn-xs btn-info">点此访问主控站</a>';
		$_SESSION['connet']==true;//防止过多访问造成卡顿 直接结束
	}
}
if($_SESSION['connet']!=true){
	if(file_get_contents('https://shepay.ayunx.com/')){//服务器系统
		$connect3='<font color="green">连接正常</font> <a href="https://shepay.ayunx.com/" class="btn btn-xs btn-info">点此访问依赖站</a>';
		$_SESSION['connet']==true;//防止过多访问造成卡顿
	}else{
		$connect3='<font color="red">连接失败</font> <a href="https://shepay.ayunx.com/" class="btn btn-xs btn-info">点此访问依赖站</a>';
		$_SESSION['connet']==true;//防止过多访问造成卡顿 直接结束
	}
}
if($_SESSION['update']!=true){
	$update=file_get_contents('http://auth.ooeecc.cn/api/check.php?url='.$_SERVER['HTTP_HOST']."&authcode=".$authcode."&ver=".$ver."&dbver=".$dbver);//获得json返回信息
	$url='http://auth.ooeecc.cn/api/check.php?url='.$_SERVER['HTTP_HOST']."&authcode=".$authcode."&ver=".$ver."&dbver=".$dbver;
	$query=json_decode($update,true);//json解析
	if($query['code']=='1'){//有新版本
		$up='<font color="red">都潮汇系统有新版本哟！ <a href="./shepay_update.php?act=set-update&do=do">点我更新</a></font>';
		$_SESSION['update']==true;//防止过多访问造成卡顿 有新版本
	}elseif($query['code']=='0'){
		$up='<font color="green">站点当前使用的已是都潮汇系统最新版本！</font>';
		$_SESSION['update']==true;//防止过多访问造成卡顿 直接结束
	}elseif($query['code']=='-1'){
		$up='很抱歉，盗版无法更新，后门定时植入，如需正式运营请尽快前往都潮汇系统授权站购买授权！';
		$_SESSION['update']==true;//防止过多访问造成卡顿 直接结束
	}elseif($query['code']=='2'){
		$up='<font color="blue">都潮汇系统授权站无法连接，请稍后重试！</font>';
		$_SESSION['update']==true;//防止过多访问造成卡顿 直接结束
	}
}
?>
<link href="//shepay.ayunx.com/admin/css/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="//shepay.ayunx.com/admin/css/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="//shepay.ayunx.com/admin/css/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="//shepay.ayunx.com/admin/css/select.bootstrap4.css" rel="stylesheet" type="text/css" />
<script src="//shepay.ayunx.com/admin/js/demo.datatable-init.js"></script>
<!-- end demo js-->
<script src="//shepay.ayunx.com/admin/js/jquery.dataTables.js"></script>
<script src="//shepay.ayunx.com/admin/js/dataTables.bootstrap4.js"></script>
<script src="https://shepay.me.ayunx.com/readme/ajax/index.js"></script>
<div id='nmuber' class="row">
	<div class="col-xl-12">
		<div class="row">
			<div class="col-lg-3 col-sm-6 col-xs-6">
				<div class="card widget-flat">
					<div class="card-body">
						<div class="float-right">
							<i class="mdi mdi-currency-usd widget-icon"></i>
						</div>
						<h5 class="text-muted font-weight-normal mt-0" title="">总计流水</h5>
						<h3 class="mt-3 mb-3"><font color='darkorange'><?php echo $data['usermoney']?>元</font></h3>
						<p class="mb-0 text-muted">
							<span class="text-nowrap"><font color='orange'>截止：<?=$date?></font></span>
						</p>
					</div> <!-- end card-body-->
				</div> <!-- end card-->
			</div> <!-- end col-->  			

			<div class="col-lg-3 col-sm-6 col-xs-6">
				<div class="card widget-flat">
					<div class="card-body">
						<div class="float-right">
							<i class="mdi mdi-account-multiple widget-icon"></i>
						</div>
						<h5 class="text-muted font-weight-normal mt-0" title="">商户数量</h5>
						<h3 class="mt-3 mb-3"><font color='red'><?php echo $count2?>个</font></h3>
						<p class="mb-0 text-muted">
							<span class="text-nowrap"><font color='orange'>截止：<?=$date?></font></span>
						</p>
					</div> <!-- end card-body-->
				</div> <!-- end card-->
			</div> <!-- end col-->

			<div class="col-lg-3 col-sm-6 col-xs-6">
				<div class="card widget-flat">
					<div class="card-body">
						<div class="float-right">
							<i class="mdi mdi-cart-plus widget-icon"></i>
						</div>
						<h5 class="text-muted font-weight-normal mt-0" title="">订单总数</h5>
						<h3 class="mt-3 mb-3"><font color='blue'><?php echo $count1?>条</font></h3>
						<p class="mb-0 text-muted">
							<span class="text-nowrap"><font color='orange'>截止：<?=$date?></font></span>
						</p>
					</div> <!-- end card-body-->
				</div> <!-- end card-->
			</div> <!-- end col-->
			
			<div class="col-lg-3 col-sm-6 col-xs-6">
				<div class="card widget-flat">
					<div class="card-body">
						<div class="float-right">
							<i class="mdi mdi-pulse widget-icon"></i>
						</div>
						<h5 class="text-muted font-weight-normal mt-0" title="">结算余额</h5>
						<h3 class="mt-3 mb-3"><font color='purple'><?php echo $data['settlemoney']?>元</font></h3>
						<p class="mb-0 text-muted">
							<span class="text-nowrap"><font color='orange'>截止：<?=$date?></font></span>
						</p>
					</div> <!-- end card-body-->
				</div> <!-- end card-->
			</div> <!-- end col-->
			
			<div class="col-lg-12 col-sm-12 col-xs-12">
			 <div class="card card-primary">
			 <div class="card-header">
			<h3 class="panel-title">支付通道订单明细</h3> </div>
			<div class="card-bodyassr">
        <table class="table table-striped">
		    <thead><tr><th class="success">订单收入统计</th><th>支付宝</th><th>微信支付</th><th>QQ钱包</th><th>财付通</th><th>总计</th></thead><tbody>
			  <tr><td>今日</td><td><?php echo round($data['order_today']['alipay'],2)?></td><td><?php echo round($data['order_today']['wxpay'],2)?></td><td><?php echo round($data['order_today']['qqpay'],2)?></td><td><?php echo round($data['order_today']['tenpay'],2)?></td><td><?php echo round($data['order_today']['all'],2)?></td></tr>
			  <tr><td>昨日</td><td><?php echo round($data['order_lastday']['alipay'],2)?></td><td><?php echo round($data['order_lastday']['wxpay'],2)?></td><td><?php echo round($data['order_lastday']['qqpay'],2)?></td><td><?php echo round($data['order_lastday']['tenpay'],2)?></td><td><?php echo round($data['order_lastday']['all'],2)?></table>
			  </div> <!-- end card-body-->
				</div> <!-- end card-->
			</div> <!-- end col-->  			
		
					  <div class="col-lg-6 col-sm-12 col-xs-6">
			 <div class="card card-primary">	
			
			 <div class="card-header">
			 	<h3 class='panel-title'>站点程序信息</font></h3></div>
			<div class="card-body">
							<?php echo file_get_contents("https://shepay.me.ayunx.com/readme/admin-index-ggnew.txt");?>
							<li class='list-group-item'>
							<b>系统更新检测：</b><?php echo $up?>
					     	</li>
							<li class='list-group-item'>
							<b>深海授权服务器：</b><?php echo $connect?>
							</li>
							<li class='list-group-item'>
							<b>深海主控服务器：</b><?php echo $connect2?>
							</li>
							<li class='list-group-item'>
							<b>深海依赖服务器：</b><?php echo $connect3?>
							</li>
	</ul>
	 </div> <!-- end card-body-->
				</div> <!-- end card-->
			</div> <!-- end col-->  			

<div class="col-lg-6 col-sm-12 col-xs-6">
			  <div class="card card-primary">	
			 <div class="card-header">
				<h3 class="panel-title">站点服务器信息</font></h3></div>
				<div class="card-body">
	<ul class="list-group">
		<li class="list-group-item">
			<b>PHP 版本：</b><?php echo phpversion() ?>
			<?php if(ini_get('safe_mode')) { echo '线程安全'; } else { echo '非线程安全'; } ?>
		</li>
		<li class="list-group-item">
			<b>MySQL 版本：</b><?php echo $mysqlversion[0] ?>
		</li>
		<li class="list-group-item">
			<b>服务器软件：</b><?php echo $_SERVER['SERVER_SOFTWARE'] ?>
		</li>		
		<li class="list-group-item">
			<b>程序最大运行时间：</b><?php echo ini_get('max_execution_time') ?>s
		</li>
		<li class="list-group-item">
			<b>POST许可：</b><?php echo ini_get('post_max_size'); ?>
		</li>
		<li class="list-group-item">
			<b>文件上传许可：</b><?php echo ini_get('upload_max_filesize'); ?>
		</li>
					</ul>
				  </div> <!-- end card-body-->
				</div> <!-- end card-->
			</div> <!-- end col-->