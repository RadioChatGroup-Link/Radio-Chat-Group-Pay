<?php 
require_once('../shepay/common.php');
$alipay_config['partner'] = $conf['reg_pid'];
$alipay_config['key'] = $DB->query("SELECT `key` FROM `pay_user` WHERE `id`='{$conf['reg_pid']}' limit 1")->fetchColumn();
require_once("./epay_notify.class.php");

@header('Content-Type: text/html; charset=UTF-8');

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {
	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];

    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		$srow=$DB->query("SELECT * FROM pay_regcode WHERE trade_no='{$trade_no}' limit 1")->fetch();
		$array = explode('|',$srow['data']);
		$type = addslashes($array[0]);
		$account = addslashes($array[1]);
		$username = addslashes($array[2]);
		$url = addslashes($array[3]);
		$tgid = addslashes($array[5]);
		if($srow['type']==1){
			$phone = addslashes($srow['email']);
			$email = addslashes($array[4]);
		}else{
			$email = addslashes($srow['email']);
		}
		if($srow['status']==0){
			$DB->exec("update `pay_regcode` set `status` ='1' where `id`='{$srow['id']}'");
			$key = random(32);
			$sds=$DB->exec("INSERT INTO `pay_user` (`key`, `account`, `username`, `money`, `url`, `email`, `phone`, `settle_id`, `addtime`, `type`, `active`) VALUES ('{$key}', '{$account}', '{$username}', '0', '{$url}', '{$email}', '{$phone}', '{$type}', '{$date}', '0', '1')");
			$pid=$DB->lastInsertId();
			if($sds){
		    //都潮汇推广返利模块          
            if(!empty($tgid)){	
                $sj=$conf['tgye'];//增加规定的余额
                $user_query=$DB->query("select money from pay_user where id=$tgid limit 1")->fetch();				
                $money=$user_query['money']+$sj;
                $abc=$DB->exec("UPDATE `pay_user` SET `money`='$money' WHERE `id`='$tgid'");
                $sj1='1';//增加推广人数
                $user_query1=$DB->query("select tgrs from pay_user where id=$tgid limit 1")->fetch();				
                $tgrs=$user_query1['tgrs']+$sj1; 
                $abc1=$DB->exec("UPDATE `pay_user` SET `tgrs`='$tgrs' WHERE `id`='$tgid'");
				$sj2=$conf['tgye'];//统计返利金额
                $user_query2=$DB->query("select gjfl from pay_user where id=$tgid limit 1")->fetch();				
                $gjfl=$user_query2['gjfl']+$sj2; 
                $abc2=$DB->exec("UPDATE `pay_user` SET `gjfl`='$gjfl' WHERE `id`='$tgid'");
                 }
				$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
				$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
				$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath.'/';
				$sub = $conf['web_name'].' - 注册成功通知';
				$msg = '<h2>商户注册成功通知</h2>感谢您注册'.$conf['web_name'].'！<br/>您的商户ID：'.$pid.'<br/>您的商户秘钥：'.$key.'<br/>'.$conf['web_name'].'官网：<a href="http://'.$_SERVER['HTTP_HOST'].'/" target="_blank">'.$_SERVER['HTTP_HOST'].'</a><br/>【<a href="'.$siteurl.'" target="_blank">商户管理后台</a>】';
				$result = send_mail($email, $sub, $msg);
			}else{
				sysmsg('申请商户失败！'.$DB->errorCode());
			}
		}else{
			$row=$DB->query("SELECT * FROM pay_user WHERE account='$account' and email='$email' order by id desc limit 1")->fetch();
			if($row){
				$pid = $row['id'];
				$key = $row['key'];
			}else{
				sysmsg('申请商户失败！');
			}
		}
    }
}
else {
    sysmsg('签名校验失败！');
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
		name="viewport">
		<meta content="auth.ooeecc.cn,<?php echo $conf['web_name']?>,都潮汇系统-最专业的易支付系统"
		name="description" />
		<meta name="author" content="auth.ooeecc.cn" />
		<title>
			申请商户成功 |
			<?php echo $conf[ 'web_name']?>
		</title>
		<link href="//shepay.ayunx.com/user/css/app.min.css" rel="stylesheet"
		type="text/css">
	</head>
	<body class="authentication-bg">
		<div class="account-pages mt-5 mb-5">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-5">
						<div class="card">
							<!-- Logo -->
							<div class="card-header pt-4 pb-4 text-center bg-primary">
								<span>
									<font color="white" size="5">
										<b>
											<?php echo $conf[ 'web_name']?>
										</b>
									</font>
								</span>
							</div>
							<div class="card-body p-4">
								<div class="text-center w-75 m-auto">
									<h4 class="text-dark-50 text-center mt-0 font-weight-bold">
										申请商户成功！
									</h4>
								</div>
								<form name="form" method="post" action="login.php">
									<div class="form-group">
										<label for="emailaddress">
											以下为您的商户信息：
										</label>
										<label>
											商户ID：
										</label>
										<input class="form-control" type="text" name="pid" value="<?php echo $pid?>">
									</div>
									<div class="form-group">
										<label>
											商户密钥：
										</label>
										<input class="form-control" type="text" name="key" value="<?php echo $key?>">
									</div>
									<div class="form-group mb-0 text-center">
										<button class="btn btn-primary" type="submit" id="submit" ng-click="login()"
										ng-disabled="form.$invalid">
											返回登录
										</button>
									</div>
								</form>
							</div>
							<!-- end card -->
							<div class="row mt-3">
								<div class="col-12 text-center">
									<p class="text-muted">
										商户信息已经发送到您的邮箱中
									</p>
								</div>
								<!-- end col-->
							</div>
							<!-- end row -->
						</div>
						<!-- end col -->
					</div>
					<!-- end row -->
				</div>
				<!-- end container -->
			</div>
		</div>
		<!-- end page -->
		<footer class="footer footer-alt" style="text-transform: uppercase;">
			Copyright &copy; 2016-
			<?=date( 'Y')?>
				<?php echo $conf[ 'web_name']?>
					-
					<?php echo $_SERVER[ 'SERVER_NAME']?>
		</footer>
		<script src="//shepay.ayunx.com/admin/js/app.min.js"></script>
		<script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	</body>
</html>