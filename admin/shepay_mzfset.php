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
$title='码支付接口配置';
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
<div class="card-header"><h3 class="panel-title">码支付接口配置</h3></div>
<div class="card-body">
  <form action="./shepay_mzfset.php?mod=site_n" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-4 control-label">码支付商户ID:</label>
	  <div class="col-sm-auto"><input type="text" name="mzf_id" value="<?php echo $conf['mzf_id']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">码支付商户密钥:</label>
	  <div class="col-sm-auto"><input type="text" name="mzf_key" value="<?php echo $conf['mzf_key']; ?>" class="form-control" required/></div>
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