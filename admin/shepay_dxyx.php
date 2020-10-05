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
$title='短信邮箱配置';
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
    <div class="card-header"><h3 class="panel-title">短信邮箱配置</h3></div>
    <div class="card-body">
        <form action="./shepay_dxyx.php?mod=site_n" method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <label class="col-sm-4 control-label">SMTP地址:</label>
                <div class="col-sm-auto"><input type="text" name="mail_smtp" value="<?php echo $conf['mail_smtp']; ?>" class="form-control" required /></div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">SMTP端口:</label>
                <div class="col-sm-auto"><input type="text" name="mail_port" value="<?php echo $conf['mail_port']; ?>" class="form-control" required /></div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">邮箱账号:</label>
                <div class="col-sm-auto"><input type="text" name="mail_name" value="<?php echo $conf['mail_name']; ?>" class="form-control" required /></div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">邮箱密码（QQ邮箱为授权码）:</label>
                <div class="col-sm-auto"><input type="text" name="mail_pwd" value="<?php echo $conf['mail_pwd']; ?>" class="form-control" required /></div>
            </div><hr>
            <div class="form-group">
              <label class="col-sm-4 control-label">短信接口密钥:</label>
              <div class="col-sm-auto"><input type="text" name="sms_appkey" value="<?php echo $conf['sms_appkey']; ?>" class="form-control"/><small>* 开启短信验证服务需前往admin.978w.cn注册账号并充值余额，接口密钥在［我的接口］页面获取，非必须配置，还是推荐邮箱验证。</small></div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-auto"><input type="submit" name="submit" value="确定修改" class="btn btn-primary form-control" />
                </div>
            </div>
        </form>
    </div>
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