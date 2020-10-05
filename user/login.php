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
$is_defend=true;
include("../shepay/common.php");
if(isset($_POST['user']) && isset($_POST['pass'])){
    $user=daddslashes($_POST['user']);
    $pass=daddslashes($_POST['pass']);
    $userrow=$DB->query("SELECT * FROM pay_user WHERE id='{$user}' limit 1")->fetch();
    if($user==$userrow['id'] && $pass==$userrow['key']) {
        if($user_id=$_SESSION['Oauth_alipay_uid']){
            $DB->exec("update `pay_user` set `alipay_uid` ='$user_id' where `id`='$user'");
            unset($_SESSION['Oauth_alipay_uid']);
        }
        if($qq_openid=$_SESSION['Oauth_qq_uid']){
            $DB->exec("update `pay_user` set `qq_uid` ='$qq_openid' where `id`='$user'");
            unset($_SESSION['Oauth_qq_uid']);
        }
        $DB->query("insert into `panel_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$user."','登录用户中心','".$date."','".$city."','".$clientip."')");
        $session=md5($user.$pass.$password_hash);
        $expiretime=time()+86400;
        $token=authcode("{$user}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
        setcookie("user_token", $token, time() + 86400);
        @header('Content-Type: text/html; charset=UTF-8');
        exit("<script language='javascript'>alert('登录用户中心成功！');window.location.href='./';</script>");
    }else {
        @header('Content-Type: text/html; charset=UTF-8');
        exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
    }
}elseif(isset($_GET['logout'])){
    setcookie("user_token", "", time() - 86400);
    @header('Content-Type: text/html; charset=UTF-8');
    exit("<script language='javascript'>alert('您已成功注销本次登录！');window.location.href='./login.php';</script>");
}elseif($islogin2==1){
    exit("<script language='javascript'>alert('您已登录！');window.location.href='./';</script>");
}
if($conf['web_is']==1)sysmsg($conf['web_offtext']);
if($conf['web_is']==2)sysmsg($conf['web_offtext']);
if($conf['login_is']==1)sysmsg($conf['login_offtext']);
?>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="<?php echo $conf['web_name']?>,都潮汇系统" name="description"/>
    <meta name="author" content="auth.ooeecc.cn" />
    <title>登录 | <?php echo $conf['web_name']?></title>
    <link href="//shepay.ayunx.com/user/css/app.min.css" rel="stylesheet" type="text/css">
</head>
<body class="authentication-bg">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <span><font color="white" size="5"><b><?php echo $conf['web_name']?></b></font></span>
                        </div>
                        <div class="card-body">
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">欢迎客官回家~</h4>
                            </div>
                            <form class="form" method="post" action="login.php">
                                <div class="form-group mb-3">
                                    <label>您的商户ID</label>
                                    <input class="form-control" type="text" name="user" value="" placeholder="ID" required>
                                </div>
                                <div class="form-group mb-3">
                                    <a href="findpwd.php" class="text-muted float-right"><small>忘记账户?</small></a>
                                    <label>您的商户KEY</label>
                                    <input class="form-control" type="password" name="pass" value="" placeholder="KEY" required>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked required>
                                        <label class="custom-control-label" for="checkbox-signin"><a href="agreement.php">同意商户服务协议</a></label>
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary" type="submit">立即登录</button>
                                    <br /><br />
                                    <p class="link <?php echo isset($_GET['connect'])||$conf['quicklogin']!=0?'hide':null;?>">其他方式登陆：<a href="oauth.php">支付宝</a> <a href="connect.php">QQ</a>
                                    </p>
                                    <p class="link <?php echo isset($_GET['connect'])||$conf['quicklogin']!=1?'hide':null;?>">其他方式登陆：<a href="oauth.php">支付宝</a>
                                    </p>
                                    <p class="link <?php echo isset($_GET['connect'])||$conf['quicklogin']!=2?'hide':null;?>">其他方式登陆：<a href="connect.php">QQ</a>
                                    </p>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted"> 没有商户？<a href="reg.php" class="text-dark ml-1"><b>马上申请</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
    <footer class="footer footer-alt" style="text-transform: uppercase;">
        Copyright &copy; 2016-<?=date('Y')?> <?php echo $conf['web_name']?> - <?php echo $_SERVER['SERVER_NAME']?>
    </footer>
    <!-- App js -->
    <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="//shepay.ayunx.com/admin/js/app.min.js"></script>
    <script src="//shepay.ayunx.com/assets/layer/layer.js"></script>
	<script>
  layer.open({
  type: 1
  ,area: ['350px', '200px']
  ,title: '<?php echo $conf['web_name']?>登录公告'
  ,shade: 0.5 //遮罩透明度
  ,maxmin: true //允许全屏最小化
  ,anim: 3 //0-6的动画形式，-1不开启
  ,content: '<div style="padding:50px;"><?php echo $conf['dlgg']?></div>'
});
</script>
</body>
</html>