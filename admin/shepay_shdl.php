<?php
$mod='blank';
include("../shepay/common.php");
if(!isset($_SESSION['authcode'])) {
	$query=file_get_contents('http://auth.ooeecc.cn/api/check.php?url='.$_SERVER['HTTP_HOST'].'&authcode='.$authcode);
	if($query=json_decode($query,true)) {
	if($query['code']==1)$_SESSION['authcode']=true;
	sysmsg($query['msg'],true);
	}
}
$title='商户登陆配置';
include './shepay_head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./shepay_login.php';</script>");
?>

<?php 
if(isset($_POST['submit'])) {
    foreach ($_POST as $x => $value) {
        if($x=='pwd')continue;
        $value=daddslashes($value);
        $DB->query("insert into admin set `x`='{$x}',`j`='{$value}' on duplicate key update `j`='{$value}'");
    }
    $pwd=daddslashes($_POST['pwd']);
    if(!empty($pwd))$DB->query("update `admin` set `j` ='{$pwd}' where `x`='admin_pwd'");
    showmsg('修改成功！',1);
    exit();
}
?>

<div class="card card-primary">	
			<div class="card-header"><h3 class="panel-title">商户登录配置</h3></div>
			<div class="card-body">
  <form action="./shepay_shdl.php?mod=site_n" method="post" class="form-horizontal" role="form">
					<div class="form-group">
	  <label class="col-sm-4 control-label">商户登录维护模式:</label>
	  <div class="col-sm-auto"><select class="form-control" name="login_is" default="<?php echo $conf['login_is']?>"><option value="0">关闭（允许商户登录）</option><option value="1">开启（禁止商户登录）</option></select></div>
	</div>
	<div class="form-group">
<label class="col-sm-4 control-label">维护提示信息:</label>
<div class="col-sm-auto">
<textarea name="login_offtext" rows="5" class="form-control"><?php echo $conf['login_offtext']; ?></textarea>
<small>* 所填提示内容将会在开启商户登录维护模式的情况下显示在商户登录页面，如果上方按钮为关闭，此提示将不会显示！</small>
</div><br/>
					<div class="form-group">
	  <label class="col-sm-4 control-label">快捷登录方式:</label>
	  <div class="col-sm-auto"><select class="form-control" name="quicklogin" default="<?php echo $conf['quicklogin']?>"><option value="0">全部开启</option><option value="1">支付宝快捷登录</option><option value="2">QQ快捷登录</option><option value="3">关闭快捷登录</option></select></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">支付宝应用APPID:</label>
	  <div class="col-sm-auto"><input type="text" name="alipay_appid" value="<?php echo $conf['alipay_appid']; ?>" class="form-control" required/></div>
	</div>
		<div class="form-group">
	  <div class="col-sm-auto"><input type="text" name="" value="QQ应用配置请修改shepay/QC.conf.php" class="form-control"  disabled></div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-auto"><input type="submit" name="submit" value="确定修改" class="btn btn-primary form-control"/>
	 </div>
	</div>
  </form>
</div>
</div>

<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}
</script>

    </div>
  </div>