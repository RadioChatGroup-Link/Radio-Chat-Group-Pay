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
$title='申请商户配置';
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
<div class="card-header"><h3 class="panel-title">申请商户配置</h3></div>
<div class="card-body">
  <form action="./shepay_sqsh.php?mod=site_n" method="post" class="form-horizontal" role="form">
					<div class="form-group">
	  <label class="col-sm-4 control-label">是否开启自助申请商户:</label>
	  <div class="col-sm-auto"><select class="form-control" name="is_reg" default="<?php echo $conf['is_reg']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div>
	              <div class="form-group">
	  <label class="col-sm-4 control-label">是否开启推广返利功能:</label>
	  <div class="col-sm-auto"><select class="form-control" name="tgfl_is" default="<?php echo $conf['tgfl_is']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div>
	<div class="form-group">
<label class="col-sm-4 control-label">关闭自助申请商户提示信息:</label>
<div class="col-sm-auto">
<textarea name="reg_offtext" rows="5" class="form-control"><?php echo $conf['reg_offtext']; ?></textarea>
<small>* 所填提示内容将会在关闭自助申请商户的情况下显示在商户自助注册页面，如果上方按钮为开启，此提示将不会显示！</small>
</div><br/>
	  <div class="form-group">
	  <label class="col-sm-4 control-label">是否付费开启申请:</label>
	  <div class="col-sm-auto"><select class="form-control" name="is_payreg" default="<?php echo $conf['is_payreg']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">商户推广返利金额:</label>
	  <div class="col-sm-auto"><input type="text" name="tgye" value="<?php echo $conf['tgye']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">付费申请收款商户ID:</label>
	  <div class="col-sm-auto"><input type="text" name="reg_pid" value="<?php echo $conf['reg_pid']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">商户申请价格:</label>
	  <div class="col-sm-auto"><input type="text" name="reg_price" value="<?php echo $conf['reg_price']; ?>" class="form-control" required/></div>
	</div>
					<div class="form-group">
	  <label class="col-sm-4 control-label">验证方式:</label>
	  <div class="col-sm-auto"><select class="form-control" name="verifytype" default="<?php echo $conf['verifytype']?>"><option value="0">邮箱验证</option><option value="1">手机验证</option></select></div>
	</div>
					<div class="form-group">
	  <label class="col-sm-4 control-label">是否开启支付宝结算:</label>
	  <div class="col-sm-auto"><select class="form-control" name="stype_1" default="<?php echo $conf['stype_1']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div>
					<div class="form-group">
	  <label class="col-sm-4 control-label">是否开启微信结算:</label>
	  <div class="col-sm-auto"><select class="form-control" name="stype_2" default="<?php echo $conf['stype_2']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div>
					<div class="form-group">
	  <label class="col-sm-4 control-label">是否开启QQ钱包结算:</label>
	  <div class="col-sm-auto"><select class="form-control" name="stype_3" default="<?php echo $conf['stype_3']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div>
					<div class="form-group">
	  <label class="col-sm-4 control-label">是否开启银行卡结算:</label>
	  <div class="col-sm-auto"><select class="form-control" name="stype_4" default="<?php echo $conf['stype_4']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-auto"><input type="submit" name="submit" value="确定修改" class="btn btn-primary form-control"/>
	 </div>
	</div>
  </form>
</div>
</div>
</div>
<div class="card card-primary">
<div class="card-header"><h3 class="panel-title">都潮汇系统配套插件</h3></div>
					<div class="card-body"><?php

echo file_get_contents("https://shepay.me.ayunx.com/readme/sqsh-readme.txt");
?>

<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}
</script>

    </div>
  </div>