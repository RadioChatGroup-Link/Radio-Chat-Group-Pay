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
$title='收银台页面配置';
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
<div class="card-header"><h3 class="panel-title">收银台页面配置</h3></div>
<div class="card-body">
  <form action="./shepay_sytset.php?mod=site_n" method="post" class="form-horizontal" role="form">
  <div class="form-group">
	  <label class="col-sm-4 control-label">收银台名称:</label>
	  <div class="col-sm-auto"><input type="text" name="syt_name" value="<?php echo $conf['syt_name']?>" class="form-control" required/><small>* 对外格式:(     )-收银台。</small></div>
  <div class="form-group">
	  <label class="col-sm-4 control-label">收银台维护模式:</label>
	  <div class="col-sm-auto"><select class="form-control" name="pay_is" default="<?php echo $conf['pay_is']?>"><option value="0">关闭（收银台正常支付收款）</option><option value="1">开启（开启后，对接支付模块将弹出维护提示，也就是收银台无法支付收款）</option></select></div>
	</div>
	<div class="form-group">
<label class="col-sm-4 control-label">收银台维护提示信息:</label>
<div class="col-sm-auto">
<textarea name="pay_offtext" rows="5" class="form-control"><?php echo $conf['pay_offtext']; ?></textarea>
<small>* 所填提示内容将会在开启维护模式的情况下显示在相应页面，如果上方按钮为关闭，此提示将不会显示！</small>
</div><br/>
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