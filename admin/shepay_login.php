<?php
//php防注入和XSS攻击通用过滤. 
$_GET     && SafeFilter($_GET);
$_POST    && SafeFilter($_POST);
$_COOKIE  && SafeFilter($_COOKIE);
function SafeFilter (&$arr){
	$ra=Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/','/script/','/javascript/','/vbscript/','/expression/','/applet/','/meta/','/xml/','/blink/','/link/','/style/','/embed/','/object/','/frame/','/layer/','/title/','/bgsound/','/base/','/onload/','/onunload/','/onchange/','/onsubmit/','/onreset/','/onselect/','/onblur/','/onfocus/','/onabort/','/onkeydown/','/onkeypress/','/onkeyup/','/onclick/','/ondblclick/','/onmousedown/','/onmousemove/','/onmouseout/','/onmouseover/','/onmouseup/','/onunload/');
	if (is_array($arr)){
		foreach ($arr as $key => $value){
			if(!is_array($value)){
				if (!get_magic_quotes_gpc()){             //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
					$value=addslashes($value);           //给单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）加上反斜线转义
				}
				$value=preg_replace($ra,'',$value);     //删除非打印字符，粗暴式过滤xss可疑字符串
				$arr[$key]     = htmlentities(strip_tags($value)); //去除 HTML 和 PHP 标记并转换为 HTML 实体
			}else{
				SafeFilter($arr[$key]);
			}
		}
	}
}
?>
<?php
include("../shepay/common.php");
if(!isset($_SESSION['authcode'])) {
	$query=file_get_contents('http://auth.ooeecc.cn/api/check.php?url='.$_SERVER['HTTP_HOST'].'&authcode='.$authcode);
	if($query=json_decode($query,true)) {
	if($query['code']==1)$_SESSION['authcode']=true;
        else		echo("<script>alert('都潮汇系统提醒您：当前访问域名未授权！如果您已购买授权，请使用授权的域名登录后台，否则将会误认为盗版并入库；如果您还未购买授权，请在决定正式运营时前往都潮汇授权站购买授权，以保障您的合法权益，感谢您的支持！');</script>");
	}
}
@header('Content-Type: text/html; charset=UTF-8');
if(isset($_POST['user']) && isset($_POST['pass'])){
	if(!$_SESSION['pass_error'])$_SESSION['pass_error']=0;
	$user=daddslashes($_POST['user']);
	$pass=daddslashes($_POST['pass']);
    $code=daddslashes($_POST['code']);
    if (!$code || ($code != $_SESSION['vc_code'])) {
		unset($_SESSION['vc_code']);
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('Sorry，验证码错误，请重试！');history.go(-1);</script>");
	}elseif($_SESSION['pass_error']>5) {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('抱歉，用户名或密码不正确，请重试！');history.go(-1);</script>");
	}elseif($user==$conf['admin_user'] && $pass==$conf['admin_pwd']) {
		$DB->query("insert into `panel_log` (`uid`,`type`,`date`,`city`,`data`) values ('1','登录系统','".$date."','".$city."','IP:".$clientip."')");
		$session=md5($user.$pass.$password_hash);
		$token=authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
		setcookie("admin_token", $token, time() + 3600);
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('登录管理中心成功，欢迎使用都潮汇系统！');window.location.href='./';</script>");
	}elseif ($pass != $conf['admin_pwd']) {
		$_SESSION['pass_error']++;
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('抱歉，用户名或密码不正确，请重试！');history.go(-1);</script>");
	}
}elseif(isset($_GET['logout'])){
	setcookie("admin_token", "", time() - 3600);
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登录！');window.location.href='./shepay_login.php';</script>");
}elseif($islogin==1){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('都潮汇系统提醒您：您已登录管理中心，确认进入管理中心首页！');window.location.href='./index.php';</script>");
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8" />
    <title>
        <?=$conf['web_name']?>-本站骄傲的采用都潮汇系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?=$conf['web_name']?>-本站骄傲的采用都潮汇系统" name="description" />
    <meta content="m6e6.cn" name="author" />
    <!-- App css -->
    <!-- build:css -->
    <link href="//shepay.ayunx.com/admin/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- endbuild -->
</head>

<body class="authentication-bg">
    <div class="account-pages mt-4 mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header pt-3 pb-3 text-center bg-primary">
                            <span><font color="white" size=5><b><?php echo file_get_contents("https://shepay.me.ayunx.com/readme/admin-head-name.txt");?><b></font></span>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">登录</h4>
                                <p class="text-muted mb-4">请使用授权域名登录后台</p>
                            </div>
                            <form action="./shepay_login.php" method="post" class="form-horizontal" role="form">
                                <div class="form-group mb-3">
                                    <label for="emailaddress">账号</label>
                                    <input class="form-control" type="text" name="user" required="" placeholder="请输入账号">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">密码</label>
                                    <input class="form-control" type="password" required="" name="pass" placeholder="请输入密码">
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="code" placeholder="验证码" required><div class="input-group-append"><img src="../shepay/code.php?r=<?php echo time();?>"onclick="this.src='../shepay/code.php?r='+Math.random();" title="点击更换验证码"></div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin" required>
                                        <label class="custom-control-label" for="checkbox-signin"><a href="http://auth.ooeecc.cn/">同意使用都潮汇系统</a></label>
                                    </div>
                                </div>
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" type="submit"> 登录 </button>
                                    </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                    <p align="center">2016-
                        <?=date('Y')?> ©
                        <?=$conf['web_name']?> -
                        <?php echo file_get_contents("https://shepay.me.ayunx.com/readme/admin-head-name.txt");?>
                    </p>
                    <!-- end row -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <footer class="footer footer-alt">
        </footer>
        <!-- end container -->
    </div>
    <!-- end page -->
    <!-- App js -->
    <script src="//shepay.ayunx.com/admin/js/app.min.js"></script>
</body>

</html>